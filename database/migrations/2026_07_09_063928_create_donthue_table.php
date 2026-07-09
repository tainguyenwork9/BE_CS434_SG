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
        Schema::create('don_thue', function (Blueprint $table) {
            $table->integer('ma_don_thue')->autoIncrement();
            $table->timestamp('ngay_dat')->useCurrent();
            $table->dateTime('ngay_nhan_du_kien');
            $table->dateTime('ngay_tra_du_kien');
            $table->decimal('tien_coc', 10, 2)->default(0);
            $table->decimal('tong_tien_thue', 10, 2)->default(0);
            $table->enum('trang_thai_don', ['ChoDuyet', 'DaDuyet', 'DangThue', 'DaHoanThanh', 'DaHuy'])->default('ChoDuyet');
            $table->integer('ma_khach_hang');
            $table->integer('ma_xe');

            $table->primary('ma_don_thue');

            $table->foreign('ma_khach_hang')
                ->references('ma_khach_hang')
                ->on('khach_hang')
                ->onUpdate('cascade');

            $table->foreign('ma_xe')
                ->references('ma_xe')
                ->on('xe_may')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('don_thue');
    }
};
