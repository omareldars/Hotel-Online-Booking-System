<?php

use App\Http\Middleware\Banned;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('login', 'LoginController@viewLogin')->name('viewLogin');
    Route::post('login', 'LoginController@login')->name('login');
    Route::post('logout', 'LoginController@logout')->name('logout');
});


Route::middleware(['auth:admin', Banned::class])->prefix('dashboard')->as('dashboard.')->group(function () {
// Route::middleware(['auth:admin'])->prefix('dashboard')->as('dashboard.')->group(function () {

    Route::get('/', 'DashboardController@index')->name('home');

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('managers', 'ManagersController');
        Route::get('managers/{admin}/banned', 'ManagersController@banned')->name('managers.banned');
        Route::get('managers/{admin}/unbanned', 'ManagersController@unbanned')->name('managers.unbanned');
    });


    Route::middleware(['role:admin|manager'])->group(function () {
        Route::resource('receptionists', 'ReceptionistsController');
        Route::get('receptionists/{admin}/banned', 'ReceptionistsController@banned')->name('receptionists.banned');
        Route::get('receptionists/{admin}/unbanned', 'ReceptionistsController@unbanned')->name('receptionists.unbanned');
    });


    Route::resource('users', 'UsersController');
    Route::get('users/{id}/approve', 'UsersController@approve')->name('users.approve');

    Route::resource('floors', 'FloorsController');

    Route::resource('rooms', 'RoomsController');
});

Route::view('/ban', 'ban')->name('ban')->middleware('auth:admin');
