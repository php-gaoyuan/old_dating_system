/*
SQLyog 企业版 - MySQL GUI v8.14 
MySQL - 5.1.41-community : Database - iweb_sns
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

/*Table structure for table `gift_order` */

DROP TABLE IF EXISTS `gift_order`;

CREATE TABLE `gift_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `send_id` int(10) NOT NULL,
  `accept_id` int(10) NOT NULL,
  `send_name` varchar(20) NOT NULL,
  `accept_name` varchar(20) NOT NULL,
  `msg` text,
  `gift` varchar(100) NOT NULL,
  `is_see` int(1) DEFAULT '0',
  `send_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

/*Data for the table `gift_order` */


/*Table structure for table `gift_user` */

DROP TABLE IF EXISTS `gift_user`;

CREATE TABLE `gift_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `score` int(10) NOT NULL DEFAULT '10'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `gift_user` */


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
