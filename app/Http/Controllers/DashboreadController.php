<?php

namespace App\Http\Controllers;

use App\Models\CaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboreadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
   
    public function index()
    {
        $user = auth()->user();
        $query = CaModel::query();
    
       
        if ($user->role == 'comm') {
            $query->where('vendeur', $user->zone);
        }
    
        $topClients = $query->clone()
                    ->select('client', DB::raw('SUM(valeur_fact) as total'))
                    ->groupBy('client')
                    ->orderByDesc('total')
                    ->take(5)
                    ->get();
    
        $topArticles = $query->clone()
                    ->select('designation', DB::raw('SUM(qte_fact) as total_quantity'))
                    ->groupBy('designation')
                    ->orderByDesc('total_quantity')
                    ->take(5)
                    ->get();
    
        $topVendeur = $query->clone()
                    ->select('vendeur', DB::raw('SUM(qte_fact) as total_quantity'))
                    ->groupBy('vendeur')
                    ->orderByDesc('total_quantity')
                    ->take(5)
                    ->get();
    
        $topCategorie = $query->clone()
                    ->select('categorie', DB::raw('SUM(qte_fact) as total_quantity'))
                    ->groupBy('categorie')
                    ->orderByDesc('total_quantity')
                    ->take(5)
                    ->get();
    
        return view('dashboard', compact('topClients', 'topArticles', 'topVendeur', 'topCategorie'));
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
