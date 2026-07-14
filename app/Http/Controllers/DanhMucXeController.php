<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThemMoiDanhMucRequest;
use App\Http\Requests\SuaDanhMucRequest;
use App\Models\DanhMucXe;
use Illuminate\Http\Request;

class DanhMucXeController extends Controller
{
    public function index()
    {
        return response()->json(DanhMucXe::all());
    }

    public function store(ThemMoiDanhMucRequest $request)
    {
        $danhMuc = DanhMucXe::create($request->validated());

        return response()->json([
            'message' => 'Thêm mới danh mục xe thành công',
            'data' => $danhMuc,
        ], 201);
    }

    public function show($id)
    {
        $danhMuc = DanhMucXe::find($id);

        if (!$danhMuc) {
            return response()->json(['message' => 'Không tìm thấy danh mục xe'], 404);
        }

        return response()->json($danhMuc);
    }

    public function update(SuaDanhMucRequest $request, $id)
    {
        $danhMuc = DanhMucXe::find($id);

        if (!$danhMuc) {
            return response()->json(['message' => 'Không tìm thấy danh mục xe'], 404);
        }

        $danhMuc->update($request->validated());

        return response()->json([
            'message' => 'Cập nhật danh mục xe thành công',
            'data' => $danhMuc,
        ]);
    }

    public function destroy($id)
    {
        $danhMuc = DanhMucXe::find($id);

        if (!$danhMuc) {
            return response()->json(['message' => 'Không tìm thấy danh mục xe'], 404);
        }

        if ($danhMuc->xeMays()->count() > 0) {
            return response()->json([
                'message' => 'Không thể xóa danh mục xe đã có xe máy thuộc danh mục này',
            ], 400);
        }

        $danhMuc->delete();

        return response()->json([
            'message' => 'Xóa danh mục xe thành công',
        ]);
    }
}
