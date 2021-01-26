<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Product;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productRepo;
    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function save(ProductStoreRequest $request)
    {
        $response = $this->productRepo->save($request->all());
        return response()->json(['message'=>$response->message], $response->status);
    }

    public function update(ProductStoreRequest $request)
    {   
        $response = $this->productRepo->update($request->all());
        return response()->json(['message'=>$response->message], $response->status);
    }

    public function delete($id)
    {   
        $response = $this->productRepo->delete($id);
        return response()->json(['message'=>$response->message], $response->status);
    }

    public function products()
    {   
        $response = $this->productRepo->products();
        return response()->json(['products'=>$response->products], $response->status);
    }

    public function product($id)
    {   
        $response = $this->productRepo->product($id);
        return response()->json(['product'=>$response->product], $response->status);
    }
    
}
