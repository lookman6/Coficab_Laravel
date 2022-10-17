<?php

namespace App\Exports;

use App\Models\Seance;
use App\Models\Personnel;
use App\Models\Participant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SeanceExpireeExport implements FromCollection, WithHeadings
//class AbsenceExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    protected $dateDebut;
    protected $dateFin;

    public function __construct($dateDebut, $dateFin)
    {
        $this->dateFin=$dateFin;
        $this->dateDebut=$dateDebut;
    }

     public function headings():array{
        return [
                'Formation',
                'Formateur prenom',
                'Formateur nom',
                'Cabinet',
                'Salle',
                'Debut',
                'Fin',
                'Participant prenom',
                'Participant nom'];
    }

   /* public function query()
    {

       // dd($this->dateFin);
        $data = Absence::join('etudiants', 'etudiants.id', '=', 'absences.etudiant_id')
                       ->join('creneaus', 'creneaus.id', '=', 'absences.creneau_id')
                       ->join('matieres', 'matieres.id', '=', 'creneaus.matiere_id')
                       ->join('professeurs', 'professeurs.id', '=', 'creneaus.professeur_id')
                       ->whereDate('creneaus.dateCreneau', '>=', $this->dateDebut)
                       ->whereDate('creneaus.dateCreneau', '<=', $this->dateFin)
                       ->get(['etudiants.codeApoge','creneaus.dateCreneau','creneaus.heureDebut','creneaus.heureFin','matieres.intitule','professeurs.matricule', 'absences.statut']);
                       //dd($data);
                       return $data;
    }*/

    /*public function map($AbsenceExport): array[


    ]
    {

    }*/

    public function collection()
    {
       $data = Participant::join('groupe_formations','groupe_formations.id' , '=','participants.groupe_formation_id' )
                       ->join('personnels', 'personnels.id', '=', 'participants.personnel_id' )
                       ->join('seances', 'seances.groupe_formation_id', '=', 'groupe_formations.id' )
                       ->join('salles', 'salles.id', '=', 'seances.salle_id' )
                       ->join('formateurs', 'formateurs.id', '=', 'seances.formateur_id' )
                       ->join('formations', 'formations.id', '=', 'seances.formation_id' )
                       ->join('cabinet_externes', 'cabinet_externes.id', '=', 'seances.cabinet_id' )
                       ->whereDate('seances.dateDebut', '>=', $this->dateDebut)
                       ->whereDate('seances.dateFin', '<=', $this->dateFin)
                       ->get(['formations.theme','formateurs.prenom as prenom1', 'formateurs.nom as nom1','cabinet_externes.nom as nm2','salles.intitule','seances.dateDebut','seances.dateFin', 'personnels.prenom',  'personnels.nom']);
                       //dd($data);
                        //->join('matieres', 'matieres.id', '=', 'creneaus.matiere_id').' '.'personnels.prenom'
                       //->join('professeurs', 'professeurs.id', '=', 'creneaus.professeur_id').' '.'formateurs.prenom'
                       return $data;
    }

    /*public function collection()
    {
        $data = Absence::join('etudiants', 'etudiants.id', '=', 'absences.etudiant_id')
                       ->join('creneaus', 'creneaus.id', '=', 'absences.creneau_id')
                       ->join('matieres', 'matieres.id', '=', 'creneaus.matiere_id')
                       ->join('professeurs', 'professeurs.id', '=', 'creneaus.professeur_id')
                       ->get(['etudiants.codeApoge','creneaus.dateCreneau','creneaus.heureDebut','creneaus.heureFin','matieres.intitule','professeurs.matricule']);
        return $data;
    }*/
}
