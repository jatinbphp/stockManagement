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
                });
                /*->when($request->input('daterange'), function ($query, $daterange) {
                    $start_date = explode("-", $daterange)[0];
                    $end_date = explode("-", $daterange)[1];
                    return $query->whereDate('created_at', '>=', $start_date)
                        ->whereDate('created_at', '<=', $end_date);
                });*/

            return datatables()->of($collection)
                ->addIndexColumn()
                ->addColumn('so_id', function($order) {
                    return env('ORDER_PREFIX').'-'.date("Y", strtotime($order->created_at)).'-'.$order->id;
                })
                ->addColumn('created_at', function($row) {
                    return date("Y-m-d H:i:s", strtotime($row->created_at));
                })
                ->addColumn('stock_order_receive_created_at', function($row) {
                    return !empty($row->stock_order_receive->created_at) ? date("Y-m-d H:i:s", strtotime($row->stock_order_receive->created_at)) : '-';
                })
                ->editColumn('status', function($row){
                   $status = [
                        'open' => '<span class="badge badge-primary">Open</span>',
                        'completed' => '<span class="badge badge-success">Completed</span>',
                        'incomplete' => '<span class="badge badge-danger">Incomplete</span>',
                   ];
                   return $status[$row->status] ?? null;
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        $data['practice'] = Practice::where('status', 'active')->orderBy('name', 'ASC')->pluck('name', 'id');
        $data['brand'] = Brand::where('status', 'active')->orderBy('name', 'ASC')->pluck('name', 'id');
        $data['supplier'] = Supplier::where('status', 'active')->orderBy('name', 'ASC')->pluck('name', 'id');
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

        //"Ref#", "Date Ordered", "Supplier", "Brand", "Practice", "Comments",
        // "Date Received", "Invoice Number",  "GRV Number", 'Additional Notes'

        if(count($orders) > 0){
            foreach ($orders as $order){
                $oDate = $order['created_at']->format('Y-m-d h:i:s');
                $sName = $order['supplier']['name'];
                $bName = $order['brand']['name'];
                $pName = $order['practice']['name'];

                if(count($order['stock_order_multi_receive']) > 0){
                    foreach ($order['stock_order_multi_receive'] as $receive){
                        $rDate = $receive['created_at']->format('Y-m-d h:i:s');
                        $iNumber = $receive['inv_number'];
                        $gNumber = $receive['grv_number'];
                        $notes = $receive['notes'];
                        $data[] = [$order['so_id'], $oDate, $sName, $bName, $pName,$order['instructions'], $rDate, $iNumber, $gNumber, $notes];
                    }
                }else{
                    $data[] = [$order['so_id'], $oDate, $sName, $bName, $pName,$order['instructions'],'','','',''];
                }
            }

            return Excel::download(new OrderExport($data), 'stock_order_report.xlsx');
        }else{
            return 0;
        }
    }
}
