<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Commandes') }}
            </h2>
            <a href="{{ route('commandes.create') }}" class="inline-block bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Passer une Commande</a>
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
                                <th>Nom client</th>
                                <th>E-mail client</th>
                                <th>Addresse</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($commandes as $commande)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="px-4 py-2 text-center">{{ $commande->id }}</td>
                                    <td class="px-4 py-2">{{ $commande->client?->nom }}</td>
                                    <td class="px-4 py-2">{{ $commande->client?->email }}</td>
                                    <td class="px-4 py-2">{{ $commande->client?->adresse }}</td>
                                    <td class="px-4 py-2">{{ $commande->total }} DHs</td>
                                    
                                    <td class="flex px-4 py-2 text-center space-x-2">
                                        <a class="bg-black text-white px-3 py-1 rounded hover:bg-grey-600" href="{{ route('commande.generatePdf', $commande) }}">Telecharger PDF</a>
                                        <a class="bg-gray-800 text-white px-3 py-1 rounded hover:bg-blue-600" href="{{ route('commandes.show', $commande) }}">Details</a>
                                        <form action="{{ route('commandes.destroy', $commande) }}" method="post" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commande ?')"
                                                >Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-2 text-center text-gray-500">Aucune commande trouvé.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    {{ $commandes->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
