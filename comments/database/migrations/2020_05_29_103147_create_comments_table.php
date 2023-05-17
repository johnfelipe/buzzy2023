<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'comments', function (Blueprint $table) {
                $table->increments('id');
                $table->text('comment')->nullable();
                $table->unsignedInteger('user_id')->nullable();
                $table->unsignedInteger('parent_id')->nullable();
                $table->string('type')->nullable();
                $table->string('content_id')->nullable();
                $table->string('content_url')->nullable();
                $table->string('access_domain')->nullable();
                $table->boolean('spoiler')->default(0);
                $table->boolean('approve')->default(0);
                if ((DB::connection()->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME) == 'mysql') && version_compare(DB::connection()->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION), '5.7.8', 'ge')) {
                    $table->json('data')->nullable();
                } else {
                    $table->text('data')->nullable();
                }
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        );
    }
    /*  `id` int(11) NOT NULL AUTO_INCREMENT,
    `comment` text NOT NULL,
    `user_id` int(11) DEFAULT NULL,
    `date` varchar(15) DEFAULT NULL,
    `type` varchar(255) NOT NULL,
    `content_id` varchar(255) DEFAULT NULL,
    `domainaccess` varchar(255) DEFAULT NULL,
    `spoiler` int(1) NOT NULL DEFAULT '0',
    `approve` int(2) NOT NULL DEFAULT '0',
    `u_name` varchar(100) DEFAULT NULL,
    `u_email` varchar(100) DEFAULT NULL,
    `out_id` varchar(20) DEFAULT NULL,
    `out_name` varchar(100) DEFAULT NULL,
    `out_link` varchar(250) DEFAULT NULL,
    `out_icon` varchar(250) DEFAULT NULL, */
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
