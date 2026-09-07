<?php

// Force log & basic environment
putenv('LOG_CHANNEL=stderr');
putenv('CACHE_DRIVER=file');
putenv('CACHE_STORE=file');
putenv('SESSION_DRIVER=file');

// Force direktori cache internal Laravel ke /tmp
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');
putenv('APP_SERVICES_CACHE=/tmp/services.php');
putenv('APP_CONFIG_CACHE=/tmp/config.php');
putenv('APP_ROUTES_CACHE=/tmp/routes.php');
putenv('APP_EVENTS_CACHE=/tmp/events.php');

// Siapkan folder storage sementara di /tmp
$storagePaths = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($storagePaths as $path) {
    if (!is_dir($path)) {
        @mkdir($path, 0777, true);
    }
}

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Gunakan /tmp sebagai root storage runtime
$app->useStoragePath('/tmp/storage');

// Inject default cache & session sebelum service provider dijalankan
$app->booting(function () use ($app) {
    $app['config']->set('cache.default', 'file');
    $app['config']->set('cache.stores.file', [
        'driver' => 'file',
        'path' => '/tmp/storage/framework/cache/data',
    ]);

    $app['config']->set('session.driver', 'file');
    $app['config']->set('session.files', '/tmp/storage/framework/sessions');
    $app['config']->set('session.lifetime', 120);

    $app['config']->set('view.compiled', '/tmp/storage/framework/views');
});

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);