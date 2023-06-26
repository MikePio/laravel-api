<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_technology', function (Blueprint $table) {

          //! da eliminare
          // $table->id();
          // $table->timestamps();

          //* relazione many-to-many per la tabella projects
          // nome della colonna nella tabella
          $table->unsignedBigInteger('project_id');

          // assegno nome della foreign key alla colonna creata
          $table->foreign('project_id')
                // che è collegata/relazionata all'id
                ->references('id')
                // della tabella projects
                ->on('projects')
                // all'eliminazione di un project viene eliminata anche la relazione con la technology
                ->cascadeOnDelete();

          //* relazione many-to-many per la tabella technologies
          // nome della colonna nella tabella
          $table->unsignedBigInteger('technology_id');

          // assegno nome della foreign key alla colonna creata
          $table->foreign('technology_id')
                // che è collegata/relazionata all'id
                ->references('id')
                // della tabella technologies
                ->on('technologies')
                // all'eliminazione di un technology viene eliminata anche la relazione con la project
                ->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_technology');
    }
};
