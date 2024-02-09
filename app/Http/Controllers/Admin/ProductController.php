<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\ProductsOptions;
use App\Models\ProductsOptionsValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductImportRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['menu'] = 'Products';
        if ($request->ajax()) {
            return Datatables::of(Products::orderBy('product_name','ASC')->get())
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $row['table_name'] = 'products';
                    return view('admin.status-buttons', $row);
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'products';
                    $row['section_title'] = 'Product';
                    return view('admin.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['menu'] = 'Products';
        $data['categories'] = $this->getCategories();
        $data['product_options'] = [];
        return view("admin.product.create",$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $product = Products::create($input);

        /*if ($request->hasFile('file')) {
            foreach ($request->file('file') as $image) {

                $imageName = $this->fileMove($image,'products');
                ProductImages::create([
                    'product_id' => $product->id,
                    'image' =>  $imageName,
                ]);
            }
        }

        // options & options values
        if(!empty($input['options'])){
            $this->addProductOptionAddUpdate($input, $product->id);
        }*/

        \Session::flash('success', 'Product has been inserted successfully! Please add product images, options and options values.');
        return redirect()->route('products.edit', ['product' => $product->id]);
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
        $data['menu'] = 'Products';
        $data['product'] = Products::with('product_images')->where('id',$id)->first();
        $data['categories'] = $this->getCategories();
        $data['product_options'] = ProductsOptions::with('product_option_values')->where('product_id',$id)->where('status','active')->get();
        return view('admin.product.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $input = $request->all();
        $product = Products::findorFail($id);
        $product->update($input);

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $image) {

                $imageName = $this->fileMove($image,'products');
                ProductImages::create([
                    'product_id' => $id,
                    'image' =>  $imageName,
                ]);
            }
        }

        // options & options values
        if(!empty($input['options'])){
            $this->addProductOptionAddUpdate($input, $id);
        }

        \Session::flash('success','Product has been updated successfully!');
        return redirect()->route('products.index');
    }

    public function addProductOptionAddUpdate($input, $product_id)
    {
        $option_ids = [];
        $option_values_ids = [];
        if(!empty($input['options']['old'])){
            foreach ($input['options']['old'] as $key => $value) {
                $optionOld = ProductsOptions::where('id',$key)->where('product_id',$product_id)->first();
                $inputOption = [
                    'product_id' => $product_id,
                    'option_name' => $value
                ];
                $optionOld->update($inputOption);

                $option_ids[] = $optionOld->id;

                if(!empty($input['option_values']['old'][$key])){
                    foreach ($input['option_values']['old'][$key] as $oKey => $oValue) {

                        $option_value = ProductsOptionsValues::where('id',$oKey)->where('option_id',$optionOld->id)->where('product_id',$product_id)->first();
                        $inputOptionValues = [
                            'product_id' => $product_id,
                            'option_id' => $optionOld->id,
                            'option_value' => $oValue,
                            'option_price' => $input['option_price']['old'][$key][$oKey],
                        ];

                        if(empty($option_value)){
                            $option_new_value = ProductsOptionsValues::create($inputOptionValues);

                            $option_values_ids[] = $option_new_value->id;
                        } else {
                            $option_value->update($inputOptionValues);

                            $option_values_ids[] = $option_value->id;
                        }
                    }
                }

                if(!empty($input['option_values']['new'][$key])){
                    foreach ($input['option_values']['new'][$key] as $oKey => $oValue) {
                        $inputOptionValues = [
                            'product_id' => $product_id,
                            'option_id' => $optionOld->id,
                            'option_value' => $oValue,
                            'option_price' => $input['option_price']['new'][$key][$oKey],
                        ];
                        $option_new_value = ProductsOptionsValues::create($inputOptionValues);

                        $option_values_ids[] = $option_new_value->id;
                    }
                }
            }

            if(count($option_ids)>0){
                ProductsOptions::whereNotIn('id', $option_ids)->where('product_id', $product_id)->delete();
                ProductsOptionsValues::whereNotIn('option_id', $option_ids)->where('product_id', $product_id)->delete();
            }

            if(count($option_values_ids)>0){
                ProductsOptionsValues::whereNotIn('id', $option_values_ids)->where('product_id', $product_id)->delete();
            }
        }
        
        if(!empty($input['options']['new'])){
            foreach ($input['options']['new'] as $key => $value) {

                $inputOption = [
                    'product_id' => $product_id,
                    'option_name' => $value
                ];
                $optionNew = ProductsOptions::create($inputOption);

                if(!empty($input['option_values']['new'][$key])){
                    foreach ($input['option_values']['new'][$key] as $oKey => $oValue) {
                        $inputOptionValues = [
                            'product_id' => $product_id,
                            'option_id' => $optionNew->id,
                            'option_value' => $oValue,
                            'option_price' => $input['option_price']['new'][$key][$oKey],
                        ];
                        ProductsOptionsValues::create($inputOptionValues);
                    }
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $products = Products::findOrFail($id);
        if(!empty($products)){
            if (!empty($products['image']) && file_exists($products['image'])) {
                unlink($products['image']);
            }
            $products->delete();
            return 1;
        }else{
            return 0;
        }
    }

    public function removeImage(Request $request)
    {
        $option_values = ProductImages::findOrFail($request['id']);
        if(!empty($option_values)){
            unlink($request['img_name']);
            $option_values->delete();
            return 1;
        }else{
            return 0;
        }
    }

    public function importProduct()
    {
        $data['menu'] = 'Products';        
        return view("admin.product.import",$data);
    }

    public function importProductStore(ProductImportRequest $request)
    {
        
        $file = $request->file('file');
        $csvFile = $this->fileMove($file,'product-csv');

        if (($handle = fopen($csvFile, 'r')) !== false) {
            // Read the header row
            $header = fgetcsv($handle);

            // Process each row
            while (($row = fgetcsv($handle)) !== false) {
                $data = array_combine($header, $row);

                if(!empty($data['CATEGORY_NAME']) && !empty($data['PRODUCT_NAME']) && !empty($data['SKU']) && !empty($data['DESCRIPTION']) && !empty($data['PRICE']) && !empty($data['STATUS'])){
                    $categoryName = $data['CATEGORY_NAME'];

                    // check Category
                    $category = Category::where('name',$categoryName)->first();
                    if(empty($category)){
                        $inputCategory = [
                            'user_id' => Auth::user()->id,
                            'name' => $categoryName,
                        ];
                        $category = Category::create($inputCategory);
                    }

                    // check Product
                    $product = Products::where('sku',$data['SKU'])->first();
                    $inputProduct = [
                        'user_id' => Auth::user()->id,
                        'category_id' => $category->id,
                        'sku' => $data['SKU'],
                        'product_name' => $data['PRODUCT_NAME'],
                        'description' => $data['DESCRIPTION'],
                        'price' => (is_numeric($data['PRICE'])) ? $data['PRICE'] : 0,
                        'status' => $data['STATUS'],
                    ];
                    if(empty($product)){
                        $product = Products::create($inputProduct);
                    } else {
                        $product->update($inputProduct);
                    }

                    // check product image
                    if(!empty($data['PRODUCT_IMAGES'])){
                        foreach (explode(",", $data['PRODUCT_IMAGES']) as $key => $value) {
                            $productsImage = ProductImages::where('image','uploads/products/'.trim($value))->where('product_id',$product->id)->first();

                            if(empty($productsImage)){
                                ProductImages::create([
                                    'product_id' => $product->id,
                                    'image' =>  'uploads/products/'.trim($value),
                                ]);
                            }
                        }
                    }
                }
            }
            fclose($handle);
        }

        \Session::flash('success', 'Product has been imported successfully!');
        return redirect()->route('products.index');
    }

    public function getOptions(Request $request)
    {
        $data['product_options'] = [];
        if(!empty($request->product_id)){
            $data['product_options'] = ProductsOptions::with('product_option_values')->where('product_id',$request->product_id)->where('status','active')->get();
        }
        return view('admin.order.product-options', $data);
    }
}
