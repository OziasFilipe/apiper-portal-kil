<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('status')) {
            $query->where('status', $request->boolean('status'));
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->paginate(15);

        return $this->success($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'category' => 'nullable|string|max:100',
            'status' => 'boolean',
            'image' => 'nullable|string',
        ]);

        $product = Product::create($validated);

        return $this->success($product, 'Product created successfully', 201);
    }

    public function show(Product $product)
    {
        return $this->success($product->load('services'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'category' => 'nullable|string|max:100',
            'status' => 'sometimes|boolean',
            'image' => 'nullable|string',
        ]);

        $product->update($validated);

        return $this->success($product, 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return $this->success(null, 'Product deleted successfully');
    }
}
