<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->uuid('site_id')->comment('站点ID');
            $table->string('name')->comment('名称');
            $table->bigInteger('category_id')->comment('分类 ID');
            $table->string('number')->comment('编号 ');
            $table->integer('sort')->default(50)->comment('排序');
            $table->char('about', 150)->nullable()->comment('简介');
            $table->tinyInteger('is_show')->default(2)->comment('显示在首页 1为显示 2为不显示');
            $table->tinyInteger('is_hot')->default(2)->comment('热门 1为热门 2为不热门');
            $table->tinyInteger('is_new')->default(2)->comment('新品 1为是新品 2为不是新品');
            $table->tinyInteger('is_recommend')->default(2)->comment('推荐 1为推荐 2为不推荐');
            $table->tinyInteger('is_visible')->default(2)->comment('会员可见 1为可见 2为不可见');
            $table->longText('file_url')->nullable()->comment('多附件');
            $table->longText('goods_url')->nullable()->comment('外部购买链接');
            $table->timestamps();
        });

        DB::statement(
            /** @lang text */
            "ALTER TABLE `shop_products` comment '产品表'"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}