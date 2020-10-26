<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->bigInteger('site_id')->comment('站点ID');
            $table->string('account')->comment('账号');
            $table->string('pwd')->comment('密码');
            $table->tinyInteger('role')->default(1)->comment('角色 1为普通管理员 2为超级管理员');
            $table->tinyInteger('status')->default(1)->comment('状态 1为启用 2为禁用');
            $table->string('permission')->nullable()->comment('权限');

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
        Schema::dropIfExists('users');
    }
}
