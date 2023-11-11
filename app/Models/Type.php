<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Type extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug'];

  //* collegamento/relazione con la tabella projects
  public function projects(){ // il nome della tabella in camelCase al plurale (projects) perché ogni ogni type ha più progetti
    // ogni type ha più progetti
    return $this->hasMany(Project::class);

    //* ottenere progetti collegati ai type dell'utente loggato - Soluzione 1 step 2/2 - ottenere solo i tipi, ESCLUSI quelli che non hanno collegamenti con progetti per l'utente loggato
    // ogni type ha più progetti //* che appartengono all'id loggato
    // return $this->hasMany(Project::class)->where('user_id', Auth::id());
  }

    //* funzione per generare uno slug univoco
  public static function generateSlug($str){

    $slug = Str::slug($str, '-');
    $original_slug = $slug;

    $slug_exists = Type::where('slug', $slug)->first();
    // contatore
    $c = 1;

    //controllo di univocità
    // 1. controllo se lo slug è già presente
    // 2. se non è presente ritorno sullo slug generato
    // 3. se è presente aggiungo un contatore
    // 4. se anche il numero del contatore è presente aggiungo +1 al contatore fino a trovare uno slug univoco

    while($slug_exists){
      $slug = $original_slug . '-' . $c;
      $slug_exists = Type::where('slug', $slug)->first();
      $c++;
    }

    return $slug;
  }

}
