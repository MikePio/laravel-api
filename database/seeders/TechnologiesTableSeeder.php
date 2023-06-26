<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnologiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //* inserisco i dati
      $technologies = ['HTML', 'CSS', 'SCSS', 'JavaScript', 'PHP', 'Bootstrap', 'Vue.js', 'Vite.js', 'Laravel'];

      //* ciclo i dati
      foreach($technologies as $technology){

        $new_tecnology = new Technology;

        $new_tecnology->name =$technology;
        $new_tecnology->slug = Technology::generateSlug($new_tecnology->name);

        // dump($new_tecnology);
        //* li invio al db
        $new_tecnology->save();

      }
    }

}
