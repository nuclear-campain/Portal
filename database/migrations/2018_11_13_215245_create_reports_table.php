<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateReportsTable
 */
class CreateReportsTable extends Migration
{
    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('reportable');
            $table->morphs('reporter');
            $table->text('reason');
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('reports_conclusions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('report_id')->unsigned()->index();
            $table->morphs('judge');
            $table->text('conclusion');
            $table->text('action_taken');
            $table->json('meta')->nullable();
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
        Schema::dropIfExists('reports');
        Schema::dropIfExists('reports_conclusions');
    }
}
