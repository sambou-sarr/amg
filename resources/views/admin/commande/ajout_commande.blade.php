@extends('admin.base')
    @section('content')
        <br><br>
    <div class="container mt-5">
    <h2>Créer une commande manuelle</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('commande.store') }}" method="POST">
        @csrf

        <!-- Section Client -->
        <div class="card mb-4">
            <div class="card-header">Informations client</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Client existant</label>
                        <select class="form-select" name="client_id">
                            <option value="">Nouveau client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">
                                    {{ $client->nom }} ({{ $client->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Nom</label>
                        <input type="text" name="client_nom" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="client_email" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Téléphone</label>
                        <input type="tel" name="client_telephone" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label>Adresse</label>
                        <textarea name="client_adresse" class="form-control" required></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Produits -->
        <div class="card mb-4">
            <div class="card-header">Produits</div>
            <div class="card-body">
                <div id="produits-container">
                    <!-- Produits ajoutés dynamiquement -->
                </div>
                <button type="button" class="btn btn-secondary mt-3" onclick="ajouterProduit()">Ajouter un produit</button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer la commande</button>
    </form>
</div>

<script>
    function ajouterProduit() {
        let index = document.querySelectorAll('.produit-ligne').length;
        let container = document.getElementById('produits-container');

        let html = `
            <div class="row g-3 mb-3 produit-ligne">
                <div class="col-md-5">
                    <select name="produits[${index}][id]" class="form-select select-produit" required>
                        <option value="">Choisir un produit</option>
                        @foreach ($produits as $p)
                            <option value="{{ $p->id }}" data-prix="{{ $p->prix_u }}">
                                {{ $p->libelle }} - {{ number_format($p->prix_u, 0, ',', ' ') }} FCFA
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="produits[${index}][quantite]" class="form-control quantite" min="1" value="1" required>
                </div>
                <div class="col-md-3">
                    <input type="hidden" name="produits[${index}][prix]" class="form-control prix">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger" onclick="supprimerLigne(this)">×</button>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
    }

    function supprimerLigne(btn) {
        btn.closest('.produit-ligne').remove();
    }
</script>
@endsection