<?php

namespace Kaliel\Comarquage;

use Kirby\Http\Remote;

class Updater
{
    public function coucou(): string
    {
        return option('comarquage.uploadDir');
    }

    public function download(): void
    {
        $url = 'https://lecomarquage.service-public.fr/vdd/3.0/part/zip/vosdroits-latest.zip';
        $options = [
            'method' => 'HEAD'
        ];
        $response = new Remote($url, $options);
        dd($response);
    }

}
