@extends('admin.base')
    @section('content')
        <br><br>
    <div class="container">
        <div class="card shadow-lg mb-4 hover-scale">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"> <i class="fas fa-tags"></i> Liste des produits</h4>
                    <a href="{{ route('produit.create') }}" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> Ajouter
                    </a>
                </div>
            </div>
            
            <div class="card-body">
                <div class="mb-3">
                    <input type="text" class="form-control" id="searchInput" 
                           placeholder="Rechercher un produit..." onkeyup="filterTable()">
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="myTable">
                        <thead class="table-dark">
                            <tr>
                                <th>Image produit</th>
                                <th>Libellé</th>
                                <th>Stock</th>
                                <th>Prix</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produits as $produit)
                                <tr>
                                    <td>
                                        <img src="{{ asset('produits/' . basename($produit->image1)) }}" alt="{{ $produit->libelle }}" style="width: 50px; height: auto;">
                                    </td>
                                    <td>{{ $produit->libelle }}</td>
                                    <td>{{ $produit->stock }}</td>
                                    <td>{{ $produit->prix_u, 0, ',', ' ' }} FCFA</td>
                                    <td>
                                        <a href="{{ route('edit_produit', $produit->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Modifier
                                        </a>
                                        <form action="{{ route('supprimer_produit', $produit->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Confirmer la suppression définitive ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
function filterTable() {
    // Récupérer la valeur de recherche et mettre en minuscules
    const input = document.getElementById("searchInput");
    const filter = input.value.toLowerCase();
    const table = document.getElementById("myTable");
    const trs = table.getElementsByTagName("tr");

    // Parcourir toutes les lignes du tbody (commence à 1 pour ignorer le header)
    for (let i = 1; i < trs.length; i++) {
        const tds = trs[i].getElementsByTagName("td");
        let found = false;

        // Parcourir toutes les cellules de la ligne
        for (let j = 0; j < tds.length; j++) {
            const td = tds[j];
            if (td && td.textContent.toLowerCase().includes(filter)) {
                found = true;
                break;
            }
        }

        // Afficher ou cacher la ligne selon le résultat
        trs[i].style.display = found ? "" : "none";
    }
}
</script>

@endsection