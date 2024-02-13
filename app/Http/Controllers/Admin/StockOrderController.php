<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Practice;
use App\Models\Supplier;
use App\Models\StockOrder;
use App\Models\StockOrderStatusHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StockOrderRequest;
use Illuminate\Support\Facades\Auth;

class StockOrderController extends Controller{
    public function index(Request $request){
        $data['menu'] = 'Stock Orders';    
        if ($request->ajax()) {
            return datatables()->of(StockOrder::with(['supplier', 'brand', 'practice'])->get())
                ->addIndexColumn()
                ->addColumn('created_at', function($row) {
                    return date("Y-m-d H:i:s", strtotime($row->created_at)); 
                })
                ->editColumn('status', function($row){
                    $row['stock_order_status'] = StockOrder::$status;
                    return view('admin.stock-order.status-dropdown', $row);
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'stock-orders';
                    $row['section_title'] = 'Stock Order';
                    return view('admin.action-buttons', $row);
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        return view('admin.stock-order.index', $data);
    }

    public function create(){
        $data['menu']       = 'Stock Orders';
        $data['brand']      = Brand::where('status', 'active')->pluck('name', 'id');
        $data['supplier']  = Supplier::where('status', 'active')->get()->pluck('full_name', 'id');
        $data['practice'] = Practice::where('status', 'active')->get()->pluck('full_name', 'id');
        return view("admin.stock-order.create",$data);
    }

    public function store(StockOrderRequest $request){
        $input   = $request->all();
        if($file = $request->file('order_copy')){
            $input['order_copy'] = $this->fileMove($file,'stock-orders');
        }

        StockOrder::create($input);
        \Session::flash('success', 'Stock Order has been inserted successfully!');
        return redirect()->route('stock-orders.index');
    }

    public function show($id)
    {
        $data['stock_order'] = StockOrder::with(['supplier', 'brand', 'practice'])->find($id);
        return view('admin.stock-order.show_modal', $data);
    }

    public function edit(string $id){        
        $data['menu'] = 'Stock Orders';
        $data['brand'] = Brand::where('status', 'active')->pluck('name', 'id');
        $data['supplier'] = Supplier::where('status', 'active')->get()->pluck('full_name', 'id');
        $data['practice'] = Practice::where('status', 'active')->get()->pluck('full_name', 'id');
        $data['stockOrder'] = StockOrder::findOrFail($id);
        return view('admin.stock-order.edit', $data);
    }

    public function update(StockOrderRequest $request, string $id){
        $input = $request->all();
        $stockOrder = StockOrder::findOrFail($id);

        if($file = $request->file('order_copy')){
            if (!empty($stockOrder->order_copy) && file_exists($stockOrder->order_copy)) {
                unlink($stockOrder->order_copy);
            }
            $input['order_copy'] = $this->fileMove($file,'stock-orders');
        }

        $stockOrder->update($input);
        \Session::flash('success','Stock Order has been updated successfully!');
        return redirect()->route('stock-orders.index');
    }

    public function destroy(string $id){
        $stockOrder = StockOrder::findOrFail($id);
        
        if(!empty($stockOrder)){
            if (!empty($stockOrder->order_copy) && file_exists($stockOrder->order_copy)) {
                unlink($stockOrder->order_copy);
            }
            $stockOrder->delete();
            return 1;
        } else {  
            return 0;
        }
    }

    public function updateStockOrderStatus(Request $request)
    { 
        $data['status'] = 0;
        $order = StockOrder::findOrFail($request->id);
        $input = $request->all();
        
        if (!empty($order)) {
            $order->update(['status' => $request->status]);
            $data['status'] = 1;
        }

        return $data;
    }

    public function addStockOrderStatusHistory(Request $request)
    {
        $input   = $request->all();
        $input['updated_by'] = Auth::user()->id;
        return StockOrderStatusHistory::create($input);
    }

    public function getStockOrderStatusHistory($stock_order_id)
    {   
        $datas = StockOrderStatusHistory::with('user')->where('stock_order_id', $stock_order_id)->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $datas,
            'message' => 'History get successfully',
            'status_name' => 'success',
        ], 200);
    }


}
