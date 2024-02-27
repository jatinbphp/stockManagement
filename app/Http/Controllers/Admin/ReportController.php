<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrderExport;
use App\Models\Brand;
use App\Models\Practice;
use App\Models\StockOrderReceive;
use App\Models\Supplier;
use App\Models\StockOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('auth');
        $this->middleware('accessright:reports');
    }

    public function index(Request $request){
        $data['menu'] = 'Reports';
        if ($request->ajax()) {
            $collection = StockOrder::with(['supplier', 'brand', 'practice', 'stock_order_receive'])
                ->select('stock_orders.*', 'suppliers.name as supplier_full_name', 'suppliers.email as supplier_email')
                ->leftJoin('suppliers', 'stock_orders.supplier_id', '=', 'suppliers.id')
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
                ->when($request->input('daterange'), function ($query, $daterange) use ($request) {
                    if ($request->input('datetype') === 'date-created') {
                        $start_date = explode("-", $daterange)[0];
                        $end_date = date('Y-m-d', strtotime(explode("-", $daterange)[1] . ' +1 day'));
                        return $query->whereDate('stock_orders.created_at', '>=', $start_date)
                                     ->whereDate('stock_orders.created_at', '<', $end_date);
                    } elseif ($request->input('datetype') === 'date-received') {
                        $start_date = explode("-", $daterange)[0];
                        $end_date = date('Y-m-d', strtotime(explode("-", $daterange)[1] . ' +1 day'));
                        return $query->whereDate('received_at', '>=', $start_date)
                                     ->whereDate('received_at', '<', $end_date);
                    }
                });
                
            return datatables()->of($collection)
                ->addIndexColumn()
                ->addColumn('so_id', function($order) {
                    return env('ORDER_PREFIX').'-'.date("Y", strtotime($order->created_at)).'-'.$order->id;
                })
                ->editColumn('created_at', function($row) {
                    return date("Y-m-d H:i:s", strtotime($row->created_at));
                })
                ->addColumn('stock_order_receive_created_at', function($row) {
                    return !empty($row->stock_order_receive->created_at) ? date("Y-m-d H:i:s", strtotime($row->stock_order_receive->created_at)) : '-';
                })
                ->editColumn('status', function($row){
                   $status = $this->statusArray();
                   return $status[$row->status] ?? null;
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        //$data['brand'] = Brand::where('status', 'active')->orderBy('name', 'ASC')->pluck('name', 'id');
        $data['supplier'] = Supplier::where('status', 'active')->orderBy('name', 'ASC')->get()->pluck('full_name', 'id');
        $data['practice'] = Practice::where('status', 'active')->orderBy('name', 'ASC')->get()->pluck('full_name', 'id');
        $data['status'] = StockOrder::$status;

        return view('admin.report.index', $data);
    }

    public function export(Request $request){
        $orders = StockOrder::with(['supplier', 'brand', 'practice', 'stock_order_multi_receive'])
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
                $end_date = date('Y-m-d', strtotime(explode("-", $daterange)[1] . ' +1 day')); // Increment end date by one day
                return $query->whereDate('created_at', '>=', $start_date)
                    ->whereDate('created_at', '<', $end_date); // Use < instead of <=
            })->get();

        $data = [];

        if(count($orders) > 0){
            foreach ($orders as $order){
                $so_id = env('ORDER_PREFIX').'-'.date("Y", strtotime($order->created_at)).'-'.$order->id;
                $oDate = $order['created_at']->format('Y-m-d h:i:s');
                $sName = $order['supplier']['name'].' ('.$order['supplier']['email'].')';
                $bName = $order['brand']['name'].' ('.$order['brand']['email'].')';
                $pName = $order['practice']['name'].' ('.$order['practice']['email'].')';
                $oStatus = $this->getStatus($order['status']);

                if(count($order['stock_order_multi_receive']) > 0){
                    foreach ($order['stock_order_multi_receive'] as $receive){
                        $rDate = $receive['created_at']->format('Y-m-d h:i:s');
                        $iNumber = $receive['inv_number'];
                        $gNumber = $receive['grv_number'];
                        $notes = $receive['notes'];

                        $data[] = [$so_id, $oDate, $sName, $bName, $pName,$order['instructions'], $oStatus, $rDate, $iNumber, $gNumber, $notes];
                    }
                }else{
                    $data[] = [$so_id, $oDate, $sName, $bName, $pName,$order['instructions'], $oStatus,'','','','', ''];
                }
            }

            return Excel::download(new OrderExport($data), 'stock_order_report.xlsx');
        }else{
            return 0;
        }
    }
}
