<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Categories') }}
            </h2>
            @auth
                @if(auth()->user()->isManager() || auth()->user()->isAdmin())
                    <a href="{{ route('categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Add Category') }}
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($categories->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($categories as $category)
                                <div class="border rounded-lg p-4 hover:shadow-lg transition">
                                    <h3 class="font-bold text-lg mb-2">{{ $category->name }}</h3>
                                    <p class="text-gray-600 mb-4">{{ $category->products_count }} {{ __('products') }}</p>
                                    <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">
                                        {{ __('View Products') }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">{{ __('No categories found.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
