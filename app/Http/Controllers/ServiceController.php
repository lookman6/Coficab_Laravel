<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Niveau;
use App\Models\Absence;
use App\Models\Creneau;
use App\Models\Filiere;
use App\Models\Matiere;
use App\Models\Etudiant;
use App\Models\Professeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{

    public function getMatiereByProfesseur($id)
    {
        $matiere= Matiere::where('professeur_id',$id)->get();
        return $matiere;
    }

    public function getFilieresWhereProfessorTeaches($id)
    {
       $niveaux= Niveau::join('modules', 'niveaux.id', '=', 'modules.niveaux_id')
       ->join('matieres', 'modules.id', '=', 'matieres.module_id')
       ->select('niveaux.id','codeNiveau', 'niveaux.intitule')
       ->where('matieres.professeur_id',Professeur::where('user_id',$id)->first()->id)
       ->get();
       return $niveaux;
    }

    public function getMatByFilProf($id,$idNiv)
    {
        $matieres= Matiere::join('modules', 'modules.id', '=', 'matieres.module_id')
       ->join('niveaux', 'niveaux.id', '=', 'modules.niveaux_id')
       ->select('matieres.id','matieres.intitule')
       ->where('matieres.professeur_id',Professeur::where('user_id',$id)->first()->id)
       ->where('niveaux.id',$idNiv)
       ->get();
       return $matieres;
    }

    public function getEtudByNiv($idNiv){
        $etudiants= Etudiant::join('users','users.id','etudiants.user_id')
        ->select('etudiants.id','codeApoge','firstname','lastname')
        ->where('niveaux_id',$idNiv)
        ->get();
        return $etudiants;
    }

    public function getCrenByProfMat($id,$idmat){
        $creneaux= Creneau::where('professeur_id',Professeur::where('user_id',$id)->first()->id)
        ->where('matiere_id',$idmat)
        ->get();

        return $creneaux;
    }

    public function getMatByNiv($idNiv){
        $matieres= Matiere::join('modules','modules.id','matieres.module_id')
        ->where('modules.niveaux_id',$idNiv)
        ->select('matieres.intitule','matieres.id','modules.niveaux_id')
        ->get();
        return $matieres;
    }

    public function getMatByEtd($idEtd){
        $matieres= $this->getMatByNiv(Etudiant::where('id',$idEtd)->first()->niveaux_id);
        return $matieres;
    }

    public function getFilByMat($idmat){
        $filieres= Filiere::join('niveaux','filieres.id','niveaux.filiere_id')
        ->join('modules','niveaux.id','modules.niveaux_id')
        ->where('modules.id',Matiere::where('id',$idmat)->first()->module_id)
        ->select('filieres.id','filieres.intitule')
        ->get();

        return $filieres;
    }

    public function getAbsOfProf($idProf){

        $filieres = Absence::join('creneaus','creneaus.id','absences.creneau_id')
        ->join('matieres','matieres.id','creneaus.matiere_id')
        ->join('modules','modules.id','matieres.module_id')
        ->join('niveaux','niveaux.id','modules.niveaux_id')
        ->where('creneaus.professeur_id',Professeur::where('user_id',$idProf)->first()->id);

        return $filieres;
    }

    public function getAbsEtudiant($userId){

        $absencesEtudiants = Absence::join('creneaus','creneaus.id','absences.creneau_id')
        ->join('matieres','matieres.id','creneaus.matiere_id')
        ->where('absences.etudiant_id',Etudiant::where('user_id',$userId)->first()->id);

        return $absencesEtudiants;
    }

    public function getMatEtudiant($userId){

        $matieres = Etudiant::join('niveaux','niveaux.id','etudiants.niveaux_id')
        ->join('filieres','filieres.id','niveaux.filiere_id')
        ->join('modules','modules.niveaux_id','niveaux.id')
        ->join('matieres','matieres.module_id','modules.id')
        ->where('etudiants.id',Etudiant::where('user_id',$userId)->first()->id)
        ->select('matieres.id')
        ->get();

        return $matieres;

    }

    public function getAllAbsEtudByMat($user)
    {
        $nombreAsencesDuneMatiere = array();
        $matieres = $this->getMatEtudiant($user);
        $nomMatieres = array();

        $i = 0;

        foreach($matieres as $matiere){
            $absences = $this->getAbsEtudiant($user)
                        ->where('matieres.id',$matiere->id)
                        ->select('absences.statut','matieres.intitule')
                        ->get();

            if($absences == null)
                continue;
            $mesAbsencesDuneMatiere = $absences->toArray();
            $nomMatieres[$i]= $mesAbsencesDuneMatiere[0]["intitule"];
            
            $P = 0;
            $AJ = 0;
            $ANJ = 0;

            

            foreach($mesAbsencesDuneMatiere as $a)
            {
                if($a["statut"] == 'P')
                    $P++;
                elseif($a["statut"] == 'AJ')
                    $AJ++;
                else
                    $ANJ++;
            }

            $nombreAsencesDuneMatiere[$i] = array(
                "P" => $P,
                "AJ" => $AJ,
                "ANJ" => $ANJ
            );
            //dd($nombreAsencesDuneMatiere[0]["ANJ"]);
            $i++;
        }

        // dd($nomMatieres);
        return array($nombreAsencesDuneMatiere,$nomMatieres);
    }

    public function getFilWhereAbs($idProf){
        $filieres= $this->getAbsOfProf($idProf)
        ->select('niveaux.id as niveauId','niveaux.codeNiveau')
        ->distinct()
        ->get();

           return $filieres;
    }

    public function getMatWhereAbs($idProf){
        $matieres= $this->getAbsOfProf($idProf)
        ->select('niveaux.id as niveauId','matieres.id as matiereId','matieres.intitule')
        ->distinct()
        ->get();

           return $matieres;
    }

    public function getDateoFAbs($idProf){
        $date= $this->getAbsOfProf($idProf)
        ->select('matieres.id as matiereId',DB::raw("DATE_FORMAT(absences.created_at, '%d-%b-%Y') as absenceDate"))
        ->distinct()
        ->get();
           return $date;
    }

    public function getEtdAbs($idProf){
        $etudiants= $this->getAbsOfProf($idProf)
        ->join('etudiants','etudiants.id','absences.etudiant_id')
        ->join('users','users.id','etudiants.user_id')
        ->select('etudiants.id as etudiantId','users.lastname','users.firstname',
                'creneaus.id as creneauId','etudiants.codeApoge','absences.statut',
                'creneaus.heureDebut','creneaus.heureFin','absences.id as absenceId',
                DB::raw("DATE_FORMAT(absences.created_at, '%d-%b-%Y') as absenceDate"))
        ->distinct()
        ->get();
           return $etudiants;
    }

    public function getCrenAbs($idProf){

        $creneaux= $this->getAbsOfProf($idProf)
        ->select('creneaus.id as creneauId','creneaus.heureDebut','creneaus.heureFin','matieres.id as matiereId',
        DB::raw("DATE_FORMAT(absences.created_at, '%d-%b-%Y') as absenceDate"))
        ->distinct()
        ->get();
           return $creneaux;
    }
}
