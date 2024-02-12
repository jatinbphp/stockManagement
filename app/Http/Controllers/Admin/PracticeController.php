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
        $data['menu'] = 'Practice';
        if ($request->ajax()) {
            return DataTables::of(Practice::all())
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $row['table_name'] = 'practices';
                    return view('admin.status-buttons', $row);
                })
                ->addColumn('action', function ($row) {
                    $row['section_name'] = 'practice';
                    $row['section_title'] = 'Practice';
                    return view('admin.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.practice.index', $data);
    }

    public function create()
    {
        $data['menu'] = 'Practice';
        return view('admin.practice.create', $data);
    }

    public function store(PracticeRequest $request)
    {
        $input = $request->all();
        Practice::create($input);
        \Session::flash('success', 'Practice has been inserted successfully!');
        return redirect()->route('practice.index');
    }

    public function edit(string $id)
    {
        $data['menu'] = 'Practice';
        $data['practice'] = Practice::findOrFail($id);
        return view('admin.practice.edit', $data);
    }

    public function update(PracticeRequest $request, string $id)
    {
        $input = $request->all();
        $practice = Practice::findOrFail($id);
        $practice->update($input);
        \Session::flash('success', 'Practice has been updated successfully!');
        return redirect()->route('practice.index');
    }

    public function destroy(string $id)
    {
        $practice = Practice::findOrFail($id);
        if(!$practice){
            return response()->json(false);
        }

        $practice->delete();
        return response()->json(true);
    }
}
