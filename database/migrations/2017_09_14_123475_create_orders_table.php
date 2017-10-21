<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('order_code', 60)->unique()->comment("订单号");
            $table->integer('user_id')->comment("用户id");
            $table->integer('merch_id')->comment("商户id");
            $table->string('type')->nullable()->comment("订单类型，recharge,merch_receipt,buy..");

            $table->decimal('total_fee', 10, 2);
            $table->tinyInteger('is_pay')->default(0)->comment("是否支付，0 未支付，1 支付中，2 支付完成");
            $table->timestamp('payed_at');
            $table->string('pay_type')->comment('支付类型，wechat,alipay,wallet,bonus,coupon');
            $table->decimal('pay_fee', 10, 2)->comment('在线支付金额');
            $table->decimal('wallet_fee', 10, 2)->comment('余额支付金额');
            $table->decimal('bonus_fee', 10, 2)->comment('红包支付金额');
            $table->decimal('coupon_fee', 10, 2)->comment('优惠券支付金额');
            $table->string('payment_trade_no')->nullable();
            $table->string('payment_trade_status')->nullable();
            $table->string('payment_notify_id')->nullable();
            $table->string('payment_notify_time')->nullable();
            $table->string('payment_buyer_email')->nullable();
            $table->string('payment_total_fee')->nullable();
            $table->text('payment_json')->nullable();

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
        Schema::dropIfExists('orders');
    }
}
