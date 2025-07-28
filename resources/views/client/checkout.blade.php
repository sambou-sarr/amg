@extends('client.base')

@section('content')
<style>
    .checkout-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 2rem;
        background: #f8f9fa;
        border-radius: 15px;
    }

    .checkout-form {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .form-title {
        font-size: 1.8rem;
        color: #2C363F;
        margin-bottom: 2rem;
        text-align: center;
    }

    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        color: #2C363F;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        transition: all 0.3s ease;
        padding-left: 40px;
    }

    .form-control:focus {
        border-color: #2E7D32;
        box-shadow: 0 0 8px rgba(46, 125, 50, 0.2);
        outline: none;
    }

    .input-icon {
        position: absolute;
        left: 12px;
        top: 38px;
        color: #6c757d;
    }

    .checkout-btn {
        background: #28a745;
        color: white !important;
        border: none;
        padding: 1rem 2.5rem;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1.1rem;
        font-weight: 500;
        display: block !important;
        margin: 2rem auto 0;
        width: fit-content;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .checkout-btn:hover {
        background: #218838;
        transform: translateY(-2px);
    }

    .form-note {
        font-size: 0.9rem;
        color: #6c757d;
        margin-top: 1rem;
        text-align: center;
    }

    .error-message {
        color: #dc3545;
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }
</style>

<div class="checkout-container">
    <form action="{{ route('checkout.process') }}" method="POST" class="checkout-form">
        @csrf

        <h2 class="form-title">Informations de Livraison</h2>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label" for="first_name">Prénom</label>
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" 
                           class="form-control" 
                           id="first_name" 
                           name="first_name" 
                           required
                           pattern="[A-Za-zÀ-ÿ\s]{2,}">
                    @error('first_name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label" for="last_name">Nom</label>
                    <i class="fas fa-user-tag input-icon"></i>
                    <input type="text" 
                           class="form-control" 
                           id="last_name" 
                           name="last_name" 
                           required
                           pattern="[A-Za-zÀ-ÿ\s]{2,}">
                    @error('last_name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label" for="phone">Téléphone</label>
                    <i class="fas fa-phone input-icon"></i>
                    <input type="tel" 
                           class="form-control" 
                           id="phone" 
                           name="phone" 
                           required>
                         
                    @error('phone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label" for="email">Email (optionnel)</label>
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" 
                           class="form-control" 
                           id="email" 
                           name="email">
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="address">Adresse complète</label>
            <i class="fas fa-map-marker-alt input-icon"></i>
            <textarea class="form-control" 
                      id="address" 
                      name="address" 
                      rows="3" 
                      required></textarea>
            @error('address')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <p class="form-note">
            <i class="fas fa-info-circle me-2"></i>
            Nous ne partageons jamais vos informations personnelles
        </p>

        <button type="submit"    class="checkout-btn" aria-label="Confirmer la commande" style="background: linear-gradient(135deg, #4b79a1 0%, #283e51 100%); border: none;">
            <i class="fas fa-shopping-bag me-2"></i>Confirmer la commande
        </button>
    </form>
</div>

<script>
    // Formatage automatique du numéro de téléphone
    document.getElementById('phone').addEventListener('input', function(e) {
        let x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,2})(\d{0,2})(\d{0,2})/);
        e.target.value = !x[2] ? x[1] : x[1] + ' ' + x[2] + (x[3] ? ' ' + x[3] : '') + (x[4] ? ' ' + x[4] : '');
    });
</script>
@endsection