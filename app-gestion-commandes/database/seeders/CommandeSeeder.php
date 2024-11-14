<?php

namespace Database\Seeders;

use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommandeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $commandes = Commande::factory()->count(10)->create();

       $produits = Produit::factory()->count(20)->create();

       foreach ($commandes as $commande) {
        
           $produitsIds = $produits->random(rand(1, 5))->pluck('id')->toArray();

           foreach ($produitsIds as $produitId) {
               $commande->produits()->attach($produitId, [
                   'quantite' => rand(1, 5),
               ]);
           }

           $total = $commande->produits->sum(function ($produit) {
               return $produit->pivot->quantite * $produit->prix;
           });

           $commande->update(['total' => $total]);
       }
   }
}
