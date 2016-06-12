  <div id="top">
  <div id="header">
    <div class="top">
      <a class="number" href="#"><i class="icon-phone7"></i> 8888-8888888</a><span>/</span>
      <a class="email" href="#"><i class="icon-mail5"></i> index8888888@email.com</a>
      <div class="eight">
        <a href="#"><i class="icon-facebook"></i></a>
        <a href="#"><i class="icon-pinterest2"></i></a>
        <a href="#"><i class="icon-twitter"></i></a>
        <a href="#"><i class="icon-attachment2"></i></a>
        <a href="#"><i class="icon-hackernews"></i></a>
        <a href="#"><i class="icon-google-plus"></i></a>
        <a href="#"><i class="icon-telegram"></i></a>
        <a href="#"><i class="icon-earth"></i></a>
      </div>
    </div>
    <div class="logo">
      <a href="#">LOGO没引入图片</a>
      <div class="soso">
        <form action="#" method="post">
          <input type="text" name="soso"><input type="submit" value="搜索">
        </form>
      </div>
      <div class="register">
        <a href="#">登录</a>
        <a href="#">注册</a>
      </div>
    </div>
    <div class="nav " id="oNav">
      <div class="box">
        <ul>
          <?php if ($this->_vars['FrontNav']) {?>
          <?php foreach ($this->_vars['FrontNav'] as $key=>$value) { ?>
            <li><a href="<?php echo $value['nav_url']?>" target="view_window"><?php echo $value['nav_name']?></a>
              <?php if ($value['child'][0]) {?>
                <div class="warp">
                  <div class="top">
                  </div>
                  <div class="bottom">
                  </div>
                </div>
              <?php } ?>
              <ul class="subnav">
              <?php foreach ($value['child'] as $k=>$v) { ?>
                      <li><a href="<?php echo $v['nav_url']?>" target="view_window"><?php echo $v['nav_name']?></a></li>
              <?php } ?>
              </ul>
            </li>
          <?php } ?>
          <?php } ?>
        </ul>
      </div>
      <div id="box">
      <div id="wrap">
        <h2 id="h2">联系我们</h2>
        <div>
          <a href="<?php echo $this->_vars['origamiMainUrl1'];?>"><?php echo $this->_vars['origamiMainName1'];?></a>
          <div>
            <a href="<?php echo $this->_vars['origamiMainUrl2'];?>"><?php echo $this->_vars['origamiMainName2'];?></a>
            <div>
              <a href="<?php echo $this->_vars['origamiMainUrl3'];?>"><?php echo $this->_vars['origamiMainName3'];?></a>
              <div>
                <a href="<?php echo $this->_vars['origamiMainUrl4'];?>"><?php echo $this->_vars['origamiMainName4'];?></a>
                <div>
                  <a href="<?php echo $this->_vars['origamiMainUrl5'];?>"><?php echo $this->_vars['origamiMainName5'];?></a>
                  <div>
                    <a href="<?php echo $this->_vars['origamiMainUrl6'];?>"><?php echo $this->_vars['origamiMainName6'];?></a>
                    <div>
                      <a href="<?php echo $this->_vars['origamiMainUrl7'];?>"><?php echo $this->_vars['origamiMainName7'];?></a>
                      <div>
                        <a href="<?php echo $this->_vars['origamiMainUrl8'];?>"><?php echo $this->_vars['origamiMainName8'];?></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
  </div>
  
