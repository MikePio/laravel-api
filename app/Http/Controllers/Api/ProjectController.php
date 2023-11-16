<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//* importato il model
use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Vite;

class ProjectController extends Controller
{
//* test api
  // public function testApi(){
  //   $test = [
  //     'name' => 'Mario',
  //     'surname' => 'Rossi'

  //   ];
  //   $newTest = true;

  //   return response()->json(compact('test', 'newTest'));
  // }

  public function index(){
    //* SOLUZIONE 1 chiamate api con più rotte
    // // query per ottenere tutti i dati dal db
    // // $projects = Project::all();

    // // query per ottenere tutti i dati dal db //* paginati per 8 IN QUESTO MODO TUTTI I DATI VENGONO RACCHIUSI IN UN ARRAY "data": []
    // // con with vengono passati: (one-to-many) type - (many-to-many) technologies
    // $projects = Project::with('type', 'technologies', 'user')->paginate(8);

    // // creo un json con i dati della query
    // return response()->json($projects);

    //* SOLUZIONE 2 Creata una sola rotta per le chiamate api per i progetti, types, technologies - nel controller passa in compact i dati (types e technologies) in modo da avere un unica rotta api
    $projects = Project::with('type', 'technologies', 'user')->paginate(10);

    $types = Type::all();
    $technologies = Technology::all();

    return response()->json(compact('projects','types','technologies'));
  }

  public function getTypes(){
    // query per ottenere tutti i dati dal db
    $types = Type::all();

    // query per ottenere tutti i dati dal db //* paginati per 8 IN QUESTO MODO TUTTI I DATI VENGONO RACCHIUSI IN UN ARRAY
    // $types = Type::paginate(8);

    // creo un json con i dati della query
    return response()->json($types);
  }

  public function getProjectsByType($id){
    //* SOLUZIONE 1 chiamate api con più rotte // migliora la velocità del sito
    // $projects = Project::where('type_id', $id)->with('type', 'technologies', 'user')->paginate(10);

    // return response()->json($projects);
    //* SOLUZIONE 2 Creata una sola rotta per le chiamate api per per la ricerca dei progetti per tipologia - nel controller passa in compact i dati (types e technologies) in modo da avere un unica rotta api // peggiora la velocità del sito
    $projects = Project::where('type_id', $id)->with('type', 'technologies', 'user')->paginate(10);
    $types = Type::all();
    $technologies = Technology::all();

    return response()->json(compact('projects','types','technologies'));
  }

  public function getTechnologies(){
    // query per ottenere tutti i dati dal db
    $technologies = Technology::all();

    // query per ottenere tutti i dati dal db //* paginati per 8 IN QUESTO MODO TUTTI I DATI VENGONO RACCHIUSI IN UN ARRAY
    // $technologies = Technology::paginate(8);

    // creo un json con i dati della query
    return response()->json($technologies);
  }

  public function getProjectsByTechnology($id){

    //* SOLUZIONE 1 PER LA RICERCA DEI PROGETTI PER TECNOLOGIE
    // // Ottiene il technology con tutti i progetti associati
    // $technology = Technology::where('id', $id)->with('projects')->first();

    // // Inizializza un array vuoto per i progetti
    // $projects = [];

    // // Per ogni progetto associato al technology, ottiene tutte le relazioni e le aggiunge all'array $projects
    // foreach ($technology->projects as $project) {
    //     $projects[] = Project::where('id', $project->id)->with('type', 'technologies', 'user')->first();
    // }

    // // Ottiene tutti i tipi e le tecnologie
    // $types = Type::all();
    // $technologies = Technology::all();

    // // Restituisce una risposta JSON includendo i progetti, i tipi e le tecnologie
    // return response()->json(compact('projects', 'types', 'technologies'));


    //* SOLUZIONE 2 PER LA RICERCA DEI PROGETTI PER TECNOLOGIE - MIGLIORE
    // Ottiene i progetti con le relazioni "type", "technologies", "user" in un formato paginato (10 progetti per pagina),
    // selezionando solo quelli che hanno almeno una technology associata con un determinato ID.
    $projects = Project::with('type', 'technologies', 'user')
                ->whereHas('technologies', function(Builder $query) use($id){
                    // Filtra i progetti che hanno almeno una technology con un ID specifico.
                    $query->where('technology_id',$id);
                })->paginate(10);

    // Ottiene tutti i tipi di progetti disponibili.
    $types = Type::all();

    // Ottiene tutte le tecnologie disponibili.
    $technologies = Technology::all();

    // Ritorna una risposta JSON contenente i progetti filtrati, i tipi e le tecnologie disponibili.
    return response()->json(compact('projects','types','technologies'));

  }

  public function getProjectDetail($slug){

    $project = Project::where('slug', $slug)->with('type', 'technologies', 'user')->first();

    // altro metodo per mostrare le immagini //* controllo lato server
    if($project->image_path) $project->image_path = asset('storage/' . $project->image_path) ;
    else{

      $project->image_path = Vite::asset('resources/img/placeholder-img.png');
      //! non funziona
      // $project->image_path = asset('storage/uploads/placeholder-img.png');
      $project->image_original_name = 'Nessuna immagine';
    }

    // dd($project);
    return response()->json($project);
  }

}
