<?php

use App\Http\Middleware\ApproveUser;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    // Artisan::call('key:generate');

    return 'Cleared...';
});


Route::middleware(['auth', ApproveUser::class])->group(function () {
    // لعرض محتوي الصفحة الرئيسية الخاصة بعرض جدول الغرف
    Route::get('/', 'App\Http\Controllers\HomeController@index')->name('/');

    // لعرض صفحة خاصة بها بيانات الغرفة وزرار للحجز
    Route::get('/{room}/reservation', 'App\Http\Controllers\HomeController@reservation')->name('reservation');

    //  عند الضغط علي زرار الحجز يتم تنفيذ عمليات الحجز
    Route::post('/{room}/paypal', 'App\Http\Controllers\PaymentController@paypal')->name('room.paypal');

    // في حاجه كانت عملية الحجز تمت بنجاح
    Route::get('/{room}/paypal/success', 'App\Http\Controllers\PaymentController@payDone')->name('paypal.success');

    // في حالة تم الغاء عملية الحجز
    Route::get('/paypal/cancel', 'App\Http\Controllers\PaymentController@payCancel')->name('paypal.cancel');

});

Route::view('/approve', 'waiting_approve')->name('approve')->middleware('auth:web');

Auth::routes();
