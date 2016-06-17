<?php

if(!defined('WP_UNINSTALL_PLUGIN')){
    exit();
}
//删除二维码url
delete_option('BuffPalQRCodeUrl');
//删除二维码描述
delete_option('BuffPalQRCodeUrlDescription');
//删除二维码生成信息
delete_option('BuffPalQRCodeUrlData');