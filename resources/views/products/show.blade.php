<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
                            <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                            
                            <div class="mb-4">
                                <span class="text-3xl font-bold text-green-600">${{ number_format($product->price, 2) }}</span>
                            </div>
                            
                            <p class="mb-4">
                                <strong>{{ __('Category') }}:</strong> {{ $product->category->name }}
                            </p>
                            
                            <p class="mb-4">
                                <strong>{{ __('Brand') }}:</strong> {{ $product->brand ?? 'N/A' }}
                            </p>
                            
                            <p class="mb-6">
                                <strong>{{ __('In Stock') }}:</strong> 
                                <span class="{{ $product->in_stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $product->in_stock }}
                                </span>
                            </p>
                            
                            <div class="flex gap-4">
                                <form method="POST" action="{{ route('cart.add', $product) }}">
                                    @csrf
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded">
                                        {{ __('Add to Cart') }}
                                    </button>
                                </form>
                                
                                @auth
                                    <form method="POST" action="{{ route('wishlist.store', $product) }}">
                                        @csrf
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded">
                                            {{ __('Add to Wishlist') }}
                                        </button>
                                    </form>
                                @endauth
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-xl font-bold mb-4">{{ __('Reviews') }}</h3>
                            
                            @auth
                                <a href="{{ route('reviews.create', $product) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
                                    {{ __('Write a Review') }}
                                </a>
                            @endauth
                            
                            @if($product->reviews->count() > 0)
                                @foreach($product->reviews as $review)
                                    <div class="border-b pb-4 mb-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-bold">{{ $review->user->name }}</p>
                                                <p class="text-yellow-500">{{ str_repeat('★', $review->score) }}{{ str_repeat('☆', 5 - $review->score) }}</p>
                                            </div>
                                            @can('delete', $review)
                                                <form method="POST" action="{{ route('reviews.destroy', $review) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700">{{ __('Delete') }}</button>
                                                </form>
                                            @endcan
                                        </div>
                                        <p class="mt-2">{{ $review->text }}</p>
                                        <p class="text-sm text-gray-500 mt-1">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-500">{{ __('No reviews yet.') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
