/*
Navicat MySQL Data Transfer

Source Server         : 192.168.1.165
Source Server Version : 50548
Source Host           : 192.168.1.165:3306
Source Database       : sxh

Target Server Type    : MYSQL
Target Server Version : 50548
File Encoding         : 65001

Date: 2016-11-23 22:11:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dts_increment_trx
-- ----------------------------
DROP TABLE IF EXISTS `dts_increment_trx`;
CREATE TABLE `dts_increment_trx` (
  `job_id` char(32) NOT NULL,
  `partition` int(11) NOT NULL,
  `checkpoint` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`job_id`,`partition`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='DTS迁移位点表,请勿轻易删除!';

-- ----------------------------
-- Records of dts_increment_trx
-- ----------------------------

-- ----------------------------
-- Table structure for old_shop_jifen
-- ----------------------------
DROP TABLE IF EXISTS `old_shop_jifen`;
CREATE TABLE `old_shop_jifen` (
  `uid` int(11) DEFAULT NULL,
  `uname` varchar(255) DEFAULT NULL,
  `sum_jifen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of old_shop_jifen
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_action
-- ----------------------------
DROP TABLE IF EXISTS `sxh_action`;
CREATE TABLE `sxh_action` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` char(30) NOT NULL COMMENT '标识',
  `title` char(80) NOT NULL COMMENT '标题',
  `remark` char(140) NOT NULL COMMENT '描述',
  `rule` text NOT NULL COMMENT '行为规则',
  `log` text NOT NULL COMMENT '日志规则',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统行为表';

-- ----------------------------
-- Records of sxh_action
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_action_log
-- ----------------------------
DROP TABLE IF EXISTS `sxh_action_log`;
CREATE TABLE `sxh_action_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `action_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '行为id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行用户id',
  `action_ip` bigint(20) NOT NULL COMMENT '执行行为者ip',
  `model` varchar(50) NOT NULL DEFAULT '' COMMENT '触发行为的表',
  `record_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '触发行为的数据id',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '日志备注',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行行为的时间',
  PRIMARY KEY (`id`),
  KEY `action_ip_ix` (`action_ip`),
  KEY `action_id_ix` (`action_id`),
  KEY `user_id_ix` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='行为日志表';

-- ----------------------------
-- Records of sxh_action_log
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_auth_cgroup
-- ----------------------------
DROP TABLE IF EXISTS `sxh_auth_cgroup`;
CREATE TABLE `sxh_auth_cgroup` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(80) NOT NULL COMMENT '用户组中文名称',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
  `rules` text NOT NULL COMMENT '用户组拥有的规则id， 多个规则","隔开',
  `sort` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='think_auth_group 用户组表， id：主键， title:用户组中文名称， rules：用';

-- ----------------------------
-- Records of sxh_auth_cgroup
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_auth_cgroup_access
-- ----------------------------
DROP TABLE IF EXISTS `sxh_auth_cgroup_access`;
CREATE TABLE `sxh_auth_cgroup_access` (
  `uid` mediumint(8) unsigned NOT NULL COMMENT '用户id',
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户组明细表';

-- ----------------------------
-- Records of sxh_auth_cgroup_access
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_auth_crule
-- ----------------------------
DROP TABLE IF EXISTS `sxh_auth_crule`;
CREATE TABLE `sxh_auth_crule` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` varchar(200) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `icon` varchar(100) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `show_type` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `hide` tinyint(2) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `condition` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of sxh_auth_crule
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `sxh_auth_group`;
CREATE TABLE `sxh_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(80) NOT NULL COMMENT '用户组中文名称',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
  `rules` text NOT NULL COMMENT '用户组拥有的规则id， 多个规则","隔开',
  `sort` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='think_auth_group 用户组表， id：主键， title:用户组中文名称， rules：用';

-- ----------------------------
-- Records of sxh_auth_group
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `sxh_auth_group_access`;
CREATE TABLE `sxh_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL COMMENT '用户id',
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户组明细表';

-- ----------------------------
-- Records of sxh_auth_group_access
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `sxh_auth_rule`;
CREATE TABLE `sxh_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` varchar(200) DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `icon` varchar(100) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `show_type` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `hide` tinyint(2) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `condition` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of sxh_auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_config
-- ----------------------------
DROP TABLE IF EXISTS `sxh_config`;
CREATE TABLE `sxh_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置标题',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组',
  `extra` text NOT NULL COMMENT '配置参数',
  `remark` varchar(100) NOT NULL COMMENT '说明',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` int(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `value` text NOT NULL COMMENT '配置值',
  `sort` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `type` (`type`),
  KEY `group` (`group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of sxh_config
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_manage_working_log
-- ----------------------------
DROP TABLE IF EXISTS `sxh_manage_working_log`;
CREATE TABLE `sxh_manage_working_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL DEFAULT '0' COMMENT '操作者ID',
  `customerId` int(11) NOT NULL DEFAULT '0' COMMENT '被处理的用户ID,没有用户ID 存0',
  `logType` int(2) NOT NULL DEFAULT '0' COMMENT '日志类型',
  `logTxt` varchar(250) NOT NULL DEFAULT '' COMMENT '日志描述',
  `isComp` int(1) DEFAULT '0' COMMENT ' 是否为企业模块',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '操作时间',
  `Username` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员用户名',
  `CustomerName` varchar(50) NOT NULL DEFAULT '' COMMENT '被操作帐户的用户名',
  `Ipaddress` int(11) NOT NULL DEFAULT '0' COMMENT '操作管理员IP',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of sxh_manage_working_log
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_message
-- ----------------------------
DROP TABLE IF EXISTS `sxh_message`;
CREATE TABLE `sxh_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `send_from_id` varchar(30) NOT NULL DEFAULT '0',
  `send_to_id` varchar(30) NOT NULL DEFAULT '0',
  `outbox` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '发件箱',
  `inbox` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '收件箱',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `message_time` int(10) unsigned NOT NULL DEFAULT '0',
  `subject` char(80) DEFAULT NULL,
  `content` text NOT NULL,
  `replyid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `msgtoid` (`send_to_id`,`inbox`),
  KEY `replyid` (`replyid`),
  KEY `folder` (`send_from_id`,`inbox`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of sxh_message
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_model
-- ----------------------------
DROP TABLE IF EXISTS `sxh_model`;
CREATE TABLE `sxh_model` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` char(30) NOT NULL COMMENT '标识',
  `title` char(30) NOT NULL COMMENT '名称',
  `table_name` varchar(50) NOT NULL COMMENT '表名',
  `is_extend` varchar(10) NOT NULL DEFAULT '0' COMMENT '允许子模型',
  `extend` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '继承的模型',
  `list_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '列表类型',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `sort` tinyint(2) NOT NULL DEFAULT '1',
  `engine_type` varchar(25) NOT NULL DEFAULT 'MyISAM' COMMENT '数据库引擎',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文档模型表';

-- ----------------------------
-- Records of sxh_model
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_model_field
-- ----------------------------
DROP TABLE IF EXISTS `sxh_model_field`;
CREATE TABLE `sxh_model_field` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型id',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '字段名',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '字段注释',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '数据类型',
  `field` varchar(100) NOT NULL COMMENT '字段定义',
  `value` varchar(100) NOT NULL DEFAULT '' COMMENT '字段默认值',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `extra` text NOT NULL COMMENT '参数',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `sort_l` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '列表',
  `sort_s` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '搜索',
  `sort_a` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '新增',
  `sort_e` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '修改',
  `l_width` varchar(10) NOT NULL DEFAULT '100' COMMENT '列表宽度',
  `field_group` varchar(5) NOT NULL DEFAULT '1' COMMENT '字段分组',
  `validate_rule` text NOT NULL COMMENT '验证规则',
  `auto_rule` text NOT NULL COMMENT '完成规则',
  `create_time` int(11) unsigned NOT NULL COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `model_id` (`model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='模型字段表';

-- ----------------------------
-- Records of sxh_model_field
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user`;
CREATE TABLE `sxh_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `username` varchar(64) NOT NULL COMMENT '用户名 唯一不能重复',
  `nickname` varchar(50) NOT NULL COMMENT '昵称/姓名',
  `password` char(32) NOT NULL COMMENT '登录密码',
  `secondarypassword` char(32) NOT NULL COMMENT '二级密码',
  `last_login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `last_login_ip` varchar(40) NOT NULL COMMENT '上次登录IP',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '余额',
  `point` tinyint(8) unsigned NOT NULL DEFAULT '0' COMMENT '审核权限',
  `vip` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT 'vip等级',
  `overduedate` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'vip到期时间',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0未激活 1激活',
  `verify` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '资料审核 0未审核 1审核',
  `info` text NOT NULL COMMENT '信息',
  `poorid` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '特困会员',
  `is_withdraw` tinyint(2) DEFAULT '0' COMMENT '接单提款权限',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '后台禁用标识',
  `is_commpany` tinyint(1) NOT NULL DEFAULT '0' COMMENT '标识是否企业用户；1-企业用户 0-个人用户',
  `IsMerchants` int(1) DEFAULT '0' COMMENT '是否是招商员',
  `user_token` varchar(255) DEFAULT NULL COMMENT '融云token',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COMMENT='后台用户表';

-- ----------------------------
-- Records of sxh_user
-- ----------------------------
INSERT INTO `sxh_user` VALUES ('1', 'test1', '', '', '', '1479696734', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '0', '1479696734', '1479908680', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('2', 'test2', '', '', '', '1479696789', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696789', '1479907728', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('3', 'test3', '', '', '', '1479696790', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '1', '1479696790', '1479907344', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('4', 'test4', '', '', '', '1479696790', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '0', '1479696790', '1479906082', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('5', 'test5', '', '', '', '1479696790', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '1', '1479696790', '1479908266', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('6', 'test6', '', '', '', '1479696790', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '0', '', '0', '1', '1479696790', '1479907131', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('7', 'test7', '', '', '', '1479696790', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696790', '1479907194', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('8', 'test8', '', '', '', '1479696790', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '0', '', '0', '0', '1479696790', '1479907213', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('9', 'test9', '', '', '', '1479696790', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '0', '', '0', '1', '1479696790', '1479907226', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('10', 'test10', '', '', '', '1479696791', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '0', '1479696791', '1479907155', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('11', 'test11', '', '', '', '1479696791', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '0', '1479696791', '1479906471', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('12', 'test12', '', '', '', '1479696791', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '0', '', '0', '1', '1479696791', '1479907244', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('13', 'test13', '', '', '', '1479696791', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696791', '1479907144', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('14', 'test14', '', '', '', '1479696791', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '0', '', '0', '0', '1479696791', '1479907470', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('15', 'test15', '', '', '', '1479696791', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '0', '', '0', '0', '1479696791', '1479907093', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('16', 'test16', '', '', '', '1479696792', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696792', '1479903168', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('17', 'test17', '', '', '', '1479696792', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '0', '', '0', '1', '1479696792', '1479907525', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('18', 'test18', '', '', '', '1479696792', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '0', '', '0', '0', '1479696792', '1479903408', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('19', 'test19', '', '', '', '1479696792', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696792', '1479906483', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('20', 'test20', '', '', '', '1479696792', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '0', '', '0', '1', '1479696792', '1479907533', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('21', 'test21', '', '', '', '1479696792', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696792', '1479902179', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('22', 'test22', '', '', '', '1479696793', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '1', '1479696793', '1479893529', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('23', 'test23', '', '', '', '1479696793', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '1', '1479696793', '1479902194', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('24', 'test24', '', '', '', '1479696793', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696793', '1479893290', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('25', 'test25', '', '', '', '1479696793', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696793', '1479696793', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('26', 'test26', '', '', '', '1479696793', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696793', '1479907301', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('27', 'test27', '', '', '', '1479696793', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '0', '1479696793', '1479696793', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('28', 'test28', '', '', '', '1479696793', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696793', '1479902001', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('29', 'test29', '', '', '', '1479696794', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '0', '1479696794', '1479696794', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('30', 'test30', '', '', '', '1479696794', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696794', '1479696794', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('31', 'test31', '', '', '', '1479696794', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '0', '', '0', '0', '1479696794', '1479696794', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('32', 'test32', '', '', '', '1479696794', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '0', '1479696794', '1479907553', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('33', 'test33', '', '', '', '1479696794', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '0', '', '0', '1', '1479696794', '1479696794', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('34', 'test34', '', '', '', '1479696794', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696794', '1479902353', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('35', 'test35', '', '', '', '1479696795', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '0', '', '0', '0', '1479696795', '1479696795', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('36', 'test36', '', '', '', '1479696795', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '0', '', '0', '1', '1479696795', '1479696795', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('37', 'test37', '', '', '', '1479696795', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696795', '1479696795', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('38', 'test38', '', '', '', '1479696795', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '0', '', '0', '1', '1479696795', '1479696795', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('39', 'test39', '', '', '', '1479696795', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '1', '1479696795', '1479696795', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('40', 'test40', '', '', '', '1479696795', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '0', '', '0', '0', '1479696795', '1479907545', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('41', 'test41', '', '', '', '1479696795', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696795', '1479892829', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('42', 'test42', '', '', '', '1479696796', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696796', '1479892844', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('43', 'test43', '', '', '', '1479696796', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696796', '1479909329', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('44', 'test44', '', '', '', '1479696796', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '1', '1479696796', '1479696796', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('45', 'test45', '', '', '', '1479696796', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '0', '1479696796', '1479909366', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('46', 'test46', '', '', '', '1479696797', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '0', '1479696797', '1479696797', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('47', 'test47', '', '', '', '1479696797', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '0', '1479696797', '1479909340', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('48', 'test48', '', '', '', '1479696797', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696797', '1479909479', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('49', 'test49', '', '', '', '1479696797', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '1', '1479696797', '1479696797', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('50', 'test50', '', '', '', '1479696797', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696797', '1479696797', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('51', 'test51', '', '', '', '1479696797', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696797', '1479909398', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('52', 'test52', '', '', '', '1479696798', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '1', '1479696798', '1479909513', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('53', 'test53', '', '', '', '1479696798', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '0', '1479696798', '1479909557', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('54', 'test54', '', '', '', '1479696798', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '1', '1479696798', '1479696798', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('55', 'test55', '', '', '', '1479696798', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696798', '1479909669', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('56', 'test56', '', '', '', '1479696798', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696798', '1479696798', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('57', 'test57', '', '', '', '1479696798', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696798', '1479696798', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('58', 'test58', '', '', '', '1479696799', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '1', '1479696799', '1479696799', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('59', 'test59', '', '', '', '1479696799', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696799', '1479696799', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('60', 'test60', '', '', '', '1479696799', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696799', '1479696799', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('61', 'test61', '', '', '', '1479696799', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '1', '1479696799', '1479909774', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('62', 'test62', '', '', '', '1479696799', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '1', '1479696799', '1479696799', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('63', 'test63', '', '', '', '1479696799', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696799', '1479909775', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('64', 'test64', '', '', '', '1479696800', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696800', '1479909817', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('65', 'test65', '', '', '', '1479696800', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696800', '1479696800', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('66', 'test66', '', '', '', '1479696800', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696800', '1479696800', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('67', 'test67', '', '', '', '1479696800', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696800', '1479910002', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('68', 'test68', '', '', '', '1479696801', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696801', '1479910002', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('69', 'test69', '', '', '', '1479696801', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696801', '1479910062', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('70', 'test70', '', '', '', '1479696801', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696801', '1479910109', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('71', 'test71', '', '', '', '1479696801', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696801', '1479910187', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('72', 'test72', '', '', '', '1479696801', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696801', '1479696801', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('73', 'test73', '', '', '', '1479696801', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696801', '1479910244', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('74', 'test74', '', '', '', '1479696801', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '0', '1479696801', '1479910299', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('75', 'test75', '', '', '', '1479696802', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696802', '1479696802', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('76', 'test76', '', '', '', '1479696802', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '0', '1479696802', '1479696802', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('77', 'test77', '', '', '', '1479696802', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '1', '1479696802', '1479696802', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('78', 'test78', '', '', '', '1479696802', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '0', '', '0', '1', '1479696802', '1479696802', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('79', 'test79', '', '', '', '1479696802', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '0', '1479696802', '1479696802', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('80', 'test80', '', '', '', '1479696803', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '0', '', '0', '1', '1479696803', '1479696803', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('81', 'test81', '', '', '', '1479696803', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '0', '1479696803', '1479907721', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('82', 'test82', '', '', '', '1479696803', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696803', '1479890745', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('83', 'test83', '', '', '', '1479696803', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696803', '1479907872', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('84', 'test84', '', '', '', '1479696803', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '1', '1479696803', '1479901956', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('85', 'test85', '', '', '', '1479696803', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696803', '1479887548', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('86', 'test86', '', '', '', '1479696804', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '1', '1479696804', '1479886758', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('87', 'test87', '', '', '', '1479696804', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696804', '1479696804', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('88', 'test88', '', '', '', '1479696804', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '1', '1479696804', '1479887130', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('89', 'test89', '', '', '', '1479696804', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696804', '1479907878', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('90', 'test90', '', '', '', '1479696804', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696804', '1479696804', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('91', 'test91', '', '', '', '1479696804', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696804', '1479696804', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('92', 'test92', '', '', '', '1479696804', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696804', '1479907883', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('93', 'test93', '', '', '', '1479696805', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '1', '1479696805', '1479887702', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('94', 'test94', '', '', '', '1479696805', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '0', '1479696805', '1479887197', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('95', 'test95', '', '', '', '1479696805', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '0', '1479696805', '1479887301', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('96', 'test96', '', '', '', '1479696805', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '1', '1479696805', '1479887693', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('97', 'test97', '', '', '', '1479696805', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696805', '1479696805', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('98', 'test98', '', '', '', '1479696805', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '1', '1479696805', '1479887192', '0', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('99', 'test99', '', '', '', '1479696806', '127.0.0.1', '', '', '0.00', '0', '0', '0', '0', '1', '', '0', '0', '1479696806', '1479887744', '1', '0', '0', null);
INSERT INTO `sxh_user` VALUES ('100', 'test100', '', '', '', '1479696806', '127.0.0.1', '', '', '0.00', '0', '0', '0', '1', '1', '', '0', '0', '1479696806', '1479907895', '0', '0', '0', null);

-- ----------------------------
-- Table structure for sxh_user_accepthelp
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_accepthelp`;
CREATE TABLE `sxh_user_accepthelp` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `Type` char(255) NOT NULL DEFAULT '' COMMENT '接受资助',
  `TypeID` char(4) NOT NULL DEFAULT '0' COMMENT '接受资助 0',
  `Sum` int(11) unsigned NOT NULL COMMENT '接受的资助金额',
  `Used` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '已匹配的金额',
  `CID` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '社区ID，接受资助不用社区ID，保留备用',
  `CName` varchar(20) NOT NULL COMMENT '社区名称，接受资助不用社区名称，保留备用',
  `UserID` int(11) unsigned NOT NULL COMMENT '接受资助的用户',
  `Status` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '接受资助状态 0未到账1已到账',
  `Sign` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '接受资助 0 我未确认收款 1我确认收款 ',
  `Batch` char(11) DEFAULT NULL,
  `Matching` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否匹配，0未匹配，1已匹配，默认0',
  `MatchingID` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '匹配列表的ID',
  `IsStop` tinyint(1) DEFAULT '0' COMMENT '冻结禁止匹配',
  `IPAddress` char(40) DEFAULT NULL,
  `CreateTime` datetime NOT NULL COMMENT '创建时间',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `match_num` tinyint(3) DEFAULT '0',
  `pay_num` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `accepthelp_inx01` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sxh_user_accepthelp
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_account
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_account`;
CREATE TABLE `sxh_user_account` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `UserID` int(11) NOT NULL COMMENT '用户ID',
  `Activate_Currency` int(5) unsigned NOT NULL COMMENT '激活币 善金币',
  `Guadan_Currency` int(5) unsigned NOT NULL COMMENT '挂单币',
  `Wallet_Currency` int(7) unsigned NOT NULL COMMENT '出局钱包，接受资助金额由此转出',
  `Manage_Wallet` int(7) unsigned NOT NULL COMMENT '管理钱包，下线完成资助的返利百分比得出，一部分给管理钱包，一部分给虚拟币',
  `Invented_Currency` int(7) unsigned NOT NULL COMMENT '虚拟币',
  `CreateTime` datetime NOT NULL COMMENT '创建时间',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `OrderTaking` int(7) NOT NULL DEFAULT '0' COMMENT '接单钱包',
  `PoorWallet` int(7) NOT NULL DEFAULT '0' COMMENT '特困钱包',
  `NeedyWallet` int(7) NOT NULL DEFAULT '0' COMMENT '贫穷钱包',
  `ComfortablyWallet` int(7) NOT NULL DEFAULT '0' COMMENT '小康钱包',
  `KindWallet` int(7) NOT NULL DEFAULT '0' COMMENT '德善钱包',
  `WealthWallet` int(7) NOT NULL DEFAULT '0' COMMENT '富人钱包',
  `CompanyWallet` int(7) NOT NULL DEFAULT '0' COMMENT '企业钱包',
  `CompManageWallet` int(11) NOT NULL DEFAULT '0' COMMENT '企业管理钱包',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UserID_UNIQUE` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户账户币表，用户注册之后会自动初始化该表，全部为0';

-- ----------------------------
-- Records of sxh_user_account
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_agent
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_agent`;
CREATE TABLE `sxh_user_agent` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `Number` char(4) NOT NULL COMMENT '地区编码',
  `Name` varchar(20) NOT NULL COMMENT '地区名称',
  `CreateTime` datetime NOT NULL COMMENT '创建时间',
  `UpdateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='代理地区表';

-- ----------------------------
-- Records of sxh_user_agent
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_auit_msg
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_auit_msg`;
CREATE TABLE `sxh_user_auit_msg` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL COMMENT '用户ID',
  `AdminID` int(11) NOT NULL COMMENT '管理员Id',
  `Attend` varchar(200) NOT NULL COMMENT '提示信息',
  `ReadType` tinyint(1) NOT NULL DEFAULT '0',
  `CreateTime` int(11) NOT NULL COMMENT '创建时间',
  `UpdateTime` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sxh_user_auit_msg
-- ----------------------------
INSERT INTO `sxh_user_auit_msg` VALUES ('1', '19', '2', '亲爱的会员，您的资料审核未通过！请尽快登陆会员系统进行资料完善和修改。', '0', '1479734967', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('2', '19', '2', '亲爱的会员，您的资料审核未通过！请尽快登陆会员系统进行资料完善和修改。', '0', '1479735028', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('3', '20', '2', '亲爱的会员，您的资料审核未通过！请尽快登陆会员系统进行资料完善和修改。', '0', '1479735495', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('4', '19', '2', '亲爱的会员，您的资料审核未通过！请尽快登陆会员系统进行资料完善和修改。', '0', '1479735642', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('5', '19', '2', '亲爱的会员，您的资料审核未通过！请尽快登陆会员系统进行资料完善和修改。', '0', '1479735766', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('6', '19', '2', '亲爱的会员，您的资料审核未通过！请尽快登陆会员系统进行资料完善和修改。', '0', '1479735807', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('7', '19', '2', '亲爱的会员，您的资料审核未通过！请尽快登陆会员系统进行资料完善和修改。', '0', '1479738262', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('8', '19', '2', '亲爱的会员，您的资料审核未通过！请尽快登陆会员系统进行资料完善和修改。', '0', '1479738262', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('9', '19', '2', '亲爱的会员，您的资料审核未通过！请尽快登陆会员系统进行资料完善和修改。', '0', '1479738344', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('10', '1', '2', '亲爱的会员，您的资料审核未通过！请尽快登陆会员系统进行资料完善和修改。', '0', '1479740785', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('11', '1', '2', '亲爱的会员，您的资料审核未通过！请尽快登陆会员系统进行资料完善和修改。', '0', '1479743142', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('12', '1', '2', '亲爱的会员，您的资料审核未通过！请尽快登陆会员系统进行资料完善和修改。', '0', '1479743454', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('13', '1', '2', '亲爱的会员，您的资料审核未通过！请尽快登陆会员系统进行资料完善和修改。', '0', '1479747001', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('14', '1', '2', '亲爱的会员，您的资料审核未通过！请尽快登陆会员系统进行资料完善和修改。', '0', '1479747001', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('15', '3', '2', '身份验证不通过', '0', '1479878006', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('16', '3', '2', '账号不通过', '0', '1479878293', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('17', '3', '2', '账号不通过', '0', '1479878293', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('18', '81', '2', 'eqwe', '0', '1479884913', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('19', '81', '2', 'qweqweqweqweqw', '0', '1479884946', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('20', '81', '2', 'qweqweqweqweqw', '0', '1479884947', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('21', '81', '2', 'qweqweqweqweqw', '0', '1479884947', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('22', '81', '2', 'qweqweqweqweqw', '0', '1479884948', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('23', '81', '2', 'qweqweqweqwe', '0', '1479885047', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('24', '81', '2', 'qweqweqweqwe', '0', '1479885048', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('25', '81', '2', 'qweqweqweqwe', '0', '1479885049', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('26', '81', '2', 'qweqweqweqwe', '0', '1479885050', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('27', '81', '2', 'qweqweqweqwe', '0', '1479885050', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('28', '81', '2', 'qweqweqw', '0', '1479885071', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('29', '81', '2', 'qweqwewq', '0', '1479885370', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('30', '81', '2', 'eqwe', '0', '1479889958', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('31', '81', '2', '驱蚊器无', '0', '1479890199', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('32', '81', '2', '驱蚊器无', '0', '1479890201', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('33', '81', '2', '驱蚊器无', '0', '1479890202', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('34', '81', '2', '驱蚊器无', '0', '1479890202', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('35', '81', '2', '驱蚊器无', '0', '1479890203', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('36', '81', '2', '驱蚊器无', '0', '1479890204', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('37', '81', '2', 'werewolf', '0', '1479890254', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('38', '81', '2', '其味无穷二', '0', '1479890270', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('39', '81', '2', '恶趣味', '0', '1479890278', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('40', '81', '2', '恶趣味', '0', '1479890279', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('41', '81', '2', '驱蚊器无', '0', '1479890286', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('42', '81', '2', '去问问', '0', '1479890293', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('43', '81', '2', '请问请问', '0', '1479890298', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('44', '81', '2', '我去额群翁', '0', '1479890304', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('45', '81', '2', '其味无穷其味无穷二', '0', '1479890312', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('46', '90', '2', '而我却二群翁', '0', '1479890345', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('47', '41', '2', '身份验证不通过', '0', '1479891710', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('48', '41', '2', '身份验证不通过', '0', '1479891725', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('49', '41', '2', '身份验证不通过', '0', '1479891972', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('50', '21', '2', '身份验证不通过', '0', '1479892544', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('51', '2', '2', '账号信息有错', '0', '1479896602', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('52', '89', '2', 'yoiuiol', '0', '1479902542', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('53', '89', '2', 'yoiuiol', '0', '1479902545', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('54', '89', '2', 'mn.n', '0', '1479902559', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('55', '83', '2', 'mn.n', '0', '1479902560', '0');
INSERT INTO `sxh_user_auit_msg` VALUES ('56', '81', '2', 'dsfasd ', '0', '1479907730', '0');

-- ----------------------------
-- Table structure for sxh_user_authorization
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_authorization`;
CREATE TABLE `sxh_user_authorization` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水号',
  `AuthorizationCode` int(4) unsigned NOT NULL COMMENT '4位数字授权码',
  `Status` int(2) NOT NULL DEFAULT '0' COMMENT '状态 0未使用 1使用',
  `BatchID` int(11) NOT NULL COMMENT ' 使用到验证码的批次ID',
  `CreateTime` datetime NOT NULL COMMENT '创建时间',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='授权码信息表';

-- ----------------------------
-- Records of sxh_user_authorization
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_batch
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_batch`;
CREATE TABLE `sxh_user_batch` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `BatchName` varchar(30) NOT NULL COMMENT '批次名称',
  `Number` int(11) unsigned NOT NULL COMMENT '该批次生成的个数',
  `UserID` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '验证码的归属账户',
  `EmpowerID` char(4) NOT NULL COMMENT '4位数字授权编码，没有授权不能开启生成',
  `AdminID` int(11) unsigned NOT NULL COMMENT '开启生成激活验证码的系统账户',
  `Info` text NOT NULL COMMENT '备注信息',
  `CreateTime` datetime NOT NULL COMMENT '生成时间',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='激活验证码批次表';

-- ----------------------------
-- Records of sxh_user_batch
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_blacklist
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_blacklist`;
CREATE TABLE `sxh_user_blacklist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) DEFAULT NULL,
  `UserName` varchar(40) DEFAULT NULL,
  `Remark` varchar(255) DEFAULT NULL,
  `CreateTime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sxh_user_blacklist
-- ----------------------------
INSERT INTO `sxh_user_blacklist` VALUES ('7', '3', 'test3', '身份验证不通过', '1479878006');
INSERT INTO `sxh_user_blacklist` VALUES ('8', '3', 'test3', '账号不通过', '1479878293');
INSERT INTO `sxh_user_blacklist` VALUES ('9', '3', 'test3', '账号不通过', '1479878293');
INSERT INTO `sxh_user_blacklist` VALUES ('10', '81', 'test81', '', '1479883779');
INSERT INTO `sxh_user_blacklist` VALUES ('11', '81', 'test81', '', '1479883787');
INSERT INTO `sxh_user_blacklist` VALUES ('12', '81', 'test81', '', '1479883787');
INSERT INTO `sxh_user_blacklist` VALUES ('13', '81', 'test81', '', '1479883788');
INSERT INTO `sxh_user_blacklist` VALUES ('14', '81', 'test81', '', '1479883837');
INSERT INTO `sxh_user_blacklist` VALUES ('15', '81', 'test81', '', '1479883840');
INSERT INTO `sxh_user_blacklist` VALUES ('16', '81', 'test81', '', '1479883845');
INSERT INTO `sxh_user_blacklist` VALUES ('17', '81', 'test81', '', '1479883850');
INSERT INTO `sxh_user_blacklist` VALUES ('18', '81', 'test81', '', '1479883855');
INSERT INTO `sxh_user_blacklist` VALUES ('19', '81', 'test81', '', '1479883860');
INSERT INTO `sxh_user_blacklist` VALUES ('20', '81', 'test81', '', '1479884052');
INSERT INTO `sxh_user_blacklist` VALUES ('21', '81', 'test81', '', '1479884162');
INSERT INTO `sxh_user_blacklist` VALUES ('22', '81', 'test81', '', '1479884228');
INSERT INTO `sxh_user_blacklist` VALUES ('23', '81', 'test81', '', '1479884291');
INSERT INTO `sxh_user_blacklist` VALUES ('24', '81', 'test81', '', '1479884408');
INSERT INTO `sxh_user_blacklist` VALUES ('25', '81', 'test81', '', '1479884430');
INSERT INTO `sxh_user_blacklist` VALUES ('26', '81', 'test81', '', '1479884458');
INSERT INTO `sxh_user_blacklist` VALUES ('27', '81', 'test81', '', '1479884463');
INSERT INTO `sxh_user_blacklist` VALUES ('28', '81', 'test81', 'eqwe', '1479884913');
INSERT INTO `sxh_user_blacklist` VALUES ('29', '81', 'test81', 'qweqweqweqweqw', '1479884946');
INSERT INTO `sxh_user_blacklist` VALUES ('30', '81', 'test81', 'qweqweqweqweqw', '1479884947');
INSERT INTO `sxh_user_blacklist` VALUES ('31', '81', 'test81', 'qweqweqweqweqw', '1479884947');
INSERT INTO `sxh_user_blacklist` VALUES ('32', '81', 'test81', 'qweqweqweqweqw', '1479884948');
INSERT INTO `sxh_user_blacklist` VALUES ('33', '81', 'test81', 'qweqweqweqwe', '1479885048');
INSERT INTO `sxh_user_blacklist` VALUES ('34', '81', 'test81', 'qweqweqweqwe', '1479885049');
INSERT INTO `sxh_user_blacklist` VALUES ('35', '81', 'test81', 'qweqweqweqwe', '1479885049');
INSERT INTO `sxh_user_blacklist` VALUES ('36', '81', 'test81', 'qweqweqweqwe', '1479885050');
INSERT INTO `sxh_user_blacklist` VALUES ('37', '81', 'test81', 'qweqweqweqwe', '1479885051');
INSERT INTO `sxh_user_blacklist` VALUES ('38', '81', 'test81', 'qweqweqw', '1479885071');
INSERT INTO `sxh_user_blacklist` VALUES ('39', '81', 'test81', 'qweqwewq', '1479885370');
INSERT INTO `sxh_user_blacklist` VALUES ('40', '81', 'test81', 'eqwe', '1479889959');
INSERT INTO `sxh_user_blacklist` VALUES ('41', '81', 'test81', '驱蚊器无', '1479890200');
INSERT INTO `sxh_user_blacklist` VALUES ('42', '81', 'test81', '驱蚊器无', '1479890201');
INSERT INTO `sxh_user_blacklist` VALUES ('43', '81', 'test81', '驱蚊器无', '1479890202');
INSERT INTO `sxh_user_blacklist` VALUES ('44', '81', 'test81', '驱蚊器无', '1479890203');
INSERT INTO `sxh_user_blacklist` VALUES ('45', '81', 'test81', '驱蚊器无', '1479890203');
INSERT INTO `sxh_user_blacklist` VALUES ('46', '81', 'test81', '驱蚊器无', '1479890204');
INSERT INTO `sxh_user_blacklist` VALUES ('47', '81', 'test81', 'werewolf', '1479890254');
INSERT INTO `sxh_user_blacklist` VALUES ('48', '81', 'test81', '其味无穷二', '1479890270');
INSERT INTO `sxh_user_blacklist` VALUES ('49', '81', 'test81', '恶趣味', '1479890278');
INSERT INTO `sxh_user_blacklist` VALUES ('50', '81', 'test81', '恶趣味', '1479890279');
INSERT INTO `sxh_user_blacklist` VALUES ('51', '81', 'test81', '驱蚊器无', '1479890286');
INSERT INTO `sxh_user_blacklist` VALUES ('52', '81', 'test81', '去问问', '1479890293');
INSERT INTO `sxh_user_blacklist` VALUES ('53', '81', 'test81', '请问请问', '1479890298');
INSERT INTO `sxh_user_blacklist` VALUES ('54', '81', 'test81', '我去额群翁', '1479890304');
INSERT INTO `sxh_user_blacklist` VALUES ('55', '81', 'test81', '其味无穷其味无穷二', '1479890312');
INSERT INTO `sxh_user_blacklist` VALUES ('56', '90', 'test90', '而我却二群翁', '1479890345');
INSERT INTO `sxh_user_blacklist` VALUES ('57', '41', 'test41', '身份验证不通过', '1479891972');
INSERT INTO `sxh_user_blacklist` VALUES ('58', '21', 'test21', '身份验证不通过', '1479892544');
INSERT INTO `sxh_user_blacklist` VALUES ('60', '89', 'test89', 'yoiuiol', '1479902543');
INSERT INTO `sxh_user_blacklist` VALUES ('61', '89', 'test89', 'yoiuiol', '1479902545');
INSERT INTO `sxh_user_blacklist` VALUES ('62', '89', 'test89', 'mn.n', '1479902560');
INSERT INTO `sxh_user_blacklist` VALUES ('63', '83', 'test83', 'mn.n', '1479902561');
INSERT INTO `sxh_user_blacklist` VALUES ('64', '81', 'test81', 'dsfasd ', '1479907730');

-- ----------------------------
-- Table structure for sxh_user_clothes
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_clothes`;
CREATE TABLE `sxh_user_clothes` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ConsigneeName` varchar(50) NOT NULL COMMENT '收货人姓名',
  `IsApply` tinyint(1) NOT NULL COMMENT '是否申请过',
  `IsReceived` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已接收到了',
  `ConsigneePhone` char(11) NOT NULL COMMENT '收货人电话',
  `UserId` int(11) NOT NULL COMMENT '申请的会员ID',
  `ConsigneeAddress` varchar(200) NOT NULL COMMENT '收货地址',
  `Size` tinyint(1) NOT NULL COMMENT '尺寸大小 1,S 2,M 3,L 4, XL 5,XXL 6,XXXL',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最近更新时间',
  `CreateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='申请善心汇文化杉表';

-- ----------------------------
-- Records of sxh_user_clothes
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_community
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_community`;
CREATE TABLE `sxh_user_community` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `Name` varchar(20) NOT NULL COMMENT '社区名称',
  `CID` int(11) unsigned NOT NULL COMMENT '社区ID',
  `LowSum` int(11) unsigned NOT NULL COMMENT '最低布施金额',
  `TopSum` int(11) unsigned NOT NULL COMMENT '最高布施金额',
  `Multiple` int(11) unsigned NOT NULL COMMENT '金额倍数',
  `LowRebate` int(11) unsigned NOT NULL COMMENT '最低返利 百分比值',
  `TopRebate` int(11) unsigned NOT NULL COMMENT '最高返利 百分比值',
  `Rebate` int(2) NOT NULL,
  `LowTime` int(11) unsigned NOT NULL COMMENT '最低匹配天数',
  `TopTime` int(11) unsigned NOT NULL COMMENT '最高匹配天数',
  `GoProvideDay` int(2) unsigned NOT NULL COMMENT '二次排单时间，单位天数',
  `Sort` int(11) unsigned NOT NULL COMMENT '显示顺序',
  `Message` text NOT NULL COMMENT '社区介绍',
  `Image` varchar(50) NOT NULL COMMENT '图片路径',
  `CreateTime` datetime NOT NULL COMMENT '创建时间',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `is_company` tinyint(1) NOT NULL DEFAULT '0' COMMENT '小区分类是否为企业版的分类:1企业,0普通',
  `RefereeRebate` int(11) NOT NULL DEFAULT '0' COMMENT '推介人百分比',
  `MembershipRebate` int(11) NOT NULL DEFAULT '0' COMMENT '招商员百分比',
  `BasinessCenterRebater` int(11) NOT NULL DEFAULT '0' COMMENT '商务中心百分比',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='五大社区信息表';

-- ----------------------------
-- Records of sxh_user_community
-- ----------------------------
INSERT INTO `sxh_user_community` VALUES ('1', '贫穷社区', '1', '1000', '3000', '100', '30', '50', '30', '1', '5', '1', '1', '&nbsp;&nbsp;布施金额1000—3000元 ，每轮收益率30%.排队布施时间1—10天，打款成功后，进入感恩受助队列，1—7天匹配收款（周末休息暂停匹配时间计入排队时间，国家法定节假日时间不计入排队时间）。', '/Public/User/images/community/pk.jpg', '2016-04-22 11:47:33', '2016-09-02 12:51:51', '0', '0', '0', '0');
INSERT INTO `sxh_user_community` VALUES ('2', '小康社区', '2', '10000', '30000', '1000', '20', '30', '20', '3', '10', '3', '2', '布施金额1万—3万元，前五轮收益率为20%，从第六轮开始收益率降为15%. 排队布施时间3—15天，打款成功后，进入感恩受助队列，3—9天匹配收款（周末休息暂停匹配时间计入排队时间，国家法定节假日时间不计入排队时间）。', '/Public/User/images/community/xk.jpg', '2016-04-22 11:48:54', '2016-09-02 12:50:46', '0', '0', '0', '0');
INSERT INTO `sxh_user_community` VALUES ('3', '富人社区', '3', '50000', '300000', '1000', '10', '20', '10', '3', '15', '10', '3', '布施金额5万—30万元，每轮收益率10%.排队布施时间3—15天，打款成功后，进入感恩受助队列，30天内匹配收款。', '/Public/User/images/community/fr.jpg', '2016-04-22 11:50:32', '2016-08-29 11:28:42', '0', '0', '0', '0');
INSERT INTO `sxh_user_community` VALUES ('4', '德善社区', '4', '300000', '10000000', '10000', '3', '5', '1', '30', '90', '20', '4', '布施金额50万—1000万元，每轮收益率0—5%，安排专属客服直接服务，签约之后打款，打款成功后，进入感恩受助队列，回款时间15—60天。', '/Public/User/images/community/ds.jpg', '2016-04-22 11:52:36', '2016-09-02 13:04:58', '0', '0', '0', '0');
INSERT INTO `sxh_user_community` VALUES ('5', '大德社区', '5', '30000000', '100000000', '10000000', '0', '0', '0', '0', '0', '99999', '5', '', '/Public/User/images/community/de.jpg', '2016-04-22 12:58:24', '2016-08-16 12:11:26', '0', '0', '0', '0');
INSERT INTO `sxh_user_community` VALUES ('6', '企业社区', '6', '50000', '300000', '10000', '10', '20', '10', '10', '30', '6', '6', '布施金额5—30万元 ，每轮收益率20%，本金和部分收益进入出局钱包，可通过“接受资助”立即提取，另一部分收益进入库存钱包，作为企业去库存的预付货款，根据实际供货情况结算提取。每年至少保证7轮，每轮排队打款和收款时间总计50天左右（周末休息暂停匹配时间计入排队时间，国家法定节假日时间不计入排队时间）。', '/Public/Comp/images/community/q6.jpg', '2016-09-22 11:48:54', '2016-10-21 16:12:02', '1', '1', '1', '4');

-- ----------------------------
-- Table structure for sxh_user_company
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_company`;
CREATE TABLE `sxh_user_company` (
  `UserID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `CompanyName` varchar(80) NOT NULL DEFAULT '' COMMENT '公司名称',
  `Corporation` char(16) NOT NULL DEFAULT '' COMMENT '法人',
  `CompanyCard` char(20) NOT NULL DEFAULT '' COMMENT '公司账号',
  `CorporationCard` char(20) NOT NULL DEFAULT '' COMMENT '法人账号',
  `lowAmount` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最低挂单金额',
  `BusinessLicenceImage` char(20) NOT NULL DEFAULT '' COMMENT '营业执照图片',
  `BusinessLicenceCode` char(20) NOT NULL DEFAULT '' COMMENT '营业执照号码',
  `OrganizationCode` char(20) NOT NULL DEFAULT '' COMMENT '组织机构代码号码',
  `OrganizationCodeImage` char(20) NOT NULL DEFAULT '' COMMENT '组织机构代码号码图片',
  `CreateTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `CompanyAlipay` varchar(50) NOT NULL COMMENT '企业支付宝帐号',
  `CorporateAlipay` varchar(50) NOT NULL COMMENT '企业法人支付宝帐号',
  `CorporateBank` varchar(50) NOT NULL COMMENT '企业法人开户银行',
  `CompanyBank` varchar(50) NOT NULL COMMENT '企业对公帐号开户银行',
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='企业资料表';

-- ----------------------------
-- Records of sxh_user_company
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_dispersemoney
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_dispersemoney`;
CREATE TABLE `sxh_user_dispersemoney` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `OtherID` int(11) unsigned NOT NULL COMMENT '被打散金额的提供资助表ID',
  `OtherUserID` int(11) unsigned NOT NULL COMMENT '被打散金额的用户ID',
  `OtherSum` int(11) unsigned NOT NULL COMMENT '被打散后的金额',
  `TotalSum` int(11) unsigned NOT NULL COMMENT '打散前的总金额',
  `AcceptID` int(11) unsigned NOT NULL COMMENT '接受资助表的ID',
  `AcceptUserID` int(11) unsigned NOT NULL COMMENT '接受资助的用户ID',
  `AcceptSum` int(11) unsigned NOT NULL COMMENT '接受资助的金额',
  `Matching` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '是否匹配掉 0未匹配，1已匹配，默认0',
  `CreateTime` datetime NOT NULL COMMENT '创建时间',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sxh_user_dispersemoney
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_feedback
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_feedback`;
CREATE TABLE `sxh_user_feedback` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `Sort` varchar(30) CHARACTER SET utf8 NOT NULL COMMENT '反馈问题的分类',
  `Title` varchar(40) CHARACTER SET utf8 NOT NULL COMMENT '反馈问题的标题',
  `Message` text CHARACTER SET utf8 NOT NULL COMMENT '反馈问题的内容',
  `UserID` int(11) NOT NULL COMMENT '反馈问题的账户ID',
  `Status` int(2) NOT NULL DEFAULT '0' COMMENT '状态 0未处理 1已处理',
  `AdminID` int(11) NOT NULL COMMENT '处理问题的系统管理员ID',
  `ImageA` varchar(30) CHARACTER SET utf8 NOT NULL COMMENT '图片1',
  `FolderA` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT '存放图片A的文件夹A',
  `CreateTime` datetime NOT NULL COMMENT '创建时间',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sxh_user_feedback
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_income
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_income`;
CREATE TABLE `sxh_user_income` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `Message` varchar(255) NOT NULL COMMENT '操作描述',
  `Type` char(20) NOT NULL COMMENT '币种类型，激活币 挂单币',
  `InCome` int(11) unsigned NOT NULL COMMENT '收入个数',
  `UserID` int(11) unsigned NOT NULL COMMENT '收入用户ID',
  `PID` int(11) unsigned NOT NULL COMMENT '收入来源的父ID(支出操作的ID)',
  `CatID` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收入的来源操作，对应outgo表的id',
  `Info` text NOT NULL COMMENT '备注',
  `CreateTime` int(11) unsigned NOT NULL COMMENT '生成时间',
  `UpdateTime` int(11) unsigned NOT NULL COMMENT '更新时间',
  `ProductID` int(11) DEFAULT NULL COMMENT '第三方产品ID',
  PRIMARY KEY (`ID`),
  KEY `sxh_user_income_inx02` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='账户收入明细表';

-- ----------------------------
-- Records of sxh_user_income
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_income_1
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_income_1`;
CREATE TABLE `sxh_user_income_1` (
  `id` int(10) NOT NULL,
  `type` tinyint(3) NOT NULL COMMENT '收益类型 1-善种子 2-善心币 3-善金币 4-出局钱包 5-管理钱包6-接单钱包 7-特困钱包 8-贫穷钱包 9-小康钱包 10-德善钱包 11-富人钱包',
  `cid` int(10) NOT NULL COMMENT '社区id',
  `user_id` int(10) NOT NULL COMMENT '收入用户id',
  `username` char(20) NOT NULL COMMENT '收益人',
  `income` int(10) NOT NULL COMMENT '收益总额',
  `pid` int(10) NOT NULL COMMENT '收益来源(provide主键id)',
  `cat_id` int(10) NOT NULL COMMENT '匹配编号(matchhelp表主键id)',
  `info` char(64) NOT NULL COMMENT '备注说明',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `status` tinyint(1) NOT NULL COMMENT '状态 1-删除 0-正常'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sxh_user_income_1
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_income_2
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_income_2`;
CREATE TABLE `sxh_user_income_2` (
  `id` int(10) NOT NULL,
  `type` tinyint(3) NOT NULL COMMENT '收益类型 1-善种子 2-善心币 3-善金币 4-出局钱包 5-管理钱包6-接单钱包 7-特困钱包 8-贫穷钱包 9-小康钱包 10-德善钱包 11-富人钱包',
  `cid` int(10) NOT NULL COMMENT '社区id',
  `user_id` int(10) NOT NULL COMMENT '收入用户id',
  `username` char(20) NOT NULL COMMENT '收益人',
  `income` int(10) NOT NULL COMMENT '收益总额',
  `pid` int(10) NOT NULL COMMENT '收益来源(provide主键id)',
  `cat_id` int(10) NOT NULL COMMENT '匹配编号(matchhelp表主键id)',
  `info` char(64) NOT NULL COMMENT '备注说明',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `status` tinyint(1) NOT NULL COMMENT '状态 1-删除 0-正常'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sxh_user_income_2
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_income_3
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_income_3`;
CREATE TABLE `sxh_user_income_3` (
  `id` int(10) NOT NULL,
  `type` tinyint(3) NOT NULL COMMENT '收益类型 1-善种子 2-善心币 3-善金币 4-出局钱包 5-管理钱包6-接单钱包 7-特困钱包 8-贫穷钱包 9-小康钱包 10-德善钱包 11-富人钱包',
  `cid` int(10) NOT NULL COMMENT '社区id',
  `user_id` int(10) NOT NULL COMMENT '收入用户id',
  `username` char(20) NOT NULL COMMENT '收益人',
  `income` int(10) NOT NULL COMMENT '收益总额',
  `pid` int(10) NOT NULL COMMENT '收益来源(provide主键id)',
  `cat_id` int(10) NOT NULL COMMENT '匹配编号(matchhelp表主键id)',
  `info` char(64) NOT NULL COMMENT '备注说明',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `status` tinyint(1) NOT NULL COMMENT '状态 1-删除 0-正常'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sxh_user_income_3
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_income_4
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_income_4`;
CREATE TABLE `sxh_user_income_4` (
  `id` int(10) NOT NULL,
  `type` tinyint(3) NOT NULL COMMENT '收益类型 1-善种子 2-善心币 3-善金币 4-出局钱包 5-管理钱包6-接单钱包 7-特困钱包 8-贫穷钱包 9-小康钱包 10-德善钱包 11-富人钱包',
  `cid` int(10) NOT NULL COMMENT '社区id',
  `user_id` int(10) NOT NULL COMMENT '收入用户id',
  `username` char(20) NOT NULL COMMENT '收益人',
  `income` int(10) NOT NULL COMMENT '收益总额',
  `pid` int(10) NOT NULL COMMENT '收益来源(provide主键id)',
  `cat_id` int(10) NOT NULL COMMENT '匹配编号(matchhelp表主键id)',
  `info` char(64) NOT NULL COMMENT '备注说明',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `status` tinyint(1) NOT NULL COMMENT '状态 1-删除 0-正常'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sxh_user_income_4
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_matchhelp
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_matchhelp`;
CREATE TABLE `sxh_user_matchhelp` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `PID` int(11) unsigned NOT NULL COMMENT '接受资助表accept的ID',
  `UserID` int(11) unsigned NOT NULL COMMENT '接受者ID',
  `Sum` int(11) unsigned NOT NULL COMMENT '接受的金额',
  `OtherID` int(11) unsigned NOT NULL COMMENT '对应的提供资助表provide的ID',
  `OtherUserID` int(11) unsigned NOT NULL COMMENT '提供者的帐号ID',
  `OtherSum` int(11) unsigned NOT NULL COMMENT '提供资助者的金额',
  `Status` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '提供资助状态  0未转款1已转款，接受资助状态 0未到账1已到账',
  `Sign` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '提供资助状态  0未确认收款1已确认收款，接受资助状态 0未确认到账1已确认到账',
  `Handlers` int(10) unsigned NOT NULL COMMENT '操作者',
  `MatchingID` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '接单ID',
  `IPAddress` varchar(20) NOT NULL COMMENT 'IP地址',
  `SignTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '确认收款时间',
  `CreateTime` datetime NOT NULL COMMENT '创建时间',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `UserName` varchar(40) DEFAULT NULL,
  `OtherUserName` varchar(40) DEFAULT NULL,
  `Batch` int(11) DEFAULT '0',
  `AuditStatus` int(4) DEFAULT '0',
  `AuditUserID` int(11) DEFAULT NULL,
  `AuditUserName` varchar(40) DEFAULT NULL,
  `AuditTime` datetime DEFAULT NULL,
  `SmsStatus` int(4) DEFAULT '0',
  `PayTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '打款时间',
  `DelayedTimeStatus` tinyint(1) DEFAULT '0' COMMENT '延时标记 1-延时过了',
  PRIMARY KEY (`ID`),
  KEY `PID` (`PID`),
  KEY `matchhelp_inx04` (`OtherID`),
  KEY `matchhelp_inx05` (`UserID`,`OtherUserID`,`OtherID`),
  KEY `IDX_OTHERUSERID` (`OtherUserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='资助匹配列表';

-- ----------------------------
-- Records of sxh_user_matchhelp
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_matchhelp-_copy
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_matchhelp-_copy`;
CREATE TABLE `sxh_user_matchhelp-_copy` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `PID` int(11) unsigned NOT NULL COMMENT '接受资助表accept的ID',
  `UserID` int(11) unsigned NOT NULL COMMENT '接受者ID',
  `Sum` int(11) unsigned NOT NULL COMMENT '接受的金额',
  `OtherID` int(11) unsigned NOT NULL COMMENT '对应的提供资助表provide的ID',
  `OtherUserID` int(11) unsigned NOT NULL COMMENT '提供者的帐号ID',
  `OtherSum` int(11) unsigned NOT NULL COMMENT '提供资助者的金额',
  `Status` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '提供资助状态  0未转款1已转款，接受资助状态 0未到账1已到账',
  `Sign` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '提供资助状态  0未确认收款1已确认收款，接受资助状态 0未确认到账1已确认到账',
  `Handlers` int(10) unsigned NOT NULL COMMENT '操作者',
  `IPAddress` varchar(20) NOT NULL COMMENT 'IP地址',
  `SignTime` datetime NOT NULL COMMENT '确认收款时间',
  `CreateTime` datetime NOT NULL COMMENT '创建时间',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='资助匹配列表';

-- ----------------------------
-- Records of sxh_user_matchhelp-_copy
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_matchjob
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_matchjob`;
CREATE TABLE `sxh_user_matchjob` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编码',
  `pool_title` varchar(255) DEFAULT NULL,
  `pool_area` int(4) DEFAULT NULL COMMENT '接受方匹配区域',
  `pool_typeid` int(4) DEFAULT NULL COMMENT '是否接收',
  `pool_poolid` int(4) DEFAULT NULL COMMENT '是否优先',
  `pool_date` date DEFAULT NULL COMMENT '贫困区匹配日期_接受',
  `pool_day` int(4) DEFAULT NULL COMMENT '贫穷回配天数',
  `pool_min` int(11) DEFAULT NULL COMMENT '贫穷匹配最小',
  `pool_max` int(11) DEFAULT NULL COMMENT '贫穷匹配最大',
  `pool_time_start` datetime DEFAULT NULL,
  `pool_time_end` datetime DEFAULT NULL,
  `pool_area2` int(4) DEFAULT NULL COMMENT '付款方区域',
  `pool_date2` date DEFAULT NULL COMMENT '贫困区匹配日期_提供',
  `pool_min2` int(11) DEFAULT '0',
  `pool_max2` int(11) DEFAULT '0',
  `pool_time2_start` datetime DEFAULT NULL,
  `pool_time2_end` datetime DEFAULT NULL,
  `run_state` int(4) DEFAULT '0' COMMENT '运行状态',
  `create_userid` int(11) DEFAULT NULL COMMENT '创建人',
  `create_username` varchar(40) DEFAULT NULL COMMENT '创建人姓名',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `only_part` int(4) DEFAULT '0' COMMENT '仅配收方未配完',
  `only_part2` int(4) DEFAULT '0' COMMENT '仅配付方未配完',
  `match_alert` int(4) DEFAULT NULL COMMENT '匹配预警次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sxh_user_matchjob
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_news
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_news`;
CREATE TABLE `sxh_user_news` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `Classify` varchar(30) CHARACTER SET utf8 NOT NULL COMMENT '分类',
  `Title` varchar(30) CHARACTER SET utf8 NOT NULL COMMENT '新闻公告标题',
  `Content` text CHARACTER SET utf8 NOT NULL COMMENT '新闻公告内容',
  `UserID` int(11) unsigned NOT NULL COMMENT '发布者',
  `Status` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '发布状态 0 未发布 1已发布',
  `CreateTime` datetime NOT NULL COMMENT '创建时间',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `IsCompany` int(1) NOT NULL DEFAULT '0' COMMENT '是否为企业能通知1企业,0用户',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sxh_user_news
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_operation
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_operation`;
CREATE TABLE `sxh_user_operation` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `Table` varchar(30) NOT NULL COMMENT '删除的数据表',
  `TableID` int(11) unsigned NOT NULL COMMENT '删除表的ID',
  `UserID` int(11) unsigned NOT NULL COMMENT '删除的用户ID',
  `JDID` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '接单ID',
  `Handlers` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '操作者ID',
  `Sign` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '操作标识 0 删除匹配表和挂单信息 1 删除匹配表和不删除挂单',
  `IPAddress` varchar(40) DEFAULT NULL COMMENT 'IP地址',
  `CreateTime` datetime NOT NULL COMMENT '操作时间',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sxh_user_operation
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_order
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_order`;
CREATE TABLE `sxh_user_order` (
  `ID` int(8) NOT NULL AUTO_INCREMENT COMMENT '本系统订单编号',
  `UserID` int(8) NOT NULL COMMENT '用户编号',
  `UserName` varchar(18) NOT NULL COMMENT '用户帐号',
  `Phone` varchar(18) NOT NULL COMMENT '用户电话',
  `ProductID` int(8) NOT NULL COMMENT '产品编号',
  `ProductName` varchar(30) NOT NULL COMMENT '产品名称',
  `ProductNum` int(5) NOT NULL COMMENT '购买数量',
  `TotalNum` int(8) NOT NULL COMMENT '总购买金额',
  `OrderID` varchar(50) DEFAULT NULL,
  `PayTime` int(11) NOT NULL COMMENT '支付日期',
  `CreateTime` int(11) NOT NULL COMMENT '创建日期',
  `UpdateTime` int(11) NOT NULL COMMENT '更新日期',
  `McID` int(10) NOT NULL COMMENT '商户编号',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `OrderID` (`OrderID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sxh_user_order
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_outgo
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_outgo`;
CREATE TABLE `sxh_user_outgo` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `Message` varchar(255) NOT NULL COMMENT '操作描述',
  `Type` char(20) NOT NULL COMMENT '币种类型，激活币 挂单币',
  `OutGo` int(11) unsigned NOT NULL COMMENT '支出个数',
  `UserID` int(11) unsigned NOT NULL COMMENT '支出的用户ID',
  `PID` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '接受ID，或专门接收UserID支出的',
  `Info` text NOT NULL COMMENT '备注',
  `CreateTime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '生成时间',
  `UpdateTime` int(11) unsigned NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`ID`),
  KEY `sxh_user_outgo_inx01` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='账户支出明细表';

-- ----------------------------
-- Records of sxh_user_outgo
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_pay
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_pay`;
CREATE TABLE `sxh_user_pay` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `UserID` int(11) unsigned NOT NULL COMMENT '用户ID',
  `PID` int(11) unsigned NOT NULL COMMENT '匹配表的ID，通过该ID可以找到双方，首批打款例外',
  `Type` char(20) NOT NULL COMMENT '提供资助或者接受资助',
  `TypeID` int(2) unsigned NOT NULL COMMENT '0 提供资助 ， 1 接受资助',
  `Sum` int(11) unsigned NOT NULL COMMENT '金额',
  `Paymethod` varchar(200) NOT NULL COMMENT '一般填写支付方式 ，如转账，支付宝，微信等',
  `PayNumber` varchar(50) NOT NULL COMMENT '支付流水号',
  `PayDate` varchar(20) NOT NULL COMMENT '支付日期',
  `Images` varchar(30) NOT NULL COMMENT '图片名称',
  `Folder` char(20) NOT NULL COMMENT '图片文件夹名称',
  `CreateTime` datetime NOT NULL COMMENT '创建日期',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期',
  PRIMARY KEY (`ID`),
  KEY `IDX_PID_USERID` (`PID`,`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sxh_user_pay
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_provide
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_provide`;
CREATE TABLE `sxh_user_provide` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Type` char(255) NOT NULL COMMENT '提供资助',
  `TypeID` char(4) NOT NULL COMMENT '0提供资助',
  `Sum` int(11) unsigned NOT NULL COMMENT '提供资助金额',
  `Used` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '已匹配的金额',
  `CID` int(10) unsigned NOT NULL COMMENT '社区ID',
  `CName` varchar(20) NOT NULL COMMENT '社区名称',
  `UserID` int(11) unsigned NOT NULL COMMENT '提供资助的用户',
  `Status` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '提供资助状态  0未转款1已转款',
  `Sign` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '成功标志 提供资质 0对方未确认收款 1是确认收款',
  `Batch` char(11) DEFAULT NULL,
  `Matching` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否匹配，0未匹配，1已匹配，默认0''',
  `MatchingID` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '匹配列表的ID',
  `PoorID` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '特困会员',
  `IsStop` tinyint(1) DEFAULT '0' COMMENT '冻结禁止匹配',
  `Disperse` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否打散，0 为未打散，1打散，打散后不能在匹配列表显示',
  `IPAddress` char(40) DEFAULT NULL,
  `SignTime` datetime NOT NULL COMMENT '确认收款时间',
  `CreateTime` datetime NOT NULL COMMENT '创建时间',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `match_num` tinyint(3) DEFAULT '0',
  `pay_num` tinyint(3) DEFAULT NULL,
  `InitPay` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '初次打款标识',
  PRIMARY KEY (`ID`),
  KEY `provider_inx04` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='提供资助或接受资助信息表';

-- ----------------------------
-- Records of sxh_user_provide
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_question
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_question`;
CREATE TABLE `sxh_user_question` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL DEFAULT '0' COMMENT '设置问题的关联用户ID',
  `Question1` varchar(200) NOT NULL DEFAULT '' COMMENT '问题1',
  `Answer1` varchar(200) NOT NULL DEFAULT '' COMMENT '答案1',
  `Question2` varchar(200) NOT NULL DEFAULT '' COMMENT '问题2',
  `Answer2` varchar(200) NOT NULL DEFAULT '' COMMENT '答案2',
  `Question3` varchar(200) NOT NULL DEFAULT '' COMMENT '问题3',
  `Answer3` varchar(200) NOT NULL DEFAULT '' COMMENT '答案3',
  `UpdateTime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `CreateTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='密保问题表';

-- ----------------------------
-- Records of sxh_user_question
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_questionnaires
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_questionnaires`;
CREATE TABLE `sxh_user_questionnaires` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL COMMENT '用户表ID',
  `Sex` tinyint(1) NOT NULL COMMENT '性别 1男,0是女',
  `City` varchar(20) NOT NULL COMMENT '所在城市',
  `Jobs` varchar(50) NOT NULL COMMENT '职业',
  `IsCity` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否 城市户ID',
  `IsJinpo` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有社保',
  `PersonalIncome` decimal(9,2) NOT NULL DEFAULT '0.00' COMMENT '个人月收入',
  `FamilyIncome` decimal(9,2) NOT NULL DEFAULT '0.00' COMMENT '家庭月收入',
  `PersonalSpending` decimal(9,2) NOT NULL DEFAULT '0.00' COMMENT '个人月支出',
  `FamilySpending` decimal(9,2) NOT NULL DEFAULT '0.00' COMMENT '家庭月支出',
  `PersonalTotalLiabilities` decimal(9,2) NOT NULL DEFAULT '0.00' COMMENT '个人总负债',
  `FamilyTotalLiatbilities` decimal(9,2) NOT NULL DEFAULT '0.00' COMMENT '家庭总负债',
  `CarLoans` decimal(9,2) NOT NULL DEFAULT '0.00' COMMENT '车代',
  `HouseLoan` decimal(9,2) NOT NULL DEFAULT '0.00' COMMENT '房代',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `CreateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='数据调查问卷表';

-- ----------------------------
-- Records of sxh_user_questionnaires
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_random
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_random`;
CREATE TABLE `sxh_user_random` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `RandomCode` varchar(8) NOT NULL COMMENT '随机码',
  `BatchID` int(11) unsigned NOT NULL COMMENT '批次编号',
  `UserID` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '初始归属的账户',
  `BeUsedID` int(11) unsigned NOT NULL COMMENT '使用激活的账户',
  `Status` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '使用状态 0未使用 1使用',
  `CreateTime` datetime NOT NULL COMMENT '生成时间',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='激活码信息表';

-- ----------------------------
-- Records of sxh_user_random
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_rank
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_rank`;
CREATE TABLE `sxh_user_rank` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `Level` varchar(4) NOT NULL COMMENT '层级 1 2 3 4 5 6',
  `Name` varchar(20) NOT NULL COMMENT '名称',
  `Ratio` int(2) unsigned NOT NULL COMMENT '提供资助总额提成比例',
  `CreateTime` datetime NOT NULL COMMENT '创建时间',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='层级体系， 1 2 3 4 5 和相应的提成';

-- ----------------------------
-- Records of sxh_user_rank
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_records
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_records`;
CREATE TABLE `sxh_user_records` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `Message` varchar(255) NOT NULL COMMENT '操作描述',
  `Type` char(20) NOT NULL COMMENT '币种类型',
  `InCome` int(11) unsigned NOT NULL COMMENT '收入',
  `OutGo` int(11) unsigned NOT NULL COMMENT '支出',
  `UserID` int(11) unsigned NOT NULL COMMENT '上级操作用户ID',
  `ReceiveID` int(11) unsigned NOT NULL COMMENT '接受账户ID',
  `Info` text NOT NULL COMMENT '备注',
  `CreateTime` int(11) unsigned NOT NULL COMMENT '生成时间',
  `UpdateTime` int(11) unsigned NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='账户收支明细表';

-- ----------------------------
-- Records of sxh_user_records
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_relation
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_relation`;
CREATE TABLE `sxh_user_relation` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `UserID` int(11) NOT NULL COMMENT '用户ID',
  `PID1` int(11) unsigned NOT NULL COMMENT '父1级ID',
  `PID2` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父2级ID',
  `PID3` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父3级ID',
  `PID4` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父4级ID',
  `PID5` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父5级ID',
  `Url` varchar(50) NOT NULL COMMENT '父级路径，5层',
  `CreateTime` int(11) NOT NULL COMMENT '创建时间',
  `UpdateTime` int(11) NOT NULL COMMENT '更新时间',
  `CompLevel1` int(11) NOT NULL DEFAULT '0' COMMENT '企业用户关系-商务中心ID',
  `CompLevel2` int(11) NOT NULL DEFAULT '0' COMMENT '企业用户关系-招商员',
  PRIMARY KEY (`ID`),
  KEY `IDX_USERID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户关系表，上下层级关系';

-- ----------------------------
-- Records of sxh_user_relation
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_relation_bak
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_relation_bak`;
CREATE TABLE `sxh_user_relation_bak` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `UserID` int(11) NOT NULL COMMENT '用户ID',
  `PID1` int(11) unsigned NOT NULL COMMENT '父1级ID',
  `PID2` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父2级ID',
  `PID3` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父3级ID',
  `PID4` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父4级ID',
  `PID5` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父5级ID',
  `Url` varchar(50) NOT NULL COMMENT '父级路径，5层',
  `CreateTime` int(11) NOT NULL COMMENT '创建时间',
  `UpdateTime` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户关系表，上下层级关系';

-- ----------------------------
-- Records of sxh_user_relation_bak
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_sms
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_sms`;
CREATE TABLE `sxh_user_sms` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `UserID` int(11) unsigned NOT NULL COMMENT '用户ID',
  `Phone` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT '接收短信的手机号码',
  `Title` varchar(30) CHARACTER SET utf8 NOT NULL COMMENT '标题，接收短信的事件',
  `Code` varchar(10) CHARACTER SET utf8 NOT NULL DEFAULT '0' COMMENT '短信验证码',
  `Status` int(5) NOT NULL DEFAULT '0' COMMENT '接收状态 0 失败 1成功',
  `Verify` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '验证码是否使用过 0 未使用 1 使用',
  `IPAddress` varchar(40) NOT NULL COMMENT 'IP地址',
  `ValidTime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '验证码的有效时间 秒为单位，和CreateTime作对比',
  `MatchingID` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '专门给匹配通知用，匹配表的ID',
  `CreateTime` int(11) unsigned NOT NULL COMMENT '创建时间',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`,`Title`,`Status`),
  KEY `IDX_CODE_PHONE` (`Code`,`Phone`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='保存短信发送记录表';

-- ----------------------------
-- Records of sxh_user_sms
-- ----------------------------
INSERT INTO `sxh_user_sms` VALUES ('1', '1', '15018529770', '你好', '0', '0', '0', '', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_sms` VALUES ('2', '1', '15018529770', '你好', '0', '0', '0', '', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_sms` VALUES ('3', '2', '15018529770', '您的资料审核通过', '0', '1', '0', '127.0.0.1', '0', '0', '1479908792', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_sms` VALUES ('4', '1', '15279126033', '您的资料审核通过', '0', '1', '0', '127.0.0.1', '0', '0', '1479908792', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for sxh_user_stoppay
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_stoppay`;
CREATE TABLE `sxh_user_stoppay` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID流水号',
  `PID` int(11) unsigned NOT NULL COMMENT '不打款的匹配表ID',
  `UserID` int(11) unsigned NOT NULL COMMENT '不付款的用户ID',
  `Message` varchar(200) NOT NULL COMMENT '不打款理由',
  `OtherUserID` int(11) unsigned NOT NULL COMMENT '不打款给对方的接受用户ID',
  `IPAddress` varchar(30) NOT NULL COMMENT 'IP地址',
  `CreateTime` datetime NOT NULL COMMENT '创建时间',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sxh_user_stoppay
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_title
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_title`;
CREATE TABLE `sxh_user_title` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `Title` varchar(30) CHARACTER SET utf8 NOT NULL COMMENT '新闻公告标题',
  `Sort` int(5) unsigned NOT NULL COMMENT '排序',
  `CreateTime` datetime NOT NULL COMMENT '创建时间',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sxh_user_title
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_type
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_type`;
CREATE TABLE `sxh_user_type` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `Mark` int(11) unsigned NOT NULL COMMENT '类型ID',
  `Name` varchar(30) NOT NULL COMMENT '用户类型名称',
  `Info` text NOT NULL COMMENT '备注',
  `CreateTime` datetime NOT NULL COMMENT '创建时间',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sxh_user_type
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_working
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_working`;
CREATE TABLE `sxh_user_working` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `UserID` int(11) NOT NULL,
  `Record` varchar(30) NOT NULL COMMENT '操作记录',
  `RegUserID` int(11) NOT NULL COMMENT '审核的ID',
  `CreateTime` datetime NOT NULL COMMENT '创建时间',
  `UpdateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=475 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sxh_user_working
-- ----------------------------
INSERT INTO `sxh_user_working` VALUES ('1', '2', '管理员测试用户在2016-11-21 19:16:30审核了', '19', '2016-11-21 19:16:30', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('2', '2', '管理员测试用户在2016-11-21 19:22:20审核了', '19', '2016-11-21 19:22:20', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('3', '2', '管理员测试用户在2016-11-21 19:23:34审核了', '19', '2016-11-21 19:23:34', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('4', '2', '管理员测试用户在2016-11-21 19:24:30审核了', '19', '2016-11-21 19:24:30', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('5', '2', '管理员测试用户在2016-11-21 19:25:25审核了', '19', '2016-11-21 19:25:25', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('6', '2', '管理员测试用户在2016-11-21 19:26:06审核了', '19', '2016-11-21 19:26:06', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('7', '2', '管理员测试用户在2016-11-21 19:40:16审核了', '20', '2016-11-21 19:40:16', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('8', '2', '管理员测试用户在2016-11-21 19:40:44审核了', '20', '2016-11-21 19:40:44', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('9', '2', '管理员测试用户在2016-11-21 19:41:48审核了', '20', '2016-11-21 19:41:48', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('10', '2', '管理员测试用户在2016-11-21 19:43:31审核了', '20', '2016-11-21 19:43:31', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('11', '2', '管理员测试用户在2016-11-21 19:43:37审核了', '20', '2016-11-21 19:43:37', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('12', '2', '管理员测试用户在2016-11-21 19:43:50审核了', '20', '2016-11-21 19:43:50', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('13', '2', '管理员测试用户在2016-11-21 19:47:50审核了', '20', '2016-11-21 19:47:50', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('14', '2', '管理员测试用户在2016-11-21 19:48:03审核了', '20', '2016-11-21 19:48:03', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('15', '2', '管理员测试用户在2016-11-21 19:50:03审核了', '20', '2016-11-21 19:50:03', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('16', '2', '管理员测试用户在2016-11-21 19:50:31审核了', '20', '2016-11-21 19:50:31', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('17', '2', '管理员测试用户在2016-11-21 19:50:50审核了', '20', '2016-11-21 19:50:50', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('18', '2', '管理员测试用户在2016-11-21 19:51:23审核了', '20', '2016-11-21 19:51:23', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('19', '2', '管理员测试用户在2016-11-21 19:51:58审核了', '20', '2016-11-21 19:51:58', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('20', '2', '管理员测试用户在2016-11-21 19:54:49审核了', '20', '2016-11-21 19:54:49', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('21', '2', '管理员测试用户在2016-11-21 19:57:40审核了', '20', '2016-11-21 19:57:40', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('22', '2', '管理员测试用户在2016-11-21 20:07:46审核了', '19', '2016-11-21 20:07:46', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('23', '2', '管理员测试用户在2016-11-21 20:07:49审核了', '19', '2016-11-21 20:07:49', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('24', '2', '管理员测试用户在2016-11-21 20:08:09审核了', '19', '2016-11-21 20:08:09', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('25', '2', '管理员测试用户在2016-11-21 20:08:58审核了', '19', '2016-11-21 20:08:58', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('26', '2', '管理员测试用户在2016-11-21 20:09:30审核了', '19', '2016-11-21 20:09:30', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('27', '2', '管理员测试用户在2016-11-21 20:09:35审核了', '19', '2016-11-21 20:09:35', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('28', '2', '管理员测试用户在2016-11-21 20:10:23审核了', '19', '2016-11-21 20:10:23', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('29', '2', '管理员测试用户在2016-11-21 20:10:27审核了', '19', '2016-11-21 20:10:27', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('30', '2', '管理员测试用户在2016-11-21 20:12:08审核了', '19', '2016-11-21 20:12:08', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('31', '2', '管理员测试用户在2016-11-21 20:12:19审核了', '19', '2016-11-21 20:12:19', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('32', '2', '测试用户在2016-11-21 20:16:53审核了会员用', '19', '2016-11-21 20:16:53', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('33', '2', '测试用户在2016-11-21 20:18:38审核了会员用', '19', '2016-11-21 20:18:38', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('34', '2', '测试用户在2016-11-21 20:19:28审核了会员用', '19', '2016-11-21 20:19:28', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('35', '2', '测试用户在2016-11-21 20:31:08审核了会员用', '19', '2016-11-21 20:31:08', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('36', '2', '测试用户在2016-11-21 20:31:31审核了会员用', '20', '2016-11-21 20:31:31', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('37', '2', '管理员测试用户在2016-11-21 22:43:58审核了', '6', '2016-11-21 22:43:58', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('38', '2', '管理员测试用户在2016-11-21 22:44:34审核了', '13', '2016-11-21 22:44:34', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('39', '2', '', '20', '2016-11-21 22:55:02', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('40', '2', '', '1', '2016-11-21 23:44:40', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('41', '2', '', '2', '2016-11-22 01:07:30', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('42', '2', '', '1', '2016-11-22 09:26:21', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('43', '2', '', '1', '2016-11-22 09:44:19', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('44', '2', '', '1', '2016-11-22 09:44:21', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('45', '1', '', '1', '2016-11-23 00:04:54', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('46', '1', '', '1', '2016-11-23 00:05:15', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('47', '1', '', '1', '2016-11-23 00:07:43', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('48', '1', '', '2', '2016-11-23 00:11:38', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('49', '1', '', '2', '2016-11-23 00:12:20', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('50', '1', '', '2', '2016-11-23 00:16:46', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('51', '1', '', '2', '2016-11-23 00:19:45', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('52', '1', '', '1', '2016-11-23 00:19:54', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('53', '1', '', '1', '2016-11-23 00:24:28', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('54', '1', '', '2', '2016-11-23 00:25:14', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('55', '1', '', '3', '2016-11-23 00:28:19', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('56', '2', '', '3', '2016-11-23 09:51:25', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('57', '2', '', '5', '2016-11-23 09:51:36', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('58', '1', '', '1', '2016-11-23 10:33:13', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('59', '1', '', '6', '2016-11-23 10:33:21', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('60', '1', '', '6', '2016-11-23 10:33:29', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('61', '2', '', '1', '2016-11-23 10:38:21', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('62', '2', '', '1', '2016-11-23 10:49:12', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('63', '2', '', '1', '2016-11-23 10:52:04', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('64', '2', '', '1', '2016-11-23 10:52:12', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('65', '2', '', '81', '2016-11-23 14:49:04', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('66', '2', '', '82', '2016-11-23 14:49:11', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('67', '2', '', '81', '2016-11-23 14:49:20', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('68', '2', '', '81', '2016-11-23 14:49:26', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('69', '2', '', '81', '2016-11-23 14:49:30', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('70', '2', '', '81', '2016-11-23 15:11:51', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('71', '2', '', '81', '2016-11-23 15:18:47', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('72', '2', '', '81', '2016-11-23 15:19:00', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('73', '2', '', '81', '2016-11-23 15:27:29', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('74', '2', '', '81', '2016-11-23 15:27:55', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('75', '2', '', '81', '2016-11-23 15:27:55', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('76', '2', '', '81', '2016-11-23 15:28:02', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('77', '2', '', '81', '2016-11-23 15:28:02', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('78', '2', '', '81', '2016-11-23 15:28:09', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('79', '2', '', '84', '2016-11-23 15:28:09', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('80', '2', '', '81', '2016-11-23 15:28:57', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('81', '2', '', '81', '2016-11-23 15:29:09', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('82', '2', '', '81', '2016-11-23 15:29:10', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('83', '2', '', '81', '2016-11-23 15:29:15', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('84', '2', '', '81', '2016-11-23 15:29:15', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('85', '2', '', '85', '2016-11-23 15:34:07', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('86', '2', '', '85', '2016-11-23 15:34:13', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('87', '2', '', '85', '2016-11-23 15:34:29', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('88', '2', '', '81', '2016-11-23 15:34:30', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('89', '2', '', '81', '2016-11-23 15:34:37', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('90', '2', '', '81', '2016-11-23 15:34:45', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('91', '2', '', '81', '2016-11-23 15:34:51', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('92', '2', '', '81', '2016-11-23 15:34:59', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('93', '2', '', '81', '2016-11-23 15:35:07', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('94', '2', '', '81', '2016-11-23 15:35:16', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('95', '2', '', '81', '2016-11-23 15:35:21', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('96', '2', '', '81', '2016-11-23 15:36:00', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('97', '2', '', '81', '2016-11-23 15:36:05', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('98', '2', '', '81', '2016-11-23 15:36:09', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('99', '2', '', '81', '2016-11-23 15:36:14', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('100', '2', '', '81', '2016-11-23 15:36:19', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('101', '2', '', '81', '2016-11-23 15:36:24', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('102', '2', '', '81', '2016-11-23 15:37:15', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('103', '2', '', '81', '2016-11-23 15:37:22', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('104', '2', '', '81', '2016-11-23 15:37:27', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('105', '2', '', '81', '2016-11-23 15:37:32', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('106', '2', '', '81', '2016-11-23 15:37:36', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('107', '2', '', '81', '2016-11-23 15:38:05', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('108', '2', '', '81', '2016-11-23 15:38:11', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('109', '2', '', '81', '2016-11-23 15:38:17', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('110', '2', '', '83', '2016-11-23 15:38:51', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('111', '2', '', '81', '2016-11-23 15:38:59', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('112', '2', '', '86', '2016-11-23 15:39:18', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('113', '2', '', '92', '2016-11-23 15:44:42', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('114', '2', '', '88', '2016-11-23 15:44:57', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('115', '2', '', '88', '2016-11-23 15:45:20', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('116', '2', '', '88', '2016-11-23 15:45:30', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('117', '2', '', '81', '2016-11-23 15:46:31', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('118', '2', '', '98', '2016-11-23 15:46:32', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('119', '2', '', '81', '2016-11-23 15:46:36', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('120', '2', '', '94', '2016-11-23 15:46:37', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('121', '2', '', '81', '2016-11-23 15:46:52', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('122', '2', '', '82', '2016-11-23 15:46:59', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('123', '2', '', '83', '2016-11-23 15:47:04', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('124', '2', '', '95', '2016-11-23 15:47:30', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('125', '2', '', '95', '2016-11-23 15:47:49', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('126', '2', '', '96', '2016-11-23 15:47:50', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('127', '2', '', '95', '2016-11-23 15:48:08', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('128', '2', '', '84', '2016-11-23 15:48:08', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('129', '2', '', '95', '2016-11-23 15:48:21', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('130', '2', '', '84', '2016-11-23 15:48:22', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('131', '2', '', '81', '2016-11-23 15:48:22', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('132', '2', '', '82', '2016-11-23 15:49:45', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('133', '2', '', '81', '2016-11-23 15:50:27', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('134', '2', '', '81', '2016-11-23 15:50:38', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('135', '2', '', '85', '2016-11-23 15:50:48', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('136', '2', '', '81', '2016-11-23 15:51:07', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('137', '2', '', '81', '2016-11-23 15:51:30', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('138', '2', '', '83', '2016-11-23 15:52:23', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('139', '2', '', '85', '2016-11-23 15:52:28', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('140', '2', '', '83', '2016-11-23 15:53:07', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('141', '2', '', '81', '2016-11-23 15:53:56', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('142', '2', '', '81', '2016-11-23 15:54:08', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('143', '2', '', '81', '2016-11-23 15:54:09', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('144', '2', '', '81', '2016-11-23 15:54:13', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('145', '2', '', '81', '2016-11-23 15:54:17', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('146', '2', '', '81', '2016-11-23 15:54:23', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('147', '2', '', '81', '2016-11-23 15:54:28', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('148', '2', '', '81', '2016-11-23 15:54:34', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('149', '2', '', '93', '2016-11-23 15:54:34', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('150', '2', '', '81', '2016-11-23 15:54:40', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('151', '2', '', '93', '2016-11-23 15:54:40', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('152', '2', '', '81', '2016-11-23 15:54:41', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('153', '2', '', '93', '2016-11-23 15:54:41', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('154', '2', '', '81', '2016-11-23 15:54:42', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('155', '2', '', '93', '2016-11-23 15:54:42', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('156', '2', '', '81', '2016-11-23 15:54:47', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('157', '2', '', '96', '2016-11-23 15:54:47', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('158', '2', '', '81', '2016-11-23 15:54:53', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('159', '2', '', '96', '2016-11-23 15:54:53', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('160', '2', '', '81', '2016-11-23 15:54:58', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('161', '2', '', '93', '2016-11-23 15:54:58', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('162', '2', '', '81', '2016-11-23 15:55:02', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('163', '2', '', '93', '2016-11-23 15:55:03', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('164', '2', '', '81', '2016-11-23 15:55:24', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('165', '2', '', '100', '2016-11-23 15:55:24', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('166', '2', '', '81', '2016-11-23 15:55:44', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('167', '2', '', '100', '2016-11-23 15:55:44', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('168', '2', '', '99', '2016-11-23 15:55:44', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('169', '2', '', '81', '2016-11-23 15:56:20', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('170', '2', '', '81', '2016-11-23 15:56:27', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('171', '2', '', '81', '2016-11-23 16:17:54', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('172', '2', '', '81', '2016-11-23 16:39:22', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('173', '2', '', '81', '2016-11-23 16:39:26', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('174', '2', '', '81', '2016-11-23 16:39:29', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('175', '2', '', '81', '2016-11-23 16:39:37', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('176', '2', '', '81', '2016-11-23 16:39:44', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('177', '2', '', '82', '2016-11-23 16:39:49', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('178', '2', '', '83', '2016-11-23 16:39:54', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('179', '2', '', '84', '2016-11-23 16:40:00', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('180', '2', '', '81', '2016-11-23 16:40:57', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('181', '2', '', '81', '2016-11-23 16:45:36', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('182', '2', '', '82', '2016-11-23 16:45:45', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('183', '1', '', '4', '2016-11-23 16:57:02', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('184', '1', '', '3', '2016-11-23 16:57:07', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('185', '1', '', '3', '2016-11-23 16:57:11', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('186', '1', '', '3', '2016-11-23 16:57:16', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('187', '1', '', '3', '2016-11-23 16:57:18', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('188', '1', '', '1', '2016-11-23 16:57:24', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('189', '1', '', '1', '2016-11-23 16:57:36', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('190', '1', '', '1', '2016-11-23 16:57:44', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('191', '1', '', '1', '2016-11-23 16:59:09', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('192', '1', '', '1', '2016-11-23 17:00:03', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('193', '2', '测试用户进行了审核', '41', '2016-11-23 17:00:46', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('194', '2', '测试用户进行了审核', '41', '2016-11-23 17:01:22', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('195', '1', '', '21', '2016-11-23 17:05:44', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('196', '1', '', '2', '2016-11-23 17:06:29', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('197', '1', '', '1', '2016-11-23 17:06:48', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('198', '1', '', '1', '2016-11-23 17:08:12', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('199', '1', '', '21', '2016-11-23 17:08:46', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('200', '1', '', '21', '2016-11-23 17:09:22', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('201', '1', '', '21', '2016-11-23 17:13:02', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('202', '1', '', '41', '2016-11-23 17:13:35', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('203', '2', '测试用户进行了审核', '21', '2016-11-23 17:13:50', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('204', '1', '', '21', '2016-11-23 17:14:02', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('205', '1', '', '21', '2016-11-23 17:14:40', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('206', '2', '测试用户进行了审核', '21', '2016-11-23 17:15:15', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('207', '1', '', '1', '2016-11-23 17:19:05', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('208', '1', '', '1', '2016-11-23 17:19:10', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('209', '1', '', '1', '2016-11-23 17:19:14', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('210', '1', '', '1', '2016-11-23 17:19:17', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('211', '1', '', '1', '2016-11-23 17:19:29', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('212', '1', '', '1', '2016-11-23 17:19:34', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('213', '1', '', '1', '2016-11-23 17:20:02', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('214', '1', '', '1', '2016-11-23 17:20:10', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('215', '1', '', '41', '2016-11-23 17:20:29', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('216', '1', '', '42', '2016-11-23 17:20:42', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('217', '1', '', '42', '2016-11-23 17:20:43', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('218', '1', '', '42', '2016-11-23 17:20:43', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('219', '1', '', '42', '2016-11-23 17:20:44', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('220', '1', '', '1', '2016-11-23 17:21:36', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('221', '1', '', '10', '2016-11-23 17:22:06', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('222', '1', '', '10', '2016-11-23 17:22:42', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('223', '1', '', '10', '2016-11-23 17:22:55', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('224', '1', '', '7', '2016-11-23 17:23:17', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('225', '1', '', '1', '2016-11-23 17:24:47', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('226', '1', '', '1', '2016-11-23 17:25:58', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('227', '1', '', '1', '2016-11-23 17:26:10', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('228', '1', '', '1', '2016-11-23 17:26:20', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('229', '1', '', '1', '2016-11-23 17:26:30', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('230', '1', '', '1', '2016-11-23 17:26:46', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('231', '1', '', '1', '2016-11-23 17:26:53', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('232', '1', '', '1', '2016-11-23 17:27:02', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('233', '1', '', '1', '2016-11-23 17:27:08', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('234', '1', '', '21', '2016-11-23 17:27:30', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('235', '1', '', '24', '2016-11-23 17:28:12', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('236', '1', '', '21', '2016-11-23 17:29:07', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('237', '1', '', '21', '2016-11-23 17:29:39', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('238', '1', '', '1', '2016-11-23 17:31:33', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('239', '1', '', '1', '2016-11-23 17:31:39', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('240', '1', '', '21', '2016-11-23 17:32:01', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('241', '1', '', '22', '2016-11-23 17:32:09', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('242', '1', '', '1', '2016-11-23 17:43:28', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('243', '1', '', '1', '2016-11-23 17:43:33', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('244', '1', '', '1', '2016-11-23 17:43:40', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('245', '1', '', '1', '2016-11-23 17:43:58', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('246', '1', '', '1', '2016-11-23 18:03:39', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('247', '1', '', '1', '2016-11-23 18:05:51', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('248', '1', '', '1', '2016-11-23 18:07:17', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('249', '1', '', '1', '2016-11-23 18:13:27', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('250', '1', '', '1', '2016-11-23 18:13:42', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('251', '1', '', '1', '2016-11-23 18:13:49', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('252', '1', '', '1', '2016-11-23 18:13:53', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('253', '1', '', '1', '2016-11-23 18:16:24', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('254', '1', '', '1', '2016-11-23 18:17:16', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('255', '1', '', '1', '2016-11-23 18:17:24', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('256', '1', '', '1', '2016-11-23 18:19:18', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('257', '1', '', '1', '2016-11-23 18:19:41', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('258', '1', '', '3', '2016-11-23 18:22:24', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('259', '2', '测试用户进行了审核', '2', '2016-11-23 18:22:41', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('260', '1', '', '1', '2016-11-23 18:22:54', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('261', '1', '', '1', '2016-11-23 18:24:18', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('262', '1', '', '1', '2016-11-23 18:25:11', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('263', '1', '', '1', '2016-11-23 18:30:31', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('264', '1', '', '1', '2016-11-23 18:30:37', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('265', '1', '', '1', '2016-11-23 18:30:51', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('266', '1', '', '1', '2016-11-23 18:30:59', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('267', '1', '', '1', '2016-11-23 18:31:08', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('268', '1', '', '8', '2016-11-23 18:31:43', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('269', '1', '', '8', '2016-11-23 18:43:09', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('270', '1', '', '6', '2016-11-23 18:46:30', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('271', '1', '', '6', '2016-11-23 18:46:38', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('272', '1', '', '3', '2016-11-23 19:31:41', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('273', '1', '', '4', '2016-11-23 19:31:57', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('274', '1', '', '9', '2016-11-23 19:33:58', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('275', '1', '', '9', '2016-11-23 19:34:36', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('276', '1', '', '9', '2016-11-23 19:34:43', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('277', '1', '', '7', '2016-11-23 19:38:16', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('278', '1', '', '1', '2016-11-23 19:38:33', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('279', '1', '', '1', '2016-11-23 19:38:36', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('280', '1', '', '1', '2016-11-23 19:40:57', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('281', '1', '', '10', '2016-11-23 19:41:08', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('282', '1', '', '3', '2016-11-23 19:42:01', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('283', '1', '', '1', '2016-11-23 19:44:36', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('284', '1', '', '1', '2016-11-23 19:48:11', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('285', '1', '', '89', '2016-11-23 19:52:02', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('286', '1', '', '84', '2016-11-23 19:52:36', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('287', '1', '', '28', '2016-11-23 19:53:09', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('288', '1', '', '28', '2016-11-23 19:53:21', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('289', '1', '', '40', '2016-11-23 19:53:42', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('290', '1', '', '11', '2016-11-23 19:55:20', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('291', '1', '', '11', '2016-11-23 19:55:25', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('292', '1', '', '11', '2016-11-23 19:55:32', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('293', '1', '', '11', '2016-11-23 19:55:38', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('294', '1', '', '11', '2016-11-23 19:55:42', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('295', '1', '', '1', '2016-11-23 19:55:58', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('296', '1', '', '1', '2016-11-23 19:56:04', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('297', '1', '', '21', '2016-11-23 19:56:19', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('298', '1', '', '23', '2016-11-23 19:56:34', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('299', '1', '', '32', '2016-11-23 19:58:51', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('300', '1', '', '34', '2016-11-23 19:59:13', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('301', '2', '', '81', '2016-11-23 20:01:37', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('302', '2', '', '81', '2016-11-23 20:01:53', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('303', '2', '', '83', '2016-11-23 20:03:21', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('304', '2', '', '81', '2016-11-23 20:03:22', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('305', '2', '测试用户进行了审核', '2', '2016-11-23 20:09:56', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('306', '1', '', '8', '2016-11-23 20:10:46', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('307', '1', '', '10', '2016-11-23 20:10:53', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('308', '1', '', '1', '2016-11-23 20:11:07', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('309', '1', '', '1', '2016-11-23 20:11:16', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('310', '1', '', '13', '2016-11-23 20:11:37', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('311', '1', '', '13', '2016-11-23 20:11:45', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('312', '1', '', '12', '2016-11-23 20:12:02', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('313', '1', '', '16', '2016-11-23 20:12:49', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('314', '1', '', '18', '2016-11-23 20:13:07', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('315', '1', '', '19', '2016-11-23 20:13:20', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('316', '1', '', '19', '2016-11-23 20:13:35', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('317', '1', '', '3', '2016-11-23 20:14:46', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('318', '1', '', '1', '2016-11-23 20:16:12', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('319', '1', '', '13', '2016-11-23 20:16:39', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('320', '1', '', '18', '2016-11-23 20:16:48', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('321', '1', '', '7', '2016-11-23 20:18:15', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('322', '1', '', '3', '2016-11-23 20:20:01', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('323', '1', '', '3', '2016-11-23 20:20:07', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('324', '1', '', '7', '2016-11-23 20:20:13', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('325', '1', '', '1', '2016-11-23 20:20:23', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('326', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 20:20:54', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('327', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 20:22:28', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('328', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 20:22:34', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('329', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 20:22:44', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('330', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 20:25:01', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('331', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 20:25:51', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('332', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 20:30:52', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('333', '1', '', '1', '2016-11-23 20:31:51', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('334', '1', '', '1', '2016-11-23 20:32:10', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('335', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 20:32:13', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('336', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 20:33:25', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('337', '1', '', '17', '2016-11-23 20:33:30', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('338', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 20:34:09', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('339', '1', '', '13', '2016-11-23 20:34:50', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('340', '1', '', '14', '2016-11-23 20:34:58', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('341', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 20:35:18', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('342', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 20:35:59', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('343', '1', '', '6', '2016-11-23 20:36:07', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('344', '1', '', '12', '2016-11-23 20:36:19', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('345', '1', '', '8', '2016-11-23 20:37:08', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('346', '1', '', '1', '2016-11-23 20:37:25', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('347', '1', '', '1', '2016-11-23 20:37:31', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('348', '1', '', '1', '2016-11-23 20:42:08', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('349', '1', '', '1', '2016-11-23 20:42:57', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('350', '1', '', '4', '2016-11-23 20:44:54', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('351', '1', '', '1', '2016-11-23 20:45:12', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('352', '1', '', '1', '2016-11-23 20:45:39', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('353', '1', '', '8', '2016-11-23 20:48:53', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('354', '1', '', '8', '2016-11-23 20:48:53', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('355', '1', '', '1', '2016-11-23 20:49:08', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('356', '1', '', '7', '2016-11-23 20:50:04', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('357', '1', '', '6', '2016-11-23 20:51:33', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('358', '1', '', '3', '2016-11-23 20:51:56', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('359', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 20:52:26', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('360', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 20:52:45', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('361', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 20:52:46', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('362', '1', '', '3', '2016-11-23 20:53:36', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('363', '1', '', '1', '2016-11-23 20:54:34', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('364', '1', '', '1', '2016-11-23 20:54:58', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('365', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 20:55:46', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('366', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 20:55:48', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('367', '1', '', '1', '2016-11-23 20:56:06', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('368', '1', '', '1', '2016-11-23 20:56:51', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('369', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 20:57:27', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('370', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 20:57:28', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('371', '1', '', '6', '2016-11-23 20:57:48', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('372', '1', '', '6', '2016-11-23 20:58:18', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('373', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 20:59:05', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('374', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 20:59:06', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('375', '1', '', '2', '2016-11-23 21:00:17', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('376', '1', '', '4', '2016-11-23 21:00:36', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('377', '1', '', '1', '2016-11-23 21:00:55', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('378', '1', '', '4', '2016-11-23 21:01:23', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('379', '1', '', '3', '2016-11-23 21:02:42', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('380', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 21:03:39', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('381', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 21:03:40', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('382', '1', '', '3', '2016-11-23 21:05:32', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('383', '1', '', '10', '2016-11-23 21:05:46', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('384', '1', '', '13', '2016-11-23 21:06:05', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('385', '1', '', '10', '2016-11-23 21:07:38', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('386', '1', '', '11', '2016-11-23 21:07:51', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('387', '1', '', '19', '2016-11-23 21:07:57', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('388', '1', '', '19', '2016-11-23 21:08:03', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('389', '1', '', '14', '2016-11-23 21:08:06', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('390', '1', '', '8', '2016-11-23 21:08:58', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('391', '1', '', '10', '2016-11-23 21:09:06', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('392', '1', '', '15', '2016-11-23 21:09:11', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('393', '1', '', '3', '2016-11-23 21:16:25', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('394', '1', '', '6', '2016-11-23 21:16:31', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('395', '1', '', '9', '2016-11-23 21:16:42', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('396', '1', '', '10', '2016-11-23 21:16:48', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('397', '1', '', '15', '2016-11-23 21:17:05', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('398', '1', '', '15', '2016-11-23 21:17:17', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('399', '1', '', '14', '2016-11-23 21:17:22', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('400', '1', '', '12', '2016-11-23 21:17:26', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('401', '1', '', '12', '2016-11-23 21:17:31', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('402', '1', '', '15', '2016-11-23 21:18:13', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('403', '1', '', '14', '2016-11-23 21:18:22', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('404', '1', '', '6', '2016-11-23 21:18:51', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('405', '1', '', '13', '2016-11-23 21:19:04', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('406', '1', '', '10', '2016-11-23 21:19:16', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('407', '1', '', '7', '2016-11-23 21:19:54', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('408', '1', '', '8', '2016-11-23 21:20:13', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('409', '1', '', '9', '2016-11-23 21:20:22', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('410', '1', '', '9', '2016-11-23 21:20:26', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('411', '1', '', '20', '2016-11-23 21:20:34', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('412', '1', '', '12', '2016-11-23 21:20:44', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('413', '1', '', '5', '2016-11-23 21:21:16', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('414', '1', '', '5', '2016-11-23 21:21:24', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('415', '1', '', '5', '2016-11-23 21:21:28', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('416', '1', '', '26', '2016-11-23 21:21:41', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('417', '1', '', '1', '2016-11-23 21:22:14', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('418', '1', '', '3', '2016-11-23 21:22:24', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('419', '1', '', '14', '2016-11-23 21:24:24', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('420', '1', '', '14', '2016-11-23 21:24:30', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('421', '1', '', '20', '2016-11-23 21:24:41', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('422', '1', '', '40', '2016-11-23 21:24:48', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('423', '1', '', '17', '2016-11-23 21:25:25', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('424', '1', '', '20', '2016-11-23 21:25:33', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('425', '1', '', '40', '2016-11-23 21:25:41', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('426', '1', '', '40', '2016-11-23 21:25:45', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('427', '1', '', '32', '2016-11-23 21:25:53', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('428', '1', '', '100', '2016-11-23 21:26:16', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('429', '1', '', '92', '2016-11-23 21:26:37', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('430', '2', '', '81', '2016-11-23 21:28:35', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('431', '2', '', '81', '2016-11-23 21:28:41', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('432', '2', '测试用户审核了会员湛开慧', '2', '2016-11-23 21:28:48', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('433', '2', '', '83', '2016-11-23 21:31:12', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('434', '2', '', '89', '2016-11-23 21:31:18', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('435', '2', '', '92', '2016-11-23 21:31:23', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('436', '2', '', '100', '2016-11-23 21:31:28', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('437', '2', '', '100', '2016-11-23 21:31:32', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('438', '2', '', '100', '2016-11-23 21:31:35', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('439', '2', '', '1', '2016-11-23 21:37:22', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('440', '2', '', '5', '2016-11-23 21:37:46', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('441', '2', '', '1', '2016-11-23 21:37:56', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('442', '2', '测试用户审核了会员sunlianggen', '1', '2016-11-23 21:43:47', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('443', '2', '', '1', '2016-11-23 21:44:40', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('444', '2', '', '43', '2016-11-23 21:45:20', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('445', '2', '', '43', '2016-11-23 21:46:06', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('446', '2', '', '43', '2016-11-23 21:46:11', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('447', '2', '', '43', '2016-11-23 21:46:30', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('448', '2', '', '43', '2016-11-23 21:49:44', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('449', '2', '', '43', '2016-11-23 21:51:07', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('450', '2', '', '43', '2016-11-23 21:51:18', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('451', '2', '', '43', '2016-11-23 21:51:57', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('452', '2', '', '43', '2016-11-23 21:55:22', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('453', '2', '', '43', '2016-11-23 21:55:29', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('454', '2', '', '47', '2016-11-23 21:55:40', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('455', '2', '', '45', '2016-11-23 21:56:06', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('456', '2', '', '48', '2016-11-23 21:56:27', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('457', '2', '', '51', '2016-11-23 21:56:38', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('458', '2', '', '48', '2016-11-23 21:56:48', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('459', '2', '', '48', '2016-11-23 21:57:59', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('460', '2', '', '52', '2016-11-23 21:58:33', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('461', '2', '', '53', '2016-11-23 21:59:17', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('462', '2', '', '55', '2016-11-23 22:01:09', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('463', '2', '', '61', '2016-11-23 22:02:41', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('464', '2', '', '61', '2016-11-23 22:02:54', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('465', '2', '', '63', '2016-11-23 22:02:55', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('466', '2', '', '64', '2016-11-23 22:03:37', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('467', '2', '', '67', '2016-11-23 22:05:05', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('468', '2', '', '67', '2016-11-23 22:06:42', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('469', '2', '', '68', '2016-11-23 22:06:42', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('470', '2', '', '69', '2016-11-23 22:07:43', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('471', '2', '', '70', '2016-11-23 22:08:29', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('472', '2', '', '71', '2016-11-23 22:09:47', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('473', '2', '', '73', '2016-11-23 22:10:44', '0000-00-00 00:00:00');
INSERT INTO `sxh_user_working` VALUES ('474', '2', '', '74', '2016-11-23 22:11:39', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for sxh_userinfo
-- ----------------------------
DROP TABLE IF EXISTS `sxh_userinfo`;
CREATE TABLE `sxh_userinfo` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `UserID` int(11) NOT NULL COMMENT 'USER表的ID，用户ID',
  `Name` varchar(20) NOT NULL COMMENT '身份证上的姓名',
  `Email` varchar(150) NOT NULL COMMENT '电子邮件',
  `Phone` varchar(30) NOT NULL COMMENT '手机号码 唯一不能重复',
  `Address` varchar(250) NOT NULL COMMENT '收货地址',
  `City` varchar(20) NOT NULL COMMENT '居住地所在的城市',
  `AlpayAccount` varchar(30) NOT NULL COMMENT '支付宝帐号',
  `WeixinAccount` varchar(30) NOT NULL COMMENT '微信帐号',
  `BankName` varchar(50) NOT NULL COMMENT '开户银行名称',
  `BankAccount` varchar(50) NOT NULL COMMENT '银行帐号',
  `CardID` varchar(20) NOT NULL COMMENT '身份证号码',
  `Referee` varchar(20) NOT NULL,
  `RefereeID` int(11) NOT NULL DEFAULT '0',
  `ServiceName` varchar(64) DEFAULT NULL COMMENT '服务中心帐号',
  `ServiceID` int(11) DEFAULT '0' COMMENT '服务ID',
  `Province` varchar(20) NOT NULL COMMENT '所在省份',
  `Town` varchar(30) NOT NULL COMMENT '所在城市',
  `ActiveCode` varchar(5) NOT NULL COMMENT '激活码',
  `ImageA` varchar(20) NOT NULL COMMENT '身份证手持正面',
  `FolderA` varchar(10) NOT NULL COMMENT '保存图片A的文件夹',
  `ImageB` varchar(20) NOT NULL COMMENT '身份证手持正面',
  `FolderB` varchar(10) NOT NULL COMMENT '保存图片B的文件夹',
  `ImageC` varchar(20) NOT NULL COMMENT '身份证手持全身',
  `FolderC` varchar(10) NOT NULL COMMENT '保存图片C的文件夹',
  `CreateTime` int(11) NOT NULL COMMENT '创建时间',
  `UpdateTime` int(11) NOT NULL COMMENT '更新时间',
  `MembershipID` int(11) NOT NULL DEFAULT '0' COMMENT '招商员ID',
  `MembershipName` varchar(50) NOT NULL DEFAULT '' COMMENT '招商员名称',
  `BusinessCenterID` int(11) NOT NULL DEFAULT '0' COMMENT '隶属招商中心ID',
  `BusinessCenterName` varchar(50) NOT NULL DEFAULT '0' COMMENT '隶属招商中心名称',
  `ServiceNumber` char(10) NOT NULL DEFAULT '' COMMENT '服务中心编号',
  `TelNumber` char(15) DEFAULT '' COMMENT '善心号',
  `Avatar` char(20) NOT NULL DEFAULT '' COMMENT '会员图片',
  `Grade` tinyint(4) NOT NULL DEFAULT '0' COMMENT '评分数',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UserID_UNIQUE` (`UserID`),
  KEY `IDX_REFEREEID` (`RefereeID`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COMMENT='注册用户信息表';

-- ----------------------------
-- Records of sxh_userinfo
-- ----------------------------
INSERT INTO `sxh_userinfo` VALUES ('1', '1', 'sunlianggen', '', '15279126033', '地址1', '广州', '', '', '', '', '', 'test1', '1', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696789', '1479696789', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('2', '2', '湛开慧', '', '15018529770', '地址2', '深圳', '', '', '', '', '', 'test2', '2', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696789', '1479696789', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('3', '3', '用户3', 'test3@qq.com', '15013529186', '地址3', '广州', 'alipay3@qq.com', 'weixin3@qq.com', '邮政银行', '220559556990057101', '420222199012272595', 'test3', '3', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696790', '1479696790', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('4', '4', '用户4', 'test4@qq.com', '15013529509', '地址4', '深圳', 'alipay4@qq.com', 'weixin4@qq.com', '中国银行', '220559556990056147', '420222199012271413', 'test4', '4', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696790', '1479696790', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('5', '5', '用户5', 'test5@qq.com', '15013529964', '地址5', '广州', 'alipay5@qq.com', 'weixin5@qq.com', '邮政银行', '220559556990058646', '420222199012277695', 'test5', '5', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696790', '1479696790', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('6', '6', '用户6', 'test6@qq.com', '15013529290', '地址6', '深圳', 'alipay6@qq.com', 'weixin6@qq.com', '中国银行', '220559556990053591', '420222199012278654', 'test6', '6', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696790', '1479696790', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('7', '7', '用户7', 'test7@qq.com', '15013529728', '地址7', '广州', 'alipay7@qq.com', 'weixin7@qq.com', '邮政银行', '220559556990058767', '420222199012277212', 'test7', '7', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696790', '1479696790', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('8', '8', '用户8', 'test8@qq.com', '15013529892', '地址8', '深圳', 'alipay8@qq.com', 'weixin8@qq.com', '中国银行', '220559556990052144', '420222199012271694', 'test8', '8', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696790', '1479696790', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('9', '9', '用户9', 'test9@qq.com', '15013529537', '地址9', '广州', 'alipay9@qq.com', 'weixin9@qq.com', '邮政银行', '220559556990058135', '420222199012271918', 'test9', '9', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696790', '1479696790', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('10', '10', '用户10', 'test10@qq.com', '15013529366', '地址10', '深圳', 'alipay10@qq.com', 'weixin10@qq.com', '中国银行', '220559556990053712', '420222199012271629', 'test10', '10', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696791', '1479696791', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('11', '11', '用户11', 'test11@qq.com', '15013529392', '地址11', '广州', 'alipay11@qq.com', 'weixin11@qq.com', '邮政银行', '220559556990054441', '420222199012276225', 'test11', '11', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696791', '1479696791', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('12', '12', '用户12', 'test12@qq.com', '15013529301', '地址12', '深圳', 'alipay12@qq.com', 'weixin12@qq.com', '中国银行', '220559556990055706', '420222199012276362', 'test12', '12', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696791', '1479696791', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('13', '13', '用户13', 'test13@qq.com', '15013529299', '地址13', '广州', 'alipay13@qq.com', 'weixin13@qq.com', '邮政银行', '220559556990054862', '420222199012274941', 'test13', '13', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696791', '1479696791', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('14', '14', '用户14', 'test14@qq.com', '15013529750', '地址14', '深圳', 'alipay14@qq.com', 'weixin14@qq.com', '中国银行', '220559556990056691', '420222199012277718', 'test14', '14', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696791', '1479696791', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('15', '15', '用户15', 'test15@qq.com', '15013529309', '地址15', '广州', 'alipay15@qq.com', 'weixin15@qq.com', '邮政银行', '220559556990059787', '420222199012279272', 'test15', '15', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696791', '1479696791', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('16', '16', '用户16', 'test16@qq.com', '15013529879', '地址16', '深圳', 'alipay16@qq.com', 'weixin16@qq.com', '中国银行', '220559556990055870', '420222199012274191', 'test16', '16', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696792', '1479696792', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('17', '17', '6456456', '', '', '地址17', '广州', '', '', '', '', '', 'test17', '17', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696792', '1479696792', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('18', '18', '用户18', 'test18@qq.com', '15013529668', '地址18', '深圳', 'alipay18@qq.com', 'weixin18@qq.com', '中国银行', '220559556990053579', '420222199012277333', 'test18', '18', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696792', '1479696792', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('19', '19', '用户19', 'test19@qq.com', '15013529391', '地址19', '广州', 'alipay19@qq.com', 'weixin19@qq.com', '邮政银行', '220559556990052394', '420222199012274172', 'test19', '19', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696792', '1479696792', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('20', '20', '用户20', 'test20@qq.com', '15013529732', '地址20', '深圳', 'alipay20@qq.com', 'weixin20@qq.com', '中国银行', '220559556990056067', '420222199012272346', 'test20', '20', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696792', '1479696792', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('21', '21', '用户21', 'test21@qq.com', '15013529343', '地址21', '广州', 'alipay21@qq.com', 'weixin21@qq.com', '邮政银行', '220559556990057507', '420222199012279286', 'test21', '21', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696792', '1479696792', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('22', '22', '用户22', 'test22@qq.com', '15013529846', '地址22', '深圳', 'alipay22@qq.com', 'weixin22@qq.com', '中国银行', '220559556990052020', '420222199012274187', 'test22', '22', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696793', '1479696793', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('23', '23', '用户23', 'test23@qq.com', '15013529978', '地址23', '广州', 'alipay23@qq.com', 'weixin23@qq.com', '邮政银行', '220559556990054663', '420222199012276149', 'test23', '23', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696793', '1479696793', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('24', '24', '用户24', 'test24@qq.com', '15013529931', '地址24', '深圳', 'alipay24@qq.com', 'weixin24@qq.com', '中国银行', '220559556990057804', '420222199012272525', 'test24', '24', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696793', '1479696793', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('25', '25', '用户25', 'test25@qq.com', '15013529287', '地址25', '广州', 'alipay25@qq.com', 'weixin25@qq.com', '邮政银行', '220559556990051901', '420222199012272684', 'test25', '25', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696793', '1479696793', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('26', '26', '用户26', 'test26@qq.com', '15013529776', '地址26', '深圳', 'alipay26@qq.com', 'weixin26@qq.com', '中国银行', '220559556990059977', '420222199012271055', 'test26', '26', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696793', '1479696793', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('27', '27', '用户27', 'test27@qq.com', '15013529145', '地址27', '广州', 'alipay27@qq.com', 'weixin27@qq.com', '邮政银行', '220559556990056713', '420222199012279712', 'test27', '27', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696793', '1479696793', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('28', '28', '用户28', 'test28@qq.com', '15013529991', '地址28', '深圳', 'alipay28@qq.com', 'weixin28@qq.com', '中国银行', '220559556990053456', '420222199012273201', 'test28', '28', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696793', '1479696793', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('29', '29', '用户29', 'test29@qq.com', '15013529737', '地址29', '广州', 'alipay29@qq.com', 'weixin29@qq.com', '邮政银行', '220559556990054144', '420222199012272428', 'test29', '29', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696794', '1479696794', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('30', '30', '用户30', 'test30@qq.com', '15013529291', '地址30', '深圳', 'alipay30@qq.com', 'weixin30@qq.com', '中国银行', '220559556990052222', '420222199012275784', 'test30', '30', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696794', '1479696794', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('31', '31', '用户31', 'test31@qq.com', '15013529631', '地址31', '广州', 'alipay31@qq.com', 'weixin31@qq.com', '邮政银行', '220559556990054010', '420222199012277466', 'test31', '31', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696794', '1479696794', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('32', '32', '用户32', 'test32@qq.com', '15013529237', '地址32', '深圳', 'alipay32@qq.com', 'weixin32@qq.com', '中国银行', '220559556990056231', '420222199012272761', 'test32', '32', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696794', '1479696794', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('33', '33', '用户33', 'test33@qq.com', '15013529848', '地址33', '广州', 'alipay33@qq.com', 'weixin33@qq.com', '邮政银行', '220559556990053428', '420222199012277722', 'test33', '33', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696794', '1479696794', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('34', '34', '用户34', 'test34@qq.com', '15013529463', '地址34', '深圳', 'alipay34@qq.com', 'weixin34@qq.com', '中国银行', '220559556990053498', '420222199012276903', 'test34', '34', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696794', '1479696794', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('35', '35', '用户35', 'test35@qq.com', '15013529567', '地址35', '广州', 'alipay35@qq.com', 'weixin35@qq.com', '邮政银行', '220559556990053436', '420222199012277970', 'test35', '35', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696795', '1479696795', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('36', '36', '用户36', 'test36@qq.com', '15013529196', '地址36', '深圳', 'alipay36@qq.com', 'weixin36@qq.com', '中国银行', '220559556990057568', '420222199012276988', 'test36', '36', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696795', '1479696795', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('37', '37', '用户37', 'test37@qq.com', '15013529701', '地址37', '广州', 'alipay37@qq.com', 'weixin37@qq.com', '邮政银行', '220559556990059752', '420222199012277035', 'test37', '37', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696795', '1479696795', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('38', '38', '用户38', 'test38@qq.com', '15013529197', '地址38', '深圳', 'alipay38@qq.com', 'weixin38@qq.com', '中国银行', '220559556990059353', '420222199012273553', 'test38', '38', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696795', '1479696795', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('39', '39', '用户39', 'test39@qq.com', '15013529489', '地址39', '广州', 'alipay39@qq.com', 'weixin39@qq.com', '邮政银行', '220559556990054514', '420222199012275269', 'test39', '39', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696795', '1479696795', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('40', '40', '用户40', 'test40@qq.com', '15013529323', '地址40', '深圳', 'alipay40@qq.com', 'weixin40@qq.com', '中国银行', '220559556990059247', '420222199012272194', 'test40', '40', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696795', '1479696795', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('41', '41', '用户41', 'test41@qq.com', '15013529921', '地址41', '广州', 'alipay41@qq.com', 'weixin41@qq.com', '邮政银行', '220559556990059486', '420222199012272948', 'test41', '41', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696795', '1479696795', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('42', '42', '用户42', 'test42@qq.com', '15013529857', '地址42', '深圳', 'alipay42@qq.com', 'weixin42@qq.com', '中国银行', '220559556990054920', '420222199012271073', 'test42', '42', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696796', '1479696796', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('43', '43', '用户43', 'test43@qq.com', '15013529223', '地址43', '广州', 'alipay43@qq.com', 'weixin43@qq.com', '邮政银行', '220559556990054879', '420222199012271094', 'test43', '43', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696796', '1479696796', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('44', '44', '用户44', 'test44@qq.com', '15013529245', '地址44', '深圳', 'alipay44@qq.com', 'weixin44@qq.com', '中国银行', '220559556990056420', '420222199012278375', 'test44', '44', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696796', '1479696796', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('45', '45', '用户45', 'test45@qq.com', '15013529508', '地址45', '广州', 'alipay45@qq.com', 'weixin45@qq.com', '邮政银行', '220559556990055075', '420222199012274001', 'test45', '45', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696796', '1479696796', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('46', '46', '用户46', 'test46@qq.com', '15013529193', '地址46', '深圳', 'alipay46@qq.com', 'weixin46@qq.com', '中国银行', '220559556990051747', '420222199012273642', 'test46', '46', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696797', '1479696797', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('47', '47', '用户47', 'test47@qq.com', '15013529236', '地址47', '广州', 'alipay47@qq.com', 'weixin47@qq.com', '邮政银行', '220559556990057112', '420222199012275653', 'test47', '47', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696797', '1479696797', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('48', '48', '用户48', 'test48@qq.com', '15013529594', '地址48', '深圳', 'alipay48@qq.com', 'weixin48@qq.com', '中国银行', '220559556990058066', '420222199012277467', 'test48', '48', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696797', '1479696797', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('49', '49', '用户49', 'test49@qq.com', '15013529850', '地址49', '广州', 'alipay49@qq.com', 'weixin49@qq.com', '邮政银行', '220559556990054502', '420222199012271812', 'test49', '49', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696797', '1479696797', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('50', '50', '用户50', 'test50@qq.com', '15013529585', '地址50', '深圳', 'alipay50@qq.com', 'weixin50@qq.com', '中国银行', '220559556990051123', '420222199012279510', 'test50', '50', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696797', '1479696797', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('51', '51', '用户51', 'test51@qq.com', '15013529907', '地址51', '广州', 'alipay51@qq.com', 'weixin51@qq.com', '邮政银行', '220559556990053964', '420222199012272318', 'test51', '51', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696797', '1479696797', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('52', '52', '用户52', 'test52@qq.com', '15013529475', '地址52', '深圳', 'alipay52@qq.com', 'weixin52@qq.com', '中国银行', '220559556990051589', '420222199012276837', 'test52', '52', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696798', '1479696798', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('53', '53', '用户53', 'test53@qq.com', '15013529968', '地址53', '广州', 'alipay53@qq.com', 'weixin53@qq.com', '邮政银行', '220559556990051493', '420222199012274196', 'test53', '53', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696798', '1479696798', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('54', '54', '用户54', 'test54@qq.com', '15013529757', '地址54', '深圳', 'alipay54@qq.com', 'weixin54@qq.com', '中国银行', '220559556990059339', '420222199012277975', 'test54', '54', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696798', '1479696798', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('55', '55', '用户55', 'test55@qq.com', '15013529519', '地址55', '广州', 'alipay55@qq.com', 'weixin55@qq.com', '邮政银行', '220559556990058647', '420222199012271584', 'test55', '55', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696798', '1479696798', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('56', '56', '用户56', 'test56@qq.com', '15013529971', '地址56', '深圳', 'alipay56@qq.com', 'weixin56@qq.com', '中国银行', '220559556990055358', '420222199012278692', 'test56', '56', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696798', '1479696798', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('57', '57', '用户57', 'test57@qq.com', '15013529393', '地址57', '广州', 'alipay57@qq.com', 'weixin57@qq.com', '邮政银行', '220559556990055803', '420222199012275873', 'test57', '57', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696798', '1479696798', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('58', '58', '用户58', 'test58@qq.com', '15013529678', '地址58', '深圳', 'alipay58@qq.com', 'weixin58@qq.com', '中国银行', '220559556990051136', '420222199012274080', 'test58', '58', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696799', '1479696799', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('59', '59', '用户59', 'test59@qq.com', '15013529444', '地址59', '广州', 'alipay59@qq.com', 'weixin59@qq.com', '邮政银行', '220559556990051426', '420222199012275738', 'test59', '59', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696799', '1479696799', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('60', '60', '用户60', 'test60@qq.com', '15013529618', '地址60', '深圳', 'alipay60@qq.com', 'weixin60@qq.com', '中国银行', '220559556990057748', '420222199012272165', 'test60', '60', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696799', '1479696799', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('61', '61', '用户61', 'test61@qq.com', '15013529260', '地址61', '广州', 'alipay61@qq.com', 'weixin61@qq.com', '邮政银行', '220559556990056766', '420222199012271090', 'test61', '61', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696799', '1479696799', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('62', '62', '用户62', 'test62@qq.com', '15013529821', '地址62', '深圳', 'alipay62@qq.com', 'weixin62@qq.com', '中国银行', '220559556990056722', '420222199012277582', 'test62', '62', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696799', '1479696799', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('63', '63', '用户63', 'test63@qq.com', '15013529868', '地址63', '广州', 'alipay63@qq.com', 'weixin63@qq.com', '邮政银行', '220559556990054683', '420222199012273084', 'test63', '63', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696799', '1479696799', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('64', '64', '用户64', 'test64@qq.com', '15013529501', '地址64', '深圳', 'alipay64@qq.com', 'weixin64@qq.com', '中国银行', '220559556990051817', '420222199012278103', 'test64', '64', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696800', '1479696800', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('65', '65', '用户65', 'test65@qq.com', '15013529249', '地址65', '广州', 'alipay65@qq.com', 'weixin65@qq.com', '邮政银行', '220559556990053313', '420222199012275491', 'test65', '65', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696800', '1479696800', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('66', '66', '用户66', 'test66@qq.com', '15013529302', '地址66', '深圳', 'alipay66@qq.com', 'weixin66@qq.com', '中国银行', '220559556990055061', '420222199012274939', 'test66', '66', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696800', '1479696800', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('67', '67', '用户67', 'test67@qq.com', '15013529449', '地址67', '广州', 'alipay67@qq.com', 'weixin67@qq.com', '邮政银行', '220559556990053841', '420222199012279047', 'test67', '67', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696800', '1479696800', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('68', '68', '用户68', 'test68@qq.com', '15013529334', '地址68', '深圳', 'alipay68@qq.com', 'weixin68@qq.com', '中国银行', '220559556990053675', '420222199012277505', 'test68', '68', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696801', '1479696801', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('69', '69', '用户69', 'test69@qq.com', '15013529711', '地址69', '广州', 'alipay69@qq.com', 'weixin69@qq.com', '邮政银行', '220559556990054824', '420222199012272449', 'test69', '69', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696801', '1479696801', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('70', '70', '用户70', 'test70@qq.com', '15013529427', '地址70', '深圳', 'alipay70@qq.com', 'weixin70@qq.com', '中国银行', '220559556990054975', '420222199012275821', 'test70', '70', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696801', '1479696801', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('71', '71', '用户71', 'test71@qq.com', '15013529153', '地址71', '广州', 'alipay71@qq.com', 'weixin71@qq.com', '邮政银行', '220559556990054328', '420222199012275922', 'test71', '71', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696801', '1479696801', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('72', '72', '用户72', 'test72@qq.com', '15013529377', '地址72', '深圳', 'alipay72@qq.com', 'weixin72@qq.com', '中国银行', '220559556990057952', '420222199012271805', 'test72', '72', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696801', '1479696801', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('73', '73', '用户73', 'test73@qq.com', '15013529602', '地址73', '广州', 'alipay73@qq.com', 'weixin73@qq.com', '邮政银行', '220559556990054882', '420222199012271550', 'test73', '73', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696801', '1479696801', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('74', '74', '用户74', 'test74@qq.com', '15013529620', '地址74', '深圳', 'alipay74@qq.com', 'weixin74@qq.com', '中国银行', '220559556990053023', '420222199012271346', 'test74', '74', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696801', '1479696801', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('75', '75', '用户75', 'test75@qq.com', '15013529413', '地址75', '广州', 'alipay75@qq.com', 'weixin75@qq.com', '邮政银行', '220559556990057562', '420222199012278835', 'test75', '75', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696802', '1479696802', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('76', '76', '用户76', 'test76@qq.com', '15013529262', '地址76', '深圳', 'alipay76@qq.com', 'weixin76@qq.com', '中国银行', '220559556990059579', '420222199012271576', 'test76', '76', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696802', '1479696802', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('77', '77', '用户77', 'test77@qq.com', '15013529755', '地址77', '广州', 'alipay77@qq.com', 'weixin77@qq.com', '邮政银行', '220559556990056023', '420222199012271484', 'test77', '77', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696802', '1479696802', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('78', '78', '用户78', 'test78@qq.com', '15013529833', '地址78', '深圳', 'alipay78@qq.com', 'weixin78@qq.com', '中国银行', '220559556990059962', '420222199012273975', 'test78', '78', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696802', '1479696802', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('79', '79', '用户79', 'test79@qq.com', '15013529271', '地址79', '广州', 'alipay79@qq.com', 'weixin79@qq.com', '邮政银行', '220559556990051449', '420222199012273495', 'test79', '79', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696802', '1479696802', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('80', '80', '用户80', 'test80@qq.com', '15013529321', '地址80', '深圳', 'alipay80@qq.com', 'weixin80@qq.com', '中国银行', '220559556990059323', '420222199012273910', 'test80', '80', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696803', '1479696803', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('81', '81', '用户81', 'test81@qq.com', '15013529949', '地址81', '广州', 'alipay81@qq.com', 'weixin81@qq.com', '邮政银行', '220559556990055533', '420222199012279855', 'test81', '81', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696803', '1479696803', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('82', '82', '用户82', 'test82@qq.com', '15013529864', '地址82', '深圳', 'alipay82@qq.com', 'weixin82@qq.com', '中国银行', '220559556990054240', '420222199012272618', 'test82', '82', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696803', '1479696803', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('83', '83', '用户83', 'test83@qq.com', '15013529452', '地址83', '广州', 'alipay83@qq.com', 'weixin83@qq.com', '邮政银行', '220559556990057421', '420222199012278483', 'test83', '83', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696803', '1479696803', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('84', '84', '用户84', 'test84@qq.com', '15013529499', '地址84', '深圳', 'alipay84@qq.com', 'weixin84@qq.com', '中国银行', '220559556990058611', '420222199012278051', 'test84', '84', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696803', '1479696803', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('85', '85', '用户85', 'test85@qq.com', '15013529193', '地址85', '广州', 'alipay85@qq.com', 'weixin85@qq.com', '邮政银行', '220559556990051340', '420222199012274607', 'test85', '85', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696803', '1479696803', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('86', '86', '用户86', 'test86@qq.com', '15013529988', '地址86', '深圳', 'alipay86@qq.com', 'weixin86@qq.com', '中国银行', '220559556990059720', '420222199012277645', 'test86', '86', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696804', '1479696804', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('87', '87', '用户87', 'test87@qq.com', '15013529384', '地址87', '广州', 'alipay87@qq.com', 'weixin87@qq.com', '邮政银行', '220559556990055691', '420222199012274888', 'test87', '87', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696804', '1479696804', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('88', '88', '用户88', 'test88@qq.com', '15013529389', '地址88', '深圳', 'alipay88@qq.com', 'weixin88@qq.com', '中国银行', '220559556990051712', '420222199012275896', 'test88', '88', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696804', '1479696804', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('89', '89', '用户89', 'test89@qq.com', '15013529981', '地址89', '广州', 'alipay89@qq.com', 'weixin89@qq.com', '邮政银行', '220559556990055776', '420222199012272725', 'test89', '89', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696804', '1479696804', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('90', '90', '用户90', 'test90@qq.com', '15013529855', '地址90', '深圳', 'alipay90@qq.com', 'weixin90@qq.com', '中国银行', '220559556990053679', '420222199012271923', 'test90', '90', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696804', '1479696804', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('91', '91', '用户91', 'test91@qq.com', '15013529310', '地址91', '广州', 'alipay91@qq.com', 'weixin91@qq.com', '邮政银行', '220559556990052510', '420222199012272545', 'test91', '91', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696804', '1479696804', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('92', '92', '用户92', 'test92@qq.com', '15013529812', '地址92', '深圳', 'alipay92@qq.com', 'weixin92@qq.com', '中国银行', '220559556990051006', '420222199012277101', 'test92', '92', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696804', '1479696804', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('93', '93', '用户93', 'test93@qq.com', '15013529739', '地址93', '广州', 'alipay93@qq.com', 'weixin93@qq.com', '邮政银行', '220559556990051376', '420222199012276647', 'test93', '93', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696805', '1479696805', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('94', '94', '用户94', 'test94@qq.com', '15013529980', '地址94', '深圳', 'alipay94@qq.com', 'weixin94@qq.com', '中国银行', '220559556990056274', '420222199012279812', 'test94', '94', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696805', '1479696805', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('95', '95', '用户95', 'test95@qq.com', '15013529657', '地址95', '广州', 'alipay95@qq.com', 'weixin95@qq.com', '邮政银行', '220559556990058770', '420222199012275460', 'test95', '95', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696805', '1479696805', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('96', '96', '用户96', 'test96@qq.com', '15013529154', '地址96', '深圳', 'alipay96@qq.com', 'weixin96@qq.com', '中国银行', '220559556990052461', '420222199012274746', 'test96', '96', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696805', '1479696805', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('97', '97', '用户97', 'test97@qq.com', '15013529682', '地址97', '广州', 'alipay97@qq.com', 'weixin97@qq.com', '邮政银行', '220559556990054886', '420222199012272794', 'test97', '97', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696805', '1479696805', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('98', '98', '用户98', 'test98@qq.com', '15013529380', '地址98', '深圳', 'alipay98@qq.com', 'weixin98@qq.com', '中国银行', '220559556990058087', '420222199012279373', 'test98', '98', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696805', '1479696805', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('99', '99', '用户99', 'test99@qq.com', '15013529391', '地址99', '广州', 'alipay99@qq.com', 'weixin99@qq.com', '邮政银行', '220559556990055421', '420222199012273112', 'test99', '99', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696806', '1479696806', '0', '', '0', '0', '', '', '', '0');
INSERT INTO `sxh_userinfo` VALUES ('100', '100', '用户100', 'test100@qq.com', '15013529871', '地址100', '深圳', 'alipay100@qq.com', 'weixin100@qq.com', '中国银行', '220559556990055769', '420222199012279068', 'test100', '100', null, '0', '广东', '', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '582969d9e6bcf.jpg', '', '1479696806', '1479696806', '0', '', '0', '0', '', '', '', '0');

-- ----------------------------
-- Table structure for sxh_userinfo_bak
-- ----------------------------
DROP TABLE IF EXISTS `sxh_userinfo_bak`;
CREATE TABLE `sxh_userinfo_bak` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `UserID` int(11) NOT NULL COMMENT 'USER表的ID，用户ID',
  `Name` varchar(20) NOT NULL COMMENT '身份证上的姓名',
  `Email` varchar(150) NOT NULL COMMENT '电子邮件',
  `Phone` varchar(30) NOT NULL COMMENT '手机号码 唯一不能重复',
  `Address` varchar(250) NOT NULL COMMENT '收货地址',
  `City` varchar(20) NOT NULL COMMENT '居住地所在的城市',
  `AlpayAccount` varchar(30) NOT NULL COMMENT '支付宝帐号',
  `WeixinAccount` varchar(30) NOT NULL COMMENT '微信帐号',
  `BankName` varchar(50) NOT NULL COMMENT '开户银行名称',
  `BankAccount` varchar(50) NOT NULL COMMENT '银行帐号',
  `CardID` varchar(20) NOT NULL COMMENT '身份证号码',
  `Referee` varchar(20) NOT NULL COMMENT '推荐人',
  `RefereeID` int(11) NOT NULL COMMENT '推荐人用户ID',
  `ServiceName` varchar(64) DEFAULT NULL COMMENT '服务中心帐号',
  `ServiceID` int(11) DEFAULT '0' COMMENT '服务ID',
  `Province` varchar(20) NOT NULL COMMENT '所在省份',
  `Town` varchar(30) NOT NULL COMMENT '所在城市',
  `ActiveCode` varchar(5) NOT NULL COMMENT '激活码',
  `ImageA` varchar(20) NOT NULL COMMENT '身份证手持正面',
  `FolderA` varchar(10) NOT NULL COMMENT '保存图片A的文件夹',
  `ImageB` varchar(20) NOT NULL COMMENT '身份证手持正面',
  `FolderB` varchar(10) NOT NULL COMMENT '保存图片B的文件夹',
  `ImageC` varchar(20) NOT NULL COMMENT '身份证手持全身',
  `FolderC` varchar(10) NOT NULL COMMENT '保存图片C的文件夹',
  `CreateTime` int(11) NOT NULL COMMENT '创建时间',
  `UpdateTime` int(11) NOT NULL COMMENT '更新时间',
  `MembershipID` int(11) NOT NULL DEFAULT '0' COMMENT '招商员ID',
  `MembershipName` varchar(50) NOT NULL DEFAULT '' COMMENT '招商员名称',
  `BusinessCenterID` int(11) NOT NULL DEFAULT '0' COMMENT '隶属招商中心ID',
  `BusinessCenterName` varchar(50) NOT NULL DEFAULT '0' COMMENT '隶属招商中心名称',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UserID_UNIQUE` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='注册用户信息表';

-- ----------------------------
-- Records of sxh_userinfo_bak
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_userinfo_copy
-- ----------------------------
DROP TABLE IF EXISTS `sxh_userinfo_copy`;
CREATE TABLE `sxh_userinfo_copy` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `UserID` int(11) NOT NULL COMMENT 'USER表的ID，用户ID',
  `Name` varchar(20) NOT NULL COMMENT '身份证上的姓名',
  `Email` varchar(150) NOT NULL COMMENT '电子邮件',
  `Phone` varchar(30) NOT NULL COMMENT '手机号码 唯一不能重复',
  `Address` varchar(250) NOT NULL COMMENT '收货地址',
  `City` varchar(20) NOT NULL COMMENT '居住地所在的城市',
  `AlpayAccount` varchar(30) NOT NULL COMMENT '支付宝帐号',
  `WeixinAccount` varchar(30) NOT NULL COMMENT '微信帐号',
  `BankName` varchar(50) NOT NULL COMMENT '开户银行名称',
  `BankAccount` varchar(50) NOT NULL COMMENT '银行帐号',
  `CardID` varchar(20) NOT NULL COMMENT '身份证号码',
  `Referee` varchar(20) NOT NULL COMMENT '推荐人',
  `RefereeID` int(11) NOT NULL COMMENT '推荐人用户ID',
  `ServiceName` varchar(64) NOT NULL DEFAULT '0' COMMENT '服务中心帐号',
  `ServiceID` int(11) NOT NULL DEFAULT '0' COMMENT '服务ID',
  `Province` varchar(20) NOT NULL COMMENT '所在省份',
  `Town` varchar(30) NOT NULL COMMENT '所在城市',
  `ActiveCode` varchar(5) NOT NULL COMMENT '激活码',
  `ImageA` varchar(20) NOT NULL COMMENT '身份证手持正面',
  `FolderA` varchar(10) NOT NULL COMMENT '保存图片A的文件夹',
  `ImageB` varchar(20) NOT NULL COMMENT '身份证手持正面',
  `FolderB` varchar(10) NOT NULL COMMENT '保存图片B的文件夹',
  `ImageC` varchar(20) NOT NULL COMMENT '身份证手持全身',
  `FolderC` varchar(10) NOT NULL COMMENT '保存图片C的文件夹',
  `CreateTime` int(11) NOT NULL COMMENT '创建时间',
  `UpdateTime` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UserID_UNIQUE` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='注册用户信息表';

-- ----------------------------
-- Records of sxh_userinfo_copy
-- ----------------------------

-- ----------------------------
-- Table structure for yt_sys_menu
-- ----------------------------
DROP TABLE IF EXISTS `yt_sys_menu`;
CREATE TABLE `yt_sys_menu` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `pid` int(8) DEFAULT NULL,
  `full_path` varchar(80) COLLATE utf8_bin DEFAULT NULL,
  `order_weight` int(4) DEFAULT NULL,
  `menu_name` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `menu_url` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `menu_icon` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `menu_type` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `enabled` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='menu_type:group,item';

-- ----------------------------
-- Records of yt_sys_menu
-- ----------------------------

-- ----------------------------
-- Table structure for yt_sys_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `yt_sys_role_menu`;
CREATE TABLE `yt_sys_role_menu` (
  `org_id` int(11) NOT NULL,
  `user_type` int(8) NOT NULL,
  `menu_id` int(8) NOT NULL,
  `role_id` int(4) NOT NULL,
  PRIMARY KEY (`org_id`,`user_type`,`menu_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of yt_sys_role_menu
-- ----------------------------
SET FOREIGN_KEY_CHECKS=1;
