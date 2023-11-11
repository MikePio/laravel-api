<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// importo la tabella Technology
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // //* vengono mostrati tutti tecnologie in una volta
      // // $technologies = Technology::all();
      // //* vengono mostrati 8 tecnologie alla volta (per far ciò è necessario importare bootstrap in AppServiceProvider)
      // $technologies = Technology::paginate(8);
      // // $technologies = Technology::paginate(2);

      //* ottenere solo le tecnologie con più di 0 progetti associati, il che significa che hanno almeno un progetto collegato a una tecnologia dell'utente loggato
      // Seleziona solo i technologies che hanno progetti associati all'utente corrente
      $technologies = Technology::whereHas('projects', function ($query) { // 'projects' viene dalla funzione dichiarata nel model Technology
        $query->where('user_id', Auth::id()); // Filtra i technologies con progetti dell'utente corrente
      })->with(['projects' => function ($query) { // 'projects' viene dalla funzione dichiarata nel model Technology
        $query->where('user_id', Auth::id()); // Carica solo i progetti dell'utente corrente all'interno di ciascun tipo
      }])->paginate(8);

      return view('admin.technologies.index', compact('technologies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $val_data = $request->validate(
        ['name' => 'required|unique:technologies|max:50']
      );

      $val_data['slug'] = Str::slug($val_data['name']);

      // * soluzione lunga per fare ciò che elencato qui sotto: new Project(), fill($form_data), save()
      // $new_technology = new Technology();
      // $new_technology->fill($val_data);
      // $new_technology->save();
      // * soluzione breve per fare quello commentato sopra: new Project(), fill($form_data), save()
      $new_technology = Technology::create($val_data);

      // redirect per ritornare indietro con un messaggio
      return redirect()->back()->with('message', "Technology $new_technology->name created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Technology $technology)
    {
      $val_data = $request->validate(
        ['name' => 'required|unique:technologies|max:50']
      );

      $val_data['slug'] = Str::slug($val_data['name']);
      $technology->update($val_data);

      // redirect per ritornare indietro con un messaggio
      return redirect()->back()->with('message', "Technology $technology->name updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Technology $technology)
    {
      // * delete many-to-many
      // se nella migration non ho messo cascadeOnDelete devo fare
      // $post->tags()->detach();

      $technology->delete();
      return redirect()->back()->with('message', "Technology $technology->name deleted successfully");
    }
}
