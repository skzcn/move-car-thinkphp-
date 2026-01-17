/*
Navicat MySQL Data Transfer

Source Server         : bendi
Source Server Version : 50648
Source Host           : localhost:3306
Source Database       : dd

Target Server Type    : MYSQL
Target Server Version : 50648
File Encoding         : 65001

Date: 2026-01-17 17:58:26
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `nickname` varchar(50) DEFAULT NULL COMMENT '昵称',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1:正常 0:禁用',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uk_username` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='管理员表';

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'admin', '$2y$10$2r6.Xc3/EvmvqUvTiNumz.HkUvXRbzn4BUfLDnwwbyBQKTCVT2suO', '超级管理员', 'admin@example.com', '1', '1700000000', '1700000000');

-- ----------------------------
-- Table structure for ads
-- ----------------------------
DROP TABLE IF EXISTS `ads`;
CREATE TABLE `ads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `sort` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ads
-- ----------------------------
INSERT INTO `ads` VALUES ('1', '11', 'https://27142293.s21i.faiusr.com/4/ABUIABAEGAAgiafKqAYo0JjUsgUwgAo42QM.png', 'https://www.skzcn.com', '1', '0', '1768405979', '1768448032');
INSERT INTO `ads` VALUES ('2', '222', 'https://img.shetu66.com/2023/10/15/1697368610614940.png?x-oss-process=image/resize,h_900/format,webp', 'https://www.skzcn.com', '1', '0', '1768406076', '1768447907');

-- ----------------------------
-- Table structure for move_car_logs
-- ----------------------------
DROP TABLE IF EXISTS `move_car_logs`;
CREATE TABLE `move_car_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '车主ID',
  `message` varchar(255) DEFAULT NULL COMMENT '留言',
  `requester_location` text COMMENT '请求者位置(JSON)',
  `owner_location` text COMMENT '车主位置(JSON)',
  `status` varchar(20) NOT NULL DEFAULT 'waiting' COMMENT '状态: waiting, confirmed',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='挪车记录表';

-- ----------------------------
-- Records of move_car_logs
-- ----------------------------

-- ----------------------------
-- Table structure for notices
-- ----------------------------
DROP TABLE IF EXISTS `notices`;
CREATE TABLE `notices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of notices
-- ----------------------------
INSERT INTO `notices` VALUES ('1', '11', '111', '1768442115');
INSERT INTO `notices` VALUES ('2', 'test', 'test', '1768442414');

-- ----------------------------
-- Table structure for system_config
-- ----------------------------
DROP TABLE IF EXISTS `system_config`;
CREATE TABLE `system_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` text,
  `config_group` varchar(20) DEFAULT 'basic',
  `title` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of system_config
-- ----------------------------
INSERT INTO `system_config` VALUES ('1', 'site_title', 'Move-Car 专业的挪车服务平台', 'basic', '网站标题');
INSERT INTO `system_config` VALUES ('2', 'smtp_host', 'smtp.qq.com', 'email', 'SMTP服务器');
INSERT INTO `system_config` VALUES ('3', 'smtp_port', '465', 'email', 'SMTP端口');
INSERT INTO `system_config` VALUES ('4', 'smtp_user', '', 'email', 'SMTP用户名');
INSERT INTO `system_config` VALUES ('5', 'smtp_pass', '', 'email', 'SMTP密码');
INSERT INTO `system_config` VALUES ('6', 'smtp_from', '', 'email', '发件人邮箱');
INSERT INTO `system_config` VALUES ('7', 'site_keywords', '11', 'basic', '网站关键词');
INSERT INTO `system_config` VALUES ('8', 'site_description', '11', 'basic', '网站描述');
INSERT INTO `system_config` VALUES ('9', 'site_contact', '11', 'basic', '联系方式');
INSERT INTO `system_config` VALUES ('10', 'site_icp', '11', 'basic', 'ICP备案号');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(255) DEFAULT NULL COMMENT '密码(可选)',
  `nickname` varchar(50) DEFAULT NULL COMMENT '昵称/姓名',
  `plate` varchar(20) DEFAULT NULL COMMENT '车牌号',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `bark_url` varchar(255) DEFAULT NULL COMMENT 'Bark通知地址',
  `server_chan_key` varchar(100) DEFAULT NULL COMMENT 'Server酱Key',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1:正常 0:禁用',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uk_username` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='车主表';

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', '1', null, '1', '11', '', null, '', 'SCT130806T7ozf9WqlpzvuJ0fAnmv0Uzr3', '1', '1768400766', '1768401170');
INSERT INTO `users` VALUES ('2', '123', '$2y$12$wGElyjOl/iyDbbQLtumoZe0QnYSxvy1Facu8RA7omVElc.lzzofGK', '', '', '', null, '', '', '1', '1768402880', '1768440694');

-- ----------------------------
-- Table structure for user_notices
-- ----------------------------
DROP TABLE IF EXISTS `user_notices`;
CREATE TABLE `user_notices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `notice_id` int(11) NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `read_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_notice_id` (`notice_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of user_notices
-- ----------------------------
INSERT INTO `user_notices` VALUES ('1', '2', '1', '1', '1768442129');
INSERT INTO `user_notices` VALUES ('2', '2', '2', '1', '1768442420');
