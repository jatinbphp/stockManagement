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
        $data['menu'] = 'Supplier';
        if ($request->ajax()) {
            return Datatables::of(Supplier::all())
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $row['table_name'] = 'suppliers';
                    return view('admin.status-buttons', $row);
                })
                ->addColumn('action', function ($row) {
                    $row['section_name'] = 'supplier';
                    $row['section_title'] = 'Supplier';
                    return view('admin.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.supplier.index', $data);
    }

    public function create()
    {
        $data['menu'] = 'Supplier';
        return view("admin.supplier.create", $data);
    }

    public function store(SupplierRequest $request)
    {
        $input = $request->all();
        Supplier::create($input);
        \Session::flash('success', 'Supplier has been inserted successfully!');
        return redirect()->route('supplier.index');
    }

    public function edit(string $id)
    {
        $data['menu'] = 'Supplier';
        $data['supplier'] = Supplier::where('id', $id)->first();
        return view('admin.supplier.edit', $data);
    }

    public function update(SupplierRequest $request, string $id)
    {
        $input = $request->all();
        $supplier = Supplier::findOrFail($id);
        $supplier->update($input);
        \Session::flash('success', 'Supplier has been updated successfully!');
        return redirect()->route('supplier.index');
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
