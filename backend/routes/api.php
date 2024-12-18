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

Route::get('/statistics', [UserController::class, 'statistics']);

Route::get('/export-users-csv', [UserController::class, 'exportData']);
Route::get('/export-users-xlsx', [UserController::class, 'exportDataXlsx']);
Route::get('/export-users-pdf', [UserController::class, 'exportDataPdf']);