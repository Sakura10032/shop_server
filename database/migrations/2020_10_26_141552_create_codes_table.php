<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codes', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->bigInteger('site_id')->comment('站点ID');
            $table->string('title', 100)->comment('姓名');
            $table->string('about')->nullable()->comment('简介');
            $table->longText('code')->nullable()->comment('代码内容');
            $table->tinyInteger('type')->default(1)->comment('1为PC 2为手机 3为PC和手机');
            $table->tinyInteger('status')->default(1)->comment('状态 1为启用 2为禁用');
            $table->tinyInteger('adr')->default(1)->comment('位置 1为meta 2为body');
            $table->timestamps();
        });

        DB::statement(
            /** @lang text */
            "ALTER TABLE `shop_codes` comment '第三方代码表'"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('codes');
    }
}