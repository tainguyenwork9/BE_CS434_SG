<?php

namespace Database\Seeders;

use App\Models\TaiKhoan;
use App\Models\KhachHang;
use App\Models\QuanTriVien;
use App\Models\DanhMucXe;
use App\Models\XeMay;
use App\Models\DonThue;
use App\Models\ThanhToan;
use App\Models\GiaoXe;
use App\Models\NhanXe;
use App\Models\DanhGia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks for clean seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing data
        TaiKhoan::truncate();
        KhachHang::truncate();
        QuanTriVien::truncate();
        DanhMucXe::truncate();
        XeMay::truncate();
        DonThue::truncate();
        ThanhToan::truncate();
        GiaoXe::truncate();
        NhanXe::truncate();
        DanhGia::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Seed TaiKhoan (Accounts)
        $tkAdmin1 = TaiKhoan::create([
            'ten_dang_nhap' => 'admin01',
            'mat_khau' => Hash::make('password123'),
            'vai_tro' => 'QuanTriVien',
            'trang_thai' => 'HoatDong',
        ]);

        $tkAdmin2 = TaiKhoan::create([
            'ten_dang_nhap' => 'admin02',
            'mat_khau' => Hash::make('password123'),
            'vai_tro' => 'QuanTriVien',
            'trang_thai' => 'HoatDong',
        ]);

        $tkKhach1 = TaiKhoan::create([
            'ten_dang_nhap' => 'nguyenvana',
            'mat_khau' => Hash::make('password123'),
            'vai_tro' => 'KhachHang',
            'trang_thai' => 'HoatDong',
        ]);

        $tkKhach2 = TaiKhoan::create([
            'ten_dang_nhap' => 'lethib',
            'mat_khau' => Hash::make('password123'),
            'vai_tro' => 'KhachHang',
            'trang_thai' => 'HoatDong',
        ]);

        $tkKhach3 = TaiKhoan::create([
            'ten_dang_nhap' => 'tranvanc',
            'mat_khau' => Hash::make('password123'),
            'vai_tro' => 'KhachHang',
            'trang_thai' => 'Khoa',
        ]);

        // 2. Seed QuanTriVien (Admins)
        $admin1 = QuanTriVien::create([
            'ho_ten' => 'Nguyễn Minh Tuấn',
            'so_dien_thoai' => '0912345678',
            'email' => 'tuan.nm@example.com',
            'ma_tai_khoan' => $tkAdmin1->ma_tai_khoan,
        ]);

        $admin2 = QuanTriVien::create([
            'ho_ten' => 'Trần Thị Thuỷ',
            'so_dien_thoai' => '0987654321',
            'email' => 'thuy.tt@example.com',
            'ma_tai_khoan' => $tkAdmin2->ma_tai_khoan,
        ]);

        // 3. Seed KhachHang (Customers)
        $khach1 = KhachHang::create([
            'ho_ten' => 'Nguyễn Văn Anh',
            'so_dien_thoai' => '0901112223',
            'email' => 'anh.nv@example.com',
            'cccd' => '012345678901',
            'dia_chi' => '123 Đường Láng, Đống Đa, Hà Nội',
            'ma_tai_khoan' => $tkKhach1->ma_tai_khoan,
        ]);

        $khach2 = KhachHang::create([
            'ho_ten' => 'Lê Thị Bình',
            'so_dien_thoai' => '0902223334',
            'email' => 'binh.lt@example.com',
            'cccd' => '023456789012',
            'dia_chi' => '456 Nguyễn Trãi, Thanh Xuân, Hà Nội',
            'ma_tai_khoan' => $tkKhach2->ma_tai_khoan,
        ]);

        $khach3 = KhachHang::create([
            'ho_ten' => 'Trần Văn Cường',
            'so_dien_thoai' => '0903334445',
            'email' => 'cuong.tv@example.com',
            'cccd' => '034567890123',
            'dia_chi' => '789 Điện Biên Phủ, Quận 3, TP.HCM',
            'ma_tai_khoan' => $tkKhach3->ma_tai_khoan,
        ]);

        // 4. Seed DanhMucXe (Categories)
        $dmXeGa = DanhMucXe::create([
            'ten_danh_muc' => 'Xe Ga',
            'mo_ta' => 'Các loại xe máy tay ga dễ lái, sang trọng như Vision, AirBlade, SH...',
        ]);

        $dmXeSo = DanhMucXe::create([
            'ten_danh_muc' => 'Xe Số',
            'mo_ta' => 'Các loại xe số tiết kiệm nhiên liệu, bền bỉ như Wave, Sirius...',
        ]);

        $dmXeCon = DanhMucXe::create([
            'ten_danh_muc' => 'Xe Côn Tay',
            'mo_ta' => 'Các loại xe côn tay thể thao, mạnh mẽ như Winner, Exciter...',
        ]);

        // 5. Seed XeMay (Motorbikes)
        $xe1 = XeMay::create([
            'bien_so_xe' => '29D1-12345',
            'ten_xe' => 'Honda Vision 2023',
            'mau_sac' => 'Trắng',
            'gia_thue_ngay' => 120000,
            'tinh_trang_xe' => 'SanSang',
            'hinh_anh' => 'https://images.unsplash.com/photo-1568772585407-9361f9bf3a87?auto=format&fit=crop&w=600&q=80',
            'ma_danh_muc' => $dmXeGa->ma_danh_muc,
        ]);

        $xe2 = XeMay::create([
            'bien_so_xe' => '29H1-56789',
            'ten_xe' => 'Honda AirBlade 150',
            'mau_sac' => 'Đen Nhám',
            'gia_thue_ngay' => 150000,
            'tinh_trang_xe' => 'DangChoThue',
            'hinh_anh' => 'https://images.unsplash.com/photo-1558981806-ec527fa84c39?auto=format&fit=crop&w=600&q=80',
            'ma_danh_muc' => $dmXeGa->ma_danh_muc,
        ]);

        $xe3 = XeMay::create([
            'bien_so_xe' => '30F1-99999',
            'ten_xe' => 'Yamaha Exciter 155',
            'mau_sac' => 'Xanh GP',
            'gia_thue_ngay' => 180000,
            'tinh_trang_xe' => 'SanSang',
            'hinh_anh' => 'https://images.unsplash.com/photo-1609630875171-b1321377ee65?auto=format&fit=crop&w=600&q=80',
            'ma_danh_muc' => $dmXeCon->ma_danh_muc,
        ]);

        $xe4 = XeMay::create([
            'bien_so_xe' => '29C1-44444',
            'ten_xe' => 'Honda Wave Alpha',
            'mau_sac' => 'Đỏ',
            'gia_thue_ngay' => 80000,
            'tinh_trang_xe' => 'BaoTri',
            'hinh_anh' => 'https://images.unsplash.com/photo-1558981403-c5f9899a28bc?auto=format&fit=crop&w=600&q=80',
            'ma_danh_muc' => $dmXeSo->ma_danh_muc,
        ]);

        // 6. Seed DonThue (Rentals)
        // Đơn 1: Đã hoàn thành (Khách 1 thuê Xe 1)
        $don1 = DonThue::create([
            'ngay_dat' => now()->subDays(5),
            'ngay_nhan_du_kien' => now()->subDays(4),
            'ngay_tra_du_kien' => now()->subDays(2),
            'tien_coc' => 1000000,
            'tong_tien_thue' => 240000, // 2 ngày * 120,000
            'trang_thai_don' => 'DaHoanThanh',
            'ma_khach_hang' => $khach1->ma_khach_hang,
            'ma_xe' => $xe1->ma_xe,
        ]);

        // Đơn 2: Đang thuê (Khách 2 thuê Xe 2)
        $don2 = DonThue::create([
            'ngay_dat' => now()->subDays(2),
            'ngay_nhan_du_kien' => now()->subDays(1),
            'ngay_tra_du_kien' => now()->addDays(2),
            'tien_coc' => 1500000,
            'tong_tien_thue' => 450000, // 3 ngày * 150,000
            'trang_thai_don' => 'DangThue',
            'ma_khach_hang' => $khach2->ma_khach_hang,
            'ma_xe' => $xe2->ma_xe,
        ]);

        // Đơn 3: Chờ duyệt (Khách 1 đặt Xe 3)
        $don3 = DonThue::create([
            'ngay_dat' => now(),
            'ngay_nhan_du_kien' => now()->addDays(1),
            'ngay_tra_du_kien' => now()->addDays(3),
            'tien_coc' => 1500000,
            'tong_tien_thue' => 360000, // 2 ngày * 180,000
            'trang_thai_don' => 'ChoDuyet',
            'ma_khach_hang' => $khach1->ma_khach_hang,
            'ma_xe' => $xe3->ma_xe,
        ]);

        // 7. Seed ThanhToan (Payments)
        // Thanh toán cho Đơn 1
        ThanhToan::create([
            'ma_don_thue' => $don1->ma_don_thue,
            'so_tien' => 240000,
            'phuong_thuc' => 'ChuyenKhoan',
            'trang_thai' => 'DaThanhToan',
            'ngay_thanh_toan' => now()->subDays(5),
        ]);

        // Thanh toán cho Đơn 2
        ThanhToan::create([
            'ma_don_thue' => $don2->ma_don_thue,
            'so_tien' => 450000,
            'phuong_thuc' => 'ViDienTu',
            'trang_thai' => 'DaThanhToan',
            'ngay_thanh_toan' => now()->subDays(2),
        ]);

        // 8. Seed GiaoXe (Vehicle Deliveries)
        // Giao xe Đơn 1 (Đã hoàn thành)
        GiaoXe::create([
            'ngay_giao_thuc_te' => now()->subDays(4),
            'tinh_trang_xe_khi_giao' => 'Xe mới rửa, đầy bình xăng, lốp căng, có xước nhẹ ở yếm phải.',
            'hinh_anh_khi_giao' => 'delivery_don1.png',
            'ma_don_thue' => $don1->ma_don_thue,
            'ma_quan_tri_vien' => $admin1->ma_quan_tri_vien,
        ]);

        // Giao xe Đơn 2 (Đang thuê)
        GiaoXe::create([
            'ngay_giao_thuc_te' => now()->subDays(1),
            'tinh_trang_xe_khi_giao' => 'Xe hoạt động tốt, có trang bị 2 mũ bảo hiểm.',
            'hinh_anh_khi_giao' => 'delivery_don2.png',
            'ma_don_thue' => $don2->ma_don_thue,
            'ma_quan_tri_vien' => $admin2->ma_quan_tri_vien,
        ]);

        // 9. Seed NhanXe (Vehicle Returns)
        // Nhận lại xe Đơn 1 (Đã hoàn thành)
        NhanXe::create([
            'ngay_nhan_thuc_te' => now()->subDays(2),
            'tinh_trang_xe_khi_nhan' => 'Xe bình thường, không phát sinh xước xát mới.',
            'chi_phi_phat_sinh' => 0,
            'ly_do_phat_sinh' => null,
            'ma_don_thue' => $don1->ma_don_thue,
            'ma_quan_tri_vien' => $admin1->ma_quan_tri_vien,
        ]);

        // 10. Seed DanhGia (Reviews)
        // Đánh giá cho Đơn 1
        DanhGia::create([
            'diem_so' => 5,
            'noi_dung' => 'Xe chạy rất êm, nhân viên hỗ trợ nhiệt tình, thủ tục nhanh chóng.',
            'ngay_danh_gia' => now()->subDays(2),
            'ma_khach_hang' => $khach1->ma_khach_hang,
            'ma_xe' => $xe1->ma_xe,
            'ma_don_thue' => $don1->ma_don_thue,
        ]);
    }
}
