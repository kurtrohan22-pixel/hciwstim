<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$defaultTempDir = '/tmp';
foreach (['TMPDIR', 'TEMP', 'TMP'] as $envVar) {
    if (! getenv($envVar)) {
        putenv($envVar.'='.$defaultTempDir);
        $_ENV[$envVar] = $defaultTempDir;
        $_SERVER[$envVar] = $defaultTempDir;
    }
}

if (! is_dir($defaultTempDir)) {
    @mkdir($defaultTempDir, 0777, true);
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
