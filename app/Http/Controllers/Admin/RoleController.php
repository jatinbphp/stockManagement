<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Role;
use App\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('auth');
        $this->middleware('accessright:roles');
    }

    public function index(Request $request){
        $data['menu'] = 'Roles';
        if ($request->ajax()) {
            return Datatables::of(Role::select())
                ->addIndexColumn()
                ->editColumn('access_rights', function ($row) {
                    $accessRights = json_decode($row->access_rights);

                    // Map each access right to its corresponding HTML button
                    $buttonsHtml = collect($accessRights)->map(function ($accessRight) {
                        // Create and return the HTML button for each access right
                        return '<span class="badge badge-success p-2">' . ucfirst($accessRight) . '</span>';
                    })->implode(' '); // Implode the HTML buttons with a space separator

                    return $buttonsHtml;
                })
                ->editColumn('status', function ($row) {
                    $row['table_name'] = 'roles';
                    return view('admin.common.status-buttons', $row);
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'roles';
                    $row['section_title'] = 'Role';

                    if($row->alias=='admin'){
                        $row['login_user'] = 'Admin';
                    }

                    return view('admin.common.action-buttons', $row);
                })
                ->rawColumns(['access_rights'])
                ->make(true);
        }

        return view('admin.role.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id){
        $role = Role::findOrFail($id);
        return view('admin.common.show_modal', [
            'section_info' => $role->toArray(),
            'type' => 'Role',
            'required_columns' => ['id', 'name', 'access_rights', 'status']
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id){
        $data['menu'] = 'Roles';
        $data['role'] = Role::where('id',$id)->first();
        return view('admin.role.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, string $id){
        if($id==1){
            \Session::flash('danger','There is no possibility of editing the admin role!');
            return redirect()->route('roles.index');
        }

        $input = $request->all();
        $input['access_rights'] = json_encode($request->access_rights);
        $role = Role::findorFail($id);
        $role->update($input);
        
        \Session::flash('success','Role has been updated successfully!');
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id){
        //
    }
}
