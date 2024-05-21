<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;



class ProductController extends Controller
{
    public function index(){
       $product = Product::all();

       return response()->json([
        'message'=>count($product).'product found',
        'data'=>$product,
        'status'=>true
       ]);
    }

    //show the data
    public function show($id){
        $product=Product::find($id);
        if($product !=null){
            return response()->json([
                'message'=>'Record found',
                'data'=>$product,
                'status'=>true
            ],200);
        }else{
            return response()->json([
                'message'=>'Record not found',
                'data'=>[],
                'status'=>true
            ],200);
        }
    }

    //store the data
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required'  
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please fix the error',
                'errors' => $validator->errors(),
                'status' => false
            ], 200);  
        }
    
        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();
    
        return response()->json([
            'message' => 'Product added successfully',
            'product' => $product, 
            'status' => true
        ], 201);  
    }
 
    
    //update the data

    public function update(Request $request,$id){
        $product=Product::find($id);

        if($product==null){
            return response()->json([
                'message' => 'Product not found', 
                'status' => true
            ], 200);  
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required'  
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please fix the error',
                'errors' => $validator->errors(),
                'status' => false
            ], 200);  
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();
        
        return response()->json([
            'message' => 'Product updated successfully', 
            'status' => true
        ], 200);  
    }

    public function delete(Request $request,$id){
        $product=Product::find($id);

        if($product==null){
            return response()->json([
                'message' => 'Product not found', 
                'status' => false
            ], 200);  
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully', 
            'status' => true
        ], 200);  
    }

  
}
 