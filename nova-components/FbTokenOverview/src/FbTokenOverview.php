<?php

namespace Lsp\FbTokenOverview;

use Facebook\Facebook;
use Illuminate\Support\Facades\File;
use Laravel\Nova\Card;

class FbTokenOverview extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = '1/3';

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'fb-token-overview';
    }

    public function overview()
    {
        $token = File::exists($p = storage_path('token.txt')) ? File::get($p) : '';
        $date = carbon(File::lastModified($p));

        return $this->withMeta([
            'token' => str_limit($token, 10),
            'date' => $date->toDateString(),
            'diff' => $date->diffForHumans(),
        ]);
    }
}
