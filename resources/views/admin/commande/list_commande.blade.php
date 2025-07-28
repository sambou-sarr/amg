@extends('admin.base')
    @section('content')
        <br><br>
    <div class="container">
        <div class="card shadow-lg mb-4 hover-scale">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-tags"></i> Liste des commandes</h4>
                    <a href="/admin/commande/create" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> Ajouter
                    </a>
                </div>
            </div>
    
            <div class="card-body">
                <div class="mb-3">
                    <input type="text" class="form-control" id="searchInput" 
                           placeholder="Rechercher une commande..." onkeyup="filterTable()">
                </div>
    
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="myTable">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($commandes as $cmd)
                            <tr>
                                <td>{{ $cmd->id }}</td>
                                <td>{{ $cmd->nom ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($cmd->date_commande)->format('d/m/Y H:i') }}</td>
                                <td>
                                    <form action="{{ route('commandes.update', $cmd->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                    
                                        <select name="statut" class="form-select form-select-sm status-select" onchange="this.form.submit()">
                                            <option value="en_attente" {{ $cmd->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                            <option value="en_cours" {{ $cmd->statut == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                            <option value="livree" {{ $cmd->statut == 'livree' ? 'selected' : '' }}>Livrée</option>
                                            <option value="annulee" {{ $cmd->statut == 'annulee' ? 'selected' : '' }}>Annulée</option>
                                        </select>
                                    </form>
                                    
                                </td>
                                <td>
                                    <a href="{{route('commandes.details',$cmd->id)}}" class="btn btn-sm btn-info">Détails</a>
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
        const input = document.getElementById("searchInput");
        const filter = input.value.toUpperCase();
        const table = document.getElementById("myTable");
        const trs = table.getElementsByTagName("tr");
    
        for (let i = 1; i < trs.length; i++) {
            const tds = trs[i].getElementsByTagName("td");
            let display = "none";
            
            for (let td of tds) {
                if (td.textContent.toUpperCase().indexOf(filter) > -1) {
                    display = "";
                    break;
                }
            }
            trs[i].style.display = display;
        }
    }
    </script>
@endsection
