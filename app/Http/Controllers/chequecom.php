<?php

namespace App\Http\Controllers;

use App\Models\CaiseModel;
use App\Models\chequecomModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class chequecom extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        $vendeurs = ChequecomModel::distinct()->pluck('vendeur');
    
       
        $cheques = ChequecomModel::query();
    
       
        if (Auth::user()->role === 'comm') {
            $cheques->where('vendeur', Auth::user()->zone);
        } elseif (request('vendeur')) {
           
            $cheques->where('vendeur', request('vendeur'));
        }
    
        $cheques = $cheques->orderBy('created_at', 'desc')->get();
    
       
        $totalCheques = ChequecomModel::when(Auth::user()->role === 'comm', function ($query) {
                                $query->where('vendeur', Auth::user()->zone);
                            })
                            ->when(request('vendeur') && Auth::user()->role !== 'comm', function ($query) {
                                $query->where('vendeur', request('vendeur'));
                            })
                            ->sum('montantbl');
    
        return view('chequeecom.index', compact('cheques', 'vendeurs', 'totalCheques'));
    }
    
    
    


    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $userZone = Auth::user()->zone;
    $factures = CaiseModel::where('vendeur', $userZone)->get();

   
    $partialPayments = ChequecomModel::where('vendeur', $userZone)
        ->get()
        ->groupBy('bl') 
        ->map(function ($group) {
            return $group->last(); 
        });

    if ($factures->isEmpty()) {
        return redirect()->back()->with('warning', 'Aucune facture trouvée pour votre zone.');
    }

    return view('chequeecom.create', compact('factures', 'partialPayments'));
}

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'montantbl' => 'required|numeric',
            'montantpayant' => 'required|numeric',
            'instance' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'factures' => 'required|array|min:1',
            'datebl' => 'required|date',
            'datepaiment' => 'required|date',
            'datedecheance' => 'required|date',
        ]);
    
       
        $imagePath = $request->file('image')->store('chequecom', 'public');
    
       
        $bl = implode(', ', $request->factures);
    
       
        $paymentDate = new \DateTime($request->datepaiment);
        $dueDate = new \DateTime($request->datedecheance);
        $daysDifference = $paymentDate->diff($dueDate)->days;
    
       
        ChequecomModel::create([
            'vendeur' => Auth::user()->zone,
            'montantbl' => $request->montantbl,
            'montantpayant' => $request->montantpayant,
            'instance' => $request->instance,
            'image' => $imagePath,
            'bl' => $bl,
            'datebl' => $request->datebl,
            'datepaiment' => $request->datepaiment,
            'datedecheance' => $request->datedecheance,
            
        ]);
    
        return redirect()->route('cheques.index')->with('success', 'Chèque enregistré avec succès.');
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
        $userZone = Auth::user()->zone;
        $cheque = chequecomModel::findOrFail($id);
        $factures = CaiseModel::where('vendeur', $userZone)->get();
        $facturesUtilisees = explode(',', $cheque->bl);
    
        return view('chequeecom.edit', compact('cheque', 'factures', 'facturesUtilisees'));
    }
    
    public function update(Request $request, string $id)
    {
        $request->validate([
            'montant' => 'required|numeric',
            'factures' => 'required|array|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $cheque = chequecomModel::findOrFail($id);
        $cheque->montant = $request->montant;
        $cheque->bl = implode(', ', $request->factures);
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chequecom', 'public');
            $cheque->image = $imagePath;
        }
    
        $cheque->save();
    
        return redirect()->route('cheques.index')->with('success', 'Chèque mis à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cheque = chequecomModel::findOrFail($id);
        $cheque->delete();
        
        return back()->with('delete', 'Chèque supprimé avec succès!');
    }
    public function valcheque($id, Request $request)
{
    $cheque = chequecomModel::findOrFail($id);
    
    $request->validate([
        'validation' => 'required|in:0,1'
    ]);

    $cheque->update([
        'validation' => $request->validation
    ]);

    return back()->with('success', 'Statut du chèque mis à jour!');
}
public function contunier($id) {
    $cheque = ChequecomModel::findOrFail($id);
    $userZone = Auth::user()->zone;
    
   
    $existingFactures = [];
    if (!empty($cheque->bl)) {
        $existingFactures = explode(',', $cheque->bl);
    }
    
   
    $usedFactureNumbers = ChequecomModel::whereNotNull('bl')
        ->where('id', '!=', $id)
        ->pluck('bl')
        ->flatMap(function($bl) {
            return explode(',', $bl);
        })
        ->filter()
        ->unique()
        ->values();
    
   
    $factures = CaiseModel::where('vendeur', $userZone)
        ->where(function($query) use ($usedFactureNumbers, $existingFactures) {
            $query->whereNotIn('numero_facture', $usedFactureNumbers)
                  ->orWhereIn('numero_facture', $existingFactures);
        })
        ->get();
    
    return view('chequeecom.contunier', [
        'cheque' => $cheque,
        'factures' => $factures,
        'existingFactures' => $existingFactures
    ]);
}
public function storeContinued(Request $request)
    {
        $request->validate([
            'montantbl' => 'required|numeric',
            'montantpayant' => 'required|numeric',
           
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'factures' => 'required',
            'datebl' => 'required|date',
            'datepaiment' => 'required|date',
            'datedecheance' => 'required|date',
        ]);

       
        $imagePath = $request->file('image')->store('chequecom', 'public');

        $bl = implode(', ', $request->factures);

        ChequecomModel::create([
            'vendeur' => Auth::user()->zone,
            'montantbl' => $request->montantbl,
            'montantpayant' => $request->montantpayant,
            'instance' => $request->montantbl - $request->montantpayant,
            'image' => $imagePath,
            'bl' => $bl,
            'datebl' => $request->datebl,
            'datepaiment' => $request->datepaiment,
            'datedecheance' => $request->datedecheance,
        ]);

        return redirect()->route('cheques.index')->with('success', 'Chèque enregistré avec succès.');
    }

}


