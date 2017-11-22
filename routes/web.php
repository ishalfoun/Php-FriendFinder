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


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/friends', 'FriendController@index');
Route::post('/friend', 'FriendController@send');
Route::delete('/friend/{friend}', 'FriendController@delete');

Route::get('/courses', 'CourseController@index');
Route::post('/course', 'CourseController@search');
Route::delete('/course/{course}', 'CourseController@drop');
