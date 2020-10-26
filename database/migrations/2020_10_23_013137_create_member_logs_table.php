<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMemberLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_logs', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->bigInteger('member_id')->comment('会员ID');
            $table->string('log')->comment('日志内容');
            $table->string('log_data')->comment('日志数据');
            $table->char('log_data', 20)->comment('IP');
            $table->timestamps();
        });

        DB::statement(/** @lang text */ "ALTER TABLE `shop_member_logs` comment '会员日志表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_logs');
    }
}
