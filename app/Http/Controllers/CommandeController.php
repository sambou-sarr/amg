<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\DetailCommande;
use App\Models\Produit;
use App\Models\User;
use App\Notifications\Alertadmin;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Correct sous Laravel 11

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer les commandes avec les informations du client
        $commandes = Commande::with('user')->orderBy('created_at', 'desc')->get();
        
        return view('admin.commande.list_commande', compact('commandes'));
    }

    public function updateStatus(Request $request, $id)
    {
        $commande = Commande::find($id);
        $commande->Statut = $request->statut;
        $commande->update();

        return redirect()->route('commandes.index')->with('success', 'Statut mis à jour.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produits = Produit::all();
        $clients = User::all(); // Si vous utilisez User comme client
        return view('admin.commande.ajout_commande', compact('produits', 'clients'));
    }

    public function store(Request $request)
    {
       
            $commande = new Commande();
            // Création de la commande
                $commande ->nom       = $request->client_nom;
                $commande  ->email     = $request->client_email;
                $commande  ->adresse   = $request->client_adresse;
                $commande  ->telephone = $request->client_telephone;
                $commande  ->id_user   = $request->client_id ?? 0;
                $commande  ->statut = 'en_attente';
                $commande->save();

            // Ajout des produits
            foreach ($request->produits as $produit) {
                $product = Produit::findOrFail($produit['id']);

                if ($product->stock < $produit['quantite']) {
                    throw new \Exception("Stock insuffisant pour {$product->libelle}");
                }

                $DetailCommande = new DetailCommande();
                $DetailCommande -> id_commande  = $commande->id;
                $DetailCommande -> id_produit   = $product->id;
                $DetailCommande ->  quantite     = $produit['quantite'];
                $DetailCommande ->   prix_unitaire= $product->prix_u;

                // Mise à jour du stock
                $product->decrement('stock', $produit['quantite']);
                $details[] = $DetailCommande;
                $DetailCommande->save();

            }
           // dd($details);
            // Générer le PDF
             $admin = User::where('role', 'admin')->first(); // ou autre critère
                if ($admin) {
                    $admin->notify(new Alertadmin($commande, $details));
                }

          
            return redirect()->route('commandes.index', $commande->id)->with('success', 'Commande créée avec succès.');

    }

        public function downloadFacture($commandeId)
        {
            $commande = Commande::findOrFail($commandeId);
            $details = DetailCommande::where('id_commande', $commandeId)->with('produit')->get();
            // Supposons que vous avez une relation pour obtenir les articles
            // Générer la facture PDF
            $pdf = PDF::loadView('facture.facture', compact('commande', 'details'));
             // redirect(route('commandes.details',$commande->id));
        
            // Télécharger le PDF
            return $pdf->download("facture_{$commande->id}.pdf");
        }
        

    public function details($id)
    {
     
    
        $commande = Commande::findOrFail($id);
        $articles = DetailCommande::where('id_commande', $id)
            ->join('produits', 'detail_commandes.id_produit', '=', 'produits.id')
            ->select('produits.libelle as produit_nom', 'detail_commandes.quantite', 'detail_commandes.prix_unitaire')
            ->get();
            

        return view('admin.commande.details_commande', compact('commande', 'articles'));
    }
     


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
