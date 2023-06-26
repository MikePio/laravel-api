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
        Schema::table('projects', function (Blueprint $table) {

          //* 1. creo la colonna della foreign key
          $table->unsignedBigInteger('type_id')->nullable()->after('id');
          //* 2. assegno la foreign key alla colonna creata
          $table->foreign('type_id')
          //* che è collegata/relazionata all'id
          ->references('id')
          //* della tabella types
          ->on('types')
          //* quando viene cancellata la colonna viene SETTATO NULL a "type_id"
          ->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {

         //* FUNZIONE di ROLLBACK
         //* soluzione 1 per eliminare la foreign key
         //* passare il nome della colonna dentro le quadre
          $table->dropForeign(['type_id']);

          // soluzione 2 per eliminare la foreign key
          // passare "nome della tabella_nome della colonna_forign
          // $table->dropForeign('project_type_id_foreign');

          //* elimino la colonna
          $table->dropColumn('type_id');

        });
    }
};
