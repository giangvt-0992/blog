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

Route::get('/', 'HomeController@index')->name('index');

Route::get('/users/register', 'Auth\RegisterController@showRegistrationForm')->name('register');;
Route::post('/users/register', 'Auth\RegisterController@register');
Route::get('/users/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/users/login', 'Auth\LoginController@login');
Route::get('/users/logout', 'Auth\LogoutController@logout')->name('logout');

Route::group(['as' => 'post.', 'prefix' => 'post'], function (){
    Route::group(['middleware' => 'auth'], function(){
        Route::get('/', 'PostController@index')->name('index');
        Route::get('/create', 'PostController@create')->name('create');
        Route::post('/create', 'PostController@store');
        Route::get('/{id?}/edit','PostController@edit')->name('edit');
        Route::post('/{id?}/edit','PostController@update');
        Route::post('/{id?}/delete','PostController@destroy')->name('delete');
        Route::post('/{id?}/publish','PostController@publish')->name('publish');
    });
    // Route::get('/', 'PostController@index')->name('index')->middleware('auth');
    // Route::get('/create', 'PostController@create')->name('create')->middleware('auth');
    // Route::post('/create', 'PostController@store')->middleware('auth');
    Route::get('/{id?}', 'PostController@show')->name('show');
    // Route::get('/{id?}/edit','PostController@edit')->name('edit');
    // Route::post('/{id?}/edit','PostController@update');
    // Route::post('/{id?}/delete','PostController@destroy')->name('delete');
});

Route::post('/comment','CommentController@newComment');
Route::get('/comment/{id?}/delete','CommentController@destroy')->name('comment.delete');

Route::get('/test/{post1}', function (App\Post $post1){
    $comments = $post1->comments()->where('status', 1)->get();
    return view('post.show', ['post' => $post1, 'comments' => $comments]);
});

Route::get('profile/{user1}', function (App\User $user) {
    return $user;
});
Route::get('profiles/{user2}', function (App\User $user) {
    return $user;
});
