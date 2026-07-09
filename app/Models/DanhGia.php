<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    protected $table = 'danh_gia';

    protected $primaryKey = 'ma_danh_gia';

    public $timestamps = false;

    protected $fillable = [
        'diem_so',
        'noi_dung',
        'ngay_danh_gia',
        'ma_khach_hang',
        'ma_xe',
        'ma_don_thue',
    ];

    protected $casts = [
        'ngay_danh_gia' => 'datetime',
    ];

    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'ma_khach_hang');
    }

    public function xeMay()
    {
        return $this->belongsTo(XeMay::class, 'ma_xe');
    }

    public function donThue()
    {
        return $this->belongsTo(DonThue::class, 'ma_don_thue');
    }
}
