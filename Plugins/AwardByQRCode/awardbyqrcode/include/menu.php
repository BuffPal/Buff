<?php


function buffpal_QR_code_manage_menu()
{
    //定义顶级菜单
    add_submenu_page(
        'options-general.php',
        'buffpal_QR_code',
        '打赏二维码管理',
        'manage_options',
        'buffpal_OR_code_menu',
        'buffpal_award_by_QR_code_menu'
    );
}

function buffpal_award_by_QR_code_menu()
{
    //图像地址
    $QR_url = get_option('BuffPalQRCodeUrl');
    //图像悬停描述
    $description = get_option('BuffPalQRCodeUrlDescription', '');
    $description = !empty($description) ? $description : '感谢您的打赏';
    //图像生成原数据
    $data = get_option('BuffPalQRCodeUrlData');

    //Post数据接收处理
    if(!empty($_POST['submit']))
    {
        //判断原数据是否更改
        if($QR_url != $_POST['ashu_upload'] || $description != $_POST['description'] || $data != $_POST['fordec'])
        {
            //判断如果是 $data修改的话,那就是用户要更具内容生成验证码
            if($data != $_POST['fordec']){
                $QR_url = buffpal_create_QR_code_function($_POST['fordec']);
            }else{
                $QR_url = $_POST['ashu_upload'];
            }
            $description = $_POST['description'];
            $data = $_POST['fordec'];
            //执行更新
            update_option('BuffPalQRCodeUrl',$QR_url);
            update_option('BuffPalQRCodeUrlDescription',$description);
            update_option('BuffPalQRCodeUrlData',$data);
        }

    }



    ?>
    <div class="wrap">
        <h2>二维码打赏设置</h2>
        <form action="" method="post">
            <table class="form-table">
                <?php
                if (!empty($QR_url)) {
                    ?>
                    <tr valign="top">
                        <th><label for="">当前的二维码</label></th>
                        <td><img src="<?php echo $QR_url ?>" height="200" width="200" style="border: 3px solid #fff;border-radius: 3px;box-shadow: 0 0 28px #ddd;cursor: pointer" title="<?php echo $description ?>"></td>
                    </tr>
                    <?php
                } else {
                    ?>
                    <tr valign="top">
                        <th><label for="">您当前还没有上传二维码</label></th>
                    </tr>
                    <?php
                }
                ?>
                <tr valign="top">
                    <th><label for="description">悬停信息</label></th>
                    <td><input type="text" name="description" id="description" class="regular-text code" value="<?php echo $description ?>"/></td>
                </tr>
                <tr valign="top">
                    <th><label for="type">选着生成方式</label></th>
                    <td><input type="radio" checked="checked" value="pic" name="type" id="pic"><label for="pic">图片</label>　　　<input type="radio" value="dec" name="type" id="dec"><label for="dec">信息</label></td>
                </tr>
                <!--JS隐藏效果-->
                <tr valign="top" id="forpic">
                    <th><label for="forpict">上传您的图片</label></th>
                    <td><input type="text" size="60" readonly="readonly" value="<?php echo $QR_url ?>" name="ashu_upload" class="regular-text code" id="ashu_upload_input"/>　　<a id="ashu_upload" class="ashu_upload_button button" href="javascript:;">点击上传</a></td>
                </tr>
                <tr valign="top" id="fordec" style="display: none;">
                    <th><label for="fordec">输入您要生成的信息</label></th>
                    <td><input type="text" name="fordec" id="fordect" class="regular-text code" value="<?php echo $data ?>"/></td>
                </tr>
                <tr valign="top">
                    <th></th>
                    <td>
                        <p class="submit">
                            <input id="submit" class="button button-primary" type="submit" value="保存更改" name="submit">
                        </p>
                    </td>
                </tr>


            </table>
        </form>
    </div>
    <?php
}

//加载顶级菜单
add_action('admin_menu', 'buffpal_QR_code_manage_menu');
