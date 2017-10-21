<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 用户钱包日志表
        Schema::create('wallet_logs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->comment('用户 钱包 id');
            $table->decimal('money', 10, 2);
            $table->string('type')->comment('交易类型');
            $table->string('item_id')->comment('交易关联项');
            $table->tinyInteger('is_finish')->comment('是否完成，用于有锁定发生时');
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
        Schema::dropIfExists('wallet_logs');
    }
}
