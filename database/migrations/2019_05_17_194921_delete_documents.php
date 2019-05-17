<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('documents_deleted', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->integer('article_id')->unsigned();
        //  $table->foreign('article_id')->references('id')->on('articles');
          $table->string('filename');
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
        Schema::dropIfExists('documents_deleted');
    }
}
