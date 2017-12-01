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
//Home page
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
//Courses
Route::get('/courses', 'CourseController@index');
Route::post('/course', 'CourseController@search');
Route::get('/course', 'CourseController@search');
Route::put('/course/register/{course}', 'CourseController@register');
Route::delete('/course/drop/{course}', 'CourseController@drop');
//Friends
Route::get('/friends', 'FriendController@index');
Route::post('/friend', 'FriendController@search');
Route::get('/friend', 'FriendController@search');
Route::put('/friend/requestFriend/{friend}', 'FriendController@requestFriend');
Route::put('/friend/addFriend/{friend}', 'FriendController@acceptFriend');
Route::delete('/friend/unFriend/{friend}', 'FriendController@declineFriend');