<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::with('categorie')->get();
        return view('admin.produit.list_produit', compact('produits'));
    }
    public function indexclient(Request $request)
    {
          // Récupérer tous les produits depuis la base de données
          $products = Produit::all();

          // Passer les produits à la vue
          return view('client.index', compact('products'));
    }

    public function create()
    {
       /* $categories = DB::table('categories')
            ->orderBy('libelle')
            ->get(['id', 'libelle']);*/

        return view('admin.produit.ajout_produit');
    }

    public function store(Request $request)
    {
            $images = [];
            $donnes = ['image', 'image1', 'image2'];
            
           foreach ($donnes as $field) {
            if ($request->hasFile($field)) {
                // C'est ce code qui envoie à Cloudinary
               $uploadedUrl = Cloudinary::uploadApi()->upload($request->file($field)->getRealPath())['secure_url'];
                $images[$field] = $uploadedUrl;
            }
        }


            $produit = new Produit();
            $produit->libelle =$request->libelle ;
            $produit->id_categorie = 0;
            $produit->stock = $request->stock;
            $produit->code = '800';
            $produit->prix_u = $request->prix;
            $produit->image1 = $images['image'] ?? null;
            $produit->image2 = $images['image1'] ?? null;
            $produit->image3= $images['image2'] ?? null;
           //dd($produit);
           $produit->save();

            return redirect()->route('list_produit')->with('success', 'Produit ajouté avec succès');
    }




    public function edit($id)
    {
        $produit = Produit::findOrFail($id);
        return view('admin.produit.edit_produit', compact('produit'));
    }

    public function update(Request $request)
    {
        $produit = Produit::find($request ->id );
        // Gestion des images
        $imageFields = ['image', 'image1', 'image2'];
        $updates = [];
        
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                Storage::delete($produit->$field);
                $path = $request->file($field)->store('public/assets/images');
                $updates[$field] = str_replace('public/', '', $path);
            }
        }
    
        // Mise à jour du produit
        
        $produit->libelle = $request->libelle;
        $produit-> id_categorie = 0;
        $produit->  stock = $request->stock;
        $produit-> prix_u = $request->prix_u;
        $produit-> code = 800;
        $produit->update();
        
    
        return redirect()->route('list_produit')->with('success', 'Produit modifié');
    }

    public function destroy($id)
    {
        Produit::findOrFail($id)->delete();
        return redirect()->route('list_produit')->with('success', 'Produit supprimé.');
    }
}
