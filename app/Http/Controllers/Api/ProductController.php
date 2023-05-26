<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class ProductController extends BaseController
{
    public function index(){
        $product = Product::all();

        return $this->sendResponse(ProductResource::collection($product),'Product list');
    }


    /**
     * store
     * create a new product
     * @param  mixed $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
     $validate = Validator::make($request->all(),[
        'name' => 'required',
        'description' => 'required',
     ]);
     if($validate->fails()){
        return $this->sendError('validate error',$validate->errors());
     }
     $product = Product::create([
        'name' => $request->name,
        'description' => $request->description,
     ]);
     return $this->sendResponse(new ProductResource($product),'product created successfully');
    }

    /**
     * show
     *
     * @param  mixed $id
     */
    public function show($id)
    {
        $product = Product::find($id);

        if(is_null($product)){
            return $this->sendError('Product not found');
        }

        return $this->sendResponse(new ProductResource($product),'product retrieved');
    }


    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation failed', $validator->errors());
        }

        $product->update($request->all());
        return $this->sendResponse(new ProductResource($product),'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return $this->sendResponse(new ProductResource($product),'Product deleted successfully');
    }







}
