<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CabinetExterne;

class CabinetExterneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cabinets = CabinetExterne::all();

        return view("cabinet_externes.index",compact(['cabinets']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ("cabinet_externes.create");
    }

    public function getCabinets()
    {
        return CabinetExterne::all();
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
        CabinetExterne::create([
            'nom' => $request->nom,
            'adresse' => $request->adresse
        ]);

        return redirect (route('cabinets.index'))->withSuccess('Cabinet créé avec succcès!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CabinetExterne $cabinet)
    {
        return view('cabinet_externes.show',compact(['cabinet']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CabinetExterne $cabinet)
    {
        return view("cabinet_externes.edit",compact(['cabinet']));
    }


    private function validateTheForm (Request $request)
    {
        $request->validate([
            'nom' => "required",
            'adresse' => "required"
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CabinetExterne $cabinet)
    {
        $this->validateTheForm($request);
        CabinetExterne::where('id',$cabinet->id)->update([
            'nom' => $request->nom,
            'adresse' => $request->adresse
        ]);
        
        return redirect(route('cabinets.index'))->withSuccess('modification des informations du cabinet effecutée avec succès!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CabinetExterne $cabinet)
    {
        CabinetExterne::where('id',$cabinet->id)->delete();

        return redirect(route('cabinets.index'))->withWarning('suppression du cabinet effectuée avec succès!');
    }
}
