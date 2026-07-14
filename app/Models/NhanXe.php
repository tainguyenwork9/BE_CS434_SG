<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhanXe extends Model
{
    protected $table = 'nhan_xe';

    protected $primaryKey = 'ma_nhan_xe';

    public $timestamps = false;

    protected $fillable = [
        'ngay_nhan_thuc_te',
        'tinh_trang_xe_khi_nhan',
        'chi_phi_phat_sinh',
        'ly_do_phat_sinh',
        'ma_don_thue',
        'ma_quan_tri_vien',
    ];

    protected $casts = [
        'ngay_nhan_thuc_te' => 'datetime',
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
