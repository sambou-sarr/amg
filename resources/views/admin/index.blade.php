
@extends('admin.base')
    @section('content')
        <br><br>
        <div class="container-fluid mt-4">
            <div class="row g-4">
                <!-- Cartes de statistiques -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle p-3 me-3">
                                    <i class="fas fa-wallet fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ number_format($stats['totalVentes'], 0, ',', ' ') }} FCFA</h5>
                                    <small class="text-muted">Chiffre d'affaires total</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-success text-white rounded-circle p-3 me-3">
                                    <i class="fas fa-shopping-cart fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $stats['commandesJour'] }}</h5>
                                    <small class="text-muted">Commandes aujourd'hui</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning text-white rounded-circle p-3 me-3">
                                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $stats['produitsStock'] }}</h5>
                                    <small class="text-muted">Produits en stock critique</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-info text-white rounded-circle p-3 me-3">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $stats['clientsActifs'] }}</h5>
                                    <small class="text-muted">Clients actifs</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Graphique et Dernières commandes -->
                <div class="col-12 col-xl-8">
                    <div class="chart-container shadow-sm">
                        <canvas id="salesChart" width="800" height="400"></canvas> <!-- Ajustez la taille ici -->
                    </div>
                </div>

                <div class="col-12 col-xl-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Dernières commandes</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                @foreach($commandes as $commande)
                                    <a href="{{ route('commande.show', $commande['id']) }}" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">Commande #{{ $commande['id'] }}</h5>
                                            <small>{{ \Carbon\Carbon::createFromFormat('d/m/Y H:i', $commande['date'])->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-1">Client : {{ $commande['nom'] }}</p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
 @endsection
