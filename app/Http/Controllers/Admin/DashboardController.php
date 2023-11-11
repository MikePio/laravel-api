<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// importo il modello dei progetti
use App\Models\Project;
//* importo Auth per capire quale utente è loggato
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        return view('admin.home');
    }
    public function dashboard(){
      // numero di progetti presenti //* dell'user loggato
      $n_projects = Project::where('user_id', Auth::id())->count();
      // dd($n_projects);

      //* ultimo progetto presente
      // $last_project = Project::orderBy('id', 'desc')->first();
      // OPPURE CON orderByDesc
      // $last_project = Project::orderByDesc('id')->first();
      // OPPURE CON "latest" che viene utilizzato per ordinare i risultati di una query in base alla colonna con data e ora più recenti
      $last_project = Project::where('user_id', Auth::id()) // controllo che l'utente possa vedere solo il suo ultimo progetto e non di altri utenti
                              ->latest()->first(); // CON "latest" che viene utilizzato per ordinare i risultati di una query in base alla colonna con data e ora più recenti
      // dd($last_project);

      // con orario formattato
      $start_date = date_create($last_project->start_date);
      $start_date_formatted = date_format($start_date, 'd/m/Y');

      // con orario formattato
      $end_date = date_create($last_project->end_date);
      $end_date_formatted = date_format($end_date, 'd/m/Y');

      return view('admin.dashboard', compact('n_projects', 'last_project', 'start_date_formatted', 'end_date_formatted'));
    }
}
