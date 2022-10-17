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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('codeModule');
            $table->string('intitule');
            $table->integer('semestre');
            $table->timestamps();

            $table->unsignedBigInteger('niveaux_id');
                $table->foreign('niveaux_id')
                ->references('id')
                ->on('niveaux')
                ->onDelete('cascade')
                ->onUpdate('cascade');

                $table->unsignedBigInteger('professeur_id');
                $table->foreign('professeur_id')
                ->references('id')
                ->on('professeurs')
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
        Schema::dropIfExists('modules');
    }
};
