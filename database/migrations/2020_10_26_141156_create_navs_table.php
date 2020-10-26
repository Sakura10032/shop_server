<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateNavsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navs', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->bigInteger('site_id')->comment('站点ID');
            $table->tinyInteger('adr')->default(1)->comment('导航位置 1为头部 2为底部 3顶部');
            $table->bigInteger('type_id')->comment('页面类型');
            $table->timestamps();
        });

        DB::statement(/** @lang text */ "ALTER TABLE `shop_navs` comment '导航表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('navs');
    }
}
