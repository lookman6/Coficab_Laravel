<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Formation;
use App\Models\Seance;
use Illuminate\Http\Request;
use App\Exports\SeanceExpireeExport;
use \Maatwebsite\Excel\Facades\Excel;

class SeanceController extends Controller
{

     public function exportIntoExcel(Request $request)
    {

         $request->validate([

            'dateFin'=>'required|after:dateDebut|before:today',
            'dateDebut'=>'required|before:today',
           
        ]);
       // return (new AbsenceExport($request->dateDebut,$request->dateFin))->download('absenceList.xlsx');
       // return (new AbsenceExport($this->dateDebut,$this->dateFin))->download('absenceList.xlsx');
        //return Excel::download(new AbsenceExport,'absenceList.xlsx');
        //dd("absenceList_".$request->dateDebut."-".$request->dateFin."xlsx");
        return Excel::download(new SeanceExpireeExport($request->dateDebut,$request->dateFin),"seanceFormation_".$request->dateDebut."-".$request->dateFin.".xlsx");
    }

    /*public function exportIntoCSV()
    {
        return Excel::download(new SeanceExpiréeExport($request->dateDebut,$request->dateFin),"seanceFormation_".$request->dateDebut."-".$request->dateFin.".csv");
        //return Excel::download(new AbsenceExport,'absenceList.csv');
    }*/


    public function index()
    {
        $seances = Seance::all();
        $seances = $seances->sortByDesc('dateDebut');
        $today = now()->format('Y-m-d');
        foreach($seances as $key => $seance)
        {
            if($today > $seance->dateFin)
            $seances->forget($key);
        }

        return view("seances.enCours",compact(['seances']));
    }

    public function cloture()
    {
        $seances = Seance::all();
        $seances = $seances->sortByDesc('dateDebut');
        $today = now()->format('Y-m-d');
        foreach($seances as $key => $seance)
        {
            if($today <= $seance->dateFin)
            $seances->forget($key);
        }

        return view("seances.cloture",compact(['seances']));
    }

    
    public function voirPlus(Seance $seance)
    {
        $participants = array();
        $i = 0;
        foreach($seance->groupe_formation->participants as $participant)
            $participants[$i++] = $participant->personnel;
        return view('seances.participants',compact(['participants','seance']));
    }

    public function voirPlusCloture(Seance $seance)
    {
          $participants = array();
        $i = 0;
        foreach($seance->groupe_formation->participants as $participant)
            $participants[$i++] = $participant->personnel;
        return view('seances.participantsClotures',compact(['participants','seance']));
    }

    public function themeParCategorie($categorie)
    {
        $categorie_id = Category::where('intitule',$id)-first()->id; 
        $formations = Formation::where('categorie_id',$categorie_id)->get();
        return $formations;
    }

    public function edit(Seance $seance)
    {
        // dd($seance);
        return view ('seances.edit',compact('seance'));
    }

    public function update(Request $request, Seance $seance)
    {
        $tab = $request->all();
        unset($tab["_method"]);
        unset($tab["_token"]);
        $insere = Seance::where('id',$seance->id)->update([
            'dateDebut' => $tab["dateDebut"],
            'dateFin' => $tab["dateFin"],
            'type' => $tab["type"],
            'duree' => $tab["duree"],
            'cout' => $tab["cout"],
            'formateur_id' => $tab["formateur"],
            'formation_id' => $tab["theme"],
            'cabinet_id' => $tab["cabinet"],
            'salle_id' => $tab["salle"],
            'groupe_formation_id' => $seance->groupe_formation_id
        ]);
        if($insere)
        return redirect(route('seances.index'))->withSuccess('Modifications de la séance effectuées avec succès!');
        return redirect(route('seances.index'))->withWarning('Assurez vous que vous rempli tous les champs!');
    }
}
