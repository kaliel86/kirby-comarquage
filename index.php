<?php

use Kaliel\Comarquage\Parser;
use Kaliel\Comarquage\Updater;

@include_once __DIR__ . '/vendor/autoload.php';

Kirby::plugin('kaliel/kirby-comarquage', [
    'options' => [
        'cache' => true
    ],
    'blueprints' => [
        'pages/comarquage-home' => __DIR__ . '/blueprints/comarquage-home.yml'
    ],
    'fields' => [
        'comarquage' => []
    ],
    'routes' => [
        [
            'pattern' => 'yolo',
            'action' => function () {
                dd(__DIR__);
                $updater = new Updater();
                $parser = new Parser();
                $parser->parse();
            }
        ]
    ]
]);
