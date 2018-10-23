<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_categories', function (Blueprint $table) {
            $table->increments('id');
//            name	string	名称
            $table->string('name');
//type_accumulation	string	菜品编号
            $table->string('type_accumulation');
//shop_id	int	所属商家ID
            $table->integer('shop_id');
//description	string	描述
            $table->text('description');
//is_selected	string	是否是默认分类
            $table->tinyInteger('is_selected');
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
        Schema::dropIfExists('menu_categories');
    }
}
