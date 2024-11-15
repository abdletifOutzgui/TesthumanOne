<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouveau Produit') }}
        </h2>
    </x-slot>

    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <form action="{{ route('products.store') }}" method="post">
                    @csrf

                    <!-- nom -->
                    <div>
                        <x-input-label for="name" :value="__('Nom')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Quantité en stock -->
                    <div class="mt-3"> 
                        <x-input-label for="quantity_in_stock" :value="__('Quantité en stock')" />
                        <x-text-input id="quantity_in_stock" class="block mt-1 w-full" type="number" name="quantity_in_stock" :value="old('quantity_in_stock')" required />
                    
                        <x-input-error :messages="$errors->get('quantity_in_stock')" class="mt-2" />
                    </div>

                    <!-- Seuil minimum -->
                    <div class="mt-3"> 
                        <x-input-label for="min_threshold" :value="__('Seuil minimum')" />
                        <x-text-input id="min_threshold" class="block mt-1 w-full" type="number" name="min_threshold" :value="old('min_threshold')" required />
                        <x-input-error :messages="$errors->get('min_threshold')" class="mt-2" />
                    </div>

                    <x-primary-button class="mt-5">
                        {{ __('Créer le produit') }}
                    </x-primary-button>
                    
                </form>
            </div>
        </div>
    </div>
</div>

</x-app-layout>
