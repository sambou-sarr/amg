<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailCommande extends Model
{
    use HasFactory;

    protected $fillable = ['id_commande', 'id_produit', 'quantite', 'prix_unitaire'];

    // Relation avec le produit
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit');
    }
    public function details()
    {
        return $this->hasMany(DetailCommande::class);
    }
}
