<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::resource('/user', UserController::class)->only([
    'index',
    'show',
    'store',
    'update',
    'destroy'
]);

Route::get('/user/statistics', [UserController::class, 'statistics']);