<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'adresse'
    ];

    /**
     * Get the commandes for the client
     * @return HasMany<Commande, covariant $this>
     */
    public function commandes(): HasMany
    {
        return $this->hasMany(Commande::class);
    }
}
