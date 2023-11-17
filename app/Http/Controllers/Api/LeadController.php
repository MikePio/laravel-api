<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LeadController extends Controller
{
  public function store(Request $request){



    // 1. ricevo i dati dal form in post
    $data = $request->all();


    return response()->json($data);
  }
}
