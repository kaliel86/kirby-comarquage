<?php

use Kaliel\Comarquage\Updater;

@include_once __DIR__ . '/vendor/autoload.php';

Kirby::plugin('kaliel/kirby-comarquage', [
    'options' => [
        'cache' => true
    ],
    'fields' => [
        'comarquage' => []
    ],
    'routes' => [
        [
            'pattern' => 'yolo',
            'action' => function () {
                $updater = new Updater();
                $updater->download();
            }
        ]
    ]
]);
