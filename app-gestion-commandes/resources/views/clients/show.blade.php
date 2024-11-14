<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Details de client') }}
            </h2>
            <form action="{{ route('clients.destroy', $client) }}" method="post" class="inline-block">
                @csrf
                @method('DELETE')
                <button 
                    type="submit" 
                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')"
                    >Supprimer</button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    Nom: {{ $client->nom }} <br />
                    E-mail: {{ $client->email }} <br />
                    Telephone: {{ $client->telephone }} <br />
                    Adresse: {{ $client->adresse }}<br />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
