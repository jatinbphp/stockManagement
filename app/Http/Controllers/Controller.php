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

    public function statusArray(){
        $status = [
            'newone' => '<span class="badge badge-secondary">Displayed</span>',
            'open' => '<span class="badge badge-primary">Dispatched</span>',
            'incomplete'  => '<span class="badge badge-warning">Order Received Incomplete</span>',
            'completed'=> '<span class="badge badge-success">Order Received Complete</span>',
        ];
        return $status;
    }

    public function getStatus($oStatus){
        $status = 'Displayed';
        if($oStatus == 'open'){
            $status = 'Dispatched';
        }elseif($oStatus == 'incomplete'){
            $status = 'Order Received Complete';
        }elseif($oStatus == 'incomplete'){
            $status = 'Order Received Complete';
        }elseif($oStatus == 'completed'){
            $status = 'Order Received Incomplete';
        }

        return $status;
    }
}
