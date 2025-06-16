<?php

namespace App\Http\Controllers;

use App\Models\CartItems;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('product')->get();

        return view('cart.index', ['cartItems' => $cartItems]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Product $product, Request $request)
    {
        $request->validate([
            'cart_quantity' => 'required|numeric'
        ]);
        $userId = auth()->user()->id;
        $data = [
            'user_id' => $userId,
            'product_id' => $product->id,
            'quantity' => $request->cart_quantity,
            'price' => $product->price
        ];

        // check if the user already added this product to cart, if yes increase quantity else create a new record
        // Check if item is already in cart
        $cartExist = CartItems::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($cartExist) {
            $cartExist->quantity += $request->cart_quantity;

            // update the price in case admin has changed the price
            $cartExist->price = $product->price;
            $cartExist->save();
            return redirect()->back()->with(['message' => 'Cart updated successfully']);
        }

        CartItems::create($data);

        return redirect()->back()->with(['message' => 'Item added successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItems $cart)
    {
        // check if the cart user_id is really the loged in user_id to mitigate fraud
        if (auth()->id() === $cart->user_id) {
            $cart->delete();
            return redirect()->back()->with(['message' => 'Item deleted']);
        } else {
            return redirect()->back()->with(['error' => 'You are attempting a wrong page']);
        }
    }

    // function to increase or decrease cart item quantity depending on the action
    public function updateQTY(Request $request, CartItems $cart)
    {
        $action = $request->input('action');
        Log::info('action is' . $action);
        if ($action === 'increase') {
            $cart->quantity++;
        } elseif ($action === 'decrease' && $cart->quantity > 1) {
            $cart->quantity--;
        }

        $cart->save();

        $cartTotal = CartItems::where('user_id', auth()->id())
            ->with('product')
            ->get()
            ->sum(fn($i) => $i->quantity * $i->product->price);
        $subTotal = $cart->quantity * $cart->price;
        return response()->json([
            'newQty' => $cart->quantity,
            'itemId' => $cart->id,
            'cartTotal' => number_format($cartTotal, 2),
            'subTotal' => number_format($subTotal, 2)
        ]);
    }
}
