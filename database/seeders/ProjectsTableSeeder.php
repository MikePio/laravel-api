<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //* importo il file con i dati
      $projects = config('projects');

      //*ciclo i dati
      foreach($projects as $project){

        $new_project = new Project();

        //* foreign key
        $new_project->type_id = Type::inRandomOrder()->first()->id; //Prende in modo random un id (/un numero) dalla tabella Type e lo assegna a type_id
        $new_project->name = $project['name'];
        $new_project->slug = Project::generateSlug($new_project->name);
        $new_project->description = $project['description'];
        // $new_project->image = $project['image'];
        $new_project->category = implode(' | ', $project['category']);
        $new_project->start_date = $project['start_date'];
        $new_project->end_date = $project['end_date'];
        $new_project->url = $project['url'];
        $new_project->produced_for = $project['produced_for'];
        $new_project->collaborators = implode(' | ', $project['collaborators']) ;

        //* dump dei dati + php artisan db:seed --class=NamesTableSeeder OPPURE se è centralizzato in DatabaseSeeder.php inviare il comando php artisan db:seed
        // dd($new_project);
        //* invio i dati + php artisan db:seed --class=NamesTableSeeder OPPURE se è centralizzato in DatabaseSeeder.php inviare il comando php artisan db:seed
        $new_project->save();
      }
    }
}
