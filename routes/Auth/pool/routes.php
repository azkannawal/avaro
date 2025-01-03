<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Service\pool\DataControl\dataApproveController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('/data-approve', dataApproveController::class);
Route::post('/data-approve/approve/{data_approve}', [dataApproveController::class, 'approve'])->name('data-approve.approve');
Route::post('/data-approve/reject/{data_approve}', [dataApproveController::class, 'reject'])->name('data-approve.reject');
Route::post('/data-approve/isiBBM/{data_approve}', [dataApproveController::class, 'isiBbm'])->name('data-approve.isiBbm');
Route::post('/data-approve/gantiService/{data_approve}', [dataApproveController::class, 'gantiService'])->name('data-approve.gantiService');