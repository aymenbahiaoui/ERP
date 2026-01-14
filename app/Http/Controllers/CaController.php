<?php

namespace App\Http\Controllers;

use App\Imports\CaImport;
use App\Models\CaModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = CaModel::query();
    
      
        if (auth()->user()->role === 'comm') {
            $query->where('vendeur', auth()->user()->zone);
        }
    
       
        if(request()->filled('from_date') && request()->filled('to_date')) {
            $query->whereBetween('Date', [ 
                request('from_date'),
                request('to_date')
            ]);
        }
    
        if(request()->filled('ville')) {
            $query->where('ville', request('ville'));
        }
    
        if(request()->filled('client')) {
            $query->where('client', 'like', '%' . request('client') . '%');
        }
    
        if(request()->filled('categorie')) {
            $query->where('categorie', request('categorie'));
        }
    
        if(request()->filled('vendeur')) {
            $query->where('vendeur', request('vendeur'));
        }
    
        $data = $query->orderBy('Date', 'desc')->get();
    
        $villes = CaModel::select('ville')
                         ->distinct()
                         ->orderBy('ville')
                         ->pluck('ville');
    
        $vendeurs = CaModel::select('vendeur')
                           ->distinct()
                           ->orderBy('vendeur')
                           ->pluck('vendeur');
    
        $clientsByVille = CaModel::select('ville', 'client')
                                ->distinct()
                                ->orderBy('ville')
                                ->orderBy('client')
                                ->get()
                                ->groupBy('ville');
    
        $categories = CaModel::select('categorie')
                            ->distinct()
                            ->orderBy('categorie')
                            ->pluck('categorie');
    
        return view("ca.index", compact('data', 'villes', 'clientsByVille', 'categories', 'vendeurs'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ini_set("max_execution_time",3600);
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new CaImport, $request->file('file'));

        return back()->with('success', 'Importation réussie !');
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
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       
    }
}
