<?php

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

Auth::routes();

$domain = substr(env('APP_URL', 'localhost'), 7);
Route::domain($domain)->group(function () {
    Route::get('/', 'PageController@homepage')->name('homepage');
    Route::get('dashboard', function () {
        return redirect()->route('dashboard');
    });
});

Route::domain('app.' . $domain)->group(function () {
    Route::get('{any?}', 'PageController@dashboard')->where('any', '.*')->middleware('auth')->name('dashboard');
});


