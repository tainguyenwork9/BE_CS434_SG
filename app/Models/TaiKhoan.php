<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaiKhoan extends Model
{
    protected $table = 'tai_khoan';

    protected $primaryKey = 'ma_tai_khoan';

    public $timestamps = false;

    protected $fillable = [
        'ten_dang_nhap',
        'mat_khau',
        'vai_tro',
        'trang_thai',
        'ngay_tao',
    ];

    public function khachHang()
    {
        return $this->hasOne(KhachHang::class, 'ma_tai_khoan');
    }

    public function quanTriVien()
    {
        return $this->hasOne(QuanTriVien::class, 'ma_tai_khoan');
    }
}
