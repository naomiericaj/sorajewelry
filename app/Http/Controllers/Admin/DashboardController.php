<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();

        // If orders table exists
        $totalOrders = class_exists(Order::class) ? Order::count() : 0;

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCustomers',
            'totalOrders'
        ));
    }
}