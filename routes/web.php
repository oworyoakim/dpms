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


Route::get('/login','AccountController@login');
Route::post('/login','AccountController@processLogin');

Route::group(['middleware' => 'ensure.authenticated'], function () {
    Route::get('/', 'HomeController@index');
    Route::post('/logout', 'AccountController@logout');
    Route::get('/user-info', 'HomeController@userInfo');
    // projects
    Route::get('/list-projects', 'ListProjectsController@listProjects');
    Route::get('/projects', 'ListProjectsController@index');
    Route::post('/projects', 'CreateProjectController@store');
    Route::put('/projects/{project}', 'UpdateProjectController@update');
    Route::post('/projects/tasks', 'CreateTaskController@store');
    // users
    Route::get('/list-users', 'ListUsersController@listUsers');
    Route::get('/users', 'ListUsersController@index');
    Route::post('/users', 'CreateUserController@store');
    Route::put('/users/{user}', 'UpdateUserController@update');
    // roles
    Route::get('/roles', 'ListRolesController@index');
    Route::post('/roles', 'CreateRoleController@store');

    // settings
    Route::get('/settings', 'SettingsController@index');
    Route::post('/settings', 'SettingsController@update');
});


