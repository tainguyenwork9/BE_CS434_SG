<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuanTriVien extends Model
{
    protected $table = 'quan_tri_vien';

    protected $primaryKey = 'ma_quan_tri_vien';

    public $timestamps = false;

    protected $fillable = [
        'ho_ten',
        'so_dien_thoai',
        'email',
        'ma_tai_khoan',
    ];

    public function taiKhoan()
    {
        return $this->belongsTo(TaiKhoan::class, 'ma_tai_khoan');
    }

    public function giaoXes()
    {
        return $this->hasMany(GiaoXe::class, 'ma_quan_tri_vien');
    }

    public function nhanXes()
    {
        return $this->hasMany(NhanXe::class, 'ma_quan_tri_vien');
    }
}
