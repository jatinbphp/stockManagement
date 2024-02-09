<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['menu'] = 'Contact Us';
        if ($request->ajax()) {

            $cms = ContactUs::all();
            return Datatables::of($cms)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $row['section_name'] = 'contactus';
                    $row['section_title'] = 'Contact Us';
                    return view('admin.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.contactus.index', $data);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contactus = ContactUs::findOrFail($id);
        if(!empty($contactus)){            
            $contactus->delete();
            return 1;
        }else{
            return 0;
        }
    }
}
