<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->uuid('site_id')->comment('站点ID');
            $table->string('name')->comment('名称');
            $table->bigInteger('category_id')->comment('分类 ID');
            $table->string('link')->nullable()->comment('外部链接');
            $table->char('number', 20)->comment('编号');
            $table->string('pic_url')->nullable()->comment('封面图');
            $table->char('about', 150)->nullable()->comment('简介');
            $table->tinyInteger('is_show')->default(2)->comment('显示在首页 1为显示 2为不显示');
            $table->tinyInteger('is_hot')->default(2)->comment('热门 1为热门 2为不热门');
            $table->integer('sort')->default(50)->comment('排序');
            $table->timestamps();
        });

        DB::statement(
            /** @lang text */
            "ALTER TABLE `shop_cases` comment '案列表'"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cases');
    }
}