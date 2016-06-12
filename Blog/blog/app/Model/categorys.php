<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class categorys extends Model
{
    protected $fillable= array('name','info','keyword','description','order','pid');
    
    //获取父级分类
    public static function getParent()
    {
        $data = categorys::where('pid','=','0')->get();
        return $data;
    }
    
    //判断是否有子分类
    public static function verfiyChild($id)
    {
        $data = categorys::where('pid','=',$id)->get();
        if(count($data) > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $id 需要查询子级的 id
     * @return 返回一个数组 用于 in 条件查询
     */
    public static function getChildByIn($id)
    {
        $child_id = '';
        //获取该id 下面的子级 id 若没有返回它自己
        $all = categorys::select('id','pid')->get()->toArray();
        //获取子级id
        if($child = getChildsID($all,$id)){
            $child_id = $child;
        }else{
            $child_id = array($id);
        }
        return $child_id;
    }
    
    
}
