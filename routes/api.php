<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::middleware(['auth:sanctum', 'role:Admin'])->group(function() {
    Route::get('/admin-dashboard', [AdminController::class, 'index']);
});