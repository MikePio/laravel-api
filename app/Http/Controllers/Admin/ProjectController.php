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
//* importo la tabella types
use App\Models\Type;
//* importo la tabella technologies
use App\Models\Technology;
//* importo Auth per capire quale utente è loggato
use Illuminate\Support\Facades\Auth;
//* importando Facades\DB è possibile fare delle query pure in SQL senza utilizzare eloquent (vedi esempio della query per la barra di ricerca)
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      // //* vengono mostrati tutti progetti in una volta
      // // $projects = Project::all();
      // //* vengono mostrati 8 progetti alla volta (per far ciò è necessario importare bootstrap in AppServiceProvider)
      // $projects = Project::paginate(8);
      // // $projects = Project::paginate(2);

      $direction = 'asc';

      //* Ricerca per nome dei progetti
      //* verifico se è presente la variabile search in GET
      if(isset($_GET['search'])){

        $toSearch = $_GET['search'];

        //* controllo che l'utente possa ricercare solo i progetti suoi ed non di altri utenti
        $projects = Project::where('user_id', Auth::id())
                        //* faccio la query con LIKE per vedere se è presente un progetto che include la parola inserita
                        ->where('name', 'like', "%$toSearch%")
                        //* vengono mostrati 8 progetti alla volta (per far ciò è necessario importare bootstrap in AppServiceProvider)
                        ->paginate(8);
      //* se non c'è la variabile search in GET faccio la query di tutti i progetti con la paginazione
      }else{
        // * controllo che l'utente possa ricercare solo i progetti suoi ed non di altri utenti
        $projects = Project::where('user_id', Auth::id())
                  //* vengono mostrati 8 progetti alla volta (per far ciò è necessario importare bootstrap in AppServiceProvider)
                  ->orderBy('id',$direction)->paginate(8);
      }

      //* importando Facades\DB è possibile fare delle query pure in SQL senza utilizzare eloquent (vedi esempio della query per la barra di ricerca)
      // ! attenzione: credo ci sia bisogno anche di collegare i progetti con i tipi e le tecnologie
      // esempi del prof
      // $projects = DB::search('SELECT * FROM `projects`');
      // esempi chat gpt
      // $projects = DB::select("SELECT * FROM projects WHERE name LIKE '%$toSearch%' LIMIT 8");
      // $projects = DB::select('SELECT * FROM projects WHERE name LIKE ? LIMIT 8', ["%$toSearch%"]);

      return view('admin.projects.index', compact('projects', 'direction'));
    }

    //* funzione per ordinare in modo asc/ascendente e desc/discendente le colonne nella pagina index dei progetti
    public function orderby($direction, $column){

      // if ($direction == 'asc') {
      //   //* Se la direzione è ascendente, imposta la direzione a discendente
      //   $direction = 'desc';
      // } else {
      //   //* Se la direzione è discendente, imposta la direzione ad ascendente
      //   $direction = 'asc';
      // }
      // OPPURE
      $direction = $direction == 'asc' ? 'desc' : 'asc';

      $projects = Project::where('user_id', Auth::id())
                          ->orderBy($column, $direction)
                          ->paginate(8);

      return view('admin.projects.index', compact('projects', 'direction', 'column'));
    }

    //* per la pagina type-projects
    public function typeProjects(){
      // //* vengono mostrati tutti tipi in una volta
      // // $types = Type::all();
      // //* vengono mostrati 8 tipi alla volta (per far ciò è necessario importare bootstrap in AppServiceProvider)
      // $types = Type::paginate(8);
      // // $types = Type::paginate(2);

      //* ottenere progetti collegati ai type dell'utente loggato - Soluzione 1 Peggiore step 2/2 - ottenere solo i tipi, ESCLUSI quelli che non hanno collegamenti con progetti per l'utente loggato
      // $types = Type::with('projects')->has('projects')->paginate(8); // 'projects' viene dalla funzione dichiarata nel model Type

      //* ottenere progetti collegati ai type dell'utente loggato - Soluzione 2 Quasi Migliore step 1/1 - ottenere solo i tipi, ESCLUSI quelli che non hanno collegamenti con progetti per l'utente loggato
      // Seleziona solo i tipi che hanno progetti associati all'utente corrente
      // $types = Type::whereHas('projects', function ($query) { // 'projects' viene dalla funzione dichiarata nel model Type
      //   $query->where('user_id', Auth::id()); // Filtra i tipi con progetti dell'utente corrente
      // })->with(['projects' => function ($query) { // 'projects' viene dalla funzione dichiarata nel model Type
      //   $query->where('user_id', Auth::id()); // Carica solo i progetti dell'utente corrente all'interno di ciascun tipo
      // }])->paginate(8);

      //* ottenere progetti collegati ai type dell'utente loggato - Soluzione 3 MIGLIORE DI TUTTE step 1/1 - ottenere i tipi, INCLUSI quelli che non hanno collegamenti con progetti per l'utente loggato
      // Ottieni l'utente loggato
      $user = Auth::user(); // Auth::user() restituisce l'oggetto dell'utente attualmente autenticato nel sistema

      // Carica tutti i tipi, inclusi quelli senza collegamenti con progetti
      $types = Type::with(['projects' => function ($query) use ($user) { // 'projects' viene dalla funzione dichiarata nel model Type
        // Filtra solo i progetti dell'utente loggato
        $query->where('user_id', $user->id);
      }])->paginate(8);

      return view('admin.projects.type-projects', compact('types'));
    }

    //* per la pagina technologies-projects
    public function technologiesProjects(){
      // //* vengono mostrati tutti tecnologie in una volta
      // // $technologies = Technology::all();
      // //* vengono mostrati 8 tecnologie alla volta (per far ciò è necessario importare bootstrap in AppServiceProvider)
      // $technologies = Technology::paginate(8);
      // // $technologies = Technology::paginate(2);

      //* ottenere progetti collegati ai technologies dell'utente loggato - Soluzione 3 MIGLIORE DI TUTTE step 1/1 - ottenere i technologies, INCLUSI quelli che non hanno collegamenti con progetti per l'utente loggato
      // Ottieni l'utente loggato
      $user = Auth::user(); // Auth::user() restituisce l'oggetto dell'utente attualmente autenticato nel sistema

      // Carica tutte le technologies, incluse quelle senza collegamenti con progetti
      $technologies = Technology::with(['projects' => function ($query) use ($user) { // 'projects' viene dalla funzione dichiarata nel model Technology
        // Filtra solo i progetti dell'utente loggato
        $query->where('user_id', $user->id);
      }])->paginate(8);

      return view('admin.projects.technologies-projects', compact('technologies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $types = Type::all();
      $technologies = Technology::all();

      return view('admin.projects.create', compact('types', 'technologies'));
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

      //* serve per salvare l'id dell'user loggato nel campo user_id nella tabella projects
      $form_data['user_id'] = Auth::id();

      // con fill i dati vengono salvati tramite le chiavi salvate nel model in protected $fillable in modo da fare l'associazione chiave-valore automaticamente
      $new_project->fill($form_data);

      // dd($request->all());
      $new_project->save();

      // * soluzione lunga per fare ciò che elencato qui sotto: new Project(), fill($form_data), save()
      // $new_project = new Project();
      // $new_project->fill($form_data);
      // $new_project->save();
      // * soluzione breve per fare quello commentato sopra: new Project(), fill($form_data), save()
      // $new_project = Project::create($form_data);

      // * many-to-many -> collegamento nella tabella ponte delle tecnologie e dei progetti
      // se ho cliccato almeno una technology nel file create
      if(array_key_exists('technologies', $form_data)){
        // "attacco" al project appena creato l'array dei technologies proveniente dal form
        $new_project->technologies()->attach($form_data['technologies']);
      }

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
    public function show($id)
    {

      //* controllo che l'utente possa vedere solo i sui progetti e non di altri utenti
      $project = Project::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->first();

      //* se cerco nell'url un project che non esiste o che è di un altro utente mostro una pagina con l'errore 404 (al posto di una pagina di errore php)
      if(!$project){
        abort('404');
      }

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
      $types = Type::all();
      $technologies = Technology::all();
      return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //* bisogna aggiungere "Project $project" in modo da ottenere gli errori scritti nella request in store() (per create.blade.php)
    // public function update(Request $request, Project $project)
    public function update(ProjectRequest $request, Project $project)
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

      //* edit per l'IMMAGINE
      // verificare se è stata caricata un immagine (dal campo di input nel form)
      if(array_key_exists('image', $form_data)){

        //* se l'immagine esiste (NEL DB) vuol dire che ne ho caricata una nuova e quindi ELIMINO quella precedente
        if($project->image_path){
          // se è presente sul disco in public ed elimina l'immagine già presente
          Storage::disk('public')->delete($project->image_path);
        }

        //* (MIGLIORE) soluzione PER CARICARE UN IMMAGINE mantendo lo stesso nome
        // prima di salvare l'immagine salvo il nome
        $form_data['image_original_name'] = $request->file('image')->getClientOriginalName();
        // salvo l'immagine nella cartella uploads (public\storage\uploads) e in $form_data['image_path'] salvo il percorso //! il nome originale viene salvato nel db ma nel percorso del db e nella cartella uploads non viene salvato il nome originale
        $form_data['image_path'] = Storage::put('uploads', $form_data['image']);

      }

      //* aggiorno i dati
      $project->update($form_data);

      // con orario formattato (per show.blade.php)
      $start_date = date_create($project->start_date);
      $start_date_formatted = date_format($start_date, 'd/m/Y');

      // con orario formattato (per show.blade.php)
      $end_date = date_create($project->end_date);
      $end_date_formatted = date_format($end_date, 'd/m/Y');

      // * many-to-many -> collegamento nella tabella ponte delle tecnologie e dei progetti
      // se ho cliccato almeno una technology nel file edit
      if(array_key_exists('technologies', $form_data)){
        // se ci sono già tecnologie selezionate le sincronizzo con le nuove selezionate (invece utilizzando attach al posto di sync vengo aggiunte nuovamente quelle selezionate in precedenza)
        $project->technologies()->sync($form_data['technologies']);
      }else{
        // se non seleziono nessuna technology nel file edit elimino tutte le relazioni
        $project->technologies()->detach();
      }

      // return view('admin.projects.show', compact('project', 'start_date_formatted', 'end_date_formatted'));
      // oppure
      // return redirect()->route('adminprojects.show', $project);
      // oppure
      return redirect()->route('adminprojects.show', compact('project', 'start_date_formatted', 'end_date_formatted'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
      // * delete many-to-many
      // se nella migration non ho messo cascadeOnDelete e devo fare un eliminazione totale (NON soft) di un oggetto/elemento //* MA è MEGLIO INSERIRE cascadeOnDelete nella migration e utilizzarlo solo se c'è bisogno di eliminare i collegamenti nelle tabelle ponte delle many-to-many all'eliminazione di un oggetto/elemento
      // $project->technologies()->detach(); //* SE è STATO ATTIVATO IL SOFT DELETE - Serve per eliminare i collegamenti nelle tabelle ponte quando viene eliminato un oggetto/elemento di una tabella many-to-many / se NON è STATO ATTIVATO IL SOFT DELETE c'è bisogno solo di INSERIRE cascadeOnDelete nella migration

      //* se il project da eliminare contiene un immagine, quest'ultima deve essere cancellata anche nella cartella
      if($project->image_path){
        Storage::disk('public')->delete($project->image_path);
      }

      //* eliminazione progetto
      $project->delete();

      //* REINDIRIZZAMENTO alla pagina index e mostro il messaggio di avvenuta eliminazione con il metodo WITH
      //* with(chiave , valore)  accetta 2 parametri. il primo è la CHIAVE della VARIABILE di SESSIONE e il secondo è il VALORE (in questo caso la frase)
      return redirect()->route('adminprojects.index')->with('deleted', "The project: $project->name has been successfully deleted");
    }
}
