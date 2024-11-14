<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produit extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'nom',
        'description',
        'prix',
        'image'
    ];

    
    public function commandes(): BelongsToMany
    {
        return $this->belongsToMany(Commande::class)->withPivot('quantite');
    }
}
