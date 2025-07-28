@extends('client.base')

@section('title', 'Nos Jus Naturels')

@section('content')

<div id="products" class="row g-4">
    <h2 class="mb-4 text-center">Nos Jus Frais</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    @forelse($products as $produit)
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100 shadow-sm border-0">
                <img src="{{ asset('storage/' . $produit->image1) }}" 
                     alt="{{ $produit->libelle }}" 
                     class="card-img-top" style="object-fit: cover; height: 200px;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $produit->libelle }}</h5>
                        <p class="card-text fw-bold text-gradient">
                            {{ number_format($produit->prix_u, 0, ',', ' ') }} FCFA
                        </p>

                    <form action="{{ route('cart.add', ['id' => $produit->id]) }}" method="POST" class="mt-auto">
                        @csrf
                       <button type="submit" class="btn text-white w-100" style="background: linear-gradient(135deg, #4b79a1 0%, #283e51 100%); border: none;">
                            <i class="fas fa-cart-plus me-1"></i> Ajouter au panier
                        </button>

                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center text-muted">
            <i class="fas fa-box-open fa-3x mb-3"></i>
            <p>Aucun produit disponible pour le moment.</p>
        </div>
    @endforelse
</div>
@endsection
