<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = [
        'code',
        'libelle',
        'prix_u',
        'stock',
        'id_categorie',
        'image1',
        'image2',
        'image3'
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie');
    }

    // Mutator pour code en majuscules
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit');
    }
}
