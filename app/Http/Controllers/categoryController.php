<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use App\Models\ProductCategories;

class categoryController extends Controller
{

    public function index(){
        return ProductCategories::get();
    }

    public function store(Request $request){
        $rules = [
            'category' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response('validate error',200);
        }

        $category = new ProductCategories;
        $category->category = $request->category;
        $category->save();

        return response('category created successfully',200);
    }
}
