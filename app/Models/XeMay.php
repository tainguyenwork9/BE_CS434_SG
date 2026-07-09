<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class XeMay extends Model
{
    protected $table = 'xe_may';

    protected $primaryKey = 'ma_xe';

    public $timestamps = false;

    protected $fillable = [
        'bien_so_xe',
        'ten_xe',
        'mau_sac',
        'gia_thue_ngay',
        'tinh_trang_xe',
        'hinh_anh',
        'ma_danh_muc',
    ];

    public function danhMucXe()
    {
        return $this->belongsTo(DanhMucXe::class, 'ma_danh_muc');
    }

    public function donThues()
    {
        return $this->hasMany(DonThue::class, 'ma_xe');
    }

    public function danhGias()
    {
        return $this->hasMany(DanhGia::class, 'ma_xe');
    }
}
