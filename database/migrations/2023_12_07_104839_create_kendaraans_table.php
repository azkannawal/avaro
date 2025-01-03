<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('nama_kendaraan');
            $table->string('jenis_kendaraan'); // kendaraan tambang atau kendaraan penumpang
            $table->string('plat_nomor');
            $table->double('jumlah_bbm');
            $table->double('konsumsi_bbm'); // konsumsi bbm per kilometer
            $table->double('full_tank'); // kapasitas full tank kendaraan
            $table->integer('status_kendaraan'); // status kendaraan (1. kendaraan hak milik atau 2. kendaraan sewa)
            $table->boolean('status_pakai'); // status (kendaraan sedang digunakan atau tidak)
            $table->string('service_terakhir'); // service terakhir kendaraan
            $table->string('service_berikutnya'); // service berikutnya kendaraan
            $table->string('penempatan'); // penempatan kendaraan (utama atau cabang)
            $table->string('tanggal_pakai'); // tanggal kendaraan digunakan
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};
