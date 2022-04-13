<?php

namespace Kaliel\Comarquage;


use DateTime;
use Kirby\Exception\InvalidArgumentException;
use Kirby\Http\Remote;

class Updater
{

    const CACHE_PATH = 'kaliel.kirby-comarquage';


    public function download(): void
    {
        $timestamp = $this->getRemoteLastModified();
        debug($this->getLocalLastModified());
        dd($timestamp);
    }

    public function update(): bool
    {
        if (!$this->needUpdate()) {
            return false;
        }
    }

    public function pull(): void
    {

    }

    /**
     * Request last modified datetime of comarquage zip file
     * @return int|null
     */
    public function getRemoteLastModified(): int|null
    {
        $url = option('comarquage.zipUrl');
        $options = [
            'method' => 'HEAD'
        ];
        $response = new Remote($url, $options);
        if ($response->code() === 200) {
            $headers = $response->headers();
            if (isset($headers['Last-Modified']) && !empty($headers['Last-Modified'])) {
                try {
                    $dt = new DateTime($headers['Last-Modified']);
                    return $dt->getTimestamp();
                } catch (\Exception $e) {
                    return null;
                }

            } else {
                return null;
            }
        } else {
            return null;
        }

    }

    /**
     * Get local data timestamp from cache
     * @return int|null
     */
    public function getLocalLastModified(): int|null
    {
        try {
            $cache = kirby()->cache(self::CACHE_PATH);
            $timestamp = $cache->get('last-modified');
            return $timestamp;
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    public function needUpdate(): bool
    {
        if ($this->getRemoteLastModified() > $this->getLocalLastModified()) {
            return true;
        }
        return false;
    }

}
