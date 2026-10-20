<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test; 
use Tests\TestCase;

class ServerlessStorageConfigTest extends TestCase
{
    #[Test]
    public function it_uses_tmp_paths_for_session_and_cache_storage_when_configured(): void
    {
        putenv('SESSION_DRIVER=file');
        putenv('SESSION_FILES=/tmp/framework/sessions');
        putenv('CACHE_STORE=file');
        putenv('CACHE_PATH=/tmp/framework/cache/data');

        $this->assertSame('/tmp/framework/sessions', config('session.files'));
        $this->assertSame('/tmp/framework/cache/data', config('cache.stores.file.path'));
    }
}
