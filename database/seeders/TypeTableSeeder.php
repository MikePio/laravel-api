<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // dati di default
      $types = ['Front-end', 'Back-end', 'Full-stack'];

      foreach($types as $type){
        $new_type = new Type();
        $new_type->name = $type;
        $new_type->slug = Type::generateSlug($new_type->name);
        // dump($new_type);
        $new_type->save();
      }


    }
}
