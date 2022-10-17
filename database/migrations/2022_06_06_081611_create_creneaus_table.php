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
        Schema::create('creneaus', function (Blueprint $table) {
            $table->id();
            $table->date('dateCreneau');
            $table->time('heureDebut');
            $table->time('heureFin');
            $table->timestamps();

            $table->unsignedBigInteger('matiere_id');
                $table->foreign('matiere_id')
                ->references('id')
                ->on('matieres')
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
        Schema::dropIfExists('creneaus');
    }
};
