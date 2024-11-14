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
                <form action="{{ route('produits.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <!-- nom -->
                    <div>
                        <x-input-label for="nom" :value="__('Nom')" />
                        <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')" required autofocus />
                        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                    </div>

                    <!-- description -->
                    <div class="mt-3"> 
                        <x-input-label for="description" :value="__('Description')" />
                        <x-text-input typeInput="textarea" id="description" class="block mt-1 w-full" name="description" :value="old('description')" required />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Prix -->
                    <div class="mt-3"> 
                        <x-input-label for="prix" :value="__('Prix')" />
                        <x-text-input id="prix" class="block mt-1 w-full" type="number" name="prix" :value="old('prix')" required />
                        <x-input-error :messages="$errors->get('prix')" class="mt-2" />
                    </div>

                    <!-- Image -->
                    <div class="mt-3"> 
                        <x-input-label for="image" :value="__('Image')" />
                        <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" :value="old('image')" required />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
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
