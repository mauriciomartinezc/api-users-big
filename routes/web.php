<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\Client\ClientIndexController::class, 'index'])->name('clients.index');
Route::get('/{client:id_api}', [\App\Http\Controllers\Client\ClientShowController::class, 'show'])->name('clients.show');
Route::get('/clients/sync', [\App\Http\Controllers\Client\ClientSyncController::class, 'syncPublic'])->name('clients.syncPublic');
