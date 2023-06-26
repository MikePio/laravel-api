<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      //* centralizzo il/i seeder in modo da poter inviare i dati tutti in una volta con il comando: php artisan db:seed
      $this->call([
        TypeTableSeeder::class,
        ProjectsTableSeeder::class, //! in produzione bisogna commentare questo seeder
      ]);

    }
}
