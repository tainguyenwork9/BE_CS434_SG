<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuaDanhMucRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'ten_danh_muc' => 'required|string|max:100|unique:danh_muc_xe,ten_danh_muc,' . $id . ',ma_danh_muc',
            'mo_ta' => 'nullable|string|max:500',
        ];
    }
}
