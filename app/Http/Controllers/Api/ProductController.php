<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
    public function index()
    {
        $products = Product::all();
        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [

            'product_name' => 'required',
            'product_description' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors());
        }

        $product = Product::create($request->all());
        return $this->sendResponse(new ProductResource($product), 'Product created successfully');
    }


    public function show($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found');
        }
        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully');
    }


    public function update(Request $request, Product $product)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [

            'product_name' => 'required',
            'product_description' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors());
        }

        $product->update($request->all());
        return $this->sendResponse(new ProductResource($product), 'Product updated successfully');
    }


    public function destroy(Product $product)
    {
        $product->delete();
        return $this->sendResponse(new ProductResource($product), 'Product deleted successfully');
    }
}
