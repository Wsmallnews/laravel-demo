<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 店铺认证信息表
        Schema::create('merch_auths', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('merch_id')->default(0)->comment('店铺id');
            $table->string('real_name')->comment('店主真实姓名');
            $table->string('id_card')->comment('身份证号');
            $table->text('id_card_images')->comment("身份证正反面照片");
            $table->text('business_images')->comment("营业执照照片");
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
        Schema::dropIfExists('merch_auths');
    }
}
