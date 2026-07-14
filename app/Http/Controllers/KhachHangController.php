<?php

namespace App\Http\Controllers;

use App\Http\Requests\CapNhatProfileRequest;
use App\Http\Requests\SuaKhachHangRequest;
use App\Models\KhachHang;
use App\Models\TaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KhachHangController extends Controller
{
    public function profileUpdate(CapNhatProfileRequest $request)
    {
        $khachHang = auth()->user()->khachHang;

        if (!$khachHang) {
            return response()->json([
                'message' => 'Không tìm thấy thông tin khách hàng',
            ], 404);
        }

        $khachHang->update($request->validated());

        return response()->json([
            'message' => 'Cập nhật thông tin cá nhân thành công',
            'data' => $khachHang,
        ]);
    }

    public function index()
    {
        $khachHangs = KhachHang::with('taiKhoan')->get();
        return response()->json($khachHangs);
    }

    public function show($id)
    {
        $khachHang = KhachHang::with('taiKhoan')->find($id);

        if (!$khachHang) {
            return response()->json([
                'message' => 'Không tìm thấy khách hàng',
            ], 404);
        }

        return response()->json($khachHang);
    }

    public function update(SuaKhachHangRequest $request, $id)
    {
        $khachHang = KhachHang::find($id);

        if (!$khachHang) {
            return response()->json([
                'message' => 'Không tìm thấy khách hàng',
            ], 404);
        }

        $khachHang->update($request->validated());

        return response()->json([
            'message' => 'Cập nhật thông tin khách hàng thành công',
            'data' => $khachHang->load('taiKhoan'),
        ]);
    }

    public function toggleStatus($id)
    {
        $khachHang = KhachHang::find($id);

        if (!$khachHang || !$khachHang->ma_tai_khoan) {
            return response()->json([
                'message' => 'Không tìm thấy tài khoản khách hàng',
            ], 404);
        }

        $taiKhoan = TaiKhoan::find($khachHang->ma_tai_khoan);
        $newStatus = $taiKhoan->trang_thai === 'HoatDong' ? 'Khoa' : 'HoatDong';
        $taiKhoan->update(['trang_thai' => $newStatus]);

        return response()->json([
            'message' => $newStatus === 'Khoa' ? 'Đã khóa tài khoản khách hàng' : 'Đã mở khóa tài khoản khách hàng',
            'trang_thai' => $newStatus,
        ]);
    }
}
