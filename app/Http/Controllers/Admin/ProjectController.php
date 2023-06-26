<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
//* importare il model
use App\Models\Project;
use Illuminate\Http\Request;
//* importo la reuest per la validazione degli errori
use App\Http\Requests\ProjectRequest;
//* importare la facades storage (necessaria per le immagini)
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //* vengono mostrati tutti progetti in una volta
      // $projects = Project::all();
      //* vengono mostrati 10 progetti alla volta (per far ciò è necessario importare bootstrap in AppServiceProvider)
      // $projects = Project::paginate(10);
      $projects = Project::paginate(2);


      return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
//! SOLUZIONE 1 MIGLIORE
//*  (MIGLIORE) soluzione 1 mostrare gli errori / per la validazione dei dati
//* CON il file ProjectRequest.php (creato dal terminale) in cui ci sono tutti gli errori e i messaggi di errore
public function store(ProjectRequest $request)
{

  //* (PEGGIORE) soluzione 2 mostrare gli errori / per la validazione dei dati
  //* SENZA il file ProjectRequest.php
    // public function store(Request $request)
    // {
    //   $request->validate([
    //     'name' => 'required|min:2|max:50',
    //     // 'description' => ''
    //     'category' => 'required|min:2|max:255',
    //     'start_date' => 'date',
    //     'end_date' => 'date|after:start_date',
    //     'url' => 'required|min:4|max:255',
    //     'produced_for' => 'max:255',
    //     'collaborators' => 'max:255'
    //   ],[
    //     'name.required' => 'The name field is required',
    //       'name.min' => 'The name must be at least :min characters',
    //       'name.max' => 'The name must not exceed :max characters',
    //       // 'image.required' => 'The image field is required',
    //       'category.required' => 'The category field is required',
    //       'category.min' => 'The category field must be at least :min characters',
    //       'category.max' => 'The category field must not exceed :max characters',
    //       'start_date.date' => 'The start date was written incorrectly',
    //       'end_date.date' => 'The start date was written incorrectly',
    //       'url.required' => 'The url field is required',
    //       'url.min' => 'The url field must be at least :min characters',
    //       'url.max' => 'The url field must not exceed :max characters',
    //       'produced_for.max' => 'The produced for field must not exceed :max characters',
    //       'collaborators.max' => 'The collaborators field must not exceed :max characters',
    //   ]);

      //* per creare un nuovo progetto e salvare i dati nel database al click del button submit del form in create
      $form_data = $request->all();

      $new_project = new Project();

      //*soluzione 1 senza fillable
      // $new_project->name = $form_data['name'];
      // $new_project->slug = Project::generateSlug($form_data['name']);
      // $new_project->description = $form_data['description'];
      // $new_project->category = $form_data['category'];
      // // $new_project->date = date('Y-m-d');
      // $new_project->start_date = $form_data['start_date'];
      // $new_project->end_date = $form_data['end_date'];
      // $new_project->url = $form_data['url'];
      // $new_project->produced_for = $form_data['produced_for'];
      // $new_project->collaborators = $form_data['collaborators'];



      //* IMMAGINI
      //* verificare se è stata caricata un immagine
      if(array_key_exists('image', $form_data)){

        // dd('The image exists');
//* (PEGGIORE) soluzione 1 PER CARICARE UN IMMAGINE
        // il 1° param. rappresenta la posizione (public\storage\uploads) in cui viene salvato il file mentre con 2° la rinomina e la inserisce nella posto in cui deve essere salvato
        // Storage::put('uploads', $form_data['image']);

//* (MIGLIORE) soluzione 2 PER CARICARE UN IMMAGINE mantendo lo stesso nome
        // prima di salvare l'immagine salvo il nome
        $form_data['image_original_name'] = $request->file('image')->getClientOriginalName();
        // salvo l'immagine nella cartella uploads (public\storage\uploads) e in $form_data['image_path'] salvo il percorso //! il nome originale viene salvato nel db ma nel percorso del db e nella cartella uploads non viene salvato il nome originale
        $form_data['image_path'] = Storage::put('uploads', $form_data['image']);
        //! SOLO UN ESEMPIO MA per fare ciò c'è bisogno che l'immagine abbia un nome univoco quindi aggiungere ulteriori controlli // per salvare il nome originale anche nel percorso del db e nella cartella uploads
        // $form_data['image_path'] = Storage::putFileAs('uploads', $form_data['image'], 'nomeImmagine');
        // ESEMPIO salvare il percorso concatenato con l'anno //! lo stesso percorso deve essere scritto anche in show.blade.php
        // $form_data['image_path'] = Storage::put('uploads/'. d('Y') . '/', $form_data['image']);


        // dd($form_data['image_original_name']);
        // dd($form_data);

      }

      //*soluzione 2 con fillable (collegata al model Project.php)
      // lo slug deve essere generato in modo automatico ogni volta che viene creato un nuovo prodotto quindi è stata creata un funzione nel model
      $form_data['slug'] = Project::generateSlug($form_data['name']);
      // con fill i dati vengono salvati tramite le chiavi salvate nel model in protected $fillable in modo da fare l'associazione chiave-valore automaticamente
      $new_project->fill($form_data);

      // dd($request->all());
      $new_project->save();

      //* redirect al progetto appena generato
      return redirect()->route('adminprojects.show', $new_project);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //* metodo migliore
    //! MA BISOGNA USARE IL PARAMETRO DI DEFAULT (in questo caso $dCComic) e non può essere modificato
    public function show(Project $project)
    {
      // con orario formattato (per show.blade.php)
      $start_date = date_create($project->start_date);
      $start_date_formatted = date_format($start_date, 'd/m/Y');

      // con orario formattato (per show.blade.php)
      $end_date = date_create($project->end_date);
      $end_date_formatted = date_format($end_date, 'd/m/Y');

      return view('admin.projects.show', compact('project', 'start_date_formatted', 'end_date_formatted'));
    }
    // OPPURE con id
    // public function show($id)
    // {
    //   $project = Project::find($id);
    //   // dd($project);
    //   return view('projects.show', compact('project'));
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
      return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //* bisogna aggiungere "Project $project" in modo da ottenere gli errori scritti nella request in store() (per create.blade.php)
    public function update(Request $request, Project $project)
    {
      //* prendo tutti i dati fillable salvati in request
      $form_data = $request->all();

      //* se il titolo è stato modificato
      //* genero un nuovo slug
      //* altrimenti lo slug resta lo stesso di prima
      if($project->slug === $form_data['name']){
        $form_data['slug'] = Project::generateSlug($form_data['name']);
      }else{
        $form_data['slug'] = $project->slug;
      }

      //* aggiorno i dati
      $project->update($form_data);

      // con orario formattato (per show.blade.php)
      $start_date = date_create($project->start_date);
      $start_date_formatted = date_format($start_date, 'd/m/Y');

      // con orario formattato (per show.blade.php)
      $end_date = date_create($project->end_date);
      $end_date_formatted = date_format($end_date, 'd/m/Y');

      return view('admin.projects.show', compact('project', 'start_date_formatted', 'end_date_formatted'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
      //* eliminazione progetto
      $project->delete();

      //* REINDIRIZZAMENTO alla pagina index e mostro il messaggio di avvenuta eliminazione con il metodo WITH
      //* with(chiave , valore)  accetta 2 parametri. il primo è la CHIAVE della VARIABILE di SESSIONE e il secondo è il VALORE (in questo caso la frase)
      return redirect()->route('adminprojects.index')->with('deleted', "The project: $project->name was deleted successfully");
    }
}
