<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class XuLyNhanXeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->vai_tro === 'QuanTriVien';
    }

    public function rules(): array
    {
        return [
            'ngay_nhan_thuc_te' => 'required|date',
            'tinh_trang_xe_khi_nhan' => 'required|string|max:1000',
            'chi_phi_phat_sinh' => 'required|numeric|min:0',
            'ly_do_phat_sinh' => 'nullable|string|max:1000',
            'ma_don_thue' => 'required|exists:don_thue,ma_don_thue|unique:nhan_xe,ma_don_thue',
        ];
    }
}
