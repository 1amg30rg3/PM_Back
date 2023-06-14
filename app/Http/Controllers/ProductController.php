<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use DB;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\ProductPictures;
use App\Models\ProductCategories;

class ProductController extends Controller
{
    /**
     * Display a listing of the Products.
     */
    public function index()
    {
        $products = Products::leftJoin('product_pictures', 'products.id', '=', 'product_pictures.product_id')
                            ->select('products.*', 'product_pictures.path')
                            ->get();

        return response(['products'=>$products], 200);
    }

    /**
     * Function for stroing a new Product.
     */
    public function store(Request $request)
    {   
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category' => 'required',
        ];

  
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response('validate error',200);
        }


        $product = new Products;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category = json_encode($request->category);
        $product->save();


        $product_id = $product->id;

        $pictures = $request->file('file'); 

       

        if (!empty($pictures)) {
            $paths = [];
            foreach ($pictures as $picture) {
                $filename = time() . '_' . uniqid() . '.' . $picture->getClientOriginalExtension();
                $picture->move(public_path('uploads/'.$product_id), $filename);
                $paths[] = 'uploads/' . $product_id . '/' . $filename;
            }

            $product_picture = new ProductPictures;
            $product_picture->product_id = $product_id;
            $product_picture->path = json_encode($paths);
            $product_picture->save();
        }

        return response('product created successfully',200);
    }


    /**
     * Function for displaying Product by id.
     */
    public function show(string $id)
    {
        $products = Products::leftJoin('product_pictures', 'products.id', '=', 'product_pictures.product_id')
                            ->where('products.id','=',$id)
                            ->select('products.*', 'product_pictures.path')
                            ->get();

        return response(['products'=>$products], 200);
    }

    /**
     * Function for destroy Product by id.
     */
    public function destroy(string $id)
    {
        $product = Products::find($id);
        if ( $product ) $product->delete();

        $product_picture = ProductPictures::where('product_id','=',$id)->first();
        if ( $product_picture ) {
            $folderPath = public_path('uploads/' . $id);

            if (File::exists($folderPath)) {
                File::deleteDirectory($folderPath);
            }
            
            $product_picture->delete();
        }

        return response('product destroyed', 200);
    }
}
