<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // if there is a search request
        if ($request->search) {
            $validatedSearch = $request->validate([
                'search' => ['string']
            ]);
            $searchQuery = $validatedSearch['search'];
            $product = Product::where('name', 'like', '%' . $searchQuery . '%')->orWhere('description',  'like', '%' . $searchQuery . '%')->get();

            return view('products.index', ['products' => $product]);
        }
        $product = Product::get();

        return view('products.index', ['products' => $product]);
    }

    public function show(Product $product)
    {
        return view('products.details', ['product' => $product]);
    }
}
