/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50529
Source Host           : localhost:3306
Source Database       : ccnu_find

Target Server Type    : MYSQL
Target Server Version : 50529
File Encoding         : 65001

Date: 2013-01-27 13:16:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cf_card`
-- ----------------------------
DROP TABLE IF EXISTS `cf_card`;
CREATE TABLE `cf_card` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `card_id` int(11) unsigned NOT NULL,
  `card_name` varchar(20) DEFAULT NULL,
  `card_subject` varchar(30) DEFAULT NULL,
  `info_id` int(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `info_id` (`info_id`),
  CONSTRAINT `FK:card_info` FOREIGN KEY (`info_id`) REFERENCES `cf_info` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cf_card
-- ----------------------------

-- ----------------------------
-- Table structure for `cf_fuckccnu`
-- ----------------------------
DROP TABLE IF EXISTS `cf_fuckccnu`;
CREATE TABLE `cf_fuckccnu` (
  `id` bigint(13) unsigned NOT NULL AUTO_INCREMENT,
  `stu_id` int(11) unsigned NOT NULL,
  `stu_real_name` varchar(20) NOT NULL,
  `stu_real_subject` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cf_fuckccnu
-- ----------------------------

-- ----------------------------
-- Table structure for `cf_image`
-- ----------------------------
DROP TABLE IF EXISTS `cf_image`;
CREATE TABLE `cf_image` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `info_id` int(8) unsigned NOT NULL,
  `img_url` varchar(40) NOT NULL,
  `img_thumb` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cf_image
-- ----------------------------

-- ----------------------------
-- Table structure for `cf_info`
-- ----------------------------
DROP TABLE IF EXISTS `cf_info`;
CREATE TABLE `cf_info` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `stu_id` int(11) unsigned NOT NULL,
  `type` tinyint(2) unsigned NOT NULL COMMENT '1 - 寻物信息; 2 - 招领信息',
  `sort` tinyint(2) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `place` varchar(40) DEFAULT NULL,
  `date` int(11) unsigned DEFAULT NULL,
  `image` int(6) unsigned DEFAULT NULL,
  `detail` text NOT NULL,
  `state` tinyint(2) NOT NULL COMMENT '0 - 进行中, 1 - 已成功, -1 - 过期',
  `time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK:info_img` (`image`),
  KEY `FK:info_user` (`stu_id`),
  KEY `FK:info_sort` (`sort`),
  CONSTRAINT `FK:info_img` FOREIGN KEY (`image`) REFERENCES `cf_image` (`id`),
  CONSTRAINT `FK:info_sort` FOREIGN KEY (`sort`) REFERENCES `cf_sort` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK:info_user` FOREIGN KEY (`stu_id`) REFERENCES `cf_user` (`stu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cf_info
-- ----------------------------

-- ----------------------------
-- Table structure for `cf_sort`
-- ----------------------------
DROP TABLE IF EXISTS `cf_sort`;
CREATE TABLE `cf_sort` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `sort_name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cf_sort
-- ----------------------------

-- ----------------------------
-- Table structure for `cf_user`
-- ----------------------------
DROP TABLE IF EXISTS `cf_user`;
CREATE TABLE `cf_user` (
  `stu_id` int(11) unsigned NOT NULL,
  `stu_name` varchar(20) DEFAULT NULL,
  `stu_tel` int(12) unsigned DEFAULT NULL,
  `stu_mail` varchar(30) DEFAULT NULL,
  `stu_qq` int(11) unsigned DEFAULT NULL,
  `stu_addr` varchar(50) DEFAULT NULL,
  `stu_said` varchar(140) NOT NULL,
  PRIMARY KEY (`stu_id`),
  KEY `FK_usres_parts` (`stu_said`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cf_user
-- ----------------------------
