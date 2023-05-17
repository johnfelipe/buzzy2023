<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'votes', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('comment_id')->index()->nullable();
                $table->unsignedInteger('user_id')->nullable();
                $table->string('type')->nullable();
                $table->boolean('vote')->index()->default(1);
                $table->ipAddress('ipno')->nullable();
                $table->timestamps();

                $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        );
    }
    /*     `id` int(11) NOT NULL AUTO_INCREMENT,
    `content_id` int(11) DEFAULT NULL,
    `likestype` varchar(11) DEFAULT NULL,
    `user_id` int(11) DEFAULT NULL,
    `date` text,
    `typelike` varchar(15) NOT NULL,
    `domainaccess` varchar(255) DEFAULT NULL, */
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votes');
    }
}
