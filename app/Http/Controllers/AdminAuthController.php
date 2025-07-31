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
    
        // Validation des données
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8'
        ]);

        // Tentative d'authentification avec vérification du rôle
      
        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::user();
            
            if($user->role !== 'admin') {
                Auth::logout();
                return back()->withErrors(['email' => 'Accès réservé aux administrateurs']);
            }

            $request->session()->regenerate();
            
            return redirect()->intended(route('dashboard'));
        }

        // Retour en cas d'échec
        return back()->withErrors([
            'email' => 'Identifiants incorrects ou accès non autorisé',
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