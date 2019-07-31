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
    return view('default');
});

Route::group(['middleware' => 'ensure.authenticated'], function () {
    Route::get('/list-projects', 'ListProjectsController@listProjects');
    Route::get('/projects', 'ListProjectsController@index');
    Route::post('/projects', 'CreateProjectController@store');
    Route::put('/projects/{project}', 'UpdateProjectController@update');
    // roles
    Route::get('/roles', 'ListRolesController@index');
    Route::post('/roles', 'CreateRoleController@store');
});


