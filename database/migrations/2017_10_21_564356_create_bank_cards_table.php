<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 银行账户表
        Schema::create('bank_cards', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->default(0)->comment('用户id');
            $table->integer('merch_id')->default(0)->comment('商户id，不和用户id 同时存在');
            $table->string('bank_name')->comment('银行名');
            $table->string('bank_branch_name')->comment('银行支行名');
            $table->string('bank_address')->comment('开户行地址');
            $table->string('bank_card')->comment('卡号');
            $table->string('card_name')->comment('开户名');
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
        Schema::dropIfExists('bank_cards');
    }
}
