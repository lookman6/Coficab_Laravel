<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Formation;
use App\Models\Formateur;
use App\Models\CabinetExterne;
use App\Models\User;
use App\Models\Groupe;
use App\Models\Salle;

use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\SimpleExcel\SimpleExcelReader;
use App\Models\Personnel;
use App\Models\Groupe_formation;
use App\Models\Participant;
use App\Models\Seance;

class test extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('seances.ajouter');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function import(Request $request)
    {
        
    	// 1. Validation du fichier uploadé. Extension ".xlsx" autorisée
    	$this->validate($request, [
    		'fichier' => 'bail|required|file|mimes:xlsx'
    	]);

    	// 2. On déplace le fichier uploadé vers le dossier "public" pour le lire
    	$fichier = $request->fichier->move(public_path(), $request->fichier->hashName());

        // 3. $reader : L'instance Spatie\SimpleExcel\SimpleExcelReader
    	$reader = SimpleExcelReader::create($fichier);

        // On récupère le contenu (les lignes) du fichier
        $rows = $reader->getRows();

        // $rows est une Illuminate\Support\LazyCollection

        // 4. On insère toutes les lignes dans la base de données
        // $status = Personnel::insert($rows->toArray());
        $status = "bonjour";
        dd($status);
        dd($rows->toArray());
        // Si toutes les lignes sont insérées
    	if ($status) {

            // 5. On supprime le fichier uploadé
            $reader->close(); // On ferme le $reader
            unlink($fichier);

            // 6. Retour vers le formulaire avec un message $msg
            return back()->withMsg("Importation réussie !");

        } else { abort(500); }



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function retirerDesParticipants(Seance $seance, Personnel $participant)
    {
        Participant::where('personnel_id',$participant->id)
                    ->where('groupe_formation_id',$seance->groupe_formation_id)
                    ->delete();
        return "suppression effectuée avec succès";
    }
    public function ajouterParticipant(Seance $seance, $matricule)
    {
        $personnel = Personnel::where('matricule',$matricule)->first();
        $participants = $seance->groupe_formation->participants;
        $trouve = false;

        if($personnel != NULL)
        {
            foreach($participants as $participant)
            {
                if($participant->personnel_id == $personnel->id)
                {
                    $trouve = true;
                    break; 
                }
            }
            if($trouve == true)
            {
                return $personnel->nom." ".$personnel->prenom." suit déjà la formation ".$seance->formation->theme;
            }
            else
            {
                Participant::create([
                    'groupe_id' => 1,
                    'groupe_formation_id' => $seance->groupe_formation_id,
                    'personnel_id' => $personnel->id
                ]);

                return "Ajout  effectué avec succès !!!";
            }
        }
        else
        return "matricule incorrect !";
    }
    public function store(Request $request)
    {
        // 1. Validation du fichier uploadé. Extension ".xlsx" autorisée
    	// $this->validate($request, [
    	// 	'fichier' => 'bail|required|file|mimes:xlsx'
    	// ]);
    	// 2. On déplace le fichier uploadé vers le dossier "public" pour le lire
    	$fichier = $request->fichier->move(public_path(), $request->fichier->hashName());

        // 3. $reader : L'instance Spatie\SimpleExcel\SimpleExcelReader
    	$reader = SimpleExcelReader::create($fichier);

        // On récupère le contenu (les lignes) du fichier
        $rows = $reader->getRows();

        $i = 0;
        $noms = [];
        $personnes = [];
        foreach($rows->toArray() as $row)
        $noms[++$i] = $row["nom"];
        $i = 0;
        foreach($noms as $nom)
        {
            if(Personnel::where('nom',$nom)->get()->toArray() != [])
            $personnes[++$i] = Personnel::where('nom',$nom)->get()->toArray();
        }

        // Vérifions si chaque personne figurant dans la liste fournie est bien présente dans la BD
        if(count($noms) == count($personnes))
        {
            // Création du groupe de formation
        $groupeFormation = Groupe_formation::create([]);
        // dd($personnes[1][0]["nom"]);
        // Insertion dans la Table Participants4
        foreach($personnes as $personne)
        {
            $grps = Groupe::all();
            // dd($grps->count());
            if($grps->count() == 0)
            $grp = Groupe::create([
                'intitule' => 'groupe1'
            ]);
        // dd($grps->first()->id);
            Participant::create([
                'groupe_id' => $grps->first()->id,
                'groupe_formation_id' => $groupeFormation->id,
                'personnel_id' => $personne[0]["id"]
            ]);
           
        } 

        $donnees = $request->all();
        $donnees['formation_id'] = $request->theme;
        $donnees['salle_id'] = $request->salle;
        $donnees['groupe_formation_id'] = $groupeFormation->id;
        $donnees['cabinet_id'] = $request->cabinet;
        if($request->type == "interne")
        {
            $formateur_id = $request->formateurInterne;
            unset($donnees['cout']);
            $donnees['formateur_id'] = $formateur_id;
        }
        else
        {
            $formateur_id = $request->formateur;
            $donnees['formateur_id'] = $formateur_id;
        }


        // dd($donnees);
        Seance::create($donnees);
        return redirect(route('seances.index'))->withSuccess('insertions effectuées avec succès!');
    }

    // Traitement à effectuer s'il y a au moins une personne de la liste qui ne figure pas dans la BD
    {
        return redirect(route('seances.index'))->withWarning('veillez joindre une liste de participants présents dans la base de données!');
    }
        // $rows est une Illuminate\Support\LazyCollection

        // 4. On insère toutes les lignes dans la base de données
        // $status = Personnel::where('nom',$noms)->get();
        // dd($status);
        // dd($rows->toArray());
        // // Si toutes les lignes sont insérées
    	// if ($status) {

        //     // 5. On supprime le fichier uploadé
        //     $reader->close(); // On ferme le $reader
        //     unlink($fichier);

        //     // 6. Retour vers le formulaire avec un message $msg
        //     return back()->withMsg("Importation réussie !");

        // } else { abort(500); }

        //Suite
        // On récupère les ids  des individus dont les noms sont présents dans le fichier excel
        // On crée un groupe de formation 
        // On insère dans la table participants l'id du groupe, les ids précédemments recupérés, l'id du 
        // groupe de formation nouvellement créé
        //  Ensuite, on insère dans la table séance la date de début, le type, la date de fin, l'id du groupe 
        // de formation, l'id de la formation, l'id de la salle 
        // l'id du formateur et eventuellement l'id du cabinet si toutefois la formation est externe
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($categorie)
    {
        $categorie_id = Category::where('intitule',$id)-first()->id; 
        $formations = Formation::where('categorie_id',$categorie_id)->get();
        return $formations;

        // $categorie_id = Category::where('id',$id)->first()->id; 
        // $formations = Formation::where('categorie_id',$categorie_id)->get();
        // return $formations;
    }

    public function themeParCategorie($categorie)
    {
        $categorie_id = Category::where('intitule',$categorie)->first()->id; 
        $formations = Formation::where('categorie_id',$categorie_id)->get();
        // dd($formations);
        return $formations;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seance $seance)
    {
        dd($seance);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function chargerCategories()
    {
        return Category::all();
    }

    public function chargerCabinets()
    {
        return CabinetExterne::all();
    }

    public function getGroupes()
    {
        return Groupe::all();
    }

    public function getSalles()
    {
        return Salle::all();
    }

    public function chargerFormateurs($cabinet)
    {
        $id = CabinetExterne::where('id',$cabinet)->get()->first()->id;
        return Formateur::where('cabinet_id',$id)->get();
    }

    public function chargerFormateursInternes()
    {
       // Retourner les users qui ont le rôle formateur.
       $users = User::all();
       $formateurs = [];
       $i = 0;
       foreach($users as $user)
       {
            foreach($user->role as $role){
                if($role->intitule == "formateur"){
                    $formateurs[$i++]= Formateur::where('user_id',$user->id)->first();
                    break;
                }
            }
       }
        // dd($formateurs);
        return $formateurs;
    }

   
}
