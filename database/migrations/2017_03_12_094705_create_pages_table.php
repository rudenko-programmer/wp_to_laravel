<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('page_id');
            $table->string('page_title');//Заголовок статьи
            $table->string('page_slug')->unique();//Уникальное имя статьи
            $table->text('page_content');//Текст поста
            $table->string('page_thumbnail')
                ->default('');
            $table->enum('page_status',['draft','publish','trash'] )->default('draft');
            $table->integer('page_author')->unsigned()->default(0);
            $table->foreign('page_author')
                ->references('user_id')->on('users')
                ->onDelete('cascade'); //??????

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
        Schema::dropIfExists('pages');
    }
}
