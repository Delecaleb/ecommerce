<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index()
    {
        $product = Product::latest()->paginate(20);

        return view('admin.products.index', ['products' => $product]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'description' => 'required|string',
                'image' => 'required|mimes:png,jpg,jpeg|max:10000'
            ]
        );

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = $path;
        }

        Product::create($data);

        $product = Product::latest()->paginate(20);

        return view('admin.products.index', ['products' => $product, 'message' => 'New product added successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', ['product' => $product]);
    }

    public function update(Product $product, Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:200',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'mimes:png,jpg,jpeg|max:10000'
            // 'category_id' => 'numeric|exists:category,id'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            Storage::disk('public')->delete($product->image_url);
            $validatedData['image_url'] = $path;
        }

        $product->update($validatedData);
        return  redirect()->route('product.index')->with(['message' => 'Product updated successfully']);
    }

    public function destroy(Product $product)
    {
        Storage::disk('public')->delete($product->image_url);

        $product->delete();

        $product = Product::latest()->paginate(20);

        return redirect()->route('product.index')->with(['message' => 'Product deleted successfully']);
    }
}
