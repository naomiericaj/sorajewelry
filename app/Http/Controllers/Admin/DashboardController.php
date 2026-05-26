<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $totalProducts = Product::count();

        $totalCustomers = User::where('role', 'customer')->count();

        $totalOrders = Order::count();

        $pendingOrders = Order::where('order_status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCustomers',
            'totalOrders',
            'pendingOrders'
        ));
    }
}