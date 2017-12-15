<?php

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
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('comment_id');
            $table->text('comment_content');//Текст поста

            $table->enum('comment_status',['moderated','approved','spam','trash'] )->default('moderated');
            
            $table->integer('comment_author')->unsigned()->default(0);
            $table->foreign('comment_author')
                ->references('user_id')->on('users')
                ->onDelete('cascade');
            
            $table->integer('comment_post')->unsigned()->default(0);
            $table->foreign('comment_post')
                ->references('post_id')->on('posts')
                ->onDelete('cascade');            

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
        Schema::dropIfExists('comments');
    }
}
