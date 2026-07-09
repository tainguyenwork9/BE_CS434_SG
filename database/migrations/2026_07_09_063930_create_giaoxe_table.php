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
        Schema::create('giao_xe', function (Blueprint $table) {
            $table->integer('ma_giao_xe')->autoIncrement();
            $table->dateTime('ngay_giao_thuc_te');
            $table->text('tinh_trang_xe_khi_giao')->nullable();
            $table->string('hinh_anh_khi_giao', 255)->nullable();
            $table->integer('ma_don_thue')->unique();
            $table->integer('ma_quan_tri_vien');

            $table->primary('ma_giao_xe');

            $table->foreign('ma_don_thue')
                ->references('ma_don_thue')
                ->on('don_thue')
                ->onUpdate('cascade');

            $table->foreign('ma_quan_tri_vien')
                ->references('ma_quan_tri_vien')
                ->on('quan_tri_vien')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('giao_xe');
    }
};
