<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//* importato il model
use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;

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

}
