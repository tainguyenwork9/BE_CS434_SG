<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonThue;
use App\Models\KhachHang;
use App\Models\XeMay;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->query('period', '7_days');

        // 1. Stats
        $revenue = DonThue::where('trang_thai_don', '!=', 'Đã hủy')->sum('tong_tien_thue');
        $customersCount = KhachHang::count();
        $totalVehicles = XeMay::count();
        $activeVehicles = XeMay::where('tinh_trang_xe', 'Sẵn sàng')->count();
        $todayRentals = DonThue::whereDate('ngay_dat', Carbon::today())->count();

        // 2. Vehicle Distribution (Join with danh_muc_xe)
        $vehicleDistribution = XeMay::join('danh_muc_xe', 'xe_may.ma_danh_muc', '=', 'danh_muc_xe.ma_danh_muc')
            ->select('danh_muc_xe.ten_danh_muc', DB::raw('count(*) as count'))
            ->groupBy('danh_muc_xe.ten_danh_muc')
            ->get();

        // Calculate percentages for vehicle distribution
        $distributionWithPercentage = $vehicleDistribution->map(function ($item) use ($totalVehicles) {
            $percentage = $totalVehicles > 0 ? round(($item->count / $totalVehicles) * 100) : 0;
            return [
                'label' => $item->ten_danh_muc,
                'count' => $item->count,
                'percentage' => $percentage
            ];
        });

        // 3. Recent Orders
        $recentOrders = DonThue::with(['khachHang', 'xeMay'])
            ->orderBy('ngay_dat', 'desc')
            ->take(10)
            ->get()
            ->map(function ($order) {
                return [
                    'ma_don_thue' => 'ORD-' . str_pad($order->ma_don_thue, 4, '0', STR_PAD_LEFT),
                    'khach_hang' => $order->khachHang ? $order->khachHang->ho_ten : 'N/A',
                    'xe' => $order->xeMay ? $order->xeMay->ten_xe : 'N/A',
                    'ngay_dat' => $order->ngay_dat ? $order->ngay_dat->format('d/m/Y') : 'N/A',
                    'tong_tien' => $order->tong_tien_thue,
                    'trang_thai' => $order->trang_thai_don
                ];
            });

        // 4. Revenue Trend
        $revenueTrend = [];
        
        if ($period === 'year') {
            $startOfYear = Carbon::now()->startOfYear();
            $revenueTrendRaw = DonThue::where('trang_thai_don', '!=', 'Đã hủy')
                ->whereDate('ngay_dat', '>=', $startOfYear)
                ->select(DB::raw('MONTH(ngay_dat) as month'), DB::raw('SUM(tong_tien_thue) as total_revenue'))
                ->groupBy('month')
                ->get()
                ->keyBy('month');
                
            for ($i = 1; $i <= 12; $i++) {
                $revenueTrend[] = [
                    'day' => 'T' . $i,
                    'date' => 'Tháng ' . $i,
                    'revenue' => isset($revenueTrendRaw[$i]) ? (float) $revenueTrendRaw[$i]->total_revenue : 0
                ];
            }
        } elseif ($period === '30_days') {
            $startDate = Carbon::today()->subDays(29);
            $revenueTrendRaw = DonThue::where('trang_thai_don', '!=', 'Đã hủy')
                ->whereDate('ngay_dat', '>=', $startDate)
                ->select(DB::raw('DATE(ngay_dat) as date'), DB::raw('SUM(tong_tien_thue) as total_revenue'))
                ->groupBy('date')
                ->get()
                ->keyBy('date');
                
            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);
                $dateString = $date->toDateString();
                $dayLabel = ($i % 5 === 0 || $i === 0 || $i === 29) ? $date->format('d/m') : '';
                
                $revenueTrend[] = [
                    'day' => $dayLabel,
                    'date' => $date->format('d/m'),
                    'revenue' => isset($revenueTrendRaw[$dateString]) ? (float) $revenueTrendRaw[$dateString]->total_revenue : 0
                ];
            }
        } else {
            $sevenDaysAgo = Carbon::today()->subDays(6);
            $revenueTrendRaw = DonThue::where('trang_thai_don', '!=', 'Đã hủy')
                ->whereDate('ngay_dat', '>=', $sevenDaysAgo)
                ->select(DB::raw('DATE(ngay_dat) as date'), DB::raw('SUM(tong_tien_thue) as total_revenue'))
                ->groupBy('date')
                ->get()
                ->keyBy('date');

            $daysOfWeekMap = [
                0 => 'CN', 1 => 'Thứ 2', 2 => 'Thứ 3', 3 => 'Thứ 4', 
                4 => 'Thứ 5', 5 => 'Thứ 6', 6 => 'Thứ 7',
            ];

            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);
                $dateString = $date->toDateString();
                $dayOfWeek = $date->dayOfWeek;
                
                $revenueTrend[] = [
                    'day' => $daysOfWeekMap[$dayOfWeek],
                    'date' => $date->format('d/m'),
                    'revenue' => isset($revenueTrendRaw[$dateString]) ? (float) $revenueTrendRaw[$dateString]->total_revenue : 0
                ];
            }
        }

        return response()->json([
            'stats' => [
                'revenue' => $revenue,
                'customers' => $customersCount,
                'vehicles' => [
                    'active' => $activeVehicles,
                    'total' => $totalVehicles,
                    'percentage' => $totalVehicles > 0 ? round(($activeVehicles / $totalVehicles) * 100) : 0
                ],
                'rentals_today' => $todayRentals,
            ],
            'vehicle_distribution' => $distributionWithPercentage,
            'recent_orders' => $recentOrders,
            'revenue_trend' => $revenueTrend,
        ]);
    }
}
