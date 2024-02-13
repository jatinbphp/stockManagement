<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Practice;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\PracticeRequest;

class PracticeController extends Controller
{
    public function index(Request $request)
    {
        $data['menu'] = 'Practices';
        if ($request->ajax()) {
            return DataTables::of(Practice::all())
                ->addIndexColumn()
                ->addColumn('created_at', function($row) {
                    return date("Y-m-d H:i:s", strtotime($row->created_at)); 
                })
                ->editColumn('status', function ($row) {
                    $row['table_name'] = 'practices';
                    return view('admin.status-buttons', $row);
                })
                ->addColumn('action', function ($row) {
                    $row['section_name'] = 'practices';
                    $row['section_title'] = 'Practice';
                    return view('admin.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.practice.index', $data);
    }

    public function create()
    {
        $data['menu'] = 'Practices';
        return view('admin.practice.create', $data);
    }

    public function store(PracticeRequest $request)
    {
        $input = $request->all();
        Practice::create($input);
        \Session::flash('success', 'Practice has been inserted successfully!');
        return redirect()->route('practices.index');
    }

    public function show($id)
    {
        $data['section_info'] = Practice::find($id)->toArray();
        $data['type'] = "Practice";
        $data['required_columns'] = ['id', 'name', 'manager_name', 'address', 'email', 'telephone', 'status', 'created_at'];
        return view('admin.show_modal', $data);
    }

    public function edit(string $id)
    {
        $data['menu'] = 'Practices';
        $data['practice'] = Practice::findOrFail($id);
        return view('admin.practice.edit', $data);
    }

    public function update(PracticeRequest $request, string $id)
    {
        $input = $request->all();
        $practice = Practice::findOrFail($id);
        $practice->update($input);
        \Session::flash('success', 'Practice has been updated successfully!');
        return redirect()->route('practices.index');
    }

    public function destroy(string $id)
    {
        $practice = Practice::findOrFail($id);
        if (!empty($practice)) {
            $practice->delete();
            return 1;
        } else {
            return 0;
        }
    }
}
