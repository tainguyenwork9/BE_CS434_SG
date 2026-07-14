<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DangKyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ten_dang_nhap' => 'required|string|max:50|unique:tai_khoan,ten_dang_nhap',
            'mat_khau' => 'required|string|min:6',
            'ho_ten' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:khach_hang,email',
            'cccd' => 'required|string|max:12',
            'dia_chi' => 'required|string|max:255',
        ];
    }
}
