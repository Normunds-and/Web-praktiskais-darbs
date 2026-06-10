<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->with('orderItems.product')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', __('Your cart is empty!'));
        }
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('orders.create', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_info' => 'required|string|max:255',
        ]);
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', __('Your cart is empty!'));
        }
        
        DB::transaction(function () use ($validated, $cart) {
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            
            $order = Order::create([
                'user_id' => auth()->id(),
                'bank_info' => $validated['bank_info'],
                'total_amount' => $total,
                'status' => 'pending',
            ]);
            
            foreach ($cart as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price_at_purchase' => $item['price'],
                ]);
                
                $product = Product::find($productId);
                $product->decrement('in_stock', $item['quantity']);
            }
        });
        
        session()->forget('cart');
        
        return redirect()->route('orders.index')->with('success', __('Order placed successfully!'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load('orderItems.product');
        return view('orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $this->authorize('update', $order);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);
        
        $order->update($validated);
        
        return redirect()->back()->with('success', __('Order status updated!'));
    }
}
