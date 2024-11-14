<?php

namespace App\Http\Controllers;

use App\Http\Requests\Commandes\StoreCommandeRequest;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Produit;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\View\View;
class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commandes = Commande::with('client')->latest()->paginate(10);

        return view("commandes.index", compact("commandes"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $clients = Client::select('id', 'nom')->get();
        $produits = Produit::select('id', 'nom', 'prix')->get();

        return view("commandes.create", compact('clients', 'produits'));
    }

    /**
     * Store a newly created resource in storage.
     */ 

    public function store(StoreCommandeRequest $request)
    {
        \DB::beginTransaction();

        try {
            $data = $request->validated();

            $commande = Commande::create(['client_id' => $data['client_id']]); // save commande

            // Attach products to commande and calculate the total
            foreach ($data['produits'] as $produit_id) {
                $qte = $data['quantites'][$produit_id];

                $commande->produits()->attach($produit_id, ['quantite' => $qte]);
            }

            $total = $commande->produits->sum(function ($produit) {
                return $produit->pivot->quantite * $produit->prix;
            });
    
            $commande->update(['total' => $total]);

            \DB::commit();

            return redirect()->route('commandes.index')->with('success', 'Commande enregistrée avec succès!');
        
        } catch (\Exception $e) {
            \DB::rollBack();

            \Log::error('Error while creating commande: ' . $e->getMessage());

            return back()->with('error', 'Une erreur est survenue lors de l\'enregistrement de la commande.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Commande $commande)
    {
        $commande = $commande->load('client', 'produits');

        return view('commandes.show', compact('commande'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commande $commande)
    {
        $commande->delete();
    }

    public function generatePdf(Commande $commande)
    {
        $commande->load('produits', 'client');

        $pdf = PDF::loadView('commandes.pdf.generateCommande', compact('commande'));

        return $pdf->download('commande_'.$commande->id.'.pdf');
    }
}
