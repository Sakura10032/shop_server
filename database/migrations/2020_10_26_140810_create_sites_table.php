<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->string('name', 100)->comment('站点名称');
            $table->string('mobile', 20)->comment('站点注册手机号');
            $table->tinyInteger('status')->default(1)->comment('状态 1为启用 2为禁用');
            $table->bigInteger('base_id')->comment('基本设置 ID');
            $table->bigInteger('theme_id')->comment('主题 ID');
            $table->timestamp('try_time')->comment('到期时间');
            $table->timestamp('reg_time')->comment('注册时间');
            $table->char('reg_ip', 20)->comment('注册IP');
            $table->timestamps();
        });

        DB::statement(/** @lang text */ "ALTER TABLE `shop_sites` comment '站点表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites');
    }
}
