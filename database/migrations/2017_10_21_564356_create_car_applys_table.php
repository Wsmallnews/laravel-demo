<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarApplysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 车辆认证申请表
        Schema::create('car_applys', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->default(0)->comment('用户id');
            $table->string('phone')->comment("车主手机号");

            // 车辆 信息，字段，车牌号，车型

            $table->text('driving_images')->comment("行驶证正反面照片");
            $table->text('car_images')->comment("车辆照片");
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
        Schema::dropIfExists('car_applys');
    }
}
