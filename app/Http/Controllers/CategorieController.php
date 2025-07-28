<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categorie::all();
        return view('admin.categorie.list_categorie',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categorie.ajout_categorie');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $categorie = new Categorie();
        $categorie->libelle = $request->libelle;
        $categorie->save();
        return redirect()->route('list_categorie');
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
    public function edit($id)
    {
        $categorie = Categorie::find($id);
        return view('admin.categorie.edit_categorie',compact('categorie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $categorie = Categorie::find($request->id);
        $categorie->libelle = $request->libelle ;
        $categorie->update();
        return redirect()->route('list_categorie');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categorie = Categorie::find($id);
        $categorie->delete();
        return redirect()->route('list_categorie');
    }
}
