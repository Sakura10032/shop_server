<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateImageHashTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_hash', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->uuid('site_id')->comment('站点ID');
            $table->bigInteger('category_id')->comment('分类ID');
            $table->string('url')->comment('图片地址');
            $table->integer('sort')->default(50)->comment('排序');
            $table->char('size', 15)->comment('大小');
            $table->char('extension', 15)->comment('文件格式');
            $table->char('mime', 15)->comment('Mime 类型');
            $table->string('hash')->comment('哈希值');
            $table->timestamps();
        });

        DB::statement(
            /** @lang text */
            "ALTER TABLE `shop_image_hash` comment '图片表'"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_hash');
    }
}