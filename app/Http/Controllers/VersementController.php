<?php

namespace App\Http\Controllers;

use App\Models\CaiseModel;
use App\Models\verModel;
use App\Models\VersementModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VersementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = VersementModel::query();
    $user = auth()->user();
    if ($request->has('vendeur') && $request->vendeur != '') {
        $query->where('vendeur', $request->vendeur);
    }
    if ($user->role === 'comm') {
        $query->where('vendeur', $user->zone);
    }
    
    $versements = $query->get();
    
    return view('versement.index', compact("versements"));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::allows('admin') || Gate::allows('df') || Gate::allows('comm')) {
            $vendeurs = CaiseModel::select('vendeur', 'id')->distinct()->get();
            return view('versement.create', compact('vendeurs'));
        }

        abort(403, "allah yhdik a m3alm");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'montant' => 'required|numeric|min:0',
    ]);

   
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->storeAs('versement', time() . '.' . $request->image->extension());
    }

   
    VersementModel::create([
        "vendeur" => auth()->user()->zone,
        'image' => $imagePath, 
        'montant' => $request->montant,
        'validation' => 0,
    ]);

    return redirect()->route("verement.index")->with("success",'Utilisateur ajoutée avec succès!');
}

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
   
    $request->validate([
        'validation' => 'required|in:0,1',
    ]);

   
    $versement = VersementModel::findOrFail($id);

   
   

   
    $versement->update([
        'validation' => $request->validation,
    ]);

   
    return redirect()->route('verement.index')
        ->with('update', 'Statut de validation mis à jour avec succès');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       
    }

    /**
     * Handles the additional versement submission with optional image.
     */
   
   
   
   
   
   

   

   
   
   
   
   

   
   
   
   

   
   

    /**
     * Update validation status and optionally transfer to VersementModel.
     */
   
   
   
   
   

   

   

   
   
   
   
   
   
   
   

   

   
   
}
