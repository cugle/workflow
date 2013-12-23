-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2013 年 12 月 20 日 11:14
-- 服务器版本: 5.5.32
-- PHP 版本: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `thinkphp`
--
CREATE DATABASE IF NOT EXISTS `thinkphp` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `thinkphp`;

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_access`
--

CREATE TABLE IF NOT EXISTS `thinkphp_access` (
  `role_id` int(5) NOT NULL,
  `node_id` int(5) NOT NULL,
  KEY `role_id` (`role_id`),
  KEY `node_id` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `thinkphp_access`
--

INSERT INTO `thinkphp_access` (`role_id`, `node_id`) VALUES
(1, 163),
(1, 162),
(1, 161),
(1, 160),
(1, 156),
(1, 155),
(1, 154),
(1, 153),
(1, 152),
(1, 151),
(1, 150),
(1, 149),
(1, 148),
(1, 147),
(1, 146),
(1, 145),
(1, 144),
(1, 143),
(1, 142),
(1, 141),
(1, 140),
(1, 132),
(1, 131),
(1, 130),
(1, 129),
(1, 128),
(1, 127),
(1, 126),
(1, 125),
(1, 124),
(1, 123),
(1, 122),
(1, 121),
(1, 139),
(1, 138),
(1, 137),
(1, 136),
(1, 135),
(1, 110),
(1, 109),
(1, 108),
(1, 107),
(1, 104),
(1, 106),
(1, 105),
(1, 103),
(1, 102),
(1, 101),
(1, 100),
(1, 99),
(1, 158),
(1, 51),
(1, 50),
(1, 16),
(1, 15),
(1, 14),
(1, 13),
(1, 12),
(1, 11),
(1, 10),
(1, 9),
(1, 8),
(1, 7),
(1, 6),
(2, 110),
(2, 109),
(2, 108),
(2, 107),
(2, 104),
(2, 106),
(2, 105),
(2, 103),
(2, 102),
(2, 101),
(2, 16),
(2, 15),
(2, 14),
(2, 13),
(2, 12),
(2, 11),
(2, 10),
(2, 9),
(2, 8),
(2, 7),
(2, 6),
(2, 5),
(2, 4),
(2, 3),
(2, 2),
(2, 1),
(1, 5),
(1, 4),
(1, 3),
(1, 2),
(1, 1),
(1, 164),
(1, 165);

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_ad`
--

CREATE TABLE IF NOT EXISTS `thinkphp_ad` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `board_id` smallint(5) NOT NULL,
  `type` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `code` text NOT NULL,
  `start_time` int(10) NOT NULL,
  `end_time` int(10) NOT NULL,
  `clicks` int(10) NOT NULL DEFAULT '0',
  `add_time` int(10) NOT NULL,
  `ordid` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `board_id` (`board_id`,`start_time`,`end_time`,`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `thinkphp_ad`
--

INSERT INTO `thinkphp_ad` (`id`, `board_id`, `type`, `name`, `url`, `code`, `start_time`, `end_time`, `clicks`, `add_time`, `ordid`, `status`) VALUES
(6, 6, 'code', 'phonegap中文网', 'http://www.phonegap100.com', '<script type=\\"text/javascript\\">alimama_pid=\\"mm_30949159_3378420_11349182\\";alimama_width=950;alimama_height=90;</script><script src=\\"http://a.alimama.cn/inf.js\\" type=\\"text/javascript\\"></script>', 1333595088, 1365217491, 104, 1333681516, 1, 1),
(7, 5, 'image', '凡客', '', '512ad36e181c5.png', 1333683143, 1365219146, 11, 1333683151, 2, 0),
(9, 5, 'text', '测试', 'http://192.168.1.51/wegou_news/uc_client', '测试广告', 1360598400, 1361462400, 0, 1361773236, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_adboard`
--

CREATE TABLE IF NOT EXISTS `thinkphp_adboard` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` varchar(20) NOT NULL,
  `width` smallint(5) NOT NULL,
  `height` smallint(5) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `thinkphp_adboard`
--

INSERT INTO `thinkphp_adboard` (`id`, `name`, `type`, `width`, `height`, `description`, `status`) VALUES
(4, '详细页横幅', 'banner', 950, 100, '', 1),
(5, '详细页右侧', 'banner', 226, 226, '', 1),
(6, '首页下方横幅', 'banner', 960, 100, '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_admin`
--

CREATE TABLE IF NOT EXISTS `thinkphp_admin` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `add_time` int(10) DEFAULT NULL,
  `last_time` int(10) DEFAULT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `role_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `thinkphp_admin`
--

INSERT INTO `thinkphp_admin` (`id`, `user_name`, `password`, `add_time`, `last_time`, `status`, `role_id`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1384237243, NULL, 1, 1),
(2, 'cugle', 'e10adc3949ba59abbe56e057f20f883e', 1384332375, 1384332375, 1, 1),
(3, 'yongfu', 'e10adc3949ba59abbe56e057f20f883e', 1384335697, 1384335697, 1, 2);

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_article`
--

CREATE TABLE IF NOT EXISTS `thinkphp_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` tinyint(4) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `orig` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `abst` varchar(255) NOT NULL,
  `info` mediumtext NOT NULL,
  `add_time` datetime NOT NULL,
  `ordid` tinyint(4) NOT NULL,
  `is_hot` tinyint(1) NOT NULL DEFAULT '0',
  `is_best` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-待审核 1-已审核',
  `seo_title` varchar(255) NOT NULL,
  `seo_keys` varchar(255) NOT NULL,
  `seo_desc` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `is_best` (`is_best`),
  KEY `add_time` (`add_time`),
  KEY `cate_id` (`cate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- 转存表中的数据 `thinkphp_article`
--

INSERT INTO `thinkphp_article` (`id`, `cate_id`, `title`, `orig`, `img`, `url`, `abst`, `info`, `add_time`, `ordid`, `is_hot`, `is_best`, `status`, `seo_title`, `seo_keys`, `seo_desc`) VALUES
(3, 15, '眉部作品', '', '52a80c5acdfe6.jpg', '', '眉部作品眉部作品', '眉部作品眉部作品', '2013-12-11 14:55:22', 0, 0, 0, 1, '', '', ''),
(4, 15, '技术班', '', '52a80f9f22551.JPG', '', '技术班', '技术班', '2013-12-11 15:09:19', 0, 0, 0, 1, '', '', ''),
(5, 15, '技术班', '', '52a80fb057bcf.JPG', '', '技术班', '技术班', '2013-12-11 15:09:36', 0, 0, 0, 1, '', '', ''),
(6, 15, '技术班', '技术班', '52a80fc01ab3f.JPG', '', '技术班', '技术班', '2013-12-11 15:09:52', 0, 0, 0, 1, '', '', ''),
(7, 15, '技术班', '', '52a80fce3567e.JPG', '', '技术班', '技术班', '2013-12-11 15:10:06', 0, 0, 0, 1, '', '', ''),
(8, 15, '技术班', '', '52a80fd9dd40a.JPG', '', '技术班', '技术班', '2013-12-11 15:10:17', 0, 0, 0, 1, '', '', ''),
(9, 15, '技术班', '', '52a80fe7a037a.JPG', '', '技术班', '技术班', '2013-12-11 15:10:31', 0, 0, 0, 1, '', '', ''),
(10, 15, '技术班', '', '52a80ff600000.JPG', '', '技术班', '技术班', '2013-12-11 15:10:46', 0, 0, 0, 1, '', '', ''),
(11, 15, '技术班', '', '52a8100190f56.JPG', '', '技术班', '技术班', '2013-12-11 15:10:57', 0, 0, 0, 1, '', '', ''),
(12, 15, '技术班', '', '52a81012f0537.JPG', '', '技术班', '技术班', '2013-12-11 15:11:14', 0, 0, 0, 1, '', '', ''),
(13, 15, '技术班', '', '52a8101e03d09.JPG', '', '技术班', '技术班', '2013-12-11 15:11:26', 0, 0, 0, 1, '', '', ''),
(14, 15, '技术班', '', '52a81035cdfe6.JPG', '', '技术班', '技术班', '2013-12-11 15:11:49', 0, 0, 0, 1, '', '', ''),
(15, 15, '技术班', '', '52a81041487ab.JPG', '', '技术班', '技术班', '2013-12-11 15:12:01', 0, 0, 0, 1, '', '', ''),
(16, 15, '技术班', '', '52a8104c7270e.JPG', '', '技术班', '技术班', '2013-12-11 15:12:12', 0, 0, 0, 1, '', '', ''),
(17, 15, '技术班1', '', '52a8105f3567e.JPG', '', '技术班是', '技术班', '2013-12-11 15:12:31', 0, 0, 0, 1, '', '', ''),
(18, 15, '纹绣学院第三期高端课', '', '52a810727de29.JPG', ' ', '技术班', '技术班', '2013-12-11 15:12:50', 0, 0, 0, 1, '', '', ''),
(19, 15, '纹绣学院第三期高端课', '', '52a8108881b32.JPG', '', '技术班', '技术班', '2013-12-11 15:13:12', 0, 0, 0, 1, '', '', ''),
(20, 15, '第十期访谈', '', '52a810980f424.JPG', '', '技术班', '技术班技术班', '2013-12-11 15:13:28', 0, 0, 0, 1, '', '', ''),
(21, 15, '第1集', '', '52a810a81e848.JPG', '', '技术班技术班技术班技术班', '技术班技术班技术班', '2013-12-11 15:13:44', 0, 0, 0, 1, '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_article_cate`
--

CREATE TABLE IF NOT EXISTS `thinkphp_article_cate` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `pid` smallint(4) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `article_nums` int(10) unsigned NOT NULL,
  `sort_order` smallint(4) unsigned NOT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_keys` varchar(255) NOT NULL,
  `seo_desc` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `thinkphp_article_cate`
--

INSERT INTO `thinkphp_article_cate` (`id`, `name`, `alias`, `pid`, `status`, `article_nums`, `sort_order`, `seo_title`, `seo_keys`, `seo_desc`) VALUES
(1, '网站信息', 'sites', 11, 1, 4, 4, '', '', ''),
(5, '新手入门', 'rumen', 11, 1, 2, 2, '', '', ''),
(9, '热门活动', 'activity', 10, 1, 6, 5, '网站在线帮助说明', '111111111111111111111', '2222222222222222'),
(10, '资讯活动', 'news', 0, 1, 2, 1, '网站资讯', '', ''),
(11, '网站帮助', 'sites', 0, 1, 0, 0, '', '', ''),
(12, '1', '1', 5, 1, 0, 0, '1', '1', '1'),
(13, 'wewr', 'wer', 5, 1, 0, 3, 'wre', 'wer', 'werew'),
(14, '434', '43', 10, 1, 0, 3, '33', '3', '33'),
(15, '眉部作品', '眉部作品', 0, 1, 19, 1, '眉部作品', '眉部作品', '眉部作品');

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_data`
--

CREATE TABLE IF NOT EXISTS `thinkphp_data` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `data` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `thinkphp_data`
--

INSERT INTO `thinkphp_data` (`id`, `data`) VALUES
(1, 'thinkphp'),
(2, 'php'),
(3, 'framework');

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_flink`
--

CREATE TABLE IF NOT EXISTS `thinkphp_flink` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` smallint(4) NOT NULL DEFAULT '1',
  `img` varchar(255) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `ordid` smallint(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `thinkphp_flink`
--

INSERT INTO `thinkphp_flink` (`id`, `cate_id`, `img`, `name`, `url`, `status`, `ordid`) VALUES
(1, 1, '4f8ceab7e6f6c.jpg', 'phonegap100', 'http://www.phonegap100.com', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_flink_cate`
--

CREATE TABLE IF NOT EXISTS `thinkphp_flink_cate` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `thinkphp_flink_cate`
--

INSERT INTO `thinkphp_flink_cate` (`id`, `name`) VALUES
(1, '友情链接'),
(2, '合作伙伴');

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_group`
--

CREATE TABLE IF NOT EXISTS `thinkphp_group` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `title` varchar(50) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `sort` (`sort`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- 转存表中的数据 `thinkphp_group`
--

INSERT INTO `thinkphp_group` (`id`, `name`, `title`, `create_time`, `update_time`, `status`, `sort`) VALUES
(4, 'article', '内容管理', 1222841259, 1222841259, 1, 3),
(1, 'system', '系统设置', 1222841259, 1222841259, 1, 6),
(8, 'member', '会员管理', 0, 0, 1, 4),
(9, 'home', '起始页', 0, 1341386748, 1, 0),
(27, 'seller', '商家管理', 1340586215, 0, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_nav`
--

CREATE TABLE IF NOT EXISTS `thinkphp_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `sort_order` smallint(4) NOT NULL,
  `system` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1-系统 0-自定义',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '导航位置1-顶部 2-底部',
  `in_site` tinyint(1) NOT NULL COMMENT '1-本站内 0-站外',
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `seo_title` varchar(255) NOT NULL,
  `seo_keys` text NOT NULL,
  `seo_desc` text NOT NULL,
  `items_cate_id` int(11) DEFAULT NULL COMMENT '//分类id',
  PRIMARY KEY (`id`),
  KEY `is_show` (`is_show`),
  KEY `type` (`type`),
  KEY `sort_order` (`sort_order`),
  KEY `alias` (`alias`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `thinkphp_nav`
--

INSERT INTO `thinkphp_nav` (`id`, `name`, `alias`, `url`, `sort_order`, `system`, `type`, `in_site`, `is_show`, `seo_title`, `seo_keys`, `seo_desc`, `items_cate_id`) VALUES
(1, '发现', 'search', '', 1, 1, 1, 1, 1, '', '', '', 0),
(2, '母婴', 'album', '', 2, 1, 1, 1, 1, '', '', '', 0),
(3, '搞笑', 'promo', '', 3, 1, 1, 1, 1, '', '', '', 0),
(4, '返现商家', 'seller', '', 4, 1, 1, 1, 1, '', '', '', NULL),
(5, '视频', 'exchange_goods', '', 5, 1, 1, 1, 0, '', '', '', NULL),
(6, '杂谈', 'xiezi', '', 8, 0, 1, 1, 1, '', '', '', 2),
(7, '帮助中心', 'bangzhu', 'http://bbs.phonegap100.com', 0, 0, 1, 0, 0, '', '', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_node`
--

CREATE TABLE IF NOT EXISTS `thinkphp_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL,
  `module_name` varchar(50) NOT NULL,
  `action` varchar(255) NOT NULL,
  `action_name` varchar(50) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned NOT NULL DEFAULT '0',
  `auth_type` tinyint(1) NOT NULL DEFAULT '0',
  `group_id` tinyint(3) unsigned DEFAULT '0',
  `often` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-不常用 1-常用',
  `is_show` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-不常用 1-常用',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `module` (`module`),
  KEY `auth_type` (`auth_type`),
  KEY `is_show` (`is_show`),
  KEY `group_id` (`group_id`),
  KEY `sort` (`sort`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=166 ;

--
-- 转存表中的数据 `thinkphp_node`
--

INSERT INTO `thinkphp_node` (`id`, `module`, `module_name`, `action`, `action_name`, `data`, `status`, `remark`, `sort`, `auth_type`, `group_id`, `often`, `is_show`) VALUES
(1, 'Node', '菜单管理', '', '', '', 1, '', 0, 0, 1, 0, 0),
(2, 'Node', '菜单管理', 'index', '菜单列表', '', 1, '', 0, 1, 1, 0, 0),
(3, 'Node', '菜单管理', 'add', '添加菜单', '', 1, '', 0, 2, 1, 0, 0),
(4, 'Node', '菜单管理', 'edit', '编辑菜单', '', 1, '', 0, 2, 1, 0, 0),
(5, 'Node', '菜单管理', 'delete', '删除菜单', '', 1, '', 0, 2, 1, 0, 0),
(6, 'Role', '角色管理', '', '', '', 1, '', 370, 0, 1, 0, 0),
(7, 'Role', '角色管理', 'index', '角色管理', '', 1, '', 0, 1, 1, 0, 0),
(8, 'Role', '角色管理', 'add', '添加角色', '', 1, '', 0, 2, 1, 0, 0),
(9, 'Role', '角色管理', 'edit', '编辑角色', '', 1, '', 0, 2, 1, 0, 0),
(10, 'Role', '角色管理', 'delete', '删除角色', '', 1, '', 0, 2, 1, 0, 0),
(11, 'Role', '角色管理', 'auth', '角色授权', '', 1, '', 0, 2, 1, 0, 0),
(12, 'Admin', '管理员管理', '', '', '', 1, '', 380, 0, 1, 0, 0),
(13, 'Admin', '管理员管理', 'index', '管理员列表', '', 1, '', 0, 1, 1, 0, 0),
(14, 'Admin', '管理员管理', 'add', '添加管理员', '', 1, '', 0, 2, 1, 0, 0),
(15, 'Admin', '管理员管理', 'edit', '编辑管理员', '', 1, '', 0, 2, 1, 0, 0),
(16, 'Admin', '管理员管理', 'delete', '删除管理员', '', 1, '', 0, 2, 1, 0, 0),
(50, 'Setting', '网站设置', '', '', '', 1, '', 399, 0, 1, 0, 0),
(51, 'Setting', '网站设置', 'index', '网站设置', '', 1, '', 0, 1, 1, 0, 0),
(99, 'Flink', '友情链接', '', '', '', 1, '', 98, 0, 4, 0, 0),
(100, 'Flink', '友情链接', 'index', '友情链接列表', '', 1, '', 0, 1, 4, 0, 0),
(101, 'Article', '资讯管理', '', '', '', 1, '', 100, 0, 4, 0, 0),
(102, 'Article', '资讯管理', 'index', '资讯列表', '', 1, '', 0, 1, 4, 0, 0),
(103, 'Article', '资讯管理', 'add', '添加资讯', '', 1, '', 0, 1, 4, 0, 0),
(104, 'ArticleCate', '资讯分类', '', '', '', 1, '', 99, 0, 4, 0, 0),
(105, 'Article', '资讯管理', 'edit', '编辑资讯', '', 1, '', 0, 2, 4, 0, 0),
(106, 'Article', '资讯管理', 'delete', '删除资讯', '', 1, '', 0, 2, 4, 0, 0),
(107, 'ArticleCate', '资讯分类', 'index', '分类列表', '', 1, '', 0, 1, 4, 0, 0),
(108, 'ArticleCate', '资讯分类', 'add', '添加分类', '', 1, '', 0, 2, 4, 0, 0),
(109, 'ArticleCate', '资讯分类', 'edit', '编辑分类', '', 1, '', 0, 2, 4, 0, 0),
(110, 'ArticleCate', '资讯分类', 'delete', '删除分类', '', 1, '', 0, 2, 4, 0, 0),
(135, 'SellerCate', '商家分类管理', '', '', '', 1, '', 0, 0, 27, 0, 0),
(136, 'SellerCate', '商家分类管理', 'index', '分类列表', '', 1, '', 0, 1, 27, 0, 0),
(137, 'SellerCate', '商家分类管理', 'add', '增加分类', '', 1, '', 0, 2, 27, 0, 0),
(121, 'Nav', '导航管理', '', '', '', 1, '', 2, 0, 4, 0, 0),
(122, 'Nav', '导航管理', 'index', '导航列表', '', 1, '', 0, 1, 4, 0, 0),
(123, 'Nav', '导航管理', 'add', '添加导航', '', 1, '', 0, 2, 4, 0, 0),
(124, 'Nav', '导航管理', 'edit', '编辑导航', '', 1, '', 0, 2, 4, 0, 0),
(125, 'Nav', '导航管理', 'delete', '删除导航', '', 1, '', 0, 2, 4, 0, 0),
(126, 'Public', '起始页', '', '', '', 1, '', 0, 0, 9, 0, 0),
(127, 'Public', '起始页', 'main', '后台首页', '', 1, '', 0, 1, 9, 0, 0),
(128, 'Group', '菜单分类管理', '', '', '', 1, '菜单分类管理', 10, 0, 1, 0, 0),
(129, 'Group', '菜单分类管理', 'index', '分类列表', '', 1, '', 0, 1, 1, 0, 0),
(130, 'Group', '菜单分类管理', 'add', '增加分类', '', 1, '', 0, 2, 1, 0, 0),
(131, 'Group', '菜单分类管理', 'edit', '编辑分类', '', 1, '', 0, 2, 1, 0, 0),
(132, 'Group', '菜单分类管理', 'delete', '删除分类', '', 1, '', 0, 2, 1, 0, 0),
(138, 'SellerCate', '商家分类管理', 'edit', '编辑分类', '', 1, '', 0, 2, 27, 0, 0),
(139, 'SellerCate', '商家分类管理', 'delete', '删除分类', '', 1, '', 0, 2, 27, 0, 0),
(140, 'SellerList', '商家管理', '', '', '', 1, '', 0, 0, 27, 0, 0),
(141, 'SellerList', '商家管理', 'index', '商家列表', '', 1, '', 0, 1, 27, 0, 0),
(142, 'SellerList', '商家管理', 'add', '增加商家', '', 1, '', 0, 2, 27, 0, 0),
(143, 'SellerList', '商家管理', 'edit', '编辑商家', '', 1, '', 0, 2, 27, 0, 0),
(144, 'SellerList', '商家管理', 'delete', '删除商家', '', 1, '', 0, 2, 27, 0, 0),
(145, 'Adboard', '广告位置', '', '', '', 1, '', 0, 0, 4, 0, 0),
(146, 'Adboard', '广告位置', 'index', '广告位置', '', 1, '', 0, 1, 4, 0, 0),
(147, 'Adboard', '广告位置', 'add', '添加广告位置', '', 1, '', 0, 2, 4, 0, 0),
(148, 'Adboard', '广告位置', 'edit', '编辑广告位置', '', 1, '', 0, 2, 4, 0, 0),
(149, 'Adboard', '广告位置', 'delete', '删除广告位置', '', 1, '', 0, 2, 4, 0, 0),
(150, 'Ad', '广告管理1', '', '', '', 1, '', 0, 0, 4, 0, 0),
(151, 'Ad', '1广告管理', 'index', '广告列表', '', 1, '', 0, 1, 4, 0, 0),
(152, 'Ad', '广告位置', 'add', '添加广告', '', 1, '', 0, 2, 4, 0, 0),
(153, 'Ad', '广告位置', 'edit', '编辑广告', '', 1, '', 0, 2, 4, 0, 0),
(154, 'Ad', '广告位置', 'delete', '删除广告', '', 1, '', 0, 2, 4, 0, 0),
(155, 'User', '会员管理', '', '', '', 1, '', 0, 0, 8, 0, 0),
(156, 'User', '会员管理', 'index', '会员列表', '', 1, '', 0, 1, 8, 0, 0),
(158, 'Setting', '网站设置', 'edit', '编辑设置', '', 1, '', 0, 2, 1, 0, 0),
(159, '11111', '111', '2', '2', '', 1, '', 0, 0, 4, 0, 0),
(160, 'WFDefination', '工作流设计', 'Index', '工作流列表', '', 1, '', 0, 0, 1, 0, 0),
(161, 'WFDefination', '工作流设计', 'add', '新增', '', 1, '', 0, 1, 1, 0, 0),
(162, 'WFNode', '工作流节点', 'Index', '工作流节点列表', '', 1, '', 0, 0, 1, 0, 0),
(163, 'WFNode', '工作流节点', 'add', '新增工作流节点', '', 1, '', 0, 1, 1, 0, 0),
(164, 'WFProcess', '工作流进程', 'Index', '进程列表', '', 1, '', 0, 0, 1, 0, 0),
(165, 'WFProcess', '工作流进程', 'add', '新增', '', 1, '', 0, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_role`
--

CREATE TABLE IF NOT EXISTS `thinkphp_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `thinkphp_role`
--

INSERT INTO `thinkphp_role` (`id`, `name`, `status`, `remark`, `create_time`, `update_time`) VALUES
(1, '管理员', 1, '管理员1', 1208784792, 1254325558),
(2, '编辑', 1, '编辑', 1208784792, 1254325558);

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_seller_cate`
--

CREATE TABLE IF NOT EXISTS `thinkphp_seller_cate` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `cid` int(8) NOT NULL,
  `name` varchar(200) NOT NULL,
  `count` int(8) NOT NULL,
  `seller_status` int(1) NOT NULL DEFAULT '1',
  `status` int(1) NOT NULL,
  `sort` int(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`),
  KEY `index_status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=123 ;

--
-- 转存表中的数据 `thinkphp_seller_cate`
--

INSERT INTO `thinkphp_seller_cate` (`id`, `cid`, `name`, `count`, `seller_status`, `status`, `sort`) VALUES
(122, 22, '食品饮料', 31, 1, 1, 10),
(121, 21, '箱包皮具', 29, 1, 1, 10),
(120, 20, '宠物用品', 1, 0, 1, 10),
(119, 19, '成人保健', 6, 0, 1, 10),
(118, 18, '饰品配饰', 31, 1, 1, 10),
(117, 17, '汽车用品', 7, 0, 1, 10),
(116, 16, '旅游订票', 1, 0, 1, 10),
(115, 15, '钟表眼镜', 17, 1, 1, 10),
(103, 3, '电脑笔记本', 15, 1, 1, 10),
(102, 2, '手机数码', 19, 1, 1, 10),
(114, 14, '药品保健', 8, 1, 1, 10),
(113, 13, '数字卡软件', 2, 0, 1, 10),
(112, 12, '玩具礼品', 6, 0, 1, 10),
(111, 11, '办公用品', 6, 0, 1, 10),
(110, 10, '母婴用品', 14, 1, 1, 10),
(109, 9, '居家生活', 24, 1, 1, 10),
(108, 8, '家用电器', 19, 1, 1, 10),
(107, 7, '户外休闲', 3, 0, 1, 10),
(106, 6, '综合百货', 22, 1, 1, 10),
(105, 5, '化妆美容', 41, 1, 1, 10),
(104, 4, '服装服饰', 85, 1, 1, 10),
(101, 1, '图书音像', 15, 1, 1, 10);

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_seller_list`
--

CREATE TABLE IF NOT EXISTS `thinkphp_seller_list` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `sid` int(8) NOT NULL,
  `cate_id` int(8) NOT NULL,
  `name` varchar(200) NOT NULL,
  `site_logo` varchar(200) DEFAULT NULL,
  `net_logo` varchar(200) NOT NULL,
  `recommend` int(1) NOT NULL,
  `click_url` varchar(400) NOT NULL,
  `sort` int(6) NOT NULL,
  `description` varchar(200) NOT NULL,
  `freeshipment` int(1) NOT NULL,
  `installment` int(1) NOT NULL,
  `has_invoice` int(1) NOT NULL,
  `cash_back_rate` varchar(64) NOT NULL,
  `status` int(1) NOT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_status` (`status`),
  KEY `index_recommend` (`recommend`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_seller_list_cate`
--

CREATE TABLE IF NOT EXISTS `thinkphp_seller_list_cate` (
  `list_id` int(11) NOT NULL,
  `cate_id` int(11) NOT NULL,
  KEY `list_id` (`list_id`),
  KEY `cate_id` (`cate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_setting`
--

CREATE TABLE IF NOT EXISTS `thinkphp_setting` (
  `name` varchar(100) NOT NULL,
  `data` text NOT NULL,
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `thinkphp_setting`
--

INSERT INTO `thinkphp_setting` (`name`, `data`) VALUES
('site_name', 'MobileCms移动后台管理系统'),
('site_title', 'MobileCms移动后台管理系统'),
('site_keyword', 'MobileCms移动后台管理系统，phonegap100.com'),
('site_description', 'MobileCms是一款移动互联网软件后台管理系统，由phonegap100.com 提供'),
('site_status', '1'),
('site_icp', '京ICP备88888888号'),
('statistics_code', ''),
('closed_reason', '升级'),
('site_domain', 'http://localhost/wego25'),
('weibo_url', 'http://www.weibo.com'),
('qqzone_url', ''),
('douban_url', ''),
('attachment_size', '3145728'),
('template', 'default'),
('taobao_app_key', '12504724'),
('qq_app_key', ''),
('qq_app_Secret', ''),
('sina_app_key', '100308089'),
('sina_app_Secret', '25ee4d31ca98edea230885985e1cf2e1'),
('taobao_app_secret', '9d6877190386092d4288dcae32811081'),
('url_model', '0'),
('attachment_path', 'data/uploads'),
('client_hash', ''),
('attachment_type', 'jpg,gif,png,jpeg'),
('miao_appkey', '1003336'),
('miao_appsecret', '0847c5008f99150de65fad8e8ec342fa'),
('mail_smtp', 'smtp.163.com'),
('mail_username', ''),
('mail_password', 'PassWord01!'),
('mail_port', '25'),
('mail_fromname', 'MobileCms'),
('check_code', '1'),
('comment_time', '10'),
('site_share', '<meta property=\\"qc:admins\\" content=\\"271503564761116217636\\" />'),
('ban_sipder', 'youdaobot|bingbot'),
('ban_ip', '192.168.1.50'),
('site_logo', './data/setting/524a5cbde8499.jpg'),
('article_count', '10'),
('html_suffix', '.html'),
('mail_username', 'ho1000003@163.com\r\nho1000004@163.com\r\nho1000005@163.com\r\nhml100000@163.com'),
('mail_receive_username', ''),
('mail_content', '<body style=\\"margin: 10px;\\">\r\n<div align=\\"center\\"><img src=\\"http://www.phonegap100.com/static/image/common/logo.png\\"></div><br>\r\n<br>\r\n <h3>欢迎使用 树根cms 此系统由phonegap中文网 <a href=\\"http://www.phonegap100.com\\" target=\\"_blank\\">phonegap100.com</a>提供 </h3>\r\n<br>\r\n\r\n在使用中遇到任何问题，请到phonegap中文网提出，感谢大家对此程序的支持，我们的qq群：295402925\r\n\r\n</body>'),
('mail_title', '欢迎使用树根cms，这是一封感谢信');

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_user`
--

CREATE TABLE IF NOT EXISTS `thinkphp_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `integral` int(3) DEFAULT NULL,
  `sex` enum('0','1','2') CHARACTER SET utf8 NOT NULL,
  `login_count` int(3) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `ip` varchar(50) DEFAULT '0.0.0.0',
  `last_time` int(11) DEFAULT NULL,
  `last_ip` varchar(50) DEFAULT '0.0.0.0',
  `status` enum('0','1') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `thinkphp_user`
--

INSERT INTO `thinkphp_user` (`id`, `name`, `password`, `email`, `integral`, `sex`, `login_count`, `add_time`, `ip`, `last_time`, `last_ip`, `status`) VALUES
(1, 'tim', '', '', 0, '0', NULL, NULL, '0.0.0.0', NULL, '0.0.0.0', '1'),
(2, 'cg', '', '', 0, '1', NULL, NULL, '0.0.0.0', NULL, '0.0.0.0', '1'),
(3, '太阳猪', '', '3444444@163.com', 0, '0', 0, 1384237243, '0.0.0.0', 0, '0.0.0.0', '1');

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_wf_defination`
--

CREATE TABLE IF NOT EXISTS `thinkphp_wf_defination` (
  `defination_id` int(11) NOT NULL AUTO_INCREMENT,
  `defination_cate_id` int(11) NOT NULL,
  `defination_name` char(50) NOT NULL,
  `defination_handler` text,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`defination_id`),
  KEY `defination_cate_id` (`defination_cate_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `thinkphp_wf_defination`
--

INSERT INTO `thinkphp_wf_defination` (`defination_id`, `defination_cate_id`, `defination_name`, `defination_handler`, `status`) VALUES
(1, 5, '作品订单', 'bill.txt', 1),
(2, 5, '1', '11', 1),
(3, 5, '44', '44', 1),
(4, 6, '3', '3', 1),
(5, 5, '3W4', '2432', 1),
(6, 5, '5', '55', 1);

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_wf_defination_cate`
--

CREATE TABLE IF NOT EXISTS `thinkphp_wf_defination_cate` (
  `defination_cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `defination_cate_name` char(50) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  PRIMARY KEY (`defination_cate_id`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `thinkphp_wf_defination_cate`
--

INSERT INTO `thinkphp_wf_defination_cate` (`defination_cate_id`, `defination_cate_name`, `pid`) VALUES
(5, '订单', 0),
(6, '事务', 0);

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_wf_node`
--

CREATE TABLE IF NOT EXISTS `thinkphp_wf_node` (
  `node_id` int(11) NOT NULL AUTO_INCREMENT,
  `defination_id` int(11) NOT NULL,
  `node_index` int(11) NOT NULL,
  `node_type` enum('1','2','3','4','5','6') DEFAULT NULL,
  `init_function` char(20) DEFAULT NULL,
  `run_function` char(20) DEFAULT NULL,
  `save_function` char(20) DEFAULT NULL,
  `transit_function` varchar(20) DEFAULT NULL,
  `prev_node_index` int(11) DEFAULT NULL,
  `next_node_index` int(11) DEFAULT NULL,
  `executor` char(10) DEFAULT NULL,
  `execute_type` int(2) NOT NULL,
  `remind` enum('0','1','2','3') DEFAULT NULL,
  `field` char(50) DEFAULT NULL,
  `max_day` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`node_id`),
  KEY `defination_id` (`defination_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `thinkphp_wf_node`
--

INSERT INTO `thinkphp_wf_node` (`node_id`, `defination_id`, `node_index`, `node_type`, `init_function`, `run_function`, `save_function`, `transit_function`, `prev_node_index`, `next_node_index`, `executor`, `execute_type`, `remind`, `field`, `max_day`, `status`) VALUES
(6, 1, 1, '1', 'init_function', 'run_function', 'save_bill', 'transit_function', 0, 2, '1', 1, '1', '', 2, 1),
(7, 1, 2, '3', 'init_function', 'run_function', 'save_function', 'transit_function', 1, 3, '2', 1, '1', '', 3, 1),
(8, 1, 3, '1', 'init_function', 'run_function', 'save_function', 'transit_function', 2, 4, '3', 0, '0', '3', 3, 1),
(9, 1, 4, '3', 'init_function', 'run_function', 'save_function', 'transit_function', 3, 5, '4', 0, '0', '4', 4, 1),
(10, 1, 5, '1', 'init_function', 'run_function', 'save_function', 'transit_function', 4, 6, '5', 1, '1', '5', 5, 1),
(11, 1, 6, '1', 'init_function', 'run_function', 'save_function', '6', 6, 6, '6', 0, '0', '6', 6, 1),
(12, 1, 7, '1', 'init_function', 'run_function', 'save_function', 'transit_function', 6, 0, '7', 0, '0', '7', 7, 1);

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_wf_process`
--

CREATE TABLE IF NOT EXISTS `thinkphp_wf_process` (
  `process_id` int(11) NOT NULL AUTO_INCREMENT,
  `defination_id` int(11) NOT NULL,
  `process_desc` char(255) DEFAULT NULL,
  `context` char(100) DEFAULT NULL,
  `current_note_index` int(11) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `finish_time` datetime DEFAULT NULL,
  `status` enum('1','2') DEFAULT NULL,
  `start_user` int(11) NOT NULL,
  PRIMARY KEY (`process_id`),
  KEY `defination_id` (`defination_id`),
  KEY `start_user` (`start_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=164 ;

--
-- 转存表中的数据 `thinkphp_wf_process`
--

INSERT INTO `thinkphp_wf_process` (`process_id`, `defination_id`, `process_desc`, `context`, `current_note_index`, `start_time`, `finish_time`, `status`, `start_user`) VALUES
(140, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 3, '2013-12-20 11:22:04', '2013-12-20 11:22:04', '1', 1),
(141, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 12:15:56', '2013-12-20 12:15:56', '1', 1),
(142, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 14:41:51', '2013-12-20 14:41:51', '1', 1),
(143, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 14:50:09', '2013-12-20 14:50:09', '1', 1),
(144, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 14:51:28', '2013-12-20 14:51:28', '1', 1),
(145, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 14:51:29', '2013-12-20 14:51:29', '1', 1),
(146, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 14:51:38', '2013-12-20 14:51:38', '1', 1),
(147, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 14:51:39', '2013-12-20 14:51:39', '1', 1),
(148, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 14:51:39', '2013-12-20 14:51:39', '1', 1),
(149, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 14:53:05', '2013-12-20 14:53:05', '1', 1),
(150, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 14:53:11', '2013-12-20 14:53:11', '1', 1),
(151, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 14:54:08', '2013-12-20 14:54:08', '1', 1),
(152, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 14:54:17', '2013-12-20 14:54:17', '1', 1),
(153, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 14:54:18', '2013-12-20 14:54:18', '1', 1),
(154, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 14:54:51', '2013-12-20 14:54:51', '1', 1),
(155, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 14:54:52', '2013-12-20 14:54:52', '1', 1),
(156, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 14:55:14', '2013-12-20 14:55:14', '1', 1),
(157, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 14:55:27', '2013-12-20 14:55:27', '1', 1),
(158, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 14:55:28', '2013-12-20 14:55:28', '1', 1),
(159, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 14:55:49', '2013-12-20 14:55:49', '1', 1),
(160, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 14:55:57', '2013-12-20 14:55:57', '1', 1),
(161, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 15:29:48', '2013-12-20 15:29:48', '1', 1),
(162, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 16:19:30', '2013-12-20 16:19:30', '1', 1),
(163, 1, '初始化进程', 'a:1:{s:6:"billid";s:1:"1";}', 1, '2013-12-20 17:04:29', '2013-12-20 17:04:29', '1', 1);

-- --------------------------------------------------------

--
-- 表的结构 `thinkphp_wf_thread`
--

CREATE TABLE IF NOT EXISTS `thinkphp_wf_thread` (
  `thread_id` int(11) NOT NULL AUTO_INCREMENT,
  `process_id` int(11) DEFAULT NULL,
  `node_id` int(11) DEFAULT NULL,
  `executor` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`thread_id`),
  KEY `process_id` (`process_id`),
  KEY `node_id` (`node_id`),
  KEY `executor` (`executor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=138 ;

--
-- 转存表中的数据 `thinkphp_wf_thread`
--

INSERT INTO `thinkphp_wf_thread` (`thread_id`, `process_id`, `node_id`, `executor`, `status`) VALUES
(96, 140, 6, 1, 1),
(97, 140, 7, 1, 2),
(98, 140, 8, 1, 1),
(99, 140, 8, 1, 0),
(100, 140, 8, 1, 0),
(101, 140, 8, 1, 0),
(102, 140, 8, 1, 0),
(103, 141, 6, 1, 0),
(104, 140, 8, 1, 0),
(105, 140, 9, 1, 0),
(106, 140, 9, 1, 0),
(107, 140, 9, 1, 0),
(108, 140, 9, 1, 0),
(109, 140, 9, 1, 0),
(110, 140, 9, 1, 0),
(111, 140, 9, 1, 0),
(112, 140, 9, 1, 0),
(113, 140, 9, 1, 0),
(114, 140, 9, 1, 0),
(115, 142, 6, 1, 0),
(116, 140, 8, 1, 0),
(117, 143, 6, 1, 0),
(118, 144, 6, 1, 0),
(119, 145, 6, 1, 0),
(120, 146, 6, 1, 0),
(121, 147, 6, 1, 0),
(122, 148, 6, 1, 0),
(123, 149, 6, 1, 0),
(124, 150, 6, 1, 0),
(125, 151, 6, 1, 0),
(126, 152, 6, 1, 0),
(127, 153, 6, 1, 0),
(128, 154, 6, 1, 0),
(129, 155, 6, 1, 0),
(130, 156, 6, 1, 0),
(131, 157, 6, 1, 0),
(132, 158, 6, 1, 0),
(133, 159, 6, 1, 0),
(134, 160, 6, 1, 0),
(135, 161, 6, 1, 0),
(136, 162, 6, 1, 0),
(137, 163, 6, 1, 0);

--
-- 限制导出的表
--

--
-- 限制表 `thinkphp_wf_defination`
--
ALTER TABLE `thinkphp_wf_defination`
  ADD CONSTRAINT `thinkphp_wf_defination_ibfk_1` FOREIGN KEY (`defination_cate_id`) REFERENCES `thinkphp_wf_defination_cate` (`defination_cate_id`) ON DELETE CASCADE;

--
-- 限制表 `thinkphp_wf_node`
--
ALTER TABLE `thinkphp_wf_node`
  ADD CONSTRAINT `thinkphp_wf_node_ibfk_1` FOREIGN KEY (`defination_id`) REFERENCES `thinkphp_wf_defination` (`defination_id`);

--
-- 限制表 `thinkphp_wf_process`
--
ALTER TABLE `thinkphp_wf_process`
  ADD CONSTRAINT `thinkphp_wf_process_ibfk_1` FOREIGN KEY (`defination_id`) REFERENCES `thinkphp_wf_defination` (`defination_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `thinkphp_wf_process_ibfk_2` FOREIGN KEY (`start_user`) REFERENCES `thinkphp_user` (`id`) ON DELETE CASCADE;

--
-- 限制表 `thinkphp_wf_thread`
--
ALTER TABLE `thinkphp_wf_thread`
  ADD CONSTRAINT `thinkphp_wf_thread_ibfk_1` FOREIGN KEY (`process_id`) REFERENCES `thinkphp_wf_process` (`process_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `thinkphp_wf_thread_ibfk_2` FOREIGN KEY (`node_id`) REFERENCES `thinkphp_wf_node` (`node_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `thinkphp_wf_thread_ibfk_3` FOREIGN KEY (`executor`) REFERENCES `thinkphp_user` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
