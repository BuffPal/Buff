<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account',20)->unique()->default('')->comment('管理员账号');
            $table->string('password',32)->default('')->comment('密码');
            $table->string('username',10)->default('')->comment('昵称');
            $table->integer('registertime')->default(0)->comment('注册时间');
            $table->integer('logintime')->default(0)->comment('上次登录时间');
            $table->string('loginip',60)->default('')->comment('上次登录Ip');
            $table->integer('count')->default(1)->comment('登录统计');
            $table->mediumInteger('locks')->comment('是否被锁定(0:没有 1:锁定)');
            $table->string('level')->default('')->comment('管理员登记标识符');
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
        Schema::drop('manages');
    }
}
