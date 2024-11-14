<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Clients') }}
            </h2>
            <a href="{{ route('clients.create') }}" class="inline-block bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Ajouter un nouveau client</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <x-flash-message />
            @endif
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Telephone</th>
                                <th>Adresse</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $client)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="px-4 py-2 text-center">{{ $client->id }}</td>
                                    <td class="px-4 py-2">{{ $client->nom }}</td>
                                    <td class="px-4 py-2">{{ $client->email }}</td>
                                    <td class="px-4 py-2 text-right">{{ $client->telephone }}</td>
                                    <td class="px-4 py-2">{{ $client->adresse }}</td>
                                    <td class="flex px-4 py-2 text-center space-x-2">
                                        <a class="inline-block bg-black text-white px-3 py-1 rounded hover:bg-blue-600" href="{{ route('clients.show', $client) }}">Voir</a>
                                        <a class="inline-block bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600" href="{{ route('clients.edit', $client) }}">Modifier</a>
                                        <form action="{{ route('clients.destroy', $client) }}" method="post" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')"
                                                >Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-2 text-center text-gray-500">Aucun client trouvé.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
