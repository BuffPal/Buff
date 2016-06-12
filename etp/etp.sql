-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-05-14 10:19:55
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `etp`
--

-- --------------------------------------------------------

--
-- 表的结构 `etp_carousel`
--

CREATE TABLE IF NOT EXISTS `etp_carousel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '轮播标题',
  `info` varchar(300) NOT NULL DEFAULT '' COMMENT '轮播简介',
  `picurl` varchar(100) NOT NULL DEFAULT '' COMMENT '图片地址',
  `link` varchar(100) NOT NULL DEFAULT '' COMMENT '点击跳转地址',
  `color` varchar(10) NOT NULL DEFAULT '' COMMENT '渐变颜色',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='首页轮播表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `etp_manages`
--

CREATE TABLE IF NOT EXISTS `etp_manages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(20) NOT NULL DEFAULT '' COMMENT '管理员账号',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `logintime` int(10) NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `loginip` varchar(50) NOT NULL DEFAULT '' COMMENT '上次登录IP',
  `locks` tinyint(1) NOT NULL DEFAULT '0' COMMENT '管理员是否被锁定(0未锁定,1锁定)',
  `level` varchar(100) NOT NULL DEFAULT '' COMMENT '管理员权限表',
  `logins` int(11) NOT NULL DEFAULT '1' COMMENT '管理员登录次数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理员表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `etp_manages`
--

INSERT INTO `etp_manages` (`id`, `account`, `password`, `logintime`, `loginip`, `locks`, `level`, `logins`) VALUES
(1, 'admin', '20917c851c4a54f2a054390dac9085b7', 1463213920, '0.0.0.0', 0, '', 2);

-- --------------------------------------------------------

--
-- 表的结构 `etp_music`
--

CREATE TABLE IF NOT EXISTS `etp_music` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `musicname` varchar(20) NOT NULL DEFAULT '' COMMENT '歌曲名',
  `author` varchar(20) NOT NULL DEFAULT '''''' COMMENT '作者名',
  `playcount` int(11) NOT NULL DEFAULT '0' COMMENT '音乐播放次数',
  `musicurl` varchar(100) NOT NULL DEFAULT '' COMMENT '音乐地址',
  `musicbgurl` varchar(100) NOT NULL DEFAULT '''''' COMMENT '音乐封面图',
  `keepcount` int(11) NOT NULL DEFAULT '0' COMMENT '收藏次数',
  `uploadtime` int(10) NOT NULL DEFAULT '0' COMMENT '上传时间',
  `size` varchar(20) NOT NULL COMMENT '文件大小',
  `cid` int(10) unsigned NOT NULL COMMENT '所属音乐类别ID',
  `mid` int(10) unsigned NOT NULL COMMENT '所属管理员ID',
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`),
  KEY `mid` (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='音乐表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `etp_musicclassify`
--

CREATE TABLE IF NOT EXISTS `etp_musicclassify` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '分类名称',
  `fid` int(11) NOT NULL DEFAULT '0' COMMENT '父级别ID(0代表最高级别)',
  `faceurl` varchar(100) NOT NULL DEFAULT '' COMMENT '分类图片地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='音乐分类(这里只做2级)表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `etp_musickeep`
--

CREATE TABLE IF NOT EXISTS `etp_musickeep` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `keeptime` int(10) NOT NULL DEFAULT '0' COMMENT '收藏时间',
  `mid` int(10) unsigned NOT NULL COMMENT '被收藏音乐的ID',
  `uid` int(11) NOT NULL COMMENT '收藏用户的ID',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='音乐收藏表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `etp_user`
--

CREATE TABLE IF NOT EXISTS `etp_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(20) NOT NULL DEFAULT '' COMMENT '用户账号',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '用户账号密码',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱地址',
  `registertime` int(10) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `logintime` int(10) NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `loginip` int(10) NOT NULL DEFAULT '0' COMMENT '上次登录Ip',
  `locks` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否被锁定(0未 1锁定)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `etp_userinfo`
--

CREATE TABLE IF NOT EXISTS `etp_userinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `userpic` varchar(100) NOT NULL DEFAULT '' COMMENT '用户头像',
  `truename` varchar(20) NOT NULL DEFAULT '' COMMENT '真实名称',
  `location` varchar(20) NOT NULL DEFAULT '' COMMENT '所在地',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别(0:男 1:女)',
  `day` varchar(15) NOT NULL DEFAULT '' COMMENT '用户生日',
  `intro` varchar(100) NOT NULL DEFAULT '' COMMENT '一句话介绍自己',
  `blog` varchar(100) NOT NULL DEFAULT '' COMMENT '用户博客地址',
  `msn` varchar(100) NOT NULL DEFAULT '' COMMENT '用户msn地址',
  `qq` varchar(11) NOT NULL COMMENT 'QQ号码',
  `uid` int(11) NOT NULL COMMENT '所属用户id',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户个人信息表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `etp_video`
--

CREATE TABLE IF NOT EXISTS `etp_video` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `videoname` varchar(20) NOT NULL DEFAULT '' COMMENT '视频名称',
  `playcount` int(11) NOT NULL DEFAULT '0' COMMENT '播放次数',
  `comment` int(11) NOT NULL DEFAULT '0' COMMENT '评论次数',
  `videourl` varchar(100) NOT NULL DEFAULT '' COMMENT '视频地址',
  `size` varchar(25) NOT NULL DEFAULT '''''' COMMENT '视频大小',
  `videopicurl` varchar(100) NOT NULL DEFAULT '' COMMENT '视频封面图',
  `videopicurl176` varchar(100) NOT NULL COMMENT '176x99小图',
  `topcount` int(11) NOT NULL DEFAULT '0' COMMENT '点赞人数',
  `uploadtime` int(10) NOT NULL DEFAULT '0' COMMENT '上传时间',
  `keepcount` int(11) NOT NULL DEFAULT '0' COMMENT '收藏次数',
  `cid` int(10) unsigned NOT NULL COMMENT '所属视频分类ID',
  `mid` int(10) unsigned NOT NULL COMMENT '所属管理员id',
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`),
  KEY `mid` (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='视频表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `etp_videoclassify`
--

CREATE TABLE IF NOT EXISTS `etp_videoclassify` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '类别名称',
  `info` varchar(200) NOT NULL COMMENT '//分类简介',
  `faceurl` varchar(100) NOT NULL DEFAULT '' COMMENT '类别封面图',
  `faceurl100x150` varchar(100) NOT NULL COMMENT '100x150',
  `fid` int(11) NOT NULL DEFAULT '0' COMMENT '分类父级ID(0为最高级别)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='视频分类(无限极)' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `etp_videokeep`
--

CREATE TABLE IF NOT EXISTS `etp_videokeep` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `keeptime` int(10) NOT NULL DEFAULT '0' COMMENT '视频收藏时间',
  `vid` int(10) unsigned NOT NULL COMMENT '被收藏视频的ID',
  `uid` int(11) NOT NULL COMMENT '收藏用户的ID',
  PRIMARY KEY (`id`),
  KEY `vid` (`vid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='视频收藏表' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
