<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Practice;
use App\Models\Supplier;
use App\Models\StockOrder;
use App\Models\StockOrderStatusHistory;
use App\Models\StockOrderReceive;
use App\Models\StockOrderReceiveDocument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StockOrderRequest;
use App\Http\Requests\StockOrderReceiveRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StockOrderController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('auth');
        $this->middleware('accessright:stock-orders');
    }

    public function index(Request $request){

        $loginUserRole = Auth::user()->role;

        $data['menu'] = 'Stock Orders';
        if ($request->ajax()) {
            $collection = StockOrder::with(['supplier', 'brand', 'practice'])
                ->select('stock_orders.*', 'suppliers.name', 'suppliers.email as supplier_email')
                ->leftJoin('suppliers', 'stock_orders.supplier_id', '=', 'suppliers.id')
                ->when($request->input('status'), function ($query, $status) {
                    return $query->where('stock_orders.status', $status);
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
                })
                ->when($loginUserRole == 'shop_manager', function ($query) {
                    return $query->whereIn('stock_orders.practice_id', [Auth::user()->practice_ids]);
                });

            return datatables()->of($collection)
                ->addIndexColumn()
                ->addColumn('so_id', function($order) {
                    return env('ORDER_PREFIX').'-'.date("Y", strtotime($order->created_at)).'-'.$order->id;
                })
                ->editColumn('created_at', function($row) {
                    return date("Y-m-d H:i:s", strtotime($row->created_at));
                })
                ->editColumn('status', function($row){
                    $status = $this->statusArray();
                    return $status[$row->status] ?? null;
                })
                ->editColumn('displayed_status', function($row){
                    $displayed_status = $this->displayedStatusArray();
                    return $displayed_status[$row->displayed_status] ?? null;
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'stock-orders';
                    $row['section_title'] = 'Stock Order';
                    $row['order_status'] = $row->status;
                    return view('admin.common.stock-orders-buttons', $row);
                })
                ->rawColumns(['status', 'displayed_status'])
                ->make(true);
        }

        //$data['brand'] = Brand::where('status', 'active')->orderBy('name', 'ASC')->pluck('name', 'id');
        $data['supplier'] = Supplier::where('status', 'active')->orderBy('name', 'ASC')->get()->pluck('full_name', 'id');

        if($loginUserRole=='shop_manager'){
            $data['practice'] = Practice::where('status', 'active')->whereIn('id', [Auth::user()->practice_ids])->orderBy('name', 'ASC')->get()->pluck('full_name', 'id');
        } else {
            $data['practice'] = Practice::where('status', 'active')->orderBy('name', 'ASC')->get()->pluck('full_name', 'id');
        }

        
        $data['status'] = StockOrder::$status;

        return view('admin.stock-order.index', $data);
    }

    public function create(){

        if(!in_array('stock-orders-add', getAccessRights())){
            \Session::flash('danger', 'Access Denied: You are not authorized to access this section. Please contact your administrator for assistance!');
            return redirect()->route('admin.dashboard');
        }

        $data['menu'] = 'Stock Orders';
        $data['brand'] = Brand::where('status', 'active')->orderBy('name', 'ASC')->pluck('name', 'id');
        $data['supplier'] = Supplier::where('status', 'active')->orderBy('name', 'ASC')->get()->pluck('full_name', 'id');
        $data['practice'] = Practice::where('status', 'active')->orderBy('name', 'ASC')->get()->pluck('full_name', 'id');
        return view("admin.stock-order.create",$data);
    }

    public function store(StockOrderRequest $request){
        $input = $request->all();
        if($file = $request->file('order_copy')){
            $input['order_copy'] = $this->fileMove($file,'stock-orders');
        }
        StockOrder::create($input);

        \Session::flash('success', 'Stock Order has been inserted successfully!');
        return redirect()->route('stock-orders.index');
    }

    public function show($id){
        $data['stock_order'] = StockOrder::with(['supplier', 'brand', 'practice'])->find($id);
        return view('admin.stock-order.show_modal', $data);
    }

    public function edit(string $id){
        $data['menu'] = 'Stock Orders';
        $data['brand'] = Brand::where('status', 'active')->orderBy('name', 'ASC')->pluck('name', 'id');
        $data['supplier'] = Supplier::where('status', 'active')->orderBy('name', 'ASC')->get()->pluck('full_name', 'id');
        $data['practice'] = Practice::where('status', 'active')->orderBy('name', 'ASC')->get()->pluck('full_name', 'id');
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
            $input['order_copy'] = $this->fileMove($file,'receive-stock-order');
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

    public function updateStockOrderStatus(Request $request){
        $order = StockOrder::findOrFail($request->id);
        $input = $request->all();
        $order->update(['status' => $request->status]);

        \Session::flash('success','Stock Order status has been updated successfully!');
        return redirect()->route('stock-orders.receive', [$input['id']]);
    }

    public function addStockOrderStatusHistory(Request $request){
        $input = $request->all();
        $input['updated_by'] = Auth::user()->id;
        return StockOrderStatusHistory::create($input);
    }

    public function getStockOrderStatusHistory($stock_order_id){
        $datas = StockOrderStatusHistory::with('user')->where('stock_order_id', $stock_order_id)->latest()->get();
        return response()->json([
            'status' => true,
            'data' => $datas,
            'message' => 'History get successfully',
            'status_name' => 'success',
        ], 200);
    }

    public function receiveStockOrder(string $id){
        $data['menu'] = 'Stock Orders';
        $data['stockOrder'] = StockOrder::findOrFail($id);
        $data['stock_order_status'] = StockOrder::$status;
        return view('admin.stock-order.receive', $data);
    }

    public function receiveStockOrderEdit(string $id){
        $data['menu'] = 'Stock Orders';
        $data['receiveStockOrder'] = StockOrderReceive::with(['stock_order','stock_order_receive_documents'])->find($id);
        $data['stock_order_status'] = StockOrder::$status;
        return view('admin.stock-order.edit-receive-stock-order', $data);
    }

    public function storeReceiveDocuments(StockOrderReceiveRequest $request){
        $input = $request->all();
        $input['added_by'] = Auth::user()->id;
        $StockOrderReceive = StockOrderReceive::create($input);

        // options & options values
        if (!empty($input['documents'])) {
            $input['stock_order_receive_id'] = $StockOrderReceive->id;
            $this->addDocumentAddUpdate($input);
        }

        $stockOrder = StockOrder::findOrFail($input['stock_order_id']);

        if (!empty($input['stock_order_status'])){
            $input['status'] = $input['stock_order_status'];
        }

        if (!empty($input['inv_number']) && !empty($input['grv_number'])){
            $input['received_at'] = date("Y-m-d H:i:s");
        }

        if(isset($request['is_delivered'])){
            $input['is_delivered'] = 1;
            $input['order_delivey_date'] = Carbon::now();
        }

        $stockOrder->update($input);

        if(isset($request['is_delivered']) && !empty($input['courier_tracking_number'])){
            \Session::flash('success', 'Order successfully delivered');
        }elseif(!empty($input['inv_number']) && !empty($input['grv_number']) && !empty($input['documents'])){
            \Session::flash('success', 'Documents successfully uploaded');
        }else{
            \Session::flash('success', 'Order successfully updated');
        }

        //\Session::flash('success', 'Stock Order Docuement has been inserted successfully!');    
        return redirect()->route('stock-orders.receive', [$input['stock_order_id']]);
    }

    public function index_receive_stock_order(Request $request){
        $data['menu'] = 'Stock Orders';
        if ($request->ajax()) {
            return datatables()->of(StockOrderReceive::with('stock_order')->where('stock_order_id', $request->stock_order_id))
                ->addIndexColumn()
                ->addColumn('created_at', function($row) {
                    return date("Y-m-d H:i:s", strtotime($row->created_at));
                })
                ->addColumn('action', function ($row) {
                    $row['section_name'] = 'receive-stock-orders';
                    $row['section_title'] = 'Receive Stock Order';
                    $row['store_order_status'] = $row->stock_order->status;

                    return view('admin.common.receive-stock-orders-button', $row)->render();
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.stock-order.index', $data);
    }

    // receive document view popup
    public function getReceiveStockOrderDocuments($stock_order_receive_id){
        $datas = StockOrderReceiveDocument::with('user')->where('stock_order_receive_id', $stock_order_receive_id)->latest()->get();
        foreach ($datas as $data) {
            $data->document_path = asset($data->document_name);
        }

        return response()->json([
            'status' => true,
            'data' => $datas,
            'message' => 'History get successfully',
            'status_name' => 'success',
        ], 200);
    }

    // delete receive documents
    public function deleteReceiveStockOrderDocuments(Request $request, $id, $type){
        if($type=='receive_stock_order'){
            $deleteData = StockOrderReceive::find($id);
        } else {
            $deleteData = StockOrderReceiveDocument::find($id);
        }

        if ($deleteData) {
            $deleteData->delete();
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    // get brand using supplier
    public function getBrandsBySupplier($supplierId){
        $supplier = Supplier::with('brand')->where('id', $supplierId)->first();
        $brands = $supplier->brand;
        return response()->json($brands);
    }

    // update receive documents
    public function updateReceiveDocuments(StockOrderReceiveRequest $request){
        $input = $request->all();
        $StockOrderReceive = StockOrderReceive::findorFail($input['stock_order_receive_id']);
        $StockOrderReceive->update($input);

        // options & options values
        if (!empty($input['documents'])){
            $this->addDocumentAddUpdate($input);
        } else {
            StockOrderReceiveDocument::where('stock_order_receive_id', $input['stock_order_receive_id'])->delete();
        }

        $stockOrder = StockOrder::findOrFail($input['stock_order_id']);

        if (!empty($input['stock_order_status'])) {            
            $input['status'] = $input['stock_order_status'];
        }

        if (!empty($input['inv_number']) && !empty($input['grv_number'])){
            $input['received_at'] = date("Y-m-d H:i:s");
        }

        if(isset($request['is_delivered']) && !empty($stockOrder['order_delivey_date'])){
            $input['is_delivered'] = 1;
            $input['order_delivey_date'] = Carbon::now();
        }

        $stockOrder->update($input);

        if(isset($request['is_delivered']) && !empty($input['courier_tracking_number'])){
            \Session::flash('success', 'Order successfully delivered');
        }elseif(!empty($input['inv_number']) && !empty($input['grv_number']) && !empty($input['documents'])){
            \Session::flash('success', 'Documents successfully uploaded');
        }else{
            \Session::flash('success', 'Order successfully updated');
        }

        //\Session::flash('success', 'Stock Order Docuement has been updated successfully!!');
        return redirect()->route('stock-orders.receive', [$input['stock_order_id']]);
    }

    //for upload receive documents
    public function addDocumentAddUpdate($input){
        $document_ids = [];
        if(!empty($input['documents']['old'])){
            foreach ($input['documents']['old'] as $key => $value) {
                $documentOld = StockOrderReceiveDocument::where('id',$key)->first();
                $document_ids[] = $documentOld->id;
            }

            if(count($document_ids)>0){
                StockOrderReceiveDocument::whereNotIn('id', $document_ids)->where('stock_order_receive_id',$input['stock_order_receive_id'])->delete();
            }
        }

        if(!empty($input['documents']['new'])){
            foreach ($input['documents']['new'] as $key => $value) {
                $documentName = $this->fileMove($value,'receive-stock-orders-documents');
                StockOrderReceiveDocument::create([
                    'document_name' => $documentName,
                    'stock_order_receive_id' =>  $input['stock_order_receive_id'],
                    'added_by' => Auth::user()->id,
                ]);
            }
        }
    }

    public function index_stock_order_dashborad(Request $request){

        $loginUserRole = Auth::user()->role;

        if ($request->ajax()) {
            $query = StockOrder::with(['supplier', 'brand', 'practice'])
                ->orderBy('id', 'DESC')
                ->take(5);

            if ($loginUserRole == 'shop_manager') {
                $query->whereIn('practice_id', [Auth::user()->practice_ids]);
            }

            return datatables()->of($query)
                ->addIndexColumn()
                ->addColumn('so_id', function($order) {
                    return env('ORDER_PREFIX').'-'.date("Y", strtotime($order->created_at)).'-'.$order->id;
                })
                ->addColumn('created_at', function($row) {
                    return date("Y-m-d H:i:s", strtotime($row->created_at));
                })
                ->editColumn('status', function($row){
                    $status = $this->statusArray();
                    return $status[$row->status] ?? null;
                })
                ->editColumn('displayed_status', function($row){
                    $displayed_status = $this->displayedStatusArray();
                    return $displayed_status[$row->displayed_status] ?? null;
                })
                ->rawColumns(['status', 'displayed_status'])
                ->make(true);

        }
    }

    public function stockDisplayedStockOrder(string $id){
        $data['menu'] = 'Stock Orders';
        $data['stockOrder'] = StockOrder::findOrFail($id);
        $data['stock_order_status'] = StockOrder::$status;
        $data['stock_displayed_status'] = StockOrder::$status_stock_displayed;
        return view('admin.stock-order.stock-displayed', $data);
    }

    public function updateStockOrderDisplayedStatus(Request $request){

        $order = StockOrder::findOrFail($request->id);
        $input = $request->all();

        if(empty($request->displayed_status)){
            \Session::flash('danger', 'Please select Stock Order Status Part 2.');
            return redirect()->route('stock-orders.stock-displayed', [$input['id']]);
        }

        $order->update(['displayed_status' => $request->displayed_status, 'displayed_status_date' => date('Y-m-d H:i:s')]);

        \Session::flash('success','Stock Order Status Part 2 has been updated successfully!');
        return redirect()->route('stock-orders.stock-displayed', [$input['id']]);
    }
}
