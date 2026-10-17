<?php

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$missing = [];
foreach (Illuminate\Support\Facades\Route::getRoutes() as $route) {
    $action = $route->getActionName();
    if (!str_contains($action, '@')) continue;
    [$class, $method] = explode('@', $action);
    if (!method_exists($class, $method)) $missing[] = [$route->uri(), $class, $method];
}
echo json_encode($missing, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).PHP_EOL;
exit(count($missing) ? 1 : 0);
