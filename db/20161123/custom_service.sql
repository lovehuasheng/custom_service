/*
Navicat MySQL Data Transfer

Source Server         : 192.168.1.165
Source Server Version : 50548
Source Host           : 192.168.1.165:3306
Source Database       : custom_service

Target Server Type    : MYSQL
Target Server Version : 50548
File Encoding         : 65001

Date: 2016-11-23 22:10:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sxh_activate_log_4
-- ----------------------------
DROP TABLE IF EXISTS `sxh_activate_log_4`;
CREATE TABLE `sxh_activate_log_4` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `operator_id` int(10) NOT NULL COMMENT '操作人id',
  `operator_name` char(20) NOT NULL COMMENT '操作人',
  `operator_type` tinyint(3) NOT NULL COMMENT '操作人类型 0-普通用户 1-管理用户',
  `user_id` int(10) NOT NULL COMMENT '被激活人的id',
  `user_name` char(20) NOT NULL COMMENT '被激活人名称',
  `activate_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '激活状态 0-未激活 1-已激活 2-已冻结',
  `remark` char(64) NOT NULL DEFAULT '' COMMENT '备注',
  `create_time` int(10) NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='激活禁用log日志表';

-- ----------------------------
-- Records of sxh_activate_log_4
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_apply_log
-- ----------------------------
DROP TABLE IF EXISTS `sxh_apply_log`;
CREATE TABLE `sxh_apply_log` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `UserName` int(11) NOT NULL,
  `Flag` tinyint(1) NOT NULL,
  `Remark` varchar(500) NOT NULL,
  `AppID` int(11) NOT NULL,
  `CreateTime` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sxh_apply_log
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_sys_group
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_group`;
CREATE TABLE `sxh_sys_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` char(20) NOT NULL DEFAULT '' COMMENT '用户组名称',
  `permissions` char(200) NOT NULL DEFAULT '' COMMENT '权限列表,多个权限用逗号分隔',
  `pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父级组id',
  `pname` char(20) NOT NULL DEFAULT '' COMMENT '父级组名称',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `remark` char(64) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-启用 1-禁用 2-删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='系统用户组';

-- ----------------------------
-- Records of sxh_sys_group
-- ----------------------------
INSERT INTO `sxh_sys_group` VALUES ('1', '超级管理员', '1,2,3', '0', '', '1', '我是超级管理员', '0', '1478326727', '1478331135');
INSERT INTO `sxh_sys_group` VALUES ('2', '超级管理员', '', '0', '', '1', '我是超级管理员', '0', '1478327217', '1478327217');
INSERT INTO `sxh_sys_group` VALUES ('3', '客服', '1,4', '0', '', '0', '客服组', '2', '1479282270', '1479435475');
INSERT INTO `sxh_sys_group` VALUES ('4', '123', '', '0', '', '0', '12321', '2', '1479282380', '1479282380');
INSERT INTO `sxh_sys_group` VALUES ('5', '超级管理员', '', '0', '', '0', '', '2', '1479282382', '1479285171');
INSERT INTO `sxh_sys_group` VALUES ('6', '王企鹅wq', '', '0', '', '0', '额我去王企鹅', '2', '1479282451', '1479282451');
INSERT INTO `sxh_sys_group` VALUES ('7', '客服组', '', '0', '', '0', 'wqewqe', '2', '1479282906', '1479282906');
INSERT INTO `sxh_sys_group` VALUES ('8', '123', '', '0', '', '0', '213', '2', '1479282928', '1479282928');
INSERT INTO `sxh_sys_group` VALUES ('9', '轻微e', '', '0', '', '0', '王企鹅', '2', '1479283029', '1479283029');
INSERT INTO `sxh_sys_group` VALUES ('10', '其味无穷wq', '', '0', '', '0', '额畏怯', '2', '1479283070', '1479283070');
INSERT INTO `sxh_sys_group` VALUES ('11', '123', '', '0', '', '0', '123', '2', '1479283316', '1479283316');
INSERT INTO `sxh_sys_group` VALUES ('12', '王企鹅', '', '0', '', '0', '请问', '2', '1479283405', '1479283405');
INSERT INTO `sxh_sys_group` VALUES ('13', '1111', '', '0', '', '0', '11111', '2', '1479283462', '1479283462');
INSERT INTO `sxh_sys_group` VALUES ('14', '孙露想跟', '', '0', '', '0', '为全文', '2', '1479283559', '1479284076');
INSERT INTO `sxh_sys_group` VALUES ('15', '而我却王企鹅', '', '0', '', '0', '气温气温', '2', '1479283629', '1479284304');
INSERT INTO `sxh_sys_group` VALUES ('16', '111111111', '', '0', '', '0', '1111111111', '2', '1479284490', '1479284885');
INSERT INTO `sxh_sys_group` VALUES ('17', '超级大魔王', '', '0', '', '0', '就是我', '2', '1479285223', '1479285223');
INSERT INTO `sxh_sys_group` VALUES ('18', '而且', '1,3', '0', '', '0', '请问', '2', '1479289574', '1479289620');
INSERT INTO `sxh_sys_group` VALUES ('19', '普通管理员', '', '0', '', '0', '普通管理员', '2', '1479435513', '1479435513');
INSERT INTO `sxh_sys_group` VALUES ('20', '213', '', '0', '', '0', '123', '2', '1479435530', '1479435530');
INSERT INTO `sxh_sys_group` VALUES ('21', '普通管理员', '', '0', '', '0', '没有', '2', '1479701149', '1479701149');
INSERT INTO `sxh_sys_group` VALUES ('22', '普通管理员', '', '0', '', '0', '没有', '2', '1479701151', '1479701151');
INSERT INTO `sxh_sys_group` VALUES ('23', '普通管理员', '', '0', '', '0', '没有', '2', '1479701152', '1479701152');
INSERT INTO `sxh_sys_group` VALUES ('24', '普通管理员', '', '0', '', '0', '没有', '2', '1479701233', '1479701233');
INSERT INTO `sxh_sys_group` VALUES ('25', '审核客服', '1,4', '0', '', '0', '', '2', '1479801392', '1479801392');

-- ----------------------------
-- Table structure for sxh_sys_menu
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_menu`;
CREATE TABLE `sxh_sys_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL DEFAULT '' COMMENT '菜单名',
  `href` char(40) NOT NULL DEFAULT '' COMMENT '菜单url',
  `group` char(20) NOT NULL DEFAULT '' COMMENT '菜单分组',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级菜单id',
  `pname` char(20) NOT NULL DEFAULT '' COMMENT '父级菜单名',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-启用 1-禁用 2-删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_hidden` tinyint(1) NOT NULL COMMENT '是否隐藏  0- 否，1-是 ',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='系统栏目表';

-- ----------------------------
-- Records of sxh_sys_menu
-- ----------------------------
INSERT INTO `sxh_sys_menu` VALUES ('1', '客服列表', 'user/user/menu_list', '客服管理', '2', '客服管理', '1', '0', '1476927440', '1477040529', '0');
INSERT INTO `sxh_sys_menu` VALUES ('2', '这是一个菜单', 'user/user/add_user', '这是一个组', '1', '客服列表', '4', '2', '1476927503', '1477204346', '1');
INSERT INTO `sxh_sys_menu` VALUES ('3', '客服列表', 'user/user/menu_list', '客服管理', '2', '客服管理', '1', '0', '1476927558', '1476927558', '0');
INSERT INTO `sxh_sys_menu` VALUES ('4', '客服列表', 'user/user/menu_list', '客服管理', '2', '客服管理', '1', '0', '1476929509', '1476929509', '0');
INSERT INTO `sxh_sys_menu` VALUES ('5', '客服列表1', 'user/user/menu_list', '客服管理', '2', '客服管理', '1', '0', '1476929555', '1476943812', '0');
INSERT INTO `sxh_sys_menu` VALUES ('6', '客服列表', 'user/user/menu_list', '客服管理', '2', '客服管理', '1', '0', '1476929575', '1476929575', '0');
INSERT INTO `sxh_sys_menu` VALUES ('7', '客服列表', 'user/user/menu_list', '客服管理', '2', '客服管理', '1', '0', '1476929700', '1476929700', '0');
INSERT INTO `sxh_sys_menu` VALUES ('8', '客服列表', 'user/user/menu_list', '客服管理', '2', '客服管理', '1', '0', '1476932522', '1476932522', '0');
INSERT INTO `sxh_sys_menu` VALUES ('9', '客服列表', 'user/user/menu_list', '客服管理', '2', '客服管理', '1', '0', '1476936408', '1476936408', '0');
INSERT INTO `sxh_sys_menu` VALUES ('10', '客服列表', 'user/user/menu_list', '客服管理', '2', '客服管理', '1', '0', '1477033283', '1477033283', '0');
INSERT INTO `sxh_sys_menu` VALUES ('11', '客服列表', 'user/user/menu_list', '客服管理', '2', '客服管理', '1', '0', '1477033383', '1477033383', '0');
INSERT INTO `sxh_sys_menu` VALUES ('12', '客服列表', 'user/user/menu_list', '客服管理', '2', '客服管理', '1', '0', '1477033575', '1477033575', '0');
INSERT INTO `sxh_sys_menu` VALUES ('13', '客服列表', 'user/user/menu_list', '客服管理', '1', '首页', '2', '0', '1477033610', '1477033610', '0');
INSERT INTO `sxh_sys_menu` VALUES ('14', '这是一个菜单', 'user/user/add_user', '这是一个组', '1', '客服列表', '4', '0', '1477203696', '1477203696', '1');
INSERT INTO `sxh_sys_menu` VALUES ('15', '这是一个菜单', 'user/user/add_user', '这是一个组', '1', '客服列表', '4', '0', '1477203986', '1477203986', '1');
INSERT INTO `sxh_sys_menu` VALUES ('16', '这是一个菜单', 'user/user/add_user', '这是一个组', '1', '客服列表', '4', '0', '1477204039', '1477204039', '1');

-- ----------------------------
-- Table structure for sxh_sys_msg_tpl
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_msg_tpl`;
CREATE TABLE `sxh_sys_msg_tpl` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(20) NOT NULL DEFAULT '' COMMENT '通知标题',
  `content` char(64) NOT NULL DEFAULT '' COMMENT '通知内容',
  `sys_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模板创建人id',
  `sys_uname` char(20) NOT NULL DEFAULT '' COMMENT '模板创建人名称',
  `remark` char(64) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-启用 1-禁用 2-删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='消息模板';

-- ----------------------------
-- Records of sxh_sys_msg_tpl
-- ----------------------------
INSERT INTO `sxh_sys_msg_tpl` VALUES ('1', '账号信息', '亲爱的会员，您的资料审核未通过！请尽快登陆会员系统进行资料完善和修改', '0', '', '', '0', '0', '0');
INSERT INTO `sxh_sys_msg_tpl` VALUES ('2', '身份验证', '亲爱的会员，您的资料审核未通过！请尽快登陆会员系统进行资料完善和修改', '0', '', '', '0', '0', '0');

-- ----------------------------
-- Table structure for sxh_sys_notification
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_notification`;
CREATE TABLE `sxh_sys_notification` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '会员账号',
  `sys_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员id',
  `sys_uname` char(20) NOT NULL DEFAULT '' COMMENT '管理员账号',
  `content` char(200) NOT NULL DEFAULT '' COMMENT '消息内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未读 1-已读',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='消息通知表';

-- ----------------------------
-- Records of sxh_sys_notification
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_sys_notification_1
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_notification_1`;
CREATE TABLE `sxh_sys_notification_1` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '会员账号',
  `sys_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员id',
  `sys_uname` char(20) NOT NULL DEFAULT '' COMMENT '管理员账号',
  `content` char(200) NOT NULL DEFAULT '' COMMENT '消息内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未读 1-已读',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='消息通知表';

-- ----------------------------
-- Records of sxh_sys_notification_1
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_sys_notification_10
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_notification_10`;
CREATE TABLE `sxh_sys_notification_10` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '会员账号',
  `sys_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员id',
  `sys_uname` char(20) NOT NULL DEFAULT '' COMMENT '管理员账号',
  `content` varchar(200) NOT NULL DEFAULT '' COMMENT '消息内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未读 1-已读',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='消息通知表';

-- ----------------------------
-- Records of sxh_sys_notification_10
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_sys_notification_2
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_notification_2`;
CREATE TABLE `sxh_sys_notification_2` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '会员账号',
  `sys_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员id',
  `sys_uname` char(20) NOT NULL DEFAULT '' COMMENT '管理员账号',
  `content` varchar(200) NOT NULL DEFAULT '' COMMENT '消息内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未读 1-已读',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='消息通知表';

-- ----------------------------
-- Records of sxh_sys_notification_2
-- ----------------------------
INSERT INTO `sxh_sys_notification_2` VALUES ('1', '1', '自由的鱼', '0', '', '你好', '0', '0', '0');
INSERT INTO `sxh_sys_notification_2` VALUES ('2', '1', '1', '1', 'admin', 'ljadsljlsalkjs', '0', '1478743644', '0');
INSERT INTO `sxh_sys_notification_2` VALUES ('3', '1', '1', '1', 'admin', 'ljadsljlsalkjs', '0', '1478743683', '0');

-- ----------------------------
-- Table structure for sxh_sys_notification_3
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_notification_3`;
CREATE TABLE `sxh_sys_notification_3` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '会员账号',
  `sys_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员id',
  `sys_uname` char(20) NOT NULL DEFAULT '' COMMENT '管理员账号',
  `content` varchar(200) NOT NULL DEFAULT '' COMMENT '消息内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未读 1-已读',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='消息通知表';

-- ----------------------------
-- Records of sxh_sys_notification_3
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_sys_notification_4
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_notification_4`;
CREATE TABLE `sxh_sys_notification_4` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '会员账号',
  `sys_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员id',
  `sys_uname` char(20) NOT NULL DEFAULT '' COMMENT '管理员账号',
  `content` varchar(200) NOT NULL DEFAULT '' COMMENT '消息内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未读 1-已读',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='消息通知表';

-- ----------------------------
-- Records of sxh_sys_notification_4
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_sys_notification_5
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_notification_5`;
CREATE TABLE `sxh_sys_notification_5` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '会员账号',
  `sys_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员id',
  `sys_uname` char(20) NOT NULL DEFAULT '' COMMENT '管理员账号',
  `content` varchar(200) NOT NULL DEFAULT '' COMMENT '消息内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未读 1-已读',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='消息通知表';

-- ----------------------------
-- Records of sxh_sys_notification_5
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_sys_notification_6
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_notification_6`;
CREATE TABLE `sxh_sys_notification_6` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '会员账号',
  `sys_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员id',
  `sys_uname` char(20) NOT NULL DEFAULT '' COMMENT '管理员账号',
  `content` varchar(200) NOT NULL DEFAULT '' COMMENT '消息内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未读 1-已读',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='消息通知表';

-- ----------------------------
-- Records of sxh_sys_notification_6
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_sys_notification_7
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_notification_7`;
CREATE TABLE `sxh_sys_notification_7` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '会员账号',
  `sys_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员id',
  `sys_uname` char(20) NOT NULL DEFAULT '' COMMENT '管理员账号',
  `content` varchar(200) NOT NULL DEFAULT '' COMMENT '消息内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未读 1-已读',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='消息通知表';

-- ----------------------------
-- Records of sxh_sys_notification_7
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_sys_notification_8
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_notification_8`;
CREATE TABLE `sxh_sys_notification_8` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '会员账号',
  `sys_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员id',
  `sys_uname` char(20) NOT NULL DEFAULT '' COMMENT '管理员账号',
  `content` varchar(200) NOT NULL DEFAULT '' COMMENT '消息内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未读 1-已读',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='消息通知表';

-- ----------------------------
-- Records of sxh_sys_notification_8
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_sys_notification_9
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_notification_9`;
CREATE TABLE `sxh_sys_notification_9` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '会员账号',
  `sys_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员id',
  `sys_uname` char(20) NOT NULL DEFAULT '' COMMENT '管理员账号',
  `content` varchar(200) NOT NULL DEFAULT '' COMMENT '消息内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未读 1-已读',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='消息通知表';

-- ----------------------------
-- Records of sxh_sys_notification_9
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_sys_operation
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_operation`;
CREATE TABLE `sxh_sys_operation` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `name` char(20) NOT NULL DEFAULT '' COMMENT '权限名称',
  `operation` char(64) NOT NULL DEFAULT '' COMMENT '对应的操作',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '类别 0-权限节点 1-菜单节点',
  `is_default` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否默认加载 0-否 1-是',
  `group` char(20) NOT NULL DEFAULT '' COMMENT '权限节点分组',
  `icon` char(10) NOT NULL DEFAULT '' COMMENT '图标',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `remark` char(64) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-启用 1-禁用 2-删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='系统权限表';

-- ----------------------------
-- Records of sxh_sys_operation
-- ----------------------------
INSERT INTO `sxh_sys_operation` VALUES ('1', '0', '我的工作', '/member/sys_work/index', '1', '1', '', 't2', '0', '', '0', '0', '0');
INSERT INTO `sxh_sys_operation` VALUES ('2', '0', '团队管理', '/permission/sys_group/index', '1', '0', '', 't4', '0', '', '0', '0', '0');
INSERT INTO `sxh_sys_operation` VALUES ('3', '0', '系统管理', '/user/user/index', '1', '0', '', 't5', '0', '', '0', '0', '0');
INSERT INTO `sxh_sys_operation` VALUES ('4', '1', '工作区', '/member/sys_work/super', '1', '1', '', 'left_one', '0', '', '0', '0', '0');
INSERT INTO `sxh_sys_operation` VALUES ('5', '1', '发布公告', '/member/user_news/index', '1', '0', '', 'left_one', '0', '', '0', '0', '0');
INSERT INTO `sxh_sys_operation` VALUES ('6', '1', '申领文化衫', '/member/user_clothes/index', '1', '0', '', 'left_one', '0', '', '0', '0', '0');
INSERT INTO `sxh_sys_operation` VALUES ('7', '1', '转币功能', '/member/user_account/show_transfer_coin', '1', '0', '', 'left_one', '0', '', '0', '0', '0');
INSERT INTO `sxh_sys_operation` VALUES ('8', '1', '匹配交易', '/business/templet/show_match', '1', '0', '', 'left_one', '0', '', '0', '0', '0');
INSERT INTO `sxh_sys_operation` VALUES ('9', '8', '查询付款超时', '/business/templet/show_time_out', '1', '0', '', '', '0', '', '0', '0', '0');
INSERT INTO `sxh_sys_operation` VALUES ('10', '8', '查询收款超时', '/business/templet/show_trade', '1', '0', '', '', '0', '', '0', '0', '0');
INSERT INTO `sxh_sys_operation` VALUES ('11', '8', '查询付款剩余', '/business/templet/show_search1', '1', '0', '', '', '0', '', '0', '0', '0');
INSERT INTO `sxh_sys_operation` VALUES ('12', '8', '查询收款剩余', '/business/templet/show_search', '1', '0', '', '', '0', '', '0', '0', '0');
INSERT INTO `sxh_sys_operation` VALUES ('13', '8', '查询已匹配', '/business/templet/show_match', '1', '0', '', '', '0', '', '0', '0', '0');
INSERT INTO `sxh_sys_operation` VALUES ('14', '8', '手动匹配列表', '/business/templet/show_manual', '1', '0', '', '', '0', '', '0', '0', '0');
INSERT INTO `sxh_sys_operation` VALUES ('15', '2', '设置用户组', '/permission/sys_group/show_group_list', '1', '1', '', 'left_one', '0', '', '0', '0', '0');
INSERT INTO `sxh_sys_operation` VALUES ('16', '3', '账号管理', '/user/user/show_user_list', '1', '1', '', 'left_one', '0', '', '0', '0', '0');
INSERT INTO `sxh_sys_operation` VALUES ('17', '3', '安全中心', '/user/user/security_center', '1', '0', '', 'left_one', '0', '', '0', '0', '0');

-- ----------------------------
-- Table structure for sxh_sys_operation_4
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_operation_4`;
CREATE TABLE `sxh_sys_operation_4` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL COMMENT '1-转接单，2-流水转让记录',
  `provide_id` int(10) NOT NULL COMMENT 'provide表ID',
  `primary_id` int(10) NOT NULL COMMENT '原用户id',
  `primary_username` char(20) NOT NULL COMMENT '原用户名',
  `user_id` int(10) NOT NULL COMMENT '新用户id',
  `username` char(20) NOT NULL COMMENT '新用户名',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态1-已还原 0-正常',
  `operator_id` int(11) NOT NULL,
  `operator_name` char(20) NOT NULL,
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客服转接单记录表';

-- ----------------------------
-- Records of sxh_sys_operation_4
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_sys_remark
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_remark`;
CREATE TABLE `sxh_sys_remark` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员id',
  `sys_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员id',
  `remark` char(64) NOT NULL DEFAULT '' COMMENT '备注',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='备注表';

-- ----------------------------
-- Records of sxh_sys_remark
-- ----------------------------
INSERT INTO `sxh_sys_remark` VALUES ('1', '1', '0', '哈哈哈哈哈', '1478154586', '0');
INSERT INTO `sxh_sys_remark` VALUES ('2', '1', '1', 'hahaha', '1478679649', '1478679649');
INSERT INTO `sxh_sys_remark` VALUES ('3', '1', '1', 'hahaha', '1478679696', '1478679696');
INSERT INTO `sxh_sys_remark` VALUES ('4', '1', '1', 'hahaha', '1478679814', '1478679814');
INSERT INTO `sxh_sys_remark` VALUES ('5', '1', '1', 'hahaha', '1478679826', '1478679826');
INSERT INTO `sxh_sys_remark` VALUES ('6', '1', '1', 'hahaha', '1478679839', '1478679839');
INSERT INTO `sxh_sys_remark` VALUES ('7', '1', '1', 'hahaha', '1478679851', '1478679851');
INSERT INTO `sxh_sys_remark` VALUES ('8', '1', '1', 'hahaha', '1478679871', '1478679871');
INSERT INTO `sxh_sys_remark` VALUES ('9', '1', '1', 'hahaha', '1478679950', '1478679950');
INSERT INTO `sxh_sys_remark` VALUES ('10', '1', '1', 'hahaha', '1478679971', '1478679971');
INSERT INTO `sxh_sys_remark` VALUES ('11', '1', '1', 'hahaha', '1478680174', '1478680174');
INSERT INTO `sxh_sys_remark` VALUES ('12', '1', '1', '\"12123132\"', '1478680194', '1478680194');
INSERT INTO `sxh_sys_remark` VALUES ('13', '1', '1', '123', '1478743735', '1478743735');
INSERT INTO `sxh_sys_remark` VALUES ('14', '1', '1', '我是小四', '1478743950', '1478743950');
INSERT INTO `sxh_sys_remark` VALUES ('15', '1', '1', 'qwqwewe', '1478744007', '1478744007');
INSERT INTO `sxh_sys_remark` VALUES ('16', '1', '1', 'qwqwewe', '1478744078', '1478744078');
INSERT INTO `sxh_sys_remark` VALUES ('17', '1', '1', '我是小四', '1478747281', '1478747281');
INSERT INTO `sxh_sys_remark` VALUES ('18', '1', '1', '没事', '1478758925', '1478758925');
INSERT INTO `sxh_sys_remark` VALUES ('19', '1', '1', 'qwe', '1479178911', '1479178911');
INSERT INTO `sxh_sys_remark` VALUES ('20', '1', '1', '123', '1479179733', '1479179733');
INSERT INTO `sxh_sys_remark` VALUES ('21', '1', '1', 'qwe', '1479180481', '1479180481');
INSERT INTO `sxh_sys_remark` VALUES ('22', '1', '1', 'qwe', '1479180522', '1479180522');
INSERT INTO `sxh_sys_remark` VALUES ('23', '1', '1', '123', '1479180559', '1479180559');
INSERT INTO `sxh_sys_remark` VALUES ('24', '1', '1', 'qweqwe', '1479180696', '1479180696');
INSERT INTO `sxh_sys_remark` VALUES ('25', '1', '1', '请问', '1479181683', '1479181683');
INSERT INTO `sxh_sys_remark` VALUES ('26', '1', '1', '请问', '1479182478', '1479182478');
INSERT INTO `sxh_sys_remark` VALUES ('27', '1', '1', '312', '1479198025', '1479198025');
INSERT INTO `sxh_sys_remark` VALUES ('28', '1', '1', 'wqe', '1479198723', '1479198723');
INSERT INTO `sxh_sys_remark` VALUES ('29', '87', '1', 'qwewqe', '1479206439', '1479206439');
INSERT INTO `sxh_sys_remark` VALUES ('30', '96', '1', 'we', '1479261277', '1479261277');
INSERT INTO `sxh_sys_remark` VALUES ('31', '100', '1', 'qwe', '1479262221', '1479262221');
INSERT INTO `sxh_sys_remark` VALUES ('32', '99', '1', 'eqwewqeqwewqeqwe', '1479262277', '1479262277');
INSERT INTO `sxh_sys_remark` VALUES ('33', '94', '1', 'qwewq', '1479699295', '1479699295');
INSERT INTO `sxh_sys_remark` VALUES ('34', '100', '1', 'wqeqwe', '1479699305', '1479699305');
INSERT INTO `sxh_sys_remark` VALUES ('35', '1', '1', 'qwewqe', '1479901518', '1479901518');
INSERT INTO `sxh_sys_remark` VALUES ('36', '1', '1', 'weweqeqwe', '1479901547', '1479901547');

-- ----------------------------
-- Table structure for sxh_sys_secret
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_secret`;
CREATE TABLE `sxh_sys_secret` (
  `id` tinyint(1) NOT NULL,
  `key` char(32) NOT NULL COMMENT '公钥key',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='密钥';

-- ----------------------------
-- Records of sxh_sys_secret
-- ----------------------------
INSERT INTO `sxh_sys_secret` VALUES ('1', 'FR4ehHBBbjD7ZBNEv_GCvXBsmNSq0zLV');

-- ----------------------------
-- Table structure for sxh_sys_sms
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_sms`;
CREATE TABLE `sxh_sys_sms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sys_uid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '管理员id',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `code` char(10) NOT NULL DEFAULT '' COMMENT '验证码',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8 COMMENT='系统管理员短信发送记录';

-- ----------------------------
-- Records of sxh_sys_sms
-- ----------------------------
INSERT INTO `sxh_sys_sms` VALUES ('1', '2', '15820485835', '352865', '1479804266', '1479804266');
INSERT INTO `sxh_sys_sms` VALUES ('2', '2', '15820485835', '257261', '1479804316', '1479804316');
INSERT INTO `sxh_sys_sms` VALUES ('3', '2', '15820485835', '471826', '1479804337', '1479804337');
INSERT INTO `sxh_sys_sms` VALUES ('4', '2', '15820485835', '744994', '1479804360', '1479804360');
INSERT INTO `sxh_sys_sms` VALUES ('5', '2', '15820485835', '884921', '1479804361', '1479804361');
INSERT INTO `sxh_sys_sms` VALUES ('6', '2', '15820485835', '861234', '1479804362', '1479804362');
INSERT INTO `sxh_sys_sms` VALUES ('7', '2', '15820485835', '818786', '1479804744', '1479804744');
INSERT INTO `sxh_sys_sms` VALUES ('8', '2', '15820485835', '604282', '1479804749', '1479804749');
INSERT INTO `sxh_sys_sms` VALUES ('9', '2', '15820485835', '314970', '1479804749', '1479804749');
INSERT INTO `sxh_sys_sms` VALUES ('10', '2', '15820485835', '457962', '1479804750', '1479804750');
INSERT INTO `sxh_sys_sms` VALUES ('11', '2', '15820485835', '115653', '1479804752', '1479804752');
INSERT INTO `sxh_sys_sms` VALUES ('12', '2', '15820485835', '624207', '1479804752', '1479804752');
INSERT INTO `sxh_sys_sms` VALUES ('13', '2', '15820485835', '796636', '1479804752', '1479804752');
INSERT INTO `sxh_sys_sms` VALUES ('14', '2', '15820485835', '275272', '1479804752', '1479804752');
INSERT INTO `sxh_sys_sms` VALUES ('15', '2', '15820485835', '083083', '1479804885', '1479804885');
INSERT INTO `sxh_sys_sms` VALUES ('16', '2', '15820485835', '447920', '1479804889', '1479804889');
INSERT INTO `sxh_sys_sms` VALUES ('17', '2', '15820485835', '287055', '1479804890', '1479804890');
INSERT INTO `sxh_sys_sms` VALUES ('18', '2', '15820485835', '259885', '1479805036', '1479805036');
INSERT INTO `sxh_sys_sms` VALUES ('19', '2', '15820485835', '776836', '1479805039', '1479805039');
INSERT INTO `sxh_sys_sms` VALUES ('20', '2', '15820485835', '551931', '1479805838', '1479805838');
INSERT INTO `sxh_sys_sms` VALUES ('21', '2', '15820485835', '719292', '1479805841', '1479805841');
INSERT INTO `sxh_sys_sms` VALUES ('22', '2', '15820485835', '736162', '1479805842', '1479805842');
INSERT INTO `sxh_sys_sms` VALUES ('23', '2', '15820485835', '535585', '1479805843', '1479805843');
INSERT INTO `sxh_sys_sms` VALUES ('24', '2', '15820485835', '526080', '1479805843', '1479805843');
INSERT INTO `sxh_sys_sms` VALUES ('25', '2', '15820485835', '779588', '1479805843', '1479805843');
INSERT INTO `sxh_sys_sms` VALUES ('26', '2', '15820485835', '495829', '1479805844', '1479805844');
INSERT INTO `sxh_sys_sms` VALUES ('27', '2', '15820485835', '881055', '1479805844', '1479805844');
INSERT INTO `sxh_sys_sms` VALUES ('28', '2', '15820485835', '255942', '1479805844', '1479805844');
INSERT INTO `sxh_sys_sms` VALUES ('29', '2', '15820485835', '361085', '1479805844', '1479805844');
INSERT INTO `sxh_sys_sms` VALUES ('30', '2', '15820485835', '652169', '1479805844', '1479805844');
INSERT INTO `sxh_sys_sms` VALUES ('31', '2', '15820485835', '142716', '1479805929', '1479805929');
INSERT INTO `sxh_sys_sms` VALUES ('32', '2', '15820485835', '139904', '1479805971', '1479805971');
INSERT INTO `sxh_sys_sms` VALUES ('33', '2', '15279126033', '862951', '1479806183', '1479806183');
INSERT INTO `sxh_sys_sms` VALUES ('34', '1', '15279126033', '960251', '1479806256', '1479806256');
INSERT INTO `sxh_sys_sms` VALUES ('35', '2', '15279126033', '707993', '1479806301', '1479806301');
INSERT INTO `sxh_sys_sms` VALUES ('36', '2', '15279126033', '171631', '1479807342', '1479807342');
INSERT INTO `sxh_sys_sms` VALUES ('37', '1', '15018529770', '966888', '1479807581', '1479807581');
INSERT INTO `sxh_sys_sms` VALUES ('38', '2', '15018529770', '977801', '1479807772', '1479807772');
INSERT INTO `sxh_sys_sms` VALUES ('39', '1', '15018529770', '723156', '1479807792', '1479807792');
INSERT INTO `sxh_sys_sms` VALUES ('40', '2', '15018529770', '906565', '1479807921', '1479807921');
INSERT INTO `sxh_sys_sms` VALUES ('41', '2', '15018529770', '118837', '1479807974', '1479807974');
INSERT INTO `sxh_sys_sms` VALUES ('42', '1', '15018529770', '956692', '1479808033', '1479808033');
INSERT INTO `sxh_sys_sms` VALUES ('43', '2', '15018529770', '792067', '1479808099', '1479808099');
INSERT INTO `sxh_sys_sms` VALUES ('44', '1', '15018529770', '408517', '1479811724', '1479811724');
INSERT INTO `sxh_sys_sms` VALUES ('45', '1', '15018529770', '051442', '1479812249', '1479812249');
INSERT INTO `sxh_sys_sms` VALUES ('46', '1', '15018529770', '338846', '1479812251', '1479812251');
INSERT INTO `sxh_sys_sms` VALUES ('47', '1', '15018529770', '997846', '1479812251', '1479812251');
INSERT INTO `sxh_sys_sms` VALUES ('48', '1', '15018529770', '050126', '1479812252', '1479812252');
INSERT INTO `sxh_sys_sms` VALUES ('49', '1', '15018529770', '529256', '1479812441', '1479812441');
INSERT INTO `sxh_sys_sms` VALUES ('50', '1', '13213399928', '036996', '1479813847', '1479813847');
INSERT INTO `sxh_sys_sms` VALUES ('51', '1', '13213399928', '302522', '1479813910', '1479813910');
INSERT INTO `sxh_sys_sms` VALUES ('52', '1', '13786613482', '978825', '1479818239', '1479818239');
INSERT INTO `sxh_sys_sms` VALUES ('53', '2', '13213399928', '862900', '1479818306', '1479818306');
INSERT INTO `sxh_sys_sms` VALUES ('54', '2', '13213399928', '795616', '1479818371', '1479818371');
INSERT INTO `sxh_sys_sms` VALUES ('55', '1', '13786613482', '997549', '1479818497', '1479818497');
INSERT INTO `sxh_sys_sms` VALUES ('56', '1', '13786613482', '690667', '1479820012', '1479820012');
INSERT INTO `sxh_sys_sms` VALUES ('57', '2', '13213399928', '986301', '1479865823', '1479865823');
INSERT INTO `sxh_sys_sms` VALUES ('58', '1', '13786613482', '636031', '1479867529', '1479867529');
INSERT INTO `sxh_sys_sms` VALUES ('59', '1', '13786613482', '949930', '1479868515', '1479868515');
INSERT INTO `sxh_sys_sms` VALUES ('60', '2', '13213399928', '502739', '1479868561', '1479868561');
INSERT INTO `sxh_sys_sms` VALUES ('61', '1', '13786613482', '296876', '1479869132', '1479869132');
INSERT INTO `sxh_sys_sms` VALUES ('62', '2', '13213399928', '471419', '1479869161', '1479869161');
INSERT INTO `sxh_sys_sms` VALUES ('63', '1', '13786613482', '617760', '1479869639', '1479869639');
INSERT INTO `sxh_sys_sms` VALUES ('64', '1', '13786613482', '361636', '1479869697', '1479869697');
INSERT INTO `sxh_sys_sms` VALUES ('65', '1', '13786613482', '222772', '1479869842', '1479869842');
INSERT INTO `sxh_sys_sms` VALUES ('66', '1', '13786613482', '998719', '1479870048', '1479870048');
INSERT INTO `sxh_sys_sms` VALUES ('67', '1', '13786613482', '972314', '1479870139', '1479870139');
INSERT INTO `sxh_sys_sms` VALUES ('68', '1', '13786613482', '362135', '1479870292', '1479870292');
INSERT INTO `sxh_sys_sms` VALUES ('69', '1', '13786613482', '342674', '1479871791', '1479871791');
INSERT INTO `sxh_sys_sms` VALUES ('70', '1', '18566298135', '982059', '1479872382', '1479872382');
INSERT INTO `sxh_sys_sms` VALUES ('71', '1', '18566298135', '688629', '1479872384', '1479872384');
INSERT INTO `sxh_sys_sms` VALUES ('72', '1', '18566298135', '109349', '1479872704', '1479872704');
INSERT INTO `sxh_sys_sms` VALUES ('73', '1', '18566298135', '360392', '1479872833', '1479872833');
INSERT INTO `sxh_sys_sms` VALUES ('74', '1', '18566298135', '004968', '1479874141', '1479874141');
INSERT INTO `sxh_sys_sms` VALUES ('75', '2', '15018529770', '462408', '1479877941', '1479877941');
INSERT INTO `sxh_sys_sms` VALUES ('76', '1', '18566298135', '022485', '1479880996', '1479880996');
INSERT INTO `sxh_sys_sms` VALUES ('77', '2', '15018529770', '550374', '1479883487', '1479883487');
INSERT INTO `sxh_sys_sms` VALUES ('78', '2', '15018529770', '190955', '1479883638', '1479883638');
INSERT INTO `sxh_sys_sms` VALUES ('79', '2', '15018529770', '327128', '1479883665', '1479883665');
INSERT INTO `sxh_sys_sms` VALUES ('80', '1', '18566298135', '962000', '1479890982', '1479890982');
INSERT INTO `sxh_sys_sms` VALUES ('81', '1', '15018529770', '818207', '1479895171', '1479895171');
INSERT INTO `sxh_sys_sms` VALUES ('82', '2', '15018529770', '733304', '1479896474', '1479896474');
INSERT INTO `sxh_sys_sms` VALUES ('83', '1', '15018529770', '075323', '1479900981', '1479900981');
INSERT INTO `sxh_sys_sms` VALUES ('84', '1', '15018529770', '219804', '1479900981', '1479900981');
INSERT INTO `sxh_sys_sms` VALUES ('85', '2', '15018529770', '276786', '1479902449', '1479902449');
INSERT INTO `sxh_sys_sms` VALUES ('86', '2', '15018529770', '970371', '1479902759', '1479902759');
INSERT INTO `sxh_sys_sms` VALUES ('87', '1', '15018529770', '392162', '1479902953', '1479902953');
INSERT INTO `sxh_sys_sms` VALUES ('88', '2', '15018529770', '133841', '1479907672', '1479907672');
INSERT INTO `sxh_sys_sms` VALUES ('89', '1', '15018529770', '867573', '1479907954', '1479907954');
INSERT INTO `sxh_sys_sms` VALUES ('90', '1', '15018529770', '630649', '1479907959', '1479907959');
INSERT INTO `sxh_sys_sms` VALUES ('91', '1', '15018529770', '022689', '1479908022', '1479908022');
INSERT INTO `sxh_sys_sms` VALUES ('92', '1', '15279126033', '091380', '1479908112', '1479908112');
INSERT INTO `sxh_sys_sms` VALUES ('93', '1', '15279126033', '241619', '1479908153', '1479908153');
INSERT INTO `sxh_sys_sms` VALUES ('94', '2', '15279126033', '438007', '1479908200', '1479908200');
INSERT INTO `sxh_sys_sms` VALUES ('95', '1', '15279126033', '235253', '1479908388', '1479908388');
INSERT INTO `sxh_sys_sms` VALUES ('96', '2', '15279126033', '450112', '1479908437', '1479908437');
INSERT INTO `sxh_sys_sms` VALUES ('97', '2', '15279126033', '843953', '1479908847', '1479908847');
INSERT INTO `sxh_sys_sms` VALUES ('98', '1', '15279126033', '872215', '1479909622', '1479909622');

-- ----------------------------
-- Table structure for sxh_sys_user
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_user`;
CREATE TABLE `sxh_sys_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(20) NOT NULL DEFAULT '' COMMENT '用户登录名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `secondary_password` char(32) NOT NULL DEFAULT '' COMMENT '二级密码',
  `salt` char(6) NOT NULL COMMENT '私钥【用于密码加密】',
  `realname` char(20) NOT NULL DEFAULT '' COMMENT '真实用户名',
  `group_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '所属组id',
  `group_name` char(20) NOT NULL DEFAULT '' COMMENT '组名称',
  `permissions` char(64) NOT NULL DEFAULT '' COMMENT '用户权限,多个权限以逗号分隔',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `email` char(30) NOT NULL DEFAULT '' COMMENT '邮箱',
  `is_super` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否是超级管理员 0-否 1-是',
  `remark` char(64) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态 -1-删除 0-启用 1-禁用',
  `login_num` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `last_login_ip` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录ip',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次登时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='系统用户表';

-- ----------------------------
-- Records of sxh_sys_user
-- ----------------------------
INSERT INTO `sxh_sys_user` VALUES ('1', 'sxh_admin', '396009016847195c9731fbe21047f646', 'be75119479280b687f978627a398b096', 'iOARel', '123456', '0', '超级管理员', '', '15279126033', 'test@qq.com', '1', '超级管理员', '0', '237', '2130706433', '1479908407', '1479103554', '1479908407');
INSERT INTO `sxh_sys_user` VALUES ('2', 'sxh_test', 'db0cad83303f011a5f787b5f89190428', '', 'COGMQe', '测试用户', '3', '审核客服', '', '15279126033', '', '0', '', '0', '80', '2130706433', '1479908916', '0', '1479908916');
INSERT INTO `sxh_sys_user` VALUES ('3', 'sxhsh0007', '24dabaf4e82a37c889b07e13f9982e6c', '', 'GDkLea', '田洁', '3', '审核客服', '', '15013785653', '', '0', '审核客服', '0', '1', '2130706433', '1479799001', '1479798938', '1479799001');
INSERT INTO `sxh_sys_user` VALUES ('4', 'sxhsh0006', 'aaa9f2d358bc12ef78e84648f74d041d', '', 'rbQhYV', '韩淑倩', '3', '审核客服', '', '18537698770', '', '0', '审核客服', '0', '0', '0', '0', '1479799162', '1479799162');
INSERT INTO `sxh_sys_user` VALUES ('5', 'sxhsh0005', '4f59afb6f86fdde44d7704e9a07298b5', '', 'yIDLNW', '韩亚莉', '3', '审核客服', '', '15997658612', '', '0', '审核客服', '0', '0', '0', '0', '1479799190', '1479799190');
INSERT INTO `sxh_sys_user` VALUES ('6', 'sxhsh0004', '99fb76f1f36593b428fa5eb6a4db79d1', '', 'mibNFq', '刑冰', '3', '审核客服', '', '18289569840', '', '0', '审核客服', '0', '0', '0', '0', '1479799211', '1479799211');
INSERT INTO `sxh_sys_user` VALUES ('7', 'sxhsh0003', '9947a52e4dab3fd1753114474d7a8230', '', 'ErdqxJ', '潘湘林', '3', '审核客服', '', '15626554207', '', '0', '审核客服', '0', '0', '0', '0', '1479799237', '1479799237');
INSERT INTO `sxh_sys_user` VALUES ('8', 'sxhsh0002', '0b7a62c8dcd9b51afd6e16ded75f8e93', '', 'dqNUuE', '丘欢兴', '3', '审核客服', '', '17875505117', '', '0', '审核客服', '0', '0', '0', '0', '1479799259', '1479799259');
INSERT INTO `sxh_sys_user` VALUES ('9', 'sxhsh0001', '7569aefe41a98aeb3cf1b94a2df50b2b', '', 'SoVYTs', '潘文丽', '3', '审核客服', '', '15994729893', '', '0', '审核客服', '0', '0', '0', '0', '1479799292', '1479799292');
INSERT INTO `sxh_sys_user` VALUES ('10', 'sxhsh0000', 'dd3a612f86e6841a8522f14480237f33', '', 'PALrdY', '刘荣', '3', '审核客服', '', '15707358555', '', '0', '审核客服', '0', '0', '0', '0', '1479799319', '1479799319');
INSERT INTO `sxh_sys_user` VALUES ('11', 'sxhxg0000', '8d94d14f1c4071f8b9cb1e30c42588ec', '', 'yuWvMh', '蓝清', '3', '审核客服', '', '13310839912', '', '0', '修改资料客服', '0', '0', '0', '0', '1479799348', '1479799348');
INSERT INTO `sxh_sys_user` VALUES ('12', 'sxhxg0003', '5060c355a1923c071ff686247c8d88b4', '', 'ceWrRz', '潘秀宁', '3', '审核客服', '', '15986604614', '', '0', '修改资料客服', '0', '0', '0', '0', '1479799377', '1479799377');
INSERT INTO `sxh_sys_user` VALUES ('13', 'sxhxg0004', '0918ccd9b9e15c6e4d6fdede523a190c', '', 'dhzFfZ', '凌珠', '3', '审核客服', '', '18318063065', '', '0', '修改资料客服', '0', '0', '0', '0', '1479799454', '1479799454');
INSERT INTO `sxh_sys_user` VALUES ('14', 'sxhxg0006', '25ce8c048c125b3cc8df6a9bfbac3160', '', 'QBpWia', '谢思霞', '3', '审核客服', '', '15112659958', '', '0', '修改资料客服', '0', '0', '0', '0', '1479799475', '1479799475');
INSERT INTO `sxh_sys_user` VALUES ('15', 'sxhxg0007', '3b333cd800b65406ec3a13d1a32b111e', '', 'NDbQEf', '涂华君', '3', '审核客服', '', '18307554135', '', '0', '修改资料客服', '0', '0', '0', '0', '1479799504', '1479799504');
INSERT INTO `sxh_sys_user` VALUES ('16', 'sxhxg0008', 'f1c1da11d33c01503445f53cc45dee8e', '', 'afOdQw', '林丽莎', '3', '审核客服', '', '15876762325', '', '0', '修改资料客服', '0', '0', '0', '0', '1479799532', '1479799532');
INSERT INTO `sxh_sys_user` VALUES ('17', 'sxhxg00081', '675905b2496decca0b1e98d1010c3af0', '', 'IMEAuW', '林丽莎1', '0', '', '', '15876762325', '', '0', '修改资料客服', '0', '0', '0', '0', '1479800103', '1479800103');
INSERT INTO `sxh_sys_user` VALUES ('18', 'sxhxg000812', 'cbc0f59b631fa3c3e34fb5b2d9703d0d', '259551de063b31a242d486ed2500a97c', 'lUOjwf', '林丽莎12', '0', '', '', '15876762325', '', '0', '修改资料客服', '0', '1', '2130706433', '1479800386', '1479800369', '1479800386');
INSERT INTO `sxh_sys_user` VALUES ('19', 'sunlianggen', '9701e56aad5b9d228c6b90227883938b', '', 'iTgPUM', '孙亮根', '0', '', '', '', '', '0', '后台注册', '0', '0', '0', '0', '1479801397', '1479801397');
INSERT INTO `sxh_sys_user` VALUES ('20', 'sxh_0001', 'ef90dd3b698899b36acfcd156c5df5cc', '', 'nLJCtp', '孙亮根', '0', '', '', '', '', '0', '后台注册', '0', '0', '0', '0', '1479801464', '1479801464');
INSERT INTO `sxh_sys_user` VALUES ('21', '请问q', '8a4fd66ac84357e32e3d9b3a70fd5399', '', 'ijuWNS', '请问我去', '0', '', '', '', '', '0', '后台注册', '0', '0', '0', '0', '1479807387', '1479807387');
INSERT INTO `sxh_sys_user` VALUES ('22', 'sxh_user_admin', 'd8dc0f1ee699f38ae406c4e01950699d', 'be75119479280b687f978627a398b096', 'pEJwju', '测试', '0', '', '', '', '', '0', '后台注册', '0', '1', '2130706433', '1479893322', '1479892670', '1479893322');
INSERT INTO `sxh_sys_user` VALUES ('23', 'afds_44', '970544af3e53eac8214f108b35819d18', 'be75119479280b687f978627a398b096', 'OTziBA', 'asfsdf', '0', '', '', '', '', '0', '后台注册', '0', '0', '0', '0', '1479893997', '1479893997');
INSERT INTO `sxh_sys_user` VALUES ('24', '23423_ww', '01eb66b35ef9495ca0a782fba6c409c0', 'be75119479280b687f978627a398b096', 'XrcKIq', '11', '2', '', '', '', '', '0', '22', '1', '0', '0', '0', '1479894032', '1479904777');

-- ----------------------------
-- Table structure for sxh_sys_user_log_4
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_user_log_4`;
CREATE TABLE `sxh_sys_user_log_4` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` smallint(5) NOT NULL COMMENT '操作用户',
  `username` char(20) NOT NULL COMMENT '用户名',
  `realname` char(20) NOT NULL COMMENT '真实姓名',
  `type` tinyint(1) NOT NULL COMMENT '标记 0-登录 1-修改 2-添加 3-删除4-还原',
  `remark` varchar(120) NOT NULL COMMENT 'log描述',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=482 DEFAULT CHARSET=utf8 COMMENT='会员操作日志表';

-- ----------------------------
-- Records of sxh_sys_user_log_4
-- ----------------------------
INSERT INTO `sxh_sys_user_log_4` VALUES ('50', '2', '137866134812', 'tt', '0', '【登录后台】【用户:tt】登录账号成功;操作地址：user/index/login', '1477202812');
INSERT INTO `sxh_sys_user_log_4` VALUES ('51', '2', '137866134812', 'tt', '2', '【添加数据】添加用户【用户名：13786613481211】;操作地址：user/user/add_user', '1477202959');
INSERT INTO `sxh_sys_user_log_4` VALUES ('52', '2', '137866134812', 'tt', '1', '【修改更新】修改用户【用户ID:1昵称：呵呵】;操作地址：user/user/set_user', '1477203047');
INSERT INTO `sxh_sys_user_log_4` VALUES ('53', '2', '137866134812', 'tt', '1', '【修改更新】修改用户状态为启用【用户ID:1】;操作地址：user/user/disable_user', '1477203081');
INSERT INTO `sxh_sys_user_log_4` VALUES ('54', '2', '137866134812', 'tt', '1', '【修改更新】修改用户状态为启用【用户ID:1】;操作地址：user/user/disable_user', '1477203105');
INSERT INTO `sxh_sys_user_log_4` VALUES ('55', '2', '137866134812', 'tt', '1', '【修改更新】修改用户状态为启用【用户ID:1】;操作地址：user/user/disable_user', '1477203268');
INSERT INTO `sxh_sys_user_log_4` VALUES ('56', '2', '137866134812', 'tt', '1', '【修改更新】修改用户状态为删除【用户ID:1】;操作地址：user/user/del_user', '1477203322');
INSERT INTO `sxh_sys_user_log_4` VALUES ('57', '2', '137866134812', 'tt', '1', '【修改更新】修改用户状态为还原【用户ID:1】;操作地址：user/user/del_user', '1477203344');
INSERT INTO `sxh_sys_user_log_4` VALUES ('58', '2', '137866134812', 'tt', '1', '【修改更新】修改用户密码【用户ID:1】;操作地址：user/user/set_user_password', '1477203560');
INSERT INTO `sxh_sys_user_log_4` VALUES ('59', '2', '137866134812', 'tt', '2', '【添加数据】添加菜单【菜单名：这是一个菜单】;操作地址：user/menu/add_menu', '1477203696');
INSERT INTO `sxh_sys_user_log_4` VALUES ('60', '2', '137866134812', 'tt', '1', '【修改更新】修改菜单【菜单ID：2】;操作地址：user/menu/set_menu', '1477203804');
INSERT INTO `sxh_sys_user_log_4` VALUES ('61', '2', '137866134812', 'tt', '2', '【添加数据】添加菜单【菜单ID：1菜单名：这是一个菜单】;操作地址：user/menu/add_menu', '1477203986');
INSERT INTO `sxh_sys_user_log_4` VALUES ('62', '2', '137866134812', 'tt', '2', '【添加数据】添加菜单【菜单ID：16菜单名：这是一个菜单】;操作地址：user/menu/add_menu', '1477204039');
INSERT INTO `sxh_sys_user_log_4` VALUES ('63', '2', '137866134812', 'tt', '2', '【添加数据】添加用户【用户ID：10用户名：1378661348121133】;操作地址：user/user/add_user', '1477204116');
INSERT INTO `sxh_sys_user_log_4` VALUES ('64', '2', '137866134812', 'tt', '1', '【修改更新】修改菜单状态为禁用【菜单ID：2】;操作地址：user/menu/disable_menu', '1477204226');
INSERT INTO `sxh_sys_user_log_4` VALUES ('65', '2', '137866134812', 'tt', '1', '【修改更新】修改菜单状态为删除【菜单ID：2】;操作地址：user/menu/del_menu', '1477204229');
INSERT INTO `sxh_sys_user_log_4` VALUES ('66', '2', '137866134812', 'tt', '1', '【修改更新】修改菜单状态为禁用【菜单ID：2】;操作地址：user/menu/disable_menu', '1477204281');
INSERT INTO `sxh_sys_user_log_4` VALUES ('67', '2', '137866134812', 'tt', '1', '【修改更新】修改菜单状态为启用【菜单ID：2】;操作地址：user/menu/disable_menu', '1477204284');
INSERT INTO `sxh_sys_user_log_4` VALUES ('68', '2', '137866134812', 'tt', '1', '【修改更新】修改菜单状态为删除【菜单ID：2】;操作地址：user/menu/del_menu', '1477204346');
INSERT INTO `sxh_sys_user_log_4` VALUES ('69', '2', '137866134812', 'tt', '1', '【修改更新】修改提供资助订单状态为删除【用户ID:1】;操作地址：business/provide/destroy_provide', '1477204536');
INSERT INTO `sxh_sys_user_log_4` VALUES ('70', '2', '137866134812', 'tt', '1', '【修改更新】修改提供资助订单状态为还原【用户ID:1】;操作地址：business/provide/destroy_provide', '1477204566');
INSERT INTO `sxh_sys_user_log_4` VALUES ('71', '2', '137866134812', 'tt', '1', '【修改更新】修改提供资助订单状态为删除【用户ID:1】;操作地址：business/provide/destroy_provide', '1477204580');
INSERT INTO `sxh_sys_user_log_4` VALUES ('72', '2', '137866134812', 'tt', '1', '【修改更新】修改提供资助订单状态为还原【用户ID:1】;操作地址：business/provide/destroy_provide', '1477204587');
INSERT INTO `sxh_sys_user_log_4` VALUES ('73', '2', '137866134812', 'tt', '3', '【删除数据】修改提供资助订单状态为删除【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/destroy_match', '1477204675');
INSERT INTO `sxh_sys_user_log_4` VALUES ('74', '2', '137866134812', 'tt', '4', '【登录后台】修改提供资助订单状态还原正常【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/reduction_match', '1477204719');
INSERT INTO `sxh_sys_user_log_4` VALUES ('75', '2', '137866134812', 'tt', '1', '【修改更新】延时了匹配订单的打款时间0小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1477204965');
INSERT INTO `sxh_sys_user_log_4` VALUES ('76', '2', '137866134812', 'tt', '1', '【修改更新】延时了匹配订单的打款时间0小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1477205031');
INSERT INTO `sxh_sys_user_log_4` VALUES ('77', '2', '137866134812', 'tt', '1', '【修改更新】延时了匹配订单的打款时间1小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1477205424');
INSERT INTO `sxh_sys_user_log_4` VALUES ('78', '2', '137866134812', 'tt', '0', '【登录后台】【用户:tt】登录账号成功;操作地址：user/index/login', '1477273815');
INSERT INTO `sxh_sys_user_log_4` VALUES ('79', '11', '137866134812', '呵呵', '0', '【登录后台】【用户:呵呵】登录账号成功;操作地址：user/index/login', '0');
INSERT INTO `sxh_sys_user_log_4` VALUES ('80', '11', '137866134812', '呵呵', '0', '【登录后台】【用户:呵呵】登录账号成功;操作地址：user/index/login', '1478074975');
INSERT INTO `sxh_sys_user_log_4` VALUES ('81', '11', '137866134812', '呵呵', '0', '【登录后台】【用户:呵呵】登录账号成功;操作地址：user/index/login', '1478139024');
INSERT INTO `sxh_sys_user_log_4` VALUES ('82', '11', '137866134812', '呵呵', '1', '【修改更新】延时了匹配订单的打款时间3小时；【匹配ID:,提供资助ID:,接受资助ID：】;操作地址：business/matching/delayed_match', '1478146778');
INSERT INTO `sxh_sys_user_log_4` VALUES ('83', '11', '137866134812', '呵呵', '1', '【修改更新】延时了匹配订单的打款时间3小时；【匹配ID:,提供资助ID:,接受资助ID：】;操作地址：business/matching/delayed_match', '1478146803');
INSERT INTO `sxh_sys_user_log_4` VALUES ('84', '11', '137866134812', '呵呵', '1', '【修改更新】延时了匹配订单的打款时间3小时；【匹配ID:,提供资助ID:,接受资助ID：】;操作地址：business/matching/delayed_match', '1478146818');
INSERT INTO `sxh_sys_user_log_4` VALUES ('85', '11', '137866134812', '呵呵', '1', '【修改更新】延时了匹配订单的打款时间3小时；【匹配ID:,提供资助ID:,接受资助ID：】;操作地址：business/matching/delayed_match', '1478146836');
INSERT INTO `sxh_sys_user_log_4` VALUES ('86', '11', '137866134812', '呵呵', '1', '【修改更新】延时了匹配订单的打款时间3小时；【匹配ID:,提供资助ID:,接受资助ID：】;操作地址：business/matching/delayed_match', '1478152054');
INSERT INTO `sxh_sys_user_log_4` VALUES ('87', '11', '137866134812', '呵呵', '1', '【修改更新】延时了匹配订单的打款时间3小时；【匹配ID:5,1,提供资助ID:2,1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1478152935');
INSERT INTO `sxh_sys_user_log_4` VALUES ('88', '11', '137866134812', '呵呵', '0', '【登录后台】【用户:呵呵】登录账号成功;操作地址：user/index/login', '1478223003');
INSERT INTO `sxh_sys_user_log_4` VALUES ('89', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479103965');
INSERT INTO `sxh_sys_user_log_4` VALUES ('90', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479104346');
INSERT INTO `sxh_sys_user_log_4` VALUES ('91', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479107836');
INSERT INTO `sxh_sys_user_log_4` VALUES ('92', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479175658');
INSERT INTO `sxh_sys_user_log_4` VALUES ('93', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479175659');
INSERT INTO `sxh_sys_user_log_4` VALUES ('94', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479175659');
INSERT INTO `sxh_sys_user_log_4` VALUES ('95', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479175978');
INSERT INTO `sxh_sys_user_log_4` VALUES ('96', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479176815');
INSERT INTO `sxh_sys_user_log_4` VALUES ('97', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479177879');
INSERT INTO `sxh_sys_user_log_4` VALUES ('98', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479178357');
INSERT INTO `sxh_sys_user_log_4` VALUES ('99', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479179006');
INSERT INTO `sxh_sys_user_log_4` VALUES ('100', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479179117');
INSERT INTO `sxh_sys_user_log_4` VALUES ('101', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479179202');
INSERT INTO `sxh_sys_user_log_4` VALUES ('102', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479179241');
INSERT INTO `sxh_sys_user_log_4` VALUES ('103', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479179252');
INSERT INTO `sxh_sys_user_log_4` VALUES ('104', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479180576');
INSERT INTO `sxh_sys_user_log_4` VALUES ('105', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479189349');
INSERT INTO `sxh_sys_user_log_4` VALUES ('106', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479189961');
INSERT INTO `sxh_sys_user_log_4` VALUES ('107', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479193562');
INSERT INTO `sxh_sys_user_log_4` VALUES ('108', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479195143');
INSERT INTO `sxh_sys_user_log_4` VALUES ('109', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479195221');
INSERT INTO `sxh_sys_user_log_4` VALUES ('110', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479196184');
INSERT INTO `sxh_sys_user_log_4` VALUES ('111', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479196871');
INSERT INTO `sxh_sys_user_log_4` VALUES ('112', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479197240');
INSERT INTO `sxh_sys_user_log_4` VALUES ('113', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479197544');
INSERT INTO `sxh_sys_user_log_4` VALUES ('114', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479197577');
INSERT INTO `sxh_sys_user_log_4` VALUES ('115', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479201420');
INSERT INTO `sxh_sys_user_log_4` VALUES ('116', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479202476');
INSERT INTO `sxh_sys_user_log_4` VALUES ('117', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479203238');
INSERT INTO `sxh_sys_user_log_4` VALUES ('118', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479204842');
INSERT INTO `sxh_sys_user_log_4` VALUES ('119', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479259901');
INSERT INTO `sxh_sys_user_log_4` VALUES ('120', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479260470');
INSERT INTO `sxh_sys_user_log_4` VALUES ('121', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479260548');
INSERT INTO `sxh_sys_user_log_4` VALUES ('122', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479260648');
INSERT INTO `sxh_sys_user_log_4` VALUES ('123', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479260833');
INSERT INTO `sxh_sys_user_log_4` VALUES ('124', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479261448');
INSERT INTO `sxh_sys_user_log_4` VALUES ('125', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479261939');
INSERT INTO `sxh_sys_user_log_4` VALUES ('126', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479262141');
INSERT INTO `sxh_sys_user_log_4` VALUES ('127', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479267827');
INSERT INTO `sxh_sys_user_log_4` VALUES ('128', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479268567');
INSERT INTO `sxh_sys_user_log_4` VALUES ('129', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479278378');
INSERT INTO `sxh_sys_user_log_4` VALUES ('130', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479279735');
INSERT INTO `sxh_sys_user_log_4` VALUES ('131', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间2小时；【匹配ID:2,1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479285164');
INSERT INTO `sxh_sys_user_log_4` VALUES ('132', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间2小时；【匹配ID:2,1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479285264');
INSERT INTO `sxh_sys_user_log_4` VALUES ('133', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间2小时；【匹配ID:2,1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479286526');
INSERT INTO `sxh_sys_user_log_4` VALUES ('134', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间1小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479287591');
INSERT INTO `sxh_sys_user_log_4` VALUES ('135', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479289165');
INSERT INTO `sxh_sys_user_log_4` VALUES ('136', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479291536');
INSERT INTO `sxh_sys_user_log_4` VALUES ('137', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479292610');
INSERT INTO `sxh_sys_user_log_4` VALUES ('138', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479294729');
INSERT INTO `sxh_sys_user_log_4` VALUES ('139', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479349546');
INSERT INTO `sxh_sys_user_log_4` VALUES ('140', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479352290');
INSERT INTO `sxh_sys_user_log_4` VALUES ('141', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479352378');
INSERT INTO `sxh_sys_user_log_4` VALUES ('142', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479353029');
INSERT INTO `sxh_sys_user_log_4` VALUES ('143', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间2小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479353116');
INSERT INTO `sxh_sys_user_log_4` VALUES ('144', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间1小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479353645');
INSERT INTO `sxh_sys_user_log_4` VALUES ('145', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间2小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479354061');
INSERT INTO `sxh_sys_user_log_4` VALUES ('146', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间3小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479354401');
INSERT INTO `sxh_sys_user_log_4` VALUES ('147', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间2小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479355076');
INSERT INTO `sxh_sys_user_log_4` VALUES ('148', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间2小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479355140');
INSERT INTO `sxh_sys_user_log_4` VALUES ('149', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间2小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479355418');
INSERT INTO `sxh_sys_user_log_4` VALUES ('150', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间3小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479355552');
INSERT INTO `sxh_sys_user_log_4` VALUES ('151', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间2小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479361454');
INSERT INTO `sxh_sys_user_log_4` VALUES ('152', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间2小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479361680');
INSERT INTO `sxh_sys_user_log_4` VALUES ('153', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间1小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479361742');
INSERT INTO `sxh_sys_user_log_4` VALUES ('154', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间2小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479361936');
INSERT INTO `sxh_sys_user_log_4` VALUES ('155', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间3小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479362032');
INSERT INTO `sxh_sys_user_log_4` VALUES ('156', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间4小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479362212');
INSERT INTO `sxh_sys_user_log_4` VALUES ('157', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479362530');
INSERT INTO `sxh_sys_user_log_4` VALUES ('158', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间1小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479362923');
INSERT INTO `sxh_sys_user_log_4` VALUES ('159', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间2小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479362999');
INSERT INTO `sxh_sys_user_log_4` VALUES ('160', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间5小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479363022');
INSERT INTO `sxh_sys_user_log_4` VALUES ('161', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间2小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479363069');
INSERT INTO `sxh_sys_user_log_4` VALUES ('162', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间3小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479363080');
INSERT INTO `sxh_sys_user_log_4` VALUES ('163', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间3小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479363095');
INSERT INTO `sxh_sys_user_log_4` VALUES ('164', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479363216');
INSERT INTO `sxh_sys_user_log_4` VALUES ('165', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479369030');
INSERT INTO `sxh_sys_user_log_4` VALUES ('166', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479369163');
INSERT INTO `sxh_sys_user_log_4` VALUES ('167', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479369282');
INSERT INTO `sxh_sys_user_log_4` VALUES ('168', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479369484');
INSERT INTO `sxh_sys_user_log_4` VALUES ('169', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间2小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479369569');
INSERT INTO `sxh_sys_user_log_4` VALUES ('170', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479371486');
INSERT INTO `sxh_sys_user_log_4` VALUES ('171', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479372308');
INSERT INTO `sxh_sys_user_log_4` VALUES ('172', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479372321');
INSERT INTO `sxh_sys_user_log_4` VALUES ('173', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479372348');
INSERT INTO `sxh_sys_user_log_4` VALUES ('174', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479372361');
INSERT INTO `sxh_sys_user_log_4` VALUES ('175', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479372387');
INSERT INTO `sxh_sys_user_log_4` VALUES ('176', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479372430');
INSERT INTO `sxh_sys_user_log_4` VALUES ('177', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479372439');
INSERT INTO `sxh_sys_user_log_4` VALUES ('178', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479372534');
INSERT INTO `sxh_sys_user_log_4` VALUES ('179', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479372867');
INSERT INTO `sxh_sys_user_log_4` VALUES ('180', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479373586');
INSERT INTO `sxh_sys_user_log_4` VALUES ('181', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479373753');
INSERT INTO `sxh_sys_user_log_4` VALUES ('182', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479373755');
INSERT INTO `sxh_sys_user_log_4` VALUES ('183', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479373756');
INSERT INTO `sxh_sys_user_log_4` VALUES ('184', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间2小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479374698');
INSERT INTO `sxh_sys_user_log_4` VALUES ('185', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间3小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479374717');
INSERT INTO `sxh_sys_user_log_4` VALUES ('186', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479375081');
INSERT INTO `sxh_sys_user_log_4` VALUES ('187', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479375659');
INSERT INTO `sxh_sys_user_log_4` VALUES ('188', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479376824');
INSERT INTO `sxh_sys_user_log_4` VALUES ('189', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479377895');
INSERT INTO `sxh_sys_user_log_4` VALUES ('190', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479378097');
INSERT INTO `sxh_sys_user_log_4` VALUES ('191', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479379949');
INSERT INTO `sxh_sys_user_log_4` VALUES ('192', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479380463');
INSERT INTO `sxh_sys_user_log_4` VALUES ('193', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479381357');
INSERT INTO `sxh_sys_user_log_4` VALUES ('194', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479433029');
INSERT INTO `sxh_sys_user_log_4` VALUES ('195', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479433310');
INSERT INTO `sxh_sys_user_log_4` VALUES ('196', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479433310');
INSERT INTO `sxh_sys_user_log_4` VALUES ('197', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479433375');
INSERT INTO `sxh_sys_user_log_4` VALUES ('198', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479434140');
INSERT INTO `sxh_sys_user_log_4` VALUES ('199', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479434261');
INSERT INTO `sxh_sys_user_log_4` VALUES ('200', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479434399');
INSERT INTO `sxh_sys_user_log_4` VALUES ('201', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479436046');
INSERT INTO `sxh_sys_user_log_4` VALUES ('202', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479436149');
INSERT INTO `sxh_sys_user_log_4` VALUES ('203', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479436638');
INSERT INTO `sxh_sys_user_log_4` VALUES ('204', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479437814');
INSERT INTO `sxh_sys_user_log_4` VALUES ('205', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479438702');
INSERT INTO `sxh_sys_user_log_4` VALUES ('206', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479441345');
INSERT INTO `sxh_sys_user_log_4` VALUES ('207', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479441447');
INSERT INTO `sxh_sys_user_log_4` VALUES ('208', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479447778');
INSERT INTO `sxh_sys_user_log_4` VALUES ('209', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479447981');
INSERT INTO `sxh_sys_user_log_4` VALUES ('210', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479450694');
INSERT INTO `sxh_sys_user_log_4` VALUES ('211', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479450814');
INSERT INTO `sxh_sys_user_log_4` VALUES ('212', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479455738');
INSERT INTO `sxh_sys_user_log_4` VALUES ('213', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间2小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479458038');
INSERT INTO `sxh_sys_user_log_4` VALUES ('214', '1', 'admin', '管理员', '1', '【修改更新】延时了匹配订单的打款时间4小时；【匹配ID:1,提供资助ID:1,接受资助ID：1】;操作地址：business/matching/delayed_match', '1479458053');
INSERT INTO `sxh_sys_user_log_4` VALUES ('215', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479461476');
INSERT INTO `sxh_sys_user_log_4` VALUES ('216', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479461479');
INSERT INTO `sxh_sys_user_log_4` VALUES ('217', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479462013');
INSERT INTO `sxh_sys_user_log_4` VALUES ('218', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479463125');
INSERT INTO `sxh_sys_user_log_4` VALUES ('219', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479463262');
INSERT INTO `sxh_sys_user_log_4` VALUES ('220', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479464292');
INSERT INTO `sxh_sys_user_log_4` VALUES ('221', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479519400');
INSERT INTO `sxh_sys_user_log_4` VALUES ('222', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479524201');
INSERT INTO `sxh_sys_user_log_4` VALUES ('223', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479534652');
INSERT INTO `sxh_sys_user_log_4` VALUES ('224', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479540394');
INSERT INTO `sxh_sys_user_log_4` VALUES ('225', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479541717');
INSERT INTO `sxh_sys_user_log_4` VALUES ('226', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479542146');
INSERT INTO `sxh_sys_user_log_4` VALUES ('227', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479549320');
INSERT INTO `sxh_sys_user_log_4` VALUES ('228', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479691302');
INSERT INTO `sxh_sys_user_log_4` VALUES ('229', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479691344');
INSERT INTO `sxh_sys_user_log_4` VALUES ('230', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479691838');
INSERT INTO `sxh_sys_user_log_4` VALUES ('231', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479693485');
INSERT INTO `sxh_sys_user_log_4` VALUES ('232', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479695683');
INSERT INTO `sxh_sys_user_log_4` VALUES ('233', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479695742');
INSERT INTO `sxh_sys_user_log_4` VALUES ('234', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479695849');
INSERT INTO `sxh_sys_user_log_4` VALUES ('235', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479696962');
INSERT INTO `sxh_sys_user_log_4` VALUES ('236', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479697638');
INSERT INTO `sxh_sys_user_log_4` VALUES ('237', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479698487');
INSERT INTO `sxh_sys_user_log_4` VALUES ('238', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479698987');
INSERT INTO `sxh_sys_user_log_4` VALUES ('239', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479699398');
INSERT INTO `sxh_sys_user_log_4` VALUES ('240', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479699675');
INSERT INTO `sxh_sys_user_log_4` VALUES ('241', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479699900');
INSERT INTO `sxh_sys_user_log_4` VALUES ('242', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479700631');
INSERT INTO `sxh_sys_user_log_4` VALUES ('243', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479700742');
INSERT INTO `sxh_sys_user_log_4` VALUES ('244', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479706510');
INSERT INTO `sxh_sys_user_log_4` VALUES ('245', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479706575');
INSERT INTO `sxh_sys_user_log_4` VALUES ('246', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479706798');
INSERT INTO `sxh_sys_user_log_4` VALUES ('247', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479706912');
INSERT INTO `sxh_sys_user_log_4` VALUES ('248', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479706982');
INSERT INTO `sxh_sys_user_log_4` VALUES ('249', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479707135');
INSERT INTO `sxh_sys_user_log_4` VALUES ('250', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479707403');
INSERT INTO `sxh_sys_user_log_4` VALUES ('251', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479708606');
INSERT INTO `sxh_sys_user_log_4` VALUES ('252', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479709750');
INSERT INTO `sxh_sys_user_log_4` VALUES ('253', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479710862');
INSERT INTO `sxh_sys_user_log_4` VALUES ('254', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479711219');
INSERT INTO `sxh_sys_user_log_4` VALUES ('255', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479711799');
INSERT INTO `sxh_sys_user_log_4` VALUES ('256', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479712865');
INSERT INTO `sxh_sys_user_log_4` VALUES ('257', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479713687');
INSERT INTO `sxh_sys_user_log_4` VALUES ('258', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479714356');
INSERT INTO `sxh_sys_user_log_4` VALUES ('259', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479716069');
INSERT INTO `sxh_sys_user_log_4` VALUES ('260', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479717552');
INSERT INTO `sxh_sys_user_log_4` VALUES ('261', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479718002');
INSERT INTO `sxh_sys_user_log_4` VALUES ('262', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479718595');
INSERT INTO `sxh_sys_user_log_4` VALUES ('263', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479718598');
INSERT INTO `sxh_sys_user_log_4` VALUES ('264', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479718601');
INSERT INTO `sxh_sys_user_log_4` VALUES ('265', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479719373');
INSERT INTO `sxh_sys_user_log_4` VALUES ('266', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479719498');
INSERT INTO `sxh_sys_user_log_4` VALUES ('267', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479719661');
INSERT INTO `sxh_sys_user_log_4` VALUES ('268', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479719850');
INSERT INTO `sxh_sys_user_log_4` VALUES ('269', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479719974');
INSERT INTO `sxh_sys_user_log_4` VALUES ('270', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479720144');
INSERT INTO `sxh_sys_user_log_4` VALUES ('271', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479720282');
INSERT INTO `sxh_sys_user_log_4` VALUES ('272', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479720431');
INSERT INTO `sxh_sys_user_log_4` VALUES ('273', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479720536');
INSERT INTO `sxh_sys_user_log_4` VALUES ('274', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479722623');
INSERT INTO `sxh_sys_user_log_4` VALUES ('275', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479722749');
INSERT INTO `sxh_sys_user_log_4` VALUES ('276', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479722979');
INSERT INTO `sxh_sys_user_log_4` VALUES ('277', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479723025');
INSERT INTO `sxh_sys_user_log_4` VALUES ('278', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479723066');
INSERT INTO `sxh_sys_user_log_4` VALUES ('279', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479723913');
INSERT INTO `sxh_sys_user_log_4` VALUES ('280', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479727229');
INSERT INTO `sxh_sys_user_log_4` VALUES ('281', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479727630');
INSERT INTO `sxh_sys_user_log_4` VALUES ('282', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479728749');
INSERT INTO `sxh_sys_user_log_4` VALUES ('283', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479729258');
INSERT INTO `sxh_sys_user_log_4` VALUES ('284', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479729267');
INSERT INTO `sxh_sys_user_log_4` VALUES ('285', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479731327');
INSERT INTO `sxh_sys_user_log_4` VALUES ('286', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479731533');
INSERT INTO `sxh_sys_user_log_4` VALUES ('287', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479733722');
INSERT INTO `sxh_sys_user_log_4` VALUES ('288', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479735373');
INSERT INTO `sxh_sys_user_log_4` VALUES ('289', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479738663');
INSERT INTO `sxh_sys_user_log_4` VALUES ('290', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479739216');
INSERT INTO `sxh_sys_user_log_4` VALUES ('291', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479739417');
INSERT INTO `sxh_sys_user_log_4` VALUES ('292', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479741079');
INSERT INTO `sxh_sys_user_log_4` VALUES ('293', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479741617');
INSERT INTO `sxh_sys_user_log_4` VALUES ('294', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479741676');
INSERT INTO `sxh_sys_user_log_4` VALUES ('295', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479741941');
INSERT INTO `sxh_sys_user_log_4` VALUES ('296', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479742588');
INSERT INTO `sxh_sys_user_log_4` VALUES ('297', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479742890');
INSERT INTO `sxh_sys_user_log_4` VALUES ('298', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479743095');
INSERT INTO `sxh_sys_user_log_4` VALUES ('299', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479743690');
INSERT INTO `sxh_sys_user_log_4` VALUES ('300', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479743695');
INSERT INTO `sxh_sys_user_log_4` VALUES ('301', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479743695');
INSERT INTO `sxh_sys_user_log_4` VALUES ('302', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479744439');
INSERT INTO `sxh_sys_user_log_4` VALUES ('303', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479744532');
INSERT INTO `sxh_sys_user_log_4` VALUES ('304', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479746781');
INSERT INTO `sxh_sys_user_log_4` VALUES ('305', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479746960');
INSERT INTO `sxh_sys_user_log_4` VALUES ('306', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479748283');
INSERT INTO `sxh_sys_user_log_4` VALUES ('307', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479748978');
INSERT INTO `sxh_sys_user_log_4` VALUES ('308', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479750442');
INSERT INTO `sxh_sys_user_log_4` VALUES ('309', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479750637');
INSERT INTO `sxh_sys_user_log_4` VALUES ('310', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479750900');
INSERT INTO `sxh_sys_user_log_4` VALUES ('311', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479777945');
INSERT INTO `sxh_sys_user_log_4` VALUES ('312', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479778550');
INSERT INTO `sxh_sys_user_log_4` VALUES ('313', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479779086');
INSERT INTO `sxh_sys_user_log_4` VALUES ('314', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479781042');
INSERT INTO `sxh_sys_user_log_4` VALUES ('315', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479781565');
INSERT INTO `sxh_sys_user_log_4` VALUES ('316', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479781654');
INSERT INTO `sxh_sys_user_log_4` VALUES ('317', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479781613');
INSERT INTO `sxh_sys_user_log_4` VALUES ('318', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479784249');
INSERT INTO `sxh_sys_user_log_4` VALUES ('319', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479784454');
INSERT INTO `sxh_sys_user_log_4` VALUES ('320', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479784562');
INSERT INTO `sxh_sys_user_log_4` VALUES ('321', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479784569');
INSERT INTO `sxh_sys_user_log_4` VALUES ('322', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479784576');
INSERT INTO `sxh_sys_user_log_4` VALUES ('323', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479784619');
INSERT INTO `sxh_sys_user_log_4` VALUES ('324', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479784631');
INSERT INTO `sxh_sys_user_log_4` VALUES ('325', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479784816');
INSERT INTO `sxh_sys_user_log_4` VALUES ('326', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479784859');
INSERT INTO `sxh_sys_user_log_4` VALUES ('327', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479785441');
INSERT INTO `sxh_sys_user_log_4` VALUES ('328', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479785515');
INSERT INTO `sxh_sys_user_log_4` VALUES ('329', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479785570');
INSERT INTO `sxh_sys_user_log_4` VALUES ('330', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479785978');
INSERT INTO `sxh_sys_user_log_4` VALUES ('331', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479786883');
INSERT INTO `sxh_sys_user_log_4` VALUES ('332', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479787291');
INSERT INTO `sxh_sys_user_log_4` VALUES ('333', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479793926');
INSERT INTO `sxh_sys_user_log_4` VALUES ('334', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479794193');
INSERT INTO `sxh_sys_user_log_4` VALUES ('335', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479794226');
INSERT INTO `sxh_sys_user_log_4` VALUES ('336', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479794425');
INSERT INTO `sxh_sys_user_log_4` VALUES ('337', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479794710');
INSERT INTO `sxh_sys_user_log_4` VALUES ('338', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479794741');
INSERT INTO `sxh_sys_user_log_4` VALUES ('339', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479794778');
INSERT INTO `sxh_sys_user_log_4` VALUES ('340', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479795389');
INSERT INTO `sxh_sys_user_log_4` VALUES ('341', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479797514');
INSERT INTO `sxh_sys_user_log_4` VALUES ('342', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479797878');
INSERT INTO `sxh_sys_user_log_4` VALUES ('343', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479798502');
INSERT INTO `sxh_sys_user_log_4` VALUES ('344', '1', 'admin', '管理员', '2', '【添加数据】添加用户【用户ID：3用户名：sxhsh0007】;操作地址：user/user/add_user', '1479798938');
INSERT INTO `sxh_sys_user_log_4` VALUES ('345', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479798998');
INSERT INTO `sxh_sys_user_log_4` VALUES ('346', '3', 'sxhsh0007', '田洁', '0', '【登录后台】【用户:田洁】登录账号成功;操作地址：user/index/login', '1479799001');
INSERT INTO `sxh_sys_user_log_4` VALUES ('347', '1', 'admin', '管理员', '2', '【添加数据】添加用户【用户ID：4用户名：sxhsh0006 】;操作地址：user/user/add_user', '1479799162');
INSERT INTO `sxh_sys_user_log_4` VALUES ('348', '1', 'admin', '管理员', '2', '【添加数据】添加用户【用户ID：5用户名：sxhsh0005】;操作地址：user/user/add_user', '1479799190');
INSERT INTO `sxh_sys_user_log_4` VALUES ('349', '1', 'admin', '管理员', '2', '【添加数据】添加用户【用户ID：6用户名：sxhsh0004】;操作地址：user/user/add_user', '1479799211');
INSERT INTO `sxh_sys_user_log_4` VALUES ('350', '1', 'admin', '管理员', '2', '【添加数据】添加用户【用户ID：7用户名：sxhsh0003】;操作地址：user/user/add_user', '1479799237');
INSERT INTO `sxh_sys_user_log_4` VALUES ('351', '1', 'admin', '管理员', '2', '【添加数据】添加用户【用户ID：8用户名：sxhsh0002】;操作地址：user/user/add_user', '1479799259');
INSERT INTO `sxh_sys_user_log_4` VALUES ('352', '1', 'admin', '管理员', '2', '【添加数据】添加用户【用户ID：9用户名：sxhsh0001】;操作地址：user/user/add_user', '1479799292');
INSERT INTO `sxh_sys_user_log_4` VALUES ('353', '1', 'admin', '管理员', '2', '【添加数据】添加用户【用户ID：10用户名：sxhsh0000 】;操作地址：user/user/add_user', '1479799319');
INSERT INTO `sxh_sys_user_log_4` VALUES ('354', '1', 'admin', '管理员', '2', '【添加数据】添加用户【用户ID：11用户名：sxhxg0000】;操作地址：user/user/add_user', '1479799348');
INSERT INTO `sxh_sys_user_log_4` VALUES ('355', '1', 'admin', '管理员', '2', '【添加数据】添加用户【用户ID：12用户名：sxhxg0003】;操作地址：user/user/add_user', '1479799377');
INSERT INTO `sxh_sys_user_log_4` VALUES ('356', '1', 'admin', '管理员', '2', '【添加数据】添加用户【用户ID：13用户名：sxhxg0004 】;操作地址：user/user/add_user', '1479799454');
INSERT INTO `sxh_sys_user_log_4` VALUES ('357', '1', 'admin', '管理员', '2', '【添加数据】添加用户【用户ID：14用户名：sxhxg0006】;操作地址：user/user/add_user', '1479799475');
INSERT INTO `sxh_sys_user_log_4` VALUES ('358', '1', 'admin', '管理员', '2', '【添加数据】添加用户【用户ID：15用户名：sxhxg0007 】;操作地址：user/user/add_user', '1479799504');
INSERT INTO `sxh_sys_user_log_4` VALUES ('359', '1', 'admin', '管理员', '2', '【添加数据】添加用户【用户ID：16用户名：sxhxg0008】;操作地址：user/user/add_user', '1479799532');
INSERT INTO `sxh_sys_user_log_4` VALUES ('360', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479799638');
INSERT INTO `sxh_sys_user_log_4` VALUES ('361', '1', 'admin', '管理员', '2', '【添加数据】添加用户【用户ID：17用户名：sxhxg00081】;操作地址：user/user/add_user', '1479800103');
INSERT INTO `sxh_sys_user_log_4` VALUES ('362', '1', 'admin', '管理员', '2', '【添加数据】添加用户【用户ID：18用户名：sxhxg000812】;操作地址：user/user/add_user', '1479800369');
INSERT INTO `sxh_sys_user_log_4` VALUES ('363', '18', 'sxhxg000812', '林丽莎12', '0', '【登录后台】【用户:林丽莎12】登录账号成功;操作地址：user/index/login', '1479800386');
INSERT INTO `sxh_sys_user_log_4` VALUES ('364', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479801073');
INSERT INTO `sxh_sys_user_log_4` VALUES ('365', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479801215');
INSERT INTO `sxh_sys_user_log_4` VALUES ('366', '1', 'admin', '管理员', '2', '【添加数据】添加用户【用户ID：19用户名：sunlianggen】;操作地址：user/user/add_user', '1479801397');
INSERT INTO `sxh_sys_user_log_4` VALUES ('367', '1', 'admin', '管理员', '2', '【添加数据】添加用户【用户ID：20用户名：sxh_0001】;操作地址：user/user/add_user', '1479801464');
INSERT INTO `sxh_sys_user_log_4` VALUES ('368', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479802633');
INSERT INTO `sxh_sys_user_log_4` VALUES ('369', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479802796');
INSERT INTO `sxh_sys_user_log_4` VALUES ('370', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479802797');
INSERT INTO `sxh_sys_user_log_4` VALUES ('371', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479803327');
INSERT INTO `sxh_sys_user_log_4` VALUES ('372', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479803395');
INSERT INTO `sxh_sys_user_log_4` VALUES ('373', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479804611');
INSERT INTO `sxh_sys_user_log_4` VALUES ('374', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479805570');
INSERT INTO `sxh_sys_user_log_4` VALUES ('375', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479805613');
INSERT INTO `sxh_sys_user_log_4` VALUES ('376', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479806210');
INSERT INTO `sxh_sys_user_log_4` VALUES ('377', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479806275');
INSERT INTO `sxh_sys_user_log_4` VALUES ('378', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479806331');
INSERT INTO `sxh_sys_user_log_4` VALUES ('379', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479806942');
INSERT INTO `sxh_sys_user_log_4` VALUES ('380', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479807356');
INSERT INTO `sxh_sys_user_log_4` VALUES ('381', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479807369');
INSERT INTO `sxh_sys_user_log_4` VALUES ('382', '1', 'admin', '管理员', '2', '【添加数据】添加用户【用户ID：21用户名：请问q】;操作地址：user/user/add_user', '1479807387');
INSERT INTO `sxh_sys_user_log_4` VALUES ('383', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479807597');
INSERT INTO `sxh_sys_user_log_4` VALUES ('384', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479807817');
INSERT INTO `sxh_sys_user_log_4` VALUES ('385', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479807936');
INSERT INTO `sxh_sys_user_log_4` VALUES ('386', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479808042');
INSERT INTO `sxh_sys_user_log_4` VALUES ('387', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479808111');
INSERT INTO `sxh_sys_user_log_4` VALUES ('388', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479812461');
INSERT INTO `sxh_sys_user_log_4` VALUES ('389', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479813861');
INSERT INTO `sxh_sys_user_log_4` VALUES ('390', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479813934');
INSERT INTO `sxh_sys_user_log_4` VALUES ('391', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479818254');
INSERT INTO `sxh_sys_user_log_4` VALUES ('392', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479818387');
INSERT INTO `sxh_sys_user_log_4` VALUES ('393', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479818388');
INSERT INTO `sxh_sys_user_log_4` VALUES ('394', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479818512');
INSERT INTO `sxh_sys_user_log_4` VALUES ('395', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479820024');
INSERT INTO `sxh_sys_user_log_4` VALUES ('396', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479864782');
INSERT INTO `sxh_sys_user_log_4` VALUES ('397', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479865874');
INSERT INTO `sxh_sys_user_log_4` VALUES ('398', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479866549');
INSERT INTO `sxh_sys_user_log_4` VALUES ('399', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479866919');
INSERT INTO `sxh_sys_user_log_4` VALUES ('400', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479867082');
INSERT INTO `sxh_sys_user_log_4` VALUES ('401', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479867084');
INSERT INTO `sxh_sys_user_log_4` VALUES ('402', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479867196');
INSERT INTO `sxh_sys_user_log_4` VALUES ('403', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479867325');
INSERT INTO `sxh_sys_user_log_4` VALUES ('404', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479867513');
INSERT INTO `sxh_sys_user_log_4` VALUES ('405', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479867548');
INSERT INTO `sxh_sys_user_log_4` VALUES ('406', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479867664');
INSERT INTO `sxh_sys_user_log_4` VALUES ('407', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479868080');
INSERT INTO `sxh_sys_user_log_4` VALUES ('408', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479868487');
INSERT INTO `sxh_sys_user_log_4` VALUES ('409', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479868532');
INSERT INTO `sxh_sys_user_log_4` VALUES ('410', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479868539');
INSERT INTO `sxh_sys_user_log_4` VALUES ('411', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479868541');
INSERT INTO `sxh_sys_user_log_4` VALUES ('412', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479868605');
INSERT INTO `sxh_sys_user_log_4` VALUES ('413', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479868856');
INSERT INTO `sxh_sys_user_log_4` VALUES ('414', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479868982');
INSERT INTO `sxh_sys_user_log_4` VALUES ('415', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479869194');
INSERT INTO `sxh_sys_user_log_4` VALUES ('416', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479869437');
INSERT INTO `sxh_sys_user_log_4` VALUES ('417', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479870145');
INSERT INTO `sxh_sys_user_log_4` VALUES ('418', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479870484');
INSERT INTO `sxh_sys_user_log_4` VALUES ('419', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479874048');
INSERT INTO `sxh_sys_user_log_4` VALUES ('420', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479874057');
INSERT INTO `sxh_sys_user_log_4` VALUES ('421', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479874189');
INSERT INTO `sxh_sys_user_log_4` VALUES ('422', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479877959');
INSERT INTO `sxh_sys_user_log_4` VALUES ('423', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479880061');
INSERT INTO `sxh_sys_user_log_4` VALUES ('424', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479880071');
INSERT INTO `sxh_sys_user_log_4` VALUES ('425', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479881479');
INSERT INTO `sxh_sys_user_log_4` VALUES ('426', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479883708');
INSERT INTO `sxh_sys_user_log_4` VALUES ('427', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479884575');
INSERT INTO `sxh_sys_user_log_4` VALUES ('428', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479884693');
INSERT INTO `sxh_sys_user_log_4` VALUES ('429', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479884857');
INSERT INTO `sxh_sys_user_log_4` VALUES ('430', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479885152');
INSERT INTO `sxh_sys_user_log_4` VALUES ('431', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479885313');
INSERT INTO `sxh_sys_user_log_4` VALUES ('432', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479886955');
INSERT INTO `sxh_sys_user_log_4` VALUES ('433', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479891065');
INSERT INTO `sxh_sys_user_log_4` VALUES ('434', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479892470');
INSERT INTO `sxh_sys_user_log_4` VALUES ('435', '1', 'sxh_admin', '刘辉', '2', '【添加数据】添加用户【用户ID：22用户名：sxh_user_admin】;操作地址：user/user/add_user', '1479892670');
INSERT INTO `sxh_sys_user_log_4` VALUES ('436', '22', 'sxh_user_admin', '测试', '0', '【登录后台】【用户:测试】登录账号成功;操作地址：user/index/login', '1479893322');
INSERT INTO `sxh_sys_user_log_4` VALUES ('437', '1', 'sxh_admin', '刘辉', '2', '【添加数据】添加用户【用户ID：23用户名：afds_44】;操作地址：user/user/add_user', '1479893997');
INSERT INTO `sxh_sys_user_log_4` VALUES ('438', '1', 'sxh_admin', '刘辉', '2', '【添加数据】添加用户【用户ID：24用户名：23423_ww】;操作地址：user/user/add_user', '1479894032');
INSERT INTO `sxh_sys_user_log_4` VALUES ('439', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479894211');
INSERT INTO `sxh_sys_user_log_4` VALUES ('440', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479894499');
INSERT INTO `sxh_sys_user_log_4` VALUES ('441', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479894767');
INSERT INTO `sxh_sys_user_log_4` VALUES ('442', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479894957');
INSERT INTO `sxh_sys_user_log_4` VALUES ('443', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479895139');
INSERT INTO `sxh_sys_user_log_4` VALUES ('444', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479895185');
INSERT INTO `sxh_sys_user_log_4` VALUES ('445', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479896093');
INSERT INTO `sxh_sys_user_log_4` VALUES ('446', '1', 'sxh_admin', '刘辉', '0', '【登录后台】【用户:刘辉】登录账号成功;操作地址：user/index/login', '1479896439');
INSERT INTO `sxh_sys_user_log_4` VALUES ('447', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479896489');
INSERT INTO `sxh_sys_user_log_4` VALUES ('448', '1', 'sxh_admin', '刘辉', '1', '【修改更新】修改用户【用户ID:24昵称：王企鹅完全】;操作地址：user/user/set_user', '1479896820');
INSERT INTO `sxh_sys_user_log_4` VALUES ('449', '1', 'sxh_admin', '刘辉', '1', '【修改更新】修改用户姓名【用户ID:1】;操作地址：user/user/set_user_realname', '1479899898');
INSERT INTO `sxh_sys_user_log_4` VALUES ('450', '1', 'sxh_admin', '刘辉', '1', '【修改更新】修改用户密码【用户ID:1】;操作地址：user/user/set_user_password', '1479900450');
INSERT INTO `sxh_sys_user_log_4` VALUES ('451', '1', 'sxh_admin', '123456', '0', '【登录后台】【用户:123456】登录账号成功;操作地址：user/index/login', '1479900514');
INSERT INTO `sxh_sys_user_log_4` VALUES ('452', '1', 'sxh_admin', '刘辉', '1', '【修改更新】修改用户二级密码【用户ID:1】;操作地址：user/user/set_user_secondary_password', '1479900938');
INSERT INTO `sxh_sys_user_log_4` VALUES ('453', '1', 'sxh_admin', '123456', '0', '【登录后台】【用户:123456】登录账号成功;操作地址：user/index/login', '1479901016');
INSERT INTO `sxh_sys_user_log_4` VALUES ('454', '1', 'sxh_admin', '123456', '0', '【登录后台】【用户:123456】登录账号成功;操作地址：user/index/login', '1479901016');
INSERT INTO `sxh_sys_user_log_4` VALUES ('455', '1', 'sxh_admin', '刘辉', '1', '【修改更新】修改用户【用户ID:24昵称：31221】;操作地址：user/user/set_user', '1479901794');
INSERT INTO `sxh_sys_user_log_4` VALUES ('456', '1', 'sxh_admin', '刘辉', '1', '【修改更新】修改用户【用户ID:24昵称：3eqew】;操作地址：user/user/set_user', '1479901811');
INSERT INTO `sxh_sys_user_log_4` VALUES ('457', '1', 'sxh_admin', '刘辉', '1', '【修改更新】修改用户【用户ID:24昵称：11】;操作地址：user/user/set_user', '1479901839');
INSERT INTO `sxh_sys_user_log_4` VALUES ('458', '1', 'sxh_admin', '刘辉', '1', '【修改更新】修改用户状态为禁用【用户ID:24】;操作地址：user/user/disable_user', '1479902069');
INSERT INTO `sxh_sys_user_log_4` VALUES ('459', '1', 'sxh_admin', '刘辉', '1', '【修改更新】修改用户状态为禁用【用户ID:24】;操作地址：user/user/disable_user', '1479902109');
INSERT INTO `sxh_sys_user_log_4` VALUES ('460', '1', 'sxh_admin', '刘辉', '1', '【修改更新】修改用户状态为禁用【用户ID:24】;操作地址：user/user/disable_user', '1479902183');
INSERT INTO `sxh_sys_user_log_4` VALUES ('461', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479902479');
INSERT INTO `sxh_sys_user_log_4` VALUES ('462', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479902787');
INSERT INTO `sxh_sys_user_log_4` VALUES ('463', '1', 'sxh_admin', '123456', '0', '【登录后台】【用户:123456】登录账号成功;操作地址：user/index/login', '1479902971');
INSERT INTO `sxh_sys_user_log_4` VALUES ('464', '1', 'sxh_admin', '刘辉', '1', '【修改更新】修改用户状态为禁用【用户ID:24】;操作地址：user/user/disable_user', '1479903088');
INSERT INTO `sxh_sys_user_log_4` VALUES ('465', '1', 'sxh_admin', '刘辉', '1', '【修改更新】修改用户状态为禁用【用户ID:1】;操作地址：user/user/disable_user', '1479903126');
INSERT INTO `sxh_sys_user_log_4` VALUES ('466', '1', 'sxh_admin', '刘辉', '1', '【修改更新】修改用户状态为禁用【用户ID:1】;操作地址：user/user/disable_user', '1479903149');
INSERT INTO `sxh_sys_user_log_4` VALUES ('467', '1', 'sxh_admin', '刘辉', '1', '【修改更新】修改用户状态为禁用【用户ID:24】;操作地址：user/user/disable_user', '1479903319');
INSERT INTO `sxh_sys_user_log_4` VALUES ('468', '1', 'sxh_admin', '刘辉', '1', '【修改更新】修改用户状态为禁用【用户ID:24】;操作地址：user/user/disable_user', '1479903330');
INSERT INTO `sxh_sys_user_log_4` VALUES ('469', '1', 'sxh_admin', '刘辉', '1', '【修改更新】修改用户状态为禁用【用户ID:24】;操作地址：user/user/disable_user', '1479903680');
INSERT INTO `sxh_sys_user_log_4` VALUES ('470', '1', 'sxh_admin', '刘辉', '1', '【修改更新】修改用户状态为禁用【用户ID:24】;操作地址：user/user/disable_user', '1479903767');
INSERT INTO `sxh_sys_user_log_4` VALUES ('471', '1', 'sxh_admin', '刘辉', '1', '【修改更新】修改用户状态为禁用【用户ID:24】;操作地址：user/user/disable_user', '1479904059');
INSERT INTO `sxh_sys_user_log_4` VALUES ('472', '1', 'sxh_admin', '刘辉', '1', '【修改更新】修改用户状态为禁用【用户ID:24】;操作地址：user/user/disable_user', '1479904070');
INSERT INTO `sxh_sys_user_log_4` VALUES ('473', '1', 'sxh_admin', '刘辉', '1', '【修改更新】修改用户状态为禁用【用户ID:24】;操作地址：user/user/disable_user', '1479904777');
INSERT INTO `sxh_sys_user_log_4` VALUES ('474', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479907704');
INSERT INTO `sxh_sys_user_log_4` VALUES ('475', '1', 'sxh_admin', '123456', '0', '【登录后台】【用户:123456】登录账号成功;操作地址：user/index/login', '1479907972');
INSERT INTO `sxh_sys_user_log_4` VALUES ('476', '1', 'sxh_admin', '123456', '0', '【登录后台】【用户:123456】登录账号成功;操作地址：user/index/login', '1479907973');
INSERT INTO `sxh_sys_user_log_4` VALUES ('477', '1', 'sxh_admin', '123456', '0', '【登录后台】【用户:123456】登录账号成功;操作地址：user/index/login', '1479908176');
INSERT INTO `sxh_sys_user_log_4` VALUES ('478', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479908209');
INSERT INTO `sxh_sys_user_log_4` VALUES ('479', '1', 'sxh_admin', '123456', '0', '【登录后台】【用户:123456】登录账号成功;操作地址：user/index/login', '1479908407');
INSERT INTO `sxh_sys_user_log_4` VALUES ('480', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479908454');
INSERT INTO `sxh_sys_user_log_4` VALUES ('481', '2', 'sxh_test', '测试用户', '0', '【登录后台】【用户:测试用户】登录账号成功;操作地址：user/index/login', '1479908916');

-- ----------------------------
-- Table structure for sxh_sys_work
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_work`;
CREATE TABLE `sxh_sys_work` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sys_uid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '客服id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员id',
  `assign_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '指派人id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核状态 0-未审核 1-未通过 2-已通过',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派时间',
  `create_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派日期',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客服任务表';

-- ----------------------------
-- Records of sxh_sys_work
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_sys_work_1
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_work_1`;
CREATE TABLE `sxh_sys_work_1` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sys_uid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '客服id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员id',
  `assign_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '指派人id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核状态 0-未审核 1-未通过 2-已通过',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派时间',
  `create_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派日期',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客服任务表';

-- ----------------------------
-- Records of sxh_sys_work_1
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_sys_work_10
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_work_10`;
CREATE TABLE `sxh_sys_work_10` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sys_uid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '客服id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员id',
  `assign_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '指派人id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核状态 0-未审核 1-未通过 2-已通过',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派时间',
  `create_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派日期',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客服任务表';

-- ----------------------------
-- Records of sxh_sys_work_10
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_sys_work_2
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_work_2`;
CREATE TABLE `sxh_sys_work_2` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sys_uid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '客服id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员id',
  `assign_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '指派人id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核状态 0-未审核 1-未通过 2-已通过',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派时间',
  `create_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派日期',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客服任务表';

-- ----------------------------
-- Records of sxh_sys_work_2
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_sys_work_3
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_work_3`;
CREATE TABLE `sxh_sys_work_3` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sys_uid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '客服id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员id',
  `assign_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '指派人id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核状态 0-未审核 1-未通过 2-已通过',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派时间',
  `create_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派日期',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COMMENT='客服任务表';

-- ----------------------------
-- Records of sxh_sys_work_3
-- ----------------------------
INSERT INTO `sxh_sys_work_3` VALUES ('1', '2', '1', '1', '2', '1479908424', '20161123', '1479908680');
INSERT INTO `sxh_sys_work_3` VALUES ('2', '2', '6', '1', '0', '1479908424', '20161123', '0');
INSERT INTO `sxh_sys_work_3` VALUES ('3', '2', '8', '1', '0', '1479908424', '20161123', '0');
INSERT INTO `sxh_sys_work_3` VALUES ('4', '2', '9', '1', '0', '1479908424', '20161123', '0');
INSERT INTO `sxh_sys_work_3` VALUES ('5', '2', '12', '1', '0', '1479908424', '20161123', '0');
INSERT INTO `sxh_sys_work_3` VALUES ('6', '2', '14', '1', '0', '1479908424', '20161123', '0');
INSERT INTO `sxh_sys_work_3` VALUES ('7', '2', '15', '1', '0', '1479908424', '20161123', '0');
INSERT INTO `sxh_sys_work_3` VALUES ('8', '2', '17', '1', '0', '1479908424', '20161123', '0');
INSERT INTO `sxh_sys_work_3` VALUES ('9', '2', '18', '1', '0', '1479908424', '20161123', '0');
INSERT INTO `sxh_sys_work_3` VALUES ('10', '2', '20', '1', '0', '1479908424', '20161123', '0');
INSERT INTO `sxh_sys_work_3` VALUES ('11', '2', '31', '1', '0', '1479908424', '20161123', '0');
INSERT INTO `sxh_sys_work_3` VALUES ('12', '2', '33', '1', '0', '1479908424', '20161123', '0');
INSERT INTO `sxh_sys_work_3` VALUES ('13', '2', '35', '1', '0', '1479908424', '20161123', '0');
INSERT INTO `sxh_sys_work_3` VALUES ('14', '2', '36', '1', '0', '1479908424', '20161123', '0');
INSERT INTO `sxh_sys_work_3` VALUES ('15', '2', '38', '1', '0', '1479908424', '20161123', '0');
INSERT INTO `sxh_sys_work_3` VALUES ('16', '2', '40', '1', '0', '1479908424', '20161123', '0');
INSERT INTO `sxh_sys_work_3` VALUES ('17', '2', '43', '1', '2', '1479908424', '20161123', '1479909330');
INSERT INTO `sxh_sys_work_3` VALUES ('18', '2', '45', '1', '2', '1479908424', '20161123', '1479909366');
INSERT INTO `sxh_sys_work_3` VALUES ('19', '2', '47', '1', '2', '1479908424', '20161123', '1479909340');
INSERT INTO `sxh_sys_work_3` VALUES ('20', '2', '48', '1', '2', '1479908424', '20161123', '1479909479');
INSERT INTO `sxh_sys_work_3` VALUES ('21', '2', '51', '1', '2', '1479908424', '20161123', '1479909398');
INSERT INTO `sxh_sys_work_3` VALUES ('22', '2', '52', '1', '2', '1479908424', '20161123', '1479909513');
INSERT INTO `sxh_sys_work_3` VALUES ('23', '2', '53', '1', '2', '1479908424', '20161123', '1479909557');
INSERT INTO `sxh_sys_work_3` VALUES ('24', '2', '55', '1', '2', '1479908424', '20161123', '1479909669');
INSERT INTO `sxh_sys_work_3` VALUES ('25', '2', '61', '1', '2', '1479908424', '20161123', '1479909775');
INSERT INTO `sxh_sys_work_3` VALUES ('26', '2', '63', '1', '2', '1479908424', '20161123', '1479909775');
INSERT INTO `sxh_sys_work_3` VALUES ('27', '2', '64', '1', '2', '1479908424', '20161123', '1479909817');
INSERT INTO `sxh_sys_work_3` VALUES ('28', '2', '67', '1', '2', '1479908424', '20161123', '1479910002');
INSERT INTO `sxh_sys_work_3` VALUES ('29', '2', '68', '1', '2', '1479908424', '20161123', '1479910002');
INSERT INTO `sxh_sys_work_3` VALUES ('30', '2', '69', '1', '2', '1479908424', '20161123', '1479910063');
INSERT INTO `sxh_sys_work_3` VALUES ('31', '2', '70', '1', '2', '1479908424', '20161123', '1479910109');
INSERT INTO `sxh_sys_work_3` VALUES ('32', '2', '71', '1', '2', '1479908424', '20161123', '1479910188');
INSERT INTO `sxh_sys_work_3` VALUES ('33', '2', '73', '1', '0', '1479908424', '20161123', '0');
INSERT INTO `sxh_sys_work_3` VALUES ('34', '2', '74', '1', '0', '1479908424', '20161123', '0');
INSERT INTO `sxh_sys_work_3` VALUES ('35', '2', '78', '1', '0', '1479908424', '20161123', '0');
INSERT INTO `sxh_sys_work_3` VALUES ('36', '2', '80', '1', '0', '1479908424', '20161123', '0');

-- ----------------------------
-- Table structure for sxh_sys_work_4
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_work_4`;
CREATE TABLE `sxh_sys_work_4` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sys_uid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '客服id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员id',
  `assign_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '指派人id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核状态 0-未审核 1-未通过 2-已通过',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派时间',
  `create_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派日期',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客服任务表';

-- ----------------------------
-- Records of sxh_sys_work_4
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_sys_work_5
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_work_5`;
CREATE TABLE `sxh_sys_work_5` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sys_uid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '客服id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员id',
  `assign_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '指派人id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核状态 0-未审核 1-未通过 2-已通过',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派时间',
  `create_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派日期',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客服任务表';

-- ----------------------------
-- Records of sxh_sys_work_5
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_sys_work_6
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_work_6`;
CREATE TABLE `sxh_sys_work_6` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sys_uid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '客服id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员id',
  `assign_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '指派人id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核状态 0-未审核 1-未通过 2-已通过',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派时间',
  `create_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派日期',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客服任务表';

-- ----------------------------
-- Records of sxh_sys_work_6
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_sys_work_7
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_work_7`;
CREATE TABLE `sxh_sys_work_7` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sys_uid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '客服id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员id',
  `assign_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '指派人id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核状态 0-未审核 1-未通过 2-已通过',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派时间',
  `create_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派日期',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客服任务表';

-- ----------------------------
-- Records of sxh_sys_work_7
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_sys_work_8
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_work_8`;
CREATE TABLE `sxh_sys_work_8` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sys_uid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '客服id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员id',
  `assign_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '指派人id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核状态 0-未审核 1-未通过 2-已通过',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派时间',
  `create_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派日期',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客服任务表';

-- ----------------------------
-- Records of sxh_sys_work_8
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_sys_work_9
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_work_9`;
CREATE TABLE `sxh_sys_work_9` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sys_uid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '客服id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员id',
  `assign_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '指派人id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核状态 0-未审核 1-未通过 2-已通过',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派时间',
  `create_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指派日期',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客服任务表';

-- ----------------------------
-- Records of sxh_sys_work_9
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user`;
CREATE TABLE `sxh_user` (
  `id` int(10) unsigned NOT NULL COMMENT '用户ID',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '登录用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `secondary_password` char(32) NOT NULL DEFAULT '' COMMENT '二级密码(支付密码)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未激活 1-已激活 2-已冻结',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '资料审核 0-未审核 1-未通过 2-已通过',
  `flag` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '上级是否可以激活 0-可以激活 1-不可以激活',
  `is_transfer` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否可以任意转币 0-不可以 1-可以',
  `is_poor` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否是特困会员 0-不是 1-是',
  `is_withdraw` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否具有接单权限 0-无权限 1-有权限',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login_ip` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录ip',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `admin_update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户登录表';

-- ----------------------------
-- Records of sxh_user
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_1
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_1`;
CREATE TABLE `sxh_user_1` (
  `id` int(10) unsigned NOT NULL COMMENT '用户ID',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '登录用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `secondary_password` char(32) NOT NULL DEFAULT '' COMMENT '二级密码(支付密码)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未激活 1-已激活 2-已冻结',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '资料审核 0-未审核 1-未通过 2-已通过',
  `flag` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '上级是否可以激活 0-可以激活 1-不可以激活',
  `is_transfer` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否可以任意转币 0-不可以 1-可以',
  `is_poor` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否是特困会员 0-不是 1-是',
  `is_withdraw` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否具有接单权限 0-无权限 1-有权限',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login_ip` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录ip',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `admin_update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户登录表';

-- ----------------------------
-- Records of sxh_user_1
-- ----------------------------
INSERT INTO `sxh_user_1` VALUES ('1', 'test1', '', '', '1', '1', '1', '0', '1', '1', '1479197352', '2130706433', '1479197352', '0', '1479276251');
INSERT INTO `sxh_user_1` VALUES ('2', 'test2', '', '', '2', '0', '0', '0', '0', '1', '1479197352', '2130706433', '1479197352', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('3', 'test3', '', '', '1', '2', '0', '1', '1', '1', '1479197353', '2130706433', '1479197353', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('4', 'test4', '', '', '2', '2', '1', '0', '1', '1', '1479197353', '2130706433', '1479197353', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('5', 'test5', '', '', '2', '0', '1', '1', '0', '1', '1479197353', '2130706433', '1479197353', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('6', 'test6', '', '', '2', '0', '0', '1', '0', '0', '1479197353', '2130706433', '1479197353', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('7', 'test7', '', '', '1', '0', '1', '1', '0', '1', '1479197353', '2130706433', '1479197353', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('8', 'test8', '', '', '1', '0', '0', '1', '1', '0', '1479197353', '2130706433', '1479197353', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('9', 'test9', '', '', '2', '1', '1', '0', '0', '1', '1479197353', '2130706433', '1479197353', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('10', 'test10', '', '', '2', '2', '0', '0', '1', '0', '1479197354', '2130706433', '1479197354', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('11', 'test11', '', '', '2', '0', '0', '1', '1', '0', '1479197354', '2130706433', '1479197354', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('12', 'test12', '', '', '1', '1', '1', '1', '0', '0', '1479197354', '2130706433', '1479197354', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('13', 'test13', '', '', '0', '1', '1', '1', '0', '1', '1479197354', '2130706433', '1479197354', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('14', 'test14', '', '', '2', '1', '0', '1', '1', '0', '1479197354', '2130706433', '1479197354', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('15', 'test15', '', '', '2', '0', '1', '0', '1', '0', '1479197354', '2130706433', '1479197354', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('16', 'test16', '', '', '0', '0', '0', '1', '1', '1', '1479197355', '2130706433', '1479197355', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('17', 'test17', '', '', '2', '2', '0', '1', '0', '0', '1479197355', '2130706433', '1479197355', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('18', 'test18', '', '', '2', '2', '0', '0', '1', '1', '1479197355', '2130706433', '1479197355', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('19', 'test19', '', '', '1', '0', '1', '0', '0', '0', '1479197355', '2130706433', '1479197355', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('20', 'test20', '', '', '0', '1', '0', '1', '0', '0', '1479197355', '2130706433', '1479197355', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('21', 'test21', '', '', '2', '2', '1', '1', '0', '1', '1479197356', '2130706433', '1479197356', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('22', 'test22', '', '', '2', '1', '1', '1', '0', '1', '1479197356', '2130706433', '1479197356', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('23', 'test23', '', '', '2', '1', '1', '1', '1', '0', '1479197356', '2130706433', '1479197356', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('24', 'test24', '', '', '1', '2', '1', '0', '1', '0', '1479197356', '2130706433', '1479197356', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('25', 'test25', '', '', '1', '0', '1', '1', '1', '0', '1479197356', '2130706433', '1479197356', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('26', 'test26', '', '', '0', '2', '1', '0', '1', '0', '1479197356', '2130706433', '1479197356', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('27', 'test27', '', '', '2', '2', '1', '0', '0', '1', '1479197357', '2130706433', '1479197357', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('28', 'test28', '', '', '0', '1', '1', '1', '0', '1', '1479197357', '2130706433', '1479197357', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('29', 'test29', '', '', '0', '2', '1', '0', '1', '0', '1479197357', '2130706433', '1479197357', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('30', 'test30', '', '', '2', '1', '0', '0', '0', '1', '1479197357', '2130706433', '1479197357', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('31', 'test31', '', '', '1', '0', '1', '1', '1', '0', '1479197357', '2130706433', '1479197357', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('32', 'test32', '', '', '1', '1', '1', '1', '0', '1', '1479197358', '2130706433', '1479197358', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('33', 'test33', '', '', '1', '0', '0', '0', '0', '1', '1479197358', '2130706433', '1479197358', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('34', 'test34', '', '', '0', '2', '0', '0', '1', '1', '1479197358', '2130706433', '1479197358', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('35', 'test35', '', '', '2', '1', '0', '0', '0', '0', '1479197358', '2130706433', '1479197358', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('36', 'test36', '', '', '1', '0', '1', '1', '1', '1', '1479197358', '2130706433', '1479197358', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('37', 'test37', '', '', '2', '2', '1', '1', '1', '1', '1479197359', '2130706433', '1479197359', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('38', 'test38', '', '', '0', '0', '0', '0', '0', '0', '1479197359', '2130706433', '1479197359', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('39', 'test39', '', '', '1', '2', '0', '1', '1', '0', '1479197359', '2130706433', '1479197359', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('40', 'test40', '', '', '2', '0', '0', '1', '0', '0', '1479197359', '2130706433', '1479197359', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('41', 'test41', '', '', '2', '0', '0', '0', '0', '1', '1479197359', '2130706433', '1479197359', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('42', 'test42', '', '', '2', '1', '0', '1', '1', '1', '1479197359', '2130706433', '1479197359', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('43', 'test43', '', '', '2', '2', '1', '1', '0', '0', '1479197360', '2130706433', '1479197360', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('44', 'test44', '', '', '1', '2', '0', '1', '0', '0', '1479197360', '2130706433', '1479197360', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('45', 'test45', '', '', '0', '1', '0', '0', '1', '0', '1479197360', '2130706433', '1479197360', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('46', 'test46', '', '', '2', '2', '1', '1', '1', '0', '1479197360', '2130706433', '1479197360', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('47', 'test47', '', '', '1', '1', '0', '1', '1', '0', '1479197360', '2130706433', '1479197360', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('48', 'test48', '', '', '1', '2', '0', '1', '1', '0', '1479197360', '2130706433', '1479197360', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('49', 'test49', '', '', '1', '2', '0', '0', '1', '1', '1479197361', '2130706433', '1479197361', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('50', 'test50', '', '', '2', '2', '1', '0', '1', '1', '1479197361', '2130706433', '1479197361', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('51', 'test51', '', '', '1', '2', '1', '1', '0', '1', '1479197361', '2130706433', '1479197361', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('52', 'test52', '', '', '2', '1', '1', '0', '0', '1', '1479197361', '2130706433', '1479197361', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('53', 'test53', '', '', '1', '0', '1', '1', '0', '0', '1479197361', '2130706433', '1479197361', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('54', 'test54', '', '', '0', '1', '1', '1', '0', '0', '1479197362', '2130706433', '1479197362', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('55', 'test55', '', '', '0', '0', '0', '1', '0', '0', '1479197362', '2130706433', '1479197362', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('56', 'test56', '', '', '1', '0', '1', '0', '1', '0', '1479197362', '2130706433', '1479197362', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('57', 'test57', '', '', '0', '0', '0', '0', '1', '0', '1479197362', '2130706433', '1479197362', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('58', 'test58', '', '', '1', '0', '0', '1', '0', '1', '1479197362', '2130706433', '1479197362', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('59', 'test59', '', '', '1', '2', '0', '1', '0', '1', '1479197363', '2130706433', '1479197363', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('60', 'test60', '', '', '1', '2', '0', '1', '1', '0', '1479197363', '2130706433', '1479197363', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('61', 'test61', '', '', '1', '0', '1', '0', '0', '1', '1479197363', '2130706433', '1479197363', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('62', 'test62', '', '', '1', '2', '1', '1', '0', '0', '1479197363', '2130706433', '1479197363', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('63', 'test63', '', '', '1', '1', '0', '1', '1', '1', '1479197364', '2130706433', '1479197364', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('64', 'test64', '', '', '2', '0', '0', '0', '0', '0', '1479197364', '2130706433', '1479197364', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('65', 'test65', '', '', '2', '0', '1', '0', '0', '1', '1479197364', '2130706433', '1479197364', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('66', 'test66', '', '', '0', '1', '1', '0', '1', '0', '1479197364', '2130706433', '1479197364', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('67', 'test67', '', '', '2', '2', '0', '0', '0', '0', '1479197364', '2130706433', '1479197364', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('68', 'test68', '', '', '1', '1', '0', '0', '1', '1', '1479197364', '2130706433', '1479197364', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('69', 'test69', '', '', '1', '1', '0', '1', '0', '0', '1479197365', '2130706433', '1479197365', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('70', 'test70', '', '', '0', '2', '1', '0', '1', '0', '1479197365', '2130706433', '1479197365', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('71', 'test71', '', '', '0', '2', '1', '1', '1', '1', '1479197365', '2130706433', '1479197365', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('72', 'test72', '', '', '0', '1', '0', '0', '1', '0', '1479197365', '2130706433', '1479197365', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('73', 'test73', '', '', '0', '0', '0', '1', '0', '0', '1479197365', '2130706433', '1479197365', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('74', 'test74', '', '', '2', '2', '0', '0', '0', '1', '1479197365', '2130706433', '1479197365', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('75', 'test75', '', '', '0', '1', '0', '0', '0', '1', '1479197366', '2130706433', '1479197366', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('76', 'test76', '', '', '0', '2', '0', '1', '0', '0', '1479197366', '2130706433', '1479197366', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('77', 'test77', '', '', '0', '2', '0', '0', '0', '1', '1479197366', '2130706433', '1479197366', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('78', 'test78', '', '', '1', '2', '1', '0', '0', '1', '1479197366', '2130706433', '1479197366', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('79', 'test79', '', '', '2', '2', '0', '1', '0', '1', '1479197366', '2130706433', '1479197366', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('80', 'test80', '', '', '1', '2', '0', '1', '0', '0', '1479197366', '2130706433', '1479197366', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('81', 'test81', '', '', '2', '0', '1', '0', '1', '1', '1479197367', '2130706433', '1479197367', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('82', 'test82', '', '', '0', '1', '1', '0', '1', '1', '1479197367', '2130706433', '1479197367', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('83', 'test83', '', '', '2', '2', '1', '0', '0', '0', '1479197367', '2130706433', '1479197367', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('84', 'test84', '', '', '0', '2', '1', '1', '0', '0', '1479197367', '2130706433', '1479197367', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('85', 'test85', '', '', '0', '2', '0', '0', '0', '0', '1479197367', '2130706433', '1479197367', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('86', 'test86', '', '', '0', '0', '1', '1', '0', '0', '1479197367', '2130706433', '1479197367', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('87', 'test87', '', '', '1', '1', '0', '0', '0', '0', '1479197368', '2130706433', '1479197368', '1479206439', '0');
INSERT INTO `sxh_user_1` VALUES ('88', 'test88', '', '', '2', '1', '0', '0', '1', '0', '1479197368', '2130706433', '1479197368', '0', '1479709853');
INSERT INTO `sxh_user_1` VALUES ('89', 'test89', '', '', '0', '1', '0', '0', '1', '0', '1479197368', '2130706433', '1479197368', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('90', 'test90', '', '', '0', '0', '1', '1', '1', '0', '1479197368', '2130706433', '1479197368', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('91', 'test91', '', '', '0', '0', '0', '1', '0', '0', '1479197368', '2130706433', '1479197368', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('92', 'test92', '', '', '2', '1', '0', '1', '1', '0', '1479197369', '2130706433', '1479197369', '0', '1479262938');
INSERT INTO `sxh_user_1` VALUES ('93', 'test93', '', '', '0', '0', '1', '0', '0', '0', '1479197369', '2130706433', '1479197369', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('94', 'test94', '', '', '0', '1', '0', '0', '1', '0', '1479197369', '2130706433', '1479197369', '1479699295', '0');
INSERT INTO `sxh_user_1` VALUES ('95', 'test95', '', '', '2', '0', '1', '1', '1', '0', '1479197369', '2130706433', '1479197369', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('96', 'test96', '', '', '2', '1', '1', '1', '0', '0', '1479197369', '2130706433', '1479197369', '1479261278', '0');
INSERT INTO `sxh_user_1` VALUES ('97', 'test97', '', '', '2', '1', '0', '1', '1', '1', '1479197370', '2130706433', '1479197370', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('98', 'test98', '', '', '2', '2', '0', '1', '1', '1', '1479197370', '2130706433', '1479197370', '0', '0');
INSERT INTO `sxh_user_1` VALUES ('99', 'test99', '', '', '1', '1', '1', '0', '0', '1', '1479197370', '2130706433', '1479197370', '1479262277', '0');
INSERT INTO `sxh_user_1` VALUES ('100', 'test100', '', '', '2', '1', '0', '0', '0', '1', '1479197370', '2130706433', '1479197370', '1479262221', '1479700528');

-- ----------------------------
-- Table structure for sxh_user_2
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_2`;
CREATE TABLE `sxh_user_2` (
  `id` int(10) unsigned NOT NULL COMMENT '用户ID',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '登录用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `secondary_password` char(32) NOT NULL DEFAULT '' COMMENT '二级密码(支付密码)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未激活 1-已激活 2-已冻结',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '资料审核 0-未审核 1-未通过 2-已通过',
  `flag` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '上级是否可以激活 0-可以激活 1-不可以激活',
  `is_transfer` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否可以任意转币 0-不可以 1-可以',
  `is_poor` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否是特困会员 0-不是 1-是',
  `is_withdraw` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否具有接单权限 0-无权限 1-有权限',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login_ip` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录ip',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `admin_update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户登录表';

-- ----------------------------
-- Records of sxh_user_2
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_3
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_3`;
CREATE TABLE `sxh_user_3` (
  `id` int(10) unsigned NOT NULL COMMENT '用户ID',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '登录用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `secondary_password` char(32) NOT NULL DEFAULT '' COMMENT '二级密码(支付密码)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未激活 1-已激活 2-已冻结',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '资料审核 0-未审核 1-未通过 2-已通过',
  `flag` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '上级是否可以激活 0-可以激活 1-不可以激活',
  `is_transfer` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否可以任意转币 0-不可以 1-可以',
  `is_poor` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否是特困会员 0-不是 1-是',
  `is_withdraw` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否具有接单权限 0-无权限 1-有权限',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login_ip` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录ip',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `admin_update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户登录表';

-- ----------------------------
-- Records of sxh_user_3
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_4
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_4`;
CREATE TABLE `sxh_user_4` (
  `id` int(10) unsigned NOT NULL COMMENT '用户ID',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '登录用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `secondary_password` char(32) NOT NULL DEFAULT '' COMMENT '二级密码(支付密码)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未激活 1-已激活 2-已冻结',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '资料审核 0-未审核 1-未通过 2-已通过',
  `flag` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '上级是否可以激活 0-可以激活 1-不可以激活',
  `is_transfer` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否可以任意转币 0-不可以 1-可以',
  `is_poor` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否是特困会员 0-不是 1-是',
  `is_withdraw` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否具有接单权限 0-无权限 1-有权限',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login_ip` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录ip',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `admin_update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户登录表';

-- ----------------------------
-- Records of sxh_user_4
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_5
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_5`;
CREATE TABLE `sxh_user_5` (
  `id` int(10) unsigned NOT NULL COMMENT '用户ID',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '登录用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `secondary_password` char(32) NOT NULL DEFAULT '' COMMENT '二级密码(支付密码)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未激活 1-已激活 2-已冻结',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '资料审核 0-未审核 1-未通过 2-已通过',
  `flag` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '上级是否可以激活 0-可以激活 1-不可以激活',
  `is_transfer` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否可以任意转币 0-不可以 1-可以',
  `is_poor` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否是特困会员 0-不是 1-是',
  `is_withdraw` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否具有接单权限 0-无权限 1-有权限',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login_ip` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录ip',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `admin_update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员跟新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户登录表';

-- ----------------------------
-- Records of sxh_user_5
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_accepthelp_4
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_accepthelp_4`;
CREATE TABLE `sxh_user_accepthelp_4` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` tinyint(1) NOT NULL DEFAULT '0' COMMENT '资助类型 1-提供资助 2-接单资助(从先前的提供资助人转到当前用户)',
  `money` int(10) NOT NULL COMMENT '提交金额',
  `used` int(10) NOT NULL COMMENT '匹配金额',
  `cid` int(10) NOT NULL COMMENT '社区ID 1-特困社区 2-贫穷社区 3-小康社区 4-富人社区5-德善社区6-大德社区',
  `cname` char(20) NOT NULL COMMENT '社区名字',
  `user_id` int(10) NOT NULL COMMENT '用户ID',
  `username` char(20) NOT NULL COMMENT '接受人',
  `status` tinyint(3) NOT NULL COMMENT '状态 0-提交成功 1-匹配成功 2-已打款，3-已收款',
  `batch` int(10) NOT NULL COMMENT '批次',
  `ipaddress` bigint(10) NOT NULL COMMENT 'ip地址',
  `sign_time` int(10) NOT NULL COMMENT '完成时间',
  `create_time` int(10) NOT NULL COMMENT '提交时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  `match_num` tinyint(3) NOT NULL DEFAULT '0' COMMENT '匹配的笔数',
  `pay_num` tinyint(3) NOT NULL DEFAULT '0' COMMENT '支付的笔数（支付的时候+1）',
  `flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-正常 2-删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COMMENT='接受资助表';

-- ----------------------------
-- Records of sxh_user_accepthelp_4
-- ----------------------------
INSERT INTO `sxh_user_accepthelp_4` VALUES ('1', '1', '10000', '8000', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '-3', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('2', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('3', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('4', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('5', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('6', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('7', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('8', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('9', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('10', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('11', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('12', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('13', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('14', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('15', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('16', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('17', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('18', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('19', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('20', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('21', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('22', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('23', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('24', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('25', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('26', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('27', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('28', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('29', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('30', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('31', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('32', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('33', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('34', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('35', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('36', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('37', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('38', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('39', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('40', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('41', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('42', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('43', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('44', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('45', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('46', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('47', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('48', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('49', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('50', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('51', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('52', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('53', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('54', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('55', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_accepthelp_4` VALUES ('56', '0', '0', '-1000', '0', '', '0', '', '0', '0', '0', '0', '0', '0', '-1', '0', '0');

-- ----------------------------
-- Table structure for sxh_user_account
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_account`;
CREATE TABLE `sxh_user_account` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `activate_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '善种子[激活用]',
  `guadan_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '善心币[挂单用]',
  `invented_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '善金币[商城用]',
  `wallet_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '出局钱包',
  `manage_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理钱包,由下线完成资助的返利百分比得出，一部分给管理钱包,一部分给善金币',
  `order_taking` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '接单钱包',
  `poor_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '特困钱包',
  `needy_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '贫穷钱包',
  `comfortably_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '小康钱包',
  `kind_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '德善钱包',
  `wealth_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '富人钱包',
  `company_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '企业钱包',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员钱包表';

-- ----------------------------
-- Records of sxh_user_account
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_account_1
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_account_1`;
CREATE TABLE `sxh_user_account_1` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `activate_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '善种子[激活用]',
  `guadan_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '善心币[挂单用]',
  `invented_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '善金币[商城用]',
  `wallet_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '出局钱包',
  `manage_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理钱包,由下线完成资助的返利百分比得出，一部分给管理钱包,一部分给善金币',
  `order_taking` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '接单钱包',
  `poor_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '特困钱包',
  `needy_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '贫穷钱包',
  `comfortably_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '小康钱包',
  `kind_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '德善钱包',
  `wealth_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '富人钱包',
  `company_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '企业钱包',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员钱包表';

-- ----------------------------
-- Records of sxh_user_account_1
-- ----------------------------
INSERT INTO `sxh_user_account_1` VALUES ('1', '2', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '0', '0');
INSERT INTO `sxh_user_account_1` VALUES ('2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for sxh_user_account_2
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_account_2`;
CREATE TABLE `sxh_user_account_2` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `activate_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '善种子[激活用]',
  `guadan_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '善心币[挂单用]',
  `invented_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '善金币[商城用]',
  `wallet_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '出局钱包',
  `manage_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理钱包,由下线完成资助的返利百分比得出，一部分给管理钱包,一部分给善金币',
  `order_taking` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '接单钱包',
  `poor_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '特困钱包',
  `needy_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '贫穷钱包',
  `comfortably_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '小康钱包',
  `kind_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '德善钱包',
  `wealth_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '富人钱包',
  `company_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '企业钱包',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员钱包表';

-- ----------------------------
-- Records of sxh_user_account_2
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_account_3
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_account_3`;
CREATE TABLE `sxh_user_account_3` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `activate_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '善种子[激活用]',
  `guadan_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '善心币[挂单用]',
  `invented_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '善金币[商城用]',
  `wallet_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '出局钱包',
  `manage_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理钱包,由下线完成资助的返利百分比得出，一部分给管理钱包,一部分给善金币',
  `order_taking` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '接单钱包',
  `poor_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '特困钱包',
  `needy_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '贫穷钱包',
  `comfortably_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '小康钱包',
  `kind_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '德善钱包',
  `wealth_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '富人钱包',
  `company_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '企业钱包',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员钱包表';

-- ----------------------------
-- Records of sxh_user_account_3
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_account_4
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_account_4`;
CREATE TABLE `sxh_user_account_4` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `activate_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '善种子[激活用]',
  `guadan_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '善心币[挂单用]',
  `invented_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '善金币[商城用]',
  `wallet_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '出局钱包',
  `manage_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理钱包,由下线完成资助的返利百分比得出，一部分给管理钱包,一部分给善金币',
  `order_taking` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '接单钱包',
  `poor_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '特困钱包',
  `needy_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '贫穷钱包',
  `comfortably_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '小康钱包',
  `kind_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '德善钱包',
  `wealth_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '富人钱包',
  `company_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '企业钱包',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员钱包表';

-- ----------------------------
-- Records of sxh_user_account_4
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_account_5
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_account_5`;
CREATE TABLE `sxh_user_account_5` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `activate_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '善种子[激活用]',
  `guadan_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '善心币[挂单用]',
  `invented_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '善金币[商城用]',
  `wallet_currency` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '出局钱包',
  `manage_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理钱包,由下线完成资助的返利百分比得出，一部分给管理钱包,一部分给善金币',
  `order_taking` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '接单钱包',
  `poor_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '特困钱包',
  `needy_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '贫穷钱包',
  `comfortably_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '小康钱包',
  `kind_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '德善钱包',
  `wealth_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '富人钱包',
  `company_wallet` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '企业钱包',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员钱包表';

-- ----------------------------
-- Records of sxh_user_account_5
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_blacklist
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_blacklist`;
CREATE TABLE `sxh_user_blacklist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(40) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='黑名单';

-- ----------------------------
-- Records of sxh_user_blacklist
-- ----------------------------
INSERT INTO `sxh_user_blacklist` VALUES ('1', '50343', '刘香云', '审核资料已进入反审', '1476249875');
INSERT INTO `sxh_user_blacklist` VALUES ('2', '123', '宋文军', '不打款封号', '2016');
INSERT INTO `sxh_user_blacklist` VALUES ('4', '29938', '郭永霞', '不打款封号', '2016');

-- ----------------------------
-- Table structure for sxh_user_community
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_community`;
CREATE TABLE `sxh_user_community` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水ID',
  `name` char(20) NOT NULL COMMENT '社区名称',
  `low_sum` int(11) unsigned NOT NULL COMMENT '最低布施金额',
  `top_sum` int(11) unsigned NOT NULL COMMENT '最高布施金额',
  `multiple` int(11) unsigned NOT NULL COMMENT '金额倍数',
  `low_rebate` tinyint(3) unsigned NOT NULL COMMENT '最低返利 百分比值',
  `top_rebate` tinyint(3) unsigned NOT NULL COMMENT '最高返利 百分比值',
  `rebate` tinyint(3) NOT NULL,
  `low_time` tinyint(3) unsigned NOT NULL COMMENT '最低匹配天数',
  `top_time` tinyint(3) unsigned NOT NULL COMMENT '最高匹配天数',
  `go_provide_day` tinyint(3) unsigned NOT NULL COMMENT '二次排单时间，单位天数',
  `sort` tinyint(3) NOT NULL COMMENT '显示顺序',
  `message` varchar(200) NOT NULL COMMENT '社区介绍',
  `image` varchar(50) NOT NULL COMMENT '图片路径',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `update_time` int(10) NOT NULL COMMENT '修改时间',
  `level1_rebate` int(5) NOT NULL DEFAULT '0' COMMENT '一级返点',
  `level2_rebate` int(5) NOT NULL DEFAULT '0' COMMENT '二级返点',
  `level3_rebate` int(5) NOT NULL DEFAULT '0' COMMENT '三级返点',
  `level4_rebate` int(5) NOT NULL DEFAULT '0' COMMENT '四级返点',
  `level5_rebate` int(5) NOT NULL DEFAULT '0' COMMENT '五级返点',
  `need_currency` tinyint(3) NOT NULL DEFAULT '0' COMMENT '提供资助（挂单\r\n\r\n）需要扣除的善心币数量',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  `is_company` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否是企业（0否1\r\n\r\n是）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='社区信息表';

-- ----------------------------
-- Records of sxh_user_community
-- ----------------------------
INSERT INTO `sxh_user_community` VALUES ('1', '特困社区', '1000', '3000', '100', '30', '60', '60', '0', '0', '0', '0', '&nbsp;&nbsp;在贫穷社区的基础上，筛选出一批特困会员（详情请咨询善心汇扶贫济困微信客服：shanxinhui9090）,布施金额1000-3000元，每轮收益率50%.排队打款和收款时间会酌情提前。', '/Public/User/images/community/pk.jpg', '2147483647', '2147483647', '6', '0', '4', '0', '2', '1', '1', '0');
INSERT INTO `sxh_user_community` VALUES ('2', '贫穷社区', '1000', '2000', '100', '30', '50', '40', '1', '5', '1', '1', '&nbsp;&nbsp;布施金额：1000—2000元 排队布施时间1—5天，排队期间不打款，打款成功后，进入受助的队列，打款确认后1-3天回款。所受助善金为你所布施与他人资金的40%（根据你的资料提交的困难程度，实在紧急可以直接沟通客服通过审核后可获优先匹配资格），打款确认后受助出场匹配时间一般为72小时之内。', '/Public/User/images/community/pk.jpg', '2147483647', '2147483647', '6', '0', '4', '0', '2', '1', '1', '0');
INSERT INTO `sxh_user_community` VALUES ('3', '小康社区', '5000', '20000', '500', '20', '30', '20', '3', '10', '3', '2', '&nbsp;&nbsp;布施金额：5000—2万元 排队布施时间3—10天，排队期间不打款，匹配打款后，进入受助队列，打款确认后5天后回款。所受助善金为你所布施与他人资金的20%（根据你的资料提交的困难程度，紧急可以直接沟通客服做登记，通过审核后获优先匹配资格）。', '/Public/User/images/community/xk.jpg', '2147483647', '2147483647', '6', '0', '4', '0', '2', '2', '1', '0');
INSERT INTO `sxh_user_community` VALUES ('4', '富人社区', '50000', '200000', '1000', '10', '20', '10', '3', '15', '5', '3', '&nbsp;&nbsp;布施金额：5万—20万元 排队布施时间3—15天，排队期间不打款，匹配打款后，进入受助队列。所受助善金为你所布施与他人资金的10%（受助20天内回款） 。', '/Public/User/images/community/fr.jpg', '2147483647', '2147483647', '6', '0', '4', '0', '2', '3', '1', '0');
INSERT INTO `sxh_user_community` VALUES ('5', '德善社区', '300000', '10000000', '10000', '3', '5', '1', '30', '90', '10', '4', '&nbsp;&nbsp;布施金额：30万—1000万元 根据实际情况具体由客服直接服务，排队期间不打款，打款成功后，进入受助的队列，回款时间一个月以上。', '/Public/User/images/community/ds.jpg', '2147483647', '2147483647', '6', '0', '4', '0', '2', '3', '1', '0');
INSERT INTO `sxh_user_community` VALUES ('6', '大德社区', '30000000', '100000000', '10000000', '0', '0', '0', '0', '0', '255', '5', '', '/Public/User/images/community/de.jpg', '2147483647', '2147483647', '6', '0', '4', '0', '2', '3', '1', '0');
INSERT INTO `sxh_user_community` VALUES ('7', '企业社区', '1000', '2000', '100', '30', '50', '40', '1', '5', '1', '6', '&nbsp;&nbsp;布施金额：1000—2000元 排队布施时间1—5天，排队期间不打款，打款成功后，进入受助的队列，打款确认后1-3天回款。所受助善金为你所布施与他人资金的40%（根据你的资料提交的困难程度，实在紧急可以直接沟通客服通过审核后可获优先匹配资格），打款确认后受助出场匹配时间一般为72小时之内。', '/Public/User/images/community/qy.jpg', '2147483647', '2147483647', '0', '0', '0', '0', '0', '3', '1', '1');

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
-- Table structure for sxh_user_info
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_info`;
CREATE TABLE `sxh_user_info` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '登录用户名',
  `name` char(20) NOT NULL DEFAULT '' COMMENT '身份证上的姓名',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未激活 1-已激活 2-已冻结',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '资料审核 0-未审核 1-未通过 2-已通过',
  `email` char(30) NOT NULL DEFAULT '' COMMENT '电子邮件',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `address` char(100) NOT NULL DEFAULT '' COMMENT '收货地址',
  `city` char(20) NOT NULL DEFAULT '' COMMENT '居住地所在的城市',
  `alipay_account` char(30) NOT NULL DEFAULT '' COMMENT '支付宝账号',
  `weixin_account` char(30) NOT NULL DEFAULT '' COMMENT '微信账号',
  `bank_name` char(30) NOT NULL DEFAULT '' COMMENT '开户银行名称',
  `bank_account` char(30) NOT NULL DEFAULT '' COMMENT '银行帐号',
  `card_id` char(20) NOT NULL DEFAULT '' COMMENT '身份证号码',
  `referee` char(20) NOT NULL DEFAULT '' COMMENT '推荐人账号',
  `referee_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '推荐人id',
  `referee_name` char(20) NOT NULL DEFAULT '' COMMENT '推荐人姓名',
  `group` char(20) NOT NULL DEFAULT '' COMMENT '隶属组账号',
  `group_name` char(20) NOT NULL DEFAULT '' COMMENT '隶属组名称',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '隶属组id',
  `verify_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '审核人id',
  `verify_uname` char(20) NOT NULL DEFAULT '' COMMENT '审核人姓名',
  `province` char(20) NOT NULL DEFAULT '' COMMENT '所在省份',
  `classification` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '用户类别 0-普通用户 1-功德主 2-服务中心',
  `town` char(20) NOT NULL DEFAULT '' COMMENT '所在城市',
  `image_a` char(40) NOT NULL DEFAULT '' COMMENT '身份证手持正面',
  `image_b` char(40) NOT NULL DEFAULT '' COMMENT '身份证手持背面',
  `image_c` char(40) NOT NULL DEFAULT '' COMMENT '身份证手持全身',
  `remark` char(64) NOT NULL DEFAULT '' COMMENT '备注',
  `tel_number` char(15) NOT NULL DEFAULT '' COMMENT '善心号',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `last_update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `admin_update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员更新资料时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员信息表';

-- ----------------------------
-- Records of sxh_user_info
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_info_1
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_info_1`;
CREATE TABLE `sxh_user_info_1` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '登录用户名',
  `name` char(20) NOT NULL DEFAULT '' COMMENT '身份证上的姓名',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未激活 1-已激活 2-已冻结',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '资料审核 0-未审核 1-未通过 2-已通过',
  `email` char(30) NOT NULL DEFAULT '' COMMENT '电子邮件',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `address` char(100) NOT NULL DEFAULT '' COMMENT '收货地址',
  `city` char(20) NOT NULL DEFAULT '' COMMENT '居住地所在的城市',
  `alipay_account` char(30) NOT NULL DEFAULT '' COMMENT '支付宝账号',
  `weixin_account` char(30) NOT NULL DEFAULT '' COMMENT '微信账号',
  `bank_name` char(30) NOT NULL DEFAULT '' COMMENT '开户银行名称',
  `bank_account` char(30) NOT NULL DEFAULT '' COMMENT '银行帐号',
  `card_id` char(20) NOT NULL DEFAULT '' COMMENT '身份证号码',
  `referee` char(20) NOT NULL DEFAULT '' COMMENT '推荐人账号',
  `referee_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '推荐人id',
  `referee_name` char(20) NOT NULL DEFAULT '' COMMENT '推荐人姓名',
  `group` char(20) NOT NULL DEFAULT '' COMMENT '隶属组账号',
  `group_name` char(20) NOT NULL DEFAULT '' COMMENT '隶属组名称',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '隶属组id',
  `verify_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '审核人id',
  `verify_uname` char(20) NOT NULL DEFAULT '' COMMENT '审核人姓名',
  `province` char(20) NOT NULL DEFAULT '' COMMENT '所在省份',
  `classification` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '用户类别 0-普通用户 1-功德主 2-服务中心',
  `town` char(20) NOT NULL DEFAULT '' COMMENT '所在城市',
  `image_a` char(40) NOT NULL DEFAULT '' COMMENT '身份证手持正面',
  `image_b` char(40) NOT NULL DEFAULT '' COMMENT '身份证手持背面',
  `image_c` char(40) NOT NULL DEFAULT '' COMMENT '身份证手持全身',
  `remark` char(64) NOT NULL DEFAULT '' COMMENT '备注',
  `tel_number` char(15) NOT NULL DEFAULT '' COMMENT '善心号',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `last_update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `admin_update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员跟新资料时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员信息表';

-- ----------------------------
-- Records of sxh_user_info_1
-- ----------------------------
INSERT INTO `sxh_user_info_1` VALUES ('1', 'test1', '213123', '1', '1', '', '', '地址1', '广州', '', '', '', '', '', 'test2', '2', '用户1', 'group1', '功德主1', '2', '1', 'sxh_admin', '广东', '0', '', '', '', '', '', '', '1479197352', '1479197352', '1479197352', '1479198710');
INSERT INTO `sxh_user_info_1` VALUES ('2', 'test2', '用户2', '2', '0', 'test2@qq.com', '15013529284', '地址2', '深圳', 'alipay2@qq.com', 'weixin2@qq.com', '中国银行', '220559556990053976', '420222199012275565', 'test1', '1', '用户2', 'group2', '功德主2', '6', '0', '', '广东', '0', '', '', '', '', '', '', '1479197352', '1479197352', '1479197352', '1479197643');
INSERT INTO `sxh_user_info_1` VALUES ('3', 'test3', '用户3', '1', '2', 'test3@qq.com', '15013529899', '地址3', '广州', 'alipay3@qq.com', 'weixin3@qq.com', '邮政银行', '220559556990053777', '420222199012277127', '3', '0', '用户3', 'group3', '功德主3', '10', '0', '', '广东', '0', '', '', '', '', '', '', '1479197353', '1479197353', '1479197353', '0');
INSERT INTO `sxh_user_info_1` VALUES ('4', 'test4', '用户4', '2', '2', 'test4@qq.com', '15013529405', '地址4', '深圳', 'alipay4@qq.com', 'weixin4@qq.com', '中国银行', '220559556990054887', '420222199012278617', '4', '0', '用户4', 'group4', '功德主4', '9', '0', '', '广东', '0', '', '', '', '', '', '', '1479197353', '1479197353', '1479197353', '0');
INSERT INTO `sxh_user_info_1` VALUES ('5', 'test5', '用户5', '2', '0', 'test5@qq.com', '15013529385', '地址5', '广州', 'alipay5@qq.com', 'weixin5@qq.com', '邮政银行', '220559556990059201', '420222199012279142', '5', '0', '用户5', 'group5', '功德主5', '3', '0', '', '广东', '0', '', '', '', '', '', '', '1479197353', '1479197353', '1479197353', '0');
INSERT INTO `sxh_user_info_1` VALUES ('6', 'test6', '用户6', '2', '0', 'test6@qq.com', '15013529659', '地址6', '深圳', 'alipay6@qq.com', 'weixin6@qq.com', '中国银行', '220559556990055074', '420222199012274162', '6', '0', '用户6', 'group6', '功德主6', '7', '0', '', '广东', '0', '', '', '', '', '', '', '1479197353', '1479197353', '1479197353', '0');
INSERT INTO `sxh_user_info_1` VALUES ('7', 'test7', '用户7', '1', '0', 'test7@qq.com', '15013529812', '地址7', '广州', 'alipay7@qq.com', 'weixin7@qq.com', '邮政银行', '220559556990056827', '420222199012275046', '7', '0', '用户7', 'group7', '功德主7', '10', '0', '', '广东', '0', '', '', '', '', '', '', '1479197353', '1479197353', '1479197353', '0');
INSERT INTO `sxh_user_info_1` VALUES ('8', 'test8', '用户8', '1', '0', 'test8@qq.com', '15013529127', '地址8', '深圳', 'alipay8@qq.com', 'weixin8@qq.com', '中国银行', '220559556990056875', '420222199012273729', '8', '0', '用户8', 'group8', '功德主8', '3', '0', '', '广东', '0', '', '', '', '', '', '', '1479197353', '1479197353', '1479197353', '0');
INSERT INTO `sxh_user_info_1` VALUES ('9', 'test9', '用户9', '2', '1', 'test9@qq.com', '15013529976', '地址9', '广州', 'alipay9@qq.com', 'weixin9@qq.com', '邮政银行', '220559556990055478', '420222199012277231', '9', '0', '用户9', 'group9', '功德主9', '9', '0', '', '广东', '0', '', '', '', '', '', '', '1479197353', '1479197353', '1479197353', '0');
INSERT INTO `sxh_user_info_1` VALUES ('10', 'test10', '用户10', '2', '2', 'test10@qq.com', '15013529216', '地址10', '深圳', 'alipay10@qq.com', 'weixin10@qq.com', '中国银行', '220559556990056676', '420222199012271792', '10', '0', '用户10', 'group10', '功德主10', '10', '0', '', '广东', '0', '', '', '', '', '', '', '1479197354', '1479197354', '1479197354', '0');
INSERT INTO `sxh_user_info_1` VALUES ('11', 'test11', '用户11', '2', '0', 'test11@qq.com', '15013529617', '地址11', '广州', 'alipay11@qq.com', 'weixin11@qq.com', '邮政银行', '220559556990057920', '420222199012274049', '11', '0', '用户11', 'group11', '功德主11', '7', '0', '', '广东', '0', '', '', '', '', '', '', '1479197354', '1479197354', '1479197354', '0');
INSERT INTO `sxh_user_info_1` VALUES ('12', 'test12', '用户12', '1', '1', 'test12@qq.com', '15013529762', '地址12', '深圳', 'alipay12@qq.com', 'weixin12@qq.com', '中国银行', '220559556990056781', '420222199012274693', '12', '0', '用户12', 'group12', '功德主12', '7', '0', '', '广东', '0', '', '', '', '', '', '', '1479197354', '1479197354', '1479197354', '0');
INSERT INTO `sxh_user_info_1` VALUES ('13', 'test13', '用户13', '0', '1', 'test13@qq.com', '15013529901', '地址13', '广州', 'alipay13@qq.com', 'weixin13@qq.com', '邮政银行', '220559556990059344', '420222199012277758', '13', '0', '用户13', 'group13', '功德主13', '9', '0', '', '广东', '0', '', '', '', '', '', '', '1479197354', '1479197354', '1479197354', '0');
INSERT INTO `sxh_user_info_1` VALUES ('14', 'test14', '用户14', '2', '1', 'test14@qq.com', '15013529750', '地址14', '深圳', 'alipay14@qq.com', 'weixin14@qq.com', '中国银行', '220559556990055303', '420222199012279532', '14', '0', '用户14', 'group14', '功德主14', '9', '0', '', '广东', '0', '', '', '', '', '', '', '1479197354', '1479197354', '1479197354', '0');
INSERT INTO `sxh_user_info_1` VALUES ('15', 'test15', '用户15', '2', '0', 'test15@qq.com', '15013529930', '地址15', '广州', 'alipay15@qq.com', 'weixin15@qq.com', '邮政银行', '220559556990052013', '420222199012279119', '15', '0', '用户15', 'group15', '功德主15', '7', '0', '', '广东', '0', '', '', '', '', '', '', '1479197354', '1479197354', '1479197354', '0');
INSERT INTO `sxh_user_info_1` VALUES ('16', 'test16', '用户16', '0', '0', 'test16@qq.com', '15013529728', '地址16', '深圳', 'alipay16@qq.com', 'weixin16@qq.com', '中国银行', '220559556990059937', '420222199012278328', '16', '0', '用户16', 'group16', '功德主16', '4', '0', '', '广东', '0', '', '', '', '', '', '', '1479197355', '1479197355', '1479197355', '0');
INSERT INTO `sxh_user_info_1` VALUES ('17', 'test17', '用户17', '2', '2', 'test17@qq.com', '15013529200', '地址17', '广州', 'alipay17@qq.com', 'weixin17@qq.com', '邮政银行', '220559556990055876', '420222199012275705', '17', '0', '用户17', 'group17', '功德主17', '2', '0', '', '广东', '0', '', '', '', '', '', '', '1479197355', '1479197355', '1479197355', '0');
INSERT INTO `sxh_user_info_1` VALUES ('18', 'test18', '用户18', '2', '2', 'test18@qq.com', '15013529207', '地址18', '深圳', 'alipay18@qq.com', 'weixin18@qq.com', '中国银行', '220559556990051817', '420222199012276248', '18', '0', '用户18', 'group18', '功德主18', '8', '0', '', '广东', '0', '', '', '', '', '', '', '1479197355', '1479197355', '1479197355', '0');
INSERT INTO `sxh_user_info_1` VALUES ('19', 'test19', '用户19', '1', '0', 'test19@qq.com', '15013529875', '地址19', '广州', 'alipay19@qq.com', 'weixin19@qq.com', '邮政银行', '220559556990058903', '420222199012277035', '19', '0', '用户19', 'group19', '功德主19', '10', '0', '', '广东', '0', '', '', '', '', '', '', '1479197355', '1479197355', '1479197355', '0');
INSERT INTO `sxh_user_info_1` VALUES ('20', 'test20', '用户20', '0', '1', 'test20@qq.com', '15013529399', '地址20', '深圳', 'alipay20@qq.com', 'weixin20@qq.com', '中国银行', '220559556990055526', '420222199012272821', '20', '0', '用户20', 'group20', '功德主20', '1', '0', '', '广东', '0', '', '', '', '', '', '', '1479197355', '1479197355', '1479197355', '0');
INSERT INTO `sxh_user_info_1` VALUES ('21', 'test21', '用户21', '2', '2', 'test21@qq.com', '15013529597', '地址21', '广州', 'alipay21@qq.com', 'weixin21@qq.com', '邮政银行', '220559556990057991', '420222199012277799', '21', '0', '用户21', 'group21', '功德主21', '2', '0', '', '广东', '0', '', '', '', '', '', '', '1479197356', '1479197356', '1479197356', '0');
INSERT INTO `sxh_user_info_1` VALUES ('22', 'test22', '用户22', '2', '1', 'test22@qq.com', '15013529986', '地址22', '深圳', 'alipay22@qq.com', 'weixin22@qq.com', '中国银行', '220559556990053308', '420222199012271845', '22', '0', '用户22', 'group22', '功德主22', '8', '0', '', '广东', '0', '', '', '', '', '', '', '1479197356', '1479197356', '1479197356', '0');
INSERT INTO `sxh_user_info_1` VALUES ('23', 'test23', '用户23', '2', '1', 'test23@qq.com', '15013529749', '地址23', '广州', 'alipay23@qq.com', 'weixin23@qq.com', '邮政银行', '220559556990051161', '420222199012275136', '23', '0', '用户23', 'group23', '功德主23', '6', '0', '', '广东', '0', '', '', '', '', '', '', '1479197356', '1479197356', '1479197356', '0');
INSERT INTO `sxh_user_info_1` VALUES ('24', 'test24', '用户24', '1', '2', 'test24@qq.com', '15013529531', '地址24', '深圳', 'alipay24@qq.com', 'weixin24@qq.com', '中国银行', '220559556990051226', '420222199012273425', '24', '0', '用户24', 'group24', '功德主24', '6', '0', '', '广东', '0', '', '', '', '', '', '', '1479197356', '1479197356', '1479197356', '0');
INSERT INTO `sxh_user_info_1` VALUES ('25', 'test25', '用户25', '1', '0', 'test25@qq.com', '15013529805', '地址25', '广州', 'alipay25@qq.com', 'weixin25@qq.com', '邮政银行', '220559556990053946', '420222199012277870', '25', '0', '用户25', 'group25', '功德主25', '3', '0', '', '广东', '0', '', '', '', '', '', '', '1479197356', '1479197356', '1479197356', '0');
INSERT INTO `sxh_user_info_1` VALUES ('26', 'test26', '用户26', '0', '2', 'test26@qq.com', '15013529395', '地址26', '深圳', 'alipay26@qq.com', 'weixin26@qq.com', '中国银行', '220559556990055775', '420222199012271608', '26', '0', '用户26', 'group26', '功德主26', '8', '0', '', '广东', '0', '', '', '', '', '', '', '1479197356', '1479197356', '1479197356', '0');
INSERT INTO `sxh_user_info_1` VALUES ('27', 'test27', '用户27', '2', '2', 'test27@qq.com', '15013529732', '地址27', '广州', 'alipay27@qq.com', 'weixin27@qq.com', '邮政银行', '220559556990057522', '420222199012271958', '27', '0', '用户27', 'group27', '功德主27', '1', '0', '', '广东', '0', '', '', '', '', '', '', '1479197357', '1479197357', '1479197357', '0');
INSERT INTO `sxh_user_info_1` VALUES ('28', 'test28', '用户28', '0', '1', 'test28@qq.com', '15013529684', '地址28', '深圳', 'alipay28@qq.com', 'weixin28@qq.com', '中国银行', '220559556990055820', '420222199012274242', '28', '0', '用户28', 'group28', '功德主28', '8', '0', '', '广东', '0', '', '', '', '', '', '', '1479197357', '1479197357', '1479197357', '0');
INSERT INTO `sxh_user_info_1` VALUES ('29', 'test29', '用户29', '0', '2', 'test29@qq.com', '15013529379', '地址29', '广州', 'alipay29@qq.com', 'weixin29@qq.com', '邮政银行', '220559556990051678', '420222199012271692', '29', '0', '用户29', 'group29', '功德主29', '3', '0', '', '广东', '0', '', '', '', '', '', '', '1479197357', '1479197357', '1479197357', '0');
INSERT INTO `sxh_user_info_1` VALUES ('30', 'test30', '用户30', '2', '1', 'test30@qq.com', '15013529600', '地址30', '深圳', 'alipay30@qq.com', 'weixin30@qq.com', '中国银行', '220559556990056161', '420222199012274884', '30', '0', '用户30', 'group30', '功德主30', '10', '0', '', '广东', '0', '', '', '', '', '', '', '1479197357', '1479197357', '1479197357', '0');
INSERT INTO `sxh_user_info_1` VALUES ('31', 'test31', '用户31', '1', '0', 'test31@qq.com', '15013529510', '地址31', '广州', 'alipay31@qq.com', 'weixin31@qq.com', '邮政银行', '220559556990051873', '420222199012272171', '31', '0', '用户31', 'group31', '功德主31', '6', '0', '', '广东', '0', '', '', '', '', '', '', '1479197357', '1479197357', '1479197357', '0');
INSERT INTO `sxh_user_info_1` VALUES ('32', 'test32', '用户32', '1', '1', 'test32@qq.com', '15013529773', '地址32', '深圳', 'alipay32@qq.com', 'weixin32@qq.com', '中国银行', '220559556990057724', '420222199012277060', '32', '0', '用户32', 'group32', '功德主32', '2', '0', '', '广东', '0', '', '', '', '', '', '', '1479197358', '1479197358', '1479197358', '0');
INSERT INTO `sxh_user_info_1` VALUES ('33', 'test33', '用户33', '1', '0', 'test33@qq.com', '15013529760', '地址33', '广州', 'alipay33@qq.com', 'weixin33@qq.com', '邮政银行', '220559556990054223', '420222199012271906', '33', '0', '用户33', 'group33', '功德主33', '4', '0', '', '广东', '0', '', '', '', '', '', '', '1479197358', '1479197358', '1479197358', '0');
INSERT INTO `sxh_user_info_1` VALUES ('34', 'test34', '用户34', '0', '2', 'test34@qq.com', '15013529375', '地址34', '深圳', 'alipay34@qq.com', 'weixin34@qq.com', '中国银行', '220559556990052951', '420222199012271199', '34', '0', '用户34', 'group34', '功德主34', '6', '0', '', '广东', '0', '', '', '', '', '', '', '1479197358', '1479197358', '1479197358', '0');
INSERT INTO `sxh_user_info_1` VALUES ('35', 'test35', '用户35', '2', '1', 'test35@qq.com', '15013529615', '地址35', '广州', 'alipay35@qq.com', 'weixin35@qq.com', '邮政银行', '220559556990057663', '420222199012278438', '35', '0', '用户35', 'group35', '功德主35', '8', '0', '', '广东', '0', '', '', '', '', '', '', '1479197358', '1479197358', '1479197358', '0');
INSERT INTO `sxh_user_info_1` VALUES ('36', 'test36', '用户36', '1', '0', 'test36@qq.com', '15013529212', '地址36', '深圳', 'alipay36@qq.com', 'weixin36@qq.com', '中国银行', '220559556990055032', '420222199012274766', '36', '0', '用户36', 'group36', '功德主36', '5', '0', '', '广东', '0', '', '', '', '', '', '', '1479197358', '1479197358', '1479197358', '0');
INSERT INTO `sxh_user_info_1` VALUES ('37', 'test37', '用户37', '2', '2', 'test37@qq.com', '15013529656', '地址37', '广州', 'alipay37@qq.com', 'weixin37@qq.com', '邮政银行', '220559556990052428', '420222199012272538', '37', '0', '用户37', 'group37', '功德主37', '10', '0', '', '广东', '0', '', '', '', '', '', '', '1479197359', '1479197359', '1479197359', '0');
INSERT INTO `sxh_user_info_1` VALUES ('38', 'test38', '用户38', '0', '0', 'test38@qq.com', '15013529633', '地址38', '深圳', 'alipay38@qq.com', 'weixin38@qq.com', '中国银行', '220559556990054416', '420222199012278331', '38', '0', '用户38', 'group38', '功德主38', '3', '0', '', '广东', '0', '', '', '', '', '', '', '1479197359', '1479197359', '1479197359', '0');
INSERT INTO `sxh_user_info_1` VALUES ('39', 'test39', '用户39', '1', '2', 'test39@qq.com', '15013529984', '地址39', '广州', 'alipay39@qq.com', 'weixin39@qq.com', '邮政银行', '220559556990055393', '420222199012279926', '39', '0', '用户39', 'group39', '功德主39', '4', '0', '', '广东', '0', '', '', '', '', '', '', '1479197359', '1479197359', '1479197359', '0');
INSERT INTO `sxh_user_info_1` VALUES ('40', 'test40', '用户40', '2', '0', 'test40@qq.com', '15013529387', '地址40', '深圳', 'alipay40@qq.com', 'weixin40@qq.com', '中国银行', '220559556990055846', '420222199012272560', '40', '0', '用户40', 'group40', '功德主40', '7', '0', '', '广东', '0', '', '', '', '', '', '', '1479197359', '1479197359', '1479197359', '0');
INSERT INTO `sxh_user_info_1` VALUES ('41', 'test41', '用户41', '2', '0', 'test41@qq.com', '15013529563', '地址41', '广州', 'alipay41@qq.com', 'weixin41@qq.com', '邮政银行', '220559556990054714', '420222199012271062', '41', '0', '用户41', 'group41', '功德主41', '10', '0', '', '广东', '0', '', '', '', '', '', '', '1479197359', '1479197359', '1479197359', '0');
INSERT INTO `sxh_user_info_1` VALUES ('42', 'test42', '用户42', '2', '1', 'test42@qq.com', '15013529917', '地址42', '深圳', 'alipay42@qq.com', 'weixin42@qq.com', '中国银行', '220559556990051504', '420222199012275147', '42', '0', '用户42', 'group42', '功德主42', '10', '0', '', '广东', '0', '', '', '', '', '', '', '1479197359', '1479197359', '1479197359', '0');
INSERT INTO `sxh_user_info_1` VALUES ('43', 'test43', '用户43', '2', '2', 'test43@qq.com', '15013529157', '地址43', '广州', 'alipay43@qq.com', 'weixin43@qq.com', '邮政银行', '220559556990055703', '420222199012273355', '43', '0', '用户43', 'group43', '功德主43', '4', '0', '', '广东', '0', '', '', '', '', '', '', '1479197360', '1479197360', '1479197360', '0');
INSERT INTO `sxh_user_info_1` VALUES ('44', 'test44', '用户44', '1', '2', 'test44@qq.com', '15013529582', '地址44', '深圳', 'alipay44@qq.com', 'weixin44@qq.com', '中国银行', '220559556990057913', '420222199012276537', '44', '0', '用户44', 'group44', '功德主44', '8', '0', '', '广东', '0', '', '', '', '', '', '', '1479197360', '1479197360', '1479197360', '0');
INSERT INTO `sxh_user_info_1` VALUES ('45', 'test45', '用户45', '0', '1', 'test45@qq.com', '15013529852', '地址45', '广州', 'alipay45@qq.com', 'weixin45@qq.com', '邮政银行', '220559556990059731', '420222199012275392', '45', '0', '用户45', 'group45', '功德主45', '1', '0', '', '广东', '0', '', '', '', '', '', '', '1479197360', '1479197360', '1479197360', '0');
INSERT INTO `sxh_user_info_1` VALUES ('46', 'test46', '用户46', '2', '2', 'test46@qq.com', '15013529814', '地址46', '深圳', 'alipay46@qq.com', 'weixin46@qq.com', '中国银行', '220559556990053477', '420222199012271547', '46', '0', '用户46', 'group46', '功德主46', '2', '0', '', '广东', '0', '', '', '', '', '', '', '1479197360', '1479197360', '1479197360', '0');
INSERT INTO `sxh_user_info_1` VALUES ('47', 'test47', '用户47', '1', '1', 'test47@qq.com', '15013529681', '地址47', '广州', 'alipay47@qq.com', 'weixin47@qq.com', '邮政银行', '220559556990055809', '420222199012275303', '47', '0', '用户47', 'group47', '功德主47', '4', '0', '', '广东', '0', '', '', '', '', '', '', '1479197360', '1479197360', '1479197360', '0');
INSERT INTO `sxh_user_info_1` VALUES ('48', 'test48', '用户48', '1', '2', 'test48@qq.com', '15013529547', '地址48', '深圳', 'alipay48@qq.com', 'weixin48@qq.com', '中国银行', '220559556990053633', '420222199012277632', '48', '0', '用户48', 'group48', '功德主48', '5', '0', '', '广东', '0', '', '', '', '', '', '', '1479197360', '1479197360', '1479197360', '0');
INSERT INTO `sxh_user_info_1` VALUES ('49', 'test49', '用户49', '1', '2', 'test49@qq.com', '15013529597', '地址49', '广州', 'alipay49@qq.com', 'weixin49@qq.com', '邮政银行', '220559556990059804', '420222199012279491', '49', '0', '用户49', 'group49', '功德主49', '7', '0', '', '广东', '0', '', '', '', '', '', '', '1479197361', '1479197361', '1479197361', '0');
INSERT INTO `sxh_user_info_1` VALUES ('50', 'test50', '用户50', '2', '2', 'test50@qq.com', '15013529207', '地址50', '深圳', 'alipay50@qq.com', 'weixin50@qq.com', '中国银行', '220559556990057050', '420222199012278481', '50', '0', '用户50', 'group50', '功德主50', '4', '0', '', '广东', '0', '', '', '', '', '', '', '1479197361', '1479197361', '1479197361', '0');
INSERT INTO `sxh_user_info_1` VALUES ('51', 'test51', '用户51', '1', '2', 'test51@qq.com', '15013529891', '地址51', '广州', 'alipay51@qq.com', 'weixin51@qq.com', '邮政银行', '220559556990058591', '420222199012274718', '51', '0', '用户51', 'group51', '功德主51', '1', '0', '', '广东', '0', '', '', '', '', '', '', '1479197361', '1479197361', '1479197361', '0');
INSERT INTO `sxh_user_info_1` VALUES ('52', 'test52', '用户52', '2', '1', 'test52@qq.com', '15013529368', '地址52', '深圳', 'alipay52@qq.com', 'weixin52@qq.com', '中国银行', '220559556990057122', '420222199012277829', '52', '0', '用户52', 'group52', '功德主52', '10', '0', '', '广东', '0', '', '', '', '', '', '', '1479197361', '1479197361', '1479197361', '0');
INSERT INTO `sxh_user_info_1` VALUES ('53', 'test53', '用户53', '1', '0', 'test53@qq.com', '15013529267', '地址53', '广州', 'alipay53@qq.com', 'weixin53@qq.com', '邮政银行', '220559556990052163', '420222199012279446', '53', '0', '用户53', 'group53', '功德主53', '7', '0', '', '广东', '0', '', '', '', '', '', '', '1479197361', '1479197361', '1479197361', '0');
INSERT INTO `sxh_user_info_1` VALUES ('54', 'test54', '用户54', '0', '1', 'test54@qq.com', '15013529314', '地址54', '深圳', 'alipay54@qq.com', 'weixin54@qq.com', '中国银行', '220559556990059719', '420222199012277155', '54', '0', '用户54', 'group54', '功德主54', '9', '0', '', '广东', '0', '', '', '', '', '', '', '1479197362', '1479197362', '1479197362', '0');
INSERT INTO `sxh_user_info_1` VALUES ('55', 'test55', '用户55', '0', '0', 'test55@qq.com', '15013529550', '地址55', '广州', 'alipay55@qq.com', 'weixin55@qq.com', '邮政银行', '220559556990053473', '420222199012279430', '55', '0', '用户55', 'group55', '功德主55', '3', '0', '', '广东', '0', '', '', '', '', '', '', '1479197362', '1479197362', '1479197362', '0');
INSERT INTO `sxh_user_info_1` VALUES ('56', 'test56', '用户56', '1', '0', 'test56@qq.com', '15013529167', '地址56', '深圳', 'alipay56@qq.com', 'weixin56@qq.com', '中国银行', '220559556990056849', '420222199012274915', '56', '0', '用户56', 'group56', '功德主56', '8', '0', '', '广东', '0', '', '', '', '', '', '', '1479197362', '1479197362', '1479197362', '0');
INSERT INTO `sxh_user_info_1` VALUES ('57', 'test57', '用户57', '0', '0', 'test57@qq.com', '15013529332', '地址57', '广州', 'alipay57@qq.com', 'weixin57@qq.com', '邮政银行', '220559556990055561', '420222199012271874', '57', '0', '用户57', 'group57', '功德主57', '2', '0', '', '广东', '0', '', '', '', '', '', '', '1479197362', '1479197362', '1479197362', '0');
INSERT INTO `sxh_user_info_1` VALUES ('58', 'test58', '用户58', '1', '0', 'test58@qq.com', '15013529601', '地址58', '深圳', 'alipay58@qq.com', 'weixin58@qq.com', '中国银行', '220559556990059129', '420222199012277438', '58', '0', '用户58', 'group58', '功德主58', '9', '0', '', '广东', '0', '', '', '', '', '', '', '1479197362', '1479197362', '1479197362', '0');
INSERT INTO `sxh_user_info_1` VALUES ('59', 'test59', '用户59', '1', '2', 'test59@qq.com', '15013529172', '地址59', '广州', 'alipay59@qq.com', 'weixin59@qq.com', '邮政银行', '220559556990054500', '420222199012272815', '59', '0', '用户59', 'group59', '功德主59', '7', '0', '', '广东', '0', '', '', '', '', '', '', '1479197363', '1479197363', '1479197363', '0');
INSERT INTO `sxh_user_info_1` VALUES ('60', 'test60', '用户60', '1', '2', 'test60@qq.com', '15013529903', '地址60', '深圳', 'alipay60@qq.com', 'weixin60@qq.com', '中国银行', '220559556990059577', '420222199012279591', '60', '0', '用户60', 'group60', '功德主60', '3', '0', '', '广东', '0', '', '', '', '', '', '', '1479197363', '1479197363', '1479197363', '0');
INSERT INTO `sxh_user_info_1` VALUES ('61', 'test61', '用户61', '1', '0', 'test61@qq.com', '15013529564', '地址61', '广州', 'alipay61@qq.com', 'weixin61@qq.com', '邮政银行', '220559556990052237', '420222199012273745', '61', '0', '用户61', 'group61', '功德主61', '8', '0', '', '广东', '0', '', '', '', '', '', '', '1479197363', '1479197363', '1479197363', '0');
INSERT INTO `sxh_user_info_1` VALUES ('62', 'test62', '用户62', '1', '2', 'test62@qq.com', '15013529913', '地址62', '深圳', 'alipay62@qq.com', 'weixin62@qq.com', '中国银行', '220559556990055967', '420222199012271606', '62', '0', '用户62', 'group62', '功德主62', '6', '0', '', '广东', '0', '', '', '', '', '', '', '1479197363', '1479197363', '1479197363', '0');
INSERT INTO `sxh_user_info_1` VALUES ('63', 'test63', '用户63', '1', '1', 'test63@qq.com', '15013529631', '地址63', '广州', 'alipay63@qq.com', 'weixin63@qq.com', '邮政银行', '220559556990051924', '420222199012273280', '63', '0', '用户63', 'group63', '功德主63', '7', '0', '', '广东', '0', '', '', '', '', '', '', '1479197364', '1479197364', '1479197364', '0');
INSERT INTO `sxh_user_info_1` VALUES ('64', 'test64', '用户64', '2', '0', 'test64@qq.com', '15013529393', '地址64', '深圳', 'alipay64@qq.com', 'weixin64@qq.com', '中国银行', '220559556990056466', '420222199012279966', '64', '0', '用户64', 'group64', '功德主64', '10', '0', '', '广东', '0', '', '', '', '', '', '', '1479197364', '1479197364', '1479197364', '0');
INSERT INTO `sxh_user_info_1` VALUES ('65', 'test65', '用户65', '2', '0', 'test65@qq.com', '15013529386', '地址65', '广州', 'alipay65@qq.com', 'weixin65@qq.com', '邮政银行', '220559556990056406', '420222199012276432', '65', '0', '用户65', 'group65', '功德主65', '4', '0', '', '广东', '0', '', '', '', '', '', '', '1479197364', '1479197364', '1479197364', '0');
INSERT INTO `sxh_user_info_1` VALUES ('66', 'test66', '用户66', '0', '1', 'test66@qq.com', '15013529553', '地址66', '深圳', 'alipay66@qq.com', 'weixin66@qq.com', '中国银行', '220559556990058724', '420222199012278281', '66', '0', '用户66', 'group66', '功德主66', '7', '0', '', '广东', '0', '', '', '', '', '', '', '1479197364', '1479197364', '1479197364', '0');
INSERT INTO `sxh_user_info_1` VALUES ('67', 'test67', '用户67', '2', '2', 'test67@qq.com', '15013529409', '地址67', '广州', 'alipay67@qq.com', 'weixin67@qq.com', '邮政银行', '220559556990058055', '420222199012275732', '67', '0', '用户67', 'group67', '功德主67', '3', '0', '', '广东', '0', '', '', '', '', '', '', '1479197364', '1479197364', '1479197364', '0');
INSERT INTO `sxh_user_info_1` VALUES ('68', 'test68', '用户68', '1', '1', 'test68@qq.com', '15013529440', '地址68', '深圳', 'alipay68@qq.com', 'weixin68@qq.com', '中国银行', '220559556990053792', '420222199012276005', '68', '0', '用户68', 'group68', '功德主68', '5', '0', '', '广东', '0', '', '', '', '', '', '', '1479197364', '1479197364', '1479197364', '0');
INSERT INTO `sxh_user_info_1` VALUES ('69', 'test69', '用户69', '1', '1', 'test69@qq.com', '15013529513', '地址69', '广州', 'alipay69@qq.com', 'weixin69@qq.com', '邮政银行', '220559556990053167', '420222199012275933', '69', '0', '用户69', 'group69', '功德主69', '3', '0', '', '广东', '0', '', '', '', '', '', '', '1479197365', '1479197365', '1479197365', '0');
INSERT INTO `sxh_user_info_1` VALUES ('70', 'test70', '用户70', '0', '2', 'test70@qq.com', '15013529365', '地址70', '深圳', 'alipay70@qq.com', 'weixin70@qq.com', '中国银行', '220559556990052830', '420222199012272662', '70', '0', '用户70', 'group70', '功德主70', '3', '0', '', '广东', '0', '', '', '', '', '', '', '1479197365', '1479197365', '1479197365', '0');
INSERT INTO `sxh_user_info_1` VALUES ('71', 'test71', '用户71', '0', '2', 'test71@qq.com', '15013529874', '地址71', '广州', 'alipay71@qq.com', 'weixin71@qq.com', '邮政银行', '220559556990052027', '420222199012274730', '71', '0', '用户71', 'group71', '功德主71', '8', '0', '', '广东', '0', '', '', '', '', '', '', '1479197365', '1479197365', '1479197365', '0');
INSERT INTO `sxh_user_info_1` VALUES ('72', 'test72', '用户72', '0', '1', 'test72@qq.com', '15013529955', '地址72', '深圳', 'alipay72@qq.com', 'weixin72@qq.com', '中国银行', '220559556990056715', '420222199012279941', '72', '0', '用户72', 'group72', '功德主72', '6', '0', '', '广东', '0', '', '', '', '', '', '', '1479197365', '1479197365', '1479197365', '0');
INSERT INTO `sxh_user_info_1` VALUES ('73', 'test73', '用户73', '0', '0', 'test73@qq.com', '15013529308', '地址73', '广州', 'alipay73@qq.com', 'weixin73@qq.com', '邮政银行', '220559556990052235', '420222199012278191', '73', '0', '用户73', 'group73', '功德主73', '1', '0', '', '广东', '0', '', '', '', '', '', '', '1479197365', '1479197365', '1479197365', '0');
INSERT INTO `sxh_user_info_1` VALUES ('74', 'test74', '用户74', '2', '2', 'test74@qq.com', '15013529651', '地址74', '深圳', 'alipay74@qq.com', 'weixin74@qq.com', '中国银行', '220559556990052702', '420222199012277801', '74', '0', '用户74', 'group74', '功德主74', '2', '0', '', '广东', '0', '', '', '', '', '', '', '1479197365', '1479197365', '1479197365', '0');
INSERT INTO `sxh_user_info_1` VALUES ('75', 'test75', '用户75', '0', '1', 'test75@qq.com', '15013529101', '地址75', '广州', 'alipay75@qq.com', 'weixin75@qq.com', '邮政银行', '220559556990055999', '420222199012275066', '75', '0', '用户75', 'group75', '功德主75', '9', '0', '', '广东', '0', '', '', '', '', '', '', '1479197366', '1479197366', '1479197366', '0');
INSERT INTO `sxh_user_info_1` VALUES ('76', 'test76', '用户76', '0', '2', 'test76@qq.com', '15013529935', '地址76', '深圳', 'alipay76@qq.com', 'weixin76@qq.com', '中国银行', '220559556990059840', '420222199012274605', '76', '0', '用户76', 'group76', '功德主76', '4', '0', '', '广东', '0', '', '', '', '', '', '', '1479197366', '1479197366', '1479197366', '0');
INSERT INTO `sxh_user_info_1` VALUES ('77', 'test77', '用户77', '0', '2', 'test77@qq.com', '15013529197', '地址77', '广州', 'alipay77@qq.com', 'weixin77@qq.com', '邮政银行', '220559556990059814', '420222199012276871', '77', '0', '用户77', 'group77', '功德主77', '8', '0', '', '广东', '0', '', '', '', '', '', '', '1479197366', '1479197366', '1479197366', '0');
INSERT INTO `sxh_user_info_1` VALUES ('78', 'test78', '用户78', '1', '2', 'test78@qq.com', '15013529342', '地址78', '深圳', 'alipay78@qq.com', 'weixin78@qq.com', '中国银行', '220559556990056170', '420222199012277404', '78', '0', '用户78', 'group78', '功德主78', '7', '0', '', '广东', '0', '', '', '', '', '', '', '1479197366', '1479197366', '1479197366', '0');
INSERT INTO `sxh_user_info_1` VALUES ('79', 'test79', '用户79', '2', '2', 'test79@qq.com', '15013529221', '地址79', '广州', 'alipay79@qq.com', 'weixin79@qq.com', '邮政银行', '220559556990051044', '420222199012275075', '79', '0', '用户79', 'group79', '功德主79', '6', '0', '', '广东', '0', '', '', '', '', '', '', '1479197366', '1479197366', '1479197366', '0');
INSERT INTO `sxh_user_info_1` VALUES ('80', 'test80', '用户80', '1', '2', 'test80@qq.com', '15013529511', '地址80', '深圳', 'alipay80@qq.com', 'weixin80@qq.com', '中国银行', '220559556990052331', '420222199012276802', '80', '0', '用户80', 'group80', '功德主80', '1', '0', '', '广东', '0', '', '', '', '', '', '', '1479197366', '1479197366', '1479197366', '0');
INSERT INTO `sxh_user_info_1` VALUES ('81', 'test81', '用户81', '2', '0', 'test81@qq.com', '15013529566', '地址81', '广州', 'alipay81@qq.com', 'weixin81@qq.com', '邮政银行', '220559556990053862', '420222199012272563', '81', '0', '用户81', 'group81', '功德主81', '8', '0', '', '广东', '0', '', '', '', '', '', '', '1479197367', '1479197367', '1479197367', '0');
INSERT INTO `sxh_user_info_1` VALUES ('82', 'test82', '用户82', '0', '1', 'test82@qq.com', '15013529350', '地址82', '深圳', 'alipay82@qq.com', 'weixin82@qq.com', '中国银行', '220559556990054003', '420222199012273988', '82', '0', '用户82', 'group82', '功德主82', '3', '0', '', '广东', '0', '', '', '', '', '', '', '1479197367', '1479197367', '1479197367', '0');
INSERT INTO `sxh_user_info_1` VALUES ('83', 'test83', '用户83', '2', '2', 'test83@qq.com', '15013529580', '地址83', '广州', 'alipay83@qq.com', 'weixin83@qq.com', '邮政银行', '220559556990052357', '420222199012271093', '83', '0', '用户83', 'group83', '功德主83', '5', '0', '', '广东', '0', '', '', '', '', '', '', '1479197367', '1479197367', '1479197367', '0');
INSERT INTO `sxh_user_info_1` VALUES ('84', 'test84', '用户84', '0', '2', 'test84@qq.com', '15013529917', '地址84', '深圳', 'alipay84@qq.com', 'weixin84@qq.com', '中国银行', '220559556990055547', '420222199012274673', '84', '0', '用户84', 'group84', '功德主84', '5', '0', '', '广东', '0', '', '', '', '', '', '', '1479197367', '1479197367', '1479197367', '0');
INSERT INTO `sxh_user_info_1` VALUES ('85', 'test85', '用户85', '0', '2', 'test85@qq.com', '15013529294', '地址85', '广州', 'alipay85@qq.com', 'weixin85@qq.com', '邮政银行', '220559556990058472', '420222199012274641', '85', '0', '用户85', 'group85', '功德主85', '7', '0', '', '广东', '0', '', '', '', '', '', '', '1479197367', '1479197367', '1479197367', '0');
INSERT INTO `sxh_user_info_1` VALUES ('86', 'test86', '用户86', '0', '0', 'test86@qq.com', '15013529844', '地址86', '深圳', 'alipay86@qq.com', 'weixin86@qq.com', '中国银行', '220559556990053326', '420222199012271199', '86', '0', '用户86', 'group86', '功德主86', '3', '0', '', '广东', '0', '', '', '', '', '', '', '1479197367', '1479197367', '1479197367', '0');
INSERT INTO `sxh_user_info_1` VALUES ('87', 'test87', '用户87', '1', '1', 'test87@qq.com', '15013529605', '地址87', '广州', 'alipay87@qq.com', 'weixin87@qq.com', '邮政银行', '220559556990053757', '420222199012279512', 'test95', '95', '用户87', 'group87', '功德主87', '9', '0', '', '广东', '0', '', '', '', '', '', '', '1479197368', '1479197368', '1479197368', '1479206473');
INSERT INTO `sxh_user_info_1` VALUES ('88', 'test88', '用户88', '2', '1', 'test88@qq.com', '15013529939', '地址88', '深圳', 'alipay88@qq.com', 'weixin88@qq.com', '中国银行', '220559556990052912', '420222199012271042', '88', '0', '用户88', 'group88', '功德主88', '10', '0', '', '广东', '0', '', '', '', '', '', '', '1479197368', '1479197368', '1479197368', '0');
INSERT INTO `sxh_user_info_1` VALUES ('89', 'test89', '123', '0', '1', '', '', '地址89', '广州', '', '', '', '', '', '89', '0', '用户89', 'group89', '功德主89', '8', '0', '', '广东', '0', '', '', '', '', '', '', '1479197368', '1479197368', '1479197368', '1479206422');
INSERT INTO `sxh_user_info_1` VALUES ('90', 'test90', '用户90', '0', '0', 'test90@qq.com', '15013529656', '地址90', '深圳', 'alipay90@qq.com', 'weixin90@qq.com', '中国银行', '220559556990057166', '420222199012278326', '90', '0', '用户90', 'group90', '功德主90', '5', '0', '', '广东', '0', '', '', '', '', '', '', '1479197368', '1479197368', '1479197368', '0');
INSERT INTO `sxh_user_info_1` VALUES ('91', 'test91', '用户91', '0', '0', 'test91@qq.com', '15013529499', '地址91', '广州', 'alipay91@qq.com', 'weixin91@qq.com', '邮政银行', '220559556990051304', '420222199012276248', '91', '0', '用户91', 'group91', '功德主91', '2', '0', '', '广东', '0', '', '', '', '', '', '', '1479197368', '1479197368', '1479197368', '0');
INSERT INTO `sxh_user_info_1` VALUES ('92', 'test92', '用户92', '2', '1', 'test92@qq.com', '15013529931', '地址92', '深圳', 'alipay92@qq.com', 'weixin92@qq.com', '中国银行', '220559556990059505', '420222199012275192', '92', '0', '用户92', 'group92', '功德主92', '2', '0', '', '广东', '0', '', '', '', '', '', '', '1479197369', '1479197369', '1479197369', '0');
INSERT INTO `sxh_user_info_1` VALUES ('93', 'test93', '用户93', '0', '0', 'test93@qq.com', '15013529100', '地址93', '广州', 'alipay93@qq.com', 'weixin93@qq.com', '邮政银行', '220559556990051627', '420222199012272134', '93', '0', '用户93', 'group93', '功德主93', '7', '0', '', '广东', '0', '', '', '', '', '', '', '1479197369', '1479197369', '1479197369', '0');
INSERT INTO `sxh_user_info_1` VALUES ('94', 'test94', '用户94', '0', '1', 'test94@qq.com', '15013529555', '地址94', '深圳', 'alipay94@qq.com', 'weixin94@qq.com', '中国银行', '220559556990057606', '420222199012278514', 'test100', '100', '用户94', 'group94', '功德主94', '10', '1', 'sxh_admin', '广东', '0', '', '', '', '', '', '', '1479197369', '1479197369', '1479197369', '1479709266');
INSERT INTO `sxh_user_info_1` VALUES ('95', 'test95', '', '2', '0', '', '', '地址95', '广州', '', '', '', '', '', '95', '0', '用户95', 'group95', '功德主95', '10', '0', '', '广东', '0', '', '', '', '', '', '', '1479197369', '1479197369', '1479197369', '1479294779');
INSERT INTO `sxh_user_info_1` VALUES ('96', 'test96', '用户96', '2', '1', 'test96@qq.com', '15013529722', '地址96', '深圳', 'alipay96@qq.com', 'weixin96@qq.com', '中国银行', '220559556990057207', '420222199012276051', '96', '0', '用户96', 'group96', '功德主96', '8', '0', '', '广东', '0', '', '', '', '', '', '', '1479197369', '1479197369', '1479197369', '0');
INSERT INTO `sxh_user_info_1` VALUES ('97', 'test97', '用户97', '2', '1', 'test97@qq.com', '15013529453', '地址97', '广州', 'alipay97@qq.com', 'weixin97@qq.com', '邮政银行', '220559556990058466', '420222199012272004', '97', '0', '用户97', 'group97', '功德主97', '5', '1', 'sxh_admin', '广东', '0', '', '', '', '', '', '', '1479197370', '1479197370', '1479197370', '1479262299');
INSERT INTO `sxh_user_info_1` VALUES ('98', 'test98', '用户98', '2', '2', 'test98@qq.com', '15013529912', '地址98', '深圳', 'alipay98@qq.com', 'weixin98@qq.com', '中国银行', '220559556990057082', '420222199012273496', '98', '0', '用户98', 'group98', '功德主98', '10', '1', 'sxh_admin', '广东', '0', '', '', '', '', '', '', '1479197370', '1479197370', '1479197370', '1479262314');
INSERT INTO `sxh_user_info_1` VALUES ('99', 'test99', '用户99', '1', '1', 'test99@qq.com', '15013529781', '地址99', '广州', 'alipay99@qq.com', 'weixin99@qq.com', '邮政银行', '220559556990055004', '420222199012271100', '99', '0', '用户99', 'group99', '功德主99', '1', '1', 'sxh_admin', '广东', '0', '', '', '', '', '', '', '1479197370', '1479197370', '1479197370', '1479260477');
INSERT INTO `sxh_user_info_1` VALUES ('100', 'test100', '32312', '2', '1', '', '', '地址100', '深圳', '', '', '', '', '', 'test76', '76', '用户100', 'group100', '功德主100', '8', '1', 'sxh_admin', '广东', '0', '', '', '', '', '', '', '1479197370', '1479197370', '1479197370', '1479699236');

-- ----------------------------
-- Table structure for sxh_user_info_2
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_info_2`;
CREATE TABLE `sxh_user_info_2` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '登录用户名',
  `name` char(20) NOT NULL DEFAULT '' COMMENT '身份证上的姓名',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未激活 1-已激活 2-已冻结',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '资料审核 0-未审核 1-未通过 2-已通过',
  `email` char(30) NOT NULL DEFAULT '' COMMENT '电子邮件',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `address` char(100) NOT NULL DEFAULT '' COMMENT '收货地址',
  `city` char(20) NOT NULL DEFAULT '' COMMENT '居住地所在的城市',
  `alipay_account` char(30) NOT NULL DEFAULT '' COMMENT '支付宝账号',
  `weixin_account` char(30) NOT NULL DEFAULT '' COMMENT '微信账号',
  `bank_name` char(30) NOT NULL DEFAULT '' COMMENT '开户银行名称',
  `bank_account` char(30) NOT NULL DEFAULT '' COMMENT '银行帐号',
  `card_id` char(20) NOT NULL DEFAULT '' COMMENT '身份证号码',
  `referee` char(20) NOT NULL DEFAULT '' COMMENT '推荐人账号',
  `referee_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '推荐人id',
  `referee_name` char(20) NOT NULL DEFAULT '' COMMENT '推荐人姓名',
  `group` char(20) NOT NULL DEFAULT '' COMMENT '隶属组账号',
  `group_name` char(20) NOT NULL DEFAULT '' COMMENT '隶属组名称',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '隶属组id',
  `verify_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '审核人id',
  `verify_uname` char(20) NOT NULL DEFAULT '' COMMENT '审核人姓名',
  `province` char(20) NOT NULL DEFAULT '' COMMENT '所在省份',
  `classification` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '用户类别 0-普通用户 1-功德主 2-服务中心',
  `town` char(20) NOT NULL DEFAULT '' COMMENT '所在城市',
  `image_a` char(40) NOT NULL DEFAULT '' COMMENT '身份证手持正面',
  `image_b` char(40) NOT NULL DEFAULT '' COMMENT '身份证手持背面',
  `image_c` char(40) NOT NULL DEFAULT '' COMMENT '身份证手持全身',
  `remark` char(64) NOT NULL DEFAULT '' COMMENT '备注',
  `tel_number` char(15) NOT NULL DEFAULT '' COMMENT '善心号',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `last_update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `admin_update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员更新资料时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员信息表';

-- ----------------------------
-- Records of sxh_user_info_2
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_info_3
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_info_3`;
CREATE TABLE `sxh_user_info_3` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '登录用户名',
  `name` char(20) NOT NULL DEFAULT '' COMMENT '身份证上的姓名',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未激活 1-已激活 2-已冻结',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '资料审核 0-未审核 1-未通过 2-已通过',
  `email` char(30) NOT NULL DEFAULT '' COMMENT '电子邮件',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `address` char(100) NOT NULL DEFAULT '' COMMENT '收货地址',
  `city` char(20) NOT NULL DEFAULT '' COMMENT '居住地所在的城市',
  `alipay_account` char(30) NOT NULL DEFAULT '' COMMENT '支付宝账号',
  `weixin_account` char(30) NOT NULL DEFAULT '' COMMENT '微信账号',
  `bank_name` char(30) NOT NULL DEFAULT '' COMMENT '开户银行名称',
  `bank_account` char(30) NOT NULL DEFAULT '' COMMENT '银行帐号',
  `card_id` char(20) NOT NULL DEFAULT '' COMMENT '身份证号码',
  `referee` char(20) NOT NULL DEFAULT '' COMMENT '推荐人账号',
  `referee_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '推荐人id',
  `referee_name` char(20) NOT NULL DEFAULT '' COMMENT '推荐人姓名',
  `group` char(20) NOT NULL DEFAULT '' COMMENT '隶属组账号',
  `group_name` char(20) NOT NULL DEFAULT '' COMMENT '隶属组名称',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '隶属组id',
  `verify_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '审核人id',
  `verify_uname` char(20) NOT NULL DEFAULT '' COMMENT '审核人姓名',
  `province` char(20) NOT NULL DEFAULT '' COMMENT '所在省份',
  `classification` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '用户类别 0-普通用户 1-功德主 2-服务中心',
  `town` char(20) NOT NULL DEFAULT '' COMMENT '所在城市',
  `image_a` char(40) NOT NULL DEFAULT '' COMMENT '身份证手持正面',
  `image_b` char(40) NOT NULL DEFAULT '' COMMENT '身份证手持背面',
  `image_c` char(40) NOT NULL DEFAULT '' COMMENT '身份证手持全身',
  `remark` char(64) NOT NULL DEFAULT '' COMMENT '备注',
  `tel_number` char(15) NOT NULL DEFAULT '' COMMENT '善心号',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `last_update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `admin_update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员更新资料时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员信息表';

-- ----------------------------
-- Records of sxh_user_info_3
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_info_4
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_info_4`;
CREATE TABLE `sxh_user_info_4` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '登录用户名',
  `name` char(20) NOT NULL DEFAULT '' COMMENT '身份证上的姓名',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未激活 1-已激活 2-已冻结',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '资料审核 0-未审核 1-未通过 2-已通过',
  `email` char(30) NOT NULL DEFAULT '' COMMENT '电子邮件',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `address` char(100) NOT NULL DEFAULT '' COMMENT '收货地址',
  `city` char(20) NOT NULL DEFAULT '' COMMENT '居住地所在的城市',
  `alipay_account` char(30) NOT NULL DEFAULT '' COMMENT '支付宝账号',
  `weixin_account` char(30) NOT NULL DEFAULT '' COMMENT '微信账号',
  `bank_name` char(30) NOT NULL DEFAULT '' COMMENT '开户银行名称',
  `bank_account` char(30) NOT NULL DEFAULT '' COMMENT '银行帐号',
  `card_id` char(20) NOT NULL DEFAULT '' COMMENT '身份证号码',
  `referee` char(20) NOT NULL DEFAULT '' COMMENT '推荐人账号',
  `referee_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '推荐人id',
  `referee_name` char(20) NOT NULL DEFAULT '' COMMENT '推荐人姓名',
  `group` char(20) NOT NULL DEFAULT '' COMMENT '隶属组账号',
  `group_name` char(20) NOT NULL DEFAULT '' COMMENT '隶属组名称',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '隶属组id',
  `verify_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '审核人id',
  `verify_uname` char(20) NOT NULL DEFAULT '' COMMENT '审核人姓名',
  `province` char(20) NOT NULL DEFAULT '' COMMENT '所在省份',
  `classification` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '用户类别 0-普通用户 1-功德主 2-服务中心',
  `town` char(20) NOT NULL DEFAULT '' COMMENT '所在城市',
  `image_a` char(40) NOT NULL DEFAULT '' COMMENT '身份证手持正面',
  `image_b` char(40) NOT NULL DEFAULT '' COMMENT '身份证手持背面',
  `image_c` char(40) NOT NULL DEFAULT '' COMMENT '身份证手持全身',
  `remark` char(64) NOT NULL DEFAULT '' COMMENT '备注',
  `tel_number` char(15) NOT NULL DEFAULT '' COMMENT '善心号',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `last_update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `admin_update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员更新资料时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员信息表';

-- ----------------------------
-- Records of sxh_user_info_4
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_info_5
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_info_5`;
CREATE TABLE `sxh_user_info_5` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '登录用户名',
  `name` char(20) NOT NULL DEFAULT '' COMMENT '身份证上的姓名',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未激活 1-已激活 2-已冻结',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '资料审核 0-未审核 1-未通过 2-已通过',
  `email` char(30) NOT NULL DEFAULT '' COMMENT '电子邮件',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `address` char(100) NOT NULL DEFAULT '' COMMENT '收货地址',
  `city` char(20) NOT NULL DEFAULT '' COMMENT '居住地所在的城市',
  `alipay_account` char(30) NOT NULL DEFAULT '' COMMENT '支付宝账号',
  `weixin_account` char(30) NOT NULL DEFAULT '' COMMENT '微信账号',
  `bank_name` char(30) NOT NULL DEFAULT '' COMMENT '开户银行名称',
  `bank_account` char(30) NOT NULL DEFAULT '' COMMENT '银行帐号',
  `card_id` char(20) NOT NULL DEFAULT '' COMMENT '身份证号码',
  `referee` char(20) NOT NULL DEFAULT '' COMMENT '推荐人账号',
  `referee_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '推荐人id',
  `referee_name` char(20) NOT NULL DEFAULT '' COMMENT '推荐人姓名',
  `group` char(20) NOT NULL DEFAULT '' COMMENT '隶属组账号',
  `group_name` char(20) NOT NULL DEFAULT '' COMMENT '隶属组名称',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '隶属组id',
  `verify_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '审核人id',
  `verify_uname` char(20) NOT NULL DEFAULT '' COMMENT '审核人姓名',
  `province` char(20) NOT NULL DEFAULT '' COMMENT '所在省份',
  `classification` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '用户类别 0-普通用户 1-功德主 2-服务中心',
  `town` char(20) NOT NULL DEFAULT '' COMMENT '所在城市',
  `image_a` char(40) NOT NULL DEFAULT '' COMMENT '身份证手持正面',
  `image_b` char(40) NOT NULL DEFAULT '' COMMENT '身份证手持背面',
  `image_c` char(40) NOT NULL DEFAULT '' COMMENT '身份证手持全身',
  `remark` char(64) NOT NULL DEFAULT '' COMMENT '备注',
  `tel_number` char(15) NOT NULL DEFAULT '' COMMENT '善心号',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `last_update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `admin_update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员更新资料时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员信息表';

-- ----------------------------
-- Records of sxh_user_info_5
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_matchhelp_4
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_matchhelp_4`;
CREATE TABLE `sxh_user_matchhelp_4` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` tinyint(1) NOT NULL COMMENT '接受类型 1-接受资助 2-接单钱包',
  `other_type_id` tinyint(1) NOT NULL COMMENT '资助类型 1-提供资助 2-接单资助',
  `cid` smallint(4) NOT NULL COMMENT 'accept表的社区ID',
  `other_cid` smallint(4) NOT NULL COMMENT 'provide表社区ID',
  `pid` int(10) NOT NULL COMMENT '接受资助表ID',
  `user_id` int(10) NOT NULL COMMENT '接受资助人ID',
  `username` char(20) NOT NULL COMMENT '接受资助人',
  `money` int(10) NOT NULL COMMENT '接受资助金额',
  `other_id` int(10) NOT NULL COMMENT '提供资助表ID',
  `other_user_id` int(10) NOT NULL COMMENT '提供资助人ID',
  `other_username` char(20) NOT NULL COMMENT '提供资助人',
  `other_money` int(10) NOT NULL COMMENT '匹配金额',
  `provide_money` int(10) NOT NULL COMMENT '提供资助金额',
  `status` tinyint(3) NOT NULL COMMENT '状态 0-匹配成功 1-审通过 2-已打款，3-已收款',
  `handlers` int(10) NOT NULL COMMENT '操作人',
  `ip_address` bigint(10) NOT NULL,
  `sign_time` int(10) NOT NULL COMMENT '收款时间',
  `pay_time` int(10) NOT NULL COMMENT '打款时间',
  `pay_image` char(20) NOT NULL COMMENT '打款图片',
  `create_time` int(10) NOT NULL COMMENT '匹配时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  `batch` int(10) NOT NULL,
  `audit_user_id` int(10) NOT NULL COMMENT '审核人ID',
  `audit_username` char(20) NOT NULL COMMENT '审核人',
  `audit_time` int(10) NOT NULL COMMENT '审核时间',
  `sms_status` tinyint(1) NOT NULL COMMENT '短信发送状态 0-成功 1-失败',
  `flag` tinyint(1) NOT NULL COMMENT '0-正常 2-删除',
  `delayed_time_status` tinyint(1) NOT NULL COMMENT '延时',
  `remark` char(30) NOT NULL DEFAULT '' COMMENT '不打款描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='匹配数据表';

-- ----------------------------
-- Records of sxh_user_matchhelp_4
-- ----------------------------
INSERT INTO `sxh_user_matchhelp_4` VALUES ('1', '0', '0', '0', '0', '1', '1', '11', '10000', '1', '135', '111', '1000', '0', '1', '1', '0', '0', '1479350861', '', '1479814274', '1477205424', '0', '0', '', '0', '0', '0', '1', '不想打');
INSERT INTO `sxh_user_matchhelp_4` VALUES ('2', '0', '0', '0', '0', '1', '1', '11', '10000', '1', '1', '1', '1000', '0', '0', '1', '0', '0', '1479350861', '', '0', '0', '0', '0', '', '0', '0', '0', '0', '不想打2');
INSERT INTO `sxh_user_matchhelp_4` VALUES ('3', '1', '1', '0', '0', '1', '1', '1', '10000', '1', '135', '2', '1000', '0', '2', '2', '2130706433', '0', '1479350861', '', '1477201807', '1477201807', '1477152000', '2', 'tt', '1477201807', '0', '0', '0', '不想打3');
INSERT INTO `sxh_user_matchhelp_4` VALUES ('4', '1', '1', '0', '0', '1', '1', '1', '10000', '1', '135', '2', '1000', '0', '2', '2', '2130706433', '0', '1479350861', '', '1477202037', '1477202037', '1477152000', '2', 'tt', '1477202037', '0', '0', '0', '不想打4');
INSERT INTO `sxh_user_matchhelp_4` VALUES ('5', '1', '1', '0', '0', '1', '1', '1', '10000', '2', '135', '2', '1000', '0', '1', '2', '2130706433', '0', '1479350861', '', '1478077335', '1477202048', '1477152000', '2', 'tt', '1477202048', '0', '2', '1', '不想打5');
INSERT INTO `sxh_user_matchhelp_4` VALUES ('6', '1', '1', '0', '0', '1', '1', '1', '10000', '121', '135', '2', '1000', '0', '1', '2', '2130706433', '0', '1479350861', '', '1477202478', '1477202478', '1477152000', '2', 'tt', '1477202478', '0', '0', '0', '不想打6');

-- ----------------------------
-- Table structure for sxh_user_outgo_4
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_outgo_4`;
CREATE TABLE `sxh_user_outgo_4` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL COMMENT '支出类型 1-善种子 2-善心币 3-善金币 4-出局钱包 5-管理钱包6-接单钱包 7-特困钱包 8-贫穷钱包 9-小康钱包 10-德善钱包 11-富人钱包',
  `user_id` int(10) NOT NULL COMMENT '支出用户id',
  `username` char(20) NOT NULL COMMENT '用户名称',
  `outgo` int(10) NOT NULL COMMENT '支出额度',
  `pid` int(10) NOT NULL COMMENT '支出来源(accepthelp表的主键)',
  `info` char(64) NOT NULL COMMENT '备注说明',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sxh_user_outgo_4
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_provide_4
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_provide_4`;
CREATE TABLE `sxh_user_provide_4` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` tinyint(1) NOT NULL DEFAULT '0' COMMENT '资助类型 1-提供资助 2-接单资助(从先前的提供资助人转到当前用户)',
  `money` int(10) NOT NULL COMMENT '提交金额',
  `used` int(10) NOT NULL COMMENT '匹配金额',
  `cid` int(10) NOT NULL COMMENT '社区ID',
  `cname` char(20) NOT NULL COMMENT '社区名字',
  `user_id` int(10) NOT NULL COMMENT '用户ID',
  `username` char(20) NOT NULL COMMENT '提供人',
  `status` tinyint(3) NOT NULL COMMENT '状态 0-提交成功 1-匹配成功 2-已打款，3-已收款',
  `batch` int(10) NOT NULL COMMENT '批次',
  `ipaddress` bigint(10) NOT NULL COMMENT 'ip地址',
  `sign_time` int(10) NOT NULL COMMENT '完成时间',
  `create_time` int(10) NOT NULL COMMENT '提交时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  `match_num` tinyint(3) NOT NULL DEFAULT '0' COMMENT '匹配的笔数',
  `pay_num` tinyint(3) NOT NULL DEFAULT '0' COMMENT '支付的笔数（支付的时候+1）',
  `flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '标记 0-正常 1-错误数据2-删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COMMENT='提供资助表';

-- ----------------------------
-- Records of sxh_user_provide_4
-- ----------------------------
INSERT INTO `sxh_user_provide_4` VALUES ('1', '1', '1000', '2000', '1', '贫穷社区', '135', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '1', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('2', '1', '1000', '-1000', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '-1', '0', '2');
INSERT INTO `sxh_user_provide_4` VALUES ('3', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('4', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('5', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('6', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('7', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('8', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('9', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('10', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('11', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('12', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('13', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('14', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('15', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('16', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('17', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('18', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('19', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('20', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('21', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('22', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('23', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('24', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('25', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('26', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('27', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('28', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('29', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('30', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('31', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('32', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('33', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('34', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('35', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('36', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('37', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('38', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('39', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('40', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('41', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('42', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('43', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('44', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('45', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('46', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('47', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('48', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('49', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('50', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('51', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('52', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('53', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');
INSERT INTO `sxh_user_provide_4` VALUES ('54', '1', '1000', '0', '1', '贫穷社区', '1', '', '0', '1478646000', '2589631234', '0', '1478646000', '1478646000', '0', '0', '0');

-- ----------------------------
-- Table structure for sxh_user_sms
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_sms`;
CREATE TABLE `sxh_user_sms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '接收短信的手机号码',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '短信类型',
  `code` char(8) NOT NULL DEFAULT '' COMMENT '短信验证码',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发送状态 0-失败 1-成功',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '验证码是否使用过 0-未使用 1-使用',
  `ip_address` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'IP地址',
  `valid_time` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '验证码的有效时间 秒为单位，和create_time作对比',
  `matching_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '专门给匹配通知用，匹配表的ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='保存短信发送记录表';

-- ----------------------------
-- Records of sxh_user_sms
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_sms_1
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_sms_1`;
CREATE TABLE `sxh_user_sms_1` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '接收短信的手机号码',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '短信类型',
  `code` char(8) NOT NULL DEFAULT '' COMMENT '短信验证码',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发送状态 0-失败 1-成功',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '验证码是否使用过 0-未使用 1-使用',
  `ip_address` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'IP地址',
  `valid_time` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '验证码的有效时间 秒为单位，和create_time作对比',
  `matching_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '专门给匹配通知用，匹配表的ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='保存短信发送记录表';

-- ----------------------------
-- Records of sxh_user_sms_1
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_sms_10
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_sms_10`;
CREATE TABLE `sxh_user_sms_10` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '接收短信的手机号码',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '短信类型',
  `code` char(8) NOT NULL DEFAULT '' COMMENT '短信验证码',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发送状态 0-失败 1-成功',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '验证码是否使用过 0-未使用 1-使用',
  `ip_address` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'IP地址',
  `valid_time` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '验证码的有效时间 秒为单位，和create_time作对比',
  `matching_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '专门给匹配通知用，匹配表的ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='保存短信发送记录表';

-- ----------------------------
-- Records of sxh_user_sms_10
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_sms_2
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_sms_2`;
CREATE TABLE `sxh_user_sms_2` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '接收短信的手机号码',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '短信类型',
  `code` char(8) NOT NULL DEFAULT '' COMMENT '短信验证码',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发送状态 0-失败 1-成功',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '验证码是否使用过 0-未使用 1-使用',
  `ip_address` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'IP地址',
  `valid_time` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '验证码的有效时间 秒为单位，和create_time作对比',
  `matching_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '专门给匹配通知用，匹配表的ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='保存短信发送记录表';

-- ----------------------------
-- Records of sxh_user_sms_2
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_sms_3
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_sms_3`;
CREATE TABLE `sxh_user_sms_3` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '接收短信的手机号码',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '短信类型',
  `code` char(8) NOT NULL DEFAULT '' COMMENT '短信验证码',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发送状态 0-失败 1-成功',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '验证码是否使用过 0-未使用 1-使用',
  `ip_address` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'IP地址',
  `valid_time` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '验证码的有效时间 秒为单位，和create_time作对比',
  `matching_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '专门给匹配通知用，匹配表的ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='保存短信发送记录表';

-- ----------------------------
-- Records of sxh_user_sms_3
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_sms_4
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_sms_4`;
CREATE TABLE `sxh_user_sms_4` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '接收短信的手机号码',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '短信类型',
  `code` char(8) NOT NULL DEFAULT '' COMMENT '短信验证码',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发送状态 0-失败 1-成功',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '验证码是否使用过 0-未使用 1-使用',
  `ip_address` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'IP地址',
  `valid_time` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '验证码的有效时间 秒为单位，和create_time作对比',
  `matching_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '专门给匹配通知用，匹配表的ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='保存短信发送记录表';

-- ----------------------------
-- Records of sxh_user_sms_4
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_sms_5
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_sms_5`;
CREATE TABLE `sxh_user_sms_5` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '接收短信的手机号码',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '短信类型',
  `code` char(8) NOT NULL DEFAULT '' COMMENT '短信验证码',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发送状态 0-失败 1-成功',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '验证码是否使用过 0-未使用 1-使用',
  `ip_address` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'IP地址',
  `valid_time` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '验证码的有效时间 秒为单位，和create_time作对比',
  `matching_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '专门给匹配通知用，匹配表的ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='保存短信发送记录表';

-- ----------------------------
-- Records of sxh_user_sms_5
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_sms_6
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_sms_6`;
CREATE TABLE `sxh_user_sms_6` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '接收短信的手机号码',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '短信类型',
  `code` char(8) NOT NULL DEFAULT '' COMMENT '短信验证码',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发送状态 0-失败 1-成功',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '验证码是否使用过 0-未使用 1-使用',
  `ip_address` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'IP地址',
  `valid_time` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '验证码的有效时间 秒为单位，和create_time作对比',
  `matching_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '专门给匹配通知用，匹配表的ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='保存短信发送记录表';

-- ----------------------------
-- Records of sxh_user_sms_6
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_sms_7
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_sms_7`;
CREATE TABLE `sxh_user_sms_7` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '接收短信的手机号码',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '短信类型',
  `code` char(8) NOT NULL DEFAULT '' COMMENT '短信验证码',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发送状态 0-失败 1-成功',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '验证码是否使用过 0-未使用 1-使用',
  `ip_address` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'IP地址',
  `valid_time` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '验证码的有效时间 秒为单位，和create_time作对比',
  `matching_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '专门给匹配通知用，匹配表的ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='保存短信发送记录表';

-- ----------------------------
-- Records of sxh_user_sms_7
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_sms_8
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_sms_8`;
CREATE TABLE `sxh_user_sms_8` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '接收短信的手机号码',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '短信类型',
  `code` char(8) NOT NULL DEFAULT '' COMMENT '短信验证码',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发送状态 0-失败 1-成功',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '验证码是否使用过 0-未使用 1-使用',
  `ip_address` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'IP地址',
  `valid_time` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '验证码的有效时间 秒为单位，和create_time作对比',
  `matching_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '专门给匹配通知用，匹配表的ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='保存短信发送记录表';

-- ----------------------------
-- Records of sxh_user_sms_8
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_user_sms_9
-- ----------------------------
DROP TABLE IF EXISTS `sxh_user_sms_9`;
CREATE TABLE `sxh_user_sms_9` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '接收短信的手机号码',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '短信类型',
  `code` char(8) NOT NULL DEFAULT '' COMMENT '短信验证码',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发送状态 0-失败 1-成功',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '验证码是否使用过 0-未使用 1-使用',
  `ip_address` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'IP地址',
  `valid_time` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '验证码的有效时间 秒为单位，和create_time作对比',
  `matching_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '专门给匹配通知用，匹配表的ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='保存短信发送记录表';

-- ----------------------------
-- Records of sxh_user_sms_9
-- ----------------------------

-- ----------------------------
-- Table structure for sxh_verify_log_4
-- ----------------------------
DROP TABLE IF EXISTS `sxh_verify_log_4`;
CREATE TABLE `sxh_verify_log_4` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `operator_id` int(10) NOT NULL COMMENT '操作人id',
  `operator_name` char(20) NOT NULL COMMENT '操作人名称',
  `user_id` int(10) NOT NULL COMMENT '被审核用户id',
  `user_name` char(20) NOT NULL COMMENT '被审核用户名称',
  `verify_status` tinyint(3) NOT NULL COMMENT '审核状态 0-未通过审核 1-已通过审核',
  `create_time` int(10) NOT NULL COMMENT '操作时间',
  `remark` char(64) NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sxh_verify_log_4
-- ----------------------------

-- ----------------------------
-- Procedure structure for outgototime
-- ----------------------------
DROP PROCEDURE IF EXISTS `outgototime`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `outgototime`()
BEGIN
	declare _pid int;
	declare _create_time int default 0;
	declare done int;
		
	-- 遍历所有支出表
	DECLARE rs_cursor cursor for select PID,CreateTime  from sxh_user_outgo where Type='出局钱包' and Info='接受资助';
	DECLARE CONTINUE HANDLER for NOT FOUND set done=1;
	open rs_cursor;
	cursor_loop:loop
		fetch rs_cursor into _pid,_create_time;
		if done = 1 THEN
			leave cursor_loop;
		end if;
		update sxh_user_accepthelp set CreateTime = FROM_UNIXTIME(_create_time,'%Y-%m-%d %H:%i:%s'),UpdateTime = FROM_UNIXTIME(_create_time,'%Y-%m-%d %H:%i:%s') where id = _pid;
	end loop cursor_loop;
	close rs_cursor;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `update_user_info_1`;
DELIMITER ;;
CREATE TRIGGER `update_user_info_1` AFTER UPDATE ON `sxh_user_1` FOR EACH ROW BEGIN 
		/**同步更新用户账号**/
		IF new.username != old.username THEN   
			UPDATE `sxh_user_info_1` SET `sxh_user_info_1`.`username` = new.username WHERE `sxh_user_info_1`.`user_id`=old.id;  
		END IF; 
		/**同步更新用户激活状态**/
		IF new.status != old.status THEN
			UPDATE `sxh_user_info_1` SET `sxh_user_info_1`.`status` = new.status WHERE `sxh_user_info_1`.`user_id` = old.id;
		END IF;
		/**同步更新用户审核状态**/
		IF new.verify != old.verify THEN
			UPDATE `sxh_user_info_1` SET `sxh_user_info_1`.`verify` = new.verify WHERE `sxh_user_info_1`.`user_id` = old.id;
		END IF;
	END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `update_user_info_2`;
DELIMITER ;;
CREATE TRIGGER `update_user_info_2` AFTER UPDATE ON `sxh_user_2` FOR EACH ROW BEGIN 
		/**同步更新用户账号**/
		IF new.username != old.username THEN   
			UPDATE `sxh_user_info_2` SET `sxh_user_info_2`.`username` = new.username WHERE `sxh_user_info_2`.`user_id`=old.id;  
		END IF; 
		/**同步更新用户激活状态**/
		IF new.status != old.status THEN
			UPDATE `sxh_user_info_2` SET `sxh_user_info_2`.`status` = new.status WHERE `sxh_user_info_2`.`user_id` = old.id;
		END IF;
		/**同步更新用户审核状态**/
		IF new.verify != old.verify THEN
			UPDATE `sxh_user_info_2` SET `sxh_user_info_2`.`verify` = new.verify WHERE `sxh_user_info_2`.`user_id` = old.id;
		END IF;
	END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `update_user_info_3`;
DELIMITER ;;
CREATE TRIGGER `update_user_info_3` AFTER UPDATE ON `sxh_user_3` FOR EACH ROW BEGIN 
		/**同步更新用户账号**/
		IF new.username != old.username THEN   
			UPDATE `sxh_user_info_3` SET `sxh_user_info_3`.`username` = new.username WHERE `sxh_user_info_3`.`user_id`=old.id;  
		END IF; 
		/**同步更新用户激活状态**/
		IF new.status != old.status THEN
			UPDATE `sxh_user_info_3` SET `sxh_user_info_3`.`status` = new.status WHERE `sxh_user_info_3`.`user_id` = old.id;
		END IF;
		/**同步更新用户审核状态**/
		IF new.verify != old.verify THEN
			UPDATE `sxh_user_info_3` SET `sxh_user_info_3`.`verify` = new.verify WHERE `sxh_user_info_3`.`user_id` = old.id;
		END IF;
	END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `update_user_info_4`;
DELIMITER ;;
CREATE TRIGGER `update_user_info_4` AFTER UPDATE ON `sxh_user_4` FOR EACH ROW BEGIN 
/**同步更新用户账号**/
IF new.username != old.username THEN   
	UPDATE `sxh_user_info_4` SET `sxh_user_info_4`.`username` = new.username WHERE `sxh_user_info_4`.`user_id`=old.id;  
END IF; 
/**同步更新用户激活状态**/
IF new.status != old.status THEN
	UPDATE `sxh_user_info_4` SET `sxh_user_info_4`.`status` = new.status WHERE `sxh_user_info_4`.`user_id` = old.id;
END IF;
/**同步更新用户审核状态**/
IF new.verify != old.verify THEN
	UPDATE `sxh_user_info_4` SET `sxh_user_info_4`.`verify` = new.verify WHERE `sxh_user_info_4`.`user_id` = old.id;
END IF;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `update_user_info_5`;
DELIMITER ;;
CREATE TRIGGER `update_user_info_5` AFTER UPDATE ON `sxh_user_5` FOR EACH ROW BEGIN 
/**同步更新用户账号**/
IF new.username != old.username THEN   
	UPDATE `sxh_user_info_5` SET `sxh_user_info_5`.`username` = new.username WHERE `sxh_user_info_5`.`user_id`=old.id;  
END IF; 
/**同步更新用户激活状态**/
IF new.status != old.status THEN
	UPDATE `sxh_user_info_5` SET `sxh_user_info_5`.`status` = new.status WHERE `sxh_user_info_5`.`user_id` = old.id;
END IF;
/**同步更新用户审核状态**/
IF new.verify != old.verify THEN
	UPDATE `sxh_user_info_5` SET `sxh_user_info_5`.`verify` = new.verify WHERE `sxh_user_info_5`.`user_id` = old.id;
END IF;
END
;;
DELIMITER ;
SET FOREIGN_KEY_CHECKS=1;
