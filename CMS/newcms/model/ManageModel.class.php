<?php 
/**
 * 用于数据库的增删改查
 */
class ManageModel extends Model{
  private $admin_user;
  private $admin_pass;
  private $level;
  private $id;
  private $limit;
  private $last_ip;
  public function __set($key,$value){
   $this->$key= Tool::mysqlString($value);  
  }
  public function __get($key){
    return $this->$key;
  }

  //查找登录 验证 用户名和密码
  public function getLoginManage(){
    $sql = "SELECT 
                   m.id,
                   m.admin_user,
                   l.level_name
            FROM
                   cms_manage m,
                   cms_level l
            WHERE  
                   m.admin_user = '$this->admin_user'
            AND
                   m.admin_pass = '$this->admin_pass'
            AND    
                   m.level = l.id
            LIMIT 1
                   ";
    return parent::one($sql);
  }

  //获取全部管理员条数 用处                Page分页类
  public function getManageTotal(){
    $_sql = "SELECT COUNT(*) as c FROM cms_manage";
    return parent::total($_sql);
  }
  //查找所有管理员
  public function getManage(){
    $_sql = "SELECT 
                    m.id,
                    m.admin_user,
                    m.login_count,
                    m.last_ip,
                    m.last_time,
                    l.level_name
              FROM 
                    cms_manage m,
                    cms_level l
              WHERE
                    l.id = m.level
              ORDER BY
                    m.id DESC
                    $this->limit
              ";
    return parent::all($_sql);
  }

  //查询一条管理员
  public function getOneManage(){
    $_sql = "SELECT 
                    id,
                    admin_user,
                    admin_pass,
                    level 
                FROM 
                    cms_manage 
              WHERE 
                    id='$this->id' 
                  OR
                    admin_user='$this->admin_user'
                  OR
                    level='$this->level'
                LIMIT 
                    1";
      return parent::one($_sql);
  }

  //添加管理员
  public function addManage(){
    $_sql = "INSERT INTO cms_manage(
                                      admin_user,
                                      admin_pass,
                                      level,
                                      reg_time
                                      ) 
                                VALUES (
                                '$this->admin_user',
                                '$this->admin_pass',
                                '$this->level',
                                NOW()
                                        )";
    return parent::aud($_sql);
  }
  //更新管理员
  public function updateManage(){
    $_sql= "UPDATE
                  cms_manage
            SET
                  admin_pass='$this->admin_pass',
                  level='$this->level'
            WHERE
                  id = $this->id";
    return parent::aud($_sql);
  }
  //删除管理员
  public function deleteManage(){
    $_sql = "DELETE FROM 
                        cms_manage 
             WHERE 
                        id='$this->id' 
             LIMIT 
                        1";
    return parent::aud($_sql);
  }

  //设置管理员登陆统计 次数 ip 时间
  public function setLoginCount(){
    $_sql = "UPDATE
                  cms_manage
              SET
                  login_count=login_count+1,
                  last_ip    ='$this->last_ip',
                  last_time  = NOW()
              WHERE
                  admin_user='$this->admin_user'
              LIMIT
                  1";
   return parent::aud($_sql);
  }

}
 ?>