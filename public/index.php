<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$localLicenseHost = getenv('JAGOSKILL_LOCAL_LICENSE_HOST');
$requestHost = $_SERVER['HTTP_HOST'] ?? '';
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$requestPath = parse_url($requestUri, PHP_URL_PATH) ?: '/';

if ($localLicenseHost && preg_match('/^(localhost|127\.0\.0\.1)(:\d+)?$/', $requestHost)) {
    $_SERVER['HTTP_X_ORIGINAL_HOST'] = $requestHost;
    $_SERVER['SERVER_NAME'] = $localLicenseHost;
}

$localPageCacheEnabled = filter_var(getenv('JAGOSKILL_LOCAL_PAGE_CACHE'), FILTER_VALIDATE_BOOLEAN) || !empty($localLicenseHost);
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$hasAuthCookie = false;
foreach (array_keys($_COOKIE) as $cookieName) {
    if (strpos($cookieName, 'remember_web') === 0 || $cookieName === 'is_logged_in') {
        $hasAuthCookie = true;
        break;
    }
}
$publicCachePaths = [
    '/',
    '/classes',
    '/forums',
    '/instructors',
    '/organizations',
    '/courses',
    '/products',
    '/store',
];
$isLocalPublicCacheRequest = $localPageCacheEnabled
    && in_array($requestMethod, ['GET', 'HEAD'], true)
    && !$hasAuthCookie
    && in_array($requestPath, $publicCachePaths, true)
    && empty($_SERVER['HTTP_X_REQUESTED_WITH'])
    && empty($_GET['nocache']);
$localPageCacheFile = __DIR__ . '/../storage/framework/cache/local-pages/' . sha1($requestUri) . '.html';

if ($isLocalPublicCacheRequest && is_file($localPageCacheFile) && filesize($localPageCacheFile) > 0) {
    header('X-Jagoskill-Local-Cache: HIT');
    header('Content-Type: text/html; charset=UTF-8');
    if ($requestMethod !== 'HEAD') {
        readfile($localPageCacheFile);
    }
    exit;
}
if (is_file(__DIR__ . '/../storage/framework/cache/cache-bootstrap.php')) {
    require_once __DIR__ . '/../storage/framework/cache/cache-bootstrap.php';
}

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$request = Request::capture();
$response = $kernel->handle($request);

if ($isLocalPublicCacheRequest && $requestMethod === 'GET' && $response->getStatusCode() === 200 && strlen($response->getContent()) > 0) {
    @is_dir(dirname($localPageCacheFile)) || @mkdir(dirname($localPageCacheFile), 0775, true);
    @file_put_contents($localPageCacheFile, $response->getContent(), LOCK_EX);
}

$response->send();

$kernel->terminate($request, $response);

