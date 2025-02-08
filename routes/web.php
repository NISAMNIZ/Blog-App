<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::prefix('user')->group( function (){
    Route::get('/login','LoginController@login')->name('user.login');
    Route::get('/register','LoginController@register')->name('user.register');
    Route::post('/saveRegistration','LoginController@saveRegistration')->name('user.saveRegistration');
    Route::post('/Dashboardlogin','LoginController@Dashboardlogin')->name('user.Dashboardlogin');
    Route::get('/withoutLoginBlog','LoginController@withoutLoginBlog')->name('user.withoutLoginBlog');
    Route::get('/withoutLoginreadMore/{id}','LoginController@withoutLoginreadMore')->name('user.withoutLoginreadMore');
    Route::middleware('auth')->group(function(){
        Route::get('/home','LoginController@home')->name('user.home');
        Route::get('/blog','BlogController@blog')->name('user.blog');
        Route::post('/createBlog','BlogController@createBlog')->name('user.createBlog');
        Route::get('/blog/{id}','BlogController@EditBlog')->name('user.EditBlog');
        Route::post('/deleteBlog','BlogController@deleteBlog')->name('user.deleteBlog');
        Route::get('/logout','LoginController@logout')->name('user.logout');
        Route::post('/blog/toggle-like/', [BlogController::class, 'toggleLike'])->name('blog.toggle');
        Route::post('/search','BlogController@search')->name('user.search');
        Route::get('/readMore/{id}','BlogController@show')->name('user.readMore');
        Route::post('/comment','BlogController@comment')->name('user.comment');

    });
});
