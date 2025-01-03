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
        Schema::create('data_approves', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->char('id_pegawai');
            $table->char('id_driver');
            $table->char('id_kendaraan');
            $table->integer('tujuan_tambang');
            $table->boolean('approve_1')->default(false);
            $table->datetime('approve_1_at')->nullable();
            $table->boolean('approve_2')->default(false);
            $table->datetime('approve_2_at')->nullable();
            $table->integer('status')->default(1)->nullable(); // 1 = menunggu pool, 2 = menunggu kepala kantor, 3 = menunggu BBM, 4. approve, 5. reject
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_approves');
    }
};
