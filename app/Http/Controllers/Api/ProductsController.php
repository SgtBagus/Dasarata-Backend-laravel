<?php

namespace App\Http\Controllers\Api;

use App\Models\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller {
    public function index() {
        $products = Products::latest()->paginate(5);

        return new ProductsResource(true, 'Success Get List Data Products', $products);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'attachement'   => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'price'         => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $attachement = $request->file('attachement');
        $attachement->storeAs('public/products', $attachement->hashName());

        $products = Products::create([
            'name'          => $request->name,
            'attachement'   => asset('storage/products/' . $attachement->hashName()),
            'desc'          => $request->desc,
            'price'         => $request->price,
        ]);

        return new ProductsResource(true, 'Success Create Products', $products);
    }

    public function show($id) {
        $products = Products::find($id);

        return new ProductsResource(true, 'Success Get Detail Data Products!', $products);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'price'         => 'required',
            'attachement'   => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $products = Products::find($id);

        if ($request->hasFile('attachement')) {
            $attachement = $request->file('attachement');
            $attachement->storeAs('public/products', $attachement->hashName());

            Storage::delete('public/products/'.basename($products->attachement));

            $products->update([
                'name'          => $request->name,
                'attachement'   => asset('storage/products/' . $attachement->hashName()),
                'desc'          => $request->desc,
                'price'         => $request->price,
            ]);
        } else {
            $products->update([
                'name'          => $request->name,
                'desc'          => $request->desc,
                'price'         => $request->price,
            ]);
        }

        return new ProductsResource(true, 'Success Update Products', $products);
    }

    public function destroy($id) {
        $products = Products::find($id);
        Storage::delete('public/posts/'.basename($products->image));
        $products->delete();
        return new ProductsResource(true, 'Success Delete Products', null);
    }
}
