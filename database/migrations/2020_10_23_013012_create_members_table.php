<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->string('name', 100)->nullable()->comment('姓名');
            $table->string('email', 64)->comment('邮箱');
            $table->tinyInteger('gender')->nullable()->comment('性别 1为男 2为女 3为未知');
            $table->integer('age')->nullable()->comment('年龄');
            $table->string('mobile', 20)->nullable()->comment('电话');
            $table->string('fax', 20)->nullable()->comment('传真');
            $table->timestamp('birthday')->nullable()->comment('生日');
            $table->char('company')->nullable()->comment('公司');
            $table->string('contact_way')->nullable()->comment('其他联系方式');
            $table->string('pwd')->comment('密码');
            $table->tinyInteger('status')->default(1)->comment('会员状态 1为启用 2为禁用');
            $table->integer('site_id')->comment('站点ID');
            $table->timestamp('reg_time')->useCurrent()->comment('注册时间');
            $table->timestamp('login_time')->nullable()->comment('最后登录时间');
            $table->char('reg_ip', 20)->nullable()->comment('注册IP');
            $table->char('login_ip', 20)->nullable()->comment('最后登录 IP');
            $table->timestamps();
        });

        DB::statement(
        /** @lang text */
        "ALTER TABLE `shop_members` comment '会员表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}