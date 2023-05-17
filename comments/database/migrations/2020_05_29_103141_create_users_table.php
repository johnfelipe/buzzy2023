<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'users',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('username', 40)->index()->unique();
                $table->string('username_slug', 40)->unique();
                $table->string('email')->unique();
                $table->string('password');
                $table->string('api_token')->nullable();
                $table->string('user_type')->nullable();
                $table->string('name')->nullable();
                $table->string('city')->nullable();
                $table->string('gender')->nullable();
                $table->string('icon')->nullable();
                $table->string('age')->nullable();
                $table->ipAddress('ipno')->nullable();
                $table->string('url')->nullable();
                $table->text('about')->nullable();
                $table->string('facebook_id')->nullable();
                $table->string('google_id')->nullable();
                $table->string('twitter_id')->nullable();
                $table->timestamp('last_seen')->nullable();
                $table->rememberToken();
                $table->timestamps();
            }
        );
    }
    /*  `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` varchar(50) DEFAULT NULL,
    `password` varchar(50) DEFAULT NULL,
    `email` varchar(50) DEFAULT NULL,
    `age` varchar(15) DEFAULT NULL,
    `registerdate` varchar(15) DEFAULT NULL,
    `gender` varchar(50) DEFAULT NULL,
    `name` varchar(50) DEFAULT NULL,
    `surname` varchar(50) DEFAULT NULL,
    `icon` text,
    `city` varchar(50) DEFAULT NULL,
    `last_date` varchar(15) DEFAULT NULL,
    `usertype` int(11) DEFAULT NULL,
    `ipno` varchar(50) DEFAULT NULL,
    `ban` int(11) DEFAULT NULL,
    `social` varchar(250) DEFAULT NULL,
    `socialtype` varchar(15) DEFAULT NULL,
    `seoslug` varchar(250) DEFAULT NULL,
    `about` varchar(255) DEFAULT NULL, */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
