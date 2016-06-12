<?php 
/**
 * 用于数据库的增删改查
 */
class NavModel extends Model{
  private $id;
  private $nav_name;
  private $nav_url;
  private $pid;
  private $sort;
  private $limit;
  private $origami_name;
  private $origami_pid;
  private $origami_url;

  public function __set($key,$value){
    $this->$key= Tool::mysqlString($value);                          //mysqlString()是用来过滤mysql特殊字符串的,因为外部调用的是拦截器,直接在拦截器里面赋值
  }
  public function __get($key){
    return $this->$key;
  }

  //用来检查 主导个数是否操作6个了  子导航也是6个
  public function getNavTotal(){
    $_sql = "SELECT COUNT(*) FROM cms_nav WHERE pid='$this->pid'";
    return parent::total($_sql);
  }

  //查找所有主导航                               用于显示分页
  public function getLimitNav(){
    $_sql = "SELECT 
                    id,
                    nav_name,
                    nav_url,
                    pid,
                    sort
              FROM 
                    cms_nav 
              WHERE 
                    pid=0
              ORDER BY
                    sort ASC
                    $this->limit";
    return parent::all($_sql);
  }

  //查找所有主导航                               用于显示分页
  public function getLimitChildNav(){
    $_sql = "SELECT 
                    id,
                    nav_name,
                    nav_url,
                    sort
              FROM 
                    cms_nav 
              WHERE pid='$this->id'
              ORDER BY
                    sort ASC
                    $this->limit";
    return parent::all($_sql);
  }

  //添加
  public function addNav(){
    $_sql = "INSERT INTO cms_nav(
                                        nav_name,
                                        nav_url,
                                        pid,
                                        sort
                                      ) 
                                VALUES (
                                        '$this->nav_name',
                                        '$this->nav_url',
                                        0,
                                        ".parent::nextId('cms_nav')."
                                        )";
    return parent::aud($_sql);
  }

//查询一条  用来判断用户是否存在
  public function getOneNav(){
    $_sql = "SELECT 
                  id,
                  nav_name,
                  nav_url
            FROM 
                  cms_nav
            WHERE  
                  nav_name='$this->nav_name'
            OR    
                  id      ='$this->id'
            LIMIT 
                  1";
    return parent::one($_sql);
  }

  //查询一条  用来判断用户是否存在 判断用户名
  public function getOneNav1(){//这是主要是用来判断 修改的用户导航名称是否存在
    $_sql = "SELECT 
                  nav_name
            FROM 
                  cms_nav
            WHERE  
                  nav_name='$this->nav_name'
            LIMIT 
                  1";
    return parent::one($_sql);
  }

  //查询一条  用来判断用户是否存在 判断用户名 用来解决 修改的时候不只更改 URL 的时候 提示用户名已存在
  public function getOneNav2(){//这是主要是用来判断 
    $_sql = "SELECT 
                  nav_name
            FROM 
                  cms_nav
            WHERE  
                  id='$this->id'
            LIMIT 
                  1";
    return parent::one($_sql);
  }

 //删除一条导航
  public function deleteNav(){
    $_sql = "DELETE FROM 
                        cms_nav 
             WHERE 
                        id='$this->id' 
             LIMIT 
                        1";
    return parent::aud($_sql);
  }

  //更新
  public function updateNav(){
    $_sql= "UPDATE
                  cms_nav
            SET
                  `nav_name`='$this->nav_name',
                  `nav_url`='$this->nav_url'
            WHERE
                  id = $this->id";
    return parent::aud($_sql);
  }

  //添加子导航
  public function addNavchild(){
    $_sql = "INSERT INTO cms_nav(
                                        nav_name,
                                        nav_url,
                                        pid,
                                        sort
                                      ) 
                                VALUES (
                                        '$this->nav_name',
                                        '$this->nav_url',
                                        '$this->pid',
                                        ".parent::nextId('cms_nav')."
                                        )";
    return parent::aud($_sql);
  }

  //前台显示指定的主导航
  public function getFrontNav(){
    $_sql = "SELECT 
                    id,
                    nav_name
              FROM 
                    cms_nav 
              WHERE 
                    pid=0
              ORDER BY
                    sort ASC
              LIMIT 0,".NAV_SIZE;
    return parent::all($_sql);
  }

  //用于递归 返回的是个数组  查找全部主导航
  public function getAllToArray(){
    $sql = "SELECT
                  nav_name,
                  nav_url,
                  pid,
                  id
            FROM
                  cms_nav
            ";
    return parent::arrayAll($sql);
  }

  //Origami show
  public function getOrigamiChildALL(){
    $sql = "SELECT
                  id,
                  origami_name,
                  origami_pid,
                  origami_url
            FROM
                  cms_nav_origami
            WHERE
                  origami_pid='$this->origami_pid'
            limit 8";
    return parent::all($sql);
  }

    //Origami show   //用来注入前台数据 !! 表示对象数组不会注入
  public function getOrigamiChildALLArray(){
    $sql = "SELECT
                  id,
                  origami_name,
                  origami_pid,
                  origami_url
            FROM
                  cms_nav_origami
            WHERE
                  origami_pid='$this->origami_pid'
            limit 8";
    return parent::arrayAll($sql);
  }

  //addNavOrigamichild()   添加子折纸
  public function addNavOrigamichild(){
     $_sql = "INSERT INTO cms_nav_origami(
                                        origami_name,
                                        origami_url,
                                        origami_pid
                                      ) 
                                VALUES (
                                        '$this->origami_name',
                                        '$this->origami_url',
                                        '$this->origami_pid'
                                        )";
    return parent::aud($_sql);
  }

//查询一条数据  查询的是折纸导航名     联系我们
  public function getOneNavOrigami(){
    $_sql = "SELECT 
                  id,
                  origami_name
            FROM 
                  cms_nav_origami
            WHERE     
                  id=1
            LIMIT 
                  1";
    return parent::one($_sql);
  }

  //查询一条数据  查询的是折纸导航名     这里差不多和上面一样,但这里做为Update 获取数据来获取指定ID
  public function getOneNavOrigami1(){
    $_sql = "SELECT 
                  id,
                  origami_name,
                  origami_url
            FROM 
                  cms_nav_origami
            WHERE     
                  id='$this->id'
            LIMIT 
                  1";
    return parent::one($_sql);
  }

  //查询一条  用来判断子折纸是否存在
  public function getOneNavOrigamiName(){
    $_sql = "SELECT 
                  origami_name
            FROM 
                  cms_nav_origami
            WHERE  
                  origami_name='$this->origami_name'
            LIMIT 
                  1";
    return parent::one($_sql);
  }

  //用来统计 cms_nav_origami 里面共有多少条数据  限制是8条
  public function getNavOrigamiTotal(){
    $_sql = "SELECT COUNT(*) FROM cms_nav_origami WHERE origami_pid='$this->origami_pid'";
    return parent::total($_sql);
  }

  //查询一条  用来判断折纸名称是否存在 判断折纸名称名 用来解决 修改的时候不只更改 URL 的时候 提示折纸名称名已存在
  public function getOneNavOrigamiName1(){//这是主要是用来判断 
    $_sql = "SELECT 
                  origami_name
            FROM 
                  cms_nav_origami
            WHERE  
                  id='$this->id'
            LIMIT 
                  1";
    return parent::one($_sql);
  }

  //更新
  public function updateOrigamiNav(){
    $_sql= "UPDATE
                  cms_nav_origami
            SET
                  `origami_name`='$this->origami_name',
                  `origami_url`='$this->origami_url'
            WHERE
                  id = $this->id";
    return parent::aud($_sql);
  }

   //删除一条导航
  public function deleteOrigamiNav(){
    $_sql = "DELETE FROM 
                        cms_nav_origami
             WHERE 
                        id='$this->id' 
             LIMIT 
                        1";
    return parent::aud($_sql);
  }

  
}
 ?>