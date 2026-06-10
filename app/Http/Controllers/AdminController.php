<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);
        
        $users = User::withCount(['orders', 'reviews'])->paginate(20);
        $orders = Order::with('user')->latest()->take(10)->get();
        
        return view('admin.index', compact('users', 'orders'));
    }

    public function users()
    {
        $this->authorize('viewAny', User::class);
        $users = User::withCount(['orders', 'reviews'])->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $this->authorize('update', $user);
        
        $validated = $request->validate([
            'role' => 'required|in:customer,manager,admin',
        ]);
        
        $user->update($validated);
        
        return redirect()->back()->with('success', __('User role updated successfully!'));
    }
}
