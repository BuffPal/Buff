<?php 
/**
 * 用户表关联模型
 */
namespace Home\Model;
use Think\Model\RelationModel;
Class UserRelationModel extends RelationModel{
  //定义主表名  因为 这个模型名为 UserRelation  它会自动去找 UserRelation表
  protected $tableName = 'user';

  //定义关联属性 ,手册上很清楚
  protected $_link = array(
    //关联的表名
      'userinfo' => array(
      'mapping_type' => self::HAS_ONE,               //关联类型为 一对一
      'foreign_key'  => 'uid',                           //这里默认的 是userinfo_id 采取当前关联对象的_id
      )
    );

  //自动插入方法 用于外部调用
  public function insert($data=NULL){
    $data = is_null($data) ? $_POST : $data;
    return $this->relation(true)->data($data)->add();
  }



}


 ?>