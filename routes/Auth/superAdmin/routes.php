<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Service\superadmin\{
    Account\AccountController,
    Pegawai\pegawaiController,
    Kendaraan\kendaraanController,
    Kendaraan\driverController,
    DataControl\dataApproveController,
    DataControl\approveAsPool,
    DataControl\approveAsKepalaKantor,
    DataControl\approveAsService,
};

/**
 * @route /dashboard
 * @authenticated
 * @role superAdmin
 * @url http://localhost:8000/superAdmin/dashboard
 * @example http://localhost:8000/superAdmin/dashboard
 */
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

/**
 * @route /accounts
 * @authenticated
 * @role superAdmin
 * @url http://localhost:8000/superAdmin/accounts
 * @example http://localhost:8000/superAdmin/accounts
 */
Route::resource('/accounts', AccountController::class);

/**
 * @route /pegawai
 * @authenticated
 * @role superAdmin
 * @url http://localhost:8000/superAdmin/pegawai
 * @example http://localhost:8000/superAdmin/pegawai
 */
Route::resource('/pegawai', pegawaiController::class);

/**
 * @route /kendaraan
 * @authenticated
 * @role superAdmin
 * @url http://localhost:8000/superAdmin/kendaraan
 * @example http://localhost:8000/superAdmin/kendaraan
 */
Route::resource('/kendaraan', kendaraanController::class);

/**
 * @route /driver
 * @authenticated
 * @role superAdmin
 * @url http://localhost:8000/superAdmin/driver
 * @example http://localhost:8000/superAdmin/driver
 */
Route::resource('/driver', driverController::class);

/**
 * @route /data-approve
 * @authenticated
 * @role superAdmin
 * @url http://localhost:8000/superAdmin/data-approve
 * @example http://localhost:8000/superAdmin/data-approve
 */
Route::resource('/data-approve', dataApproveController::class);
Route::get('/exports', [dataApproveController::class, 'export_excel'])->name('data-approve.export');

/**
 * @route /approveAsPool
 * @authenticated
 * @role superAdmin
 * @url http://localhost:8000/superAdmin/approveAsPool
 * @example http://localhost:8000/superAdmin/approveAsPool
 */
Route::resource('/approveAsPool', approveAsPool::class);
Route::post('/approveAsPool/approve/{approveAsPool}', [approveAsPool::class, 'approve'])->name('approveAsPool.approve');
Route::post('/approveAsPool/reject/{approveAsPool}', [approveAsPool::class, 'reject'])->name('approveAsPool.reject');
Route::post('/approveAsPool/isiBBM/{approveAsPool}', [approveAsPool::class, 'isiBbm'])->name('approveAsPool.isiBbm');
Route::post('/approveAsPool/gantiService/{approveAsPool}', [approveAsPool::class, 'gantiService'])->name('approveAsPool.gantiService');

/**
 * @route /approveAsKepala
 * @authenticated
 * @role superAdmin
 * @url http://localhost:8000/superAdmin/approveAsKepala
 * @example http://localhost:8000/superAdmin/approveAsKepala
 */
Route::resource('/approveAsKepala', approveAsKepalaKantor::class);
Route::post('/approveAsKepala/approve/{approveAsKepala}', [approveAsKepalaKantor::class, 'approve'])->name('approveAsKepala.approve');
Route::post('/approveAsKepala/reject/{approveAsKepala}', [approveAsKepalaKantor::class, 'reject'])->name('approveAsKepala.reject');

/**
 * @route /approveAsService
 * @authenticated
 * @role superAdmin
 * @url http://localhost:8000/superAdmin/approveAsService
 * @example http://localhost:8000/superAdmin/approveAsService
 */
Route::resource('/approveAsService', approveAsService::class);
Route::post('/approveAsService/isiBBM/{approveAsService}', [approveAsService::class, 'isiBbm'])->name('approveAsService.isiBbm');
Route::post('/approveAsService/service/{approveAsService}', [approveAsService::class, 'service'])->name('approveAsService.service');

// Route::resource('/kantor', kantorController::class);
// Route::resource('/tambang', tambangController::class);
