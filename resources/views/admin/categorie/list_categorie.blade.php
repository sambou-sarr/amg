@extends('admin.base')
    @section('content')
        <br><br>
    <div class="container mt-4">
        <!-- Session Messages -->
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><i class="fas fa-tags"></i> Liste des catégories</h3>
                    <a href="/admin/categorie/ajout" class="btn btn-light">
                        <i class="fas fa-plus"></i> Nouvelle catégorie
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <input type="text" class="form-control" id="searchInput" 
                           placeholder="Rechercher par nom ou description..." 
                           onkeyup="filterTable()">
                </div>

                <div class="table-responsive">
                    <table class="table table-hover" id="myTable">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Création</th>
                                <th>Dernière modification</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $categorie)
                            <tr>
                                <td>{{ $categorie->id }}</td>
                                <td>{{ $categorie->libelle }}</td>
                                <td>{{ $categorie->created_at->format('d/m/Y') }}</td>
                                <td>{{ $categorie->updated_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('edit_categorie', ['id' => $categorie->id]) }}"
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                    <form action="{{ route('supprimer_categorie', ['id' => $categorie->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Confirmer la suppression définitive ?')">
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
    // Keep the same JavaScript
    function filterTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('myTable');
        const trs = table.getElementsByTagName('tr');

        for (let i = 1; i < trs.length; i++) {
            const tds = trs[i].getElementsByTagName('td');
            let showRow = false;
            
            for (let td of tds) {
                if (td.textContent.toLowerCase().includes(filter)) {
                    showRow = true;
                    break;
                }
            }
            
            trs[i].style.display = showRow ? '' : 'none';
        }
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection