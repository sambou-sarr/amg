<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProduitController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;


Route::get('/create-admin', function () {
    $admin = User::updateOrCreate(
        ['email' => 'diopjunior015@gmail.com'],
        [
            'nom' => 'diop',
            'prenom' => 'junior',
            'telephone' => '+221781498848',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
        ]
    );
    return 'Admin créé ou mis à jour !';
});


Route::get('/user', function () {return view('index');});


Route::get('/admin/categorie',[CategorieController::class, 'index'])->name('list_categorie')->middleware('auth');
Route::get('/admin/categorie/ajout',[CategorieController::class, 'create'])->middleware('auth');
Route::post('/admin/categorie/store',[CategorieController::class, 'store'])->middleware('auth');
Route::get('/admin/categorie/edit/{id}', [CategorieController::class, 'edit'])->name('edit_categorie')->middleware('auth');
Route::delete('/admin/categorie/delete/{id}', [CategorieController::class, 'destroy'])->name('supprimer_categorie')->middleware('auth');
Route::put('/admin/categorie/update',[CategorieController::class, 'update'])->name('update_categorie')->middleware('auth');

Route::get('/admin/produit',[ProduitController::class, 'index'])->name('list_produit')->middleware('auth');
Route::get('admin/produit/create', [ProduitController::class, 'create'])->name('produit.create')->middleware('auth');
Route::post('/admin/produit/store',[ProduitController::class, 'store'])->name('ajout_Produit')->middleware('auth');
Route::get('/admin/produit/edit/{id}', [ProduitController::class, 'edit'])->name('edit_produit')->middleware('auth');
Route::delete('/admin/produit/delete/{id}', [ProduitController::class, 'destroy'])->name('supprimer_produit')->middleware('auth');
Route::put('/admin/produit/update',[ProduitController::class, 'update'])->name('update_produit')->middleware('auth');


Route::get('/admin/commande', [CommandeController::class, 'index'])->name('commandes.index')->middleware('auth');
Route::put('/commandes/{id}/update', [CommandeController::class, 'updateStatus'])->name('commandes.update')->middleware('auth');

Route::get('admin/commande/create', [CommandeController::class, 'create'])->name('commande.create')->middleware('auth');
Route::post('/commande/store', [CommandeController::class, 'store'])->name('commande.store')->middleware('auth');
Route::get('/commande/{id}', [CommandeController::class, 'show'])->name('commande.show')->middleware('auth');

Route::get('/commandes/{id}', [CommandeController::class, 'details'])->name('commandes.details')->middleware('auth');
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/commandes/{commande}/facture', [CommandeController::class, 'downloadFacture'])->name('commandes.download.facture')->middleware('auth');

// Routes accessibles uniquement aux invités (non connectés)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
});

// Route accessible uniquement aux utilisateurs connectés
Route::middleware('auth')->group(function () {
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

Route::get('/client',[ProduitController::class, 'indexclient'])->name('client.index');




Route::get('/reset-db', function () {
    if (request()->get('token') !== 'ton_token_secret') {
        abort(403, 'Accès non autorisé');
    }

    try {
        Artisan::call('migrate:fresh', ['--force' => true]);
        return '✅ Base de données réinitialisée et migrations relancées.';
    } catch (\Exception $e) {
        return '❌ Erreur : ' . $e->getMessage();
    }
});


Route::get('/', [CartController::class, 'indexp']);
Route::get('/admin', [CartController::class, 'indexp1']);


// Route pour voir un produit en détail
Route::get('/product/{id}', [CartController::class, 'show'])->name('product.show');

// Routes du panier
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/checkout', [CartController::class, 'showForm'])->name('checkout');
Route::post('/commandes/client', [CartController::class, 'processCommande'])->name('checkout.process');
Route::get('/commandes/client/{commande}', [CartController::class, 'generateCommandePDF'])->name('client.commandes.show');