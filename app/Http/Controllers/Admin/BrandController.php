<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Http\Requests\BrandRequest;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        //return Brand::with('supplier')->get();
        $data['menu'] = 'Brands';
        if ($request->ajax()) {
            return Datatables::of(Brand::with('supplier')->get())
                ->addIndexColumn()   
                ->addColumn('created_at', function($row) {
                    return date("Y-m-d H:i:s", strtotime($row->created_at)); 
                })             
                ->addColumn('image', function($row){
                    return $this->getImageUrl($row['image']);
                })
                ->editColumn('status', function($row){
                    $row['table_name'] = 'brands';
                    return view('admin.status-buttons', $row);
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'brands';
                    $row['section_title'] = 'Brand';
                    return view('admin.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.brand.index', $data);
    }

    public function create(){
        $data['menu'] = 'Brands';
        $data['supplier']  = Supplier::where('status', 'active')->get()->pluck('full_name', 'id');
        return view("admin.brand.create",$data);
    }

    public function store(BrandRequest $request){
        $input   = $request->all();

        if($file = $request->file('image')){
            $input['image'] = $this->fileMove($file,'brands');
        }

        Brand::create($input);

        \Session::flash('success', 'Brand has been inserted successfully!');
        
        return redirect()->route('brands.index');
    }

    public function show($id)
    {
        $brand = Brand::with('supplier')->findOrFail($id);
        
        return view('admin.show_modal', [
            'section_info' => $brand->toArray(),
            'type' => 'Brand',
            'required_columns' => ['id', 'image', 'name', 'supplier', 'status', 'created_at']
        ]);
    }

    public function edit(string $id){        
        $data['menu'] = 'Brands';
        $data['supplier'] = Supplier::where('status', 'active')->get()->pluck('full_name', 'id');
        $data['brand'] = Brand::where('id',$id)->first();
        return view('admin.brand.edit',$data);
    }

    public function update(BrandRequest $request, string $id){
        $input = $request->all();
        $brand = Brand::findorFail($id);
        if($file = $request->file('image')){
            if (!empty($brand['image']) && file_exists($brand['image'])) {
                unlink($brand['image']);
            }
            $input['image'] = $this->fileMove($file,'brands');
        }
        $brand->update($input);
        \Session::flash('success','Brand has been updated successfully!');
        return redirect()->route('brands.index');
    }

    public function destroy(string $id){
        $brand = Brand::findOrFail($id);
        if(!empty($brand)){
            if (!empty($brand['image']) && file_exists($brand['image'])) {
                unlink($brand['image']);
            }
            $brand->delete();
            return 1;
        }else{  
            return 0;
        }
    }

    public function getImageUrl($image)
    {
        if (!empty($image) && file_exists($image)) {
            return url($image);
        } else {
            return url('uploads/default-image.jpeg');
        }
    }
}
