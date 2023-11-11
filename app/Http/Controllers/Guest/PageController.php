<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(){

      return view('guest.home');
    }

    public function projects(){

      $projects = Project::orderBy('id', 'desc')->limit(10)->get();

      // $start_date = date_create($projects->start_date);
      // $start_date_formatted = date_format($start_date, 'd/m/Y');

      // return view('guest.projects', compact('projects', 'start_date_formatted'));
      return view('guest.projects', compact('projects'));
    }

    public function contacts(){

      return view('guest.contacts');
    }

}
