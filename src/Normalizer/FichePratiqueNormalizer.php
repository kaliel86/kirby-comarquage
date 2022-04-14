<?php

namespace Kaliel\Comarquage\Normalizer;

class FichePratiqueNormalizer implements NormalizerInterface
{

    public function __construct()
    {
        dd('yolo');
    }

    public function normalize(array $xmlData): array
    {
        return [
            'coucou', 'caca'
        ];
    }
}
