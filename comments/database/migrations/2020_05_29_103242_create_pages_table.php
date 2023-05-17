<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'pages', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->text('body')->nullable();
                $table->string('type')->nullable();
                $table->timestamps();
            }
        );
    }
    /*    `id` int(11) NOT NULL AUTO_INCREMENT,
    `date` text,
    `pagetitle` varchar(255) NOT NULL,
    `text` text,
    `content_type` varchar(20) NOT NULL, */
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
