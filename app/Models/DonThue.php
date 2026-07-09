<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonThue extends Model
{
    protected $table = 'don_thue';

    protected $primaryKey = 'ma_don_thue';

    public $timestamps = false;

    protected $fillable = [
        'ngay_dat',
        'ngay_nhan_du_kien',
        'ngay_tra_du_kien',
        'tien_coc',
        'tong_tien_thue',
        'trang_thai_don',
        'ma_khach_hang',
        'ma_xe',
    ];

    protected $casts = [
        'ngay_dat' => 'datetime',
        'ngay_nhan_du_kien' => 'datetime',
        'ngay_tra_du_kien' => 'datetime',
    ];

    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'ma_khach_hang');
    }

    public function xeMay()
    {
        return $this->belongsTo(XeMay::class, 'ma_xe');
    }

    public function thanhToans()
    {
        return $this->hasMany(ThanhToan::class, 'ma_don_thue');
    }

    public function giaoXe()
    {
        return $this->hasOne(GiaoXe::class, 'ma_don_thue');
    }

    public function nhanXe()
    {
        return $this->hasOne(NhanXe::class, 'ma_don_thue');
    }

    public function danhGia()
    {
        return $this->hasOne(DanhGia::class, 'ma_don_thue');
    }
}
