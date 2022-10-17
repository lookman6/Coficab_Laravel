<?php

namespace App\Http\Controllers;

use App\Models\Personne;
use Illuminate\Http\Request;

class PersonneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //return view('personnes.index');
    //     $personnes = Personne::all();
    //     return view('personnes.index',compact('personnes'));
    //    // $personnes = Personne::latest()->paginate(5);
    //     //return view('personnes.index',compact('personnes'))
    //     //    ->with('i',(request()->input('page',1)-1)*5);
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     return view('personnes.create');
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request  $request)
    // {
    //     //dd('Inscription effectuee !');
    //     $request->validate([
    //         'login' => 'required'
    //     ]);
    //     $input = $request->all();
    //     $personne = Personne::create($input);
    //     return $personne->id;
    //     //return redirect('personnes')->with('success', 'Ajout effectué !!!');
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Personne  $personne
    //  * @return \Illuminate\Http\Response
    //  */
    // //public function show(Personne $personne)
    // public function show($id)
    // {
    //    // return view('personnes.show');
    //     $personne = Personne::findOrFail($id);
    //     return view('personnes.show')->with('personnes', $personne);
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\Personne  $personne
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //    // return view('personnes.edit');
    //     $personne = Personne::findOrFail($id);
    //     return view('personnes.edit')->with('personnes', $personne);
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Personne  $personne
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     $personne = Personne::findOrFail($id);
    //     $input = $request->all();
    //     $personne->update($input);
    //     return redirect('personnes')->with('success', 'Modification effectuée !!'); 
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Personne  $personne
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     Personne::destroy($id);
    //     return redirect('personnes')->with('success', 'Suppression effectuée !!!'); 
    // }
}
