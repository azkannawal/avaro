<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Service\service\DataControl\dataApproveController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('/service', dataApproveController::class);
Route::post('/service/isiBBM/{service}', [dataApproveController::class, 'isiBbm'])->name('service.isiBbm');
Route::post('/service/service/{service}', [dataApproveController::class, 'service'])->name('service.service');
