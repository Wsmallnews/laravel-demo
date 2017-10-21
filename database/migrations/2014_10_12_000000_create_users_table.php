<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('current_city')->comment('当前所在城市');
            $table->string('rank')->comment('用户等级');
            $table->string('is_car_auth')->comment('是否车主认证');
            $table->tinyInteger('is_merch')->default(0)->comment('是否商家');
            $table->integer('merch_id')->default(0)->comment('商家id');
            $table->tinyInteger('status')->default(0)->comment('账号状态');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
