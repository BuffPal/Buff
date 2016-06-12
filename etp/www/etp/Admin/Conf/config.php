<?php
return array(
	'LOCATION_IP'=>false,//是否开启后台获取真是IP地址 用QQ分享计划获取的 不开启则显示单纯的IP
  //图片上传配置
  'UPLOAD_MAX_SIZE' => 3145728,      //最大 3M
  'UPLOAD_PATH'     => './Uploads/', //文件上传保存路径//这个是按 项目文件路劲来算的
  'UPLOAD_EXTS'     =>  array('jpg', 'gif', 'png', 'jpeg'), //允许上传的文件后缀
  //视频上传类配置
  'UPLOAD_MAX_SIZE_VIDEO' =>3221225472, //最大上传3G
  'UPLOAD_EXTS_VIDEO'     =>  array('mp4'), //允许上传的文件后缀

  //音乐上传处理
  'UPLOAD_MAX_SIZE_MUSIC'=> 10485760, //最大允许10M
  'UPLOAD_EXTS_MUSIC' => array('mp3'),//只允许上传 mp3

  //后台视频列表显示条数
  'VIDEO_LISTS_SIZE'=>10,
);