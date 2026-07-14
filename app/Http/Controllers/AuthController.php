<?php

namespace App\Http\Controllers;

use App\Http\Requests\DangKyRequest;
use App\Http\Requests\DangNhapRequest;
use App\Models\TaiKhoan;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(DangKyRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $taiKhoan = TaiKhoan::create([
                'ten_dang_nhap' => $request->ten_dang_nhap,
                'mat_khau' => Hash::make($request->mat_khau),
                'vai_tro' => 'KhachHang',
                'trang_thai' => 'HoatDong',
                'ngay_tao' => now(),
            ]);

            $khachHang = KhachHang::create([
                'ho_ten' => $request->ho_ten,
                'so_dien_thoai' => $request->so_dien_thoai,
                'email' => $request->email,
                'cccd' => $request->cccd,
                'dia_chi' => $request->dia_chi,
                'ma_tai_khoan' => $taiKhoan->ma_tai_khoan,
            ]);

            $token = $taiKhoan->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Đăng ký tài khoản thành công',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $taiKhoan->load('khachHang'),
            ], 201);
        });
    }

    public function login(DangNhapRequest $request)
    {
        $taiKhoan = TaiKhoan::where('ten_dang_nhap', $request->ten_dang_nhap)->first();

        if (!$taiKhoan || !Hash::check($request->mat_khau, $taiKhoan->mat_khau)) {
            return response()->json([
                'message' => 'Tên đăng nhập hoặc mật khẩu không chính xác',
            ], 401);
        }

        if ($taiKhoan->trang_thai === 'Khoa') {
            return response()->json([
                'message' => 'Tài khoản của bạn đã bị khóa',
            ], 403);
        }

        $token = $taiKhoan->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Đăng nhập thành công',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'vai_tro' => $taiKhoan->vai_tro,
            'user' => $taiKhoan->load($taiKhoan->vai_tro === 'KhachHang' ? 'khachHang' : 'quanTriVien'),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Đăng xuất thành công',
        ]);
    }

    public function profile(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'user' => $user->load($user->vai_tro === 'KhachHang' ? 'khachHang' : 'quanTriVien'),
        ]);
    }
}
