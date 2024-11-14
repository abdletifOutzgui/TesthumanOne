<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Enregistrer une commande') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form action="{{ route('commandes.store') }}" method="post" id="order-form">
                        @csrf

                        <!-- Clients -->
                        <div>
                            <x-input-label for="client" :value="__('Choisir un client')" />
                            <select name="client_id" id="client" class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option selected disabled>selectionner un client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->nom }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('client_id')" class="mt-2" />
                        </div>

                        <!-- Produits & quantites -->
                        <div class="mt-3">
                            <x-input-label for="produits" :value="__('Selectionner de Produit(s)')" />

                            @foreach ($produits as $produit)
                                <div class="flex items-center mb-2">
                                    <!-- Checkbox for selecting the product -->
                                    <input 
                                        type="checkbox" 
                                        name="produits[]" 
                                        value="{{ $produit->id }}" 
                                        id="produit_{{ $produit->id }}" 
                                        class="mr-2 produit-checkbox"
                                        {{ in_array($produit->id, old('produits', [])) ? 'checked' : '' }} 
                                    >
                                    <label for="produit_{{ $produit->id }}">
                                        {{ $produit->nom }} - {{ $produit->prix }} DH
                                    </label>

                                    <!-- Hidden input for product price, this will only be appended dynamically -->
                                    <input type="hidden" name="prix_{{ $produit->id }}" value="{{ $produit->prix }}" class="prix-hidden">

                                    <!-- Quantity input -->
                                    <input 
                                        type="number" 
                                        name="quantites[{{ $produit->id }}]" 
                                        min="1" 
                                        value="{{ old('quantites.' . $produit->id, 1) }}" 
                                        class="ml-4 w-16 produit-quantite" 
                                        placeholder="Quantité"
                                    >
                                </div>
                            @endforeach

                            <x-input-error :messages="$errors->get('produits')" class="mt-2" />
                            <x-input-error :messages="$errors->get('quantites')" class="mt-2" />
                        </div>

                        <x-primary-button class="mt-5">
                            {{ __('Sauvgarder la commande') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
