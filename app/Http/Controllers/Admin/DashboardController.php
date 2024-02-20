<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Brand;
use App\Models\Practice;
use App\Models\StockOrder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data['menu'] = "Dashboard";
        $data['users'] = User::where('role', '!=', 'admin')->count();
        $data['suppliers'] = Supplier::count();
        $data['brands'] = Brand::count();
        $data['practices'] = Practice::count();
        $data['stock_orders'] = StockOrder::count();
        return view('admin.dashboard', $data);
    }
}
