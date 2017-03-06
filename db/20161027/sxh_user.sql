/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : sxh_manage

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-10-27 15:04:30
*/

SET FOREIGN_KEY_CHECKS=0;

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
  `is_withdraw` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否具有接单权限 0-无权限 1-有权限',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login_ip` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录ip',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户登录表';
SET FOREIGN_KEY_CHECKS=1;
