<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThemMoiDonThueRequest;
use App\Http\Requests\SuaDonThueRequest;
use App\Models\DonThue;
use App\Models\XeMay;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DonThueController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->vai_tro === 'QuanTriVien') {
            $donThues = DonThue::with(['khachHang', 'xeMay'])->get();
        } else {
            $khachHang = $user->khachHang;
            if (!$khachHang) {
                return response()->json([], 200);
            }
            $donThues = DonThue::with(['xeMay'])
                ->where('ma_khach_hang', $khachHang->ma_khach_hang)
                ->get();
        }

        return response()->json($donThues);
    }

    public function show($id)
    {
        $user = auth()->user();
        $donThue = DonThue::with(['khachHang', 'xeMay', 'giaoXe', 'nhanXe', 'thanhToans', 'danhGia'])->find($id);

        if (!$donThue) {
            return response()->json([
                'message' => 'Không tìm thấy đơn thuê',
            ], 404);
        }

        // Khách hàng chỉ được xem đơn thuê của chính mình
        if ($user->vai_tro === 'KhachHang' && $donThue->ma_khach_hang !== $user->khachHang?->ma_khach_hang) {
            return response()->json([
                'message' => 'Bạn không có quyền xem đơn thuê này',
            ], 403);
        }

        return response()->json($donThue);
    }

    public function store(ThemMoiDonThueRequest $request)
    {
        $khachHang = auth()->user()->khachHang;
        if (!$khachHang) {
            return response()->json([
                'message' => 'Tài khoản của bạn chưa có thông tin khách hàng',
            ], 400);
        }

        $xeMay = XeMay::find($request->ma_xe);
        if ($xeMay->tinh_trang_xe !== 'SanSang') {
            return response()->json([
                'message' => 'Xe máy hiện tại không sẵn sàng để thuê',
            ], 400);
        }

        // Tính tổng tiền thuê
        $ngayNhan = Carbon::parse($request->ngay_nhan_du_kien);
        $ngayTra = Carbon::parse($request->ngay_tra_du_kien);
        $soNgay = $ngayNhan->diffInDays($ngayTra);
        if ($soNgay <= 0) {
            $soNgay = 1;
        }

        $tongTienThue = $soNgay * $xeMay->gia_thue_ngay;

        $donThue = DonThue::create([
            'ngay_dat' => now(),
            'ngay_nhan_du_kien' => $request->ngay_nhan_du_kien,
            'ngay_tra_du_kien' => $request->ngay_tra_du_kien,
            'tien_coc' => $request->tien_coc,
            'tong_tien_thue' => $tongTienThue,
            'trang_thai_don' => 'ChoDuyet',
            'ma_khach_hang' => $khachHang->ma_khach_hang,
            'ma_xe' => $request->ma_xe,
        ]);

        return response()->json([
            'message' => 'Đặt thuê xe thành công, đang chờ duyệt',
            'data' => $donThue->load('xeMay'),
        ], 201);
    }

    public function update(SuaDonThueRequest $request, $id)
    {
        $donThue = DonThue::find($id);

        if (!$donThue) {
            return response()->json([
                'message' => 'Không tìm thấy đơn thuê',
            ], 404);
        }

        $xeMay = XeMay::find($request->ma_xe);

        // Tính lại tổng tiền thuê nếu đổi ngày hoặc đổi xe
        $ngayNhan = Carbon::parse($request->ngay_nhan_du_kien);
        $ngayTra = Carbon::parse($request->ngay_tra_du_kien);
        $soNgay = $ngayNhan->diffInDays($ngayTra);
        if ($soNgay <= 0) {
            $soNgay = 1;
        }

        $tongTienThue = $soNgay * $xeMay->gia_thue_ngay;

        // Cập nhật trạng thái xe máy nếu trạng thái đơn thuê thay đổi
        if ($request->trang_thai_don === 'DangThue' && $donThue->trang_thai_don !== 'DangThue') {
            $xeMay->update(['tinh_trang_xe' => 'DangChoThue']);
        } elseif (in_array($request->trang_thai_don, ['DaHoanThanh', 'DaHuy']) && in_array($donThue->trang_thai_don, ['DangThue', 'DaDuyet'])) {
            $xeMay->update(['tinh_trang_xe' => 'SanSang']);
        }

        $donThue->update(array_merge($request->validated(), [
            'tong_tien_thue' => $tongTienThue,
        ]));

        return response()->json([
            'message' => 'Cập nhật đơn thuê thành công',
            'data' => $donThue->load(['khachHang', 'xeMay']),
        ]);
    }

    public function cancel($id)
    {
        $user = auth()->user();
        $donThue = DonThue::find($id);

        if (!$donThue) {
            return response()->json([
                'message' => 'Không tìm thấy đơn thuê',
            ], 404);
        }

        if ($user->vai_tro === 'KhachHang') {
            if ($donThue->ma_khach_hang !== $user->khachHang?->ma_khach_hang) {
                return response()->json([
                    'message' => 'Bạn không có quyền hủy đơn thuê này',
                ], 403);
            }

            if ($donThue->trang_thai_don !== 'ChoDuyet') {
                return response()->json([
                    'message' => 'Bạn chỉ có thể hủy đơn thuê khi đang ở trạng thái chờ duyệt',
                ], 400);
            }
        } else {
            if (in_array($donThue->trang_thai_don, ['DaHoanThanh', 'DaHuy'])) {
                return response()->json([
                    'message' => 'Đơn thuê đã kết thúc, không thể hủy',
                ], 400);
            }
        }

        $donThue->update(['trang_thai_don' => 'DaHuy']);

        // Giải phóng trạng thái xe máy
        $xeMay = XeMay::find($donThue->ma_xe);
        if ($xeMay && $xeMay->tinh_trang_xe === 'DangChoThue') {
            $xeMay->update(['tinh_trang_xe' => 'SanSang']);
        }

        return response()->json([
            'message' => 'Hủy đơn thuê thành công',
            'data' => $donThue,
        ]);
    }
}
