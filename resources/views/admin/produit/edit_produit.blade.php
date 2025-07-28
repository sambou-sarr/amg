@extends('admin.base')
    @section('content')
        <br><br>
<div class="container mt-4">
    <div class="card shadow-lg hover-scale">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0"><i class="fas fa-edit"></i> Modifier le produit</h3>
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('update_produit', $produit) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nom du produit</label>
                    <input type="hidden" name="id" class="form-control" 
                    value="{{ old('id', $produit->id) }}" >
                    <input type="text" name="libelle" class="form-control" 
                           value="{{ old('libelle', $produit->libelle) }}" required>
                </div>

                <div class="row g-3 mb-3">

                    <div class="col-md-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" 
                               value="{{ old('stock', $produit->stock) }}" min="0" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Prix (FCFA)</label>
                        <input type="number" name="prix_u" class="form-control" 
                               value="{{ old('prix', number_format($produit->prix_u, 0, '', '')) }}" 
                               step="100" min="0" required>
                    </div>
                </div>

                <div class="mb-4 current-images">
                    <h5 class="text-muted mb-3">Images actuelles</h5>
                    <div class="row g-3">
                        @foreach (['image', 'image1', 'image2'] as $field)
                            @if ($produit->$field)
                                <div class="col-md-4">
                                    <img src="{{ Storage::url($produit->$field) }}" 
                                         class="img-thumbnail image-preview w-100">
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="text-muted mb-3">Nouvelles images</h5>
                    <div class="row g-3">
                        @foreach (['image', 'image1', 'image2'] as $field)
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <label class="form-label">
                                            Image {{ $loop->iteration }} 
                                            <small class="text-muted">(max 5Mo)</small>
                                        </label>
                                        <input type="file" 
                                               name="{{ $field }}" 
                                               class="form-control" 
                                               accept="image/jpeg, image/png, image/gif">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-save"></i> Modifier
                    </button>
                    <a href="{{ route('list_produit') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection