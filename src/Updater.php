<?php

namespace Kaliel\Comarquage;


use DateTime;
use Kirby\Exception\InvalidArgumentException;
use Kirby\Filesystem\F;
use Kirby\Http\Remote;
use ZipArchive;

class Updater
{

    const CACHE_PATH = 'kaliel.kirby-comarquage';

    public function download(): bool
    {
        $url = option('comarquage.zipUrl');
        $response = Remote::get($url);

        if ($response->code() !== 200) {
            return false;
        }

        $dest = kirby()->root('index') . DS . 'comarquage';
        F::write($dest . DS . 'tmp.zip', $response->content());

        $zip = new ZipArchive;
        if ($zip->open($dest . DS . 'tmp.zip') === TRUE) {
            $zip->extractTo($dest);
            $zip->close();
            F::remove($dest . DS . 'tmp.zip');
            echo 'ok';
        } else {
            return false;
        }
        dd('done');
    }

    public function update(): bool
    {
        if (!$this->needUpdate()) {
            return false;
        }

        return $this->download();
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
