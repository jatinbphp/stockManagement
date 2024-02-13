<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Role;
use App\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['menu'] = 'Roles';
        if ($request->ajax()) {
            return Datatables::of(Role::select())
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    $row['table_name'] = 'roles';
                    return view('admin.status-buttons', $row);
                })
                ->addColumn('action', function ($row) {
                    $row['section_name'] = 'roles';
                    $row['section_title'] = 'Role';
                    return view('admin.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.role.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show($id)
    {
        $role = Role::findOrFail($id);
        
        return view('admin.show_modal', [
            'section_info' => $role->toArray(),
            'type' => 'Role',
            'required_columns' => ['id', 'name', 'status', 'created_at']
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['menu']  = 'Roles';
        $data['role'] = Role::where('id',$id)->first();
        return view('admin.role.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, string $id)
    {
        $input = $request->all();
        $role = Role::findorFail($id);
        $role->update($input);
        \Session::flash('success','Role has been updated successfully!');
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
