<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ===== Thống kê Đơn hàng =====
        $totalOrders      = Order::count();
        $pendingOrders     = Order::where('status', 'pending')->count();
        $processingOrders  = Order::where('status', 'processing')->count();
        $shippedOrders     = Order::where('status', 'shipped')->count();
        $deliveredOrders   = Order::where('status', 'delivered')->count();
        $cancelledOrders   = Order::where('status', 'cancelled')->count();

        // ===== Doanh thu (tổng tiền từ các đơn đã giao thành công) =====
        $totalRevenue = OrderDetail::whereHas('order', function ($q) {
            $q->where('status', 'delivered');
        })->sum(DB::raw('price * quantity'));

        // Doanh thu tất cả đơn (không phân biệt trạng thái, trừ đã hủy)
        $totalRevenueAll = OrderDetail::whereHas('order', function ($q) {
            $q->where('status', '!=', 'cancelled');
        })->sum(DB::raw('price * quantity'));

        // ===== Khách hàng =====
        $totalCustomers = User::where('role', '!=', 'admin')->count();

        // ===== Sản phẩm được mua nhiều nhất =====
        $topProducts = Product::select('products.*', DB::raw('COALESCE(SUM(order_details.quantity), 0) as total_sold'))
            ->leftJoin('order_details', 'products.id', '=', 'order_details.product_id')
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // ===== Sản phẩm ít được mua nhất =====
        $leastProducts = Product::select('products.*', DB::raw('COALESCE(SUM(order_details.quantity), 0) as total_sold'))
            ->leftJoin('order_details', 'products.id', '=', 'order_details.product_id')
            ->groupBy('products.id')
            ->orderBy('total_sold', 'asc')
            ->limit(5)
            ->get();

        // ===== Sản phẩm có lượt xem cao nhất =====
        $mostViewedProducts = Product::orderByDesc('view')->limit(5)->get();

        // ===== Phân tích dữ liệu bằng Python =====
        $analysis = null;
        try {
            $pythonScript = base_path('scripts/analyze.py');
            $inputData = json_encode(['orders' => []]);

            $descriptorSpec = [
                0 => ["pipe", "r"],
                1 => ["pipe", "w"],
                2 => ["pipe", "w"],
            ];

            $process = proc_open("python \"$pythonScript\"", $descriptorSpec, $pipes);
            if (is_resource($process)) {
                fwrite($pipes[0], $inputData);
                fclose($pipes[0]);
                $output = stream_get_contents($pipes[1]);
                fclose($pipes[1]);
                fclose($pipes[2]);
                proc_close($process);
                $analysis = json_decode($output, true);
            }
        } catch (\Exception $e) {
            $analysis = null;
        }

        return view('admin.dashboard', compact(
            'totalOrders', 'pendingOrders', 'processingOrders', 'shippedOrders',
            'deliveredOrders', 'cancelledOrders',
            'totalRevenue', 'totalRevenueAll', 'totalCustomers',
            'topProducts', 'leastProducts', 'mostViewedProducts',
            'analysis'
        ));
    }
}
