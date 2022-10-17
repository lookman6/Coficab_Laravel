<?php

use App\Http\Controllers\AbsenceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\NiveauController;
// use App\Http\Controllers\PersonneController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\MessageController;


use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\CabinetExterneController;
use App\Http\Controllers\FormateurController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\test;
use App\Http\Controllers\SimpleExcelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StatistiquesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('/', function () {
    return view('auth.login');
});



Route::get('/home', function () {
    return view('index');
})->middleware(['auth'])->name('home');


Route::middleware(['auth'])->group(function(){
    
    Route::resource('personnels', PersonnelController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('formations', FormationController::class);
    Route::resource('salles', SalleController::class);
    Route::resource('cabinets',CabinetExterneController::class);
    Route::resource('statistiques',StatistiquesController::class);
    Route::post('image',[App\Http\Controllers\StatistiquesController::class,'image'])->name("statistiques.image");
    Route::resource('formateurs',FormateurController::class);
    Route::resource('tests',test::class);
    Route::get('tester/{theme}',[App\Http\Controllers\StatistiquesController::class,'tester']);
    Route::get('testss/{categorie}',[App\Http\Controllers\test::class,'themeParCategorie']);
    Route::get('categorie',[App\Http\Controllers\test::class,'chargerCategories']);

    Route::put('seances/{seance}',[App\Http\Controllers\SeanceController::class,'update'])->name("seances.update");
    Route::get('seances',[App\Http\Controllers\SeanceController::class,'index'])->name("seances.index");
    Route::get('seances/clotures',[App\Http\Controllers\SeanceController::class,'cloture'])->name("seances.cloture");
    Route::get('seances/{seance}/participants',[App\Http\Controllers\SeanceController::class,'voirPlus'])->name("seances.participants");
    Route::get('seances/{seance}/participantsFormatCloturee',[App\Http\Controllers\SeanceController::class,'voirPlusCloture'])->name("seances.participantsClotures");
    Route::get('seances/{seance}',[App\Http\Controllers\SeanceController::class,'edit'])->name("seances.edit");
    
    Route::get('users/modifierRole/{user}',[App\Http\Controllers\UserController::class,'modifierRole'])->name('users.editRole');
    Route::get('users/modifierMesInfos/{user}',[App\Http\Controllers\UserController::class,'modifierMesInfos'])->name('users.modifierMesInfos');
    Route::put('users/updateRole/{user}',[App\Http\Controllers\UserController::class,'updateRole'])->name('users.updateRole');
    Route::put('users/updateMesInfos/{user}',[App\Http\Controllers\UserController::class,'  '])->name('users.updateMesInfos');

    Route::get('cabinet',[App\Http\Controllers\test::class,'chargerCabinets']);
    Route::get('importerFichierPersonnel',[App\Http\Controllers\PersonnelController::class,'importerFichierPersonnel'])->name("personnels.importer");
    Route::get('importerDomainesFormation',[App\Http\Controllers\CategoryController::class,'importerFichier'])->name("categories.importer");
    Route::get('importerFormations',[App\Http\Controllers\FormationController::class,'importerFichier'])->name("formations.importer");
    Route::get('getCabinets',[App\Http\Controllers\CabinetExterneController::class,'getCabinets']);
    Route::get('users',[App\Http\Controllers\UserController::class,'index'])->name('users.index');
    Route::get('users/create',[App\Http\Controllers\UserController::class,'create'])->name('users.create');

    Route::delete('users/{user}',[App\Http\Controllers\UserController::class,'destroy'])->name('users.destroy');

    Route::post('users',[App\Http\Controllers\UserController::class,'store'])->name('users.store');
    Route::get('formateur/{cabinet}',[App\Http\Controllers\test::class,'chargerFormateurs']);
    Route::get('getGroupes',[App\Http\Controllers\test::class,'getGroupes']);
    Route::get('getDepartement',[App\Http\Controllers\PersonnelController::class,'getDepartement']);
    Route::get('getCategorie',[App\Http\Controllers\CategoryController::class,'getCategorie']);
    Route::post('fichierPersonnel',[App\Http\Controllers\PersonnelController::class,'fichierPersonnel'])->name("personnels.fichierPersonnel");
    Route::post('fichierCategorie',[App\Http\Controllers\CategoryController::class,'fichierCategorie'])->name("categories.fichierCategorie");
    Route::post('fichierFormation',[App\Http\Controllers\FormationController::class,'fichierFormation'])->name("formations.fichierFormation");
    Route::get('getSalles',[App\Http\Controllers\test::class,'getSalles']);
    Route::get('getStatDepartement/{debut}/{fin}/{departement}',[App\Http\Controllers\StatistiquesController::class,'getStatDepartement']); 
    Route::get('ajouterParticipant/{seance}/{matricule}',[App\Http\Controllers\test::class,'ajouterParticipant']);
    Route::get('retirerDesParticipants/{seance}/{participant}',[App\Http\Controllers\test::class,'retirerDesParticipants']);
    Route::get('getStatCategorie/{debut}/{fin}/{cat}',[App\Http\Controllers\StatistiquesController::class,'statsParCategorie']);
    Route::get('getPersonnel',[App\Http\Controllers\PersonnelController::class,'getPersonnel']);
    Route::get('formateursInternes/',[App\Http\Controllers\test::class,'chargerFormateursInternes']);
    Route::post("simple-excel/import", [App\Http\Controllers\SimpleExcelController::class,'import'])->name('excel.import');
    Route::get("simple-excel/index", [App\Http\Controllers\SimpleExcelController::class ,'index'])->name('excel.index');

    Route::get("message", "MessageController@formMessageGoogle");
    Route::post("message", "MessageController@sendMessageGoogle")->name('send.message.google');

    Route::post('/export-excel',[SeanceController::class, 'exportIntoExcel']);

});


require __DIR__.'/auth.php';
