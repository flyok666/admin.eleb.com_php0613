<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
//            goods_name	string	名称
            $table->string('goods_name');
//rating	float	评分
            $table->float('rating',3,1);
//shop_id	int	所属商家ID
            $table->integer('shop_id');
//category_id	int	所属分类ID
            $table->integer('category_id');
//goods_price	float	价格
            $table->float('goods_price');
//description	string	描述
            $table->text('description');
//month_sales	int	月销量
            $table->integer('month_sales');
//rating_count	int	评分数量
            $table->integer('rating_count');
//tips	string	提示信息
            $table->string('tips');
//satisfy_count	int	满意度数量
            $table->integer('satisfy_count');
//satisfy_rate	float	满意度评分
            $table->float('satisfy_rate');
//goods_img	string	商品图片
            $table->string('goods_img');
//status	int	状态：1上架，0下架
            $table->tinyInteger('status');
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
        Schema::dropIfExists('menus');
    }
}
