<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProduitController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $produits = Produit::when($request->category, function ($query, $category) {
                        return $query->where('category_id', $category); 
                    })
                    ->when($request->prix, function ($query, $prix) {
                        return $query->where('prix', '>=', $prix); 
                    })
                    ->latest()
                    ->paginate(10);

        return view('produits.index', compact('produits'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View  
    {
        return view('produits.create');     
    }

    /**
     * Store a newly created product in storage.
     *
     * @param \App\Http\Requests\Products\StoreProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        // Handle the image upload.
        if (isset($data['image']) && $data['image']->isValid()) {
            $data['image'] = $data['image']->store('produits');
        }

        Produit::create($data);
        
        return redirect(route('produits.index'))->with('success', 'Produit a été ajouté!');
    }

    /**
     * Display the specified product.
     *
     * @param \App\Models\Produit $produit
     * @return \Illuminate\View\View
     */
    public function show(Produit $produit): View
    {
        return view('produits.show', compact('produit'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param \App\Models\Produit $produit
     * @return \Illuminate\View\View
     */
    public function edit(Produit $produit): View
    {
        return view('produits.edit', compact('produit')); 
    }

    /**
     * Update the specified product in storage.
     *
     * @param \App\Http\Requests\Products\UpdateProductRequest $request
     * @param \App\Models\Produit $produit
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProductRequest $request, Produit $produit): RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['image']) && $data['image']->isValid()) {
            $data['image'] = $data['image']->store('produits');
        }

        $produit->update($data);

        return redirect(route('produits.index'))
                ->with('success', 'Produit a été modifié!');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param \App\Models\Produit $produit
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Produit $produit): RedirectResponse
    {
        $produit->delete();

        return redirect(route('produits.index'))
                ->with('success', 'Produit a été supprimé!');
    }
}
