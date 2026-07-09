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
        Schema::create('danh_muc_xe', function (Blueprint $table) {
            $table->integer('ma_danh_muc')->autoIncrement();
            $table->string('ten_danh_muc', 100);
            $table->text('mo_ta')->nullable();

            $table->primary('ma_danh_muc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danh_muc_xe');
    }
};
