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


Route::get('/', [App\Http\Controllers\CalendarController::class, 'index'])->name('index');
Route::post('store', [App\Http\Controllers\CalendarController::class, 'store'])->name('store');
Route::get('connect-to-google', [App\Http\Controllers\CalendarController::class, 'connectToGoogle'])->name('connect_to_google');
Route::get('revoke-oauth-token', [App\Http\Controllers\CalendarController::class, 'revokeOauthToken'])->name('revoke-oauth-token');

