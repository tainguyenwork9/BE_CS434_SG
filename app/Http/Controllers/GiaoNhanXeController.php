<?php

namespace App\Http\Controllers;

use App\Http\Requests\XuLyGiaoXeRequest;
use App\Http\Requests\XuLyNhanXeRequest;
use App\Models\GiaoXe;
use App\Models\NhanXe;
use App\Models\DonThue;
use App\Models\XeMay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GiaoNhanXeController extends Controller
{
    public function giaoXe(XuLyGiaoXeRequest $request)
    {
        $admin = auth()->user()->quanTriVien;
        if (!$admin) {
            return response()->json(['message' => 'Bạn không có quyền quản trị viên'], 403);
        }

        $donThue = DonThue::find($request->ma_don_thue);

        if (in_array($donThue->trang_thai_don, ['DangThue', 'DaHoanThanh', 'DaHuy'])) {
            return response()->json([
                'message' => 'Đơn thuê này đã được giao xe hoặc đã kết thúc/hủy',
            ], 400);
        }

        return DB::transaction(function () use ($request, $donThue, $admin) {
            // Tạo bản ghi giao xe
            $giaoXe = GiaoXe::create([
                'ngay_giao_thuc_te' => $request->ngay_giao_thuc_te,
                'tinh_trang_xe_khi_giao' => $request->tinh_trang_xe_khi_giao,
                'hinh_anh_khi_giao' => $request->hinh_anh_khi_giao,
                'ma_don_thue' => $donThue->ma_don_thue,
                'ma_quan_tri_vien' => $admin->ma_quan_tri_vien,
            ]);

            // Cập nhật trạng thái đơn thuê thành DangThue
            $donThue->update(['trang_thai_don' => 'DangThue']);

            // Cập nhật trạng thái xe máy thành DangChoThue
            $xeMay = XeMay::find($donThue->ma_xe);
            if ($xeMay) {
                $xeMay->update(['tinh_trang_xe' => 'DangChoThue']);
            }

            return response()->json([
                'message' => 'Xử lý bàn giao xe thành công',
                'data' => $giaoXe->load('donThue'),
            ], 201);
        });
    }

    public function nhanXe(XuLyNhanXeRequest $request)
    {
        $admin = auth()->user()->quanTriVien;
        if (!$admin) {
            return response()->json(['message' => 'Bạn không có quyền quản trị viên'], 403);
        }

        $donThue = DonThue::find($request->ma_don_thue);

        if ($donThue->trang_thai_don !== 'DangThue') {
            return response()->json([
                'message' => 'Đơn thuê phải đang ở trạng thái DangThue mới có thể nhận lại xe',
            ], 400);
        }

        return DB::transaction(function () use ($request, $donThue, $admin) {
            // Tạo bản ghi nhận xe
            $nhanXe = NhanXe::create([
                'ngay_nhan_thuc_te' => $request->ngay_nhan_thuc_te,
                'tinh_trang_xe_khi_nhan' => $request->tinh_trang_xe_khi_nhan,
                'chi_phi_phat_sinh' => $request->chi_phi_phat_sinh,
                'ly_do_phat_sinh' => $request->ly_do_phat_sinh,
                'ma_don_thue' => $donThue->ma_don_thue,
                'ma_quan_tri_vien' => $admin->ma_quan_tri_vien,
            ]);

            // Cập nhật trạng thái đơn thuê thành DaHoanThanh
            $donThue->update(['trang_thai_don' => 'DaHoanThanh']);

            // Cập nhật trạng thái xe máy thành SanSang
            $xeMay = XeMay::find($donThue->ma_xe);
            if ($xeMay) {
                $xeMay->update(['tinh_trang_xe' => 'SanSang']);
            }

            return response()->json([
                'message' => 'Xử lý nhận lại xe thành công',
                'data' => $nhanXe->load('donThue'),
            ], 201);
        });
    }
}
