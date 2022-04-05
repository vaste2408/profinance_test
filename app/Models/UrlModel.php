<?php

namespace App\Models;

use DateTime;
use Illuminate\Support\Facades\Storage;

class UrlModel
{
    protected string $url;
    protected ?string $short;
    protected string $storageFile = 'links.ini';

    public function __construct($url)
    {
        $this->url = $url;
        $this->short = null;
    }

    public function restoreShortUrl($short): string|null
    {
        $links = parse_ini_file(Storage::path($this->storageFile));
        foreach ($links as $url => $value) {
            if ($value === $short) {
                return $url;
            }
        }
        return null;
    }

    public function getShortCode()
    {
        return $this->short ?? $this->createShortCode();
    }

    private function createShortCode()
    {
        $this->short = $this->loadShortCode() ?? $this->saveShortCode();
        return $this->short;
    }

    private function loadShortCode()
    {
        $links = parse_ini_file(Storage::path($this->storageFile));
        return $links[$this->url] ?? null;
    }

    private function saveShortCode(): string
    {
        $short = (new DateTime('now'))->getTimestamp();
        Storage::append($this->storageFile, "$this->url = $short");
        return (string)$short;
    }
}
