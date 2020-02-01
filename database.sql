/*
SQLyog Enterprise v12.09 (64 bit)
MySQL - 10.4.8-MariaDB : Database - restapi
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`restapi` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `restapi`;

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(30) DEFAULT NULL,
  `product_desc` varchar(255) DEFAULT NULL,
  `image` varchar(30) DEFAULT NULL,
  `stock` int(5) DEFAULT NULL,
  `id_merchant` int(5) DEFAULT NULL,
  `price` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `transaction` */

DROP TABLE IF EXISTS `transaction`;

CREATE TABLE `transaction` (
  `id` varchar(20) NOT NULL,
  `date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_customer` int(5) DEFAULT NULL,
  `id_product` int(5) DEFAULT NULL,
  `qty` int(5) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `id_merchant` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_ibfk_1` (`id_customer`),
  KEY `transaction_ibfk_2` (`id_merchant`),
  KEY `id_product` (`id_product`),
  CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`id_customer`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`id_merchant`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `transaction_ibfk_3` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` int(1) DEFAULT NULL,
  `reward` int(5) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/* Trigger structure for table `transaction` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `CustumerBuy` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `CustumerBuy` AFTER INSERT ON `transaction` FOR EACH ROW BEGIN
	UPDATE product SET stock = stock-new.qty
	WHERE id = new.id_product;
    END */$$


DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
