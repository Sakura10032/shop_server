<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->string('name', 100)->nullable()->comment('主题名称');
            $table->string('config')->comment('主题配置文件');
            $table->tinyInteger('status')->default(1)->comment('状态 1为启用 2为禁用');
            $table->timestamps();
        });

        DB::statement(/** @lang text */ "ALTER TABLE `shop_themes` comment '主题表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('themes');
    }
}
