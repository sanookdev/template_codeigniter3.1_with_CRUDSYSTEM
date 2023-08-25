/*
SQLyog Community v13.1.9 (64 bit)
MySQL - 5.7.33 : Database - video_course_sex
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`video_course_sex` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `video_course_sex`;

/*Table structure for table `tb_logs` */

DROP TABLE IF EXISTS `tb_logs`;

CREATE TABLE `tb_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1 = Login , 2 = Logout',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tb_options` */

DROP TABLE IF EXISTS `tb_options`;

CREATE TABLE `tb_options` (
  `website_name` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `sub_name` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `banner_img1` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `banner_img2` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `menu_color` varchar(255) DEFAULT '#17a2b8',
  `background_img_login` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tb_others_banner` */

DROP TABLE IF EXISTS `tb_others_banner`;

CREATE TABLE `tb_others_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_filename` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tb_permission_title` */

DROP TABLE IF EXISTS `tb_permission_title`;

CREATE TABLE `tb_permission_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `title_id` (`title_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tb_permission_title_ibfk_1` FOREIGN KEY (`title_id`) REFERENCES `tb_title` (`id`),
  CONSTRAINT `tb_permission_title_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

/*Table structure for table `tb_title` */

DROP TABLE IF EXISTS `tb_title`;

CREATE TABLE `tb_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1 = public , 2 = unpublic',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) NOT NULL,
  `last_updated` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

/*Table structure for table `tb_user` */

DROP TABLE IF EXISTS `tb_user`;

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(255) DEFAULT NULL,
  `last_updated` datetime DEFAULT CURRENT_TIMESTAMP,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` mediumtext NOT NULL COMMENT 'defauls =  "password"',
  `phone` varchar(11) NOT NULL,
  `user_role` int(1) NOT NULL DEFAULT '2' COMMENT '1 = admin , 2 = user',
  `status_active` int(1) NOT NULL DEFAULT '1' COMMENT '0 = inactive , 1 = active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

/*Table structure for table `tb_videos` */

DROP TABLE IF EXISTS `tb_videos`;

CREATE TABLE `tb_videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1 = public , 0 = unpublic',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) NOT NULL,
  `last_updated` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `title_id` (`title_id`),
  CONSTRAINT `tb_videos_ibfk_1` FOREIGN KEY (`title_id`) REFERENCES `tb_title` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=238 DEFAULT CHARSET=utf8;

/*Table structure for table `tb_videos_tmp` */

DROP TABLE IF EXISTS `tb_videos_tmp`;

CREATE TABLE `tb_videos_tmp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `last_visited` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
