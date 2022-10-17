<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Matiere;
use App\Models\Professeur;
use App\Models\Responsabilite;
use App\Models\Role;
use App\Models\User;

class MatiereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matieres = Matiere::all();
        return view("matieres/index",compact('matieres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = Module::all();
        $profs = Professeur::all();
        return view("matieres/create",compact('modules','profs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     "codeMatiere"=>"required",
        //     "responsableMatiere"=>"required",
        //     "intitule"=>"required",
        //     "module_id"=>"required"
        // ]);
        // $moduleId = Module::where('intitule',$request->moduleIntitule)->first(['id'])->id;

        Matiere::create([
            "codeMatiere" => $request->input('codeMatiere'),
            "professeur_id" => $request->input('responsableMatiere'),
            "intitule" => $request->input('intitule'),
            "module_id" => $request->input('module_id'),
        ]);

        $prof = Professeur::where('id',$request->input('responsableMatiere'))->first();

        $prof = Professeur::where('id',$request->input('responsableMatiere'))->first();
        $user = User::where('id',$prof->user->id)->first();
        $role=Role::where('intitule','enseignant')->first();
        $user->role()->attach($role);

        return redirect(route("matieres.index"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function getByProfesseur($id)
    {
        Matiere::where('professeur_id',$id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Matiere $matiere)
    {
        $modules = Module::where('filiere_id',$matiere->module->filiere_id)->get();
        return view("matieres/editer",compact(['matiere','modules']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matiere $matiere)
    {
        $moduleId = Module::where('intitule',$request->moduleIntitule)->first(['id'])->id;
        Matiere::where('id',$matiere->id)->update([
            "codeMatiere" => $request->input('codeMatiere'),
            "responsableMatiere" => $request->input('responsableMatiere'),
            "intitule" => $request->input('intitule'),
            "module_id" => $moduleId
        ]);

        return redirect(route("matieres.index"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Matiere $matiere)
    {
        $matiere->delete();
        return redirect(route("matieres.index"));
    }
}
