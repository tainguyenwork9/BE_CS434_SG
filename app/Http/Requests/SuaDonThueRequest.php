<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuaDonThueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->vai_tro === 'QuanTriVien';
    }

    public function rules(): array
    {
        return [
            'ngay_nhan_du_kien' => 'required|date',
            'ngay_tra_du_kien' => 'required|date|after:ngay_nhan_du_kien',
            'tien_coc' => 'required|numeric|min:0',
            'trang_thai_don' => 'required|in:ChoDuyet,DaDuyet,DangThue,DaHoanThanh,DaHuy',
            'ma_xe' => 'required|exists:xe_may,ma_xe',
            'ma_khach_hang' => 'required|exists:khach_hang,ma_khach_hang',
        ];
    }
}
