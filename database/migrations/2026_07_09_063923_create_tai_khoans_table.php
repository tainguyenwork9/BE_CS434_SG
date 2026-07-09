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
        Schema::create('tai_khoan', function (Blueprint $table) {
            $table->integer('ma_tai_khoan')->autoIncrement();
            $table->string('ten_dang_nhap', 50)->unique();
            $table->string('mat_khau', 255);
            $table->enum('vai_tro', ['KhachHang', 'QuanTriVien']);
            $table->enum('trang_thai', ['HoatDong', 'Khoa'])->default('HoatDong');
            $table->timestamp('ngay_tao')->useCurrent();

            $table->primary('ma_tai_khoan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tai_khoan');
    }
};
