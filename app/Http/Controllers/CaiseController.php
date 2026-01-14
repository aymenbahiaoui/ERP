<?php

namespace App\Http\Controllers;

use App\Models\CaiseModel;
use App\Models\VersementModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CaiseController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request)
     {
         $query = CaiseModel::query();
         if (auth()->user()->role === 'comm') {
             $query->where('vendeur', auth()->user()->zone);
         }
     
         $versementQuery = VersementModel::query();
     
       
     
        
         if ($request->has('vendeur') && !empty($request->vendeur)) {
             $query->where('vendeur', $request->vendeur);
            
            
         }
     
        
         if ($request->has('date_debut') && !empty($request->date_debut)) {
             $query->whereDate('created_at', '>=', $request->date_debut);
             $versementQuery->whereDate('created_at', '>=', $request->date_debut);
         }
     
        
         if ($request->has('date_fin') && !empty($request->date_fin)) {
             $query->whereDate('created_at', '<=', $request->date_fin);
             $versementQuery->whereDate('created_at', '<=', $request->date_fin);
         }
     
         $fact = $query->get();
     
        
         $totalVersement = $versementQuery->where('validation',1)->sum('montant');
     
       
     
         return view('caise.index', compact('fact', 'totalVersement'));
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
    public function edit($id)
{
    $caise = CaiseModel::find($id);
    return view('caise.edit', compact('caise'));
}


    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
{
    $caise = CaiseModel::findOrFail($id);

    $modes = $request->input('mode_de_paiement', []);
    $caise->mode_de_paiement = implode(',', $modes);

    $caise->cheque_details   = in_array('cheque', $modes) ? $request->input('cheque_details') : null;
    $caise->espece_details   = in_array('espece', $modes) ? $request->input('espece_details') : null;
    $caise->instance_details = in_array('instance', $modes) ? $request->input('instance_details') : null;
    

    $caise->montant_payant = $request->input('montant_payant');
    $caise->montant_reste  = $request->input('montant_reste');
    $caise->validation     = $request->input('validation');

    $caise->update();

   
    if (in_array('cheque', $modes)) {
        $exists = \App\Models\ChequeModel::where('client_id', $caise->id)->exists();

        if (!$exists) {
            \App\Models\ChequeModel::create([
                'date1'      => now(),
                'N_cheque'   => null,
                'client_id'  => $caise->id,
                'numero_facture_id' => $caise->id,
                'vendeur_id' => $caise->id,
                'montant_id' => $caise->id,
               
                'date2'      => now(),
            ]);
        }
    } else {
       
        \App\Models\ChequeModel::where('client_id', $caise->id)->delete();
    }

    return redirect()->route('caise.index')->with('edit', 'BL modifiée avec succès.');
}

    
    
    
    
    
    
    
    
    
    
    
        
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
