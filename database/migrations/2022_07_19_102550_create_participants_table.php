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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('groupe_id');
            $table->unsignedBigInteger('personnel_id');
            $table->unsignedBigInteger('groupe_formation_id');
            $table->foreign('groupe_id')->on('groupes')->references('id');
            $table->foreign('personnel_id')->on('personnels')->references('id');
            $table->foreign('groupe_formation_id')->on('groupe_formations')->references('id');
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
        Schema::dropIfExists('participants');
    }
};
