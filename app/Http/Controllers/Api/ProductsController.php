<?php

namespace App\Http\Controllers\Api;

use App\Models\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsResource;

use Illuminate\Http\Request;

class ProductsController extends Controller {
    public function index() {
        $products = Products::latest()->paginate(5);

        return new ProductsResource(true, 'List Data Products', $products);
    }
}
