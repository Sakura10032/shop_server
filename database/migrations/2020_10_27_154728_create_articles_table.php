<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->integer('site_id')->comment('站点ID');
            $table->string('title')->comment('标题');
            $table->bigInteger('category_id')->comment('分类 ID');
            $table->char('author', 10)->nullable()->comment('作者');
            $table->char('about', 150)->nullable()->comment('简介');
            $table->string('cover_url')->nullable()->comment('封面图');
            $table->tinyInteger('is_show')->default(2)->comment('显示在首页 1为显示 2为不显示');
            $table->integer('sort')->default(50)->comment('排序');
            $table->timestamps();
        });

        DB::statement(
            /** @lang text */
            "ALTER TABLE `shop_articles` comment '文章表'"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}