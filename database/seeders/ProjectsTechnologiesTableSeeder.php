<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectsTechnologiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      for($i = 0; $i < 3; $i++){

        //* in modo casuale viene preso un progetto
        $project = Project::inRandomOrder()->first();

        //* in modo casuale viene preso l'id di una tecnologia
        $technology_id = Technology::inRandomOrder()->first()->id;

        //* ora al progetto estratto viene assegnato (tramite il metodo technologies() scritto nel model di Project) l'id estratto di una tecnologia
        $project->technologies()->attach($technology_id);

        // dump($project);
        // dump($technology_id);

      }
    }
}
