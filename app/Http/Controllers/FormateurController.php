<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Formateur;
use App\Models\User;
use App\Models\Role;

class FormateurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formateurs = Formateur::all();

        $formateursInternes = User::join('role_user','role_user.user_id','=','users.id')
                        ->join('roles','roles.id','role_user.id')
                        ->where('roles.intitule','=','formateur')
                        ->select('users.email','users.name')
                        ->get();

        return view("formateurs.index",compact(['formateurs','formateursInternes']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("formateurs.create");
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
        $donnees = $request->all();
        //Formateur externe
        if($request->type == "externe")
        {
            Formateur::create([
                'cabinet_id' => $request->cabinet,
                'email' => $request->email,
                'nom' => $request->nom,
                'prenom' => $request->prenom
            ]);
        }
        //Formateur interne
        else
       { 
            $user = User::create([
                'email' => $request->email,
                'name' => $request->nom,
                'password' => bcrypt($request->password)
            ]);

            $idRole = Role::where('intitule','formateur')->first()->id;
            $user->role()->attach($idRole);
            $donnees['user_id'] = $user->id;
           
            Formateur::create($donnees);
       }

        return redirect(route('formateurs.index'))->withSuccess('Ajout du formateur effectué avec succès!');
    }

    private function validateTheForm(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Formateur $formateur)
    {
        return view('formateurs.show',compact(['formateur']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Formateur $formateur)
    {
        return view('formateurs.edit',compact(['formateur']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Formateur $formateur)
    {
        $this->validateTheForm($request);
        $donnees = extraireDonneeUpdate($request);

        Formateur::where('id',$formateur->id)->update($donnees);

        return redirect(route('formateurs.index'))->withSuccess('Modification des données du formateur effectée avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Formateur $formateur)
    {
        Formateur::where('id',$formateur->id)->delete();

        return redirect(route('formateurs.index'))->withWarning('Suppression du formateur effectuée avec succès!');
    }
}
