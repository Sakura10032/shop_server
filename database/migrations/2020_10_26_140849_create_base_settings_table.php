<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBaseSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('base_settings', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->uuid('site_id')->comment('站点ID');
            $table->string('logo')->comment('logo地址');
            $table->string('ico')->comment('ico图标地址');
            $table->tinyInteger('message_status')->default(2)->comment('开启底部留言 1开启 2关闭');
            $table->string('search_message')->nullable()->comment('产品搜索提示语');
            $table->string('copyright')->nullable()->comment('版权信息');
            $table->string('bolg_copyright')->nullable()->comment('博客版权信息');
            $table->longText('language')->nullable()->comment('语言');
            $table->char('company')->nullable()->comment('公司名称');
            $table->string('email')->nullable()->comment('邮箱');
            $table->string('mobile', 20)->nullable()->comment('电话');
            $table->string('fax', 20)->nullable()->comment('传真');
            $table->string('address')->nullable()->comment('地址');
            $table->string('home_url')->nullable()->comment('首页链接 一般为单页链接');
            $table->tinyInteger('price_status')->default(2)->comment('产品价格 1为启用 2为禁用;可控制用户是否开启价格属性以及显示');
            $table->tinyInteger('share_status')->default(2)->comment('社交分享 1为启用 2为禁用;产品详细页带有分享组件,可分享到全球知名的社交平台如Facebook、Twitter、Google、Pinterest等.');
            $table->tinyInteger('price_visible')->default(2)->comment('价格可见 1为启用 2为禁用;控制价格是否仅会员可见，如果开启，则登录之后才能看到');
            $table->tinyInteger('rank_model')->default(1)->comment('价格可见 1为默认 2为自定义;默认关闭，后台产品管理列表以添加时间进行排序显示；勾选后，则会以产品排序设置来进行排序显示.');
            $table->tinyInteger('member_status')->default(1)->comment('开启会员功能 1为启用 2为禁用');
            $table->tinyInteger('member_check')->default(2)->comment('会员审核 1为启用 2为禁用');
            $table->tinyInteger('email_verify')->default(2)->comment('注册邮箱验证 1为启用 2为禁用');
            $table->string('reg_message')->nullable()->comment('注册提示语');
            $table->longText('reg_param')->nullable()->comment('注册参数');
            $table->integer('watermark_alpha')->default(80)->comment('水印透明度');
            $table->string('watermark_url')->nullable()->comment('水印');
            $table->tinyInteger('watermark_site')->default(1)->comment('水印位置 1为右上角 2为右下角 3为左上角 4为左下角 5为居中');
            $table->tinyInteger('watermark_status')->default(2)->comment('开启水印 1为启用 2为禁用');
            $table->longText('social')->nullable()->comment('社交媒体');
            $table->timestamps();
        });

        DB::statement(
            /** @lang text */
            "ALTER TABLE `shop_base_settings` comment '基本设置表'"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('base_settings');
    }
}