<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    function index() : View {
        $todaysOrders = Order::whereDate('created_at', now()->format('Y-m-d'))->count();
        $todaysEarnings = Order::whereDate('created_at', now()->format('Y-m-d'))->sum('grand_total');
        $monthOrders = Order::whereMonth('created_at', now()->month)->count();
        $monthEarnings = Order::whereMonth('created_at', now()->month)->sum('grand_total');
        $yearOrders = Order::whereYear('created_at', now()->year)->count();
        $yearEarnings = Order::whereYear('created_at', now()->year)->sum('grand_total');

        $totalUsers = User::where('role', 'user')->count();

        $totalProducts = Product::count();
        return view('admin.dashboard.index', compact(
            'todaysOrders',
            'todaysEarnings',
            'monthOrders',
            'monthEarnings',
            'yearOrders',
            'yearEarnings',
            'totalUsers',
            'totalProducts'

        ));
    }
}
