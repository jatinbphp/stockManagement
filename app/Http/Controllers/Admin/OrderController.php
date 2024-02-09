<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Cart;
use App\Models\Products;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['menu'] = 'Orders';
        if ($request->ajax()) {
            return DataTables::of(Order::select())
                ->addColumn('user_name', function($order) {
                    return $order->user->name; 
                })
                ->addColumn('user_email', function($order) {
                    return $order->user->email;
                })
                ->addColumn('total_amount', function($order) {
                    return '£ '.number_format($order->total_amount, 2);
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'orders';
                    $row['section_title'] = 'order';
                    return view('admin.action-buttons', $row);
                })
                ->addColumn('status', function($row){
                    $select = '<select class="form-control select2 orderStatus" id="status'.$row->unique_id.'"  data-id="'.$row->id.'" >';
                        foreach(Order::$allStatus as $status){
                            $selected = ($status == $row->status) ? ' selected="selected"' : '';
                            $select .= '<option '.$selected.' value="'.$status.'">'.ucfirst($status).'</option>';
                        }
                    $select .= '</select>';
                    return $select;
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        return view('admin.order.index', $data);
    }

    public function index_product(Request $request)
    {
        $data['menu'] = 'Orders';
        if ($request->ajax()) {
            return DataTables::of(Cart::select()->where('csrf_token',csrf_token())->get())
                ->addColumn('product_name', function($order) {
                    return $order->product->product_name; 
                })
                ->addColumn('sku', function($order) {
                    return $order->product->sku; 
                })
                ->addColumn('unit_price', function($order) {
                    return '£ '.number_format($order->product->price, 2);
                })
                ->addColumn('total', function($order) {
                    return '£ '.number_format(($order->quantity*$order->product->price), 2);
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'orders_products';
                    $row['section_title'] = 'order';
                    return view('admin.action-buttons', $row);
                })
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['menu'] = 'Orders';
        $data['users'] = User::where('status', 'active')->where('role', 'user')->get();
        $data['products'] = Products::where('status', 'active')->get();
        return view("admin.order.create",$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['menu'] = 'Orders';
        $data['order'] = Order::where('id',$id)->first();
        return view('admin.order.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    { 
        $data['status'] = 0;
        $order = Order::findOrFail($id);
        $input = $request->all();
        
        if (!empty($order)) {
            $order->update(['status' => $request->status]);
            $data['status'] = 1;
        }

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        if(!empty($order)){
            $order->delete();
            return 1;
        }else{
            return 0;
        }
    }

    public function addProductToCart(Request $request)
    {

        $this->validate($request, [
            'product_id' => 'required',
            'quantity' =>'required|numeric',
            'options' => 'required|array',
            'options.*' => 'array', // Ensure each option is an array
            'options.*.*' => 'numeric' // Ensure each option value is numeric
        ]);

        $input = $request->all();
        $input['added_by_admin'] = 1;
        $input['options'] = json_encode($input['options']);
        $input['csrf_token'] = $input['_token'];
        Cart::create($input);

        return $input = $request->all();
    }
} 
