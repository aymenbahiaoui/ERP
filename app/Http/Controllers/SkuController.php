<?php

namespace App\Http\Controllers;

use App\Models\Sku;
use App\Models\SkuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SkuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skus = SkuModel::all();
        if(Gate::allows('admin') || Gate::allows('df')){
            return view("sku.create",compact("skus"));

        }
        abort(403,"allah yhdik a m3alm");
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
       
        $skus = SkuModel::all();
        if(Gate::allows('admin') || Gate::allows('df')){
            $newsku = new SkuModel();
            $newsku->nom = $request ->nom;
            $newsku ->save();
            return redirect()->route('importations.create')->with("success",'SKU est ajoutée avec succès!');

        }
        abort(403,"allah yhdik a m3alm");
    }

    /**
     * Display the specified resource.
     */
    public function show(SkuModel $sku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (Gate::allows('admin') || Gate::allows('df')) {
            $sku = SkuModel::find($id);
            $skus = SkuModel::all();
            return view('sku.edit', compact("sku", "skus"));
        }
    
        abort(403, "Access denied.");
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
 
       

        if(Gate::allows('admin') || Gate::allows('df')) {
            $newsku =SkuModel::find($id);
            $newsku->nom = $request ->nom;
            $newsku ->update();
            return redirect()->route('importations.create');

        }
        abort(403,"allah yhdik a m3alm");


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       

        if(Gate::allows('admin') || Gate::allows('df')) {
            $newsku =SkuModel::find($id);
            $newsku ->delete();
            return redirect()->route('importations.create');

        }
        abort(403,"allah yhdik a m3alm");
    }
}
