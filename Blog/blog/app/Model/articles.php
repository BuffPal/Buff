<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class articles extends Model
{
    protected $fillable = array('title','content','time','editor','tag','description','info','thumb','cid');


    //时间戳处理
    public function setTimeAttribute($data){
        $this->attributes['time'] = time();
    }

    //thumb地址处理
    public function setThumbAttribute($data)
    {
        $num = mb_strpos($data,env('CROPPIC_PATH'));
        $data = mb_substr($data,$num);
        $this->attributes['thumb'] = $data;
    }

    /**
     * 关键字查找
     */
    public static function getDataByKeyword($keyword)
    {
        $data = \DB::table('articles')
                        ->where('title','like','%'.$keyword.'%')
                        ->leftJoin('categorys','categorys.id','=','articles.cid')
                        ->select('articles.id as aid','articles.time','articles.editor','articles.title','categorys.name','categorys.id as cid','articles.count')
                        ->orderBy('time','DESC')
                        ->paginate(env('ADMIN_PAGE_SIZE'));
        return $data;
    }

    /**
     * 获取in条件数据 (用于点击分类查询下面子类的所有数据)
     */
    public static function getChildDataByIn($id)
    {
        //获取 in 数组
        $arIn = categorys::getChildByIn($id);

        $data = \DB::table('articles')
                        ->whereIn('cid',$arIn)
                        ->leftJoin('categorys','categorys.id','=','articles.cid')
                        ->select('articles.id as aid','articles.time','articles.editor','articles.title','categorys.name','categorys.id as cid','articles.count')
                        ->orderBy('time','DESC')
                        ->paginate(env('ADMIN_PAGE_SIZE'));
        return $data;
    }


    /**
     * 获取in条件数据 (用于点击分类查询下面子类的所有数据)用于前台
     */
    public static function getChildDataByInForHome($array)
    {
        $data = \DB::table('articles')
            ->whereIn('cid',$array)
            ->leftJoin('categorys','categorys.id','=','articles.cid')
            ->select('articles.id as aid','articles.time','articles.editor','articles.title','categorys.name','categorys.id as cid','articles.count','articles.thumb','articles.info')
            ->orderBy('time','DESC')
            ->paginate(5);
        return $data;
    }

    /**
     * 获取分类列表 HTML
     */
    public static function getCate()
    {
        $data = unlimitedForLevel(categorys::all()->toArray(),'┣━');
        return $data;
    }

    /**
     * 获取分类 压组
     */
    public static function getCateHtml()
    {
        $data = unlimitedForLayer(categorys::all()->toArray());
        return $data;
    }

    /**
     * 关联分类表  获取后台数据
     */
    public static function jionCategorys5()
    {
        $data = \DB::table('articles')
            ->leftjoin('categorys','categorys.id','=','articles.cid')
            ->select('articles.id as aid','articles.time','articles.editor','articles.title','categorys.name','categorys.id as cid','articles.count','articles.thumb','articles.info')
            ->orderBy('count','DESC')
            ->paginate(5);
        return $data;
    }



    /**
     * 关联分类表  获取后台数据
     */
    public static function jionCategorys()
    {
        $data = \DB::table('articles')
                    ->leftjoin('categorys','categorys.id','=','articles.cid')
                    ->select('articles.id as aid','articles.time','articles.editor','articles.title','categorys.name','categorys.id as cid','articles.count')
                    ->orderBy('time','DESC')
                    ->paginate(env('ADMIN_PAGE_SIZE'));
        return $data;
    }



}
