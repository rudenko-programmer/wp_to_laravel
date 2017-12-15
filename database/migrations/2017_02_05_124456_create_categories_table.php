<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('cat_id');
            $table->integer('parent_id')->unsigned()->default(0);

            $table->string('cat_title');
            $table->string('cat_slug')->unique();
            $table->text('cat_content');
            $table->string('cat_thumbnail')
                  ->default('');
            $table->string('hash_url')->unique();

            $table->enum('cat_status',['draft','publish','trash'] )->default('draft');

            $table->string('meta_description')
                  ->default('');
            $table->string('meta_keywords')
                  ->default('');
            $table->string('meta_img')
                  ->default('');

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
        Schema::dropIfExists('categories');
    }
}
