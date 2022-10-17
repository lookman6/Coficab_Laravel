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
        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->Date('dateDebut');
            $table->Date('dateFin');
            $table->enum('type',array('interne','externe'));
            $table->integer('duree');
            $table->double('cout')->default(0);
            $table->unsignedBigInteger('formateur_id');
            $table->unsignedBigInteger('formation_id');
            $table->unsignedBigInteger('cabinet_id')->nullable();
            $table->unsignedBigInteger('salle_id');
            $table->unsignedBigInteger('groupe_formation_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seances');
    }
};
