<?php 
/**
 * 用于数据库的增删改查
 */
class LevelModel extends Model{
  private $id;
  private $level_name;
  private $level_info;
  private $level;
  private $limit;
  public function __set($key,$value){
    $this->$key= Tool::mysqlString($value);                          //mysqlString()是用来过滤mysql特殊字符串的,因为外部调用的是拦截器,直接在拦截器里面赋值
  }
  public function __get($key){
    return $this->$key;
  }

  //获取等级的总记录 用处                Page分页类
  public function getLevelTotal(){
    $_sql = "SELECT COUNT(*) as c FROM cms_level";
    return parent::total($_sql);
  }

  //查找所有等级  并非是分页  
  public function getLevel(){
    $_sql = "SELECT 
                  id,
                  level_name,
                  level_info
              FROM 
                    cms_level 
              ORDER BY
                    id ASC";
    return parent::all($_sql);
  }

  //查找所有等级 是给 lmit 用的 分页查询
  public function getLimitLevel(){
    $_sql = "SELECT 
                    id,
                    level_name,
                    level_info
              FROM 
                    cms_level 
              ORDER BY
                    id DESC
                    $this->limit";
    return parent::all($_sql);
  }

  //查询一条
  public function getOneLevel(){
    $_sql = "SELECT 
                  id,
                  level_name,
                  level_info
            FROM 
                  cms_level
            WHERE  
                  id='$this->id' 
            OR
                  level_name='$this->level_name'
            LIMIT 
                  1";
    return parent::one($_sql);
  }

    //查询一条
  public function getOneLevel1(){ /////////////////用来判断修改等级名称是否已经存在
    $_sql = "SELECT
                  level_name
            FROM 
                  cms_level
            WHERE
                  level_name='$this->level_name'
            LIMIT 
                  1";
    return parent::one($_sql);
  }

  //添加
  public function addLevel(){
    $_sql = "INSERT INTO cms_level(
                                        level_name,
                                        level_info
                                      ) 
                                VALUES (
                                        '$this->level_name',
                                        '$this->level_info'
                                        )";
    return parent::aud($_sql);
  }

  //更新
  public function updateLevel(){
    $_sql= "UPDATE
                  cms_level
            SET
                  `level_name`='$this->level_name',
                  `level_info`='$this->level_info'
            WHERE
                  id = $this->id";
    return parent::aud($_sql);
  }

  //删除管理员
  public function deleteLevel(){
    $_sql = "DELETE FROM 
                        cms_level 
             WHERE 
                        id='$this->id' 
             LIMIT 
                        1";
    return parent::aud($_sql);
  }

}
 ?>