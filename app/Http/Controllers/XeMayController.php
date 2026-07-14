<?php

namespace App\Http\Controllers;

use App\Models\XeMay;
use App\Models\DanhMucXe;
use Illuminate\Http\Request;

class XeMayController extends Controller
{
    public function index(Request $request)
    {
        $query = XeMay::with('danhMucXe');

        if ($request->has('ten_xe')) {
            $query->where('ten_xe', 'like', '%' . $request->ten_xe . '%');
        }

        if ($request->has('ma_danh_muc')) {
            $query->where('ma_danh_muc', $request->ma_danh_muc);
        }

        if ($request->has('tinh_trang_xe')) {
            $query->where('tinh_trang_xe', $request->tinh_trang_xe);
        }

        if ($request->has('mau_sac')) {
            $query->where('mau_sac', 'like', '%' . $request->mau_sac . '%');
        }

        if ($request->has('gia_min')) {
            $query->where('gia_thue_ngay', '>=', $request->gia_min);
        }

        if ($request->has('gia_max')) {
            $query->where('gia_thue_ngay', '<=', $request->gia_max);
        }

        return response()->json($query->get());
    }

    public function show($id)
    {
        $xeMay = XeMay::with(['danhMucXe', 'danhGias.khachHang'])->find($id);

        if (!$xeMay) {
            return response()->json([
                'message' => 'Không tìm thấy xe máy',
            ], 404);
        }

        return response()->json($xeMay);
    }

    public function danhMuc()
    {
        return response()->json(DanhMucXe::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bien_so_xe' => 'required|string|max:20|unique:xe_may',
            'ten_xe' => 'required|string|max:100',
            'mau_sac' => 'required|string|max:50',
            'gia_thue_ngay' => 'required|numeric|min:0',
            'tinh_trang_xe' => 'required|in:SanSang,DangChoThue,BaoTri',
            'hinh_anh' => 'nullable|string',
            'ma_danh_muc' => 'required|exists:danh_muc_xe,ma_danh_muc'
        ]);

        $xeMay = XeMay::create($validated);
        
        return response()->json([
            'message' => 'Thêm xe máy thành công',
            'data' => $xeMay->load('danhMucXe')
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $xeMay = XeMay::find($id);

        if (!$xeMay) {
            return response()->json(['message' => 'Không tìm thấy xe máy'], 404);
        }

        $validated = $request->validate([
            'bien_so_xe' => 'sometimes|string|max:20|unique:xe_may,bien_so_xe,' . $id . ',ma_xe',
            'ten_xe' => 'sometimes|string|max:100',
            'mau_sac' => 'sometimes|string|max:50',
            'gia_thue_ngay' => 'sometimes|numeric|min:0',
            'tinh_trang_xe' => 'sometimes|in:SanSang,DangChoThue,BaoTri',
            'hinh_anh' => 'nullable|string',
            'ma_danh_muc' => 'sometimes|exists:danh_muc_xe,ma_danh_muc'
        ]);

        $xeMay->update($validated);

        return response()->json([
            'message' => 'Cập nhật xe máy thành công',
            'data' => $xeMay->load('danhMucXe')
        ]);
    }

    public function destroy($id)
    {
        $xeMay = XeMay::find($id);

        if (!$xeMay) {
            return response()->json(['message' => 'Không tìm thấy xe máy'], 404);
        }
        
        if ($xeMay->tinh_trang_xe === 'Đang cho thuê') {
            return response()->json(['message' => 'Không thể xoá xe đang cho thuê'], 400);
        }

        $xeMay->delete();

        return response()->json(['message' => 'Xoá xe máy thành công']);
    }
}
