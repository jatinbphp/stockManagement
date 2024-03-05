<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\StockOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $data['menu'] = "Dashboard";
        $data['total_stock_clerk'] = User::where('role', 'stock_clerk')->count();
        $data['total_accountant'] = User::where('role', 'accountant')->count();
        $data['total_suppliers'] = Supplier::count();
        $data['total_stock_orders'] = StockOrder::count();

        return view('admin.dashboard', $data);
    }
}