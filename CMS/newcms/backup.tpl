<div id="tableBox">
    <form method="post" action="nav.php?action=sort">
      <table border="0" cellspacing="0">
        <tr><th style="width: 5%;">编号 / 序列</th><th style="width: 5%;">导 航 名 称</th><th style="width: 25%;">描 述</th><th style="width: 5% ;">子 类</th><th style="width: 5%;">操 作</th><th style="width: 5%;"> 排 序(在 0~<i style="font-size: 28px;font-weight:bold;">{$pagesize} </i>之间)</th></tr>
        {if $ALLNav}
        {foreach $ALLNav(key,value)}
        <tr>
          <td><script type="text/javascript">document.write({@key+1}+{$num})</script></td>
          <td>{@value->nav_name}</td>
          <td>{@value->nav_info}</td>
          <td> [<a href="nav.php?action=showchild&id={@value->id}">查看</a>] | [<a href="nav.php?action=addchild&id={@value->id}">添加子类</a>] </td>
          <td><a href="nav.php?action=update&id={@value->id}"> [ 修改 ] </a>|<a href="nav.php?action=delete&id={@value->id}" onclick="return confirm('确认删除?') ? true : false"> [ 删除 ] </a></td>
          <td><input type="text" name="s[{@value->id}]" value="{@value->sort}" class="text nav_text_sort"></td>
        </tr>
        {/foreach}
        {else}
          <tr><td colspan="6"><i class="icon-quill"></i> 没 有 任 何 数  据 ! </td></tr>
        {/if}
        <tr><td colspan="5"></td><td><input type="submit" value="提 交 排 序" name="send" class="nav_submit"></td></tr>
      </table>
    </form>
  </div>
   <div id="page">
    {$page}
   </div>
  

                                                                    <!--   <li><a href="#"> 首 页 </a></li>
                                                                    <li>
                                                                      <a href="#">钢筋水泥</a><div class="warp"><div class="top"></div><div class="bottom"></div></div>
                                                                      <ul class="subnav">
                                                                        <li><a href="#">一号钢筋</a></li>
                                                                        <li><a href="#">二号钢筋</a></li>
                                                                        <li><a href="#">国标钢筋</a></li>
                                                                        <li><a href="#">{$title}</a></li>
                                                                        <li><a href="#">生锈钢筋</a></li>
                                                                        <li><a href="#">二手钢筋</a></li>
                                                                      </ul>
                                                                    </li>
                                                                    <li><a href="#">热线电话</a></li>
                                                                    <li>
                                                                      <a href="#">木材市场</a><div class="warp"><div class="top"></div><div class="bottom"></div></div>
                                                                       <ul class="subnav">
                                                                        <li><a href="#">檀香木</a></li>
                                                                        <li><a href="#">梧桐木</a></li>
                                                                        <li><a href="#">黑胡桃木</a></li>
                                                                        <li><a href="#">中国土木</a></li>
                                                                        <li><a href="#">桦木</a></li>
                                                                        <li><a href="#">降龙木</a></li>
                                                                      </ul>
                                                                    </li>
                                                                    <li><a href="#">跳蚤市场</a></li>
                                                                    <li><a href="#">建材市场</a></li> -->