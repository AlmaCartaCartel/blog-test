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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/post/{slug}', 'HomeController@show')->name('post.show');
Route::get('/tag/{slug}', 'HomeController@tag')->name('tag.show');
Route::get('/category/{slug}', 'HomeController@category')->name('category.show');

Route::post('/subscribe', 'SubsController@subscribe');
Route::get('/confirm/{token}', 'SubsController@confirm');

Route::group(['middleware' => 'auth'], function (){
    Route::get('/logout','AuthController@logout')->name('logout');
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');
    Route::post('/comment', 'CommentController@add');
});

Route::group(['middleware' => 'guest'], function (){
    Route::get('/register', 'AuthController@registerForm');
    Route::post('/register', 'AuthController@register');
    Route::get('/verifications/{token}', 'AuthController@verifications');
    Route::get('/login', 'AuthController@loginForm')->name('login');
    Route::post('/login', 'AuthController@login');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('/', 'DashboardController@index')->name('admin.dashboard');
    Route::resource('/categories', 'CategoriesController');
    Route::resource('/tags', 'TagsController');
    Route::resource('/users', 'UsersController');
    Route::resource('/posts', 'PostsController');
    Route::resource('/subscribes', 'SubscribesController');

    Route::get('/comments', 'CommentsController@index')-> name('comment.index');
    Route::get('/comments/toggle/{id}', 'CommentsController@toggle')->name('comment.toggle');
    Route::delete('/comments/destroy/{id}', 'CommentsController@destroy')->name('comment.destroy');
});
