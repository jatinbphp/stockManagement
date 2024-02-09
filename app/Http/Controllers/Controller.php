<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function fileMove($photo, $path){
        $root = 'uploads/'.$path;
        $name = Str::random(20).".".$photo->getClientOriginalExtension();
        if (!file_exists($root)) {
            mkdir($root, 0777, true);
        }
        $photo->move($root,$name);
        return 'uploads/'.$path."/".$name;
    }

    public function getCategories(){
        $results = DB::table('categories')
            ->select('categories.id', 'categories.name as category_name', 'parents.name as parent_name')
            ->leftJoin('categories as parents', 'categories.parent_category_id', '=', 'parents.id')
            ->where('categories.status', 'active')
            ->orderBy('categories.name', 'ASC')
            ->get();

        // Assuming you want to transform the results into the desired format
        $results = $results->map(function ($row) {
            $row->categoryName = !empty($row->parent_name) ? $row->parent_name . " -> " . $row->category_name : $row->category_name;
            return $row;
        });

        return $results;
    }
}
