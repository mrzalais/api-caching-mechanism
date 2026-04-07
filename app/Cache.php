<?php

declare(strict_types=1);

namespace App;

use App\Contracts\CacheInterface;

class Cache implements CacheInterface
{
    protected string $cacheDirectory;

    public function __construct(string $cacheDirectory)
    {
        $this->cacheDirectory = $cacheDirectory;
        if (!is_dir($this->cacheDirectory)) {
            mkdir(directory: $this->cacheDirectory, recursive: true);
        }
    }

    public function set(string $key, mixed $value, int $duration): void
    {
        $cacheFile = $this->getCacheFilePath($key);
        $data = [
            'value' => $value,
            'expiration' => time() + $duration
        ];
        file_put_contents($cacheFile, json_encode($data));
    }

    public function get(string $key): mixed
    {
        $cacheFileName = $this->getCacheFilePath($key);

        if (!file_exists($cacheFileName)) {
            return null;
        }

        $data = $this->getFileData($cacheFileName);
        if ($this->isCacheExpired($data['expiration'])) {
            unlink($cacheFileName);
            return null;
        }

        return $data['value'];
    }

    protected function getCacheFilePath(string $key): string
    {
        return $this->cacheDirectory . '/' . md5($key) . '.cache';
    }

    protected function getFileData(string $cacheFileName)
    {
        return json_decode(file_get_contents($cacheFileName), true);
    }

    protected function isCacheExpired(int $timestamp): bool
    {
        return $timestamp <= time();
    }
}
