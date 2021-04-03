<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/index', 'ScheduleController@index')->name('schedule.index');

Route::post('/create', 'ScheduleController@store')->name('schedule.store');

Route::delete('/delete/{id}', 'ScheduleController@destroy')->name('schedule.destroy');
