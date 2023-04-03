<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_medias', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_id')->unsigned()->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->nullable();
            $table->timestamps();
            $table->foreign('project_id')
            ->references('id')->on('projects')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_medias');
        
    }
}
