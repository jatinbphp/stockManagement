<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Practice;
use App\Models\Supplier;
use App\Models\StockOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller{
    public function index(Request $request){
        $data['menu'] = 'Reports';

        if ($request->ajax()) {
            $collection = StockOrder::with(['supplier', 'brand', 'practice'])
                ->when($request->input('status'), function ($query, $status) {
                    return $query->where('status', $status);
                })
                ->when($request->input('brand_id'), function ($query, $brand_id) {
                    return $query->where('brand_id', $brand_id);
                })
                ->when($request->input('supplier_id'), function ($query, $supplier_id) {
                    return $query->where('supplier_id', $supplier_id);
                })
                ->when($request->input('practice_id'), function ($query, $practice_id) {
                    return $query->where('practice_id', $practice_id);
                })
                ->when($request->input('daterange'), function ($query, $daterange) {
                    $start_date = explode("-", $daterange)[0];
                    $end_date = explode("-", $daterange)[1];
                    return $query->whereDate('created_at', '>=', $start_date)
                        ->whereDate('created_at', '<=', $end_date);
                });

            return datatables()->of($collection)
                ->addIndexColumn()
                ->addColumn('created_at', function($row) {
                    return date("Y-m-d H:i:s", strtotime($row->created_at)); 
                })
                ->editColumn('status', function($row){
                   $status = [
                        'open'          => '<span class="badge badge-primary">Open</span>',
                        'completed'     => '<span class="badge badge-success">Completed</span>',
                        'incomplete'    => '<span class="badge badge-danger">Incomplete</span>',
                   ]; 
                   return $status[$row->status] ?? null;
                })
                ->rawColumns(['status'])
                ->make(true);
        }
        
        $data['practice']   = Practice::where('status', 'active')->pluck('name', 'id');
        $data['brand']      = Brand::where('status', 'active')->pluck('name', 'id');
        $data['supplier']   = Supplier::where('status', 'active')->pluck('name', 'id');
        $data['status']     = StockOrder::$status;   

        return view('admin.report.index', $data);
    }
}