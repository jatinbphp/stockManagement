<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Practice;
use App\Models\Supplier;

use App\Models\StockOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StockOrderRequest;

class StockOrderController extends Controller{
    public function index(Request $request){
        $data['menu'] = 'Stock Order';    
        if ($request->ajax()) {
            return datatables()->of(StockOrder::with(['supplier', 'brand', 'practice'])->get())
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $row['section_name'] = 'stock-order';
                    $row['section_title'] = 'Stock Order';
                    return view('admin.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.stock-order.index', $data);
    }

    public function create(){
        $data['menu']       = 'Stock Order';
        $data['brand']      = Brand::where('status', 'active')->pluck('name', 'id');
        $data['supplier']   = Supplier::where('status', 'active')->pluck('name', 'id');
        $data['practice']   = Practice::where('status', 'active')->pluck('name', 'id');
        return view("admin.stock-order.create",$data);
    }

    public function store(StockOrderRequest $request){
        $input   = $request->all();
        if($file = $request->file('order_copy')){
            $input['order_copy'] = $this->fileMove($file,'stock-orders');
        }

        StockOrder::create($input);
        \Session::flash('success', 'Stock Order has been inserted successfully!');
        return redirect()->route('stock-order.index');
    }

    public function edit(string $id){        
        $data['menu']       = 'Stock Order';
        $data['brand']      = Brand::where('status', 'active')->pluck('name', 'id');
        $data['supplier']   = Supplier::where('status', 'active')->pluck('name', 'id');
        $data['practice']   = Practice::where('status', 'active')->pluck('name', 'id');
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
        return redirect()->route('stock-order.index');
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
}
