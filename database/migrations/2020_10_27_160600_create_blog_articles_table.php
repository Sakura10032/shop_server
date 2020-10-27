<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_articles', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->bigInteger('site_id')->comment('站点ID');
            $table->string('title')->comment('标题');
            $table->string('cover_url')->nullable()->comment('封面图');
            $table->char('author', 10)->nullable()->comment('作者');
            $table->char('about', 150)->nullable()->comment('简介');
            $table->string('tag')->nullable()->comment('标签');
            $table->tinyInteger('is_hot')->default(2)->comment('热门 1为热门 2为不热门');
            $table->integer('sort')->default(50)->comment('排序');
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
        Schema::dropIfExists('blog_articles');
    }
}
