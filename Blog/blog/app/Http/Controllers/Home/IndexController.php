<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Home;
use App\Model\articles;
use App\Model\categorys;
use Illuminate\Http\Request;

use App\Http\Requests;

class IndexController extends CommonController
{
    //首页视图
    public function index()
    {
        //获取图文列表 5 篇带分页
        $data = articles::jionCategorys5();

        return view('Home/index',array('data'=>$data));
    }

    //首页列表
    public function lists($id)
    {
        //获取当前 id 分类信息 递归父级
        $categoryAll = categorys::select('id','pid','name')->get();
        $category = getParents($categoryAll,$id);

        //获取当前 id 的一条信息
        $cateInfo = categorys::where('id','=',$id)->select('info')->get()[0]->info;

        //用IN方法查询当前分类下的所有分类 这里在模型里面完成
        $arrIn = categorys::getChildByIn($id);

        //获取数据 5 个分页 按time字段排序 依然模型里面完成
        $data = articles::getChildDataByInForHome($arrIn);

        //获取子类导航 (前提你是父类)
        $child = categorys::where('pid','=',$id)->orderBy('order','asc')->select('name','id')->get();

        //获取当前栏目下的最新文章  8篇
        $newCate = articles::whereIn('cid',$arrIn)->orderBy('time','desc')->take(8)->select('title','id','info')->get();

        //获取当前分类下面的 点击排行  5篇
        $clickData = articles::whereIn('cid',$arrIn)->orderBy('count','desc')->take(5)->select('title','id','info')->get();

        return view('Home/lists',array('data'=>$data,'child'=>$child,'newCate'=>$newCate,'clickData'=>$clickData,'category'=>$category,'cateInfo'=>$cateInfo));
    }


    //文章页面
    public function article($id)
    {
        //获取当前 id 文章的主要信息
        $data = articles::find($id);
        //tag标签循环
        $tagArr = explode(',',$data->tag);
        $data->tag = '';
        foreach($tagArr as $v){
            $data->tag .= '<a href="#">'.$v.'</a>　';
        }

        //注入 文章导航
        $cid = articles::find($id)->cid;
        //获取当前 id 分类信息 递归父级
        $categoryAll = categorys::select('id','pid','name')->get();
        $category = getParents($categoryAll,$cid);


        return view('Home/article',array('data'=>$data,'category'=>$category));
    }


}
