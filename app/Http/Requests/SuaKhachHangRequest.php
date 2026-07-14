<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuaKhachHangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'ho_ten' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:khach_hang,email,' . $id . ',ma_khach_hang',
            'cccd' => 'required|string|max:12',
            'dia_chi' => 'required|string|max:255',
        ];
    }
}
