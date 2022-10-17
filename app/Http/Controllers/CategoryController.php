<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\SimpleExcel\SimpleExcelReader;

use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view("categories.index",compact(['categories']));
    }


    public function getCategorie()
    {
        return Category::all();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("categories.create");
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
            'intitule' => "required"
        ]);

        Category::create([
            'intitule' => $request->intitule
        ]);

        return redirect(route('categories.index'))->withSuccess('catégorie '.$request->intitule.' ajoutée avec succès!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view("categories.show",compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view("categories.edit",compact("category"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        Category::where('id',$category->id)->update([
            'intitule' => $request->intitule
        ]);

        return redirect(route("categories.index"))->withSuccess('Modification effectuée avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Category::where('id',$category->id)->delete();
        return redirect(route('categories.index'))->withWarning('La catégorie '.$category->intitule.' a été supprimée!');
    }
    public function importerFichier()
    {
        return view('categories.importer');
    }

    public function fichierCategorie(Request $request)
    {
        $fichier = $request->fichier->move(public_path(), $request->fichier->hashName());

    	$reader = SimpleExcelReader::create($fichier);

        $rows = $reader->getRows();

        $personnes = [];
        foreach($rows->toArray() as $key => $row)
        {
            Category::create([
                'intitule' => $row["intitule"],
            ]);
        }
        return redirect(route("categories.index"))->withSuccess('importation réussie !');
    }
}
