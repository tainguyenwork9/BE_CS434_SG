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
        Schema::create('thanh_toan', function (Blueprint $table) {
            $table->integer('ma_thanh_toan')->autoIncrement();
            $table->integer('ma_don_thue');
            $table->decimal('so_tien', 10, 2);
            $table->enum('phuong_thuc', ['TienMat', 'ChuyenKhoan', 'ViDienTu']);
            $table->enum('trang_thai', ['ChoThanhToan', 'DaThanhToan', 'HoanTien'])->default('ChoThanhToan');
            $table->dateTime('ngay_thanh_toan')->nullable();

            $table->primary('ma_thanh_toan');

            $table->foreign('ma_don_thue')
                ->references('ma_don_thue')
                ->on('don_thue')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thanh_toan');
    }
};
