<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Options;
use App\Models\OptionsValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Http\Requests\OptionRequest;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['menu'] = 'Product Options';
        if ($request->ajax()) {
            return Datatables::of(Options::orderBy('name','ASC')->get())
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $row['table_name'] = 'options';
                    return view('admin.status-buttons', $row);
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'options';
                    $row['section_title'] = 'Option';
                    return view('admin.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.option.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['menu'] = 'Product Options';
        return view("admin.option.create",$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OptionRequest $request)
    {
        $input = $request->all();
        $option = Options::create($input);

        if(!empty($input['option_values']) && !empty($option)){
            foreach ($input['option_values'] as $key => $value) {

                $inputOptionsValue = [
                    'option_id' => $option->id,
                    'value' => $value,
                ];            
                OptionsValue::create($inputOptionsValue);
            }            
        }

        \Session::flash('success', 'Option has been inserted successfully!');
        return redirect()->route('options.index');
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
    public function edit(string $id)
    {        
        $data['menu'] = 'Product Options';
        $data['option'] = Options::with('option_values')->where('id',$id)->first();
        return view('admin.option.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OptionRequest $request, string $id)
    {
        $input = $request->all();
        $option = Options::findorFail($id);
        $option->update($input);

        if(!empty($input['option_values']) && !empty($option)){
            foreach ($input['option_values'] as $key => $value) {

                $option_value = OptionsValue::where('id',$key)->where('option_id', $option->id)->first();

                if(!empty($option_value)){
                    $option_value->update([
                        'value' => $value,
                    ]);
                } else {
                    $inputOptionsValue = [
                        'option_id' => $option->id,
                        'value' => $value,
                    ];            
                    OptionsValue::create($inputOptionsValue);
                }
            }            
        }

        \Session::flash('success','Option has been updated successfully!');
        return redirect()->route('options.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $option = Options::findOrFail($id);
        if(!empty($option)){
            $option->delete();
            return 1;
        }else{
            return 0;
        }
    }
    
    public function removeOptionValues(Request $request)
    {
        $option_values = OptionsValue::findOrFail($request['id']);
        if(!empty($option_values)){
            $option_values->delete();
            return 1;
        }else{
            return 0;
        }
    }
}
