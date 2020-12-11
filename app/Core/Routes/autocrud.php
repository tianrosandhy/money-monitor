<?php
//will be used in every Auto CRUD routes
Route::group([
	'prefix' => $bs_url
], function() use($bs_controller, $bs_route){
	Route::get('/', $bs_controller.'@index')->name('admin.'.$bs_route.'.index');
	Route::get('create', $bs_controller.'@create')->name('admin.'.$bs_route.'.create');
	Route::get('edit/{id}', $bs_controller.'@edit')->name('admin.'.$bs_route.'.edit');
	Route::post('create', $bs_controller.'@store')->name('admin.'.$bs_route.'.store');
	Route::post('edit/{id}', $bs_controller.'@update')->name('admin.'.$bs_route.'.update');
	Route::post('switch/{id}', $bs_controller.'@switch')->name('admin.'.$bs_route.'.switch');
	Route::post('delete/{id?}', $bs_controller.'@delete')->name('admin.'.$bs_route.'.delete');

	// ajax route
	Route::match(['get', 'post'], 'datatable/post', $bs_controller.'@dataTable')->name('admin.'.$bs_route.'.datatable');
});
