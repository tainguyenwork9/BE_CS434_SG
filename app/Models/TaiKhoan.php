<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class TaiKhoan extends Authenticatable
{
    use HasApiTokens;

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

    protected $hidden = [
        'mat_khau',
    ];

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->mat_khau;
    }

    public function khachHang()
    {
        return $this->hasOne(KhachHang::class, 'ma_tai_khoan');
    }

    public function quanTriVien()
    {
        return $this->hasOne(QuanTriVien::class, 'ma_tai_khoan');
    }
}

