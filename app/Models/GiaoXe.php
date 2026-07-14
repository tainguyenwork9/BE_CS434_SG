<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiaoXe extends Model
{
    protected $table = 'giao_xe';

    protected $primaryKey = 'ma_giao_xe';

    public $timestamps = false;

    protected $fillable = [
        'ngay_giao_thuc_te',
        'tinh_trang_xe_khi_giao',
        'hinh_anh_khi_giao',
        'ma_don_thue',
        'ma_quan_tri_vien',
    ];

    protected $casts = [
        'ngay_giao_thuc_te' => 'datetime',
    ];

    public function donThue()
    {
        return $this->belongsTo(DonThue::class, 'ma_don_thue');
    }

    public function quanTriVien()
    {
        return $this->belongsTo(QuanTriVien::class, 'ma_quan_tri_vien');
    }
}
