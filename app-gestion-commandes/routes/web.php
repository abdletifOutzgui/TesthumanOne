<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::redirect('/', 'produits');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Produits
    Route::resource('/produits', ProduitController::class);
    // Clients
    Route::resource('/clients', ClientController::class);

     // Commandes
     Route::get('/commandes/{commande}/pdf', [CommandeController::class, 'generatePdf'])->name('commande.generatePdf');
     Route::resource('/commandes', CommandeController::class)->except(['edit', 'update']);
});

require __DIR__.'/auth.php';
