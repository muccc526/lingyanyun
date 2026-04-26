-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_class`
--

CREATE TABLE `qingka_wangke_class` (
  `cid` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '10',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '网课平台名字',
  `getnoun` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '查询参数',
  `noun` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '对接参数',
  `price` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '定价',
  `queryplat` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '查询平台',
  `docking` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '对接平台',
  `yunsuan` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '*' COMMENT '代理费率运算',
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '说明',
  `addtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '添加时间',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态0为下架。1为上架',
  `fenlei` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT '分类',
  `mall_custom` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '商城自定义'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_code`
--

CREATE TABLE `qingka_wangke_code` (
  `id` int(11) NOT NULL,
  `vercode` varchar(6) DEFAULT NULL,
  `time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_config`
--

CREATE TABLE `qingka_wangke_config` (
  `v` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `k` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `qingka_wangke_config`
--

INSERT INTO `qingka_wangke_config` (`v`, `k`) VALUES
('akcookie', '7321sPn6n+Yt9tGs1wy7f2ULOKbENP2W/J83w50jYbpDpQEXjkGRJnZOlXPY7XeOX5zCSU6vfhOLJSoKLMeWQ7cv9ghbEsFowYoCzQ'),
('api_ck', '10'),
('api_proportion', '20'),
('api_tongb', '1'),
('api_tongbc', '3'),
('api_xd', '10'),
('description', '凌烟云'),
('dklcookie', 'd1abUN9efprWp3E93jrzR27IaTDLsmnV7AGLOb+rPKLrml1YDKRVBgXW0JxsfktUYm/Ym/Sk9J4eJiLfEdoPFXgKRuy/vtoV4YXYuRkarpydLsoeMgp93qAWuTWF9vRdk4xdew4QGgPIt/LzbMnUsDOHq/u5HGrnMhU8wbD35T/47sGC5cCVzGlGK565qMhH3kUzazhgiEoEpDJNAOFXttowDLKM+6G1iAApLyUNDxP7rluq383FyGxO3tcYR4VVuTEJA1V0LTNTOzhq8TJXl0l/hGE6JfDmLkDo4piWok2lnG5VTzYdMf6AJYSHwO+W4P2rAxgd3augn/kkJUfvxRiWZWPoddS4n0n1kRpIJrBNgTWuE3U9EQqxIMMwMWLI3IZvP0NZE/Nl0yqyFg'),
('email_pass', '123456'),
('email_port', '465'),
('email_service', 'smtp.qq.com'),
('email_url', 'https://baidu.com'),
('email_user', '123456@qq.com'),
('epay_api', 'http://pay.111wk.cn/'),
('epay_key', ''),
('epay_pid', '1000'),
('flkg', '1'),
('fllx', '2'),
('is_alipay', '1'),
('is_qqpay', '0'),
('is_wxpay', '0'),
('keywords', '凌烟云'),
('khkg', '1'),
('khyue', '1000'),
('login_appid', ''),
('nanatoken', '14cen/DXBsnMXkKPE50giKP/KmWGgIwn/B2sdw9z+b7zL2riFzG2mvyb04YP/xdD5w5h8uvXIKwjCo7AIF3QgzvCoiOdJfK+a9IdjpFcb2mSpzqGg9jRrEeFOomuokkA0F971RhK'),
('notice', '<div class=\"layui-timeline-item\">\r\n    <i class=\"layui-icon layui-timeline-axis layui-icon-face-smile\"></i>\r\n    <div class=\"layui-timeline-content layui-text\">\r\n      <div class=\"layui-timeline-title\">平台状态永远只是辅助工具。具体课刷没刷完，自行计算好时间后，再亲自上号查询后核实。并不是无状态更新，或者状态不动，就是不走单！</div>\r\n    </div>\r\n  </div>\r\n  <div class=\"layui-timeline-item\">\r\n    <i class=\"layui-icon layui-timeline-axis layui-icon-fire\"></i>\r\n    <div class=\"layui-timeline-content layui-text\">\r\n      <div class=\"layui-timeline-title\">平台全对接无自营，非本站问题，不退不换，谨慎充值，下单前请先测试</div>\r\n    </div>\r\n  </div>\r\n  <div class=\"layui-timeline-item\">\r\n    <i class=\"layui-icon layui-timeline-axis layui-icon-release\"></i>\r\n    <div class=\"layui-timeline-content layui-text\">\r\n      <div class=\"layui-timeline-title\">正常接单请勿低价，自觉维持市场秩序，利人利己</div>\r\n    </div>\r\n  </div>\r\n</div>\r\n  <div class=\"layui-timeline-item\">\r\n    <i class=\"layui-icon layui-timeline-axis layui-icon-notice\"></i>\r\n    <div class=\"layui-timeline-content layui-text\">\r\n      <div class=\"layui-timeline-title\">客户进度查询地址①：<a href=\"http://本站域名/get\"  target=\"_blank\">http://本站域名/get</a>（自行修改【本站域名】）</div>\r\n    </div>\r\n  </div>\r\n</div>\r\n  <div class=\"layui-timeline-item\">\r\n    <i class=\"layui-icon layui-timeline-axis layui-icon-close\"></i>\r\n    <div class=\"layui-timeline-content layui-text\">\r\n      <div class=\"layui-timeline-title\">禁止在公众社交娱乐等平台（如抖音、快手等）发布本平台相关内容</div>\r\n    </div>\r\n  </div>\r\n</div>\r\n  <div class=\"layui-timeline-item\">\r\n    <i class=\"layui-icon layui-timeline-axis layui-icon-survey\"></i>\r\n    <div class=\"layui-timeline-content layui-text\">\r\n      <div class=\"layui-timeline-title\">请勿随意欺压下级代理，下级代理被无故欺压可携带证据用工单反馈。</div>\r\n    </div>\r\n  </div>\r\n</div>\r\n  <div class=\"layui-timeline-item\">\r\n    <i class=\"layui-icon layui-timeline-axis layui-icon-loading\"></i>\r\n    <div class=\"layui-timeline-content layui-text\">\r\n      <div class=\"layui-timeline-title\">违反上述规定者，包括但不仅限于有相关影响平台利益的，都会进行封号处理！</div>\r\n    </div>\r\n  </div>\r\n</div>'),
('settings', '1'),
('sign_in_limit', '10'),
('sign_in_max', '1'),
('sign_in_min', '0.1'),
('sign_in_switch', '1'),
('sitename', '凌烟云'),
('sjqykg', '1'),
('sykg', '0'),
('tcgonggao', '上架XXXXXXXXXXXX<br>\r\n上架XXXXXXXXXXXX<br>\r\n修复XXXXXXXXXXXX<br>\r\n通知群：XXXXXXXX\r\n'),
('tongzhidizhi', '1'),
('user_htkh', '1'),
('user_ktmoney', '0'),
('user_yqzc', '1'),
('yzmkg', '1'),
('zdpay', '10'),
('zxczkg', '1');

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_czk`
--

CREATE TABLE `qingka_wangke_czk` (
  `id` int(11) NOT NULL,
  `card` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `addtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `endtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usetime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uid` varchar(11) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_dengji`
--

CREATE TABLE `qingka_wangke_dengji` (
  `id` int(11) NOT NULL,
  `sort` varchar(11) NOT NULL,
  `name` varchar(11) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `addkf` varchar(11) NOT NULL,
  `gjkf` varchar(11) NOT NULL,
  `status` varchar(11) NOT NULL,
  `time` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `qingka_wangke_dengji`
--

INSERT INTO `qingka_wangke_dengji` (`id`, `sort`, `name`, `rate`, `money`, `addkf`, `gjkf`, `status`, `time`) VALUES
(4, '0', '顶级代理', '0.20', '999.00', '1', '1', '1', '2024-12-01 '),
(5, '1', '二级代理', '0.25', '20.00', '1', '1', '1', '2024-12-01 '),
(6, '1', '三级代理', '0.45', '999.00', '1', '1', '1', '2024-12-01 '),
(7, '1', '四级代理', '0.80', '999.00', '1', '1', '1', '2024-12-01 '),
(8, '1', '普通代理', '1.00', '999.00', '1', '1', '1', '2024-12-01 ');

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_fenlei`
--

CREATE TABLE `qingka_wangke_fenlei` (
  `id` int(11) NOT NULL,
  `sort` varchar(11) NOT NULL DEFAULT '0',
  `name` varchar(11) NOT NULL,
  `status` varchar(11) NOT NULL,
  `time` varchar(11) NOT NULL,
  `hid` int(11) NOT NULL COMMENT '货源ID',
  `fenlei` int(11) NOT NULL COMMENT '分类ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_gongdan`
--

CREATE TABLE `qingka_wangke_gongdan` (
  `gid` int(11) NOT NULL,
  `uid` int(3) NOT NULL,
  `region` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '工单类型',
  `title` text COLLATE utf8_unicode_ci NOT NULL COMMENT '工单标题',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '工单内容',
  `answer` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '工单回复',
  `state` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT '工单状态',
  `addtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_gonggao`
--

CREATE TABLE `qingka_wangke_gonggao` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `time` text NOT NULL,
  `uid` int(11) NOT NULL,
  `status` varchar(11) NOT NULL COMMENT '状态',
  `zhiding` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `qingka_wangke_gonggao`
--

INSERT INTO `qingka_wangke_gonggao` (`id`, `title`, `content`, `time`, `uid`, `status`, `zhiding`) VALUES
(1, '注意事项', '<div class=\"layui-timeline-item\">\n    <i class=\"layui-icon layui-timeline-axis layui-icon-face-smile\"></i>\n    <div class=\"layui-timeline-content layui-text\">\n      <div class=\"layui-timeline-title\">平台状态永远只是辅助工具。具体课刷没刷完，自行计算好时间后，再亲自上号查询后核实。并不是无状态更新，或者状态不动，就是不走单！</div>\n    </div>\n  </div>\n  <div class=\"layui-timeline-item\">\n    <i class=\"layui-icon layui-timeline-axis layui-icon-fire\"></i>\n    <div class=\"layui-timeline-content layui-text\">\n      <div class=\"layui-timeline-title\">平台全对接无自营，非本站问题，不退不换，谨慎充值，下单前请先测试</div>\n    </div>\n  </div>\n  <div class=\"layui-timeline-item\">\n    <i class=\"layui-icon layui-timeline-axis layui-icon-release\"></i>\n    <div class=\"layui-timeline-content layui-text\">\n      <div class=\"layui-timeline-title\">正常接单请勿低价，自觉维持市场秩序，利人利己</div>\n    </div>\n  </div>\n</div>\n  <div class=\"layui-timeline-item\">\n    <i class=\"layui-icon layui-timeline-axis layui-icon-notice\"></i>\n    <div class=\"layui-timeline-content layui-text\">\n      <div class=\"layui-timeline-title\">客户进度查询地址①：<a href=\"http://本站域名/get\"  target=\"_blank\">http://本站域名/get</a>（自行修改【本站域名】）</div>\n    </div>\n  </div>\n</div>\n  <div class=\"layui-timeline-item\">\n    <i class=\"layui-icon layui-timeline-axis layui-icon-close\"></i>\n    <div class=\"layui-timeline-content layui-text\">\n      <div class=\"layui-timeline-title\">禁止在公众社交娱乐等平台（如抖音、快手等）发布本平台相关内容</div>\n    </div>\n  </div>\n</div>\n  <div class=\"layui-timeline-item\">\n    <i class=\"layui-icon layui-timeline-axis layui-icon-survey\"></i>\n    <div class=\"layui-timeline-content layui-text\">\n      <div class=\"layui-timeline-title\">请勿随意欺压下级代理，下级代理被无故欺压可携带证据用工单反馈。</div>\n    </div>\n  </div>\n</div>\n  <div class=\"layui-timeline-item\">\n    <i class=\"layui-icon layui-timeline-axis layui-icon-loading\"></i>\n    <div class=\"layui-timeline-content layui-text\">\n      <div class=\"layui-timeline-title\">违反上述规定者，包括但不仅限于有相关影响平台利益的，都会进行封号处理！</div>\n    </div>\n  </div>\n</div>', '2024-12-01 12:00:00', 1, '1', '1'),
(2, '上架通知', '\n    <div class=\"layui-timeline-content layui-text\">\n      <ul>\n        <li>上架XXXXXXXXXXXX</li>\n        <li>上架XXXXXXXXXXXX</li>\n        <li>修复XXXXXXXXXXXX</li>\n      </ul>\n    </div>\n  </div>', '2024-12-01 12:00:00', 1, '1', '0');

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_huodong`
--

CREATE TABLE `qingka_wangke_huodong` (
  `hid` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '活动名字',
  `yaoqiu` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '要求',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '1为邀人活动 2为订单活动',
  `num` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '要求数量',
  `money` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '奖励',
  `addtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '活动开始时间',
  `endtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '活动结束时间',
  `status_ok` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1为正常 2为结束',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1为进行中  2为待领取 3为已完成'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_huoyuan`
--

CREATE TABLE `qingka_wangke_huoyuan` (
  `hid` int(11) NOT NULL,
  `pt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '不带http 顶级',
  `user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cookie` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `money` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `addtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `endtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `warning` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_km`
--

CREATE TABLE `qingka_wangke_km` (
  `id` int(11) NOT NULL COMMENT '卡密id',
  `pid` varchar(255) DEFAULT NULL COMMENT '批次ID',
  `content` varchar(255) NOT NULL COMMENT '卡密内容',
  `money` int(11) NOT NULL COMMENT '卡密金额',
  `status` int(11) DEFAULT NULL COMMENT '卡密状态',
  `uid` int(11) DEFAULT NULL COMMENT '使用者id',
  `addtime` varchar(255) DEFAULT NULL COMMENT '添加时间',
  `usedtime` varchar(255) DEFAULT NULL COMMENT '使用时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_log`
--

CREATE TABLE `qingka_wangke_log` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `money` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smoney` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_mijia`
--

CREATE TABLE `qingka_wangke_mijia` (
  `mid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `mode` int(11) NOT NULL COMMENT '0.价格的基础上扣除 1.倍数的基础上扣除 2.直接定价',
  `price` varchar(100) NOT NULL,
  `addtime` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_order`
--

CREATE TABLE `qingka_wangke_order` (
  `oid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `cid` int(11) NOT NULL COMMENT '平台ID',
  `hid` int(11) NOT NULL COMMENT '接口ID',
  `yid` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '对接站ID',
  `ptname` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '平台名字',
  `school` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '学校',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '姓名',
  `user` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '账号',
  `pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '手机号',
  `kcid` text COLLATE utf8_unicode_ci NOT NULL COMMENT '课程ID',
  `kcname` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '课程名字',
  `courseStartTime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '课程开始时间',
  `courseEndTime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '课程结束时间',
  `examStartTime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '考试开始时间',
  `examEndTime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '考试结束时间',
  `chapterCount` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '总章数',
  `unfinishedChapterCount` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '剩余章数',
  `cookie` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'cookie',
  `fees` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '扣费',
  `noun` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '对接标识',
  `miaoshua` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '0不秒 1秒',
  `addtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '添加时间',
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '下单ip',
  `dockstatus` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '对接状态 0待 1成  2失 3重复 4取消',
  `loginstatus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '待处理',
  `process` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bsnum` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '补刷次数',
  `remarks` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '备注',
  `score` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT '分数',
  `shichang` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT '时长',
  `laststatus` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tuisongtoken` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shoujia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '商城售价',
  `out_trade_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '订单交易号',
  `paytime` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '支付时间',
  `payUser` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '支付用户',
  `type` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '支付类型',
  `pushUid` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '微信推送用户ID',
  `pushStatus` tinyint(4) NOT NULL DEFAULT '0' COMMENT '推送状态:0-未推送,1-已推送'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `qingka_wangke_order`
--

INSERT INTO `qingka_wangke_order` (`oid`, `uid`, `cid`, `hid`, `yid`, `ptname`, `school`, `name`, `user`, `pass`, `phone`, `kcid`, `kcname`, `courseStartTime`, `courseEndTime`, `examStartTime`, `examEndTime`, `chapterCount`, `unfinishedChapterCount`, `cookie`, `fees`, `noun`, `miaoshua`, `addtime`, `ip`, `dockstatus`, `loginstatus`, `status`, `process`, `bsnum`, `remarks`, `score`, `shichang`, `laststatus`, `tuisongtoken`, `shoujia`, `out_trade_no`, `paytime`, `payUser`, `type`, `pushUid`, `pushStatus`) VALUES
(1, 1, 124, 1, '', '【龙龙】超星学习通阅读', '自动识别', '', '15170294554', 'zdf15170294554@', '', '233684579|118621974', '大学计算机基础', '', '', '', '', '', '', '', '0.12', '6622', '', '2025-06-14 19:23:37', '45.207.201.89', '1', '', '进行中', '', '0', '', '', '', NULL, NULL, '', '', '', '', '', NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_pay`
--

CREATE TABLE `qingka_wangke_pay` (
  `oid` int(11) NOT NULL,
  `out_trade_no` varchar(64) NOT NULL,
  `trade_no` varchar(100) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `uid` int(11) NOT NULL,
  `num` int(11) NOT NULL DEFAULT '1',
  `addtime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `money` varchar(32) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `domain` varchar(64) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `money2` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '第二笔金额',
  `payUser` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '支付用户'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_push_logs`
--

CREATE TABLE `qingka_wangke_push_logs` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `uid` varchar(255) DEFAULT NULL,
  `content` text,
  `status` enum('成功','失败') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_user`
--

CREATE TABLE `qingka_wangke_user` (
  `uid` int(11) NOT NULL,
  `uuid` int(11) NOT NULL,
  `user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `zcz` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `addprice` decimal(10,2) NOT NULL DEFAULT '1.00' COMMENT '加价',
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `yqm` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '邀请码',
  `yqprice` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '邀请单价',
  `notice` text COLLATE utf8_unicode_ci NOT NULL,
  `addtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '添加时间',
  `endtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grade` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `tuisongtoken` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '推送Token',
  `yctzkg` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '订单异常开关',
  `wctzkg` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '订单完成开关',
  `dltzkg` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '后台登陆开关',
  `sjtzkg` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '每日数据开关',
  `dlzctzkg` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '代理注册开关',
  `tktzkg` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '退款通知开关',
  `dlsbtzkg` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '登陆失败开关',
  `czcgtzkg` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '充值成功开关',
  `xgmmtzkg` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '修改密码开关',
  `tourist` int(2) DEFAULT '0' COMMENT '商城开启与否',
  `paydata` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '支付数据',
  `onlineStore_add` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '价格倍数增幅',
  `touristdata` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '客服配置',
  `t_jdscmoney` text COLLATE utf8_unicode_ci NOT NULL,
  `last_sign_in_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `qingka_wangke_user`
--

INSERT INTO `qingka_wangke_user` (`uid`, `uuid`, `user`, `pass`, `name`, `money`, `zcz`, `addprice`, `key`, `yqm`, `yqprice`, `notice`, `addtime`, `endtime`, `grade`, `active`, `tuisongtoken`, `yctzkg`, `wctzkg`, `dltzkg`, `sjtzkg`, `dlzctzkg`, `tktzkg`, `dlsbtzkg`, `czcgtzkg`, `xgmmtzkg`, `tourist`, `paydata`, `onlineStore_add`, `touristdata`, `t_jdscmoney`, `last_sign_in_date`) VALUES
(1, 1, 'admin', '123456', '凌烟云', '99999.47', '99999.59', '0.20', '88S4onq384NmfK30', '0000', '0.2', '低调发展，低调开户', '', '', '', '1', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '', NULL, '', '2025-06-13');

--
-- 转储表的索引
--

--
-- 表的索引 `qingka_wangke_class`
--
ALTER TABLE `qingka_wangke_class`
  ADD PRIMARY KEY (`cid`);

--
-- 表的索引 `qingka_wangke_code`
--
ALTER TABLE `qingka_wangke_code`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `qingka_wangke_config`
--
ALTER TABLE `qingka_wangke_config`
  ADD UNIQUE KEY `v` (`v`);

--
-- 表的索引 `qingka_wangke_czk`
--
ALTER TABLE `qingka_wangke_czk`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `qingka_wangke_dengji`
--
ALTER TABLE `qingka_wangke_dengji`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `qingka_wangke_fenlei`
--
ALTER TABLE `qingka_wangke_fenlei`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `qingka_wangke_gongdan`
--
ALTER TABLE `qingka_wangke_gongdan`
  ADD PRIMARY KEY (`gid`);

--
-- 表的索引 `qingka_wangke_gonggao`
--
ALTER TABLE `qingka_wangke_gonggao`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `qingka_wangke_huodong`
--
ALTER TABLE `qingka_wangke_huodong`
  ADD PRIMARY KEY (`hid`);

--
-- 表的索引 `qingka_wangke_huoyuan`
--
ALTER TABLE `qingka_wangke_huoyuan`
  ADD PRIMARY KEY (`hid`);

--
-- 表的索引 `qingka_wangke_km`
--
ALTER TABLE `qingka_wangke_km`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `qingka_wangke_log`
--
ALTER TABLE `qingka_wangke_log`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `qingka_wangke_mijia`
--
ALTER TABLE `qingka_wangke_mijia`
  ADD PRIMARY KEY (`mid`);

--
-- 表的索引 `qingka_wangke_order`
--
ALTER TABLE `qingka_wangke_order`
  ADD PRIMARY KEY (`oid`);

--
-- 表的索引 `qingka_wangke_pay`
--
ALTER TABLE `qingka_wangke_pay`
  ADD PRIMARY KEY (`oid`);

--
-- 表的索引 `qingka_wangke_push_logs`
--
ALTER TABLE `qingka_wangke_push_logs`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `qingka_wangke_user`
--
ALTER TABLE `qingka_wangke_user`
  ADD PRIMARY KEY (`uid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `qingka_wangke_class`
--
ALTER TABLE `qingka_wangke_class`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_code`
--
ALTER TABLE `qingka_wangke_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_czk`
--
ALTER TABLE `qingka_wangke_czk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_dengji`
--
ALTER TABLE `qingka_wangke_dengji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_fenlei`
--
ALTER TABLE `qingka_wangke_fenlei`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_gongdan`
--
ALTER TABLE `qingka_wangke_gongdan`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_gonggao`
--
ALTER TABLE `qingka_wangke_gonggao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_huodong`
--
ALTER TABLE `qingka_wangke_huodong`
  MODIFY `hid` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_huoyuan`
--
ALTER TABLE `qingka_wangke_huoyuan`
  MODIFY `hid` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_km`
--
ALTER TABLE `qingka_wangke_km`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '卡密id';

--
-- 使用表AUTO_INCREMENT `qingka_wangke_log`
--
ALTER TABLE `qingka_wangke_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_mijia`
--
ALTER TABLE `qingka_wangke_mijia`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_order`
--
ALTER TABLE `qingka_wangke_order`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_pay`
--
ALTER TABLE `qingka_wangke_pay`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_push_logs`
--
ALTER TABLE `qingka_wangke_push_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_user`
--
ALTER TABLE `qingka_wangke_user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
