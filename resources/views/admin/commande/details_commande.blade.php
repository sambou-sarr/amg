@extends('admin.base')
    @section('content')
    <style>
        /* Style général du select */
select[name="statut"] {
    padding: 5px 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-weight: bold;
    background-color: #f8f9fa;
    transition: background-color 0.3s ease;
}

/* Couleurs spécifiques selon le statut sélectionné */
select[name="statut"].en_attente {
    color: #856404;
    background-color: #fff3cd;
    border-color: #ffeeba;
}

select[name="statut"].en_cours {
    color: #0c5460;
    background-color: #d1ecf1;
    border-color: #bee5eb;
}

select[name="statut"].livree {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

select[name="statut"].annulee {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

    </style>
        <br><br>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Détails de la Commande #{{ $commande->id }}</h1>
        <a href="{{ route('commandes.index') }}" class="btn btn-secondary">Retour aux commandes</a>
    </div>

    <!-- Informations client -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informations client</h5>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Nom</dt>
                <dd class="col-sm-9">{{ $commande->nom }}</dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $commande->email }}</dd>

                <dt class="col-sm-3">Téléphone</dt>
                <dd class="col-sm-9">{{ $commande->telephone }}</dd>

                <dt class="col-sm-3">Adresse</dt>
                <dd class="col-sm-9">{{ nl2br(e($commande->adresse)) }}</dd>

                <dt class="col-sm-3">Date</dt>
                <dd class="col-sm-9">{{ $commande->created_at }}</dd>

                <dt class="col-sm-3">Statut</dt>
                <dd class="col-sm-9">
                    <dd class="col-sm-9">
                        <span class="badge bg-{{ $commande->getStatusBadgeColor() }}">
                            {{ ucfirst($commande->statut) }}
                        </span>
                    </dd>
                </dd>
                <a href="{{ route('commandes.download.facture', $commande->id) }}" class="btn btn-primary">Télécharger la facture</a>
            </dl>
        </div>
    </div>

    <!-- Articles commandés -->
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Articles commandés</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th class="text-end">Quantité</th>
                        <th class="text-end">Prix unitaire</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalGeneral = 0; @endphp
                    @foreach ($articles as $article)
                        @php 
                            $totalLigne = $article->prix_unitaire * $article->quantite;
                            $totalGeneral += $totalLigne;
                        @endphp
                        <tr>
                            <td>{{ $article->produit_nom }}</td>
                            <td class="text-end">{{ $article->quantite }}</td>
                            <td class="text-end">{{ number_format($article->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                            <td class="text-end">{{ number_format($totalLigne, 0, ',', ' ') }} FCFA</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-active">
                        <th colspan="3" class="text-end">Total général</th>
                        <th class="text-end">{{ number_format($totalGeneral, 0, ',', ' ') }} FCFA</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<dt class="col-sm-3">Statut</dt>
<dd class="col-sm-9">
    <form action="{{ route('commandes.update', $commande->id) }}" method="POST">
        @csrf
        @method('PUT')
<select name="statut"
        class="form-select form-select-sm w-auto d-inline {{ $commande->statut }}"
        onchange="this.form.submit()">
            <option value="en_attente" {{ $commande->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
            <option value="en_cours" {{ $commande->statut == 'en_cours' ? 'selected' : '' }}>En cours</option>
            <option value="livree" {{ $commande->statut == 'livree' ? 'selected' : '' }}>Livrée</option>
            <option value="annulee" {{ $commande->statut == 'annulee' ? 'selected' : '' }}>Annulée</option>
        </select>
    </form>
</dd>

                                    
@endsection