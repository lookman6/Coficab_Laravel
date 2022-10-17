<?php

namespace App\Http\Controllers;

use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Http\Request;

use App\Models\Formation;
use App\Models\Category;

class FormationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formations = Formation::all();
        return view("formations.index",compact(['formations']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view("formations.create",compact(['categories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $donnees = $this->extraireDonnees($request); 
        
        Formation::create($donnees);

        return redirect(route("formations.index"))->withSuccess('ajout de la formation effectué avec succès!');
    }

    private function extraireDonnees(Request $request)
    {
        $donnees = $request->all();
        unset($donnees['_token']);
        unset($donnees['categorie']);
        $donnees['categorie_id'] = $this->getCategorieId($request);

        return $donnees;
    }

    private function getCategorieId(Request $request)
    {
        return Category::where('intitule',$request->categorie)->first()->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Formation $formation)
    {
        return view("formations.show",compact(['formation']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Formation $formation )
    {
        $categories = Category::all();
        return view("formations.edit",compact(['formation','categories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Formation $formation)
    {
        $donnees = $this->extraireDonnees($request); 
        unset($donnees['_method']);

        Formation::where('id',$formation->id)->update($donnees);

        return redirect(route('formations.index'))->withSuccess('Modification de la formation effectuée avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Formation::where('id',$id)->delete();
        return redirect(route('formations.index'))->withWarning('Suppression de la formation effectuée avec succès!');
    }

    public function importerFichier()
    {
        return view('formations.importer');
    }

    public function fichierFormation(Request $request)
    {
        $fichier = $request->fichier->move(public_path(), $request->fichier->hashName());

    	$reader = SimpleExcelReader::create($fichier);

        $rows = $reader->getRows();

        $categories = [];
        foreach($rows->toArray() as $key => $row)
        {
             $categorie = Category::where([
                'intitule' => $row["categorie"],
            ])->first();
            Formation::create([
                'theme' => $row["theme"],
                'categorie_id' => $categorie->id,
            ]);
        }
       
        return redirect(route('formations.index'))->withSuccess('Importation réussie!');

    }
}
