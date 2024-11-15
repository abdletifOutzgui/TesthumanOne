<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Details de produit') }}
            </h2>
            <form action="{{ route('products.destroy', $product) }}" method="post" class="inline-block">
                @csrf
                @method('DELETE')
                <button 
                    type="submit" 
                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')"
                    >Supprimer</button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <p>Nom : <span class="font-bold">{{ $product->name }}</span></p>
                    <p>Quantité en stock: <span class="font-bold">{{ $product->quantity_in_stock }}</span></p>
                    <p>Seuil minimum: <span class="font-bold">{{ $product->min_threshold }}</span></p>
                    <br />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
