<?php

namespace App\Http\Controllers;

use App\Models\CommerciauxModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class usersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        
        if(Gate::allows("admin")){
           $users = User::all();
        return view("users.index",compact('users')); 

        }
        abort(403,"allah yhdik a m3alm");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
      
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
           
            'role' => 'user', 
        ]);
    
     
        return redirect()
               ->route('users.index')
               ->with('success', 'Utilisateur créé avec succès!');
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
        $user = User::find($id);
        $commerciaux = CommerciauxModel::all();
        
        return view("users.edit",compact('user',"commerciaux"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string|in:dc,df,dg,user,comp,sup,comm',
        ]);
    
        $user = User::findOrFail($id);
    
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        if ($request->input('role') === 'comm') {
            $user->zone = $request->input('zone');
        } else {
            $user->zone = null;
        }
    
        $user->save();
    
        return redirect()->route('users.index')->with('update', "L'utilisateur a été mis à jour avec succès");
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('delete', "L'utilisateur a été suprimée avec succès");

    }
}
