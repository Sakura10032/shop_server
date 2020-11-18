<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->integer('site_id')->comment('站点ID');
            $table->bigInteger('category_id')->comment('分类 ID');
            $table->string('name')->comment('名称');
            $table->tinyInteger('is_visible')->default(2)->comment('是否会员可见 1为显示 2为不显示');
            $table->string('third_party_url')->nullable()->comment('是否第三方链接');
            $table->string('cover_url')->nullable()->comment('图片');
            $table->string('file_url')->comment('文件地址');
            $table->integer('sort')->default(50)->comment('排序');
            $table->char('size', 15)->comment('大小');
            $table->char('extension', 15)->comment('文件格式');
            $table->char('mime', 15)->comment('Mime 类型');
            $table->string('hash')->comment('哈希值');
            $table->string('pwd')->nullable()->comment('下载密码');
            $table->integer('count')->default(0)->comment('下载次数');
            $table->tinyInteger('status')->default(1)->comment('状态 1为启用 2为禁用');
            $table->timestamps();
        });

        DB::statement(
            /** @lang text */
            "ALTER TABLE `shop_files` comment '下载表'"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}