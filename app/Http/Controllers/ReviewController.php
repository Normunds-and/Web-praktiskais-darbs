<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'product'])->latest()->paginate(20);
        return view('reviews.index', compact('reviews'));
    }

    public function create(Product $product)
    {
        return view('reviews.create', compact('product'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'text' => 'required|string',
            'score' => 'required|integer|min:1|max:5',
        ]);
        
        $validated['user_id'] = auth()->id();
        
        Review::create($validated);
        
        return redirect()->route('products.show', $validated['product_id'])
            ->with('success', __('Review submitted successfully!'));
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        $review->delete();
        
        return redirect()->back()->with('success', __('Review deleted successfully!'));
    }
}
