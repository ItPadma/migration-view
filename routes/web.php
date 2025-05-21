<?php

use App\Http\Controllers\MigrationController;
use Illuminate\Support\Facades\Route;

Route::controller(MigrationController::class)->group(function () {
    Route::get('/', 'index')->name('migration.index');
    Route::get('/migration/getdata', 'getData')->name('migration.getdata');
    Route::get('/migration/downloadData', 'downloadData')->name('migration.downloadData');
});
