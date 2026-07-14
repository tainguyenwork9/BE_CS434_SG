<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThemMoiDanhGiaRequest;
use App\Models\DanhGia;
use App\Models\DonThue;
use Illuminate\Http\Request;

class DanhGiaController extends Controller
{
    public function index()
    {
        $danhGias = DanhGia::with(['khachHang', 'xeMay'])->orderBy('ngay_danh_gia', 'desc')->get();
        return response()->json($danhGias);
    }

    public function byXe($maXe)
    {
        $danhGias = DanhGia::with(['khachHang'])
            ->where('ma_xe', $maXe)
            ->orderBy('ngay_danh_gia', 'desc')
            ->get();
        return response()->json($danhGias);
    }
    public function store(ThemMoiDanhGiaRequest $request)
    {
        $khachHang = auth()->user()->khachHang;
        if (!$khachHang) {
            return response()->json(['message' => 'Bạn không phải là khách hàng'], 403);
        }

        $donThue = DonThue::find($request->ma_don_thue);

        // Kiểm tra quyền sở hữu đơn thuê
        if ($donThue->ma_khach_hang !== $khachHang->ma_khach_hang) {
            return response()->json(['message' => 'Bạn không sở hữu đơn thuê này'], 403);
        }

        // Kiểm tra trạng thái đơn thuê
        if ($donThue->trang_thai_don !== 'DaHoanThanh') {
            return response()->json(['message' => 'Bạn chỉ có thể đánh giá sau khi đã hoàn thành đơn thuê xe'], 400);
        }

        // Kiểm tra xem đã đánh giá đơn thuê này chưa
        $daDanhGia = DanhGia::where('ma_don_thue', $request->ma_don_thue)->exists();
        if ($daDanhGia) {
            return response()->json(['message' => 'Bạn đã gửi đánh giá cho đơn thuê này rồi'], 400);
        }

        $danhGia = DanhGia::create([
            'diem_so' => $request->diem_so,
            'noi_dung' => $request->noi_dung,
            'ngay_danh_gia' => now(),
            'ma_khach_hang' => $khachHang->ma_khach_hang,
            'ma_xe' => $donThue->ma_xe,
            'ma_don_thue' => $request->ma_don_thue,
        ]);

        return response()->json([
            'message' => 'Gửi đánh giá và phản hồi thành công',
            'data' => $danhGia,
        ], 201);
    }

    public function destroy($id)
    {
        $danhGia = DanhGia::find($id);

        if (!$danhGia) {
            return response()->json(['message' => 'Không tìm thấy đánh giá'], 404);
        }

        $danhGia->delete();

        return response()->json([
            'message' => 'Xóa đánh giá thành công',
        ]);
    }
}
