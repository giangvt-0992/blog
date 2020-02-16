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
Route::get('/users/register', 'Auth\RegisterController@showRegistrationForm')->name('register');;
Route::post('/users/register', 'Auth\RegisterController@register');
Route::get('/users/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/users/login', 'Auth\LoginController@login');
Route::get('/users/logout', 'Auth\LogoutController@logout')->name('logout');

Route::group(['namespace'=>'Web'], function(){
    Route::get('/', 'HomeController@index')->name('index');
    Route::group(['as' => 'post.', 'prefix' => 'post'], function (){
        Route::group(['middleware' => 'auth'], function(){
            Route::get('/', 'PostController@index')->name('index');
            Route::get('/create', 'PostController@create')->name('create');
            Route::post('/create', 'PostController@store');
            Route::get('/{id?}/edit','PostController@edit')->name('edit');
            Route::post('/{id?}/edit','PostController@update');
            Route::post('/{id?}/delete','PostController@destroy')->name('delete');
            Route::get('/{id?}/publish','PostController@publish')->name('publish');
        });
        Route::get('/{id?}', 'PostController@show')->name('show');
    });
    Route::group(['as' => 'ticket.', 'prefix' => 'ticket'], function (){
        Route::group(['middleware' => 'auth'], function(){
            Route::get('/', 'TicketController@index')->name('index');
            Route::get('/create', 'TicketController@create')->name('create');
            Route::post('/create', 'TicketController@store');
            Route::get('/{ticket_id?}/edit','TicketController@edit')->name('edit');
            Route::post('/{ticket_id?}/edit','TicketController@update');
            Route::post('/{ticket_id?}/delete','TicketController@destroy')->name('delete');
            Route::get('/{ticket_id?}/publish','TicketController@publish')->name('publish');
        });
        Route::get('/{ticket_id?}', 'TicketController@show')->name('show');
    });
    
    Route::get('/tags/{tag_name?}', 'TagController@show')->name('tag.show');

    Route::post('/comment','CommentController@create');
    Route::get('/comment/{id?}/delete','CommentController@destroy')->name('comment.delete');
    

    
});
