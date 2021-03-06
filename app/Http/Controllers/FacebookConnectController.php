<?php

namespace App\Http\Controllers;

use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class FacebookConnectController extends Controller
{
    public function login(Facebook $fb)
    {
        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email', 'user_events'];
        $loginUrl = $helper->getLoginUrl(route('fb.callback'), $permissions);

        return view('facebook_connect.login', [
            'loginUrl' => $loginUrl,
        ]);
    }

    public function callback(Request $request, Facebook $fb)
    {
        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: '.$e->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: '.$e->getMessage();
            exit;
        }

        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo 'Error: '.$helper->getError()."\n";
                echo 'Error Code: '.$helper->getErrorCode()."\n";
                echo 'Error Reason: '.$helper->getErrorReason()."\n";
                echo 'Error Description: '.$helper->getErrorDescription()."\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);

        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId(config('services.facebook.id'));

        // If you know the user ID this access token belongs to, you can validate it here
        //$tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();

        if (!$accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo '<p>Error getting long-lived access token: '.$e->getMessage()."</p>\n\n";
                exit;
            }
        }

        Cache::put('facebook-token', $accessToken->getValue());
        Log::debug('Long lived token for user #'.Auth::user()->id.': '.str_limit($accessToken->getValue(), 8));

        return ['token' => $accessToken->getValue()];
    }
}
