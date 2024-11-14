<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouveau Client') }}
        </h2>
    </x-slot>

    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <form action="{{ route('clients.store') }}" method="post">
                    @csrf

                    <!-- Nom -->
                    <div>
                        <x-input-label for="nom" :value="__('Nom')" />
                        <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')" required autofocus />
                        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                    </div>

                    <!-- E-mail -->
                    <div class="mt-3"> 
                        <x-input-label for="email" :value="__('E-mail')" />
                        <x-text-input id="email" type="email" class="block mt-1 w-full" name="email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Telephone -->
                    <div class="mt-3"> 
                        <x-input-label for="telephone" :value="__('Telephone')" />
                        <x-text-input id="telephone" class="block mt-1 w-full" type="text" name="telephone" :value="old('telephone')" required />
                        <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                    </div>

                   <!-- Adresse -->
                   <div class="mt-3"> 
                        <x-input-label for="adresse" :value="__('Adresse')" />
                        <x-text-input typeInput="textarea" id="adresse" type="adresse" class="block mt-1 w-full" name="adresse" :value="old('adresse')" required />
                        <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
                    </div>

                    <x-primary-button class="mt-5">
                        {{ __('Enregistrer') }}
                    </x-primary-button>
                    
                </form>
            </div>
        </div>
    </div>
</div>

</x-app-layout>
