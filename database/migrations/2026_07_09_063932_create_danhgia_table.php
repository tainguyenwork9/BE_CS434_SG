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
        Schema::create('danh_gia', function (Blueprint $table) {
            $table->integer('ma_danh_gia')->autoIncrement();
            $table->tinyInteger('diem_so')->unsigned();
            $table->text('noi_dung')->nullable();
            $table->timestamp('ngay_danh_gia')->useCurrent();
            $table->integer('ma_khach_hang');
            $table->integer('ma_xe');
            $table->integer('ma_don_thue')->unique();

            $table->primary('ma_danh_gia');

            $table->foreign('ma_khach_hang')
                ->references('ma_khach_hang')
                ->on('khach_hang')
                ->onUpdate('cascade');

            $table->foreign('ma_xe')
                ->references('ma_xe')
                ->on('xe_may')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('danh_gia');
    }
};
