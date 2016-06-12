<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default('')->comment('文章标题');
            $table->text('content')->default('')->comment('文章内容');
            $table->integer('time')->default(0)->comment('发布时间');
            $table->string('editor')->default('')->comment('编辑人员');
            $table->integer('count')->default(0)->comment('查看次数');
            $table->string('tag',100)->default('')->comment('TAG标签');
            $table->string('description')->default('')->comment('关键字描述');
            $table->string('info')->default('')->comment('文章简介');
            $table->string('thumb')->default('')->comment('缩略图地址');
            $table->integer('cid')->default(0)->comment('分类ID');
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
        Schema::drop('articles');
    }
}
