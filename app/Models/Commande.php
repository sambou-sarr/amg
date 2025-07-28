<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $table = 'commandes'; // Nom de la table

    protected $fillable = [
        'id',
        'user_id',
        'date_commande',
        'id_user',
        'Statut'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getStatusBadgeColor()
{
    return match ($this->statut) {
        'en_attente' => 'warning',
        'en_cours' => 'info',
        'livree' => 'success',
        'annulee' => 'danger',
        default => 'secondary',
    };
}

}
