<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('post_id');
            $table->string('post_title');//Заголовок статьи
            $table->string('post_slug')->unique();//Уникальное имя статьи
            $table->text('post_content');//Текст поста
            $table->string('post_thumbnail')
                ->default('');
            $table->enum('post_status',['draft','publish','trash'] )->default('draft');

            $table->integer('post_author')->unsigned()->default(0);
            $table->foreign('post_author')
                  ->references('user_id')->on('users')
                  ->onDelete('cascade');

            $table->integer('main_cat')->unsigned()->default(0);
            /*$table->foreign('main_cat')
                  ->references('cat_id')->on('categories')
                  ->onDelete('cascade');*/

            $table->string('hash_url')->unique();

            $table->string('meta_description')->default('');//description
            $table->string('meta_keywords')->default('');//keywords                
            $table->string('meta_img') ->default('');//картинка для мета тега
               

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
        Schema::dropIfExists('posts');
    }
}
