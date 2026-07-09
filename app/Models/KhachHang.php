<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    protected $table = 'khach_hang';

    protected $primaryKey = 'ma_khach_hang';

    public $timestamps = false;

    protected $fillable = [
        'ho_ten',
        'so_dien_thoai',
        'email',
        'cccd',
        'dia_chi',
        'ma_tai_khoan',
    ];

    public function taiKhoan()
    {
        return $this->belongsTo(TaiKhoan::class, 'ma_tai_khoan');
    }

    public function donThues()
    {
        return $this->hasMany(DonThue::class, 'ma_khach_hang');
    }

    public function danhGias()
    {
        return $this->hasMany(DanhGia::class, 'ma_khach_hang');
    }
}
