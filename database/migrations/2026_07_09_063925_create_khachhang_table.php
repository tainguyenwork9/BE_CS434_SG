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
        Schema::create('khach_hang', function (Blueprint $table) {
            $table->integer('ma_khach_hang')->autoIncrement();
            $table->string('ho_ten', 100);
            $table->string('so_dien_thoai', 15)->unique();
            $table->string('email', 100)->unique();
            $table->char('cccd', 12)->unique();
            $table->string('dia_chi', 255)->nullable();
            $table->integer('ma_tai_khoan')->unique();

            $table->primary('ma_khach_hang');

            $table->foreign('ma_tai_khoan')
                ->references('ma_tai_khoan')
                ->on('tai_khoan')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khach_hang');
    }
};
