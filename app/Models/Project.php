<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//* per generare lo slug in questo caso
use Illuminate\Support\Str;
//* per il soft delete
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

  //* per il soft delete
  protected $dates = ['delete_at'];

    //* array utilizzato per centralizzare i campi della tabella in modo da rendere più leggibile store() in PageController.php (per creare un nuovo progetto)
  protected $fillable = [
    'name',
    'user_id',
    'type_id',
    'slug',
    'description',
    'category',
    'start_date',
    'end_date',
    'url',
    'produced_for',
    'collaborators',
    'image_path',
    'image_original_name'
  ];

  //* collegamento con la tabella technologies
  public function technologies(){ // il nome della tabella in camelCase al plurale (technologies) perché ogni project ha più technologies
    return $this->belongsToMany(Technology::class);
  }

  //* collegamento/relazione con la tabella types
  public function type(){ // il nome della tabella in camelCase al singolare (type) perché ogni project ha un solo tipo
    // belongsTo = Appartiene a
    return $this->belongsTo(Type::class);
  }

  //* collegamento/relazione one-to-many con la tabella user
  public function user(){
    return $this->belongsTo(User::class);
  }

    //* funzione per generare uno slug univoco
  public static function generateSlug($str){

    $slug = Str::slug($str, '-');
    $original_slug = $slug;

    $slug_exists = Project::where('slug', $slug)->first();
    // contatore
    $c = 1;

    //controllo di univocità
    // 1. controllo se lo slug è già presente
    // 2. se non è presente ritorno sullo slug generato
    // 3. se è presente aggiungo un contatore
    // 4. se anche il numero del contatore è presente aggiungo +1 al contatore fino a trovare uno slug univoco

    while($slug_exists){
      $slug = $original_slug . '-' . $c;
      $slug_exists = Project::where('slug', $slug)->first();
      $c++;
    }

    return $slug;
  }

}
