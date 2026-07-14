<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThanhToan extends Model
{
    protected $table = 'thanh_toan';

    protected $primaryKey = 'ma_thanh_toan';

    public $timestamps = false;

    protected $fillable = [
        'ma_don_thue',
        'so_tien',
        'phuong_thuc',
        'trang_thai',
        'ngay_thanh_toan',
    ];

    protected $casts = [
        'ngay_thanh_toan' => 'datetime',
    ];

    public function donThue()
    {
        return $this->belongsTo(DonThue::class, 'ma_don_thue');
    }
}
