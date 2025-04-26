<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'No products found...!!!',
            ], 404);
        }
        else{
            return response()->json($products);
        }
    }

    public function show($id){
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }
        else{
            return response()->json($product, 200);
        }
    }

    public function store(Request $request){
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->save();
        return response()->json([
            'message' => 'Product created successfully...!!!',
            'product' => $product
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'This product not found...!!!'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'stock' => 'sometimes|integer'
        ]);

        $product->update($validated);

        return response()->json([
            'message' => 'Product updated successfully...!!!',
            'product' => $product
        ], 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found...!!!'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully...!!!']);
    }
}
