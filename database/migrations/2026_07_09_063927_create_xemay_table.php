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
        Schema::create('xe_may', function (Blueprint $table) {
            $table->integer('ma_xe')->autoIncrement();
            $table->string('bien_so_xe', 15)->unique();
            $table->string('ten_xe', 100);
            $table->string('mau_sac', 50)->nullable();
            $table->decimal('gia_thue_ngay', 10, 2);
            $table->enum('tinh_trang_xe', ['SanSang', 'DangChoThue', 'BaoTri'])->default('SanSang');
            $table->string('hinh_anh', 255)->nullable();
            $table->integer('ma_danh_muc');

            $table->primary('ma_xe');

            $table->foreign('ma_danh_muc')
                ->references('ma_danh_muc')
                ->on('danh_muc_xe')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('xe_may');
    }
};
