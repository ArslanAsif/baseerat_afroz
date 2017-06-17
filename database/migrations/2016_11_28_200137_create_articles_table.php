<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->string('picture');
            $table->string('summary');
            $table->unsignedInteger('priority');
            $table->integer('view_count')->default(0);
            $table->tinyInteger('active')->default(0);
            $table->tinyInteger('public_appr')->default(0);
            $table->tinyInteger('community_appr')->default(0);
            $table->tinyInteger('homepage')->default(0);
            $table->tinyInteger('spotlight')->default(0);
            $table->tinyInteger('headline')->default(0);
            $table->tinyInteger('featured')->default(0);
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->timestamps();
            $table->datetime('publish_date')->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
