<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // === Total Pendapatan Bulanan ===
        $monthlySales = Order::where('order_status', 'Selesai')
            ->whereMonth('created_at', now()->month)
            ->sum('total_payment');

        // === Total Pendapatan Tahunan ===
        $annualSales = Order::where('order_status', 'Selesai')
            ->whereYear('created_at', now()->year)
            ->sum('total_payment');

        // === Grafik Penjualan Bulanan ===
        $monthlyData = Order::selectRaw('MONTH(created_at) as month, SUM(total_payment) as total')
            ->where('order_status', 'Selesai')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = [];
        $data = [];

        // Isi data tiap bulan (1 - 12)
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->translatedFormat('F'); // Januari, Februari, dst.
            $found = $monthlyData->firstWhere('month', $i);
            $data[] = $found ? (int) $found->total : 0;
        }

        $topCategories = OrderItem::select(
            'products.category_id',
            DB::raw('SUM(order_items.amount) as total'),
            'categories.category_name'
        )
        ->join('products', 'products.products_id', '=', 'order_items.products_id')
        ->join('categories', 'categories.category_id', '=', 'products.category_id')
        ->whereHas('order', function ($query) {
            $query->whereIn('order_status', ['Telah Dibayar', 'Selesai']);
        })
        ->groupBy('products.category_id', 'categories.category_name')
        ->orderByDesc('total')
        ->limit(5)
        ->get();
        
        $pieLabels = [];
        $pieData = [];
        
        foreach ($topCategories as $item) {
            $pieLabels[] = $item->category_name;
            $pieData[] = $item->total;
        }

        // === Jumlah Order Berdasarkan Status ===
        $completedOrders = Order::where('order_status', 'Selesai')->count();
        $pendingOrders = Order::where('order_status', 'Belum Bayar')->count();

        // === Kirim Semua Data ke View ===
        return view('admin.dashboard', [
            'monthlySales' => $monthlySales,
            'annualSales' => $annualSales,
            'labels' => $labels,
            'data' => $data,
            'pieLabels' => $pieLabels,
            'pieData' => $pieData,
            'completedOrders' => $completedOrders,
            'pendingOrders' => $pendingOrders,
        ]);
    }
}
