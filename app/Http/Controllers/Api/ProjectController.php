<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//* importato il model
use App\Models\Project;

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
    // query per ottenere tutti i dati dal db
    // $projects = Project::all();

    // query per ottenere tutti i dati dal db //* paginati per 8 IN QUESTO MODO TUTTI I DATI VENGONO RACCHIUSI IN UN ARRAY "data": []
    // con with vengono passati: (one-to-many) type - (many-to-many) technologies
    $projects = Project::with('type', 'technologies')->paginate(8);

    // creo un json con i dati della query
    return response()->json($projects);
  }

}
