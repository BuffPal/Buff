<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategorysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20)->unique()->default('')->comment('分类名称');
            $table->string('info',100)->default('')->comment('分类简介');
            $table->string('keyword',100)->default('')->comment('关键字');
            $table->string('description')->default('')->comment('关键字描述?');
            $table->integer('count')->default(0)->comment('查看次数');
            $table->tinyInteger('order')->default(0)->comment('排序');
            $table->integer('pid')->default(0)->comment('父级ID');
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
        Schema::drop('categorys');
    }
}
