<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$public = realpath(__DIR__.'/../public');
$candidate = realpath($public.$path);
if ($path !== '/' && $candidate && str_starts_with($candidate, $public.DIRECTORY_SEPARATOR) && is_file($candidate)) return false;
$app = require __DIR__.'/preview-storefront.php';
$app->handleRequest(Illuminate\Http\Request::capture());
