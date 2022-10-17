<?php

namespace App\Http\Controllers;

use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\SimpleExcel\SimpleExcelReader;

use Illuminate\Http\Request;
use App\Models\Personnel;
use App\Models\Participant;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personnels = Personnel::where('actif',true)->get();
        return view("personnel.index",compact(['personnels']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("personnel.ajouter");
    }

    public function fichierPersonnel(Request $request)
    {

        $fichier = $request->fichier->move(public_path(), $request->fichier->hashName());

    	$reader = SimpleExcelReader::create($fichier);

        $rows = $reader->getRows();

        $personnes = [];
        foreach($rows->toArray() as $key => $row)
        {
            Personnel::create([
                'matricule' => $row["matricule"],
                'nom' => $row["nom"],
                'prenom' => $row["prenom"],
                'departement' => $row["departement"],
                'fonction' => $row["fonction"],
                'CIN' => "CIN1231"
            ]);
        }
     
        return redirect(route("personnels.index"))->withSuccess('importation réussie!');
    }
    public function importerFichierPersonnel()
    {
        return view('personnel.importer');
    }


    public function getPersonnel()
    {
        return Personnel::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "nom"=>"required",
            "prenom"=>"required",
            "fonction"=>"required",
            "matricule"=>"required",
            'departement' => "required"
        ]);

       $personnel = Personnel::create([
            "nom" => $request->input('nom'),
            "prenom" => $request->input('prenom'),
            "matricule" => $request->input('matricule'),
            "fonction" => $request->input('fonction'),
            "departement" => $request->input('departement')
        ]);

        return redirect(route("personnels.index"))->withSuccess('ajout du personnel effectué avec succès!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Personnel $personnel)
    {
        $participations = Participant::where('personnel_id',$personnel->id)->get();
        // dd($participations);
        $tab = array();
        $i = 0;
        foreach($participations as $participation)
        {
            $tab[$i++] =  $participation->groupe_formation->seance;
        }
        if($tab)
        return view('personnel.show',compact('personnel','tab'));
        return view('personnel.show',compact('personnel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Personnel $personnel)
    {
        return view("personnel.edit",compact('personnel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Personnel $personnel)
    {
        Personnel::where('id',$personnel->id)->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'matricule' => $request->matricule,
            'departement' => $request->departement,
            'matricule' => $request->matricule
        ]);

        return redirect(route('personnels.index'))->withSuccess('Modification effectuée avec succès!');
    }


    public function getDepartement()
    {
        return Personnel::select('departement')->distinct()->get();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Personnel $personnel)
    {
        Personnel::where('id',$personnel->id)->update([
            'actif' => false
        ]);

        return redirect(route('personnels.index'))->withWarning('suppression du personnel effectuée avec succès!');
    }
}
