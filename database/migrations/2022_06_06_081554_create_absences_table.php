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
        Schema::disableForeignKeyConstraints();
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->enum('statut', array('P', 'AJ' ,'ANJ'))->default('P');
            $table->timestamps();

            $table->unsignedBigInteger('etudiant_id');
                $table->foreign('etudiant_id')
                ->references('id')
                ->on('etudiants')
                ->onDelete('cascade')
                ->onUpdate('cascade');

                $table->unsignedBigInteger('creneau_id');
                $table->foreign('creneau_id')
                ->references('id')
                ->on('creneaus')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absences');
    }
};
