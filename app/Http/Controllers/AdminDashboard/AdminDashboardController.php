<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Items;
use App\Models\Blog;
class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();

        $totalCustomers = User::count();

        $totalBlog = Blog::count();

        $totalPurchase = Items::count();

        $users = User::where('sys_state', '!=', '-1')->latest()->take(5)->get();

        return view('dashboard.dashboardv1', compact(
            'totalOrders',
            'totalCustomers',
            'totalBlog',
            'totalPurchase',
            'users'
        ));
    }
}
