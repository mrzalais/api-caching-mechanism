<?php

declare(strict_types=1);

namespace Tests\Unit\Cache;

use App\Cache;
use PHPUnit\Framework\TestCase;

class GetTest extends TestCase
{
    private string $testKey = 'test_key';
    private string $cacheDirectory = __DIR__ . '/';
    private string $fileName = '';

    protected function tearDown(): void
    {
        if (file_exists($this->fileName)) {
            unlink($this->fileName);
        }
    }

    public function test_it_returns_null_if_no_file_exists(): void
    {
        $cacheMock = $this->getMockBuilder(Cache::class)
            ->setConstructorArgs([$this->cacheDirectory])
            ->onlyMethods(['getCacheFilePath'])
            ->getMock();

        $cacheMock->method('getCacheFilePath')->willReturn('');

        $this->assertNull($cacheMock->get($this->testKey));
    }

    public function test_it_unlinks_the_cache_if_it_has_expired(): void
    {
        $this->fileName = $this->cacheDirectory . md5($this->testKey) . '.cache';

        file_put_contents($this->fileName, json_encode([
            'value' => 'test_value',
            'expiration' => time() - 500
        ]));

        $cache = new Cache($this->cacheDirectory);

        $this->assertFileExists($this->fileName);

        $emptyCache = $cache->get($this->testKey);

        $this->assertFileDoesNotExist($this->fileName);

        $this->assertNull($emptyCache);
    }

    public function test_it_returns_a_cached_value(): void
    {
        $this->fileName = $this->cacheDirectory . md5($this->testKey) . '.cache';

        file_put_contents($this->fileName, json_encode([
            'value' => 'test_value',
            'expiration' => time() + 300
        ]));

        $cache = new Cache($this->cacheDirectory);

        $cache = $cache->get($this->testKey);

        $this->assertEquals('test_value', $cache);
    }
}
