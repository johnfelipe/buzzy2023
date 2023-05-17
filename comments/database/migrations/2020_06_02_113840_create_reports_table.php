<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'reports', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('comment_id')->index()->nullable();
                $table->unsignedInteger('user_id')->nullable();
                $table->string('body', 500)->nullable();
                $table->timestamps();

                $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
