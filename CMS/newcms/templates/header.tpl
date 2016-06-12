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
          {if $FrontNav}
          {foreach name='FrontNav' key=key item=value}
            <li><a href="{@value['nav_url']}" target="view_window">{@value['nav_name']}</a>
              {if @value['child'][0]}
                <div class="warp">
                  <div class="top">
                  </div>
                  <div class="bottom">
                  </div>
                </div>
              {/if}
              <ul class="subnav">
              {foreach array=value.'child' key=k item=v}
                      <li><a href="{@v['nav_url']}" target="view_window">{@v['nav_name']}</a></li>
              {/foreach}
              </ul>
            </li>
          {/foreach}
          {/if}
        </ul>
      </div>
      <div id="box">
      <div id="wrap">
        <h2 id="h2">联系我们</h2>
        <div>
          <a href="{$origamiMainUrl1}">{$origamiMainName1}</a>
          <div>
            <a href="{$origamiMainUrl2}">{$origamiMainName2}</a>
            <div>
              <a href="{$origamiMainUrl3}">{$origamiMainName3}</a>
              <div>
                <a href="{$origamiMainUrl4}">{$origamiMainName4}</a>
                <div>
                  <a href="{$origamiMainUrl5}">{$origamiMainName5}</a>
                  <div>
                    <a href="{$origamiMainUrl6}">{$origamiMainName6}</a>
                    <div>
                      <a href="{$origamiMainUrl7}">{$origamiMainName7}</a>
                      <div>
                        <a href="{$origamiMainUrl8}">{$origamiMainName8}</a>
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
  
