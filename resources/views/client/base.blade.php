<!-- layouts/base.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AMG Jus Naturels - Dakar')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2E7D32;
            --secondary: #FF8F00;
            --text-dark: #2C363F;
            --bg-light: #F8F9FA;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
        }

        .navbar {
             background: linear-gradient(135deg, #4b79a1 0%, #283e51 100%);
        }

        .navbar-brand, .nav-link {
            color: #fff !important;
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        .hero-section {
            background: url('/images/banner.jpg') no-repeat center center/cover;
            color: white;
            text-align: center;
            padding: 0px;
            position: relative;
        }

        .hero-section::after {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        footer {
            background: linear-gradient(135deg, #4b79a1 0%, #283e51 100%);
            color: #ccc;
            padding: 40px 0 20px;
        }

        footer a {
            color: #aaa;
        }

        footer a:hover {
            color: var(--primary);
        }
    </style>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg" style="background-color: #2d2d2d;">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand text-white fw-bold" href="{{ route('client.index') }}">
            <img src="{{ asset('logoamg.png') }}" alt="Logo" style="height: 40px;">
            Amg Juices
        </a>

        <!-- Toggle mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>

        <!-- Liens -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item me-4">
                    <a class="nav-link text-white fw-semibold" href="{{ route('client.index') }}">Accueil</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link text-white fw-semibold" href="#products">Nos Jus</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link text-white fw-semibold" href="#footers">Contact</a>
                </li>
                <li class="nav-item position-relative">
                    <a class="nav-link text-white" href="{{ route('cart.index') }}">
                        <i class="fas fa-shopping-cart fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success text-dark">
                            {{ session('cart') ? count(session('cart')) : 0 }}
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>



<!-- Hero -->
@if(Route::is('client.index'))
<div class="hero-section position-relative">
    <img src="{{ asset('banner.jpg') }}" alt="Jus naturels" class="w-100"
         style="height: 400px; object-fit: cover; filter: brightness(0.6);">
    <div class="hero-content position-absolute top-50 start-50 translate-middle text-center text-white">
        <h1 class="display-5 fw-bold">Jus 100% Naturels à Dakar</h1>
        <p class="lead">Bisap, Gingembre, Bouye et bien plus encore</p>
        <a href="#products" class="btn btn-success btn-lg mt-3" style="background: linear-gradient(135deg, #4b79a1 0%, #283e51 100%); border: none;">Voir les produits</a>
    </div>
</div>
@endif



<!-- Content -->
<main class="container mt-5">
    @yield('content')
</main>

<!-- Footer -->
<footer id="footers">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5>À propos</h5>
                <p>Basés à Dakar, nous produisons des jus de fruits naturels sans conservateurs.</p>
            </div>
            <div class="col-md-3">
                <h5>Contact</h5>
                <ul class="list-unstyled small">
                    <li>📍 HLM5, Dakar</li>
                    <li>📞 +221 78 149 88 48</li>
                    <li>📧 diopjunior015@gmail.com</li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>Suivez-nous</h5>
                <a href="#" class="me-2"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="https://wa.me/221781498848"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
        <hr>
        <p class="text-center small">© 2024 AMG Jus Naturels. Tous droits réservés. By <a href="https://wa.me/221772476160">Sambou</a></p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
