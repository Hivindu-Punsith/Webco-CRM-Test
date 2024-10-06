<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

use App\Http\Controllers\ProjectController;

Route::prefix('crm')->group(function () {
    Route::resource('customer', CustomerController::class);
    Route::resource('project', ProjectController::class);
});
