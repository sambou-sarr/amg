<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\DetailCommande;
use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\User;
use App\Notifications\Alertadmin;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    // Afficher le panier
    public function index()
    {
        $cart = session()->get('cart', []);

        // Calculer le total du panier
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    
        // Passer le panier et le total à la vue
        return view('client.cart', compact('cart', 'total'));
    }

    // Afficher les produits disponibles
    public function indexp()
    {
        $produits = Produit::all();
        return view('client.index', compact('produits'));
    }

    // Ajouter un produit au panier
    public function add($id)
    {
        $product = Produit::find($id);
        
        if (!$product) {
            return redirect()->route('cart.index')->with('error', 'Produit introuvable');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id" => $product->id,
                "name" => $product->libelle,
                "price" => $product->prix_u,
                "image" => $product->image1,
                "quantity" => 1
            ];
        }
        session()->put('cart', $cart);
        session()->flash('success', 'Produit ajouté au panier avec succès!');
        return redirect()->route('cart.index')->with('success', 'Produit ajouté au panier');
    }

    // Modifier la quantité d'un produit dans le panier
    public function update(Request $request, $id)
    {
        $request->validate([
            'change' => 'required|integer',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->input('change');

            if ($cart[$id]['quantity'] <= 0) {
                unset($cart[$id]);
            }

            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Panier mis à jour');
    }

    // Supprimer un produit du panier
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Produit retiré du panier');
    }

    // Vider complètement le panier
    public function clear()
    {
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Panier vidé');
    }

    public function showForm(){
        return view('client.checkout');
    }

    
    public function processCommande(Request $request)
    {
        $user = new User();
        $user ->prenom = $request ->first_name;
        $user ->nom = $request ->last_name;
        $user ->telephone = $request->phone;
        $user ->email=$request->email ?? 'xxx@gmail.com';
        $user ->password =bcrypt('12345678');
        $user->save();
    
       
         
            // Création de la commande
            $commande = new Commande();
            
            $commande-> nom = $request->last_name.' '.$request->first_name;
            $commande->email = $request->email;
            $commande->adresse = $request->address;
            $commande-> telephone = preg_replace('/\s+/', '', $request->phone);
            $commande-> id_user = $user->id ?? null;
            $commande-> statut = 'en_attente';
            
    
            // Traitement des produits
            foreach (session()->get('cart') as $produitData) {
                $product = Produit::find($produitData['id']);
                
                if (!$product) {
                    throw new \Exception("Produit introuvable: {$produitData['id']}");
                }
    
                if ($product->stock < $produitData['quantity']) {
                    throw new \Exception("Stock insuffisant pour {$product->libelle}. Stock disponible: {$product->stock}");
                }
                $commande->save();
                // Création du détail de commande
               $DetailCommande =new  DetailCommande();
               $DetailCommande-> id_commande = $commande->id;
               $DetailCommande->id_produit = $product->id;
               $DetailCommande-> quantite = $produitData['quantity'];
               $DetailCommande-> prix_unitaire = $product->prix_u;
            
                // Mise à jour du stock de manière atomique
                $product->decrement('stock', $produitData['quantity']);
                $DetailCommande->save();
           
                
            }
            return redirect()->route('client.commandes.show', $commande->id)
                ->with('success', __('Commande créée avec succès'));
    }
    
    public function generateCommandePDF( $id)
    {
        // Implémentez la génération du PDF ici
        // Exemple avec DomPDF :
        
        $commande = Commande::findOrFail($id);
        $details = DetailCommande::where('id_commande', $id)->with('produit')->get();
        // Devrait retourner true si des enregistrements existent
        // Générer la facture PDF
        $pdf = PDF::loadView('facture.facture', compact('commande', 'details'));
         // redirect(route('commandes.details',$commande->id));
         $pdf->download("facture_{$commande->id}.pdf");
        // Télécharger le PDF
        return view('facture.facture' , compact('commande','details'));
    }
    
}