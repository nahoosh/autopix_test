<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/listArticles', 'APIController@listArticles')->name('listArticles');
Route::post('/viewArticle', 'APIController@viewArticle')->name('viewArticle');
Route::post('/viewArticleForUser', 'APIController@viewArticleForUser')->name('viewArticleForUser');
Route::middleware('auth:api')->post('/saveArticle', 'APIController@saveArticle')->name('saveArticle');
