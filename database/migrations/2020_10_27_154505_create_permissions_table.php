<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->bigInteger('pid')->default(0)->comment('父ID');
            $table->enum('type', ['menu', 'file'])->default('file')->comment('权限类型 menu为菜单,file为权限节点');
            $table->char('title', 15)->comment('规则名称');
            $table->char('name', 20)->comment('权限规则');
            $table->char('route', 20)->nullable()->comment('路由规则');
            $table->char('icon', 20)->nullable()->comment('图标');
            $table->string('remark', 100)->comment('备注');
            $table->integer('weigh')->default(50)->comment('权重');
            $table->tinyInteger('status')->default(1)->comment('状态 1为启用 2为禁用');
            $table->timestamps();
        });


        DB::statement(
            /** @lang text */
            "ALTER TABLE `shop_permissions` comment '权限表'"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}