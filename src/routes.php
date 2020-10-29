<?php

use Illuminate\Support\Facades\Route;

$preffix = config('media-manager.route_preffix', 'vendor/media/manager');

Route::group([
    'namespace'  => 'MasterDmx\LaravelMediaManager\Controllers',
], function () use ($preffix) {
    Route::get($preffix . '/init', 'ManagerController@init')->name('media-manager.init');
    Route::get($preffix . '/files', 'ManagerController@files')->name('media-manager.files');
    Route::post($preffix . '/files/upload', 'ManagerController@upload')->name('media-manager.upload');
    Route::delete($preffix . '/files/{id}', 'ManagerController@remove')->name('media-manager.remove');
});
