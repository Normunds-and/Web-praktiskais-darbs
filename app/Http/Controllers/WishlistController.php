<?php

namespace App\Http\Controllers;

use App\Models\WishlistItem;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = auth()->user()->wishlistItems()->with('product')->get();
        return view('wishlist.index', compact('wishlistItems'));
    }

    public function store(Product $product)
    {
        $exists = WishlistItem::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->exists();
        
        if ($exists) {
            return redirect()->back()->with('info', __('Product already in wishlist!'));
        }
        
        WishlistItem::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);
        
        return redirect()->back()->with('success', __('Product added to wishlist!'));
    }

    public function destroy(WishlistItem $wishlistItem)
    {
        $this->authorize('delete', $wishlistItem);
        $wishlistItem->delete();
        
        return redirect()->back()->with('success', __('Product removed from wishlist!'));
    }
}
