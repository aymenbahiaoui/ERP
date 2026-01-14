<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CustomerImport;
use App\Models\CustomerModel;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    


    public function index()
    {
       
        $customers = CustomerModel::all();
    
       
        $salesData = $customers->map(function ($customer) {
            return [
                'produit' => $customer->produit, 
                'janvier' => $customer->janvier, 
                'février' => $customer->février,
                'mars' => $customer->mars,
                'avril' => $customer->avril,
                'mai' => $customer->mai,
                'juin' => $customer->juin,
                'juillet' => $customer->juillet,
                'août' => $customer->août,
                'septembre' => $customer->septembre,
                'octobre' => $customer->octobre,
                'novembre' => $customer->novembre,
                'décembre' => $customer->décembre
            ];
        });
    
       
        return view('costumer.index',compact('salesData'));
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
        $request->validate([
            "file" => "required|file"
        ]);

        Excel::import(new CustomerImport, $request->file('file'));

        return redirect()->back()->with('success', 'Fichier importé avec succès');
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
