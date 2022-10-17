<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seance;
use App\Models\Participant;
use App\Models\Formation;
use App\Models\Category;
use App\Models\Formateur;
use App\Models\Personnel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class StatistiquesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function topFormateursParHeures($debut,$fin)
    {
            $tableau = array();

            $seances = Seance::where('dateDebut','>=',$debut)
                               ->where('dateDebut','<=',$fin)
                               ->where('dateFin','<=',$fin)
                               ->get()
                               ->groupBy('formateur_id');
            foreach($seances as $seance)
            {
                $formateur = Formateur::where('id',$seance[0]->formateur_id)->first();
                $clef = $formateur->nom." ".$formateur->prenom;
                $tableau[$clef] = 0;
                foreach($seance as $item)
                $tableau[$clef] += $item->duree;
            }

            dd($tableau);
            

            return $seances;
    }

    public function getDepartements()
    {
        $departements = Personnel::all()->unique('departement')->pluck('departement');
        return $departements;
    }

    private function getParticipants_builder($debut,$fin)
    {
        // $debut = '2022-07-01';
        // $fin = '2022-12-01';

        $participants = DB::table("participants")
        ->join("personnels", "participants.personnel_id", "=", "personnels.id")
        ->join("seances", "seances.groupe_formation_id", "=", "participants.groupe_formation_id")
        ->where('dateDebut','>=',$debut)
        ->where('dateDebut','<=',$fin)
        ->where('dateFin','<=',$fin);
        

        return $participants;
    }

    public function getStatDepartement($debut,$fin,$departement)
    {

        $tab = array();
        $tab = $this->totalHeuresEtParticipantsParDepartement($debut,$fin);
        $tableau = $this->employesFormesParDepartement($debut,$fin);
        $tableau[$departement]["duree"] = $tab[$departement]["duree"];
        $tableau[$departement]["cout"] = $tab[$departement]["cout"];
        
        return  $tableau[$departement] ;
       
    }

    public function statsParCategorie($debut,$fin,$cat)
    {
        //dd($cat);
        $cat = rawurldecode ($cat);
        //dd($cat);
        $tableau = array();
        $categorie = Category::where('intitule',$cat)->first();
        //dd($categorie->id); 
        $builderCategorie =  $this->getParticipants_builder($debut,$fin)
                                  ->join("formations","seances.formation_id","=","formations.id")
                                  ->where('formations.categorie_id','=',$categorie->id);

        
        $themesFormations = $builderCategorie->distinct('seances.formation_id')->count('seances.formation_id'); 
        $employesFormes = $builderCategorie
                        ->distinct('participants.personnel_id') // à revoir
                        ->count();

        $sessionsFormations = $builderCategorie
                            ->distinct('seances.id')
                            ->count();

        $seances = Seance::all();
        $duree = 0;

        foreach($seances as $seance)
        {

            if($seance->formation->categorie_id == $categorie->id)
                $duree += $seance->duree;
        }
        // dd($duree);
        $tableau["duree"] = $duree;
        $tableau["employes"] = $employesFormes;
        $tableau["themes"] = $themesFormations;
        $tableau["sessions"] = $sessionsFormations;
        
        return $tableau;
    }

    public function employesFormesParDepartement($debut,$fin)
    {
        $departements = $this->getDepartements();
        $tableau = array();

        foreach ($departements as $key => $departement) {

            
        $builderDepartement =  $this->getParticipants_builder($debut,$fin)
                                    ->where('personnels.departement','=',$departement);

        $themesFormations = $builderDepartement->distinct('seances.formation_id')->count('seances.formation_id');  
        $employesFormes = $builderDepartement
                        ->distinct('participants.personnel_id')
                        ->count();
                            
        $sessionsFormations = $builderDepartement
                            ->distinct('seances.id')
                            ->count(); 
                                
        $externe = $builderDepartement
        ->where('seances.type','externe')
        ->get()
        ->count('participants.id');
               
                        
        $tableau[$departement]["themes"] = $themesFormations;
                              
        $tableau[$departement]["employes"] = $employesFormes;
        $tableau[$departement]["sessions"] = $sessionsFormations;
        $tableau[$departement]["externe"] = $externe;
        
    }

        foreach($departements as $key => $departement)
        {
            $builderDepartement =  $this->getParticipants_builder($debut,$fin)
            ->where('personnels.departement','=',$departement);
            
            $interne =  $builderDepartement
            ->where('seances.type','interne')
            ->get()
            ->count('participants.id');

            
            $tableau[$departement]["interne"] = $interne;
        }
        return $tableau;
        
    }

    public function totalHeuresEtParticipantsParDepartement($debut,$fin)
    {
     

        $tableau = array();
        $tabGroupeFormation = array();
        $departements = array();

        foreach ($this->getDepartements() as $departement)
        {
           $participants = $this->getParticipants_builder($debut,$fin)
                            ->where('personnels.departement','=',$departement)
                            ->count();
           $tableau[$departement] = array();
           $tableau[$departement]["participants"] = $participants;
           
            //nombre de participants dun departement par séance
            $seances = Seance::all();
            $nombre = 0;
            $cout = 0;
            $duree = 0;
            $departements[$departement] = array();

            foreach($seances as $seance)
            {
                // dd($seance->formation->categorie->intitule);
                $total = $this->getParticipants_builder($debut,$fin)
                             ->where('seances.id','=',$seance->id)
                             ->count();

                $nombre = $this->getParticipants_builder($debut,$fin)
                            ->where('personnels.departement','=',$departement)
                            ->where('seances.id','=',$seance->id)
                            ->count(); 
                

                if($nombre != 0)
                {
                    $duree += $seance->duree;
                    $cout += ($seance->cout * $nombre) / $total;
                    $departements[$departement]["duree"] = $duree;
                    $departements[$departement]["cout"] = $cout;

                }
                $nombre = 0;
            }
            
            $tableau[$departement]["duree"] = $duree;
            $tableau[$departement]["cout"] = $cout;
        }
        
        return $tableau;
    }

    
    public function totalHeuresEtParticipantsParMoisParDepartement($debut,$fin)
    {
        $tableau = array();
        $elements = $this->getParticipants_builder($debut,$fin)
                    ->get()
                    ->groupBy(function($seance){
                                return Carbon::parse($seance->dateDebut)->format('m');
                            });
        
        foreach($elements as $key => $element)
        {
            $tableau[$key] =  array();
            foreach ($this->getDepartements() as $departement)
            {
                $participants = $element->where('departement',$departement)
                                        ->count();

                $tableau[$key][$departement] = array();
                $tableau[$key][$departement]["participants"] = $participants;

                $seances = Seance::all();
                $nombre = 0;
                $cout = 0;
                $duree = 0;

                foreach ($seances as $seance) {
                    $total = $element->where('id',$seance->id)
                             ->count();
                    $nombre = $element->where('id',$seance->id)
                                      ->where('departement',$departement)
                                      ->count();

                    if($nombre)
                    {
                        $duree += $seance->duree;
                        $cout += ($seance->cout * $nombre) / $total;
                    }
                    $nombre = 0;
                }
                $tableau[$key][$departement]["duree"] = $duree;
                $tableau[$key][$departement]["cout"] = $cout;                       
            }
        }
        return $tableau;
        // dd($elements);
    }

    public function lesStats($debut,$fin,$departement)
    {
        $annee = substr($debut,0,4);
        // dd('bonjour');
        // $debut = '2022-07-01';
        // $fin = '2022-12-01';
       // index StatistiqueController
       $donneesDept = $this->employesFormesParDepartement($debut,$fin);
        $heuresParDept = $this->totalHeuresEtParticipantsParDepartement($debut,$fin);
        // dd($heuresParDept);
        $nbrHeuresEtCoutParMois = $this->nbreHeuresEtCoutParMois($debut,$fin);
        // nbreHeuresParFormateur($debut,$fin);
        // dd($this->employesFormesParDepartement('2022-07-01','2022-12-01'));
        $formations = $this->tester(2);
        // $departements = $this->parDepartement();

        $formateeurs = $this->nbreHeuresParFormateur($debut,$fin);
        // un champs dans le frontend pour la saisie de la période 
        
        
        $themesFormation = Seance::all()->pluck('formation_id');
        $groupeFormations = Seance::whereIn('formation_id',$themesFormation)
                                    ->where('dateDebut','>=',$debut)
                                    ->where('dateDebut','<=',$fin)
                                    ->where('dateFin','<=',$fin)
                                    ->get()->groupBy('formation_id');
        // dd($groupeFormations);
        $tableau = array(); 
        foreach($groupeFormations as $collectionItem)
        {
            $formation = Formation::where('id',$collectionItem[0]->formation_id)->first();
            $participantsParFormation = 0;
            $nbreHeuresParFormation = 0;

            $nbreHeuresParFormation = Seance::where('formation_id',$formation->id)->get()->sum('duree');
            foreach($collectionItem as $subElement)
            {
                $participantsParFormation += Participant::where('groupe_formation_id',$subElement->groupe_formation_id)->get()->count();
            }

            $tableau[$formation->theme]["nbreParticipants"] = $participantsParFormation;
            $tableau[$formation->theme]["nbreHeures"] = $nbreHeuresParFormation;
        }
   
        
        $participants = array();
        $heures = array();
        foreach($tableau as $clef => $valeur)
        {
            $participants[$clef] = $valeur["nbreParticipants"];
            $heures[$clef] = $valeur["nbreHeures"];
        }
       

        arsort($participants);
        arsort($heures);
        // dd($participants,$heures);
        
        $participants = array_slice($participants,0,5);
        $heures = array_slice($heures,0,5);
        // dd($nbrHeuresEtCoutParMois);
        return view('statistiques.visualisation',compact(['participants','heures',
                                                  'formations','formateeurs',
                                                  'debut','fin','annee',
                                                  'nbrHeuresEtCoutParMois',
                                                   'departement','heuresParDept','donneesDept']));
        // dd($this->topFormateursParHeures());
    }

    public function lesImages($debut,$fin,$departement)
    {
        $annee = substr($debut,0,4);
        // dd('bonjour');
        // $debut = '2022-07-01';
        // $fin = '2022-12-01';
       // index StatistiqueController
       $donneesDept = $this->employesFormesParDepartement($debut,$fin);
        $heuresParDept = $this->totalHeuresEtParticipantsParDepartement($debut,$fin);
        // dd($heuresParDept);
        $nbrHeuresEtCoutParMois = $this->nbreHeuresEtCoutParMois($debut,$fin);
        // nbreHeuresParFormateur($debut,$fin);
        // dd($this->employesFormesParDepartement('2022-07-01','2022-12-01'));
        $formations = $this->tester(2);
        // $departements = $this->parDepartement();

        $formateeurs = $this->nbreHeuresParFormateur($debut,$fin);
        // un champs dans le frontend pour la saisie de la période 
        
        
        $themesFormation = Seance::all()->pluck('formation_id');
        $groupeFormations = Seance::whereIn('formation_id',$themesFormation)
                                    ->where('dateDebut','>=',$debut)
                                    ->where('dateDebut','<=',$fin)
                                    ->where('dateFin','<=',$fin)
                                    ->get()->groupBy('formation_id');
        // dd($groupeFormations);
        $tableau = array(); 
        foreach($groupeFormations as $collectionItem)
        {
            $formation = Formation::where('id',$collectionItem[0]->formation_id)->first();
            $participantsParFormation = 0;
            $nbreHeuresParFormation = 0;

            $nbreHeuresParFormation = Seance::where('formation_id',$formation->id)->get()->sum('duree');
            foreach($collectionItem as $subElement)
            {
                $participantsParFormation += Participant::where('groupe_formation_id',$subElement->groupe_formation_id)->get()->count();
            }

            $tableau[$formation->theme]["nbreParticipants"] = $participantsParFormation;
            $tableau[$formation->theme]["nbreHeures"] = $nbreHeuresParFormation;
        }
   
        
        $participants = array();
        $heures = array();
        foreach($tableau as $clef => $valeur)
        {
            $participants[$clef] = $valeur["nbreParticipants"];
            $heures[$clef] = $valeur["nbreHeures"];
        }
       

        arsort($participants);
        arsort($heures);
        // dd($participants,$heures);
        
        $participants = array_slice($participants,0,5);
        $heures = array_slice($heures,0,5);
        // dd($nbrHeuresEtCoutParMois);
        return view('statistiques.image',compact(['participants','heures',
                                                  'formations','formateeurs',
                                                  'debut','fin','annee',
                                                  'nbrHeuresEtCoutParMois',
                                                   'departement','heuresParDept','donneesDept']));
        // dd($this->topFormateursParHeures());
    }

    public function statsParDepartement($departement,$debut,$fin)
    {
            $tableau = array();
            $employesFormes = $this->getParticipants_builder($debut,$fin)
                            ->where('personnels.departement','=',$departement)
                            ->distinct('participants.personnel_id')
                            ->count();
            $tableau["session"] = $employesFormes;
            dd($tableau);
    }

    public function index()
    {

        // dd("bonjour");
        $debut = '2022-07-01';
        $fin = '2022-12-01';
        //  $this->statsParCategorie($debut,$fin,'Magnam%20ipsum.');
        // $this->totalHeuresEtParticipantsParDepartement($debut,$fin);
        // dd($this->totalHeuresEtParticipantsParDepartement($debut,$fin));
        // index StatistiqueController
        // $this->statsParDepartement('departement1',$debut,$fin);
        // dd($this->totalHeuresEtParticipantsParDepartement($debut,$fin));
        // nbreHeuresEtCoutParMois($debut,$fin);
        // nbreHeuresParFormateur($debut,$fin);
        // dd($this->employesFormesParDepartement('2022-07-01','2022-12-01'));
        $formations = $this->tester(2);
        $donneesDept = $this->employesFormesParDepartement($debut,$fin);
        // $departements = $this->parDepartement();

        $formateeurs = $this->nbreHeuresParFormateur($debut,$fin);
        // un champs dans le frontend pour la saisie de la période 
        
        
        $themesFormation = Seance::all()->pluck('formation_id');
        $groupeFormations = Seance::whereIn('formation_id',$themesFormation)
                                    ->where('dateDebut','>=',$debut)
                                    ->where('dateDebut','<=',$fin)
                                    ->where('dateFin','<=',$fin)
                                    ->get()->groupBy('formation_id');
        // dd($groupeFormations);
        $tableau = array(); 
        foreach($groupeFormations as $collectionItem)
        {
            $formation = Formation::where('id',$collectionItem[0]->formation_id)->first();
            $participantsParFormation = 0;
            $nbreHeuresParFormation = 0;

            $nbreHeuresParFormation = Seance::where('formation_id',$formation->id)->get()->sum('duree');
            foreach($collectionItem as $subElement)
            {
                $participantsParFormation += Participant::where('groupe_formation_id',$subElement->groupe_formation_id)->get()->count();
            }

            $tableau[$formation->theme]["nbreParticipants"] = $participantsParFormation;
            $tableau[$formation->theme]["nbreHeures"] = $nbreHeuresParFormation;
        }
   
        
        $participants = array();
        $heures = array();
        foreach($tableau as $clef => $valeur)
        {
            $participants[$clef] = $valeur["nbreParticipants"];
            $heures[$clef] = $valeur["nbreHeures"];
        }
       

        arsort($participants);
        arsort($heures);
        // dd($participants,$heures);
        
        $participants = array_slice($participants,0,5);
        $heures = array_slice($heures,0,5);
        // dd($heures);
        // dd($this->topFormateursParHeures($debut,$fin));
        return view('statistiques.index',compact(['participants','heures','formations','formateeurs']));
    }

   
    public function parDepartement()
    {
         // $tab["a"]["b"]["c"]= array();
        // $tab["a"]["b"]["d"] = 3;
        // dd($tab["a"]["b"]["c"]);

        $debut = '2022-07-01';
        $fin = '2022-12-01';
    
        $departement = array();

        $themesFormation = Seance::all()->pluck('formation_id');
        $groupeFormations = Seance::whereIn('formation_id',$themesFormation)
                                    ->where('dateDebut','>=',$debut)
                                    ->where('dateDebut','<=',$fin)
                                    ->where('dateFin','<=',$fin)
                                    ->get()->groupBy('formation_id');
        // dd($groupeFormations);
        $tableau = array(); 
        foreach($groupeFormations as $collectionItem)
        {
            // dd($collectionItem);
            $formation = Formation::where('id',$collectionItem[0]->formation_id)->first();
            $participantsParFormation = 0;
            $nbreHeuresParFormation = 0;
     
            $nbreHeuresParFormation = Seance::where('formation_id',$formation->id)->get()->sum('duree');
            $dept = "";
            foreach($collectionItem as $subElement)
            {
                // dd($subElement);
                $participantsParFormation = Participant::where('groupe_formation_id',$subElement->groupe_formation_id)->get();
                
                foreach($participantsParFormation as $element)
                {
                    // dd($element);
                    if(!array_key_exists($element->personnel->departement,$departement))
                    {
                        $departement[$element->personnel->departement][$formation->theme]["NP"] = 0;
                        $departement[$element->personnel->departement][$formation->theme]["personnel"] = array();
                        // $departement[$element->personnel->departement]["personnel"][$element->personnel->id] = $element->personnel->id; 
                        // $departement[$element->personnel->departement]["nbHeures"] = 0;
                    }
                    // dd($departement[$element->personnel->departement]);
                    // dd(array_key_exists($formation->theme,$departement[$element->personnel->departement]));
                    if(!array_key_exists($formation->theme,$departement[$element->personnel->departement]))
                    {
                        // dd("bonjour");
                        $departement[$element->personnel->departement][$formation->theme]["NP"] = 1;
                        $departement[$element->personnel->departement][$formation->theme]["personnel"][$element->personnel->id] = $element->personnel->id; 
                    }
                    if(!array_key_exists($element->personnel->id,$departement[$element->personnel->departement][$formation->theme]["personnel"]))
                    {
                        $departement[$element->personnel->departement][$formation->theme]["personnel"][$element->personnephp->id] = $element->personnel->id; 
                        $departement[$element->personnel->departement][$formation->theme]["NP"] += 1;
                    }
                    $dept = $element->personnel->departement;
                  
                }
            }
            
            $tableau[$formation->theme]["nbreParticipants"] = $participantsParFormation;
            $tableau[$formation->theme]["nbreHeures"] = $nbreHeuresParFormation;
            $tableau[$formation->theme]["departement"] = $dept;
        }
        dd($tableau);
        return $tableau;
    }

    public function nbreHeuresEtCoutParMois($debut,$fin)
    {
        // $debut = '2022-07-01';
        // $fin = '2022-08-29';

        $tableau = array();
       
        $totalHeuresParMois = array();
        $totalCoutParMois = array();

        $seances = Seance::where('dateDebut','>=',$debut)
                            ->where('dateDebut','<=',$fin)
                            ->where('dateFin','<=',$fin)
                            -> get()
                            ->groupBy(function($seance){
                                        return Carbon::parse($seance->dateDebut)->format('m');
                                     });

        foreach($seances as $seancesParMois)
        {
            $nbreHeures = 0;
            $couts = 0;
            $mois = Carbon::parse($seancesParMois[0]->dateDebut)->format('m');
            foreach($seancesParMois as $seance)
            {
                $nbreHeures += $seance->duree;
                $couts += $seance->cout;
            }
            $totalHeuresParMois[$mois] = $nbreHeures;
            $totalCoutParMois[$mois] = $couts;
        }

        $tableau["nbreHeuresParMois"] = $totalHeuresParMois;
        $tableau["coutParMois"] = $totalCoutParMois;
        // dd($tableau);
        return $tableau;
    }

    public function TotalHeuresParMois()
    {
        $debut = '2022-07-01';
        $fin = '2022-12-01';
        
        $themesFormation = Seance::all()->pluck('formation_id');
        $groupeFormations = Seance::where('dateDebut','>=',$debut)
                                    ->where('dateDebut','<=',$fin)
                                    ->where('dateFin','<=',$fin)
                                    ->get()->groupBy(function($seance){
                                        return Carbon::parse($seance->dateDebut)->format('m');
                                    });
    }

    public function nbreHeuresParFormateur($debut,$fin)
    {
        $tableau = array();
       
        $totalHeuresParMois = array();
        $totalCoutParMois = array();

        // faire la version avec where ... ---> période
        $seances = Seance::where('dateDebut','>=',$debut)
                            ->where('dateDebut','<=',$fin)
                            ->where('dateFin','<=',$fin)
                            ->get()->groupBy('formateur_id');

        foreach($seances as $seance)
        {
            $formateur = "";
            $set = false;
            $nbreHeures = 0;
            foreach($seance as $seance)
            {
                if(!$set)
                {
                    $formateur = Formateur::where('id',$seance->formateur_id)->first();
                    $set = true;
                }
                $nbreHeures += $seance->duree;
            }
            $set = false;
            if(isset($formateur->prenom))
            {
                $totalHeuresParMois[$formateur->prenom] = $nbreHeures;

            }
            // dd($totalHeuresParMois);
        }
        // dd($totalCoutParMois);
       return $totalHeuresParMois;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd("bonjour");
        $request->validate([

            'dateFin'=>'required|after:dateDebut',
            //'photo' => 'required',
            //'photo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);
        $debut = $request->dateDebut ;
        $fin = $request->dateFin;
        $departement = $request->departement;
       return $this->lesStats($debut,$fin,$departement);
    }

     public function image(Request $request)
    {
        // dd("bonjour");

        $request->validate([

            'dateFin'=>'required|after:dateDebut',
            //'photo' => 'required',
            //'photo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);
        $debut = $request->dateDebut ;
        $fin = $request->dateFin;
        $departement = $request->departement;
       return $this->lesImages($debut,$fin,$departement);
    }

    public function themeParParticipants()
    {
        // Top 5 des thèmes de formation par participants
        
        
    }

    public function tester($theme)
    {
        $themesFormation = Seance::all()->pluck('formation_id');
        $groupeFormations = Seance::whereIn('formation_id',$themesFormation)->get()->groupBy('formation_id');
        
        $tableau = array(); 
        foreach($groupeFormations as $collectionItem)
        {
            $formation = Formation::where('id',$collectionItem[0]->formation_id)->first();
            $participantsParFormation = 0;
            $nbreHeuresParFormation = 0;

            $nbreHeuresParFormation = Seance::where('formation_id',$formation->id)->get()->sum('duree');
            foreach($collectionItem as $subElement)
            {
                $participantsParFormation += Participant::where('groupe_formation_id',$subElement->groupe_formation_id)->get()->count();
            }

            $tableau[$formation->theme]["nbreParticipants"] = $participantsParFormation;
            $tableau[$formation->theme]["nbreHeures"] = $nbreHeuresParFormation;
        }
        return $tableau;
      
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
