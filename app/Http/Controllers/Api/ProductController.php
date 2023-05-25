<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function index(){
        $product = Product::all();

        return $this->sendResponse($product->toArray(),'Product list');
    }
}
