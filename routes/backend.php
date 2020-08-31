<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function(){
    Route::group(['prefix' => 'backend'], function () {
        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('/', 'HomeController@index')->name('home');

        Route::get('/roles', 'RolesController@index')->name('roles');
        Route::get('/roles/store', 'RolesController@store')->name('store_roles');
        Route::get('/roles/update/{id}', 'RolesController@update')->name('update_roles');
        Route::get('/roles/delete/{id}', 'RolesController@destroy')->name('delete_roles');
        Route::get('/roles/permissions/{id}', 'RolesController@permissions')->name('permissions_roles');
        Route::get('/roles/assign/permissions/{id}', 'RolesController@assignPermissions')->name('assign_permissions_roles');

        Route::get('/permissions', 'PermissionsController@index')->name('permissions');
        Route::get('/permissions/store', 'PermissionsController@store')->name('store_permissions');
        Route::get('/permissions/update/{id}', 'PermissionsController@update')->name('update_permissions');
        Route::get('/permissions/delete/{id}', 'PermissionsController@destroy')->name('delete_permissions');

        Route::get('/users', 'UserController@index')->name('users');
        Route::get('/users/create', 'UserController@create')->name('create_users');
        Route::post('/users/store', 'UserController@store')->name('store_users');
        Route::get('/users/edit/{id}', 'UserController@edit')->name('edit_users');
        Route::get('/users/profile', 'UserController@profile')->name('profile_users');
        Route::post('/users/update/{id}', 'UserController@update')->name('update_users');
        Route::get('/users/show/{id}', 'UserController@show')->name('show_users');
        Route::get('/users/delete/{id}', 'UserController@destroy')->name('destroy_users');
        
        Route::get('/pages', 'PageController@index')->name('pages');
        Route::get('/pages/create', 'PageController@create')->name('create_pages');
        Route::post('/pages/store', 'PageController@store')->name('store_pages');
        Route::get('/pages/edit/{id}', 'PageController@edit')->name('edit_pages');
        Route::post('/pages/update/{id}', 'PageController@update')->name('update_pages');
        Route::get('/pages/show/{id}', 'PageController@show')->name('show_pages');
        Route::get('/pages/delete/{id}', 'PageController@destroy')->name('destroy_pages');
        Route::post('/pages/upload', 'PageController@upload')->name('upload_pages');
        
        Route::get('/blogs', 'BlogController@index')->name('blogs');
        Route::get('/blogs/create', 'BlogController@create')->name('create_blogs');
        Route::post('/blogs/store', 'BlogController@store')->name('store_blogs');
        Route::get('/blogs/edit/{id}', 'BlogController@edit')->name('edit_blogs');
        Route::post('/blogs/update/{id}', 'BlogController@update')->name('update_blogs');
        Route::get('/blogs/show/{id}', 'BlogController@show')->name('show_blogs');
        Route::get('/blogs/delete/{id}', 'BlogController@destroy')->name('destroy_blogs');
        Route::post('/blogs/upload', 'BlogController@upload')->name('upload_blogs');

        Route::get('/mainsettings', 'MainSettingController@index')->name('mainsettings');
        Route::post('/mainsettings/save', 'MainSettingController@save')->name('save_mainsettings');
        
        Route::get('/contacts', 'ContactController@index')->name('contacts');

        Route::get('/langs', 'LanguagesController@index')->name('langs');
        Route::post('/langs/save', 'LanguagesController@save')->name('store_langs');
        Route::post('/langs/new', 'LanguagesController@addNew')->name('store_new_langs');
        
        Route::get('/export/{model}/{name}', 'ExportController@index')->name('exports');
    });
});
