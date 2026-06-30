<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

try {
    echo view('admin.store.products.create', [
        'pageTitle' => 'Test',
        'productCategories' => [],
        'locale' => 'en',
        'defaultLocale' => 'en'
    ])->render();
} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine();
}
