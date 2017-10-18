<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_cats', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->comment('分类名称');
            $table->integer('parent_id')->default(0)->nullable()->index();
            $table->integer('lft')->nullable()->index()->comment('无线级联使用');
            $table->integer('rgt')->nullable()->index()->comment('无线级联使用');
            $table->integer('depth')->nullable()->comment('无线级联使用');
            $table->tinyInteger('is_nav')->comment('是否导航栏');
            $table->smallInteger('sort_order')->comment('排序');
            $table->text('desc')->comment('描述');
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
        Schema::dropIfExists('article_cats');
    }
}
