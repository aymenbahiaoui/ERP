<?php

namespace App\Http\Controllers;

use App\Models\CaiseModel;
use App\Models\Cheque;
use App\Models\ChequeModel;
use App\Models\CommerciauxModel;
use Illuminate\Http\Request;

class ChequeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vendeurs = CommerciauxModel::whereNotNull('vendeur')->distinct()->get();
        
        $chequesQuery = ChequeModel::with(['client', 'vendeur', 'montant']);
    
        if ($request->has('vendeur') && $request->vendeur != '') {
            $chequesQuery->whereHas('vendeur', function ($q) use ($request) {
                $q->where('vendeur', $request->vendeur);
            });
        }
    
        if ($request->has('etat') && $request->etat != '') {
            $chequesQuery->where('etat', $request->etat);
        }
    
        $cheques = $chequesQuery->get();
        
        $totalMontant = $cheques->sum(function ($cheque) {
            return $cheque->montant->cheque_details ?? 0;
        });
        
        return view('cheque.index', compact('cheques', 'totalMontant', 'vendeurs'));
    }
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $cheque = ChequeModel::find($id);
        return view("cheque.edit",compact('cheque'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'N_cheque' => 'required|string|max:255',
        'date2' => 'required|date',
        'etat' => 'required|string|in:en garante,payés,impayée,en caissement,en port feiule,contre espèce',
    ]);

    $cheque = ChequeModel::findOrFail($id);
    $cheque->N_cheque = $request->N_cheque;
    $cheque->date2 = $request->date2;
    $cheque->etat = $request->etat;
    $cheque->save();

    return redirect()->route('cheque.index')->with('success', 'Cheque updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
