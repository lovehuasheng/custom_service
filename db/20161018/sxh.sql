/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2016-10-18 16:59:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `sxh_sys_group`
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_group`;
CREATE TABLE `sxh_sys_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` char(20) NOT NULL DEFAULT '' COMMENT '用户组名称',
  `permissions` char(200) NOT NULL DEFAULT '' COMMENT '权限列表,多个权限用逗号分隔',
  `pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父级组id',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `remark` char(64) NOT NULL DEFAULT '' COMMENT '组描述',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未禁用 1-已禁用 2-已删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统用户组';

-- ----------------------------
-- Records of sxh_sys_group
-- ----------------------------

-- ----------------------------
-- Table structure for `sxh_sys_menu`
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sxh_sys_menu
-- ----------------------------

-- ----------------------------
-- Table structure for `sxh_sys_permission`
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_permission`;
CREATE TABLE `sxh_sys_permission` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL DEFAULT '' COMMENT '权限名称',
  `operation` char(64) NOT NULL DEFAULT '' COMMENT '对应的操作',
  `group` char(20) NOT NULL DEFAULT '' COMMENT '权限节点分组',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-未禁用 1-已禁用 2-已删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统权限表';

-- ----------------------------
-- Records of sxh_sys_permission
-- ----------------------------

-- ----------------------------
-- Table structure for `sxh_sys_user`
-- ----------------------------
DROP TABLE IF EXISTS `sxh_sys_user`;
CREATE TABLE `sxh_sys_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(20) NOT NULL DEFAULT '' COMMENT '用户登录名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `realname` char(20) NOT NULL DEFAULT '' COMMENT '真实用户名',
  `group_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '所属组id',
  `group_name` char(20) NOT NULL DEFAULT '' COMMENT '组名称',
  `permissions` char(64) NOT NULL DEFAULT '' COMMENT '用户权限,多个权限以逗号分隔',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `email` char(30) NOT NULL DEFAULT '' COMMENT '邮箱',
  `is_super` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否是超级管理员 0-否 1-是',
  `remark` char(64) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0-启用 1-禁用 2-删除',
  `last_login_ip` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录ip',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次登时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统用户表';

-- ----------------------------
-- Records of sxh_sys_user
-- ----------------------------
