<?php

namespace App\Repository;

use App\Models\Product;
use stdClass;

class  ProductRepository implements ProductRepositoryInterface
{
    public function save(array $request)
    {
        $res = new stdClass;
        try{
            $fileName = null;
            if(isset($request['image'])){
                if(file_exists('products/'.$request['image'])){
                    unlink('products/'.$request['image']);
                }
                $fileName =  time().'.'.$request['image']->getClientOriginalName();
                request()->image->move(public_path('products'), $fileName);
            }

            $product = new Product();
            $product->title = $request['title'];
            $product->description = $request['description'];
            $product->price = $request['price'];
            $product->image = $fileName;
            $product->save();
            
            $res->message = "Product added successfully";
            $res->status = 201;
        }catch(\Exception $e){
            $res->message = "Product added fail";
            $res->status = 422;
        }
        return $res;
    }

    public function update(array $request)
    {
        $res = new stdClass;
        try{
            $product = Product::find($request['id']);
            $fileName = $product->image;
            if(isset($request['image'])){
                if(file_exists('products/'.$product->image)){
                    unlink('products/'.$product->image);
                }

                $fileName =  time().'.'.$request['image']->getClientOriginalName();
                request()->image->move(public_path('products'), $fileName);
            }

            
            $product->title = $request['title'];
            $product->description = $request['description'];
            $product->price = $request['price'];
            $product->image = $fileName;
            $product->save();
            
            $res->message = "Product updated successfully";
            $res->status = 200;
        }catch(\Exception $e){
            $res->message = "Product updated fail";
            $res->status = 422;
        }
        return $res;
    }

    public function delete($id)
    {
        $res = new stdClass;
        try{
            $product = Product::find($id);
            $product->delete();

            $res->message = "Product deleted successfully";
            $res->status = 200;
        }catch(\Exception $e){
            $res->message = "Product deleted fail";
            $res->status = 422;
        }
        return $res;
    }

    public function products()
    {
        $res = new stdClass;
        try{
            $products= Product::get();

            $res->products = $products;
            $res->status = 200;
        }catch(\Exception $e){
            $res->message = "Something went wrong";
            $res->status = 422;
        }
        return $res;
    }

    public function product($id)
    {
        $res = new stdClass;
        try{
            $product = Product::find($id);

            $res->product = $product;
            $res->status = 200;
        }catch(\Exception $e){
            $res->message = "Something went wrong";
            $res->status = 422;
        }
        return $res;
    }
}