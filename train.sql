/*
 Navicat Premium Data Transfer

 Source Server         : 10.10.75.208
 Source Server Type    : MySQL
 Source Server Version : 50547
 Source Host           : 10.10.75.208
 Source Database       : 12306

 Target Server Type    : MySQL
 Target Server Version : 50547
 File Encoding         : utf-8

 Date: 11/10/2016 11:09:12 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `log`
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hid` int(11) NOT NULL,
  `train_no` text NOT NULL,
  `buy_status` int(1) NOT NULL,
  `call_status` int(1) NOT NULL,
  `ctime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `station_code`
-- ----------------------------
DROP TABLE IF EXISTS `station_code`;
CREATE TABLE `station_code` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(3) NOT NULL,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`code`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=2593 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `password` char(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `user_hope`
-- ----------------------------
DROP TABLE IF EXISTS `user_hope`;
CREATE TABLE `user_hope` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `stat_station` varchar(3) NOT NULL,
  `end_station` varchar(3) NOT NULL,
  `go_time` int(11) NOT NULL,
  `train_no` varchar(11) NOT NULL DEFAULT '',
  `seat_type` varchar(11) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
