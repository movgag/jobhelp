<?php



Route::get('/home','AdminController@dashboard')->name('home');

Route::get('/regions','AdminController@getRegions');
Route::get('/skills','AdminController@getSkills');
Route::get('/categories','AdminController@getCategories');
Route::get('/types','AdminController@getTypes');
Route::get('/languages','AdminController@getLanguages');

