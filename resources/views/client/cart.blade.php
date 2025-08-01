@extends('client.base')

@section('content')
<style>
body {
    background: #f5f5f5;
}

.cart-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.cart-title {
    font-size: 2rem;
    color: #283e51;
    margin-bottom: 2rem;
    text-align: center;
}

.empty-cart {
    text-align: center;
    padding: 3rem;
    color: #6c757d;
    font-size: 1.2rem;
}

.cart-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 2rem;
    background: #2c3e50; /* ✅ Fond constant sombre */
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    color: white;
}

.cart-table th {
    background: #4b79a1;
    color: white;
    padding: 1rem;
    text-align: left;
}

.cart-table td {
    padding: 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1); /* Lignes plus douces */
}

.cart-item-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.quantity-btn {
    background: linear-gradient(135deg, #4b79a1 0%, #283e51 100%);
    color: white;
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
}

.quantity-btn:hover {
    transform: scale(1.1);
    opacity: 0.9;
}

.remove-btn {
    background: #dc3545;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.remove-btn:hover {
    background: #bb2d3b;
}

.total-section {
    text-align: right;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.total-amount {
    font-size: 1.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, #4b79a1 0%, #283e51 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.clear-cart-btn {
    background: #dc3545;
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: block;
    width: 100%;
    max-width: 200px;
    margin: 0 auto;
    text-align: center;
}

.clear-cart-btn:hover {
    background: #bb2d3b;
    transform: translateY(-2px);
}

.checkout-btn {
    text-decoration: none !important;
    background: linear-gradient(135deg, #4b79a1 0%, #283e51 100%);
    color: white !important;
    border: none;
    padding: 1rem 2.5rem;
    border-radius: 30px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1.1rem;
    font-weight: 500;
    display: block;
    margin: 20px auto;
    width: fit-content;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.checkout-btn:hover {
    transform: translateY(-2px);
    opacity: 0.9;
}

.success-message {
    background: #d4edda;
    color: #155724;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 2rem;
    text-align: center;
}

/* Mobile */
@media (max-width: 768px) {
    .cart-table thead {
        display: none;
    }

    .cart-table tr {
        display: flex;
        flex-direction: column;
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 8px;
        background-color: #34495e; /* Mobile row bg */
    }

    .cart-table td {
        padding: 0.5rem;
        border: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cart-table td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #ecf0f1;
        margin-right: 1rem;
    }

    .cart-item-image {
        width: 100%;
        height: 150px;
        margin-bottom: 1rem;
    }

    .quantity-controls {
        justify-content: center;
    }
}
</style>

<div class="cart-container">
    <h2 class="cart-title">Mon Panier</h2>

    @if(session('success'))
        <p class="success-message">{{ session('success') }}</p>
    @endif

    @if(empty($cart))
        <div class="empty-cart">
            <i class="fas fa-shopping-cart fa-3x mb-3"></i>
            <p>Votre panier est vide.</p>
        </div>
    @else
        <table class="cart-table">
            <thead>
                <tr>
                    <th></th>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $item)
                    <tr>
                        <td data-label="">
                            <img src="{{  $item['image']) }}" 
                                 class="cart-item-image" 
                                 alt="{{ $item['name'] }}">
                        </td>
                        <td data-label="Produit">{{ $item['name'] }}</td>
                        <td data-label="Prix">{{ number_format($item['price']) }} FCFA</td>
                        <td data-label="Quantité">
                            <div class="quantity-controls">
                                <form action="{{ route('cart.update', $item['id']) }}" method="POST">
                                    @csrf
                                    <button type="submit" name="change" value="-1" class="quantity-btn">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span>{{ $item['quantity'] }}</span>
                                    <button type="submit" name="change" value="1" class="quantity-btn">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        <td data-label="Actions">
                            <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                @csrf
                                <button type="submit" class="remove-btn">
                                    <i class="fas fa-trash-alt me-2"></i>Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <p class="total-amount">Total : {{ number_format($total, 0, ',', ' ') }} FCFA</p>
        </div>

        <form action="{{ route('cart.clear') }}" method="POST">
            @csrf
            <button type="submit" class="clear-cart-btn">
                <i class="fas fa-trash me-2"></i>Vider le panier
            </button>
        </form>

        <a href="{{ route('checkout') }}" class="checkout-btn" role="button">
            <i class="fas fa-shopping-bag me-2"></i>Commander
        </a>
    @endif
</div>
@endsection
