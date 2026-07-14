<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CapNhatProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->vai_tro === 'KhachHang';
    }

    public function rules(): array
    {
        $khachHang = auth()->user()->khachHang;
        $maKhachHang = $khachHang ? $khachHang->ma_khach_hang : null;

        return [
            'ho_ten' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:khach_hang,email,' . ($maKhachHang ?? 'NULL') . ',ma_khach_hang',
            'cccd' => 'required|string|max:12',
            'dia_chi' => 'required|string|max:255',
        ];
    }
}
