<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminAuthController extends Controller
{
    // Afficher le formulaire de connexion admin
    public function loginForm()
    {

        return view('admin.login');
    }

    // Traiter la tentative de connexion
   public function login(Request $request)
{
    // Valider les données saisies
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:8'
    ]);

    // Tenter d'authentifier l'utilisateur
    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if ($user->role == 'admin') {
              $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        // Authentification réussie et utilisateur est admin
       // Sécurise la session
    }

    // En cas d'échec
    return back()->withErrors([
        'email' => 'Identifiants incorrects'
    ])->onlyInput('email');
}


    // Déconnexion admin
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // Gestion mot de passe oublié (optionnel)
    public function showLinkRequestForm()
    {
        return view('admin.auth.passwords.email');
    }
}