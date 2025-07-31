@extends('admin.base')
    @section('content')
        <br><br>
    <div class="container mt-4">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-plus-circle"></i> Ajouter un nouveau produit</h3>
            </div>
    
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
    
                <form method="POST" action="{{ route('ajout_Produit') }}" enctype="multipart/form-data">
                    @csrf
    
                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <label class="form-label">Nom du produit</label>
                            <input type="text" name="libelle" class="form-control" 
                                    required maxlength="100">
                        </div>

                    </div>
    
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Stock initial</label>
                            <input type="number" name="stock" class="form-control" 
                                    min="0" required>
                        </div>
    
                        <div class="col-md-8">
                            <label class="form-label">Prix (FCFA)</label>
                            <input type="number" name="prix" class="form-control" 
                                    min="0" step="100" required>
                        </div>
                    </div>
    
                    <div class="mb-4">
                        <h5 class="text-muted mb-3">Images du produit</h5>
                        <div class="row g-3">
                          
                            <div class="col-md-4">
                                <div class="card image-upload-card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                        <p class="mb-0">Image 
                                            <small class="text-muted">(optionnelle)</small>
                                        </p>
                                        <input type="file" 
                                               name="{{ $field }}" 
                                               class="form-control mt-2" 
                                               accept="image/jpeg, image/png, image/gif">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                        <a href="{{ route('list_produit') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function previewImage(event, index) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgPreview = document.createElement('img');
                    imgPreview.src = e.target.result;
                    imgPreview.classList.add('img-fluid', 'mt-2');
                    const parentDiv = event.target.closest('.card-body');
                    parentDiv.appendChild(imgPreview);
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection