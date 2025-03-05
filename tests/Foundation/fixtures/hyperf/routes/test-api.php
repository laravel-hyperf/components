<?php

declare(strict_types=1);

use LaravelHyperf\Http\Request;
use LaravelHyperf\Http\Response;
use LaravelHyperf\Support\Facades\Route;

Route::get('/foo', function () {
    return 'foo';
});

Route::get('/server-params', function (Request $request, Response $response) {
    return $response->json(
        $request->getServerParams()
    );
});

Route::get('/stream', function (Request $request, Response $response) {
    return $response->stream(function () {
        return 'stream';
    });
});
