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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/auth/redirect', [App\Http\Controllers\Auth\LoginController::class, 'redirect'])->name('auth.login');

Route::get('/auth/callback', [App\Http\Controllers\Auth\LoginController::class, 'callback'])->name('auth.callback');

Route::get('/auth/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('auth.logout');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'view'])->middleware('auth:sanctum');
