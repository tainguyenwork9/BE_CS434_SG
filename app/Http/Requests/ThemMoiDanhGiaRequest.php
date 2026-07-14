<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemMoiDanhGiaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->vai_tro === 'KhachHang';
    }

    public function rules(): array
    {
        return [
            'diem_so' => 'required|integer|min:1|max:5',
            'noi_dung' => 'required|string|max:1000',
            'ma_don_thue' => 'required|exists:don_thue,ma_don_thue',
        ];
    }
}
