<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Service\admin\DataControl\dataApproveController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('/data-approve', dataApproveController::class);
Route::post('/data-approve/selesai/{dataApprove}', [dataApproveController::class, 'selesai'])->name('data-approve.selesai');