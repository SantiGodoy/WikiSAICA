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



Auth::routes();;

Route::group( ['middleware' => 'auth' ], function()
{
	Route::get('/', function () {
    $user = Auth::user();
    $departments = DB::table('departments')->get();
    $articles = DB::table('articles')->get();
    return view('index', compact('departments','articles','user'));
});
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('admin/ajuda', 'AdminController@ajuda');
    Route::resource('articles', 'ArticleController');
    Route::resource('departments', 'DepartmentController');
		Route::get('files/{filename}', 'ArticleController@getFile' )->name('download')->middleware('auth');

});

Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function()
{
    Route::resource('admin', 'AdminController');
    Route::resource('version', 'VersionController');

});

	Route::delete('/deleteFile/{filename}', 'ArticleController@deleteFile')->name('deleteFile');
//Route::get('/{filename}', 'ArticleController@getFile' )->name('download')->middleware('auth');
