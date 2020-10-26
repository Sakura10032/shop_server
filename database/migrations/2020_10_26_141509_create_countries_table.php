<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->string('name', 100)->nullable()->comment('姓名');
            $table->string('slug', 100)->nullable()->comment('缩略名');
            $table->string('continent', 10)->nullable()->comment('洲');
            $table->tinyInteger('status')->default(1)->comment('状态 1为启用 2为禁用');
            $table->tinyInteger('is_custom')->default(1)->comment('是否自定义 1为是 2为否');
            $table->timestamps();
        });

        DB::statement(/** @lang text */ "ALTER TABLE `shop_members` comment '国家地区表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
