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

Route::get('/', function () {
    return view('main');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::group([
    'prefix'    => 'admin',
    'middleware' => 'can:admin'
] , function() {
    Route::get('/', function() {
        return view('admin.index');
    })->name('admin.index');

    Route::get('users', 'Admin\UserController@index')->name('admin.users');
    Route::post('users/set-admin/{user}', 'Admin\UserController@setAdmin')->name('admin.users.set-admin');
    Route::post('users/cancel-admin/{user}', 'Admin\UserController@cancelAdmin')->name('admin.users.cancel-admin');
});
