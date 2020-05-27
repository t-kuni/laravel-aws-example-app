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

Route::get('/', 'TopController@index');
Route::post('/', 'TopController@post');
Route::post('/upload-image', 'TopController@uploadImage');

Route::get('/chat', 'ChatController@index');
Route::get('/chat/list', 'ChatController@list');
Route::post('/chat/send', 'ChatController@send');

//Route::get('/subscription', 'SubscriptionController@index');
//Route::post('/subscription/buy', 'SubscriptionController@buy');

Route::get('/users', 'UserController@index');
Route::post('/users/create', 'UserController@create');
Route::get('/users/{user}', 'UserController@detail');
Route::post('/users/{user}/cards/create', 'SubscriptionController@card');
Route::post('/users/{user}/subscriptions/buy', 'SubscriptionController@buy');
Route::post('/users/{user}/subscriptions/buy-multi', 'SubscriptionController@buyMulti');
Route::post('/users/{user}/subscriptions/swap', 'SubscriptionController@swap');
Route::post('/users/{user}/subscriptions/cancel', 'SubscriptionController@cancel');
Route::post('/users/{user}/subscriptions/force-cancel', 'SubscriptionController@forceCancel');
