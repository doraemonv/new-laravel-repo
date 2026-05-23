<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

Route::get('/{path?}', function ($path = null) {
    $base = public_path('yxr-home/en.ks-yxr.com');

    $path = $path ?: 'index.html';
    $path = urldecode($path);

    if (str_contains($path, '..')) {
        abort(404);
    }

    $file = $base . '/' . $path;

    if (is_dir($file)) {
        $file = rtrim($file, '/') . '/index.html';
    } elseif (!File::exists($file) && !pathinfo($file, PATHINFO_EXTENSION)) {
        $file = rtrim($file, '/') . '/index.html';
    }

    if (!File::exists($file)) {
        abort(404);
    }

    return response()->file($file);
})->where('path', '.*');
