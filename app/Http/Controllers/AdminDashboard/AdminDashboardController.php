<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Items;
use App\Models\Blog;
use Carbon\Carbon;
class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::where('sys_state', '!=', '-1')->count();

        $totalCustomers = User::where('sys_state', '!=', '-1')->count();

        $totalBlog = Blog::count();

        $totalPurchase = Items::where('sys_state', '!=', '-1')->count();

        $totalSales = Order::where('sys_state', '!=', '-1')->sum('payment_amount');

        $users = User::where('sys_state', '!=', '-1')->latest()->take(5)->get();

        return view('dashboard.dashboardv1', compact(
            'totalOrders',
            'totalCustomers',
            'totalBlog',
            'totalPurchase',
            'totalSales',
            'users'
        ));
    }
    public function filter(Request $request)
    {
        $filter = $request->input('filter', 'all');

        $orderQuery = Order::where('sys_state', '!=', '-1');
        $userQuery = User::where('sys_state', '!=', '-1');
        $itemQuery = Items::where('sys_state', '!=', '-1');

        switch ($filter) {
            case 'today':
                $orderQuery->whereDate('created_at', Carbon::today());
                $userQuery->whereDate('created_at', Carbon::today());
                $itemQuery->whereDate('created_at', Carbon::today());
                break;

            case 'this_week':
                $orderQuery->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                $userQuery->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                $itemQuery->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;

            case 'this_month':
                $orderQuery->whereMonth('created_at', Carbon::now()->month);
                $userQuery->whereMonth('created_at', Carbon::now()->month);
                $itemQuery->whereMonth('created_at', Carbon::now()->month);
                break;

            case 'this_year':
                $orderQuery->whereYear('created_at', Carbon::now()->year);
                $userQuery->whereYear('created_at', Carbon::now()->year);
                $itemQuery->whereYear('created_at', Carbon::now()->year);
                break;

            case 'lifetime':
            default:
                break;
        }

        $totalOrders = $orderQuery->count();
        $totalSales = $orderQuery->sum('payment_amount');

        $totalCustomers = $userQuery->count();
        $users = $userQuery->latest()->take(5)->get();

        $totalBlog = Blog::count();
        $totalPurchase = $itemQuery->count();

        return response()->json([
            'totalOrders' => $totalOrders,
            'totalSales' => $totalSales,
            'totalCustomers' => $totalCustomers,
            'totalPurchase' => $totalPurchase,
            'users' => $users, // already done ✔
        ]);
    }
}
