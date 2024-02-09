<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\ContentManagement;
use App\Http\Requests\ContentManagementRequest;

class ContentManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['menu'] = 'Content Management';
        if ($request->ajax()) {

            $cms = ContentManagement::all();
            return Datatables::of($cms)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $row['section_name'] = 'content';
                    $row['section_title'] = 'Content';
                    return view('admin.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.content.index', $data);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['menu']="Content Management";
        $data['content'] = ContentManagement::findorFail($id);
        return view('admin.content.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContentManagementRequest $request, $id)
    {
        $input = $request->all();
        $content = ContentManagement::findorFail($id);
        $content->update($input);

        \Session::flash('success','Content has been updated successfully!');
        return redirect()->route('content.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
