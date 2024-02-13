<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data['menu']  = 'Users';

        if ($request->ajax()) {

            $user = User::select()->where('role', '!=', 'admin');
        
            return Datatables::of($user)
                ->addIndexColumn()
                ->addColumn('created_at', function($row) {
                    return date("Y-m-d H:i:s", strtotime($row->created_at)); 
                })
                ->addColumn('image', function($row){
                    if (!empty($row['image']) && file_exists($row['image'])) {
                        return url($row['image']);
                    } else {
                        return url('uploads/users/user-default-image.png');
                    }
                })
                ->editColumn('status', function($row){
                    $row['table_name'] = 'users';
                    return view('admin.status-buttons', $row);
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'users';
                    $row['section_title'] = 'User';
                    return view('admin.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.user.index', $data);
    }

    public function create()
    {
        $data['menu'] = 'Users';
        return view("admin.user.create",$data);
    }

    public function store(UserRequest $request){
        $input = $request->all();
        if($file = $request->file('image')){
            $input['image'] = $this->fileMove($file,'users');
        }
        $user = User::create($input);

        \Session::flash('success', 'User has been inserted successfully!');
        return redirect()->route('users.index');
    }

    public function show($id)
    {
        $data['section_info'] = User::find($id)->toArray();
        $data['type'] = "User";
        $data['required_columns'] = ['id', 'image', 'name', 'email', 'role', 'email', 'phone', 'status', 'created_at'];
        return view('admin.show_modal', $data);
    }

    public function edit($id)
    {
        $data['menu']  = 'Users';
        $data['user'] = User::where('id',$id)->first();
        return view('admin.user.edit',$data);
    }

    public function update(UserRequest $request, $id)
    {
        if(empty($request['password'])){
            unset($request['password']);
        }
        $input = $request->all();
        $user = User::findorFail($id);

        if($file = $request->file('image')){
            if (!empty($user['image'])) {
                @unlink($user['image']);
            }
            $input['image'] = $this->fileMove($file,'users');
        }
        $user->update($input);

        \Session::flash('success','User has been updated successfully!');
        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $users = User::findOrFail($id);
        if(!empty($users)){
            if (!empty($users['image']) && file_exists($users['image'])) {
                unlink($users['image']);
            }
            $users->delete();
            return 1;
        }else{
            return 0;
        }
    }
}
