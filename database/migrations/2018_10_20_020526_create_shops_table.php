<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*id	primary	主键
shop_category_id	int	店铺分类ID
shop_name	string	名称
shop_img	string	店铺图片
shop_rating	float	评分
brand	boolean	是否是品牌
on_time	boolean	是否准时送达
fengniao	boolean	是否蜂鸟配送
bao	boolean	是否保标记
piao	boolean	是否票标记
zhun	boolean	是否准标记
start_send	float	起送金额
send_cost	float	配送费
notice	string	店公告
discount	string	优惠信息
status	int	状态:1正常,0待审核,-1禁用*/
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shop_category_id');
            $table->string('shop_name');
            $table->string('shop_img');
            $table->float('shop_rating',3,1);
            $table->tinyInteger('brand');
            $table->tinyInteger('on_time');
            $table->tinyInteger('fengniao');
            $table->tinyInteger('bao');
            $table->tinyInteger('piao');
            $table->tinyInteger('zhun');
            $table->decimal('start_send');
            $table->decimal('send_cost');
            $table->text('notice');
            $table->text('discount');
            $table->smallInteger('status');
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
        Schema::dropIfExists('shops');
    }
}
