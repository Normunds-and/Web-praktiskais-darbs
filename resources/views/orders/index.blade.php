<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($orders->count() > 0)
                        @foreach($orders as $order)
                            <div class="border rounded-lg p-4 mb-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="font-bold">{{ __('Order') }} #{{ $order->id }}</h3>
                                        <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-lg">${{ number_format($order->total_amount, 2) }}</p>
                                        <span class="px-2 py-1 rounded text-sm {{ $order->status == 'delivered' ? 'bg-green-200' : 'bg-yellow-200' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                                <a href="{{ route('orders.show', $order) }}" class="text-blue-500 hover:text-blue-700">
                                    {{ __('View Details') }} →
                                </a>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-500">{{ __('No orders yet.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
