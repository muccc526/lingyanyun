CREATE TABLE IF NOT EXISTS `qingka_custom_goods_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `baseurl` varchar(255) NOT NULL DEFAULT '' COMMENT '上游接口地址',
  `uid` varchar(64) NOT NULL DEFAULT '' COMMENT '上游UID',
  `api_key` varchar(255) NOT NULL DEFAULT '' COMMENT '上游KEY',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `addtime` varchar(100) NOT NULL DEFAULT '',
  `updatetime` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `qingka_custom_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upstream_cid` varchar(64) NOT NULL DEFAULT '' COMMENT '上游商品ID',
  `name` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `input_config` text NOT NULL,
  `upstream_price` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `price` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `yunsuan` varchar(8) NOT NULL DEFAULT '*',
  `sort` int(11) NOT NULL DEFAULT '10',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `addtime` varchar(100) NOT NULL DEFAULT '',
  `updatetime` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `upstream_cid` (`upstream_cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `qingka_custom_goods_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `goods_id` int(11) NOT NULL DEFAULT '0',
  `upstream_cid` varchar(64) NOT NULL DEFAULT '',
  `upstream_oid` varchar(100) NOT NULL DEFAULT '',
  `input_data` text NOT NULL,
  `quantity` decimal(10,4) NOT NULL DEFAULT '1.0000',
  `unit_price` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `total_price` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `upstream_price` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `status` varchar(100) NOT NULL DEFAULT '待处理',
  `process` varchar(255) NOT NULL DEFAULT '',
  `remarks` text NOT NULL,
  `addtime` varchar(100) NOT NULL DEFAULT '',
  `updatetime` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `goods_id` (`goods_id`),
  KEY `upstream_oid` (`upstream_oid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
