/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : pemweb_instagram

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-04-14 19:30:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for notifikasi
-- ----------------------------
DROP TABLE IF EXISTS `notifikasi`;
CREATE TABLE `notifikasi` (
  `ID_NOTIFIKASI` char(36) NOT NULL,
  `JUDUL` varchar(100) NOT NULL,
  `PESAN` text NOT NULL,
  `DATE_NOTIFIKASI` datetime NOT NULL,
  PRIMARY KEY (`ID_NOTIFIKASI`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for post
-- ----------------------------
DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `ID_POST` char(36) NOT NULL,
  `DATE_POST` datetime NOT NULL,
  `ID_USER` char(36) NOT NULL,
  `DESCRIPTION` text,
  `IS_AKTIF` smallint(6) NOT NULL,
  PRIMARY KEY (`ID_POST`),
  KEY `IXFK_POST_USER` (`ID_USER`),
  CONSTRAINT `FK_POST_USER` FOREIGN KEY (`ID_USER`) REFERENCES `user` (`ID_USER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for post_comment
-- ----------------------------
DROP TABLE IF EXISTS `post_comment`;
CREATE TABLE `post_comment` (
  `ID_COMMENT` char(36) NOT NULL,
  `ID_POST` char(36) NOT NULL,
  `ID_USER` char(36) NOT NULL,
  `DATE_COMMENT` datetime NOT NULL,
  `COMMENT` text NOT NULL,
  `IS_AKTIF` smallint(6) NOT NULL,
  PRIMARY KEY (`ID_COMMENT`),
  KEY `IXFK_POST_COMMENT_POST` (`ID_POST`),
  KEY `IXFK_POST_COMMENT_USER` (`ID_USER`),
  CONSTRAINT `FK_POST_COMMENT_POST` FOREIGN KEY (`ID_POST`) REFERENCES `post` (`ID_POST`),
  CONSTRAINT `FK_POST_COMMENT_USER` FOREIGN KEY (`ID_USER`) REFERENCES `user` (`ID_USER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for post_like
-- ----------------------------
DROP TABLE IF EXISTS `post_like`;
CREATE TABLE `post_like` (
  `ID_POST` char(36) NOT NULL,
  `ID_USER` char(36) NOT NULL,
  `IS_LIKE` smallint(6) NOT NULL,
  KEY `IXFK_POST_LIKE_POST` (`ID_POST`),
  KEY `IXFK_POST_LIKE_USER` (`ID_USER`),
  CONSTRAINT `FK_POST_LIKE_POST` FOREIGN KEY (`ID_POST`) REFERENCES `post` (`ID_POST`),
  CONSTRAINT `FK_POST_LIKE_USER` FOREIGN KEY (`ID_USER`) REFERENCES `user` (`ID_USER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for post_picture
-- ----------------------------
DROP TABLE IF EXISTS `post_picture`;
CREATE TABLE `post_picture` (
  `ID_POST` char(36) NOT NULL,
  `PATH` varchar(256) NOT NULL,
  KEY `IXFK_POST_PICTURE_POST` (`ID_POST`),
  CONSTRAINT `FK_POST_PICTURE_POST` FOREIGN KEY (`ID_POST`) REFERENCES `post` (`ID_POST`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for post_report
-- ----------------------------
DROP TABLE IF EXISTS `post_report`;
CREATE TABLE `post_report` (
  `ID_REPORT` char(36) NOT NULL,
  `ID_POST` char(36) NOT NULL,
  `ID_USER` char(36) NOT NULL,
  `DATE_REPORT` datetime NOT NULL,
  `PESAN_REPORT` text,
  `IS_READ` smallint(6) NOT NULL,
  PRIMARY KEY (`ID_REPORT`),
  KEY `IXFK_POST_REPORT_POST` (`ID_POST`),
  KEY `IXFK_POST_REPORT_USER` (`ID_USER`),
  CONSTRAINT `FK_POST_REPORT_POST` FOREIGN KEY (`ID_POST`) REFERENCES `post` (`ID_POST`),
  CONSTRAINT `FK_POST_REPORT_USER` FOREIGN KEY (`ID_USER`) REFERENCES `user` (`ID_USER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `ID_USER` char(36) NOT NULL,
  `USERNAME` varchar(25) NOT NULL,
  `EMAIL` varchar(256) NOT NULL,
  `PASSWORD` varchar(256) NOT NULL,
  `FULL_NAME` varchar(256) NOT NULL,
  `USER_PICTURE` varchar(256) DEFAULT NULL,
  `DESCRIPTION` text,
  `LEVEL` smallint(6) NOT NULL,
  `IS_AKTIF` smallint(6) NOT NULL,
  PRIMARY KEY (`ID_USER`),
  UNIQUE KEY `UNIQUE_USERNAME` (`USERNAME`),
  UNIQUE KEY `UNIQUE_EMAIL` (`EMAIL`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for user_follow
-- ----------------------------
DROP TABLE IF EXISTS `user_follow`;
CREATE TABLE `user_follow` (
  `ID_USER` char(36) NOT NULL,
  `ID_USER_FOLLOW` char(36) NOT NULL,
  `FOLLOW_DATE` datetime NOT NULL,
  KEY `IXFK_USER_FOLLOW_USER` (`ID_USER`),
  KEY `IXFK_USER_FOLLOW_USER_02` (`ID_USER_FOLLOW`),
  CONSTRAINT `FK_USER_FOLLOW_USER` FOREIGN KEY (`ID_USER`) REFERENCES `user` (`ID_USER`),
  CONSTRAINT `FK_USER_FOLLOW_USER_02` FOREIGN KEY (`ID_USER_FOLLOW`) REFERENCES `user` (`ID_USER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for user_notifikasi
-- ----------------------------
DROP TABLE IF EXISTS `user_notifikasi`;
CREATE TABLE `user_notifikasi` (
  `ID_USER` char(36) NOT NULL,
  `ID_NOTIFIKASI` char(36) NOT NULL,
  `IS_READ` smallint(6) NOT NULL,
  KEY `IXFK_USER_NOTIFIKASI_NOTIFIKASI` (`ID_NOTIFIKASI`),
  KEY `IXFK_USER_NOTIFIKASI_USER` (`ID_USER`),
  CONSTRAINT `FK_USER_NOTIFIKASI_NOTIFIKASI` FOREIGN KEY (`ID_NOTIFIKASI`) REFERENCES `notifikasi` (`ID_NOTIFIKASI`),
  CONSTRAINT `FK_USER_NOTIFIKASI_USER` FOREIGN KEY (`ID_USER`) REFERENCES `user` (`ID_USER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Function structure for GENERATEID
-- ----------------------------
DROP FUNCTION IF EXISTS `GENERATEID`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `GENERATEID`() RETURNS char(22) CHARSET latin1
BEGIN	
	RETURN REPLACE(UUID(),'-','');
END
;;
DELIMITER ;
