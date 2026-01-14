<?php

namespace App\Http\Controllers;

use App\Imports\ChargeImport;
use App\Imports\InvonImport;
use App\Imports\StockImport;
use App\Imports\StockInitialImport;
use App\Models\CaModel;
use App\Models\StockModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $stocks = StockModel::orderBy('date', 'desc')
        ->orderBy('categorie')
        ->orderBy('produit')
        ->get();
    
    return view('stocks.index', compact('stocks'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produits = CaModel::all();
        return view('stocks.create', compact('produits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
    
        Excel::import(new StockImport, $request->file('file'));
        return 'sak';
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


    public function importStockInitial(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        try {
            Excel::import(new StockInitialImport, $request->file('file'));
            return back()->with('success', 'Stock initial updated successfully!');
        } catch (\Exception $e) {
            Log::error('StockInitial Import Error: ' . $e->getMessage());
            return back()->with('error', 'Error during import.');
        }
    }
    
    public function importInventaire(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        try {
            Excel::import(new InvonImport, $request->file('file'));
            return back()->with('success', 'Inventaire updated successfully!');
        } catch (\Exception $e) {
            Log::error('Inventaire Import Error: ' . $e->getMessage());
            return back()->with('error', 'Error during import.');
        }
    }
    public function importCharge(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        try {
            Excel::import(new ChargeImport, $request->file('file'));
            return back()->with('success', 'Cahrge et decherge updated successfully!');
        } catch (\Exception $e) {
            Log::error('Cahrge et decherge Import Error: ' . $e->getMessage());
            return back()->with('error', 'Error during import.');
        }
    }
}
