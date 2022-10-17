<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salle;

class SalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salles = Salle::all();
        return view('salles.index',compact('salles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('salles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateTheForm($request);
        Salle::create([
            'intitule' => $request->intitule
        ]);
        return redirect (route('salles.index'))->withSuccess('salle ajoutée avec succcès!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Salle $salle)
    {
        return view('salles.show',compact(['salle']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Salle $salle)
    {
        return view('salles.edit',compact(['salle']));
    }

    private function validateTheForm (Request $request)
    {
        $request->validate([
            'intitule' => "required",
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Salle $salle)
    {
        $this->validateTheForm($request);
        Salle::where('id',$salle->id)->update([
            'intitule' => $request->intitule,
        ]);
        
        return redirect(route('salles.index'))->withSuccess('modification des informations de la salle effecutée avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salle $salle)
    {
        Salle::where('id',$salle->id)->delete();

        return redirect(route('salles.index'))->withWarning('suppression de la salle effectuée avec succès!');
    }
}
