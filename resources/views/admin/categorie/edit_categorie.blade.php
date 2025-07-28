@extends('admin.base')
    @section('content')
        <br><br>
    <div class="container mt-4">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-plus-circle"></i> Modification produit</h3>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('update_categorie') }}">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label class="form-label">Libellé</label>
                        <input type="hidden" name="id" class="form-control" value="{{$categorie->id}}" maxlength="100">
                        <input type="text" name="libelle" class="form-control" value="{{$categorie->libelle}}" maxlength="100">
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                        <a href="#" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
