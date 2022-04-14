<?php

namespace Kaliel\Comarquage;

use Kaliel\Comarquage\Normalizer\NormalizerInterface;
use Kaliel\Comarquage\Utility\Inflector;
use Kirby\Data\Xml;
use Kirby\Toolkit\Str;

class Parser
{

    public function parse(): void
    {
        $file = kirby()->root('index') . DS . 'comarquage' . DS . 'questionsReponses.xml';
        $xml = Xml::read($file);
        dd($xml);
        $type = $xml['dc:type'] ?? null;
        $type = Str::slug($type, ' ');
        $normalizer = $this->getNormalizer($type);
        $normalizer->normalize($xml);
    }

    public function getNormalizer(string $type): NormalizerInterface
    {
        $class = Inflector::classify($type) . 'Normalizer';
        $fqn = "\Kaliel\Comarquage\Normalizer\\" . $class;
        return new $fqn;
    }

}
