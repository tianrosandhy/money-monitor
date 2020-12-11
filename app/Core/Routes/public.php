<?php
// guest only route
Route::get('login', 'CoreController@login')->name('admin.login');
Route::post('login', 'CoreController@storeLogin')->name('admin.login.process');
Route::get('register', 'CoreController@register')->name('admin.register');
Route::post('forgot-password', 'CoreController@forgotPassword')->name('admin.forgot-password');
Route::get('password-reset/{token}', 'CoreController@passwordReset')->name('admin.password-reset');
Route::post('password-reset/{token}', 'CoreController@passwordResetPost')->name('admin.password-reset-post');
