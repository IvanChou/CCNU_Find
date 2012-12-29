/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50528
Source Host           : localhost:3306
Source Database       : ccnu_find

Target Server Type    : MYSQL
Target Server Version : 50528
File Encoding         : 65001

Date: 2012-12-29 17:28:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cf_card`
-- ----------------------------
DROP TABLE IF EXISTS `cf_card`;
CREATE TABLE `cf_card` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `crd_num` int(11) unsigned NOT NULL,
  `crd_name` varchar(20) DEFAULT NULL,
  `crd_part` tinyint(3) unsigned DEFAULT NULL,
  `inf_id` int(6) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_cards_parts` (`crd_part`),
  KEY `FK_cards_infos` (`inf_id`),
  CONSTRAINT `FK_cards_infos` FOREIGN KEY (`inf_id`) REFERENCES `cf_info` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `FK_cards_parts` FOREIGN KEY (`crd_part`) REFERENCES `cf_part` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cf_card
-- ----------------------------

-- ----------------------------
-- Table structure for `cf_comm`
-- ----------------------------
DROP TABLE IF EXISTS `cf_comm`;
CREATE TABLE `cf_comm` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `nick` varchar(20) NOT NULL,
  `stu_num` int(11) unsigned DEFAULT NULL,
  `comment` text NOT NULL,
  `time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_comms_users` (`stu_num`) USING BTREE,
  CONSTRAINT `FK_comms_users` FOREIGN KEY (`stu_num`) REFERENCES `cf_user` (`stu_num`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cf_comm
-- ----------------------------

-- ----------------------------
-- Table structure for `cf_image`
-- ----------------------------
DROP TABLE IF EXISTS `cf_image`;
CREATE TABLE `cf_image` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `inf_id` int(6) unsigned NOT NULL,
  `img_url` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_imgs_infos` (`inf_id`),
  CONSTRAINT `FK_imgs_infos` FOREIGN KEY (`inf_id`) REFERENCES `cf_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cf_image
-- ----------------------------

-- ----------------------------
-- Table structure for `cf_info`
-- ----------------------------
DROP TABLE IF EXISTS `cf_info`;
CREATE TABLE `cf_info` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `stu_num` int(11) unsigned NOT NULL,
  `method` tinyint(2) unsigned NOT NULL COMMENT '1 - 寻物信息; 2 - 招领信息',
  `sort` tinyint(2) unsigned NOT NULL,
  `what` varchar(20) NOT NULL,
  `where` varchar(40) DEFAULT NULL,
  `when` int(11) unsigned DEFAULT NULL,
  `image` varchar(20) DEFAULT NULL COMMENT 'image_id,image_id, ...',
  `detail` text NOT NULL,
  `state` tinyint(2) unsigned NOT NULL COMMENT '0 - 进行中, 1 - 已成功, 9 - 过期',
  `time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_infos_users` (`stu_num`),
  KEY `FK_infos_sorts` (`sort`),
  KEY `when` (`when`),
  KEY `time` (`time`),
  CONSTRAINT `FK_infos_sorts` FOREIGN KEY (`sort`) REFERENCES `cf_sort` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_infos_users` FOREIGN KEY (`stu_num`) REFERENCES `cf_user` (`stu_num`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cf_info
-- ----------------------------

-- ----------------------------
-- Table structure for `cf_part`
-- ----------------------------
DROP TABLE IF EXISTS `cf_part`;
CREATE TABLE `cf_part` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `prt_name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cf_part
-- ----------------------------

-- ----------------------------
-- Table structure for `cf_sort`
-- ----------------------------
DROP TABLE IF EXISTS `cf_sort`;
CREATE TABLE `cf_sort` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `srt_name` varchar(20) NOT NULL,
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
  `stu_num` int(11) unsigned NOT NULL,
  `stu_name` varchar(20) DEFAULT NULL,
  `stu_tel` int(12) unsigned DEFAULT NULL,
  `stu_mail` varchar(30) DEFAULT NULL,
  `stu_qq` int(11) unsigned DEFAULT NULL,
  `stu_addr` varchar(50) DEFAULT NULL,
  `stu_part` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`stu_num`),
  KEY `FK_usres_parts` (`stu_part`),
  CONSTRAINT `FK_usres_parts` FOREIGN KEY (`stu_part`) REFERENCES `cf_part` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cf_user
-- ----------------------------
