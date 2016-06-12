<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->string('title')->default('')->comment('标题');
            $table->string('name',50)->default('')->comment('变量名');
            $table->text('content')->default('')->comment('变量值');
            $table->integer('order')->default(0)->comment('排序');
            $table->string('tips')->default('')->comment('解释');
            $table->string('type',50)->default('')->comment('类型');
            $table->string('value')->default('')->comment('类型值');
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
        Schema::drop('configs');
    }
}
