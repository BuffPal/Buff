<?php
/*
Plugin Name:打赏
Plugin URI: http://localhost
Description:通过二维码进行打赏,将在全站右下角输出
Version:  1.0
Author: BuffPal
Author URI: http://blog.buff.com
*/
include (dirname(__FILE__).'/include/phpqrcode.php');
Class buffpal_award_by_QR_code{

    public function __construct()
    {
        //用于ajax引入JS文件
        add_action('admin_enqueue_scripts',array($this,'load_script'));
        //前台挂载钩子,用于显示打赏图标
        add_action('wp_head',array($this,'show_icon_function'));

    }

    //前台显示图标
    public function show_icon_function()
    {
        $path = get_option('BuffPalQRCodeUrl');
        $description = get_option('BuffPalQRCodeUrlDescription');
        ?>
        <style>
            div.buffpal_QR_code{
                width: 50px;
                height: 50px;
                border-left:1px solid #eee;
                border-top:1px solid #eee;
                border-right:1px solid #aaa;
                border-bottom:1px solid #aaa;
                background-color: #fff;
                position: fixed;
                bottom: 20%;
                right:10%;
                cursor: pointer;
                border-radius: 5px;
                box-shadow: 1px 1px 2px #666;
                z-index:99999;
            }
            div.buffpal_QR_code:after{
                font-size: 35px;
                font-family: '娃娃体-简';
                line-height:45px;
                padding-left:6px;
                color: #073047;
                text-shadow: 0 0 1px #333;
                content: '赏';
            }
            div.buffpal_QR_code>div.img{
                position: absolute;
                top:-85px;
                left:-238px;
                border:3px solid #eee;
                border-radius: 3px;
                transform-origin: right;
                transform:scale(0,0);
                opacity:0;
                transition:transform .5s ease-out,opacity 1s;
            }
            div.buffpal_QR_code>div.img>img{
                position: relative;
                height:230px;
                width:230px;
            }
            div.buffpal_QR_code:hover >div.img{
                transform: scale(1,1);
                opacity:1;
            }
        </style>
        <div class="buffpal_QR_code">
            <div class="img">
                <img src="<?php echo $path ?>" title="<?php echo $description ?>">
            </div>
        </div>
        <?php
    }

    //指定页面加载
    public function load_script()
    {
        //获取当前页面URL
        $screen = get_current_screen();
        if(is_object($screen) && $screen->id == 'settings_page_buffpal_OR_code_menu'){
            wp_enqueue_media();
            wp_enqueue_script('buffpal_js',plugins_url('js/buffpal_js.js',__FILE__),array('jquery'));
        }

    }


}

new buffpal_award_by_QR_code();

//生成二维码.在menu界面被调用
function buffpal_create_QR_code_function($data){
    $errorCorrectionLevel = 'L';//纠错级别：L、M、Q、H
    $matrixPointSize = 10;//二维码点的大小：1到10
    $path = dirname(__FILE__).'/emw.png';
    QRcode::png ( $data, $path, $errorCorrectionLevel, $matrixPointSize, 2,true);//不带Logo二维码的文件名
    chmod($path,0777);
    return plugins_url('/emw.png',__FILE__);
}


//顶级菜单
include (dirname(__FILE__).'/include/menu.php');
