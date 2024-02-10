<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Http\Requests\BrandRequest;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $data['menu'] = 'Brand';
        if ($request->ajax()) {
            return Datatables::of(Brand::all())
                ->addIndexColumn()
                ->addColumn('image', function($row){
                    if (!empty($row['image']) && file_exists($row['image'])) {
                        return url($row['image']);
                    } else {
                        return url('uploads/brands/default-brand-image.jpeg');
                    }
                })
                ->addColumn('status', function($row){
                    $row['table_name'] = 'brands';
                    return view('admin.status-buttons', $row);
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'brand';
                    $row['section_title'] = 'Brand';
                    return view('admin.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.brand.index', $data);
    }

    public function create(){
        $data['menu'] = 'Brand';
        return view("admin.brand.create",$data);
    }

    public function store(BrandRequest $request){
        $input   = $request->all();
        if($file = $request->file('image')){
            $input['image'] = $this->fileMove($file,'brands');
        }
        Brand::create($input);
        \Session::flash('success', 'Brand has been inserted successfully!');
        return redirect()->route('brand.index');
    }

    public function edit(string $id){        
        $data['menu']       = 'Brand';
        $data['brand']      = Brand::where('id',$id)->first();
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
        return redirect()->route('brand.index');
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
}
