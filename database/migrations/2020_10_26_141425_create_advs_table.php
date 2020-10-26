<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAdvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advs', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->bigInteger('site_id')->comment('站点ID');
            $table->bigInteger('type_id')->comment('页面类型');
            $table->string('title')->comment('标题');
            $table->string('about')->comment('简介');
            $table->string('url')->comment('图片地址');
            $table->timestamps();
        });

        DB::statement(/** @lang text */ "ALTER TABLE `shop_advs` comment '广告表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advs');
    }
}
