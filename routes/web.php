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

Route::get('/', function () {
    // return view('welcome');
    return redirect('/home/home');
});

Route::view('/template', 'template');

Route::controller(\App\Http\Controllers\UserController::class)->prefix('/user')->group(function () {
    Route::get('/login', 'login')->middleware([\App\Http\Middleware\OnlyGuestMiddleware::class]);
    Route::post('/login', 'doLogin')->middleware([\App\Http\Middleware\OnlyGuestMiddleware::class]);
    Route::post('/logout', 'doLogout')->middleware([\App\Http\Middleware\OnlyMemberMiddleware::class]);
});

Route::controller(\App\Http\Controllers\HomeController::class)->prefix('/home')->group(function () {
    Route::get('/home', 'home');
});

Route::controller(\App\Http\Controllers\TodolistController::class)
    ->middleware([\App\Http\Middleware\OnlyMemberMiddleware::class])
    ->prefix('/todo')->group(function () {
        Route::get('/index', 'indexTodo');
        Route::post('/add', 'addTodo');
        Route::post('/remove/{id}', 'removeTodo');
    })
;