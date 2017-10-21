<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 用户钱包表
        Schema::create('wallets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id')->unique();
            $table->decimal('money', 10, 2);
            $table->decimal('money_lock', 10, 2);
            $table->integer('integral')->comment('积分');
            $table->string('password')->comment('支付密码');
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
        Schema::dropIfExists('wallets');
    }
}
