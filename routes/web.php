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

Auth::routes(['register' => false]);

Route::group(['middleware' => ['auth']], function() {

    Route::get('/', function () {
        return view('main');
    });

    Route::post('change-password', 'ChangePasswordController')->name('password.change');

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

        Route::delete('users/{user}', 'Admin\UserController@destroy')->name('admin.users.delete');
        Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('logs');
    });

    Route::group([
        'middleware'    => 'can:admin'
    ], function() {
        Route::get('add-user', 'UserController@create')->name('user.create');

        Route::post('store-user', 'UserController@store')->name('user.store');

        Route::get('update-user/{user}', 'UserController@update')->name('user.update');
    });


    Route::group([
        'prefix'    => 'project'
    ], function() {
        Route::get('add-project', 'ProjectController@addProject')->name('project.add');

        Route::post('store-project', 'ProjectController@store')->name('project.store');

        Route::get('links/{project}', 'LinksController@showLinks')->name('project.links');
        Route::get('user-links/{project}/{user}', 'LinksController@userLinks')->name('project.user-links');

        Route::get('/{project}','ProjectController@view')->name('project.view');
        Route::get('/{project}/append', 'ProjectController@append')->name('user.append');
        Route::post('/{project}/append', 'ProjectController@saveUser')->name('user.save-project');
        Route::delete('/{id}', 'ProjectController@delete')->name('project.delete');

        Route::post('/detach-user/{project_id}/{user_id}', 'ProjectController@detachUser')->name('project.detach-user');

        Route::get('/import/{project_id}/{user_id}', 'ProjectController@import')->name('project.link-import');
        Route::get('export/{project_id}/{user_id}', 'ProjectController@linkExport')->name('project.link-export');

        Route::post('link-store/{project_id}/{user_id}', 'ProjectController@linkStore')->name('project.link-store');

        Route::post('links-delete', 'ProjectController@linksDelete');
    });
});

