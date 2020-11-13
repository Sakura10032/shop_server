<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUserLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_logs', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->uuid('site_id')->comment('站点ID');
            $table->bigInteger('user_id')->comment('用户ID');
            $table->string('log')->comment('日志内容');
            $table->string('log_data')->comment('日志数据');
            $table->char('ip', 20)->comment('IP');
            $table->timestamps();
        });

        DB::statement(
            /** @lang text */
            "ALTER TABLE `shop_user_logs` comment '用户日志表'"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_logs');
    }
}