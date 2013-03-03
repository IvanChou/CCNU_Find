/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Version : 50527
 Source Host           : localhost
 Source Database       : ccnu_find

 Target Server Version : 50527
 File Encoding         : utf-8

 Date: 03/03/2013 23:13:42 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `cf_card`
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `cf_card`
-- ----------------------------
BEGIN;
INSERT INTO `cf_card` VALUES ('1', '2009213640', '胡正', '物化', '3');
COMMIT;

-- ----------------------------
--  Table structure for `cf_fuckccnu`
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
--  Table structure for `cf_image`
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
--  Table structure for `cf_info`
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
  `info` text,
  `state` tinyint(2) NOT NULL COMMENT '0 - 进行中, 1 - 已成功, -1 - 过期',
  `time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK:info_img` (`image`),
  KEY `FK:info_user` (`stu_id`),
  KEY `FK:info_sort` (`sort`),
  CONSTRAINT `FK:info_img` FOREIGN KEY (`image`) REFERENCES `cf_image` (`id`),
  CONSTRAINT `FK:info_sort` FOREIGN KEY (`sort`) REFERENCES `cf_sort` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK:info_user` FOREIGN KEY (`stu_id`) REFERENCES `cf_user` (`stu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `cf_info`
-- ----------------------------
BEGIN;
INSERT INTO `cf_info` VALUES ('2', '2009213663', '2', '5', '火腿肠 黑色 G9', '东八208附近', '1368227611', null, '没什么好说的 可能是被偷了', '0', '1361081787'), ('3', '2009213663', '1', '1', '2009213640', '图书馆9楼 咖啡厅', '1361081787', null, '', '0', '1361081787'), ('4', '2009213663', '2', '3', '白色金立手机带黑保护套', '行政楼副楼二楼', '1368227611', null, '白色触屏智能手机，型号为金立GN106，八成新，外有黑色保护套，里面没有插SIM卡，壁纸为蓝天下的鹅，存有100多个联系人，大量的课件，对我很重要，希望拾到者与我联系，本人将不胜感激!', '0', '1361081787'), ('5', '2009213663', '1', '5', '火腿肠 黑色 G9', '东八208附近', '1368227611', null, '一不小心就捡到了 运气背到家了 谁的？ 来领吧', '0', '1361081787'), ('6', '2009213663', '1', '5', '火腿肠 黑色 G10', '东八209附近', '1368227611', null, '没什么好说的 可能是又被偷了', '0', '1361081787');
COMMIT;

-- ----------------------------
--  Table structure for `cf_sort`
-- ----------------------------
DROP TABLE IF EXISTS `cf_sort`;
CREATE TABLE `cf_sort` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `sort_name` varchar(20) NOT NULL,
  `sort_code` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `cf_sort`
-- ----------------------------
BEGIN;
INSERT INTO `cf_sort` VALUES ('1', '一卡通', 'ykt'), ('2', '书籍资料', 'books'), ('3', '衣服饰品', 'apparels'), ('4', '随身物品', 'belongs'), ('5', '电子数码', 'electronics'), ('6', '卡类证件', 'cards'), ('7', '其他物品', 'others');
COMMIT;

-- ----------------------------
--  Table structure for `cf_user`
-- ----------------------------
DROP TABLE IF EXISTS `cf_user`;
CREATE TABLE `cf_user` (
  `stu_id` int(11) unsigned NOT NULL,
  `stu_name` varchar(20) DEFAULT NULL,
  `stu_tel` bigint(14) unsigned DEFAULT NULL,
  `stu_mail` varchar(30) DEFAULT NULL,
  `stu_qq` int(11) unsigned DEFAULT NULL,
  `stu_addr` varchar(50) DEFAULT NULL,
  `stu_said` varchar(140) NOT NULL,
  PRIMARY KEY (`stu_id`),
  KEY `FK_usres_parts` (`stu_said`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `cf_user`
-- ----------------------------
BEGIN;
INSERT INTO `cf_user` VALUES ('2009213663', '周一', '13114375536', 'xworm@xworm.net', '645655198', null, '');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
