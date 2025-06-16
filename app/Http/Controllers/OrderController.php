<?php

namespace App\Http\Controllers;

use App\Models\CartItems;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)->with('product')->get();
        return view('order.index', ['orderItems' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        // im basically moving all the items in cart to order table. Reason is because no payment gateway involved
        $items = CartItems::where('user_id', $user->id)->get();
        $ref_number = uniqid();
        foreach ($items as $item) {
            Order::create([
                'user_id' => $item->user_id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'transaction_id' => $ref_number
            ]);
        }

        // thereafter i  empty the cart
        CartItems::where('user_id', $user->id)->delete();

        $orders = Order::where('user_id', $user->id)->with('product')->latest()->get();
        return view('order.index', ['orderItems' => $orders]);
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
