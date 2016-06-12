<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//首页视图
Route::get('/', 'Home\IndexController@index');
//首页列表  全部
Route::get('/lists/{id}', 'Home\IndexController@lists');
//文章页面
Route::get('/article/{id}','Home\IndexController@article');

//图片处理路由
Route::post('upload', 'CommonController@postUpload');
Route::post('crop', 'CommonController@postCrop');


/**
 * 后台路由
 */
//验证码地址
Route::get('/code','KitController@captcha');

//图片处理路由
Route::post('/common/uploadpic','CommonController@uploadPic');

//后台ADMIN跳转
Route::get('/admin','Admin\LoginController@index');

Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['adminlogin']] , function(){
    //后台首页
    Route::get('index','IndexController@index');
    


    //后台AJAX切换 category排序
    Route::post('category/changeOrder','CategorysController@changeOrder');
    //分类管理  资源路由
    Route::resource('category','CategorysController');

    //文章管理 当中的 from 表单查询关键字查询
    Route::post('/article/search','ArticlesController@search');
    //文章管理  资源路由
    Route::resource('article','ArticlesController');

    //后台AJAX切换 link排序
    Route::post('link/changeOrder','LinksController@changeOrder');
    //分类管理  资源路由
    Route::resource('link','LinksController');

    //后台AJAX切换 nav排序
    Route::post('nav/changeOrder','NavsController@changeOrder');
    //自定义导航管理  资源路由
    Route::resource('nav','NavsController');

    //后台更新 content 方法
    Route::post('config/changeContent','ConfigsController@changeContent');
    //后台config写入文件
    Route::get('config/putfile','ConfigsController@putFile');
    //后台AJAX切换 config排序
    Route::post('config/changeOrder','ConfigsController@changeOrder');
    //配置管理  资源路由
    Route::resource('config','ConfigsController');

    //后台首页信息
    Route::get('info','IndexController@info');

    //后台退出
    Route::get('logout','LoginController@logout');
    
});
//后台登录
Route::get('admin/login','Admin\LoginController@index');
Route::post('admin/login','Admin\LoginController@store');

Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['adminlogin']] , function(){
    //修改管理员密码 显示页面
    Route::get('pass','IndexController@pass');
    //修改管理员密码 post提交页面
    Route::post('pass','IndexController@checkpass');
});