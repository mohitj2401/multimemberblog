<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorysBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_blogs', function (Blueprint $table) {
            $table->bigIncrements('id');        
            $table->foreignId('blog_id')
            ->constrained();
            $table->foreignId('category_id')
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
        Schema::dropIfExists('categorys_blogs');
    }
}
