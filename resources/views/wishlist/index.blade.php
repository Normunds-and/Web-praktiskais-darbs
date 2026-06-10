<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Wishlist') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($wishlistItems->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($wishlistItems as $item)
                                <div class="border rounded-lg p-4">
                                    <h3 class="font-bold mb-2">{{ $item->product->name }}</h3>
                                    <p class="text-xl font-bold text-green-600 mb-4">${{ number_format($item->product->price, 2) }}</p>
                                    <div class="flex gap-2">
                                        <a href="{{ route('products.show', $item->product) }}" 
                                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                            {{ __('View') }}
                                        </a>
                                        <form method="POST" action="{{ route('wishlist.destroy', $item) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                                                {{ __('Remove') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">{{ __('Your wishlist is empty.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
