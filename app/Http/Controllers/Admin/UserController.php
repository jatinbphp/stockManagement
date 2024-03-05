<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use App\Models\Practice;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('auth');
        $this->middleware('accessright:users');
    }

    public function index(Request $request){
        $data['menu'] = 'Users';
        if ($request->ajax()) {
            return Datatables::of(User::with('role')->where('role', '!=', 'super_admin'))
                ->addIndexColumn()
                ->editColumn('created_at', function($row) {
                    return date("Y-m-d H:i:s", strtotime($row->created_at)); 
                })
                ->editColumn('image', function($row){
                    if (!empty($row['image']) && file_exists($row['image'])) {
                        return url($row['image']);
                    } else {
                        return url('assets/admin/dist/img/no-image.png');
                    }
                })
                ->editColumn('status', function($row){
                    $row['table_name'] = 'users';
                    return view('admin.common.status-buttons', $row);
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'users';
                    $row['section_title'] = 'User';
                    return view('admin.common.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.user.index', $data);
    }

    public function create(){
        $data['menu'] = 'Users';
        $data['practice_ids'] = [];
        $data['practice'] = Practice::where('status', 'active')->orderBy('name', 'ASC')->get()->pluck('full_name', 'id');
        return view("admin.user.create",$data);
    }

    public function store(UserRequest $request){
        $input = $request->all();
        if($file = $request->file('image')){
            $input['image'] = $this->fileMove($file,'users');
        }

        if(!empty($input['practice_ids'])){
            $input['practice_ids'] = implode(",", $input['practice_ids']);
        }

        $user = User::create($input);

        \Session::flash('success', 'User has been inserted successfully!');
        return redirect()->route('users.index');
    }

    public function show($id){
        $user = User::findOrFail($id);
        
        return view('admin.common.show_modal', [
            'section_info' => $user->toArray(),
            'type' => 'User',
            'required_columns' => ['id', 'image', 'name', 'email', 'role', 'email', 'phone', 'status', 'created_at']
        ]);
    }

    public function edit($id){
        $data['menu'] = 'Users';
        $data['user'] = User::where('id',$id)->first();
        $data['practice'] = Practice::where('status', 'active')->orderBy('name', 'ASC')->get()->pluck('full_name', 'id');
        $data['practice_ids'] = !empty($data['user']['practice_ids']) ? explode(",", $data['user']['practice_ids']) : [];
        return view('admin.user.edit',$data);
    }

    public function update(UserRequest $request, $id){
        if(empty($request['password'])){
            unset($request['password']);
        }
        $input = $request->all();

        if(!empty($input['practice_ids'])){
            $input['practice_ids'] = implode(",", $input['practice_ids']);
        }

        $user = User::findorFail($id);

        if($file = $request->file('image')){
            if (!empty($user['image']) && file_exists($user['image'])) {
                @unlink($user['image']);
            }
            $input['image'] = $this->fileMove($file,'users');
        }
        $user->update($input);

        \Session::flash('success','User has been updated successfully!');
        return redirect()->route('users.index');
    }

    public function destroy($id){
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
