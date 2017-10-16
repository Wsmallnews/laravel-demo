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
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('cat_id')->comment('文章分类id');
            $table->string('title');
            $table->string('images')->comment('文章图片');
            $table->text('content');
            $table->string('keywords')->comment('文章关键字');
            $table->tinyInteger('status')->comment('文章状态， 1 有效, 0 无效不显示');
            $table->string('desc')->comment('文章描述，摘要');
            $table->integer('view_num')->comment('浏览量');
            $table->timestamps();
            $table->softDeletes();
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
