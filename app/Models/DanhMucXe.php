<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhMucXe extends Model
{
    protected $table = 'danh_muc_xe';

    protected $primaryKey = 'ma_danh_muc';

    public $timestamps = false;

    protected $fillable = [
        'ten_danh_muc',
        'mo_ta',
    ];

    public function xeMays()
    {
        return $this->hasMany(XeMay::class, 'ma_danh_muc');
    }
}
