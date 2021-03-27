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


// Route::middleware(['auth:admin', Banned::class])->prefix('dashboard')->as('dashboard.')->group(function () {
Route::middleware(['auth:admin'])->prefix('dashboard')->as('dashboard.')->group(function () {

    Route::get('/', 'DashboardController@index')->name('home');

    Route::resource('admins', 'AdminsController')->middleware('role:admin|manager');
    Route::get('admins/{admin}/banned', 'AdminsController@banned')->name('admins.banned');
    Route::get('admins/{admin}/unbanned', 'AdminsController@unbanned')->name('admins.unbanned');

    Route::resource('users', 'UsersController');
    Route::get('users/{id}/approve', 'UsersController@approve')->name('users.approve');

    Route::resource('floors', 'FloorsController');

    Route::resource('rooms', 'RoomsController');

    Route::resource('receptionists', 'ReceptionistsController');
    Route::get('receptionists/{id}/ban', 'ReceptionistsController@ban');

});

// Route::view('/ban', 'ban')->name('ban')->middleware();

