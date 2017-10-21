<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchApplysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 商户认证申请表
        Schema::create('merch_applys', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->default(0)->comment('用户id');
            $table->string('name')->comment('店铺名称');
            $table->string('real_name')->comment('店主真实姓名');
            $table->string('id_card')->comment('身份证号');
            $table->string('bank_card')->comment('提现账号');
            $table->string('bank_name')->comment('开户行');
            $table->text('id_card_images')->comment("身份证正反面照片");
            $table->text('business_images')->comment("营业执照照片");
            $table->tinyInteger('status')->default(0)->comment('审核状态，0 申请中，1 通过，-1 失败');
            $table->string('status_msg')->comment('审核说明');
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
        Schema::dropIfExists('merch_applys');
    }
}
