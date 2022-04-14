<?php

namespace Kaliel\Comarquage\Normalizer;

interface NormalizerInterface
{
    public function normalize(array $xmlData): array;

}
