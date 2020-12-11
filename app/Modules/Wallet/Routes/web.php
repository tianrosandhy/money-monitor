<?php
generateAdminRoute('wallet', 'WalletController');
Route::get('wallet-record', 'WalletRecordController@index')->name('admin.wallet-record.index');
Route::get('wallet-record/create/{id}', 'WalletRecordController@create')->name('admin.wallet-record.create');
Route::post('wallet-record/store/{id?}', 'WalletRecordController@store')->name('admin.wallet-record.store');
Route::get('get-wallet-balance', 'WalletRecordController@getBalance')->name('admin.wallet-record.get-balance');
Route::get('wallet-report', 'WalletRecordController@report')->name('admin.wallet-record.report');
Route::get('transaction', 'WalletRecordController@transaction')->name('admin.wallet-record.transaction');
Route::get('get-transaction-list', 'WalletRecordController@getTransactionList')->name('admin.wallet-record.get-transaction');
Route::post('remove-wallet-record', 'WalletRecordController@removeWalletRecord')->name('admin.wallet-record.remove');
