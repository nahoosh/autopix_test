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
    return view('welcome');
});

Auth::routes();

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/listArticles', 'HomeController@listArticles')->name('listArticles');
    Route::get('/editArticle/{id}', 'HomeController@editArticle')->name('editArticle');
    Route::get('/viewArticle/{id}', 'HomeController@viewArticle')->name('viewArticle');
    Route::post('/saveArticle/{id}', 'HomeController@saveArticle')->name('saveArticle');
    Route::get('/addNewArticleForm', 'HomeController@addNewArticleForm')->name('addNewArticleForm');
    Route::post('/addNewArticle', 'HomeController@addNewArticle')->name('addNewArticle');
    Route::post('/addComment/{id}', 'HomeController@addComment')->name('addComment');
    Route::get('/searchArticles', 'HomeController@searchArticles')->name('searchArticles');
    Route::post('/searchResult', 'HomeController@searchResult')->name('searchResult');
});
