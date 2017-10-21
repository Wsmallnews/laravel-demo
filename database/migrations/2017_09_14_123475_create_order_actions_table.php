<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_actions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('order_id', 60)->unique()->comment("订单id");
            $table->integer('user_id')->comment("用户id");
            $table->string('pay_type')->comment('支付类型，wechat,alipay,wallet,bonus,coupon');
            $table->decimal('pay_fee', 10, 2)->comment("支付金额");
            $table->timestamp('payed_at')->comment("支付时间");
            $table->string('payment_trade_no')->nullable();
            $table->string('payment_trade_status')->nullable();
            $table->string('payment_notify_id')->nullable();
            $table->string('payment_notify_time')->nullable();
            $table->string('payment_buyer_email')->nullable();
            $table->string('payment_total_fee')->nullable();
            $table->text('payment_json')->nullable();
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
        Schema::dropIfExists('order_actions');
    }
}
