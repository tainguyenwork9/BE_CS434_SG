<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemMoiDonThueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->vai_tro === 'KhachHang';
    }

    public function rules(): array
    {
        return [
            'ngay_nhan_du_kien' => 'required|date|after_or_equal:today',
            'ngay_tra_du_kien' => 'required|date|after:ngay_nhan_du_kien',
            'tien_coc' => 'required|numeric|min:0',
            'ma_xe' => 'required|exists:xe_may,ma_xe',
        ];
    }
}
