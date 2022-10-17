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
        Schema::create('professeurs', function (Blueprint $table) {
            $table->id();
            $table->string('matricule');
            $table->enum('grade', array('PROFESSEUR', 'PFE' ,'DOCTORANT','PA'))->default('PROFESSEUR');
            $table->enum('statut', array('VACATAIRE', 'PERMANENT'))->default('PERMANENT');
            $table->timestamps();

            $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('professeurs');
    }
};
