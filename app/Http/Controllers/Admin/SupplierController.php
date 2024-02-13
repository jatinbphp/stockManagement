<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Http\Requests\SupplierRequest;


class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $data['menu'] = 'Suppliers';
        if ($request->ajax()) {
            return Datatables::of(Supplier::all())
                ->addIndexColumn()
                ->addColumn('created_at', function($row) {
                    return date("Y-m-d H:i:s", strtotime($row->created_at)); 
                })
                ->editColumn('status', function ($row) {
                    $row['table_name'] = 'suppliers';
                    return view('admin.status-buttons', $row);
                })
                ->addColumn('action', function ($row) {
                    $row['section_name'] = 'suppliers';
                    $row['section_title'] = 'Supplier';
                    return view('admin.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.supplier.index', $data);
    }

    public function create()
    {
        $data['menu'] = 'Suppliers';
        return view("admin.supplier.create", $data);
    }

    public function store(SupplierRequest $request)
    {
        $input = $request->all();
        Supplier::create($input);
        \Session::flash('success', 'Supplier has been inserted successfully!');
        return redirect()->route('suppliers.index');
    }

    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        
        return view('admin.show_modal', [
            'section_info' => $supplier->toArray(),
            'type' => 'Supplier',
            'required_columns' => ['id', 'name', 'email', 'telephone', 'account_number', 'status', 'created_at']
        ]);
    }

    public function edit(string $id)
    {
        $data['menu'] = 'Suppliers';
        $data['supplier'] = Supplier::where('id', $id)->first();
        return view('admin.supplier.edit', $data);
    }

    public function update(SupplierRequest $request, string $id)
    {
        $input = $request->all();
        $supplier = Supplier::findOrFail($id);
        $supplier->update($input);
        \Session::flash('success', 'Supplier has been updated successfully!');
        return redirect()->route('suppliers.index');
    }

    public function destroy(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        if (!empty($supplier)) {
            $supplier->delete();
            return 1;
        } else {
            return 0;
        }
    }
}
