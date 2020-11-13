<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->uuid('site_id')->comment('站点ID');
            $table->char('title')->comment('标题');
            $table->char('about', 150)->nullable()->comment('简介');
            $table->longText('nav')->comment('导航 序列化多个导航数据');
            $table->string('adv_url')->nullable()->comment('广告图');
            $table->timestamps();
        });

        DB::statement(
            /** @lang text */
            "ALTER TABLE `shop_blog` comment '博客表'"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog');
    }
}