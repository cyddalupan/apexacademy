<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return response()->json([
        'message' => 'Hello from Apex Academy!',
        'status' => 'running',
        'environment' => app()->environment(),
    ]);
});
