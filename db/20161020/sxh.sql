CREATE TABLE `sxh_sys_user_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` smallint(5) NOT NULL COMMENT '操作用户',
  `type` tinyint(1) NOT NULL COMMENT '标记 0-登录 1-修改 2-添加 3-删除',
  `remark` varchar(64) NOT NULL COMMENT 'log描述',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

