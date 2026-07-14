<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class XuLyGiaoXeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->vai_tro === 'QuanTriVien';
    }

    public function rules(): array
    {
        return [
            'ngay_giao_thuc_te' => 'required|date',
            'tinh_trang_xe_khi_giao' => 'required|string|max:1000',
            'hinh_anh_khi_giao' => 'nullable|string|max:255',
            'ma_don_thue' => 'required|exists:don_thue,ma_don_thue|unique:giao_xe,ma_don_thue',
        ];
    }
}
