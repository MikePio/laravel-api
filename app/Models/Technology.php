<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Technology extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug'];

  //* collegamento con la tabella technologies
  public function projects(){
    return $this->belongsToMany(Project::class);
  }


  //* funzione per generare uno slug univoco
  public static function generateSlug($str){

    $slug = Str::slug($str, '-');
    $original_slug = $slug;

    $slug_exists = Technology::where('slug', $slug)->first();
    // contatore
    $c = 1;

    //controllo di univocità
    // 1. controllo se lo slug è già presente
    // 2. se non è presente ritorno sullo slug generato
    // 3. se è presente aggiungo un contatore
    // 4. se anche il numero del contatore è presente aggiungo +1 al contatore fino a trovare uno slug univoco

    while($slug_exists){
      $slug = $original_slug . '-' . $c;
      $slug_exists = Technology::where('slug', $slug)->first();
      $c++;
    }

    return $slug;
  }

}
