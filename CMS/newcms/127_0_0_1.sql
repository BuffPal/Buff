-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-03-15 16:51:09
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- 表的结构 `cms_level`
--

CREATE TABLE IF NOT EXISTS `cms_level` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '排序编号',
  `level_name` varchar(20) NOT NULL COMMENT '等级名称',
  `level_info` varchar(200) NOT NULL COMMENT '等级说明',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `cms_level`
--

INSERT INTO `cms_level` (`id`, `level_name`, `level_info`) VALUES
(1, '超级管理员', '最大的权限(如果只有一个超级管理员时不能删除自己)!'),
(2, '普通管理员', '除了不能操作别的管理员,其他任何都能操作'),
(3, '发帖专员', '可以发表文章1和1修改删除文章权a限'),
(4, '水军', '可以对文章的评论进评论和删除a'),
(5, '会员专员', '只有管理会员的权限,包括新增删除和查询'),
(6, '酱油侠', '只是路过打酱油的哈哈,传说中的后台游客'),
(7, '黑马', '官方维护人员,除了超级管理员不操作,拥有其他全部功能'),
(10, '蓝马', '频道所有');

-- --------------------------------------------------------

--
-- 表的结构 `cms_manage`
--

CREATE TABLE IF NOT EXISTS `cms_manage` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `admin_user` varchar(20) NOT NULL COMMENT '管理员账号',
  `admin_pass` char(40) NOT NULL COMMENT '管理员密码',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '管理员等级',
  `login_count` smallint(5) NOT NULL DEFAULT '0' COMMENT '管理员登录次数',
  `last_ip` varchar(20) DEFAULT '000.000.000.000' COMMENT '最后登录ip',
  `last_time` datetime NOT NULL COMMENT '最后登录时间',
  `reg_time` datetime NOT NULL COMMENT '注册时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=71 ;

--
-- 转存表中的数据 `cms_manage`
--

INSERT INTO `cms_manage` (`id`, `admin_user`, `admin_pass`, `level`, `login_count`, `last_ip`, `last_time`, `reg_time`) VALUES
(1, 'admin', 'd5a1bdf9ce989fd6161063e94b92bdeacb94ed23', 1, 23, '::1', '2016-03-15 19:47:18', '2016-02-25 03:15:08'),
(68, '钱十', 'd5a1bdf9ce989fd6161063e94b92bdeacb94ed23', 7, 0, '000.000.000.000', '0000-00-00 00:00:00', '2016-03-11 18:24:22'),
(67, '孙九', 'd5a1bdf9ce989fd6161063e94b92bdeacb94ed23', 1, 0, '000.000.000.000', '0000-00-00 00:00:00', '2016-03-11 18:24:09'),
(66, '王八', 'd5a1bdf9ce989fd6161063e94b92bdeacb94ed23', 5, 0, '000.000.000.000', '0000-00-00 00:00:00', '2016-03-11 18:23:51'),
(56, '小黑', '', 10, 0, '000.000.000.000', '0000-00-00 00:00:00', '2016-03-11 17:18:01'),
(10, '狸花猫', '2891baceeef1652ee698294da0e71ba78a2a4064', 4, 1, '127.0.0.1', '2016-03-13 17:51:36', '2016-03-01 09:39:03'),
(59, '陈一', 'd5a1bdf9ce989fd6161063e94b92bdeacb94ed23', 4, 0, '000.000.000.000', '0000-00-00 00:00:00', '2016-03-11 18:21:59'),
(60, '吴二', 'd5a1bdf9ce989fd6161063e94b92bdeacb94ed23', 10, 0, '000.000.000.000', '0000-00-00 00:00:00', '2016-03-11 18:22:23'),
(61, '张三', '', 1, 0, '000.000.000.000', '0000-00-00 00:00:00', '2016-03-11 18:22:35'),
(62, '李四', 'd5a1bdf9ce989fd6161063e94b92bdeacb94ed23', 6, 0, '000.000.000.000', '0000-00-00 00:00:00', '2016-03-11 18:22:53'),
(63, '王五', 'd5a1bdf9ce989fd6161063e94b92bdeacb94ed23', 1, 0, '000.000.000.000', '0000-00-00 00:00:00', '2016-03-11 18:23:00'),
(65, '周七', 'd5a1bdf9ce989fd6161063e94b92bdeacb94ed23', 3, 0, '000.000.000.000', '0000-00-00 00:00:00', '2016-03-11 18:23:36'),
(55, '汪星人', 'd5a1bdf9ce989fd6161063e94b92bdeacb94ed23', 2, 0, '000.000.000.000', '0000-00-00 00:00:00', '2016-03-11 17:14:18'),
(22, '虎斑猫', 'c53255317bb11707d0f614696b3ce6f221d0e2f2', 4, 0, '000.000.000.000', '0000-00-00 00:00:00', '2016-03-01 10:06:28');

-- --------------------------------------------------------

--
-- 表的结构 `cms_nav`
--

CREATE TABLE IF NOT EXISTS `cms_nav` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `nav_name` varchar(20) NOT NULL COMMENT '导航名',
  `nav_url` varchar(200) NOT NULL COMMENT '导航URL',
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '子分类',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- 转存表中的数据 `cms_nav`
--

INSERT INTO `cms_nav` (`id`, `nav_name`, `nav_url`, `pid`) VALUES
(1, '首页', 'http://www.hao123.com', 0),
(2, '花草种类', 'http://www.baidu.com', 0),
(3, '购买电话', 'http://www.baidu.com', 0),
(4, '木材种类', 'http://www.baidu.com', 0),
(5, '原生论坛', 'http://tieba.baidu.com/', 0),
(6, '留言板', 'http://tieba.baidu.com/', 0),
(40, '白桦', 'http://tieba.baidu.com/', 2),
(41, '梅花', 'http://www.qq.com', 2),
(42, '茉莉花', 'http://www.baidu.com', 2),
(43, '紫罗兰', 'http://www.baidu.com', 2),
(44, '栀子花', 'http://www.baidu.com', 2),
(45, '月季', 'http://www.baidu.com', 2),
(46, '银杏', 'http://www.baidu.com', 4),
(47, '马尾松', 'http://www.baidu.com', 4),
(48, '合欢树', 'http://www.baidu.com', 4),
(49, '见血封喉', 'http://www.baidu.com', 4),
(50, '梧桐', 'http://www.baidu.com', 4),
(51, '平安树', 'http://www.baidu.com', 4);

-- --------------------------------------------------------

--
-- 表的结构 `cms_nav_origami`
--

CREATE TABLE IF NOT EXISTS `cms_nav_origami` (
  `id` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `origami_name` varchar(20) NOT NULL COMMENT '名字',
  `origami_pid` smallint(1) unsigned NOT NULL COMMENT 'ID',
  `origami_url` varchar(200) NOT NULL COMMENT '超链接',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `cms_nav_origami`
--

INSERT INTO `cms_nav_origami` (`id`, `origami_name`, `origami_pid`, `origami_url`) VALUES
(1, '联系我们', 0, 'none'),
(2, '中国淘宝', 1, 'http://www.taobao.com'),
(3, '中国京东', 1, 'https://www.jd.com'),
(4, '中国天猫', 1, 'https://www.tmall.com'),
(5, '中国1号店', 1, 'http://www.yhd.com'),
(6, '苏宁易购', 1, 'http://sale.suning.com'),
(7, '亚马逊', 1, 'http://www.amazon.cn'),
(8, '唯品会', 1, 'http://www.vip.com'),
(11, '美丽说', 1, 'http://www.meilishuo.com/');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
