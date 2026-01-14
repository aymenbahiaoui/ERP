<?php

namespace App\Http\Controllers;

use App\Models\ImportationsModel;
use App\Models\SkuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ImportationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = ImportationsModel::query();

    if ($request->has('sku_filter') && $request->sku_filter != '') {
        $query->whereHas('sku', function($q) use ($request) {
            $q->where('nom', 'like', '%'.$request->sku_filter.'%');
        });
    }

    $items = $query->get();

    $cout_moyen = null;
    if ($request->has('sku_filter') && $items->count() > 0) {
        $cout_moyen = $items->avg('cout_total');
    }

    return view("importations.index", compact("items", "cout_moyen"));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Gate::allows('admin') || Gate::allows('df')) {
            $skus = SkuModel::all();
        return view('importations.create',compact("skus"));
        }
        abort(403,"yhdik allah am3lm");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    ImportationsModel::create($request->all());

    return redirect()->route('importations.index')->with('success', 'Importation ajoutée avec succès.');
}

    
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = ImportationsModel:: find($id);
        return view('importations.show',compact("item"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $skus = SkuModel::all();
        $item = ImportationsModel:: find($id);
        return view('importations.edit',compact("item","skus"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    
    $importation = ImportationsModel::findOrFail($id);

    
    $importation->update($request->all());

    
    return redirect()->route('importations.index')->with('success', 'Importation mise à jour avec succès.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $p = ImportationsModel::find($id);
            $p->delete();
            return redirect()->back();
    }
    
    
}
