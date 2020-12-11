<?php
Route::get('/', 'CoreController@index')->name('admin.splash');
Route::get('my-profile', 'CoreController@myProfile')->name('admin.my-profile');
Route::post('my-profile', 'CoreController@storeMyProfile')->name('admin.my-profile.store');
Route::post('store-setting', 'CoreController@storeSetting')->name('admin.setting.store');

Route::get('language', 'CoreController@language')->name('admin.language.index');
Route::post('language', 'CoreController@addLanguage')->name('admin.language.create');
Route::get('language/set-as-default/{id}', 'CoreController@setAsDefaultLanguage')->name('admin.language.set-as-default');
Route::get('language/delete/{id}', 'CoreController@removeLanguage')->name('admin.language.delete');


Route::get('privilege', 'CoreController@privilege')->name('admin.privilege.index');
Route::get('privilege/create', 'CoreController@privilegeCreate')->name('admin.privilege.create');
Route::post('privilege/store', 'CoreController@privilegeStore')->name('admin.privilege.store');
Route::get('privilege/edit/{id}', 'CoreController@privilegeEdit')->name('admin.privilege.edit');
Route::post('privilege/update/{id}', 'CoreController@privilegeUpdate')->name('admin.privilege.update');
Route::post('privilege/delete/{id}', 'CoreController@privilegeDelete')->name('admin.privilege.delete');
Route::get('privilege/manage-privilege/{id}', 'CoreController@privilegeManage')->name('admin.privilege.manage');
Route::post('privilege/manage-privilege/{id}', 'CoreController@privilegeStoreManage')->name('admin.privilege.store-manage');


Route::match(['get', 'post'], 'datatable/user', 'CoreController@userManagementDataTable')->name('admin.user.datatable');
Route::get('user-management', 'CoreController@userManagement')->name('admin.user.index');
Route::get('user-management/create', 'CoreController@userManagementCreate')->name('admin.user.create');
Route::post('user-management/create', 'CoreController@userManagementStore')->name('admin.user.store');
Route::get('user-management/edit/{id}', 'CoreController@userManagementEdit')->name('admin.user.edit');
Route::post('user-management/edit/{id}', 'CoreController@userManagementUpdate')->name('admin.user.update');
Route::post('user-management/delete/{id?}', 'CoreController@userManagementDelete')->name('admin.user.delete');

Route::get('log', 'CoreController@log')->name('admin.log.index');
Route::get('log/export', 'CoreController@logExport')->name('admin.log.export');
Route::get('log-detail/{id}', 'CoreController@logDetail')->name('admin.log.detail');
Route::get('log/mark-as-reported', 'CoreController@logMarkAsReported')->name('admin.log.mark-as-reported');


Route::match(['get', 'post'], 'datatable/push-notif', 'CoreController@pushNotifManagementDataTable')->name('admin.push-notif.datatable');
Route::get('push-notif', 'CoreController@pushNotif')->name('admin.push-notif.index');
Route::post('push-notif', 'CoreController@storePushNotif')->name('admin.push-notif.register');
Route::get('push-notif/create', 'CoreController@pushNotifCreate')->name('admin.push-notif.create');
Route::post('push-notif/create', 'CoreController@pushNotifStore')->name('admin.push-notif.store');
Route::get('push-notif/edit/{id}', 'CoreController@pushNotifEdit')->name('admin.push-notif.edit');
Route::post('push-notif/edit/{id}', 'CoreController@pushNotifUpdate')->name('admin.push-notif.update');
Route::post('push-notif/delete/{id?}', 'CoreController@pushNotifDelete')->name('admin.push-notif.delete');


Route::match(['get', 'post'], 'logout', 'CoreController@logout')->name('admin.logout');
