<?php

namespace App\Http\Controllers;

use App\ApiDefinition;
use Illuminate\Support\Facades\Cache;

class ApiController extends Controller
{
    public function __invoke()
    {
        $endpoint = Cache::rememberForever('users', function () {
            return ApiDefinition::get();
        });

        return view('api', [
            'endpoints' => $endpoint,
            'xData' => $endpoint->map(fn () => false)->toJson(),
        ]);
    }
}
