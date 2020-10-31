<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags_blogs', function (Blueprint $table) {
            $table->bigIncrements('id');        
            $table->foreignId('blog_id')
            ->constrained();
            $table->foreignId('tag_id')
            ->constrained();
               
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags_blogs');
    }
}
