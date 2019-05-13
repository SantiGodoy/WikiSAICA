<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeArticleTitle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function ($table) {
            $table->longtext('title')->change();
        });
        Schema::table('articles_deleted', function ($table) {
            $table->longtext('title')->change();
        });
        Schema::table('versions', function ($table) {
            $table->longtext('title')->change();
            $table->longtext('description')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
