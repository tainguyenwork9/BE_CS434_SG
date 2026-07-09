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
        Schema::create('nhan_xe', function (Blueprint $table) {
            $table->integer('ma_nhan_xe')->autoIncrement();
            $table->dateTime('ngay_nhan_thuc_te');
            $table->text('tinh_trang_xe_khi_nhan')->nullable();
            $table->decimal('chi_phi_phat_sinh', 10, 2)->default(0);
            $table->text('ly_do_phat_sinh')->nullable();
            $table->integer('ma_don_thue')->unique();
            $table->integer('ma_quan_tri_vien');

            $table->primary('ma_nhan_xe');

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
        Schema::dropIfExists('nhan_xe');
    }
};
