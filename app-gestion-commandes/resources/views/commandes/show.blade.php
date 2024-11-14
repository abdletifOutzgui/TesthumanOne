<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Details de la commande ') }}
            </h2>
            <form action="{{ route('commandes.destroy', $commande) }}" method="post" class="inline-block">
                @csrf
                @method('DELETE')
                <button 
                    type="submit" 
                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')"
                    >Supprimer</button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <p>Commande ID: <span class="font-bold">{{ $commande->id }}</span></p>
                    <p>Client: <span class="font-bold">{{ $commande->client->nom }}</span></p>
                    <p>Date de création de la commande: <span class="font-bold">{{ $commande->created_at }}</span></p>
                    <br />

                    <h5 class="font-bold text-lg mb-4">Détails de la commande</h5>
                  
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left">ID produit</th>
                                <th class="px-4 py-2 text-left">Nom</th>
                                <th class="px-4 py-2 text-left">Prix</th>
                                <th class="px-4 py-2 text-left">Qte</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commande->produits as $produit)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="px-4 py-2 text-center">{{ $produit->id }}</td>
                                    <td class="px-4 py-2">{{ $produit->nom }}</td>
                                    <td class="px-4 py-2">{{ $produit->prix }} DH</td>
                                    <td class="px-4 py-2 text-right">{{ $produit->pivot->quantite }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <p class="font-bold text-lg">Total de la commande: <span class="text-green-500">{{ number_format($commande->total, 2) }} DH</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
