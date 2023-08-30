<?php

declare(strict_types=1);

namespace Tests\Unit\Cache;

use App\Cache;
use PHPUnit\Framework\TestCase;

class SetTest extends TestCase
{
    private string $testKey = 'test_key';
    private string $cacheDirectory = __DIR__ . '/';
    private string $fileName = '';

    protected function setUp(): void
    {
        $this->fileName = $this->cacheDirectory . md5($this->testKey) . '.cache';
    }

    protected function tearDown(): void
    {
        if (file_exists($this->fileName)) {
            unlink($this->fileName);
        }
    }

    public function test_it_sets_in_cache_the_provided_data(): void
    {
        $cache = new Cache($this->cacheDirectory);
        $cache->set($this->testKey, 'test_value', 300);

        $cacheContent = json_decode(file_get_contents($this->fileName), true);

        $this->assertArrayHasKey('value', $cacheContent);
        $this->assertArrayHasKey('expiration', $cacheContent);
    }
}
