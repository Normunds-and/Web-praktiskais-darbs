<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(count($cart) > 0)
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-2">{{ __('Product') }}</th>
                                    <th class="text-left py-2">{{ __('Price') }}</th>
                                    <th class="text-left py-2">{{ __('Quantity') }}</th>
                                    <th class="text-left py-2">{{ __('Subtotal') }}</th>
                                    <th class="text-left py-2">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $id => $item)
                                    <tr class="border-b">
                                        <td class="py-4">{{ $item['name'] }}</td>
                                        <td class="py-4">${{ number_format($item['price'], 2) }}</td>
                                        <td class="py-4">{{ $item['quantity'] }}</td>
                                        <td class="py-4">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                        <td class="py-4">
                                            <form method="POST" action="{{ route('cart.remove', $id) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">{{ __('Remove') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <div class="mt-6 flex justify-between items-center">
                            <div>
                                <p class="text-2xl font-bold">{{ __('Total') }}: ${{ number_format($total, 2) }}</p>
                            </div>
                            <div class="flex gap-4">
                                <form method="POST" action="{{ route('cart.clear') }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        {{ __('Clear Cart') }}
                                    </button>
                                </form>
                                @auth
                                    <a href="{{ route('orders.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        {{ __('Checkout') }}
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        {{ __('Login to Checkout') }}
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500">{{ __('Your cart is empty.') }}</p>
                        <a href="{{ route('home') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Continue Shopping') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
