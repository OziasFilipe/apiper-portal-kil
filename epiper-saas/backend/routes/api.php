<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ServerController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\IntegrationController;
use App\Http\Controllers\Api\SynchronizationController;
use App\Http\Controllers\Api\ServiceController;

Route::prefix('auth')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/user', [LoginController::class, 'user'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('companies', CompanyController::class);
    Route::apiResource('servers', ServerController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('permissions', PermissionController::class);
    Route::apiResource('users', UserController::class);
    Route::get('/settings', [SettingController::class, 'index']);
    Route::put('/settings', [SettingController::class, 'update']);
    Route::apiResource('integrations', IntegrationController::class);
    Route::apiResource('synchronizations', SynchronizationController::class);
    Route::post('/synchronizations/{id}/run', [SynchronizationController::class, 'run']);
    Route::apiResource('services', ServiceController::class);
});
