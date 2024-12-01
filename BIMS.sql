/*
SQLyog Ultimate
MySQL - 5.7.44-log : Database - bims
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bims` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `bims`;

/*Table structure for table `brgy_details` */

DROP TABLE IF EXISTS `brgy_details`;

CREATE TABLE `brgy_details` (
  `brgy_details_id` int(55) NOT NULL AUTO_INCREMENT,
  `brgy_name` varchar(55) DEFAULT NULL,
  `sona` varchar(55) DEFAULT NULL,
  `district` varchar(55) DEFAULT NULL,
  `tel_num` varchar(55) DEFAULT NULL,
  `cp_num` varchar(55) DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  `address` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`brgy_details_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `brgy_details` */

insert  into `brgy_details`(`brgy_details_id`,`brgy_name`,`sona`,`district`,`tel_num`,`cp_num`,`email`,`address`) values 
(1,'Barangay 177','Sona 15','Distrito 1','8364-7073','0999-4031692','177Barangay@gmail.com','Cielito Homes Subd., Camarin, Lungsod ng Caloocan, M.M.');

/*Table structure for table `brgy_officials` */

DROP TABLE IF EXISTS `brgy_officials`;

CREATE TABLE `brgy_officials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `official_name` varchar(255) NOT NULL,
  `official_position` varchar(55) NOT NULL,
  `date_last_edited` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `official_position` (`official_position`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `brgy_officials` */

insert  into `brgy_officials`(`id`,`official_name`,`official_position`,`date_last_edited`) values 
(1,'Donna De Gana-Jarito','Punong Barangay','2024-08-18'),
(2,'Vince B. Salvani','SK Chairperson','2024-04-30'),
(3,'Loida M. Francisco','Barangay Secretary','2024-04-30'),
(4,'Dave A. Ramirez','Barangay Treasurer','2024-05-23');

/*Table structure for table `certificate-img` */

DROP TABLE IF EXISTS `certificate-img`;

CREATE TABLE `certificate-img` (
  `img_id` int(12) NOT NULL AUTO_INCREMENT,
  `purpose` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  PRIMARY KEY (`img_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `certificate-img` */

insert  into `certificate-img`(`img_id`,`purpose`,`filename`) values 
(1,'Government Logo','BagongPinas.png'),
(2,'City Logo','CaloocanCityLogo.png'),
(3,'Barangay Title','Brgy177Logo.png'),
(4,'Barangay Logo','Brgy177.png'),
(5,'Watermark','watermark.png'),
(6,'Barangay Title2','Brgy177(2).png');

/*Table structure for table `departments_list` */

DROP TABLE IF EXISTS `departments_list`;

CREATE TABLE `departments_list` (
  `department_id` int(50) NOT NULL AUTO_INCREMENT,
  `department_desc` varchar(50) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `departments_list` */

insert  into `departments_list`(`department_id`,`department_desc`) values 
(1,'Clearance Dept'),
(2,'Secretariant Dept'),
(3,'Lupon'),
(4,'Admin');

/*Table structure for table `kagawad` */

DROP TABLE IF EXISTS `kagawad`;

CREATE TABLE `kagawad` (
  `kagawad_id` int(55) NOT NULL AUTO_INCREMENT,
  `official_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`kagawad_id`),
  KEY `kagawad_id` (`kagawad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `kagawad` */

insert  into `kagawad`(`kagawad_id`,`official_name`) values 
(1,'Darwin Dela Cruz'),
(2,'Eloisa Marie T. Encarnation'),
(3,'Gina T. Ortiz'),
(4,'Francis S. Acosta'),
(5,'Renato C. Busante'),
(6,'Christy Joy V. Calilung'),
(7,'Loreto D. Derrada');

/*Table structure for table `login_attempts` */

DROP TABLE IF EXISTS `login_attempts`;

CREATE TABLE `login_attempts` (
  `id` int(55) NOT NULL AUTO_INCREMENT,
  `ip_add` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `failed_attempts` int(11) NOT NULL DEFAULT '0',
  `lockout_until` timestamp NULL DEFAULT NULL,
  `last_attempt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `username_no` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `login_attempts` */

/*Table structure for table `non_resident` */

DROP TABLE IF EXISTS `non_resident`;

CREATE TABLE `non_resident` (
  `nresident_id` int(55) NOT NULL AUTO_INCREMENT,
  `img_filename` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `house_num` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `subdivision` varchar(255) DEFAULT NULL,
  `district_brgy` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) DEFAULT NULL,
  `zipcode` varchar(255) DEFAULT NULL,
  `sex` varchar(55) NOT NULL,
  `marital_status` varchar(255) DEFAULT NULL,
  `birth_place` varchar(255) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `cellphone_num` varchar(50) NOT NULL,
  `audit_trail_no` int(55) DEFAULT NULL,
  `is_deleted` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`nresident_id`),
  KEY `nres_audit_trail` (`audit_trail_no`),
  CONSTRAINT `nres_audit_trail` FOREIGN KEY (`audit_trail_no`) REFERENCES `nonres_audit_trail` (`audit_trail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `non_resident` */

insert  into `non_resident`(`nresident_id`,`img_filename`,`last_name`,`first_name`,`middle_name`,`suffix`,`house_num`,`street`,`subdivision`,`district_brgy`,`city`,`province`,`zipcode`,`sex`,`marital_status`,`birth_place`,`birth_date`,`cellphone_num`,`audit_trail_no`,`is_deleted`) values 
(1,'Picture_043__1__v_1706525302.jpg','Rabanes','Fernan','Jarito','','Blk 9 Lot 3','Kamatis st','Ramirez Subd','Novaliches','Quezon City','Metro Manila','1423','Male','Single','Tuguegarao','1998-06-16','090956565454',1,0),
(2,'capture_1732500165.jpg','Lim','Nicholas','Mahestro','','12','Zapote Rd','Cielito Homes','Camarin Brgy 175','Caloocan City','Metro Manila','1423','Male','Single','San Nicolas Pangasinan','1998-09-29','0966565666544',2,0),
(3,'2f070627687d52995cfabf5c1bbde057.jpg','Lim','Mario','Jaen','III','Blk 12 Lot 4','Hillcrest st','Rolling Stone Subd','Novaliches','Quezon City','Metro Manila','1420','Male','Married','Madella Quirino','1990-05-02','090913457854',3,0),
(4,'capture_1732002496.jpg','Chavez','Celestina','Mariano','','Blk 12 Lot 13','Josephine st','La Forteza Subd','Camarin','Caloocan City','Metro Manila','1432','Female','Married','Lipa Batangas','2024-10-16','09064545125',4,1),
(5,'capture_1732338783.jpg','La Torre','Nicholas','Trinidad','III','Blk 12 Lot 13','Davao st','Kingdom subd','Novaliches','Quezon City','Metro Manila','1411','Male','Married','Davao City','2000-01-01','090541236585',5,0),
(6,'shanna (1).jpg','Saksi','Shanna','Jiamin','','Blk 1 Lot 12','St Bernard st','La Forteza','Camarin Brgy 175','La Forteza','Metro Manila','1424','Female','Married','Bagabag Nueva Viscaya','1990-06-12','09054321268',6,0),
(7,'capture_1732713130.jpg','San Viciente','Carlos','Mateo','','Blk 12 Lot 14','Aluling st','Francisco Homes','Brgy Mulawin','City of San Jose Del Monte','Bulacan','1143','Male','Single','Cabiao Nueva Ecjia','2024-11-12','0957878787878788',7,0),
(8,'capture_1731783811.jpg','Santos','Kian','Salvador','','Phase 12 Pkg 9','San Jacinto','-','Bagong Silang','Caloocan City','Metro Manila','1422','Male','Single','San Juan Batangas','1997-06-10','00000000000',8,0),
(9,'capture_1731783837.jpg','Santos','Hugo','Salvador','','Phase 12 Pkg 9','San Jacinto','-','Bagong Silang','Caloocan City','Metro Manila','1422','Male','Single','San Juan Batangas','1997-06-10','00000000000',9,0),
(10,'capture_1731783858.jpg','Santos','Mariano','Salvador','','Phase 12 Pkg 9','San Jacinto','-','Bagong Silang','Caloocan City','Metro Manila','1422','Male','Single','San Juan Batangas','1997-06-10','00000000000',10,0),
(11,'capture_1731783875.jpg','Santos','Jacob','Salvador','','Phase 12 Pkg 9','San Jacinto','-','Bagong Silang','Caloocan City','Metro Manila','1422','Male','Single','San Juan Batangas','1997-06-10','00000000000',11,0),
(12,'capture_1732003889.jpg','Joselito','Robert','Kaledo','','Phase 2 Lot 9','Miriam Defensor Santiago st','Justice Subd','Deparo','Caloocan City','Metro Manila','1148','Male','Married','Valenzuela City','1983-10-12','094585656566',12,0),
(15,'capture_1732426183.jpg','Nograles','James','Balete','','Blk 13 Lot 3 Unit 7','Navaro st','Kiko Subd','Brgy 178 Camarin','Caloocan City','Metor Manila','1123','Male','Single','San Jose Del Monte Bulacan','2000-02-02','09064545655',13,0),
(16,'capture_1732527187.jpg','Timothy','Timmy','Gardo','','15 Zabarte blg','Zabarte Rd','Mary Homes','Brgy 172','Caloocan City','Metro Manila','1122','Male','Single','Candaba Pampanga','2024-01-01','094454545454',14,0);

/*Table structure for table `nonres_audit_trail` */

DROP TABLE IF EXISTS `nonres_audit_trail`;

CREATE TABLE `nonres_audit_trail` (
  `audit_trail_id` int(55) NOT NULL AUTO_INCREMENT,
  `dept_added_no` int(55) DEFAULT NULL,
  `user_added_no` int(55) DEFAULT NULL,
  `datetime_added` datetime DEFAULT NULL,
  `dept_edited_no` int(55) DEFAULT NULL,
  `user_edited_no` int(55) DEFAULT NULL,
  `last_edited_dt` datetime DEFAULT NULL,
  `dept_deleted_no` int(55) DEFAULT NULL,
  `user_deleted_no` int(55) DEFAULT NULL,
  `last_deleted_dt` datetime DEFAULT NULL,
  `dept_recovered_no` int(55) DEFAULT NULL,
  `user_recovered_no` int(55) DEFAULT NULL,
  `last_recovered_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`audit_trail_id`),
  KEY `nres_user_fk` (`user_added_no`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `nonres_audit_trail` */

insert  into `nonres_audit_trail`(`audit_trail_id`,`dept_added_no`,`user_added_no`,`datetime_added`,`dept_edited_no`,`user_edited_no`,`last_edited_dt`,`dept_deleted_no`,`user_deleted_no`,`last_deleted_dt`,`dept_recovered_no`,`user_recovered_no`,`last_recovered_dt`) values 
(1,NULL,NULL,'2024-09-04 10:12:00',NULL,NULL,'2024-11-18 08:11:35',NULL,NULL,'2024-11-17 02:52:47',NULL,NULL,'2024-11-17 02:58:12'),
(2,NULL,NULL,'2024-09-24 18:32:14',4,1,'2024-11-25 10:02:45',NULL,NULL,'2024-11-17 02:52:52',NULL,NULL,'2024-11-17 02:58:10'),
(3,NULL,NULL,'2024-10-03 00:48:06',NULL,NULL,'2024-10-03 01:46:56',NULL,NULL,'2024-11-17 02:52:50',NULL,NULL,'2024-11-17 02:58:08'),
(4,NULL,NULL,'2024-10-03 00:48:33',NULL,NULL,'2024-11-19 15:48:16',4,1,'2024-11-30 21:03:09',4,1,'2024-11-30 21:00:01'),
(5,NULL,NULL,'2024-10-03 00:59:05',NULL,NULL,'2024-11-23 13:13:03',NULL,NULL,'2024-11-17 02:52:55',NULL,NULL,'2024-11-17 02:58:02'),
(6,NULL,NULL,'2024-10-03 00:59:35',NULL,NULL,'2024-10-24 15:09:48',NULL,NULL,'2024-11-17 02:52:45',NULL,NULL,'2024-11-17 02:58:00'),
(7,NULL,NULL,'2024-10-03 01:02:24',4,1,'2024-11-27 21:12:10',NULL,NULL,NULL,NULL,NULL,NULL),
(8,NULL,NULL,'2024-11-17 03:30:56',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(9,NULL,NULL,'2024-11-17 03:30:59',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(10,NULL,NULL,'2024-11-17 03:31:03',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(11,NULL,NULL,'2024-11-17 03:31:08',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(12,NULL,NULL,'2024-11-19 15:31:03',2,4,'2024-11-30 20:54:10',4,1,'2024-11-27 21:15:05',4,1,'2024-11-27 21:15:14'),
(13,4,1,'2024-11-24 13:29:43',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(14,4,1,'2024-11-25 17:33:07',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `nonresident_audit` */

DROP TABLE IF EXISTS `nonresident_audit`;

CREATE TABLE `nonresident_audit` (
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `nresident_id` int(11) NOT NULL,
  `action_type` enum('INSERT','UPDATE','DELETE','RECOVER') NOT NULL,
  `action_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_no` int(11) NOT NULL,
  `dept_no` int(11) DEFAULT NULL,
  `is_deleted` tinyint(2) DEFAULT '0',
  `last_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `action_data` json DEFAULT NULL,
  PRIMARY KEY (`audit_id`),
  KEY `user_no` (`user_no`),
  KEY `dept_no` (`dept_no`),
  CONSTRAINT `nonresident_audit_ibfk_1` FOREIGN KEY (`user_no`) REFERENCES `tbl_username` (`username_id`),
  CONSTRAINT `nonresident_audit_ibfk_2` FOREIGN KEY (`dept_no`) REFERENCES `departments_list` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `nonresident_audit` */

insert  into `nonresident_audit`(`audit_id`,`nresident_id`,`action_type`,`action_timestamp`,`user_no`,`dept_no`,`is_deleted`,`last_name`,`first_name`,`action_data`) values 
(1,12,'UPDATE','2024-11-29 23:08:35',1,4,0,'Joselito','Robert','{\"new_values\": {\"sex\": \"Female\", \"city\": \"Caloocan City\", \"street\": \"Miriam Defensor Santiago st\", \"suffix\": \"\", \"zipcode\": \"1148\", \"province\": \"Metro Manila\", \"house_num\": \"Phase 2 Lot 9\", \"last_name\": \"Joselito\", \"birth_date\": \"1983-10-12\", \"first_name\": \"Robert\", \"birth_place\": \"Valenzuela City\", \"middle_name\": \"Kaledo\", \"subdivision\": \"Justice Subd\", \"img_filename\": \"capture_1732003889.jpg\", \"cellphone_num\": \"094585656566\", \"district_brgy\": \"Deparo\", \"marital_status\": \"Single\"}, \"old_values\": {\"sex\": \"Female\", \"city\": \"Caloocan City\", \"street\": \"Miriam Defensor Santiago st\", \"suffix\": \"\", \"zipcode\": \"1148\", \"province\": \"Metro Manila\", \"house_num\": \"Phase 2 Lot 9\", \"last_name\": \"Joselito\", \"birth_date\": \"1983-10-12\", \"first_name\": \"Robert\", \"birth_place\": \"Navotas City\", \"middle_name\": \"Kaledo\", \"subdivision\": \"Justice Subd\", \"img_filename\": \"capture_1732003889.jpg\", \"cellphone_num\": \"094585656566\", \"district_brgy\": \"Deparo\", \"marital_status\": \"Single\"}}'),
(2,12,'UPDATE','2024-11-30 20:54:10',4,2,0,'Joselito','Robert','{\"new_values\": {\"sex\": \"Male\", \"city\": \"Caloocan City\", \"street\": \"Miriam Defensor Santiago st\", \"suffix\": \"\", \"zipcode\": \"1148\", \"province\": \"Metro Manila\", \"house_num\": \"Phase 2 Lot 9\", \"last_name\": \"Joselito\", \"birth_date\": \"1983-10-12\", \"first_name\": \"Robert\", \"birth_place\": \"Valenzuela City\", \"middle_name\": \"Kaledo\", \"subdivision\": \"Justice Subd\", \"img_filename\": \"capture_1732003889.jpg\", \"cellphone_num\": \"094585656566\", \"district_brgy\": \"Deparo\", \"marital_status\": \"Married\"}, \"old_values\": {\"sex\": \"Female\", \"city\": \"Caloocan City\", \"street\": \"Miriam Defensor Santiago st\", \"suffix\": \"\", \"zipcode\": \"1148\", \"province\": \"Metro Manila\", \"house_num\": \"Phase 2 Lot 9\", \"last_name\": \"Joselito\", \"birth_date\": \"1983-10-12\", \"first_name\": \"Robert\", \"is_deleted\": 0, \"birth_place\": \"Valenzuela City\", \"middle_name\": \"Kaledo\", \"subdivision\": \"Justice Subd\", \"img_filename\": \"capture_1732003889.jpg\", \"cellphone_num\": \"094585656566\", \"district_brgy\": \"Deparo\", \"marital_status\": \"Single\"}}'),
(3,4,'RECOVER','2024-11-30 21:00:01',1,4,0,'Chavez','Celestina','{\"new_values\": {\"sex\": \"Female\", \"city\": \"Caloocan City\", \"street\": \"Josephine st\", \"suffix\": \"\", \"zipcode\": \"1432\", \"province\": \"Metro Manila\", \"house_num\": \"Blk 12 Lot 13\", \"last_name\": \"Chavez\", \"birth_date\": \"2024-10-16\", \"first_name\": \"Celestina\", \"is_deleted\": 0, \"birth_place\": \"Lipa Batangas\", \"middle_name\": \"Mariano\", \"subdivision\": \"La Forteza Subd\", \"img_filename\": \"capture_1732002496.jpg\", \"cellphone_num\": \"09064545125\", \"district_brgy\": \"Camarin\", \"marital_status\": \"Married\"}, \"old_values\": {\"is_deleted\": 1}}'),
(4,4,'DELETE','2024-11-30 21:03:09',1,4,1,'Chavez','Celestina','{\"new_values\": {\"sex\": \"Female\", \"city\": \"Caloocan City\", \"street\": \"Josephine st\", \"suffix\": \"\", \"zipcode\": \"1432\", \"province\": \"Metro Manila\", \"house_num\": \"Blk 12 Lot 13\", \"last_name\": \"Chavez\", \"birth_date\": \"2024-10-16\", \"first_name\": \"Celestina\", \"is_deleted\": 1, \"birth_place\": \"Lipa Batangas\", \"middle_name\": \"Mariano\", \"subdivision\": \"La Forteza Subd\", \"img_filename\": \"capture_1732002496.jpg\", \"cellphone_num\": \"09064545125\", \"district_brgy\": \"Camarin\", \"marital_status\": \"Married\"}, \"old_values\": {\"is_deleted\": 0}}');

/*Table structure for table `res_audit_trail` */

DROP TABLE IF EXISTS `res_audit_trail`;

CREATE TABLE `res_audit_trail` (
  `res_at_id` int(55) NOT NULL AUTO_INCREMENT,
  `added_depart_no` int(55) DEFAULT NULL,
  `added_by_no` int(55) DEFAULT NULL,
  `added_dt` datetime DEFAULT CURRENT_TIMESTAMP,
  `edited_depart_no` int(55) DEFAULT NULL,
  `last_edited_by` int(55) DEFAULT NULL,
  `last_edited_dt` datetime DEFAULT NULL,
  `dept_del_no` int(55) DEFAULT NULL,
  `del_by_no` int(55) DEFAULT NULL,
  `del_dt` datetime DEFAULT NULL,
  `dept_rec_no` int(55) DEFAULT NULL,
  `rec_by_no` int(55) DEFAULT NULL,
  `rec_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`res_at_id`),
  KEY `res_depart_fk` (`added_depart_no`),
  KEY `res_addedby_fk` (`added_by_no`),
  KEY `res_edited_by` (`last_edited_by`),
  CONSTRAINT `res_addedby_fk` FOREIGN KEY (`added_by_no`) REFERENCES `tbl_username` (`username_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `res_depart_fk` FOREIGN KEY (`added_depart_no`) REFERENCES `departments_list` (`department_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `res_edited_by` FOREIGN KEY (`last_edited_by`) REFERENCES `tbl_username` (`username_id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4;

/*Data for the table `res_audit_trail` */

insert  into `res_audit_trail`(`res_at_id`,`added_depart_no`,`added_by_no`,`added_dt`,`edited_depart_no`,`last_edited_by`,`last_edited_dt`,`dept_del_no`,`del_by_no`,`del_dt`,`dept_rec_no`,`rec_by_no`,`rec_dt`) values 
(1,NULL,NULL,'2024-11-17 03:58:41',NULL,NULL,'2024-11-17 04:00:10',NULL,NULL,'2024-11-17 04:00:24',NULL,NULL,'2024-11-17 04:00:40'),
(2,NULL,NULL,'2024-11-17 03:58:41',NULL,NULL,'2024-11-17 04:00:10',NULL,NULL,'2024-11-17 04:00:24',NULL,NULL,'2024-11-17 04:00:40'),
(3,NULL,NULL,'2024-11-17 03:58:41',NULL,NULL,'2024-11-17 04:00:10',NULL,NULL,'2024-11-17 04:00:24',NULL,NULL,'2024-11-19 02:40:51'),
(4,NULL,NULL,'2024-11-17 03:58:41',NULL,NULL,'2024-11-17 04:00:10',NULL,NULL,'2024-11-17 04:00:24',NULL,NULL,'2024-11-17 04:00:40'),
(5,NULL,NULL,'2024-11-17 03:58:41',NULL,NULL,'2024-11-17 04:00:10',NULL,NULL,'2024-11-17 04:00:24',NULL,NULL,'2024-11-17 04:00:40'),
(6,NULL,NULL,'2024-11-17 03:58:41',NULL,NULL,'2024-11-17 04:00:10',NULL,NULL,'2024-11-17 04:00:24',NULL,NULL,'2024-11-18 21:41:45'),
(8,NULL,NULL,'2024-11-17 03:58:41',NULL,NULL,'2024-11-17 04:00:10',NULL,NULL,'2024-11-17 04:00:24',NULL,NULL,'2024-11-17 04:00:40'),
(9,NULL,NULL,'2024-11-17 03:58:41',NULL,NULL,'2024-11-17 04:00:10',NULL,NULL,'2024-11-17 04:00:24',NULL,NULL,'2024-11-17 04:00:40'),
(10,NULL,NULL,'2024-11-17 03:58:41',NULL,NULL,'2024-11-17 04:00:10',NULL,NULL,'2024-11-17 04:00:24',NULL,NULL,'2024-11-17 04:00:40'),
(11,NULL,NULL,'2024-11-17 03:58:41',NULL,NULL,'2024-11-17 04:00:10',NULL,NULL,'2024-11-17 04:00:24',NULL,NULL,'2024-11-17 04:00:40'),
(12,NULL,NULL,'2024-11-17 03:58:41',NULL,NULL,'2024-11-18 01:43:20',NULL,NULL,'2024-11-17 04:00:24',NULL,NULL,'2024-11-17 04:00:40'),
(13,NULL,NULL,'2024-11-17 03:58:41',NULL,NULL,'2024-11-17 04:00:10',NULL,NULL,'2024-11-17 04:00:24',4,1,'2024-11-30 12:19:10'),
(14,NULL,NULL,'2024-11-17 03:58:41',NULL,NULL,'2024-11-17 04:00:10',NULL,NULL,'2024-11-18 21:18:53',NULL,NULL,'2024-11-17 04:00:40'),
(15,NULL,NULL,'2024-11-17 03:58:41',NULL,NULL,'2024-11-18 09:05:38',NULL,NULL,'2024-11-18 13:02:21',NULL,NULL,'2024-11-17 04:00:40'),
(16,NULL,NULL,'2024-11-17 03:58:41',4,1,'2024-11-23 15:43:12',NULL,NULL,'2024-11-17 04:00:24',NULL,NULL,'2024-11-17 04:00:40'),
(17,NULL,NULL,'2024-11-17 03:58:41',NULL,NULL,'2024-11-17 04:00:10',NULL,NULL,'2024-11-17 04:00:24',NULL,NULL,'2024-11-17 04:00:40'),
(18,NULL,NULL,'2024-11-17 03:58:41',NULL,NULL,'2024-11-17 04:00:10',NULL,NULL,'2024-11-17 04:00:24',NULL,NULL,'2024-11-17 04:00:40'),
(19,NULL,NULL,'2024-11-17 03:58:41',NULL,NULL,'2024-11-17 04:00:10',NULL,NULL,'2024-11-17 04:00:24',NULL,NULL,'2024-11-17 04:00:40'),
(20,NULL,NULL,'2024-11-17 03:58:41',4,1,'2024-11-23 15:44:45',NULL,NULL,'2024-11-17 04:00:24',NULL,NULL,'2024-11-17 04:00:40'),
(21,NULL,NULL,'2024-11-18 15:32:27',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(22,NULL,NULL,'2024-11-18 15:35:30',4,1,'2024-11-23 02:40:02',NULL,NULL,NULL,NULL,NULL,NULL),
(23,NULL,NULL,'2024-11-18 17:07:33',NULL,NULL,NULL,4,1,'2024-11-24 19:22:34',NULL,NULL,NULL),
(24,NULL,NULL,'2024-11-18 17:22:26',NULL,NULL,NULL,4,1,'2024-11-24 19:22:18',NULL,NULL,NULL),
(25,NULL,NULL,'2024-11-18 22:06:04',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(26,NULL,NULL,'2024-11-18 22:08:14',NULL,NULL,'2024-11-18 22:25:56',NULL,NULL,NULL,NULL,NULL,NULL),
(27,NULL,NULL,'2024-11-18 22:10:42',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(28,NULL,NULL,'2024-11-18 22:22:01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(29,NULL,NULL,'2024-11-18 23:40:19',4,1,'2024-11-23 10:14:08',4,1,'2024-11-23 10:27:30',NULL,NULL,'2024-11-19 15:56:22'),
(30,NULL,NULL,'2024-11-18 23:43:49',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(31,NULL,NULL,'2024-11-19 01:11:25',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(32,NULL,NULL,'2024-11-19 01:18:53',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(33,NULL,NULL,'2024-11-19 01:34:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(34,NULL,NULL,'2024-11-19 01:36:49',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(35,NULL,NULL,'2024-11-19 01:40:49',4,1,'2024-11-24 00:06:43',NULL,NULL,NULL,NULL,NULL,NULL),
(36,NULL,NULL,'2024-11-19 01:41:02',4,1,'2024-11-23 15:40:54',NULL,NULL,NULL,NULL,NULL,NULL),
(37,NULL,NULL,'2024-11-19 01:43:02',4,1,'2024-11-23 15:10:57',NULL,NULL,NULL,NULL,NULL,NULL),
(38,NULL,NULL,'2024-11-19 01:43:14',4,1,'2024-11-23 02:35:40',NULL,NULL,NULL,NULL,NULL,NULL),
(39,NULL,NULL,'2024-11-19 01:57:04',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(40,NULL,NULL,'2024-11-19 04:37:49',NULL,NULL,NULL,4,1,'2024-11-24 19:29:21',NULL,NULL,NULL),
(41,NULL,NULL,'2024-11-19 14:47:38',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(42,4,1,'2024-11-23 14:50:25',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(43,4,1,'2024-11-24 04:02:53',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(44,4,1,'2024-11-24 04:03:30',4,1,'2024-11-24 13:04:59',4,1,'2024-11-30 13:29:02',4,1,'2024-11-30 13:30:52'),
(45,4,1,'2024-11-25 09:03:50',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(46,4,4,'2024-11-29 23:50:28',4,1,'2024-11-29 23:56:39',NULL,NULL,NULL,NULL,NULL,NULL),
(47,2,4,'2024-11-30 11:52:38',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `resident` */

DROP TABLE IF EXISTS `resident`;

CREATE TABLE `resident` (
  `resident_id` int(55) NOT NULL AUTO_INCREMENT,
  `img_filename` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `house_num` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `subdivision` varchar(255) DEFAULT NULL,
  `resident_since` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `marital_status` varchar(50) NOT NULL,
  `birth_date` date NOT NULL,
  `birth_place` varchar(255) NOT NULL,
  `cellphone_num` varchar(55) NOT NULL,
  `is_a_voter` tinyint(2) DEFAULT NULL,
  `audit_trail` int(55) DEFAULT NULL,
  `is_deleted` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`resident_id`),
  KEY `res_at_fk` (`audit_trail`),
  FULLTEXT KEY `fullname_idx` (`last_name`,`first_name`,`middle_name`,`suffix`) COMMENT 'For fast res searching',
  CONSTRAINT `res_at_fk` FOREIGN KEY (`audit_trail`) REFERENCES `res_audit_trail` (`res_at_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4;

/*Data for the table `resident` */

insert  into `resident`(`resident_id`,`img_filename`,`last_name`,`first_name`,`middle_name`,`suffix`,`house_num`,`street`,`subdivision`,`resident_since`,`sex`,`marital_status`,`birth_date`,`birth_place`,`cellphone_num`,`is_a_voter`,`audit_trail`,`is_deleted`) values 
(1,'capture_24-09-131726191126.jpg','Tecson','Reno','Hofileña','','Blk 12 Lot 4','Isaiah st','Cielito Homes','2015','Male','Single','1992-01-18','Malolos Bulacan','09568989899',0,1,0),
(2,'8406e341a7981729777f9dee8b55be99 (1).jpg','Tecson','Randy','Hofileña','','Blk 12 Lot 4','Isaiah st','Cielito Homes','2003','Male','Single','1992-01-08','Bulacan Bulacan','09656565655',0,2,1),
(3,'Miranda_Hallow.png','Tecson','Miranda','Hofileña','','Blk 12 Lot 4','Isaiah st','Cielito Homes','2006','Female','Married','1994-01-15','Plaridel Bulacan','09656565655',1,3,0),
(4,'Lavi_2006.png','Tecson','James','Hofileña','','Blk 12 Lot 4','Isaiah st','Cielito Homes','2007','Male','Single','1993-02-18','Pulilan Bulacan','09669898989',0,4,0),
(5,'alingpuring.jpg','Tecson','Puring','Ulatan','','Blk 12 Lot 3','Isaiah st','Cielito Homes','2007','Female','Single','1993-02-18','Bustos Bulacan','09669898989',0,5,1),
(6,'Shirou.png','Tecson','Gardo','Hofileña','','Blk 12 Lot 2','Isaiah st','Cielito Homes','2009','Male','Married','1988-02-27','San Miguel Bulacan','09064154588',1,6,0),
(8,'images (1).jpg','Yalong','Aaaron','Armengol','','Blk 12 Lot 5','Isaiah st','Cielito Homes','2015','Male','Single','1986-03-21','Gapan Nueva Ecjia','09565656565',1,8,0),
(9,'miano.jpg','Tecson','Franklin','Miano','','Blk 12 Lot 5','Isaiah st','Cielito Homes','2015','Male','Married','1986-03-21','Cabiao Nueva Ecjia','09565656564',1,9,0),
(10,'Karen-Bennett-200x200px.jpg','Tecson','Kiana','Macabara','','Blk 8 lot 5B','Jeremiah st','Cielito Homes','2015','Female','Married','1988-09-13','Valenzuela City','09565656565',0,10,0),
(11,'capture_24-09-161726498272.jpg','Salas','Norberto','Torres','','12','Zabarte rd','','2002','Male','Single','2002-08-23','Caloocan City','09565656566',0,11,1),
(12,'capture_24-11-171731865400.jpg','Salas','Robert','Lumauig','','Blk 8 lot 4','Jeremiah st','Cielito Homes','2002','Male','Single','2002-10-16','Caloocan City','09064121066',0,12,0),
(13,'Akatsuki_portal.png','Salas','Akatsuki','Lumauig','','Blk 8 lot 4','Jeremiah st','Cielito Homes','2004','Female','Single','2004-12-16','Caloocan City','09054321268',1,13,0),
(14,'6c2e2762dc133ba55627875e9fa27f33.jpg','Dayao','Hiro','Timbol','','Blk 8 lot 3','Jeremiah st','Cielito Homes','2013','Male','Married','1990-04-03','Palauig Quezon','09665656565',1,14,1),
(15,'capture_24-11-181731891938.jpg','Atchico','Denise','Tamaro','','Blk 14 lot 13','Moises st','Cielito Homes','2019','Female','Single','1999-04-24','Palauig Quezon','09665656565',0,15,1),
(16,'Shuichi_Kagaya_-_Anime.png','Labancas','Danilo','Lim','','Blk 12 Lot 4','Kang kong st','Kassel Villas','2006','Male','Single','2002-10-16','Hangono Bulacan','09056565656',1,16,0),
(17,'capture_24-09-121726121120.jpg','Japerson','Henry','','','123','Zabarte Rd','','2012','Male','Single','2002-10-16','Caloocan City','0906412066',0,17,1),
(18,'Naotsugu_portal.png','Operacio','Tim','Lucarnas','','12','Virgo st Corner Aries st','Maria Luisa Subd','2002','Male','Single','2002-10-16','Malabon City','09545454544',1,18,0),
(19,'Allenwalkerimage.png','Salas','Roberto','Lumauig','','Blk 12 Lot 4','Isaiah st','Cielito Homes','2002','Male','Single','2001-10-16','Caloocan City','09064121066',1,19,0),
(20,'Shuichi_Kagaya_-_Anime (1).png','Salas','Robert','Lumauig','','Blk 8 Lot 4','Jeremiah st','','2002','Male','Single','2002-10-16','Malabon City','09064121066',0,20,0),
(21,'capture_1731915147.jpg','Salas','Robert','Midalea','','12','Happy st','Caritas','2005','Male','Single','1999-05-10','Iriga Sorsogon','0948784555555',1,21,0),
(22,'Lavi_2006 (1).png','Jasloslos','Ping','Mardaldea','','Blk 12 Lot 11','Lapus st','','2005','Male','Single','1994-06-14','Davao City','098556955555',1,22,0),
(23,'capture_1731920853.jpg','Yalong','Aaaron','Armengol','','Blk 12 Lot5','Isaiah st','Cielito Homes','2015','Male','Single','1986-03-21','Gapan Nueva Ecjia','09565656565',1,23,1),
(24,'capture_1731921746.jpg','Yalong','Aaaron','Armengol','','Blk 12 Lot 5','Isaiah st','Cielito Homes','2015','Male','Single','1986-03-21','Gapan Nueva Ecija','09565656565',1,24,1),
(25,'capture_1731938764.jpg','Salas','Marivic','Lumauig','','Blk 8 Lot 4','Jeremiah st','Cielito Homes','2000','Female','Single','1962-11-02','Bagabag Nueva Viscaya','09054321268',1,25,0),
(26,'capture_1731938894.jpg','Salas','Marivic','Lumauig','','Blk 8 Lot 4','Jeremiah st','Cielito Homes','2000','Female','Married','1961-11-02','Bagabag Nueva Viscaya','09054321268',1,26,0),
(27,'capture_1731939042.jpg','Salas','Marivic','Lumauig','','Blk 8 Lot 4','Jeremiah st','Cielito Homes','2000','Female','Married','1961-11-02','Bagabag Nueva Viscaya','09054321268',1,27,0),
(28,'capture_1731939721.jpg','Salas','Marivic','Lumauig','','Blk 8 Lot 4','Jeremiah st','Cielito Homes','2000','Female','Married','1962-11-02','Bagabag Nueva Viscaya','09054321268',1,28,0),
(29,'capture_1732328048.jpg','Hofileña','Karl','Mark','','Blk 3 Lot 3','Virgo st Corner Aries st','Maria Luisa Subd','2015','Male','Single','2004-06-14','Donna Remedios Trinidad Bulacan','09054321268',0,29,1),
(30,'capture_1731944629.jpg','Salas','Robert','Lumauig','','Blk 12 Lot 14','Jeremiah st','Del Rey Ville 2','2006','Male','Single','2004-06-29','Caloocan City','09054321268',1,31,0),
(31,'capture_1731949885.jpg','Salas','Robert','Lumauig','','Blk 12 Lot 14','Jeremiah st','Del Rey Ville 2','2006','Female','Married','2004-06-30','Caloocan City','09054321268',1,32,0),
(32,'capture_1731950333.jpg','Salas','Robert','Lumauig','','Blk 12 Lot 14','Jeremiah st','Del Rey Ville 2','2006','Female','Married','2004-06-07','Caloocan City','09054321268',0,33,0),
(33,'capture_1731951240.jpg','Salas','Robert','Lumauig','','Blk 12 Lot 14','Jeremiah st','Del Rey Ville 2','2006','Female','Married','2004-06-01','Caloocan City','09054321268',1,34,0),
(34,'capture_1731951409.jpg','Salas','Robert','Lumauig','','Blk 12 Lot 14','Jeremiah st','Del Rey Ville 2','2006','Female','Married','2004-06-03','Caloocan City','09054321268',1,35,0),
(35,'Karen-Bennett-200x200px (1).jpg','Hofileña','Mary','Grace','','Blk 3 Lot 3','Virgo st Corner Aries st','Maria Luisa Subd','2010','Female','Married','2024-11-04','Cabangan Isabela','9054321267',1,36,0),
(36,'Yu_Kanda.PNG','Hofileña','Tangol','Mark','','Blk 3 Lot 3','Virgo st Corner Aries st','Maria Luisa Subd','2003','Male','Married','2024-11-08','Bayombong Nueva Viscaya','9054321267',1,37,0),
(37,'capture_1732300490.jpg','Hofileña','Tangol','Mark','','Blk 3 Lot 3','Virgo st Corner Aries st','Cassel Spring Subd','2002','Female','Married','2024-02-06','Quezon Nueva Viscaya','09054321268',1,38,0),
(38,'capture_1732300540.jpg','Hofileña','Tangol','Mark','','Blk 3 Lot 3','Virgo st Corner Aries st','Cassel Spring Subd','2002','Female','Married','2024-02-27','Bagabag Nueva Viscaya','09054321268',1,39,0),
(39,'capture_1731952624.jpg','Salas','Marivic','Lumauig','','Blk 8 Lot 4','Jeremiah st','Cielito Homes','2000','Male','Single','2024-11-14','Bagabag Nueva Viscaya','09054321268',1,40,0),
(40,'capture_1731962269.jpg','Salas','Marivic','Lumauig','','Blk 8 Lot 4','Jeremiah st','Select','2000','Male','Single','2024-11-19','Bagabag Nueva Viscaya','09054321268',1,41,1),
(41,'capture_1731998858.jpg','Lascanas','Robert','Kaledo','','Blk 8 Lot 11','Oliver st','North Matrix Ville','2005','Male','Married','1993-07-08','Caloocan City','095656565656',1,42,0),
(42,'capture_1732344625.jpg','Jerez','Roberto','Bunanig','','Blk 12 Lot 14','Lapus st','Kassel Villas','2002','Male','Single','2000-01-03','Silang Cavite','095645454547',1,43,0),
(44,'capture_1732392173.jpg','De Leon','Vincient','Simbulan','','Blk 12 Lot 4','Zapote st','Lilleville Subd','2002','Male','Married','2000-02-09','Muntinlupa','09045565656',1,44,0),
(45,'capture_1732392210.jpg','Orlando','David','Simbulan','','Blk 12 Lot 4','Zapote st','Lilleville Subd','2002','Male','Married','2000-02-16','Quezon city','09565656233',0,45,0),
(46,'Shiroe_portal (1).png','Carmona','Nicholas','Dasol','','Blk 8 Lot 4','Jeremiah st','','2002','Male','Single','2002-12-24','Solano Nueva Viscaya','09054321268',1,46,0),
(47,'capture_1732938758.jpg','Obo','Francis','','','Blk 12 Lot 15','Papili st','Christina Homes','2005','Male','Single','2003-01-06','Quezon City','0956565656565',1,47,0);

/*Table structure for table `resident_audit` */

DROP TABLE IF EXISTS `resident_audit`;

CREATE TABLE `resident_audit` (
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `resident_id` int(11) NOT NULL,
  `action_type` enum('INSERT','UPDATE','DELETE','RECOVER') NOT NULL,
  `action_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_no` int(11) DEFAULT NULL,
  `dept_no` int(11) DEFAULT NULL,
  `is_deleted` tinyint(2) DEFAULT '0',
  `last_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `action_data` json DEFAULT NULL,
  PRIMARY KEY (`audit_id`),
  KEY `user_no` (`user_no`),
  KEY `dept_no` (`dept_no`),
  CONSTRAINT `resident_audit_ibfk_1` FOREIGN KEY (`user_no`) REFERENCES `tbl_username` (`username_id`),
  CONSTRAINT `resident_audit_ibfk_2` FOREIGN KEY (`dept_no`) REFERENCES `departments_list` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `resident_audit` */

insert  into `resident_audit`(`audit_id`,`resident_id`,`action_type`,`action_timestamp`,`user_no`,`dept_no`,`is_deleted`,`last_name`,`first_name`,`action_data`) values 
(1,46,'UPDATE','2024-11-29 23:56:39',1,4,0,'Carmona','Nicholas','{\"new_values\": {\"sex\": \"Male\", \"street\": \"Jeremiah st\", \"suffix\": \"\", \"house_num\": \"Blk 8 Lot 4\", \"last_name\": \"Carmona\", \"birth_date\": \"2002-12-24\", \"first_name\": \"Nicholas\", \"is_a_voter\": 1, \"birth_place\": \"Solano Nueva Viscaya\", \"middle_name\": \"Dasol\", \"subdivision\": \"\", \"img_filename\": \"Shiroe_portal (1).png\", \"cellphone_num\": \"09054321268\", \"marital_status\": \"Single\", \"resident_since\": \"2002\"}, \"old_values\": {\"sex\": \"Male\", \"street\": \"Jeremiah st\", \"suffix\": \"\", \"house_num\": \"Blk 8 Lot 4\", \"last_name\": \"Carmona\", \"birth_date\": \"2002-12-24\", \"first_name\": \"Nicholas\", \"is_a_voter\": 1, \"birth_place\": \"Bayombong Nueva Viscaya\", \"middle_name\": \"Dasol\", \"subdivision\": null, \"img_filename\": \"Shiroe_portal (1).png\", \"cellphone_num\": \"09054321268\", \"marital_status\": \"Single\", \"resident_since\": \"2002\"}}'),
(2,47,'INSERT','2024-11-30 11:52:38',4,2,0,'Obo','Francis','{\"sex\": \"Male\", \"street\": \"Papili st\", \"suffix\": \"\", \"house_num\": \"Blk 12 Lot 15\", \"last_name\": \"Obo\", \"birth_date\": \"2003-01-06\", \"first_name\": \"Francis\", \"is_a_voter\": 1, \"birth_place\": \"Quezon City\", \"middle_name\": \"\", \"subdivision\": \"Christina Homes\", \"img_filename\": \"capture_1732938758.jpg\", \"cellphone_num\": \"0956565656565\", \"marital_status\": \"Single\", \"resident_since\": \"2005\"}'),
(3,44,'DELETE','2024-11-30 13:29:02',1,4,1,'De Leon','Vincient','{\"new_values\": {\"sex\": \"Male\", \"street\": \"Zapote st\", \"suffix\": \"\", \"house_num\": \"Blk 12 Lot 4\", \"last_name\": \"De Leon\", \"birth_date\": \"2000-02-09\", \"first_name\": \"Vincient\", \"is_a_voter\": 1, \"is_deleted\": 1, \"birth_place\": \"Muntinlupa\", \"middle_name\": \"Simbulan\", \"subdivision\": \"Lilleville Subd\", \"img_filename\": \"capture_1732392173.jpg\", \"cellphone_num\": \"09045565656\", \"marital_status\": \"Married\", \"resident_since\": \"2002\"}, \"old_values\": {\"is_deleted\": 0}}'),
(4,44,'RECOVER','2024-11-30 13:30:52',1,4,0,'De Leon','Vincient','{\"new_values\": {\"sex\": \"Male\", \"street\": \"Zapote st\", \"suffix\": \"\", \"house_num\": \"Blk 12 Lot 4\", \"last_name\": \"De Leon\", \"birth_date\": \"2000-02-09\", \"first_name\": \"Vincient\", \"is_a_voter\": 1, \"is_deleted\": 0, \"birth_place\": \"Muntinlupa\", \"middle_name\": \"Simbulan\", \"subdivision\": \"Lilleville Subd\", \"img_filename\": \"capture_1732392173.jpg\", \"cellphone_num\": \"09045565656\", \"marital_status\": \"Married\", \"resident_since\": \"2002\"}, \"old_values\": {\"is_deleted\": 1}}');

/*Table structure for table `tbl_blotter_audit_trail` */

DROP TABLE IF EXISTS `tbl_blotter_audit_trail`;

CREATE TABLE `tbl_blotter_audit_trail` (
  `blotter_at_id` int(55) NOT NULL AUTO_INCREMENT,
  `assist_by_no` int(55) DEFAULT NULL,
  `blotter_add_dt` datetime DEFAULT CURRENT_TIMESTAMP,
  `blotter_edit_dt` datetime DEFAULT NULL,
  `edited_by` int(55) DEFAULT NULL,
  `blotter_delete_dt` datetime DEFAULT NULL,
  `deleted_by` int(55) DEFAULT NULL,
  `blotter_recovered_dt` datetime DEFAULT NULL,
  `recovered_by` int(55) DEFAULT NULL,
  PRIMARY KEY (`blotter_at_id`),
  KEY `fk_assist_by` (`assist_by_no`),
  CONSTRAINT `fk_assist_by` FOREIGN KEY (`assist_by_no`) REFERENCES `tbl_username` (`username_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_blotter_audit_trail` */

insert  into `tbl_blotter_audit_trail`(`blotter_at_id`,`assist_by_no`,`blotter_add_dt`,`blotter_edit_dt`,`edited_by`,`blotter_delete_dt`,`deleted_by`,`blotter_recovered_dt`,`recovered_by`) values 
(1,NULL,'2024-11-16 17:12:51','2024-11-25 17:23:31',NULL,'2024-11-18 13:53:09',NULL,NULL,NULL),
(2,NULL,'2024-11-16 17:18:59','2024-11-25 17:23:31',NULL,'2024-11-18 13:53:09',NULL,NULL,NULL),
(3,NULL,'2024-11-16 17:21:42','2024-11-25 17:23:31',NULL,'2024-11-18 13:53:09',NULL,NULL,NULL),
(4,NULL,'2024-11-16 17:23:52','2024-11-25 17:23:31',NULL,'2024-11-18 13:53:09',NULL,NULL,NULL),
(5,NULL,'2024-11-16 22:16:52','2024-11-25 17:23:31',NULL,'2024-11-18 13:53:09',NULL,NULL,NULL),
(6,NULL,'2024-11-16 22:17:55','2024-11-25 17:23:31',NULL,'2024-11-18 13:53:09',NULL,NULL,NULL),
(7,NULL,'2024-11-16 22:19:31','2024-11-25 17:23:31',NULL,'2024-11-18 13:53:09',NULL,NULL,NULL),
(8,NULL,'2024-11-16 22:20:10','2024-11-25 17:23:31',NULL,'2024-11-18 13:53:09',NULL,NULL,NULL),
(9,NULL,'2024-11-16 22:20:12','2024-11-25 17:23:31',NULL,'2024-11-18 13:53:09',NULL,NULL,NULL),
(10,NULL,'2024-11-16 22:20:30','2024-11-25 17:23:31',NULL,'2024-11-18 13:53:09',NULL,NULL,NULL),
(11,NULL,'2024-11-16 22:25:17','2024-11-25 17:23:31',NULL,'2024-11-18 13:53:09',NULL,NULL,NULL),
(12,NULL,'2024-11-16 22:31:39','2024-11-25 17:23:31',NULL,'2024-11-18 13:53:09',NULL,NULL,NULL),
(13,NULL,'2024-11-18 13:49:28','2024-11-25 17:23:31',NULL,'2024-11-18 13:53:09',NULL,NULL,NULL),
(14,NULL,'2024-11-25 17:20:21','2024-11-25 17:23:31',NULL,NULL,NULL,NULL,NULL),
(15,NULL,'2024-11-25 17:27:19',NULL,NULL,NULL,NULL,NULL,NULL),
(16,NULL,'2024-11-25 17:30:06',NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `tbl_blotter_mediator` */

DROP TABLE IF EXISTS `tbl_blotter_mediator`;

CREATE TABLE `tbl_blotter_mediator` (
  `mediator_id` int(55) NOT NULL AUTO_INCREMENT,
  `last_name` varchar(85) DEFAULT NULL,
  `first_name` varchar(85) DEFAULT NULL,
  `middle_name` varchar(85) DEFAULT NULL,
  `suffix` varchar(85) DEFAULT NULL,
  PRIMARY KEY (`mediator_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_blotter_mediator` */

insert  into `tbl_blotter_mediator`(`mediator_id`,`last_name`,`first_name`,`middle_name`,`suffix`) values 
(1,'Salas','Robert','Lumauig','Jr'),
(2,'Jamin','Jeffrey','Ocampo','Sr');

/*Table structure for table `tbl_blotters` */

DROP TABLE IF EXISTS `tbl_blotters`;

CREATE TABLE `tbl_blotters` (
  `blotter_id` int(55) NOT NULL AUTO_INCREMENT,
  `res_complainant_no` int(55) DEFAULT NULL,
  `nres_complainant_no` int(55) DEFAULT NULL,
  `res_respondent_no` int(55) DEFAULT NULL,
  `nres_respondent_no` int(55) DEFAULT NULL,
  `other_complainant_no` int(55) DEFAULT NULL,
  `other_respondent_no` int(55) DEFAULT NULL,
  `blotter_type` tinyint(5) DEFAULT NULL,
  `desc_incident` varchar(255) DEFAULT NULL,
  `incident_dt` datetime DEFAULT NULL,
  `location_of_incident` varchar(255) DEFAULT NULL,
  `date_of_resolution` date DEFAULT NULL,
  `blotter_contextfile` varchar(255) DEFAULT NULL,
  `blotter_evidencefile` varchar(255) DEFAULT NULL,
  `statemnt` longtext,
  `mediation_starttime` time DEFAULT NULL,
  `mediation_endtime` time DEFAULT NULL,
  `mediator_no` int(55) DEFAULT NULL,
  `blot_at_no` int(55) DEFAULT NULL,
  `mediation_date` date DEFAULT NULL,
  `schedule_color` varchar(55) DEFAULT NULL,
  `report_status` tinyint(5) DEFAULT '0',
  `is_deleted` tinyint(5) DEFAULT '0',
  PRIMARY KEY (`blotter_id`),
  KEY `res_complainant_no` (`res_complainant_no`),
  KEY `res_repondent_no` (`res_respondent_no`),
  KEY `nres_respondent_no` (`nres_respondent_no`),
  KEY `blot_at_no` (`blot_at_no`),
  KEY `other_complanant_no` (`other_complainant_no`),
  KEY `other_respondent_no` (`other_respondent_no`),
  KEY `tbl_blotters_ibfk_2` (`nres_complainant_no`),
  KEY `mediator_no` (`mediator_no`),
  CONSTRAINT `tbl_blotters_ibfk_1` FOREIGN KEY (`res_complainant_no`) REFERENCES `resident` (`resident_id`),
  CONSTRAINT `tbl_blotters_ibfk_2` FOREIGN KEY (`nres_complainant_no`) REFERENCES `non_resident` (`nresident_id`),
  CONSTRAINT `tbl_blotters_ibfk_3` FOREIGN KEY (`res_respondent_no`) REFERENCES `resident` (`resident_id`),
  CONSTRAINT `tbl_blotters_ibfk_4` FOREIGN KEY (`nres_respondent_no`) REFERENCES `non_resident` (`nresident_id`),
  CONSTRAINT `tbl_blotters_ibfk_5` FOREIGN KEY (`blot_at_no`) REFERENCES `tbl_blotter_audit_trail` (`blotter_at_id`),
  CONSTRAINT `tbl_blotters_ibfk_6` FOREIGN KEY (`other_complainant_no`) REFERENCES `tbl_other_complainants` (`complainant_id`),
  CONSTRAINT `tbl_blotters_ibfk_7` FOREIGN KEY (`other_respondent_no`) REFERENCES `tbl_other_respondents` (`respondent_id`),
  CONSTRAINT `tbl_blotters_ibfk_8` FOREIGN KEY (`mediator_no`) REFERENCES `tbl_blotter_mediator` (`mediator_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_blotters` */

insert  into `tbl_blotters`(`blotter_id`,`res_complainant_no`,`nres_complainant_no`,`res_respondent_no`,`nres_respondent_no`,`other_complainant_no`,`other_respondent_no`,`blotter_type`,`desc_incident`,`incident_dt`,`location_of_incident`,`date_of_resolution`,`blotter_contextfile`,`blotter_evidencefile`,`statemnt`,`mediation_starttime`,`mediation_endtime`,`mediator_no`,`blot_at_no`,`mediation_date`,`schedule_color`,`report_status`,`is_deleted`) values 
(1,1,NULL,10,NULL,1,1,1,'Utang Di na binayaraan, naglahong parang bula','2024-11-13 17:00:21','Cielito Homes','2024-11-25','GettyImages-846492016-cab58ea8fa1c4540b6ae00f133b28889 (1).jpg','GLooZSFWYAAMxfL (1).jpeg','Sa ika 13th ng Nobiembre ay nagpautang si Ginang Kiana Makabara ng 10 libong piso kay Reno Hofileña Tecson at di na sumpot ulit','12:30:00','14:00:00',1,1,'2024-11-18',NULL,1,0),
(2,1,NULL,12,NULL,2,2,0,'Utang Di binabayaraan','2024-11-13 17:00:21','Cielito Homes',NULL,'5_2024-07-06_22-17-53.jpg','2f070627687d52995cfabf5c1bbde057 (2).jpg','Sa ika 13th ng Nobiembre ay nagpautang si Robert Salas Makabara ng 10 libong piso kay Reno Hofileña Tecson at di na sumipot ulit','14:00:00','15:30:00',2,2,'2024-11-18',NULL,0,0),
(3,1,NULL,4,NULL,3,3,0,'Utang Tangngay','2024-11-13 17:00:21','Cielito Homes',NULL,'2f070627687d52995cfabf5c1bbde057.jpg','456471971_509667595047012_371368751885686431_n.jpg','Sa ika 13th ng Nobiembre ay nagpautang ang kapatid ng nagrereklamo  na si James Hofileña Tecson ng 10 libong piso kay Reno Hofileña Tecson at di na sumipot muli','14:00:00','15:30:00',2,3,'2024-11-21',NULL,0,0),
(4,1,NULL,8,NULL,4,4,0,'Di nagbabayad ng Utang','2024-11-13 17:00:21','Cielito Homes',NULL,'2f070627687d52995cfabf5c1bbde057 (1).jpg','456471971_509667595047012_371368751885686431_n (1).jpg','Sa ika 13th ng Nobiembre ay si Allen Adrian Yalong ay nagpost ng libeliong mga post sa kanyang social media kung saan binibintangan ang nagrereklamo ng salot at tiwalig','13:00:00','14:30:00',1,4,'2024-11-27','#000000',0,0),
(5,8,NULL,1,NULL,5,5,0,'Cyber Libel','2024-11-11 22:15:46','Cielito Homes',NULL,'GettyImages-846492016-cab58ea8fa1c4540b6ae00f133b28889.jpg','GLooZSFWYAAMxfL.jpeg','Cyber libel lfjsdklflkasjflsdklfsadklvnlsdakncl','13:00:00','14:00:00',1,5,'2024-11-26',NULL,0,0),
(6,8,NULL,1,NULL,6,6,0,'jkdjfksjdkfjksafksjdfkajdskfjadskkfkldsjdf','2024-11-11 22:15:46','Cielito Homes',NULL,'5_2024-07-06_22-17-53 (4).jpg','5_2024-07-06_22-17-53 (3).jpg','fvjdfklvjaksljviajsdfklvjadsklfmfvoaefjd','13:00:00','14:00:00',1,6,'2024-11-26',NULL,0,0),
(7,10,NULL,9,NULL,7,7,0,'Cyber Bullying','2024-11-12 22:18:42','Maria Lusisa',NULL,'2f070627687d52995cfabf5c1bbde057 (4).jpg','Shiroe_portal (4).png','dslmalmdlmfqewfmqsdmklawmdcwmdkcmkwsd','09:00:00','10:00:00',NULL,7,'2024-11-29','#000000',0,0),
(8,10,NULL,9,NULL,8,8,1,'Unjust Vexation','2024-11-12 22:18:42','Maria Lusisa',NULL,'2f070627687d52995cfabf5c1bbde057 (5).jpg','Shiroe_portal (5).png','sdjkmdscmasdmckasmdcklandkclnasdkjnckds hckadscjndkjcnasdkncklasdnckanwdkc','09:00:00','10:00:00',1,8,'2024-11-29',NULL,0,0),
(9,10,NULL,9,NULL,9,9,1,'Unjust Vexation','2024-11-12 22:18:42','Maria Lusisa',NULL,'2f070627687d52995cfabf5c1bbde057 (7).jpg','Shiroe_portal (6).png','sdjkmdscmasdmckasmdcklandkclnasdkjnckds hckadscjndkjcnasdkncklasdnckanwdkc','09:00:00','10:00:00',1,9,'2024-11-29',NULL,0,0),
(10,10,NULL,NULL,1,10,10,1,'Estafa Rentangay','2024-11-12 22:18:42','Maria Lusisa',NULL,'2f070627687d52995cfabf5c1bbde057 (8).jpg','Shiroe_portal (7).png','sdjkmdscmasdmckasmdcklandkclnasdkjnckds hckadscjndkjcnasdkncklasdnckanwdkcdsfsfsdfsd','09:00:00','10:00:00',NULL,10,'2024-11-29','#000000',0,0),
(11,8,NULL,9,NULL,11,11,0,'Snatching','2024-11-13 22:20:51','Maligay Park',NULL,'2f070627687d52995cfabf5c1bbde057 (13).jpg','toilet-bound-hanako-kun-acryl-keychain-hanako-kun (4).jpg','fsdfcsdcmsdmdclksdmlcmsklmcslacnsdkncadskncvkadsfvkld','08:30:00','10:30:00',NULL,11,'2024-11-20','#c83c3c',0,0),
(12,8,NULL,9,NULL,12,12,0,'Snatchingfdfsdlcls;dkmcals','2024-11-13 22:20:51','Maligay Park',NULL,'2f070627687d52995cfabf5c1bbde057 (15).jpg','toilet-bound-hanako-kun-acryl-keychain-hanako-kun (5).jpg','fsdfcsdcmsdmdclksdmlcmsklmcslacnsdkncadskncvkadsfvkld','08:30:00','10:30:00',NULL,12,'2024-11-20','#c83c3c',0,1),
(13,1,NULL,9,NULL,13,13,0,'Estafa Rentangay','2024-11-11 13:30:46','Cielito Homes',NULL,'GLooZSFWYAAMxfL.jpeg','GLooZSFWYAAMxfL (2).jpeg','sdkjfndisafcljkasdhfkasndcasoidcpIUASNHDCPIUA','09:00:00','10:00:00',NULL,13,'2024-11-19','#000000',0,1),
(14,1,NULL,3,NULL,14,14,0,'Estafa Ebike na di na binalik sa pinagupahan','2024-11-26 17:17:18','Cielito Homes',NULL,'456471971_509667595047012_371368751885686431_n (1).jpg','465560047_3983565665304630_891432138380119720_n.jpg','Gdpfcklsdlcksldmcsldjclasmdocaskdlmcsiodlsdmvlksdmvldsmf','10:00:00','10:30:00',1,14,'2024-11-27',NULL,0,0),
(15,1,NULL,8,NULL,15,15,0,'Online harasment','2024-11-13 17:25:25','Maria Lusisa',NULL,'465560047_3983565665304630_891432138380119720_n.jpg','465560047_3983565665304630_891432138380119720_n (1).jpg','Sa ika 10 ng nobyembre si Aaaron Armengol Yalong ay nagpost ng mga malisiosong mga post laban sa nagrereklamo','15:00:00','15:30:00',NULL,15,'2024-11-28','#b40404',0,0),
(16,1,NULL,8,NULL,16,16,0,'Online harasment','2024-11-06 17:29:08','Maria Lusisa',NULL,'456471971_509667595047012_371368751885686431_n (2).jpg','465560047_3983565665304630_891432138380119720_n (2).jpg','adssldmclksdmcklsmadlkcmslkdmcsdmn','13:30:00','14:00:00',NULL,16,'2024-11-28','#000000',0,0);

/*Table structure for table `tbl_building_permits` */

DROP TABLE IF EXISTS `tbl_building_permits`;

CREATE TABLE `tbl_building_permits` (
  `building_permit_id` int(55) NOT NULL AUTO_INCREMENT,
  `blg_house_no` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `subd` varchar(255) DEFAULT NULL,
  `permit_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`building_permit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_building_permits` */

insert  into `tbl_building_permits`(`building_permit_id`,`blg_house_no`,`street`,`subd`,`permit_type`) values 
(1,'Blk 12 Lot 12','King Ping st','North Triangle','Renovaton'),
(2,'Blk 12 Lot 12','King Ping st','North Triangle','Renovaton'),
(3,'Blk 12 Lot 12','King Ping st','North Triangle','Renovaton'),
(4,'Blk 12 Lot 12','King Ping st','North Triangle','Renovaton'),
(5,'Blk 12 Lot 12','King Ping st','North Triangle','Renovaton'),
(6,'Blk 12 Lot 12','King Ping st','North Triangle','Renovaton'),
(7,'Blk 12 Lot 12','King Ping st','North Triangle','Renovaton'),
(8,'Blk 12 Lot 12','King Ping st','North Triangle','Renovaton'),
(9,'Blk 12 Lot 12','King Ping st','North Triangle','Renovaton'),
(10,'Blk 12 Lot 12','King Ping st','North Triangle','Renovaton'),
(11,'Blk 12 Lot 12','King Ping st','North Triangle','Renovaton'),
(12,'Blk 12 Lot 12','King Ping st','North Triangle','Renovaton'),
(13,'Blk 12 Lot 15','Ping st','Lilleville Subd','Extension'),
(14,'123','Zabarte Rd','Cielito Homes','Renovaton'),
(15,'12','Zapote Rd','Maligay Park','Renovaton'),
(16,'12','Zapote Rd','Maligay Park','Renovaton'),
(17,'12','Zabarte Road','Cielito Homes','Renovaton'),
(18,'Blk 12 Lot 3','Yang st','Almar Subd','Extension'),
(19,'Blk 12 Lot 12','Exodus st','North Matrix Villge 1','Renovaton'),
(20,'Blk 12 Lot 12','Exodus st','North Matrix Villge 1','Renovaton'),
(21,'Blk 12 Lot 12','Exodus st','North Matrix Villge 1','Renovaton'),
(22,'Blk 12 Lot 4','Exodus st','Cielito Homes','Extension'),
(23,'Blk 12 Lot 4','Exodus st','Cielito Homes','Extension'),
(24,'Blk 12 Lot 4','Exodus st','Cielito Homes','Extension'),
(25,'Blk 12 Lot 4','Exodus st','Cielito Homes','Extension'),
(26,'Blk 12 Lot 4','Exodus st','Cielito Homes','Extension'),
(27,'Blk 12 Lot 4','Exodus st','Cielito Homes','Extension');

/*Table structure for table `tbl_business_permits` */

DROP TABLE IF EXISTS `tbl_business_permits`;

CREATE TABLE `tbl_business_permits` (
  `business_id` int(55) NOT NULL AUTO_INCREMENT,
  `year_quarter` varchar(255) NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `blg_house_no` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `subdivision` varchar(255) DEFAULT NULL,
  `type_of_buss` varchar(255) NOT NULL,
  PRIMARY KEY (`business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_business_permits` */

insert  into `tbl_business_permits`(`business_id`,`year_quarter`,`store_name`,`blg_house_no`,`street`,`subdivision`,`type_of_buss`) values 
(1,'Q3-Q4','Jack Frost Ice Creme','Blk 12 Lot 13','John st','Cielito Homes','Food Stall'),
(2,'Q3-Q4','Ice Frost Water Refilling Station','Blk 12 Lot 14','Genesis st','Cielito Homes','Water Refilling Station'),
(3,'Q3-Q4','Master Siomai','Blk 12 Lot 14','Genesis st','Cielito Homes','Food Stall'),
(4,'Q3-Q4','Rex Metal Works','Blk 12 Lot 14','Genesis st','Cielito Homes','Metal Works Shop'),
(5,'Q3-Q4','Cions Meat Shop','Blk 12 Lot 15','Genesis st','Cielito Homes','Meat Shop'),
(6,'Q3-Q4','Yangzhe Metal Works','14','Zabarte Rd','','Metal Works'),
(7,'Q3-Q4','Yangzhe Metal Works','14','Zabarte Rd','','Metal Works'),
(8,'Q3-Q4','Yangzhe Metal Works','14','Zabarte Rd','','Metal Works'),
(9,'Q3-Q4','Yangzhe Metal Works','14','Zabarte Rd','','Metal Works'),
(10,'Q3-Q4','Yangzhe Metal Works','14','Zabarte Rd','','Metal Works'),
(11,'Q3-Q4','Umbalin Furniture','123','Genesis st Corner Zabarte','Cielito Homes','Funiture Store'),
(12,'Q3-Q4','Cion Meat Shop','Blk 8 Lot 4','Jeremiah st','Christina Homes','Meat Shop'),
(13,'Q3-Q4','Cion Meat Shop','Blk 8 Lot 12','Kambal st','Cielito Homes','Meat Shop'),
(14,'Q3-Q4','Mana Car Wash','12','Zabarte Rd','','Car Wash');

/*Table structure for table `tbl_cert_audit_trail` */

DROP TABLE IF EXISTS `tbl_cert_audit_trail`;

CREATE TABLE `tbl_cert_audit_trail` (
  `audit_trail_id` int(50) NOT NULL AUTO_INCREMENT,
  `issuing_dept_no` int(50) DEFAULT NULL,
  `issued_by_no` int(50) DEFAULT NULL,
  `datetime_issued` datetime NOT NULL,
  `edited_depart_no` int(55) DEFAULT NULL,
  `edited_by_no` int(55) DEFAULT NULL,
  `datetime_edited` datetime DEFAULT NULL,
  `deleted_depart` int(55) DEFAULT NULL,
  `deleted_by_no` int(55) DEFAULT NULL,
  `datetime_deleted` date DEFAULT NULL,
  `recovered_depart_no` int(55) DEFAULT NULL,
  `recovered_by_no` int(55) DEFAULT NULL,
  `datetime_recovered` datetime DEFAULT NULL,
  `recovered_time` time DEFAULT NULL,
  PRIMARY KEY (`audit_trail_id`),
  KEY `department_fk` (`issuing_dept_no`),
  KEY `issued_by_fk` (`issued_by_no`),
  KEY `edited_by_fk` (`edited_by_no`),
  KEY `deleted_by_fk` (`deleted_by_no`),
  KEY `recovered_by_fk` (`recovered_by_no`),
  CONSTRAINT `deleted_by_fk` FOREIGN KEY (`deleted_by_no`) REFERENCES `tbl_username` (`username_id`),
  CONSTRAINT `department_fk` FOREIGN KEY (`issuing_dept_no`) REFERENCES `departments_list` (`department_id`),
  CONSTRAINT `edited_by_fk` FOREIGN KEY (`edited_by_no`) REFERENCES `tbl_username` (`username_id`),
  CONSTRAINT `issued_by_fk` FOREIGN KEY (`issued_by_no`) REFERENCES `tbl_username` (`username_id`),
  CONSTRAINT `recovered_by_fk` FOREIGN KEY (`recovered_by_no`) REFERENCES `tbl_username` (`username_id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_cert_audit_trail` */

insert  into `tbl_cert_audit_trail`(`audit_trail_id`,`issuing_dept_no`,`issued_by_no`,`datetime_issued`,`edited_depart_no`,`edited_by_no`,`datetime_edited`,`deleted_depart`,`deleted_by_no`,`datetime_deleted`,`recovered_depart_no`,`recovered_by_no`,`datetime_recovered`,`recovered_time`) values 
(1,4,1,'2024-10-14 01:34:59',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(2,4,1,'2024-10-14 01:54:23',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(3,4,1,'2024-10-14 02:01:50',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(4,4,1,'2024-10-14 02:04:49',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(5,4,1,'2024-10-14 02:09:36',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(6,4,1,'2024-10-14 02:19:44',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(7,4,1,'2024-10-14 02:22:03',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(8,4,1,'2024-10-14 02:24:15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(9,4,1,'2024-10-14 02:24:48',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(10,4,1,'2024-10-14 02:26:20',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(11,4,1,'2024-10-14 02:26:55',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(12,4,1,'2024-10-14 02:27:56',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(13,4,1,'2024-10-14 02:28:08',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(14,4,1,'2024-10-14 02:28:32',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(15,4,1,'2024-10-14 02:30:29',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(16,4,1,'2024-10-14 02:31:26',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(17,4,1,'2024-10-14 02:33:07',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(18,4,1,'2024-10-14 02:35:23',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(19,4,1,'2024-10-14 02:40:36',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(20,4,1,'2024-10-14 02:42:15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(21,4,1,'2024-10-14 12:38:44',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(22,4,1,'2024-10-14 12:40:33',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(23,4,1,'2024-10-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(24,4,1,'2024-10-14 19:07:38',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(25,4,1,'2024-10-15 20:07:51',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(26,4,1,'2024-10-16 14:52:19',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(27,4,1,'2024-10-16 14:54:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(28,4,1,'2024-10-16 14:54:36',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(29,4,1,'2024-10-16 14:54:53',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(30,4,1,'2024-10-16 14:57:20',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(31,4,1,'2024-10-16 14:58:38',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(32,4,1,'2024-10-16 15:11:33',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(33,4,1,'2024-10-16 18:56:35',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(34,4,1,'2024-10-19 13:22:31',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(35,4,1,'2024-10-19 19:23:50',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(36,4,1,'2024-10-19 19:27:51',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(37,4,1,'2024-10-19 19:28:02',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(38,4,1,'2024-10-19 19:29:25',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(39,4,1,'2024-10-19 13:34:11',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(40,4,1,'2024-11-09 18:02:01',NULL,NULL,'2024-11-15 00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(41,4,1,'2024-11-14 15:44:22',NULL,NULL,'2024-11-14 00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(42,4,1,'2024-11-15 16:56:46',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(43,4,1,'2024-11-15 17:00:13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(44,4,1,'2024-11-17 17:38:15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(45,4,1,'2024-11-17 17:54:17',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(46,4,1,'2024-11-17 17:58:44',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(47,4,1,'2024-11-17 18:04:01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(48,4,1,'2024-11-18 01:05:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(49,4,1,'2024-11-18 01:09:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(50,4,1,'2024-11-18 01:10:44',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(51,4,1,'2024-11-18 01:13:19',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(52,4,1,'2024-11-18 01:45:01',NULL,NULL,'2024-12-01 00:00:00',NULL,NULL,NULL,4,1,NULL,NULL),
(53,4,1,'2024-11-18 01:50:16',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(54,4,1,'2024-11-18 05:02:49',4,1,'2024-11-24 00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(55,4,1,'2024-11-24 11:49:27',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(56,4,1,'2024-11-24 12:25:17',NULL,NULL,'2024-12-01 00:00:00',NULL,NULL,NULL,4,1,NULL,NULL),
(57,1,1,'2024-11-25 13:44:19',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(58,1,2,'2024-11-25 13:44:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(59,1,2,'2024-11-25 13:45:41',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(60,2,4,'2024-11-25 18:08:47',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(61,2,4,'2024-11-25 18:09:18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(62,4,1,'2024-11-25 18:24:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(63,4,1,'2024-11-25 18:40:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(64,4,1,'2024-11-25 18:42:04',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(65,4,1,'2024-11-26 23:26:28',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(66,4,1,'2024-11-26 23:28:50',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(67,4,1,'2024-11-27 00:06:15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(68,4,1,'2024-11-27 00:18:15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(69,4,1,'2024-11-27 00:25:17',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(70,4,1,'2024-11-27 00:26:59',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(71,4,1,'2024-11-27 08:44:51',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(72,4,1,'2024-11-27 08:46:24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(73,4,1,'2024-11-27 08:48:51',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(74,4,NULL,'2024-11-27 09:53:42',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(75,4,1,'2024-11-27 09:57:52',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(76,4,1,'2024-11-27 10:02:14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(77,4,1,'2024-11-27 10:03:47',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(78,4,1,'2024-11-27 10:10:02',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(79,4,1,'2024-11-27 10:11:25',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(80,4,1,'2024-11-27 10:12:07',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(81,4,1,'2024-11-27 10:13:02',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(82,4,1,'2024-11-27 10:13:58',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(83,4,1,'2024-11-27 10:17:08',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(84,4,1,'2024-11-27 10:18:02',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(85,4,1,'2024-11-27 10:18:26',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(86,4,1,'2024-11-27 11:21:13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(87,4,1,'2024-11-27 11:40:49',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(88,4,1,'2024-11-27 12:03:51',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(89,4,1,'2024-11-27 12:19:19',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(90,4,1,'2024-11-27 12:20:59',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(91,4,1,'2024-11-27 12:25:57',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(92,4,1,'2024-11-27 12:44:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(93,4,1,'2024-11-27 13:14:23',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(94,4,1,'2024-11-27 14:24:03',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(95,4,1,'2024-11-27 14:28:17',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(96,4,1,'2024-11-27 14:34:26',NULL,NULL,NULL,4,1,'2024-12-01',NULL,NULL,NULL,NULL),
(97,2,4,'2024-11-27 14:37:13',2,4,'2024-12-01 00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(98,4,1,'2024-12-01 13:57:07',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `tbl_docu_request` */

DROP TABLE IF EXISTS `tbl_docu_request`;

CREATE TABLE `tbl_docu_request` (
  `request_id` varchar(255) NOT NULL,
  `resident_no` int(55) DEFAULT NULL,
  `nresident_no` int(55) DEFAULT NULL,
  `document_no` int(55) DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `age` int(10) DEFAULT NULL,
  `presented_id` varchar(255) DEFAULT NULL,
  `ID_number` varchar(255) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `audit_trail_no` int(55) DEFAULT NULL,
  `pdffile` varchar(255) DEFAULT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`request_id`),
  KEY `toknowtheaudittrail` (`audit_trail_no`),
  KEY `toknowtheresident` (`resident_no`),
  KEY `toknowthenresident` (`nresident_no`),
  KEY `toknowdocument` (`document_no`),
  CONSTRAINT `toknowdocument` FOREIGN KEY (`document_no`) REFERENCES `tbl_documents` (`docu_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `toknowtheaudittrail` FOREIGN KEY (`audit_trail_no`) REFERENCES `tbl_cert_audit_trail` (`audit_trail_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `toknowthenresident` FOREIGN KEY (`nresident_no`) REFERENCES `non_resident` (`nresident_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `toknowtheresident` FOREIGN KEY (`resident_no`) REFERENCES `resident` (`resident_id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_docu_request` */

insert  into `tbl_docu_request`(`request_id`,`resident_no`,`nresident_no`,`document_no`,`expiration_date`,`age`,`presented_id`,`ID_number`,`purpose`,`audit_trail_no`,`pdffile`,`status`,`is_deleted`) values 
('2024-000001',1,NULL,1,'2025-01-14',32,'National ID','PCN-123455678890','Maynilad Application',1,'generated_pdf_1728840899.pdf',0,0),
('2024-000002',NULL,1,2,'2025-10-14',26,'Drivers License','N42-2121212121212','Getting Business Permit',2,'generated_pdf_1728842063.pdf',0,0),
('2024-000003',12,NULL,3,'2025-10-14',21,'Drivers License','N42-2010345','Getting Business Permit',3,'generated_pdf_1728842510.pdf',0,0),
('2024-000004',1,NULL,4,'2025-10-14',32,'Drivers License','N42-2010345','Getting Business Permit',4,'generated_pdf_1728842689.pdf',2,0),
('2024-000005',8,NULL,5,'2025-10-14',38,'Drivers License','N42-2010345','Getting Business Permit',5,'generated_pdf_1728842976.pdf',0,0),
('2024-000006',NULL,2,6,'2025-10-14',26,'SSS ID','SSS-1234455677','Securing Building Permit',6,'generated_pdf_1728843584.pdf',0,0),
('2024-000007',NULL,2,7,'2025-10-14',26,'SSS ID','SSS-1234455677','Securing Building Permit',7,'generated_pdf_1728843723.pdf',0,0),
('2024-000008',NULL,2,8,'2025-10-14',26,'SSS ID','SSS-1234455677','Securing Building Permit',8,'generated_pdf_1728843855.pdf',0,0),
('2024-000009',NULL,2,9,'2025-10-14',26,'SSS ID','SSS-1234455677','Securing Building Permit',9,'generated_pdf_1728843888.pdf',0,0),
('2024-000010',NULL,2,10,'2025-10-14',26,'SSS ID','SSS-1234455677','Securing Building Permit',10,'generated_pdf_1728843980.pdf',0,0),
('2024-000011',NULL,2,11,'2025-10-14',26,'SSS ID','SSS-1234455677','Securing Building Permit',11,'generated_pdf_1728844015.pdf',0,0),
('2024-000012',NULL,2,12,'2025-10-14',26,'SSS ID','SSS-1234455677','Securing Building Permit',12,'generated_pdf_1728844076.pdf',0,0),
('2024-000013',NULL,2,13,'2025-10-14',26,'SSS ID','SSS-1234455677','Securing Building Permit',13,'generated_pdf_1728844088.pdf',0,0),
('2024-000014',NULL,2,14,'2025-10-14',26,'SSS ID','SSS-1234455677','Securing Building Permit',14,'generated_pdf_1728844112.pdf',0,0),
('2024-000015',NULL,2,15,'2025-10-14',26,'SSS ID','SSS-1234455677','Securing Building Permit',15,'generated_pdf_1728844229.pdf',0,0),
('2024-000016',NULL,2,16,'2025-10-14',26,'SSS ID','SSS-1234455677','Securing Building Permit',16,'generated_pdf_1728844286.pdf',0,0),
('2024-000017',NULL,2,17,'2025-10-14',26,'SSS ID','SSS-1234455677','Securing Building Permit',17,'generated_pdf_1728844387.pdf',0,0),
('2024-000018',NULL,3,18,'2025-10-14',34,'SSS ID','SSS-1234455677','Securing Building Permit',18,'generated_pdf_1728844523.pdf',0,0),
('2024-000019',NULL,3,19,'2025-10-14',34,'Passport','PASS-1234567898998','Securing Excavation Permit',19,'generated_pdf_1728844836.pdf',0,0),
('2024-000020',NULL,3,20,'2025-10-14',34,'School ID','19-4545454545','Securing Fencing Permit',20,'generated_pdf_1728844935.pdf',0,0),
('2024-000021',8,NULL,21,'2025-10-14',38,'GSIS ID','GSIS-123345567789','Securing Building Permit',21,'generated_pdf_1728880724.pdf',2,0),
('2024-000022',8,NULL,22,'2025-10-14',38,'GSIS ID','GSIS-123345567789','Securing Building Permit',22,'generated_pdf_1728880833.pdf',0,0),
('2024-000023',8,NULL,23,'2025-10-14',38,'GSIS ID','GSIS-123345567789','Securing Building Permit',23,'generated_pdf_1728880864.pdf',0,0),
('2024-000024',12,NULL,24,'2025-10-14',21,'Drivers License','N42-1212121212121','Securing Building Permit',24,'generated_pdf_1728904058.pdf',0,0),
('2024-000025',NULL,1,25,'2025-10-15',26,'NBI Clearance','NBI-12122434345454','Getting Business Permit',25,'generated_pdf_1728994071.pdf',0,0),
('2024-000026',NULL,2,26,'2025-10-16',26,'LTOPF ID','LTOF-1234567890','Getting Business Permit',26,'generated_pdf_1729061539.pdf',0,0),
('2024-000027',NULL,2,27,'2025-10-16',26,'LTOPF ID','LTOF-1234567890','Getting Business Permit',27,'generated_pdf_1729061662.pdf',0,0),
('2024-000028',NULL,2,28,'2025-10-16',26,'LTOPF ID','LTOF-1234567890','Getting Business Permit',28,'generated_pdf_1729061676.pdf',0,0),
('2024-000029',NULL,2,29,'2025-10-16',26,'LTOPF ID','LTOF-1234567890','Getting Business Permit',29,'generated_pdf_1729061693.pdf',0,0),
('2024-000030',NULL,2,30,'2025-10-16',26,'LTOPF ID','LTOF-1234567890','Getting Business Permit',30,'generated_pdf_1729061840.pdf',0,0),
('2024-000031',NULL,1,31,'2025-10-16',26,'Drivers License','N42-12121324343434','Securing Building Permit',31,'generated_pdf_1729061918.pdf',0,0),
('2024-000032',NULL,3,32,'2025-10-16',34,'Postal ID','POS-1234567890','Getting Business Permit',32,'generated_pdf_1729062693.pdf',0,0),
('2024-000033',12,NULL,33,'2025-10-16',22,'School ID','21-00259','Securing Excavation Permit',33,'generated_pdf_1729076195.pdf',0,0),
('2024-000034',8,NULL,34,'2025-01-19',38,'National ID','df4545454545','Verification Purposes',34,'generated_pdf_1729336951.pdf',0,0),
('2024-000035',8,NULL,35,'2025-01-19',38,'NBI Clearance','df4545454545','Medical Assistance',35,'generated_pdf_1729337030.pdf',0,0),
('2024-000036',8,NULL,36,'2025-01-19',38,'NBI Clearance','df4545454545','Medical Assistance',36,'generated_pdf_1729337271.pdf',0,0),
('2024-000037',8,NULL,37,'2025-01-19',38,'NBI Clearance','df4545454545','Medical Assistance',37,'generated_pdf_1729337282.pdf',0,0),
('2024-000038',8,NULL,38,'2025-01-19',38,'NBI Clearance','df4545454545','Medical Assistance',38,'generated_pdf_1729337365.pdf',0,0),
('2024-000039',8,NULL,39,'2025-10-19',38,'Postal ID','df4545454545','Employment',39,'C:/xampp/htdocs//BIMS-with-Template/documents/first_time_job_seeker/generated_pdf_1729337651.pdf',0,0),
('2024-000040',9,NULL,40,'2025-02-09',38,'School ID','19-565698912121','Verification Purposes',40,'generated_pdf_1731146521.pdf',0,0),
('2024-000041',12,NULL,41,'2025-11-14',22,'School ID','21-2100254','Getting Business Permit',41,'generated_pdf_1731570262.pdf',0,0),
('2024-000042',1,NULL,42,'2025-02-15',32,'School ID','21-00254','Maynilad Application',42,'generated_pdf_1731661006.pdf',0,0),
('2024-000043',1,NULL,43,'2025-11-15',32,'School ID','21-00259','Getting Business Permit',43,'generated_pdf_1731661213.pdf',0,0),
('2024-000044',NULL,5,44,'2024-12-18',24,'Drivers License','N42-201045667','Securing TPRS Permit',44,'generated_pdf_1731861495.pdf',0,0),
('2024-000045',NULL,5,45,'2024-12-18',24,'Drivers License','N42-201045667','Securing TPRS Permit',45,'generated_pdf_1731862457.pdf',0,0),
('2024-000046',NULL,5,46,'2024-12-18',24,'Drivers License','N42-201045667','Securing TPRS Permit',46,'generated_pdf_1731862724.pdf',0,0),
('2024-000047',9,NULL,47,'2025-02-18',38,'Police ID','POL-12344545454','Meralco Application',47,'generated_pdf_1731863041.pdf',0,0),
('2024-000048',4,NULL,48,'2025-02-18',31,'Postal ID','1212123232435445','Medical Assistance',48,'generated_pdf_1731863122.pdf',0,0),
('2024-000049',4,NULL,49,'2025-02-18',31,'Postal ID','1212123232435445','Medical Assistance',49,'generated_pdf_1731863374.pdf',0,0),
('2024-000050',1,NULL,50,'2025-02-18',32,'NBI Clearance','fdfsdfsdf','Medical Assistance',50,'generated_pdf_1731863444.pdf',0,0),
('2024-000051',1,NULL,51,'2025-02-18',32,'NBI Clearance','fdfsdfsdf','Medical Assistance',51,'generated_pdf_1731863599.pdf',0,0),
('2024-000052',1,NULL,52,'2025-02-18',32,'Postal ID','PRN-2132323433434','Job Application',52,'generated_pdf_1731890701.pdf',0,0),
('2024-000053',9,NULL,53,'2025-11-18',38,'Postal ID','FBFDCGCDFGCFGFGFDXGD','Employment',53,'generated_pdf_1731891016.pdf',0,0),
('2024-000054',10,NULL,54,'2025-11-18',36,'Drivers License','N42-201064112','Employment',54,'generated_pdf_1731902569.pdf',0,0),
('2024-000055',1,NULL,55,'2025-02-24',32,'PRC ID','12345678910','Maynilad Application',55,'generated_pdf_1732420167.pdf',0,0),
('2024-000056',3,NULL,56,'2025-02-24',30,'NBI Clearance','123232323232323','Meralco Application',56,'generated_pdf_1732422317.pdf',0,0),
('2024-000057',45,NULL,57,'2025-11-25',24,'NBI Clearance','NBI-1234567890','Securing Building Permit',57,'generated_pdf_1732513459.pdf',0,0),
('2024-000058',45,NULL,58,'2025-11-25',24,'NBI Clearance','NBI-1234567890','Securing Building Permit',58,'generated_pdf_1732513474.pdf',0,0),
('2024-000059',45,NULL,59,'2025-11-25',24,'NBI Clearance','NBI-1234567890','Securing Building Permit',59,'generated_pdf_1732513541.pdf',0,0),
('2024-000060',1,NULL,60,'2025-02-25',32,'Solo Parent ID','122313232323232','Meralco Application',60,'generated_pdf_1732529327.pdf',0,0),
('2024-000061',1,NULL,61,'2025-02-25',32,'Solo Parent ID','122313232323232','Meralco Application',61,'generated_pdf_1732529358.pdf',0,0),
('2024-000062',1,NULL,62,'2025-02-25',32,'Police ID','123455656565','Meralco Application',62,'generated_pdf_1732530262.pdf',0,0),
('2024-000063',4,NULL,63,'2025-02-25',31,'PRC ID','123456789555','Meralco Application',63,'generated_pdf_1732531234.pdf',0,0),
('2024-000064',8,NULL,64,'2025-02-25',38,'GSIS ID','12345678','Scholarship Grants',64,'generated_pdf_1732531324.pdf',0,0),
('2024-000065',10,NULL,65,'2025-02-26',36,'Senior ID','121i2981278371278361327','Maynilad Application',65,'generated_pdf_1732634788.pdf',0,0),
('2024-000066',19,NULL,66,'2025-02-26',23,'Senior ID','121i2981278371278361327','Verification Purposes',66,'generated_pdf_1732634930.pdf',0,0),
('2024-000067',9,NULL,67,'2025-02-27',38,'GSIS ID','123456767898990','Meralco Application',67,'generated_pdf_1732637175.pdf',0,0),
('2024-000068',6,NULL,68,'2025-02-27',36,'GSIS ID','123456767898990','Maynilad Application',68,'generated_pdf_1732637895.pdf',0,0),
('2024-000069',6,NULL,69,'2025-02-27',36,'Drivers License','N42-1212121212121','To any legal purpose',69,'generated_pdf_1732638317.pdf',0,0),
('2024-000070',6,NULL,70,'2025-02-27',36,'National ID','PRN-12345678900','Medical Assistance',70,'generated_pdf_1732638419.pdf',0,0),
('2024-000071',19,NULL,71,'2025-02-27',23,'School ID','21-00259','Job Application',71,'generated_pdf_1732668291.pdf',0,0),
('2024-000072',6,NULL,72,'2025-02-27',36,'School ID','21-00259','Job Application',72,'generated_pdf_1732668384.pdf',0,0),
('2024-000073',6,NULL,73,'2025-02-27',36,'School ID','21-00259','Verification Purposes',73,'generated_pdf_1732668531.pdf',0,0),
('2024-000074',NULL,2,74,'2024-12-27',26,'Postal ID','POS-12132435445465756','Securing TPRS Permit',74,'generated_pdf_1732672422.pdf',0,0),
('2024-000075',NULL,2,75,'2024-12-27',26,'Postal ID','POS-1212323434343443','Securing TPRS Permit',75,'generated_pdf_1732672672.pdf',0,0),
('2024-000076',NULL,2,76,'2024-12-27',26,'Drivers License','N423232323232','Securing TPRS Permit',76,'generated_pdf_1732672934.pdf',0,0),
('2024-000077',NULL,2,77,'2024-12-27',26,'National ID','dmjskdckjsndcksd','Securing TPRS Permit',77,'generated_pdf_1732673027.pdf',0,0),
('2024-000078',NULL,6,78,'2024-12-27',34,'Postal ID','2312312312312','Securing TPRS Permit',78,'generated_pdf_1732673402.pdf',0,0),
('2024-000079',NULL,6,79,'2024-12-27',34,'National ID','ffrefwefwer32432423','Securing TPRS Permit',79,'generated_pdf_1732673485.pdf',0,0),
('2024-000080',NULL,3,80,'2024-12-27',34,'Postal ID','3rew3r2332','Securing TPRS Permit',80,'generated_pdf_1732673527.pdf',0,0),
('2024-000081',NULL,5,81,'2024-12-27',24,'Drivers License','N42-32323232323232','Securing TPRS Permit',81,'generated_pdf_1732673582.pdf',0,0),
('2024-000082',NULL,1,82,'2024-12-27',26,'Voters ID','234234234','Securing TPRS Permit',82,'generated_pdf_1732673638.pdf',0,0),
('2024-000083',NULL,6,83,'2024-12-27',34,'Voters ID','121221312312312','Securing TPRS Permit',83,'generated_pdf_1732673828.pdf',0,0),
('2024-000084',NULL,6,84,'2024-12-27',34,'Voters ID','121221312312312','Securing TPRS Permit',84,'generated_pdf_1732673882.pdf',0,0),
('2024-000085',NULL,6,85,'2024-12-27',34,'Voters ID','121221312312312','Securing TPRS Permit',85,'generated_pdf_1732673906.pdf',0,0),
('2024-000086',NULL,6,86,'2024-12-27',34,'Voters ID','121221312312312','Securing TPRS Permit',86,'generated_pdf_1732677673.pdf',0,0),
('2024-000087',NULL,6,87,'2025-11-27',34,'Postal ID','POS-1232334354546456','Securing Building Permit',87,'generated_pdf_1732678848.pdf',0,0),
('2024-000088',NULL,6,88,'2025-11-27',34,'Postal ID','POS-1232334354546456','Securing Building Permit',88,'generated_pdf_1732680231.pdf',0,0),
('2024-000089',NULL,6,89,'2025-11-27',34,'Postal ID','POS-1232334354546456','Securing Building Permit',89,'generated_pdf_1732681159.pdf',0,0),
('2024-000090',NULL,6,90,'2025-11-27',34,'Postal ID','POS-1232334354546456','Securing Building Permit',90,'generated_pdf_1732681259.pdf',0,0),
('2024-000091',NULL,12,91,'2025-11-27',41,'Postal ID','POS-1232334354546456','Securing Building Permit',91,'generated_pdf_1732681557.pdf',0,0),
('2024-000092',NULL,12,92,'2025-11-27',41,'Postal ID','POS-1232334354546456','Securing Building Permit',92,'generated_pdf_1732682640.pdf',0,0),
('2024-000093',NULL,1,93,'2025-11-27',26,'Senior ID','SEN-11283787236472364','Getting Business Permit',93,'generated_pdf_1732684463.pdf',0,0),
('2024-000094',NULL,16,94,'2025-11-27',0,'GSIS ID','1212232323232','Securing Excavation Permit',94,'generated_pdf_1732688643.pdf',0,0),
('2024-000095',NULL,5,95,'2025-11-27',24,'SSS ID','218298178371273612','Securing Fencing Permit',95,'generated_pdf_1732688897.pdf',0,0),
('2024-000096',NULL,2,96,'2025-11-27',26,'GSIS ID','1212121212121212','Securing Fencing Permit',96,'generated_pdf_1732689266.pdf',0,1),
('2024-000097',18,NULL,97,'2025-02-27',22,'National ID','PCN-122343534554655443344','Legal Aid',97,'generated_pdf_1732689433.pdf',0,0),
('2024-000098',9,NULL,98,'2025-03-01',38,'Drivers License','N42-1212121212121212','Maynilad Application',98,'generated_pdf_1733032627.pdf',0,0);

/*Table structure for table `tbl_documents` */

DROP TABLE IF EXISTS `tbl_documents`;

CREATE TABLE `tbl_documents` (
  `docu_id` int(55) NOT NULL AUTO_INCREMENT,
  `Barangay_Clearance` int(55) DEFAULT NULL,
  `Certificate_of_Residency` int(55) DEFAULT NULL,
  `Certificate_of_Indigency` int(55) DEFAULT NULL,
  `Certificate_of_Good_Moral` int(55) DEFAULT NULL,
  `FTJS` int(55) DEFAULT NULL,
  `Oath_of_Undertaking` int(55) DEFAULT NULL,
  `Business_Permits` int(55) DEFAULT NULL,
  `Building_Permits` int(55) DEFAULT NULL,
  `Excavation_Permits` int(55) DEFAULT NULL,
  `Fencing_Permits` int(55) DEFAULT NULL,
  `TPRS` int(55) DEFAULT NULL,
  PRIMARY KEY (`docu_id`),
  KEY `f_permit_fk` (`Fencing_Permits`),
  KEY `bpermit_fk` (`Business_Permits`),
  KEY `build_permit_fk` (`Building_Permits`),
  KEY `tprs_fk` (`TPRS`),
  KEY `exca_fk` (`Excavation_Permits`),
  KEY `indigency_fk` (`Certificate_of_Indigency`),
  CONSTRAINT `bpermit_fk` FOREIGN KEY (`Business_Permits`) REFERENCES `tbl_business_permits` (`business_id`) ON DELETE CASCADE,
  CONSTRAINT `build_permit_fk` FOREIGN KEY (`Building_Permits`) REFERENCES `tbl_building_permits` (`building_permit_id`) ON DELETE CASCADE,
  CONSTRAINT `exca_fk` FOREIGN KEY (`Excavation_Permits`) REFERENCES `tbl_excavation_permits` (`exca_permit_id`) ON DELETE CASCADE,
  CONSTRAINT `f_permit_fk` FOREIGN KEY (`Fencing_Permits`) REFERENCES `tbl_fencing_permit` (`fencing_permit_id`) ON DELETE CASCADE,
  CONSTRAINT `indigency_fk` FOREIGN KEY (`Certificate_of_Indigency`) REFERENCES `tbl_indigency` (`indigency_id`) ON DELETE CASCADE,
  CONSTRAINT `tprs_fk` FOREIGN KEY (`TPRS`) REFERENCES `tbl_tprs` (`tprs_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_documents` */

insert  into `tbl_documents`(`docu_id`,`Barangay_Clearance`,`Certificate_of_Residency`,`Certificate_of_Indigency`,`Certificate_of_Good_Moral`,`FTJS`,`Oath_of_Undertaking`,`Business_Permits`,`Building_Permits`,`Excavation_Permits`,`Fencing_Permits`,`TPRS`) values 
(1,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(2,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL),
(3,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,NULL,NULL,NULL),
(4,NULL,NULL,NULL,NULL,NULL,NULL,3,NULL,NULL,NULL,NULL),
(5,NULL,NULL,NULL,NULL,NULL,NULL,4,NULL,NULL,NULL,NULL),
(6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,NULL,NULL),
(8,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,NULL,NULL,NULL),
(9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,NULL,NULL,NULL),
(10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,5,NULL,NULL,NULL),
(11,NULL,NULL,NULL,NULL,NULL,NULL,NULL,6,NULL,NULL,NULL),
(12,NULL,NULL,NULL,NULL,NULL,NULL,NULL,7,NULL,NULL,NULL),
(13,NULL,NULL,NULL,NULL,NULL,NULL,NULL,8,NULL,NULL,NULL),
(14,NULL,NULL,NULL,NULL,NULL,NULL,NULL,9,NULL,NULL,NULL),
(15,NULL,NULL,NULL,NULL,NULL,NULL,NULL,10,NULL,NULL,NULL),
(16,NULL,NULL,NULL,NULL,NULL,NULL,NULL,11,NULL,NULL,NULL),
(17,NULL,NULL,NULL,NULL,NULL,NULL,NULL,12,NULL,NULL,NULL),
(18,NULL,NULL,NULL,NULL,NULL,NULL,NULL,13,NULL,NULL,NULL),
(19,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL),
(20,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL),
(21,NULL,NULL,NULL,NULL,NULL,NULL,NULL,14,NULL,NULL,NULL),
(22,NULL,NULL,NULL,NULL,NULL,NULL,NULL,15,NULL,NULL,NULL),
(23,NULL,NULL,NULL,NULL,NULL,NULL,NULL,16,NULL,NULL,NULL),
(24,NULL,NULL,NULL,NULL,NULL,NULL,NULL,17,NULL,NULL,NULL),
(25,NULL,NULL,NULL,NULL,NULL,NULL,5,NULL,NULL,NULL,NULL),
(26,NULL,NULL,NULL,NULL,NULL,NULL,6,NULL,NULL,NULL,NULL),
(27,NULL,NULL,NULL,NULL,NULL,NULL,7,NULL,NULL,NULL,NULL),
(28,NULL,NULL,NULL,NULL,NULL,NULL,8,NULL,NULL,NULL,NULL),
(29,NULL,NULL,NULL,NULL,NULL,NULL,9,NULL,NULL,NULL,NULL),
(30,NULL,NULL,NULL,NULL,NULL,NULL,10,NULL,NULL,NULL,NULL),
(31,NULL,NULL,NULL,NULL,NULL,NULL,NULL,18,NULL,NULL,NULL),
(32,NULL,NULL,NULL,NULL,NULL,NULL,11,NULL,NULL,NULL,NULL),
(33,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,NULL),
(34,NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(35,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(36,NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(37,NULL,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(38,NULL,NULL,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(39,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),
(40,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(41,NULL,NULL,NULL,NULL,NULL,NULL,12,NULL,NULL,NULL,NULL),
(42,NULL,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(43,NULL,NULL,NULL,NULL,NULL,NULL,13,NULL,NULL,NULL,NULL),
(44,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),
(45,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2),
(46,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3),
(47,NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(48,NULL,NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(49,NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(50,NULL,NULL,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(51,NULL,NULL,8,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(52,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(53,NULL,NULL,NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,NULL),
(54,NULL,NULL,NULL,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL),
(55,NULL,6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(56,NULL,NULL,9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(57,NULL,NULL,NULL,NULL,NULL,NULL,NULL,19,NULL,NULL,NULL),
(58,NULL,NULL,NULL,NULL,NULL,NULL,NULL,20,NULL,NULL,NULL),
(59,NULL,NULL,NULL,NULL,NULL,NULL,NULL,21,NULL,NULL,NULL),
(60,NULL,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(61,NULL,8,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(62,NULL,NULL,10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(63,NULL,9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(64,NULL,NULL,11,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(65,NULL,10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(66,NULL,11,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(67,NULL,12,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(68,NULL,13,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(69,NULL,14,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(70,NULL,NULL,12,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(71,NULL,NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(72,NULL,NULL,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(73,NULL,NULL,NULL,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(74,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4),
(75,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,5),
(76,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,6),
(77,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,7),
(78,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,8),
(79,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,9),
(80,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,10),
(81,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,11),
(82,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,12),
(83,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,13),
(84,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,14),
(85,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,15),
(86,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,16),
(87,NULL,NULL,NULL,NULL,NULL,NULL,NULL,22,NULL,NULL,NULL),
(88,NULL,NULL,NULL,NULL,NULL,NULL,NULL,23,NULL,NULL,NULL),
(89,NULL,NULL,NULL,NULL,NULL,NULL,NULL,24,NULL,NULL,NULL),
(90,NULL,NULL,NULL,NULL,NULL,NULL,NULL,25,NULL,NULL,NULL),
(91,NULL,NULL,NULL,NULL,NULL,NULL,NULL,26,NULL,NULL,NULL),
(92,NULL,NULL,NULL,NULL,NULL,NULL,NULL,27,NULL,NULL,NULL),
(93,NULL,NULL,NULL,NULL,NULL,NULL,14,NULL,NULL,NULL,NULL),
(94,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,NULL,NULL),
(95,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL),
(96,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,NULL),
(97,NULL,NULL,13,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(98,NULL,15,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `tbl_documents_audit` */

DROP TABLE IF EXISTS `tbl_documents_audit`;

CREATE TABLE `tbl_documents_audit` (
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `action_type` enum('INSERT','UPDATE','DELETE','RECOVER') NOT NULL,
  `action_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_no` int(11) DEFAULT NULL,
  `dept_no` int(11) DEFAULT NULL,
  `is_deleted` tinyint(2) DEFAULT '0',
  `resident_no` int(55) DEFAULT NULL,
  `nresident_no` int(55) DEFAULT NULL,
  `document_no` int(55) DEFAULT NULL,
  `action_data` json DEFAULT NULL,
  PRIMARY KEY (`audit_id`),
  KEY `user_no` (`user_no`),
  KEY `dept_no` (`dept_no`),
  KEY `resident_no` (`resident_no`),
  KEY `nresident_no` (`nresident_no`),
  KEY `document_no` (`document_no`),
  CONSTRAINT `tbl_documents_audit_ibfk_1` FOREIGN KEY (`resident_no`) REFERENCES `resident` (`resident_id`),
  CONSTRAINT `tbl_documents_audit_ibfk_2` FOREIGN KEY (`nresident_no`) REFERENCES `non_resident` (`nresident_id`),
  CONSTRAINT `tbl_documents_audit_ibfk_3` FOREIGN KEY (`document_no`) REFERENCES `tbl_documents` (`docu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_documents_audit` */

insert  into `tbl_documents_audit`(`audit_id`,`action_type`,`action_timestamp`,`user_no`,`dept_no`,`is_deleted`,`resident_no`,`nresident_no`,`document_no`,`action_data`) values 
(1,'UPDATE','2024-12-01 00:07:46',1,4,0,18,NULL,97,'{\"new_values\": {\"ID_number\": \"45454545454545454545\", \"is_deleted\": 0, \"presented_id\": \"Drivers License\", \"expiration_date\": \"2025-02-27\"}, \"old_values\": {\"ID_number\": \"23i2738127313\", \"is_deleted\": 0, \"presented_id\": \"GSIS ID\", \"expiration_date\": \"2025-02-27\"}}'),
(2,'RECOVER','2024-12-01 00:21:10',1,4,0,3,NULL,56,'{\"new_values\": {\"ID_number\": \"123232323232323\", \"is_deleted\": 0, \"presented_id\": \"NBI Clearance\", \"expiration_date\": \"2025-02-24\"}, \"old_values\": {\"is_deleted\": 1}}'),
(3,'RECOVER','2024-12-01 00:35:01',1,4,0,1,NULL,52,'{\"new_values\": {\"ID_number\": \"PRN-2132323433434\", \"is_deleted\": 0, \"presented_id\": \"Postal ID\", \"expiration_date\": \"2025-02-18\"}, \"old_values\": {\"is_deleted\": 1}}'),
(4,'DELETE','2024-12-01 00:48:49',1,4,1,NULL,2,96,'{\"new_values\": {\"ID_number\": \"1212121212121212\", \"is_deleted\": 1, \"presented_id\": \"GSIS ID\", \"expiration_date\": \"2025-11-27\"}, \"old_values\": {\"is_deleted\": 0}}'),
(5,'UPDATE','2024-12-01 10:29:01',4,2,0,18,NULL,97,'{\"new_values\": {\"ID_number\": \"PCN-122343534554655443344\", \"is_deleted\": 0, \"presented_id\": \"National ID\", \"expiration_date\": \"2025-02-27\"}, \"old_values\": {\"ID_number\": \"45454545454545454545\", \"is_deleted\": 0, \"presented_id\": \"Drivers License\", \"expiration_date\": \"2025-02-27\"}}'),
(6,'INSERT','2024-12-01 13:57:07',1,4,0,9,NULL,98,'{\"ID_number\": \"N42-1212121212121212\", \"is_deleted\": 0, \"presented_id\": \"Drivers License\", \"expiration_date\": \"2025-03-01\"}');

/*Table structure for table `tbl_excavation_permits` */

DROP TABLE IF EXISTS `tbl_excavation_permits`;

CREATE TABLE `tbl_excavation_permits` (
  `exca_permit_id` int(55) NOT NULL AUTO_INCREMENT,
  `blg_house_no` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `subd` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`exca_permit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_excavation_permits` */

insert  into `tbl_excavation_permits`(`exca_permit_id`,`blg_house_no`,`street`,`subd`) values 
(1,'12','Zabarte',''),
(2,'Blk 8 Lot 4','Jeremiah st','Cielito Homes'),
(3,'32','Zabarte Rd','');

/*Table structure for table `tbl_fencing_permit` */

DROP TABLE IF EXISTS `tbl_fencing_permit`;

CREATE TABLE `tbl_fencing_permit` (
  `fencing_permit_id` int(55) NOT NULL AUTO_INCREMENT,
  `blg_house_no` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `subd` varchar(255) DEFAULT NULL,
  `estate_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`fencing_permit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_fencing_permit` */

insert  into `tbl_fencing_permit`(`fencing_permit_id`,`blg_house_no`,`street`,`subd`,`estate_type`) values 
(1,'12','Zabarte','','Commercial'),
(2,'Blk 12 Lot 21','Ping Lacson st','Capitol Parkland','Residencial'),
(3,'Blk 12 Lot 15','Jasmine st','Kassel Villas','Residencial');

/*Table structure for table `tbl_indigency` */

DROP TABLE IF EXISTS `tbl_indigency`;

CREATE TABLE `tbl_indigency` (
  `indigency_id` int(55) NOT NULL AUTO_INCREMENT,
  `agency` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`indigency_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_indigency` */

insert  into `tbl_indigency`(`indigency_id`,`agency`) values 
(1,'Public Attorneys Office'),
(2,'PCSO'),
(3,'PCSO'),
(4,'PCSO'),
(5,'PCSO'),
(6,'PCSO'),
(7,'PCSO'),
(8,'PCSO'),
(9,'Meralco Indigent Program'),
(10,'PCSO'),
(11,'Sa Isang Foundation'),
(12,'Malasakit Center'),
(13,'Public Attorneys Office');

/*Table structure for table `tbl_other_complainants` */

DROP TABLE IF EXISTS `tbl_other_complainants`;

CREATE TABLE `tbl_other_complainants` (
  `complainant_id` int(55) NOT NULL AUTO_INCREMENT,
  `res_person_1` int(55) DEFAULT NULL,
  `nres_person_1` int(55) DEFAULT NULL,
  `res_person_2` int(55) DEFAULT NULL,
  `nres_person_2` int(55) DEFAULT NULL,
  `res_person_3` int(55) DEFAULT NULL,
  `nres_person_3` int(55) DEFAULT NULL,
  `res_person_4` int(55) DEFAULT NULL,
  `nres_person_4` int(55) DEFAULT NULL,
  `res_person_5` int(55) DEFAULT NULL,
  `nres_person_5` int(55) DEFAULT NULL,
  PRIMARY KEY (`complainant_id`),
  KEY `res_person_1` (`res_person_1`),
  KEY `nres_person_1` (`nres_person_1`),
  KEY `res_person_2` (`res_person_2`),
  KEY `nres_person_2` (`nres_person_2`),
  CONSTRAINT `tbl_other_complainants_ibfk_1` FOREIGN KEY (`res_person_1`) REFERENCES `resident` (`resident_id`),
  CONSTRAINT `tbl_other_complainants_ibfk_2` FOREIGN KEY (`nres_person_1`) REFERENCES `non_resident` (`nresident_id`),
  CONSTRAINT `tbl_other_complainants_ibfk_3` FOREIGN KEY (`res_person_2`) REFERENCES `resident` (`resident_id`),
  CONSTRAINT `tbl_other_complainants_ibfk_4` FOREIGN KEY (`nres_person_2`) REFERENCES `non_resident` (`nresident_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_other_complainants` */

insert  into `tbl_other_complainants`(`complainant_id`,`res_person_1`,`nres_person_1`,`res_person_2`,`nres_person_2`,`res_person_3`,`nres_person_3`,`res_person_4`,`nres_person_4`,`res_person_5`,`nres_person_5`) values 
(1,9,1,16,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(2,NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(3,NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(8,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(11,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(12,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(13,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(14,8,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(15,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(16,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `tbl_other_respondents` */

DROP TABLE IF EXISTS `tbl_other_respondents`;

CREATE TABLE `tbl_other_respondents` (
  `respondent_id` int(55) NOT NULL AUTO_INCREMENT,
  `res_person_1` int(55) DEFAULT NULL,
  `nres_person_1` int(55) DEFAULT NULL,
  `res_person_2` int(55) DEFAULT NULL,
  `nres_person_2` int(55) DEFAULT NULL,
  `res_person_3` int(55) DEFAULT NULL,
  `nres_person_3` int(55) DEFAULT NULL,
  `res_person_4` int(55) DEFAULT NULL,
  `nres_person_4` int(55) DEFAULT NULL,
  `res_person_5` int(55) DEFAULT NULL,
  `nres_person_5` int(55) DEFAULT NULL,
  PRIMARY KEY (`respondent_id`),
  KEY `res_person_1` (`res_person_1`),
  KEY `nres_person_1` (`nres_person_1`),
  KEY `res_person_2` (`res_person_2`),
  KEY `nres_person_2` (`nres_person_2`),
  KEY `res_person_3` (`res_person_3`),
  KEY `nres_person_3` (`nres_person_3`),
  KEY `res_person_4` (`res_person_4`),
  KEY `nres_person_4` (`nres_person_4`),
  KEY `res_person_5` (`res_person_5`),
  KEY `nres_person_5` (`nres_person_5`),
  CONSTRAINT `tbl_other_respondents_ibfk_1` FOREIGN KEY (`res_person_1`) REFERENCES `resident` (`resident_id`),
  CONSTRAINT `tbl_other_respondents_ibfk_10` FOREIGN KEY (`nres_person_5`) REFERENCES `non_resident` (`nresident_id`),
  CONSTRAINT `tbl_other_respondents_ibfk_2` FOREIGN KEY (`nres_person_1`) REFERENCES `non_resident` (`nresident_id`),
  CONSTRAINT `tbl_other_respondents_ibfk_3` FOREIGN KEY (`res_person_2`) REFERENCES `resident` (`resident_id`),
  CONSTRAINT `tbl_other_respondents_ibfk_4` FOREIGN KEY (`nres_person_2`) REFERENCES `non_resident` (`nresident_id`),
  CONSTRAINT `tbl_other_respondents_ibfk_5` FOREIGN KEY (`res_person_3`) REFERENCES `resident` (`resident_id`),
  CONSTRAINT `tbl_other_respondents_ibfk_6` FOREIGN KEY (`nres_person_3`) REFERENCES `non_resident` (`nresident_id`),
  CONSTRAINT `tbl_other_respondents_ibfk_7` FOREIGN KEY (`res_person_4`) REFERENCES `resident` (`resident_id`),
  CONSTRAINT `tbl_other_respondents_ibfk_8` FOREIGN KEY (`nres_person_4`) REFERENCES `non_resident` (`nresident_id`),
  CONSTRAINT `tbl_other_respondents_ibfk_9` FOREIGN KEY (`res_person_5`) REFERENCES `resident` (`resident_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_other_respondents` */

insert  into `tbl_other_respondents`(`respondent_id`,`res_person_1`,`nres_person_1`,`res_person_2`,`nres_person_2`,`res_person_3`,`nres_person_3`,`res_person_4`,`nres_person_4`,`res_person_5`,`nres_person_5`) values 
(1,8,NULL,19,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(8,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(11,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(12,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(13,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(14,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(15,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(16,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `tbl_tprs` */

DROP TABLE IF EXISTS `tbl_tprs`;

CREATE TABLE `tbl_tprs` (
  `tprs_id` int(50) NOT NULL AUTO_INCREMENT,
  `toda` varchar(255) NOT NULL,
  `route` varchar(255) NOT NULL,
  `platenum` varchar(255) NOT NULL,
  `chasisnum` varchar(255) NOT NULL,
  `makertype` varchar(255) NOT NULL,
  `enginenum` varchar(255) NOT NULL,
  PRIMARY KEY (`tprs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_tprs` */

insert  into `tbl_tprs`(`tprs_id`,`toda`,`route`,`platenum`,`chasisnum`,`makertype`,`enginenum`) values 
(1,'CCCH TODA','Camarin','11223 UJQ','2NZ-345454333','Kawazaki','N42-JD9IU938490QEW'),
(2,'CCCH TODA','Camarin','11223 UJQ','2NZ-345454333','Kawazaki','N42-JD9IU938490QEW'),
(3,'CCCH TODA','Camarin','11223 UJQ','2NZ-345454333','Kawazaki','N42-JD9IU938490QEW'),
(4,'MACATODA','Camarin Maligaya Vice Versa','WOJ944','15454545454545','Suzuki','DE-21322334343434'),
(5,'MACATODA','Maligaya-Camarin Vice Versa','545454545454','454545454','Kawazaki','4545454545454'),
(6,'MACATODA','Maligaya - Camarin','5454545454','4545454545','Kawazaki','5545454545'),
(7,'ddslkmlskd','sfsdlmfksdm','lmfldsmclksdmfdsn','lsamdslmfksldm','Kawazaki','smdaslmdfl'),
(8,'CCCH TODA','Cielito Maria Luisa','dskfmseklfnsaklndf','sdkfnskdlnfskl','Kawazaki','ojdfsdklmncslkdn'),
(9,'4324324','23432432','342342','324234','Honda','342342342'),
(10,'432423','432423','432423','32423','Kawazaki','342342'),
(11,'12123123123','321312312','312312312','213123123','Kawazaki','1223123123123'),
(12,'34234234','32432423','324324','324324324','Suzuki','42342342'),
(13,'2312312312312','2131231231231','2131232131','231231231212','Suzuki','21312313123'),
(14,'2312312312312','2131231231231','2131232131','231231231212','Suzuki','21312313123'),
(15,'2312312312312','2131231231231','2131232131','231231231212','Suzuki','21312313123'),
(16,'2312312312312','2131231231231','2131232131','231231231212','Suzuki','21312313123');

/*Table structure for table `tbl_username` */

DROP TABLE IF EXISTS `tbl_username`;

CREATE TABLE `tbl_username` (
  `username_id` int(55) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`username_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_username` */

insert  into `tbl_username`(`username_id`,`username`) values 
(1,'RobertPrower'),
(2,'AteAnna'),
(3,'Francis'),
(4,'Francis12'),
(5,'JohnRin12'),
(6,'RobertSalas');

/*Table structure for table `tbl_users` */

DROP TABLE IF EXISTS `tbl_users`;

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username_no` int(55) NOT NULL,
  `pword` varchar(255) NOT NULL,
  `img_filename` varchar(255) NOT NULL,
  `fname` varchar(55) NOT NULL,
  `mname` varchar(55) DEFAULT NULL,
  `lname` varchar(55) NOT NULL,
  `suffix` varchar(55) DEFAULT NULL,
  `depart_no` int(55) NOT NULL,
  `user_at_no` int(55) NOT NULL,
  `isactive` tinyint(11) NOT NULL DEFAULT '0',
  `isdeleted` tinyint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `username_fk` (`username_no`),
  KEY `depart_fk` (`depart_no`),
  KEY `user_at_no` (`user_at_no`),
  CONSTRAINT `depart_fk` FOREIGN KEY (`depart_no`) REFERENCES `departments_list` (`department_id`),
  CONSTRAINT `tbl_users_ibfk_1` FOREIGN KEY (`user_at_no`) REFERENCES `tbl_users_audit_trail` (`user_at_id`),
  CONSTRAINT `username_fk` FOREIGN KEY (`username_no`) REFERENCES `tbl_username` (`username_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_users` */

insert  into `tbl_users`(`user_id`,`username_no`,`pword`,`img_filename`,`fname`,`mname`,`lname`,`suffix`,`depart_no`,`user_at_no`,`isactive`,`isdeleted`) values 
(1,1,'$2y$10$S4TBGbekXSy8iFzm88xmGetm8S.nYmOqB4j3FmNv9qcGA4M.8Ol8e','715a5404857b4d3cfdbd2747e2eaac79.jpg','Robert','Lumauig','Salas','',4,1,1,0),
(2,2,'$2y$10$wB0B16FNxf3p2bN4H96P2uQHvAeqIAhUAz8un6gMFnHBlhO.3zw5e','ab67706c0000da84dc7f5b89d9dd705a9e1a8e4f.jpg','Anna','','De Gana','',1,2,0,0),
(3,3,'$2y$10$y/7ZKZMNkd4rU4MJos7wsOuOPR6xJghztEj.IzqChEHQtl4xbfuGu','465560047_3983565665304630_891432138380119720_n.jpg','Francis','','Obo','',2,3,0,1),
(4,4,'$2y$10$CdG1ZZhj7EAv4LWWk8f3UexcPTpdEGz1ZG8fMNtPL0DUGM9y7svZe','465560047_3983565665304630_891432138380119720_n (1).jpg','Francis','','Obo','',2,4,0,0),
(5,5,'$2y$10$iatVIZ7wHxSWYWhHSIiBPueoMzssg.b1mXzuZL5dRUscJop0hbyrW','462570570_1859289424892345_8887677385207056678_n (11).jpg','John Rin','Mark','Hofileña','',3,5,0,0),
(6,6,'$2y$10$R3sKrZEdoKBIBL.ErisZbuLtHw956.ZrdZrMNM5Ar3ffw0p72TMoW','capture_1732812358.jpg','Robert','','Salas','',1,6,0,0);

/*Table structure for table `tbl_users_audit_trail` */

DROP TABLE IF EXISTS `tbl_users_audit_trail`;

CREATE TABLE `tbl_users_audit_trail` (
  `user_at_id` int(55) NOT NULL AUTO_INCREMENT,
  `created_dt` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(55) DEFAULT NULL,
  `last_edited_by` int(55) DEFAULT NULL,
  `last_edited_dt` datetime DEFAULT NULL,
  `deleted_by` int(55) DEFAULT NULL,
  `deleted_dt` datetime DEFAULT NULL,
  `recovered_by` int(55) DEFAULT NULL,
  `recovered_dt` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`user_at_id`),
  KEY `created_by` (`created_by`),
  KEY `last_edited_by` (`last_edited_by`),
  KEY `deleted_by` (`deleted_by`),
  KEY `recovered_by` (`recovered_by`),
  CONSTRAINT `tbl_users_audit_trail_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `tbl_username` (`username_id`) ON UPDATE NO ACTION,
  CONSTRAINT `tbl_users_audit_trail_ibfk_2` FOREIGN KEY (`last_edited_by`) REFERENCES `tbl_username` (`username_id`) ON UPDATE NO ACTION,
  CONSTRAINT `tbl_users_audit_trail_ibfk_3` FOREIGN KEY (`deleted_by`) REFERENCES `tbl_username` (`username_id`) ON UPDATE NO ACTION,
  CONSTRAINT `tbl_users_audit_trail_ibfk_4` FOREIGN KEY (`recovered_by`) REFERENCES `tbl_username` (`username_id`) ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_users_audit_trail` */

insert  into `tbl_users_audit_trail`(`user_at_id`,`created_dt`,`created_by`,`last_edited_by`,`last_edited_dt`,`deleted_by`,`deleted_dt`,`recovered_by`,`recovered_dt`,`last_login`) values 
(1,'2024-11-22 04:04:26',1,NULL,NULL,NULL,NULL,NULL,NULL,'2024-12-01 16:55:32'),
(2,'2024-11-22 04:05:27',1,NULL,NULL,1,'2024-11-22 23:15:25',1,'2024-11-22 22:50:00','2024-11-22 04:23:33'),
(3,'2024-11-28 13:07:57',1,NULL,NULL,1,'2024-11-28 21:48:01',NULL,NULL,NULL),
(4,'2024-11-28 13:08:11',1,NULL,NULL,NULL,NULL,NULL,NULL,'2024-12-01 11:07:15'),
(5,'2024-11-28 18:54:03',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(6,'2024-11-29 00:14:02',1,1,'2024-11-29 00:45:58',NULL,NULL,NULL,NULL,NULL);

/* Trigger structure for table `non_resident` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `trig_ainc_nonres_at` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `trig_ainc_nonres_at` BEFORE INSERT ON `non_resident` FOR EACH ROW BEGIN
    
      DECLARE new_id INT;
      
     SET new_id = (SELECT MAX(audit_trail_no) FROM non_resident) + 1;
    IF new_id IS NULL THEN
        SET new_id = 1;
    END IF;
    SET NEW.audit_trail_no = new_id;
   
    END */$$


DELIMITER ;

/* Trigger structure for table `non_resident` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `non_resident_add_audit` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `non_resident_add_audit` AFTER INSERT ON `non_resident` FOR EACH ROW BEGIN
    -- Declare variables
    DECLARE user_no INT;
    DECLARE dept_no INT;

    -- Safely retrieve user and department numbers from the audit trail table
    SELECT `user_added_no`, `dept_added_no`
    INTO user_no, dept_no
    FROM `nonres_audit_trail`
    WHERE audit_trail_id = NEW.nresident_id 
    LIMIT 1;

    -- Insert into nonresident_audit table
    INSERT INTO nonresident_audit (
        nresident_id, action_type, user_no, dept_no, is_deleted, last_name, first_name, action_data
    )
    VALUES (
        NEW.nresident_id, 
        'INSERT', 
        user_no, 
        dept_no, 
        NEW.is_deleted, 
        NEW.last_name, 
        NEW.first_name,
        JSON_OBJECT(
            'img_filename', NEW.img_filename,
            'last_name', NEW.last_name,
            'first_name', NEW.first_name,
            'middle_name', NEW.middle_name,
            'suffix', NEW.suffix,
            'house_num', NEW.house_num,
            'street', NEW.street,
            'subdivision', NEW.subdivision,
            'district_brgy', NEW.district_brgy,
            'city', NEW.city,
            'province', NEW.province,
            'zipcode', NEW.zipcode,
            'sex', NEW.sex,
            'marital_status', NEW.marital_status,
            'birth_place', NEW.birth_place,
            'birth_date', NEW.birth_date,
            'cellphone_num', NEW.cellphone_num
        )
    );
END */$$


DELIMITER ;

/* Trigger structure for table `non_resident` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `non_resident_update_audit` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `non_resident_update_audit` BEFORE UPDATE ON `non_resident` FOR EACH ROW 
BEGIN
    DECLARE user_no INT;
    DECLARE dept_no INT;

    -- Check if the `is_deleted` column is being updated to 1
    IF OLD.is_deleted = 0 AND NEW.is_deleted = 1 THEN
        SELECT `user_deleted_no`, `dept_deleted_no`
        INTO user_no, dept_no
        FROM `nonres_audit_trail`
        WHERE `audit_trail_id` = NEW.nresident_id
        LIMIT 1;

        INSERT INTO nonresident_audit (
            nresident_id, action_type, user_no, dept_no, is_deleted, last_name, first_name, action_data
        )
        VALUES (
            OLD.nresident_id,
            'DELETE',
            user_no,
            dept_no,
            NEW.is_deleted,
            OLD.last_name,
            OLD.first_name,
            JSON_OBJECT(
                'old_values', JSON_OBJECT(
                    'is_deleted', OLD.is_deleted
                ),
                'new_values', JSON_OBJECT(
			'is_deleted', NEW.is_deleted,
                      'img_filename', NEW.img_filename,
		    'last_name', NEW.last_name,
		    'first_name', NEW.first_name,
		    'middle_name', NEW.middle_name,
		    'suffix', NEW.suffix,
		    'house_num', NEW.house_num,
		    'street', NEW.street,
		    'subdivision', NEW.subdivision,
		    'district_brgy', NEW.district_brgy,
		    'city', NEW.city,
		    'province', NEW.province,
		    'zipcode', NEW.zipcode,
		    'sex', NEW.sex,
		    'marital_status', NEW.marital_status,
		    'birth_place', NEW.birth_place,
		    'birth_date', NEW.birth_date,
		    'cellphone_num', NEW.cellphone_num
                )
            )
        );

    ELSEIF OLD.is_deleted = 1 AND NEW.is_deleted = 0 THEN
        SELECT `user_recovered_no`, `dept_recovered_no`
        INTO user_no, dept_no
        FROM `nonres_audit_trail`
        WHERE `audit_trail_id` = NEW.nresident_id
        LIMIT 1;

        INSERT INTO nonresident_audit (
            nresident_id, action_type, user_no, dept_no, is_deleted, last_name, first_name, action_data
        )
        VALUES (
            OLD.nresident_id,
            'RECOVER',
            user_no,
            dept_no,
            NEW.is_deleted,
            OLD.last_name,
            OLD.first_name,
            JSON_OBJECT(
                'old_values', JSON_OBJECT(
                    'is_deleted', OLD.is_deleted
                ),
                'new_values', JSON_OBJECT(
                    'is_deleted', NEW.is_deleted,
                    'img_filename', NEW.img_filename,
		    'last_name', NEW.last_name,
		    'first_name', NEW.first_name,
		    'middle_name', NEW.middle_name,
		    'suffix', NEW.suffix,
		    'house_num', NEW.house_num,
		    'street', NEW.street,
		    'subdivision', NEW.subdivision,
		    'district_brgy', NEW.district_brgy,
		    'city', NEW.city,
		    'province', NEW.province,
		    'zipcode', NEW.zipcode,
		    'sex', NEW.sex,
		    'marital_status', NEW.marital_status,
		    'birth_place', NEW.birth_place,
		    'birth_date', NEW.birth_date,
		    'cellphone_num', NEW.cellphone_num
                )
            )
        );

    ELSE
        SELECT `user_edited_no`, `dept_edited_no`
        INTO user_no, dept_no
        FROM `nonres_audit_trail`
        WHERE `audit_trail_id` = NEW.nresident_id
        LIMIT 1;

        INSERT INTO nonresident_audit (
            nresident_id, action_type, user_no, dept_no, is_deleted, last_name, first_name, action_data
        )
        VALUES (
            OLD.nresident_id,
            'UPDATE',
            user_no,
            dept_no,
            OLD.is_deleted,
            OLD.last_name,
            OLD.first_name,
            JSON_OBJECT(
                'old_values', JSON_OBJECT(
                    'is_deleted', OLD.is_deleted,
                    'img_filename', OLD.img_filename,
		    'last_name', OLD.last_name,
		    'first_name', OLD.first_name,
		    'middle_name', OLD.middle_name,
		    'suffix', OLD.suffix,
		    'house_num', OLD.house_num,
		    'street', OLD.street,
		    'subdivision', OLD.subdivision,
		    'district_brgy', OLD.district_brgy,
		    'city', OLD.city,
		    'province', OLD.province,
		    'zipcode', OLD.zipcode,
		    'sex', OLD.sex,
		    'marital_status', OLD.marital_status,
		    'birth_place', OLD.birth_place,
		    'birth_date', OLD.birth_date,
		    'cellphone_num', OLD.cellphone_num
                ),
                'new_values', JSON_OBJECT(
			"is_deleted", NEW.is_deleted,
                    'img_filename', NEW.img_filename,
		    'last_name', NEW.last_name,
		    'first_name', NEW.first_name,
		    'middle_name', NEW.middle_name,
		    'suffix', NEW.suffix,
		    'house_num', NEW.house_num,
		    'street', NEW.street,
		    'subdivision', NEW.subdivision,
		    'district_brgy', NEW.district_brgy,
		    'city', NEW.city,
		    'province', NEW.province,
		    'zipcode', NEW.zipcode,
		    'sex', NEW.sex,
		    'marital_status', NEW.marital_status,
		    'birth_place', NEW.birth_place,
		    'birth_date', NEW.birth_date,
		    'cellphone_num', NEW.cellphone_num
                )
            )
        );
    END IF;
END */$$


DELIMITER ;

/* Trigger structure for table `resident` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `trig_ainc_res_at` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `trig_ainc_res_at` BEFORE INSERT ON `resident` FOR EACH ROW BEGIN
    
      DECLARE new_id INT;
      
     SET new_id = (SELECT MAX(audit_trail) FROM resident) + 1;
    IF new_id IS NULL THEN
        SET new_id = 1;
    END IF;
    SET NEW.audit_trail = new_id;
   
    END */$$


DELIMITER ;

/* Trigger structure for table `resident` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `resident_add_audit` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `resident_add_audit` AFTER INSERT ON `resident` FOR EACH ROW 
BEGIN

    DECLARE user_no INT;
    DECLARE dept_no INT;

    SELECT `added_by_no`, `added_depart_no`
    INTO user_no, dept_no
    FROM `res_audit_trail`
    WHERE `res_at_id` = NEW.resident_id; 

    INSERT INTO resident_audit (
        resident_id, action_type, user_no, dept_no, is_deleted, last_name, first_name, action_data
    )
    VALUES (
        NEW.resident_id, 
        'INSERT', 
        user_no,
        dept_no,
        NEW.is_deleted, 
        NEW.last_name, 
        NEW.first_name,
        JSON_OBJECT(
            'img_filename', NEW.img_filename,
            'last_name', NEW.last_name,
            'first_name', NEW.first_name,
            'middle_name', NEW.middle_name,
            'suffix', NEW.suffix,
            'house_num', NEW.house_num,
            'street', NEW.street,
            'subdivision', NEW.subdivision,
            'resident_since', NEW.resident_since,
            'sex', NEW.sex,
            'marital_status', NEW.marital_status,
            'birth_date', NEW.birth_date,
            'birth_place', NEW.birth_place,
            'cellphone_num', NEW.cellphone_num,
            'is_a_voter', NEW.is_a_voter
        )
    );

END */$$


DELIMITER ;

/* Trigger structure for table `resident` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `resident_update_audit` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `resident_update_audit` BEFORE UPDATE ON `resident` FOR EACH ROW 
BEGIN
    DECLARE user_no INT;
    DECLARE dept_no INT;

    -- Check if the `is_deleted` column is being updated to 1
    IF OLD.is_deleted = 0 AND NEW.is_deleted = 1 THEN
        SELECT `del_by_no`, `dept_del_no`
        INTO user_no, dept_no
        FROM `res_audit_trail`
        WHERE `res_at_id` = NEW.resident_id
        LIMIT 1;

        INSERT INTO resident_audit (
            resident_id, action_type, user_no, dept_no, is_deleted, last_name, first_name, action_data
        )
        VALUES (
            OLD.resident_id,
            'DELETE',
            user_no,
            dept_no,
            NEW.is_deleted,
            OLD.last_name,
            OLD.first_name,
            JSON_OBJECT(
                'old_values', JSON_OBJECT(
                    'is_deleted', OLD.is_deleted
                ),
                'new_values', JSON_OBJECT(
                    'is_deleted', NEW.is_deleted,
                    'img_filename', NEW.img_filename,
                    'last_name', NEW.last_name,
                    'first_name', NEW.first_name,
                    'middle_name', NEW.middle_name,
                    'suffix', NEW.suffix,
                    'house_num', NEW.house_num,
                    'street', NEW.street,
                    'subdivision', NEW.subdivision,
                    'resident_since', NEW.resident_since,
                    'sex', NEW.sex,
                    'marital_status', NEW.marital_status,
                    'birth_date', NEW.birth_date,
                    'birth_place', NEW.birth_place,
                    'cellphone_num', NEW.cellphone_num,
                    'is_a_voter', NEW.is_a_voter
                )
            )
        );

    ELSEIF OLD.is_deleted = 1 AND NEW.is_deleted = 0 THEN
        SELECT `rec_by_no`, `dept_rec_no`
        INTO user_no, dept_no
        FROM `res_audit_trail`
        WHERE `res_at_id` = NEW.resident_id
        LIMIT 1;

        INSERT INTO resident_audit (
            resident_id, action_type, user_no, dept_no, is_deleted, last_name, first_name, action_data
        )
        VALUES (
            OLD.resident_id,
            'RECOVER',
            user_no,
            dept_no,
            NEW.is_deleted,
            OLD.last_name,
            OLD.first_name,
            JSON_OBJECT(
                'old_values', JSON_OBJECT(
                    'is_deleted', OLD.is_deleted
                ),
                'new_values', JSON_OBJECT(
                    'is_deleted', NEW.is_deleted,
                    'img_filename', NEW.img_filename,
                    'last_name', NEW.last_name,
                    'first_name', NEW.first_name,
                    'middle_name', NEW.middle_name,
                    'suffix', NEW.suffix,
                    'house_num', NEW.house_num,
                    'street', NEW.street,
                    'subdivision', NEW.subdivision,
                    'resident_since', NEW.resident_since,
                    'sex', NEW.sex,
                    'marital_status', NEW.marital_status,
                    'birth_date', NEW.birth_date,
                    'birth_place', NEW.birth_place,
                    'cellphone_num', NEW.cellphone_num,
                    'is_a_voter', NEW.is_a_voter
                )
            )
        );

    ELSE
        SELECT `last_edited_by`, `edited_depart_no`
        INTO user_no, dept_no
        FROM `res_audit_trail`
        WHERE `res_at_id` = NEW.resident_id
        LIMIT 1;

        INSERT INTO resident_audit (
            resident_id, action_type, user_no, dept_no, is_deleted, last_name, first_name, action_data
        )
        VALUES (
            OLD.resident_id,
            'UPDATE',
            user_no,
            dept_no,
            OLD.is_deleted,
            OLD.last_name,
            OLD.first_name,
            JSON_OBJECT(
                'old_values', JSON_OBJECT(
                    'is_deleted', OLD.is_deleted,
                    'img_filename', OLD.img_filename,
                    'last_name', OLD.last_name,
                    'first_name', OLD.first_name,
                    'middle_name', OLD.middle_name,
                    'suffix', OLD.suffix,
                    'house_num', OLD.house_num,
                    'street', OLD.street,
                    'subdivision', OLD.subdivision,
                    'resident_since', OLD.resident_since,
                    'sex', OLD.sex,
                    'marital_status', OLD.marital_status,
                    'birth_date', OLD.birth_date,
                    'birth_place', OLD.birth_place,
                    'cellphone_num', OLD.cellphone_num,
                    'is_a_voter', OLD.is_a_voter
                ),
                'new_values', JSON_OBJECT(
                    'is_deleted', NEW.is_deleted,
                    'img_filename', NEW.img_filename,
                    'last_name', NEW.last_name,
                    'first_name', NEW.first_name,
                    'middle_name', NEW.middle_name,
                    'suffix', NEW.suffix,
                    'house_num', NEW.house_num,
                    'street', NEW.street,
                    'subdivision', NEW.subdivision,
                    'resident_since', NEW.resident_since,
                    'sex', NEW.sex,
                    'marital_status', NEW.marital_status,
                    'birth_date', NEW.birth_date,
                    'birth_place', NEW.birth_place,
                    'cellphone_num', NEW.cellphone_num,
                    'is_a_voter', NEW.is_a_voter
                )
            )
        );
    END IF;
END */$$


DELIMITER ;

/* Trigger structure for table `tbl_blotters` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `trig_ainc_blotters` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `trig_ainc_blotters` BEFORE INSERT ON `tbl_blotters` FOR EACH ROW BEGIN
    
        DECLARE new_id INT;
      
    SET new_id = (SELECT MAX(blot_at_no) FROM tbl_blotters) + 1;
    IF new_id IS NULL THEN
        SET new_id = 1;
    END IF;
    SET NEW.blot_at_no = new_id;
    
    SET new_id = (SELECT MAX(other_complainant_no) FROM tbl_blotters) + 1;
    IF new_id IS NULL THEN
        SET new_id = 1;
    END IF;
    SET NEW.other_complainant_no = new_id;
    
    SET new_id = (SELECT MAX(other_respondent_no) FROM tbl_blotters) + 1;
    IF new_id IS NULL THEN
        SET new_id = 1;
    END IF;
    SET NEW.other_respondent_no = new_id;
    END */$$


DELIMITER ;

/* Trigger structure for table `tbl_docu_request` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `trig_cal_docu_age_id` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `trig_cal_docu_age_id` BEFORE INSERT ON `tbl_docu_request` FOR EACH ROW BEGIN
    DECLARE current_year CHAR(4);
    DECLARE sequence_number CHAR(6);
    DECLARE resident_birthdate DATE;
    
    -- Get the current year
    SET current_year = DATE_FORMAT(CURDATE(), '%Y');
    
    -- Generate the next sequence number for the current year
    SET sequence_number = LPAD(
        IFNULL(
            (SELECT MAX(CAST(SUBSTRING(`request_id`, 6, 6) AS UNSIGNED)) + 1 
             FROM tbl_docu_request 
             WHERE SUBSTRING(`request_id`, 1, 4) = current_year),
        1), 6, '0');
    
    -- Combine the current year and sequence number to form the new request_id
    SET NEW.`request_id` = CONCAT(current_year, '-', sequence_number);
    
    -- Get the birthdate of the resident or non-resident
    IF NEW.`resident_no` IS NOT NULL THEN
        SELECT birth_date INTO resident_birthdate 
        FROM resident 
        WHERE resident_id = NEW.`resident_no`;
    ELSEIF NEW.`nresident_no` IS NOT NULL THEN
        SELECT birth_date INTO resident_birthdate 
        FROM non_resident 
        WHERE nresident_id = NEW.`nresident_no`;
    END IF;
    
    -- Calculate the age based on the birthdate and the current date
    SET NEW.`age` = TIMESTAMPDIFF(YEAR, resident_birthdate, CURDATE());
    
    SET NEW.document_no = (SELECT IFNULL(MAX(document_no), 0) + 1 FROM tbl_docu_request);
    SET NEW.audit_trail_no = (SELECT IFNULL(MAX(audit_trail_no), 0) + 1 FROM tbl_docu_request);
END */$$


DELIMITER ;

/* Trigger structure for table `tbl_docu_request` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `documents_add_audit` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `documents_add_audit` AFTER INSERT ON `tbl_docu_request` FOR EACH ROW 
BEGIN

    DECLARE user_no INT;
    DECLARE dept_no INT;

    SELECT `issued_by_no`, `issuing_dept_no`
    INTO user_no, dept_no
    FROM `tbl_cert_audit_trail`
    WHERE `audit_trail_id` = NEW.`audit_trail_no`; 

    INSERT INTO tbl_documents_audit (
         action_type, user_no, dept_no, is_deleted, resident_no, nresident_no, document_no ,action_data
    )
    VALUES (
        'INSERT', 
        user_no,
        dept_no,
        NEW.is_deleted, 
	  NEW.resident_no,
            NEW.nresident_no,
            NEW.document_no,
        JSON_OBJECT(
            'expiration_date', NEW.expiration_date,
            'presented_id', NEW.presented_id,
            'ID_number', NEW.ID_number,
            'is_deleted', NEW.is_deleted
            
        )
    );

END */$$


DELIMITER ;

/* Trigger structure for table `tbl_docu_request` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `document_update_audit` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `document_update_audit` BEFORE UPDATE ON `tbl_docu_request` FOR EACH ROW 
BEGIN
    DECLARE user_no INT;
    DECLARE dept_no INT;

    -- Handle DELETE Action
    IF OLD.is_deleted = 0 AND NEW.is_deleted = 1 THEN
        SELECT `deleted_by_no`, `deleted_depart`
        INTO user_no, dept_no
        FROM `tbl_cert_audit_trail`
        WHERE `audit_trail_id` = NEW.`audit_trail_no`
        LIMIT 1;

        INSERT INTO tbl_documents_audit (
            action_type, user_no, dept_no, is_deleted, resident_no, nresident_no, document_no, action_data
        )
        VALUES (
            'DELETE',
            user_no,
            dept_no,
            NEW.is_deleted,
            OLD.resident_no,
            OLD.nresident_no,
            OLD.document_no,
            JSON_OBJECT(
                'old_values', JSON_OBJECT(
                    'is_deleted', OLD.is_deleted
                ),
                'new_values', JSON_OBJECT(
                    'is_deleted', NEW.is_deleted,
                    'expiration_date', NEW.expiration_date,
                    'presented_id', NEW.presented_id,
                    'ID_number', NEW.ID_number
                )
            )
        );

    -- Handle RECOVER Action
    ELSEIF OLD.is_deleted = 1 AND NEW.is_deleted = 0 THEN
        SELECT `recovered_by_no`, `recovered_depart_no`
        INTO user_no, dept_no
        FROM `tbl_cert_audit_trail`
        WHERE `audit_trail_id` = NEW.`audit_trail_no`
        LIMIT 1;

        INSERT INTO tbl_documents_audit (
            action_type, user_no, dept_no, is_deleted, resident_no, nresident_no, document_no, action_data
        )
        VALUES (
            'RECOVER',
            user_no,
            dept_no,
            NEW.is_deleted,
            OLD.resident_no,
            OLD.nresident_no,
            OLD.document_no,
            JSON_OBJECT(
                'old_values', JSON_OBJECT(
                    'is_deleted', OLD.is_deleted
                ),
                'new_values', JSON_OBJECT(
                    'is_deleted', NEW.is_deleted,
                    'expiration_date', NEW.expiration_date,
                    'presented_id', NEW.presented_id,
                    'ID_number', NEW.ID_number
                )
            )
        );

    -- Handle UPDATE Action
    ELSE
        SELECT `edited_by_no`, `edited_depart_no`
        INTO user_no, dept_no
        FROM `tbl_cert_audit_trail`
        WHERE `audit_trail_id` = NEW.`audit_trail_no`
        LIMIT 1;

        INSERT INTO tbl_documents_audit (
            action_type, user_no, dept_no, is_deleted, resident_no, nresident_no, document_no, action_data
        )
        VALUES (
            'UPDATE',
            user_no,
            dept_no,
            OLD.is_deleted,
            OLD.resident_no,
            OLD.nresident_no,
            OLD.document_no,
            JSON_OBJECT(
                'old_values', JSON_OBJECT(
                    'is_deleted', OLD.is_deleted,
                    'expiration_date', OLD.expiration_date,
                    'presented_id', OLD.presented_id,
                    'ID_number', OLD.ID_number
                ),
                'new_values', JSON_OBJECT(
                    'is_deleted', NEW.is_deleted,
                    'expiration_date', NEW.expiration_date,
                    'presented_id', NEW.presented_id,
                    'ID_number', NEW.ID_number
                )
            )
        );
    END IF;
END */$$


DELIMITER ;

/* Trigger structure for table `tbl_users` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `trig_username_no_at` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `trig_username_no_at` BEFORE INSERT ON `tbl_users` FOR EACH ROW 
BEGIN
    DECLARE new_id INT;

    SET new_id = (SELECT MAX(username_no) FROM tbl_users) + 1;

    -- Check if new_id is NULL
    IF new_id IS NULL THEN
        SET new_id = 1;
    END IF;

    SET NEW.username_no = new_id;
    SET NEW.user_at_no = new_id;
END */$$


DELIMITER ;

/*!50106 set global event_scheduler = 1*/;

/* Event structure for event `evt_update_cert_status` */

/*!50106 DROP EVENT IF EXISTS `evt_update_cert_status`*/;

DELIMITER $$

/*!50106 CREATE DEFINER=`root`@`localhost` EVENT `evt_update_cert_status` ON SCHEDULE EVERY 1 DAY STARTS '2024-10-10 16:56:12' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE tbl_docu_request d
  JOIN tbl_cert_audit_trail c ON d.audit_trail_no = c.audit_trail_id
  SET d.status = 2
  WHERE c.expiration < NOW() */$$
DELIMITER ;

/* Function  structure for function  `get_max_request_id` */

/*!50003 DROP FUNCTION IF EXISTS `get_max_request_id` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `get_max_request_id`() RETURNS varchar(255) CHARSET utf8
BEGIN
    DECLARE max_request_id VARCHAR(255);
    SELECT MAX(request_id) INTO max_request_id FROM tbl_docu_request as request_id;
    RETURN max_request_id;
END */$$
DELIMITER ;

/* Function  structure for function  `get_quarter` */

/*!50003 DROP FUNCTION IF EXISTS `get_quarter` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `get_quarter`(input_date DATE) RETURNS varchar(10) CHARSET utf8
    DETERMINISTIC
BEGIN
    IF QUARTER(input_date) = 1 OR QUARTER(input_date) = 2 THEN
        RETURN 'Q1-Q2';
    ELSEIF QUARTER(input_date) = 3 OR QUARTER(input_date) = 4 THEN
        RETURN 'Q3-Q4';
    END IF;
END */$$
DELIMITER ;

/* Procedure structure for procedure `CheckNonResidentBlotterRec` */

/*!50003 DROP PROCEDURE IF EXISTS  `CheckNonResidentBlotterRec` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `CheckNonResidentBlotterRec`(IN nresident_id INT, in start_from int)
BEGIN
        SELECT 
            b.blotter_id,
            aud.blotter_add_dt,
            CASE 
                WHEN b.nres_complainant_no =nresident_id THEN 'Complainant' 
                WHEN b.nres_respondent_no =nresident_id THEN 'Respondent'
                WHEN c.nres_person_1 =nresident_id OR c.nres_person_2 =nresident_id OR 
                     c.nres_person_3 =nresident_id OR c.nres_person_4 =nresident_id OR 
                     c.nres_person_5 =nresident_id THEN 'Other Complainant'
                WHEN r.nres_person_1 =nresident_id OR r.nres_person_2 =nresident_id OR 
                     r.nres_person_3 =nresident_id OR r.nres_person_4 =nresident_id OR 
                     r.nres_person_5 =nresident_id THEN 'Other Respondent'
                ELSE 'Not Found'
            END AS person_status,
            b.blotter_type, 
            b.desc_incident,
            b.incident_dt, 
            b.location_of_incident, 
            b.date_of_resolution,
            b.report_status
        FROM 
            tbl_blotters b
            LEFT JOIN tbl_other_complainants c ON c.complainant_id = b.other_complainant_no
            LEFT JOIN tbl_other_respondents r ON r.respondent_id = b.other_respondent_no
            LEFT JOIN tbl_blotter_audit_trail aud ON aud.blotter_at_id =  b.blot_at_no
        WHERE 
            b.nres_complainant_no =nresident_id 
            OR b.nres_respondent_no =nresident_id
            OR c.nres_person_1 =nresident_id 
            OR c.nres_person_2 =nresident_id 
            OR c.nres_person_3 =nresident_id 
            OR c.nres_person_4 =nresident_id 
            OR c.nres_person_5 =nresident_id
            OR r.nres_person_1 =nresident_id 
            OR r.nres_person_2 =nresident_id 
            OR r.nres_person_3 =nresident_id 
            OR r.nres_person_4 =nresident_id 
            OR r.nres_person_5 =nresident_id
        ORDER BY b.incident_dt DESC
        LIMIT start_from, 5;
END */$$
DELIMITER ;

/* Procedure structure for procedure `CheckResidentBlotterRec` */

/*!50003 DROP PROCEDURE IF EXISTS  `CheckResidentBlotterRec` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `CheckResidentBlotterRec`(
    IN resident_id INT, 
    IN start_from INT
)
BEGIN
        SELECT 
            b.blotter_id,
            aud.blotter_add_dt,
            CASE 
                WHEN b.res_complainant_no = resident_id THEN 'Complainant' 
                WHEN b.res_respondent_no = resident_id THEN 'Respondent'
                WHEN c.res_person_1 = resident_id OR c.res_person_2 = resident_id OR 
                     c.res_person_3 = resident_id OR c.res_person_4 = resident_id OR 
                     c.res_person_5 = resident_id THEN 'Other Complainant'
                WHEN r.res_person_1 = resident_id OR r.res_person_2 = resident_id OR 
                     r.res_person_3 = resident_id OR r.res_person_4 = resident_id OR 
                     r.res_person_5 = resident_id THEN 'Other Respondent'
                ELSE 'Not Found'
            END AS person_status,
            b.blotter_type, 
            b.desc_incident,
            b.incident_dt, 
            b.location_of_incident, 
            b.date_of_resolution,
            b.report_status
        FROM 
            tbl_blotters b
            LEFT JOIN tbl_other_complainants c ON c.complainant_id = b.other_complainant_no
            LEFT JOIN tbl_other_respondents r ON r.respondent_id = b.other_respondent_no
            LEFT JOIN tbl_blotter_audit_trail aud ON aud.blotter_at_id =  b.blot_at_no
        WHERE 
            b.res_complainant_no = resident_id 
            OR b.res_respondent_no = resident_id
            OR c.res_person_1 = resident_id 
            OR c.res_person_2 = resident_id 
            OR c.res_person_3 = resident_id 
            OR c.res_person_4 = resident_id 
            OR c.res_person_5 = resident_id
            OR r.res_person_1 = resident_id 
            OR r.res_person_2 = resident_id 
            OR r.res_person_3 = resident_id 
            OR r.res_person_4 = resident_id 
            OR r.res_person_5 = resident_id
        ORDER BY b.incident_dt DESC
        LIMIT start_from, 5;
END */$$
DELIMITER ;

/* Procedure structure for procedure `CountNonResidentBlotterEntries` */

/*!50003 DROP PROCEDURE IF EXISTS  `CountNonResidentBlotterEntries` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `CountNonResidentBlotterEntries`(IN residentId INT)
BEGIN
    -- Count the matching entries with the specified resident_id and report_status = 1
    SELECT COUNT(*)
    FROM tbl_blotters AS b
    LEFT JOIN tbl_other_respondents AS orr ON b.blotter_id = orr.respondent_id
    WHERE 
        -- Check if resident_id is in tbl_other_respondents nres_person_1 to nres_person_5
        (orr.nres_person_1 = residentId OR orr.nres_person_2 = residentId 
         OR orr.nres_person_3 = residentId OR orr.nres_person_4 = residentId 
         OR orr.nres_person_5 = residentId OR b.nres_respondent_no = residentId)
        AND
        -- Only include entries with report_status = 1
        b.report_status = 0;
END */$$
DELIMITER ;

/* Procedure structure for procedure `CountNonResidentBlotterRec` */

/*!50003 DROP PROCEDURE IF EXISTS  `CountNonResidentBlotterRec` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `CountNonResidentBlotterRec`(IN nresident_id INT)
BEGIN
     SELECT count(*) FROM (SELECT 
            b.blotter_id,
            aud.blotter_add_dt,
            CASE 
                WHEN b.nres_complainant_no =nresident_id THEN 'Complainant' 
                WHEN b.nres_respondent_no =nresident_id THEN 'Respondent'
                WHEN c.nres_person_1 =nresident_id OR c.nres_person_2 =nresident_id OR 
                     c.nres_person_3 =nresident_id OR c.nres_person_4 =nresident_id OR 
                     c.nres_person_5 =nresident_id THEN 'Other Complainant'
                WHEN r.nres_person_1 =nresident_id OR r.nres_person_2 =nresident_id OR 
                     r.nres_person_3 =nresident_id OR r.nres_person_4 =nresident_id OR 
                     r.nres_person_5 =nresident_id THEN 'Other Respondent'
                ELSE 'Not Found'
            END AS person_status,
            b.blotter_type, 
            b.desc_incident,
            b.incident_dt, 
            b.location_of_incident, 
            b.date_of_resolution,
            b.report_status
        FROM 
            tbl_blotters b
            LEFT JOIN tbl_other_complainants c ON c.complainant_id = b.other_complainant_no
            LEFT JOIN tbl_other_respondents r ON r.respondent_id = b.other_respondent_no
            LEFT JOIN tbl_blotter_audit_trail aud ON aud.blotter_at_id =  b.blot_at_no
        WHERE 
            b.nres_complainant_no =nresident_id 
            OR b.nres_respondent_no =nresident_id
            OR c.nres_person_1 =nresident_id 
            OR c.nres_person_2 =nresident_id 
            OR c.nres_person_3 =nresident_id 
            OR c.nres_person_4 =nresident_id 
            OR c.nres_person_5 =nresident_id
            OR r.nres_person_1 =nresident_id 
            OR r.nres_person_2 =nresident_id 
            OR r.nres_person_3 =nresident_id 
            OR r.nres_person_4 =nresident_id 
            OR r.nres_person_5 =nresident_id
        ) as count_entries;
END */$$
DELIMITER ;

/* Procedure structure for procedure `CountPersonBlotterInvolved` */

/*!50003 DROP PROCEDURE IF EXISTS  `CountPersonBlotterInvolved` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `CountPersonBlotterInvolved`(in resident_id int)
BEGIN
	
	 SELECT COUNT(*) AS total_entries
        FROM (
            SELECT 
                b.blotter_id,
                aud.blotter_add_dt,
                CASE 
                    WHEN b.res_complainant_no = resident_id THEN 'Complainant' 
                    WHEN b.res_respondent_no = resident_id THEN 'Respondent'
                    WHEN c.res_person_1 = resident_id OR c.res_person_2 = resident_id OR 
                         c.res_person_3 = resident_id OR c.res_person_4 = resident_id OR 
                         c.res_person_5 = resident_id THEN 'Other Complainant'
                    WHEN r.res_person_1 = resident_id OR r.res_person_2 = resident_id OR 
                         r.res_person_3 = resident_id OR r.res_person_4 = resident_id OR 
                         r.res_person_5 = resident_id THEN 'Other Respondent'
                    ELSE 'Not Found'
                END AS person_status,
                b.blotter_type, 
                b.desc_incident,
                b.incident_dt, 
                b.location_of_incident, 
                b.date_of_resolution,
                b.report_status
            FROM 
                tbl_blotters b
                LEFT JOIN tbl_other_complainants c ON c.complainant_id = b.other_complainant_no
                LEFT JOIN tbl_other_respondents r ON r.respondent_id = b.other_respondent_no
                LEFT JOIN tbl_blotter_audit_trail aud ON aud.blotter_at_id =  b.blot_at_no
            WHERE 
                b.res_complainant_no = resident_id 
                OR b.res_respondent_no = resident_id
                OR c.res_person_1 = resident_id 
                OR c.res_person_2 = resident_id 
                OR c.res_person_3 = resident_id 
                OR c.res_person_4 = resident_id 
                OR c.res_person_5 = resident_id
                OR r.res_person_1 = resident_id 
                OR r.res_person_2 = resident_id 
                OR r.res_person_3 = resident_id 
                OR r.res_person_4 = resident_id 
                OR r.res_person_5 = resident_id
        ) AS counted_entries;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `CountResidentBlotterEntries` */

/*!50003 DROP PROCEDURE IF EXISTS  `CountResidentBlotterEntries` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `CountResidentBlotterEntries`(IN residentId INT)
BEGIN
    -- Count the matching entries with the specified resident_id and report_status = 1
    SELECT COUNT(*)
    FROM tbl_blotters AS b
    LEFT JOIN tbl_other_respondents AS orr ON b.blotter_id = orr.respondent_id
    WHERE 
        -- Check if resident_id is in tbl_other_respondents res_person_1 to res_person_5
        (orr.res_person_1 = residentId OR orr.res_person_2 = residentId 
         OR orr.res_person_3 = residentId OR orr.res_person_4 = residentId 
         OR orr.res_person_5 = residentId OR b.res_respondent_no = residentId)
        AND
        -- Only include entries with report_status = 1
        b.report_status = 0;
END */$$
DELIMITER ;

/* Procedure structure for procedure `determine_docu_type` */

/*!50003 DROP PROCEDURE IF EXISTS  `determine_docu_type` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `determine_docu_type`(
    IN certificate_type VARCHAR(255)
)
BEGIN
    -- For Certificate of Residency
    IF certificate_type = 'Certificate_of_Residency' THEN
        INSERT INTO tbl_documents(certificate_of_residency)
        SELECT IFNULL(MAX(certificate_of_residency), 0) + 1 FROM tbl_documents;
        
    -- For Certificate of Indigency
    ELSEIF certificate_type = 'Certificate_of_Indigency' THEN
        INSERT INTO tbl_documents(certificate_of_indigency)
        SELECT IFNULL(MAX(certificate_of_indigency), 0) + 1 FROM tbl_documents;
        
    -- For Certificate of Good Moral
    ELSEIF certificate_type = 'Good_Moral' THEN
        INSERT INTO tbl_documents(Certificate_of_Good_Moral)
        SELECT IFNULL(MAX(Certificate_of_Good_Moral), 0) + 1 FROM tbl_documents;
        
    -- For First Time Job Seeker Certificate
    ELSEIF certificate_type = 'FTJS' THEN
        INSERT INTO tbl_documents(FTJS)
        SELECT IFNULL(MAX(FTJS), 0) + 1 FROM tbl_documents;
        
      -- For Business Permits
    ELSEIF certificate_type = 'Business_Permits' THEN
        INSERT INTO tbl_documents(Business_Permits)
        SELECT IFNULL(MAX(Business_Permits), 0) + 1 FROM tbl_documents;
        
      -- For Building Permits
    ELSEIF certificate_type = 'Building_Permits' THEN
        INSERT INTO tbl_documents(Building_Permits)
        SELECT IFNULL(MAX(Building_Permits), 0) + 1 FROM tbl_documents;
            
        -- For Excavation Permits
    ELSEIF certificate_type = 'Excavation_Permits' THEN
        INSERT INTO tbl_documents(Excavation_Permits)
        SELECT IFNULL(MAX(Excavation_Permits), 0) + 1 FROM tbl_documents;
        
    
        -- For Fencing Permits
    ELSEIF certificate_type = 'Fencing_Permits' THEN
        INSERT INTO tbl_documents(Fencing_Permits)
        SELECT IFNULL(MAX(Fencing_Permits), 0) + 1 FROM tbl_documents;
        
    
        -- For TPRS
    ELSEIF certificate_type = 'TPRS' THEN
        INSERT INTO tbl_documents(TPRS)
        SELECT IFNULL(MAX(TPRS), 0) + 1 FROM tbl_documents;
        
    END IF;
END */$$
DELIMITER ;

/* Procedure structure for procedure `FetchAllComplainant` */

/*!50003 DROP PROCEDURE IF EXISTS  `FetchAllComplainant` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `FetchAllComplainant`(IN id int)
BEGIN
	
	SELECT 
    resident.`resident_id` as id,
    CONCAT(`resident`.`last_name`, ', ', `resident`.`first_name`, ' ', IFNULL(`resident`.`middle_name`, ''), ' ', IFNULL(`resident`.`suffix`, '')) AS `full_name`,
    'Resident' AS `status`,
    `resident`.`img_filename`
FROM 
    `tbl_other_complainants`
JOIN 
    `resident` ON `tbl_other_complainants`.`res_person_1` = `resident`.`resident_id`
WHERE `tbl_other_complainants`.`res_person_1` IS NOT NULL AND `tbl_other_complainants`.`complainant_id` = id
UNION ALL
SELECT 
    resident.`resident_id` as id,
    CONCAT(`resident`.`last_name`, ', ', `resident`.`first_name`, ' ', IFNULL(`resident`.`middle_name`, ''), ' ', IFNULL(`resident`.`suffix`, '')) AS `full_name`,
    'Resident' AS `status`,
    `resident`.`img_filename`
FROM 
    `tbl_other_complainants`
JOIN 
    `resident` ON `tbl_other_complainants`.`res_person_2` = `resident`.`resident_id`
WHERE `tbl_other_complainants`.`res_person_2` IS NOT NULL AND `tbl_other_complainants`.`complainant_id` = id
UNION ALL
SELECT 
	resident.`resident_id` as id,
    CONCAT(`resident`.`last_name`, ', ', `resident`.`first_name`, ' ', IFNULL(`resident`.`middle_name`, ''), ' ', IFNULL(`resident`.`suffix`, '')) AS `full_name`,
    'Resident' AS `status`,
    `resident`.`img_filename`
FROM 
    `tbl_other_complainants`
JOIN 
    `resident` ON `tbl_other_complainants`.`res_person_3` = `resident`.`resident_id`
WHERE `tbl_other_complainants`.`res_person_3` IS NOT NULL AND `tbl_other_complainants`.`complainant_id` = id
UNION ALL
SELECT 
	resident.`resident_id` as id,   
	 CONCAT(`resident`.`last_name`, ', ', `resident`.`first_name`, ' ', IFNULL(`resident`.`middle_name`, ''), ' ', IFNULL(`resident`.`suffix`, '')) AS `full_name`,
    'Resident' AS `status`,
    `resident`.`img_filename`
FROM 
    `tbl_other_complainants`
JOIN 
    `resident` ON `tbl_other_complainants`.`res_person_4` = `resident`.`resident_id`
WHERE `tbl_other_complainants`.`res_person_4` IS NOT NULL AND `tbl_other_complainants`.`complainant_id` = id
UNION ALL
SELECT 
	resident.`resident_id` as id,
    CONCAT(`resident`.`last_name`, ', ', `resident`.`first_name`, ' ', IFNULL(`resident`.`middle_name`, ''), ' ', IFNULL(`resident`.`suffix`, '')) AS `full_name`,
    'Resident' AS `status`,
    `resident`.`img_filename`
FROM 
    `tbl_other_complainants`
JOIN 
    `resident` ON `tbl_other_complainants`.`res_person_5` = `resident`.`resident_id`
WHERE `tbl_other_complainants`.`res_person_5` IS NOT NULL AND `tbl_other_complainants`.`complainant_id` = id
UNION ALL
SELECT 
	non_resident.`nresident_id` as id,    
	CONCAT(`non_resident`.`last_name`, ', ', `non_resident`.`first_name`, ' ', IFNULL(`non_resident`.`middle_name`, ''), ' ', IFNULL(`non_resident`.`suffix`, '')) AS `full_name`,
    'Non-Resident' AS `status`,
    `non_resident`.`img_filename`
FROM 
    `tbl_other_complainants`
JOIN 
    `non_resident` ON `tbl_other_complainants`.`nres_person_1` = `non_resident`.`nresident_id`
WHERE `tbl_other_complainants`.`nres_person_1` IS NOT NULL AND `tbl_other_complainants`.`complainant_id` = id
UNION ALL
SELECT 
	non_resident.`nresident_id` as id,
    CONCAT(`non_resident`.`last_name`, ', ', `non_resident`.`first_name`, ' ', IFNULL(`non_resident`.`middle_name`, ''), ' ', IFNULL(`non_resident`.`suffix`, '')) AS `full_name`,
    'Non-Resident' AS `status`,
    `non_resident`.`img_filename`
FROM 
    `tbl_other_complainants`
JOIN 
    `non_resident` ON `tbl_other_complainants`.`nres_person_2` = `non_resident`.`nresident_id`
WHERE `tbl_other_complainants`.`nres_person_2` IS NOT NULL AND `tbl_other_complainants`.`complainant_id` = id
UNION ALL
SELECT 
	non_resident.`nresident_id` as id,
    CONCAT(`non_resident`.`last_name`, ', ', `non_resident`.`first_name`, ' ', IFNULL(`non_resident`.`middle_name`, ''), ' ', IFNULL(`non_resident`.`suffix`, '')) AS `full_name`,
    'Non-Resident' AS `status`,
    `non_resident`.`img_filename`
FROM 
    `tbl_other_complainants`
JOIN 
    `non_resident` ON `tbl_other_complainants`.`nres_person_3` = `non_resident`.`nresident_id`
WHERE `tbl_other_complainants`.`nres_person_3` IS NOT NULL AND `tbl_other_complainants`.`complainant_id` = id
UNION ALL
SELECT 
	non_resident.`nresident_id` as id,
    CONCAT(`non_resident`.`last_name`, ', ', `non_resident`.`first_name`, ' ', IFNULL(`non_resident`.`middle_name`, ''), ' ', IFNULL(`non_resident`.`suffix`, '')) AS `full_name`,
    'Non-Resident' AS `status`,
    `non_resident`.`img_filename`
FROM 
    `tbl_other_complainants`
JOIN 
    `non_resident` ON `tbl_other_complainants`.`nres_person_4` = `non_resident`.`nresident_id`
WHERE `tbl_other_complainants`.`nres_person_4` IS NOT NULL AND `tbl_other_complainants`.`complainant_id` = id
UNION ALL
SELECT 
	non_resident.`nresident_id` as id,
    CONCAT(`non_resident`.`last_name`, ', ', `non_resident`.`first_name`, ' ', IFNULL(`non_resident`.`middle_name`, ''), ' ', IFNULL(`non_resident`.`suffix`, '')) AS `full_name`,
    'Non-Resident' AS `status`,
    `non_resident`.`img_filename`
FROM 
    `tbl_other_complainants`
JOIN 
    `non_resident` ON `tbl_other_complainants`.`nres_person_5` = `non_resident`.`nresident_id`
WHERE `tbl_other_complainants`.`nres_person_5` IS NOT NULL AND `tbl_other_complainants`.`complainant_id` = id;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `FetchAllComplainantsID` */

/*!50003 DROP PROCEDURE IF EXISTS  `FetchAllComplainantsID` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `FetchAllComplainantsID`(IN _id INT)
BEGIN
    SELECT 
        resident.`resident_id` AS id,
        'Resident' AS `status`
    FROM 
        `tbl_other_complainants`
    JOIN 
        `resident` ON `tbl_other_complainants`.`res_person_1` = `resident`.`resident_id`
    WHERE `tbl_other_complainants`.`res_person_1` IS NOT NULL AND `tbl_other_complainants`.`complainant_id` = _id
    UNION ALL
    SELECT 
        resident.`resident_id` AS id,
        'Resident' AS `status`
    FROM 
        `tbl_other_complainants`
    JOIN 
        `resident` ON `tbl_other_complainants`.`res_person_2` = `resident`.`resident_id`
    WHERE `tbl_other_complainants`.`res_person_2` IS NOT NULL AND `tbl_other_complainants`.`complainant_id` = _id
    UNION ALL
    SELECT 
        resident.`resident_id` AS id,
        'Resident' AS `status`
    FROM 
        `tbl_other_complainants`
    JOIN 
        `resident` ON `tbl_other_complainants`.`res_person_3` = `resident`.`resident_id`
    WHERE `tbl_other_complainants`.`res_person_3` IS NOT NULL AND `tbl_other_complainants`.`complainant_id` = _id
    UNION ALL
    SELECT 
        resident.`resident_id` AS id,   
        'Resident' AS `status`
    FROM 
        `tbl_other_complainants`
    JOIN 
        `resident` ON `tbl_other_complainants`.`res_person_4` = `resident`.`resident_id`
    WHERE `tbl_other_complainants`.`res_person_4` IS NOT NULL AND `tbl_other_complainants`.`complainant_id` = _id
    UNION ALL
    SELECT 
        resident.`resident_id` AS id,
        'Resident' AS `status`
    FROM 
        `tbl_other_complainants`
    JOIN 
        `resident` ON `tbl_other_complainants`.`res_person_5` = `resident`.`resident_id`
    WHERE `tbl_other_complainants`.`res_person_5` IS NOT NULL AND `tbl_other_complainants`.`complainant_id` = _id
    UNION ALL
    SELECT 
        non_resident.`nresident_id` AS id,    
        'Non-Resident' AS `status`
    FROM 
        `tbl_other_complainants`
    JOIN 
        `non_resident` ON `tbl_other_complainants`.`nres_person_1` = `non_resident`.`nresident_id`
    WHERE `tbl_other_complainants`.`nres_person_1` IS NOT NULL AND `tbl_other_complainants`.`complainant_id` = _id
    UNION ALL
    SELECT 
        non_resident.`nresident_id` AS id,
        'Non-Resident' AS `status`
    FROM 
        `tbl_other_complainants`
    JOIN 
        `non_resident` ON `tbl_other_complainants`.`nres_person_2` = `non_resident`.`nresident_id`
    WHERE `tbl_other_complainants`.`nres_person_2` IS NOT NULL AND `tbl_other_complainants`.`complainant_id` = _id
    UNION ALL
    SELECT 
        non_resident.`nresident_id` AS id,
        'Non-Resident' AS `status`
    FROM 
        `tbl_other_complainants`
    JOIN 
        `non_resident` ON `tbl_other_complainants`.`nres_person_3` = `non_resident`.`nresident_id`
    WHERE `tbl_other_complainants`.`nres_person_3` IS NOT NULL AND `tbl_other_complainants`.`complainant_id` = _id
    UNION ALL
    SELECT 
        non_resident.`nresident_id` AS id,
        'Non-Resident' AS `status`
    FROM 
        `tbl_other_complainants`
    JOIN 
        `non_resident` ON `tbl_other_complainants`.`nres_person_4` = `non_resident`.`nresident_id`
    WHERE `tbl_other_complainants`.`nres_person_4` IS NOT NULL AND `tbl_other_complainants`.`complainant_id` = _id
    UNION ALL
    SELECT 
        non_resident.`nresident_id` AS id,
        'Non-Resident' AS `status`
    FROM 
        `tbl_other_complainants`
    JOIN 
        `non_resident` ON `tbl_other_complainants`.`nres_person_5` = `non_resident`.`nresident_id`
    WHERE `tbl_other_complainants`.`nres_person_5` IS NOT NULL AND `tbl_other_complainants`.`complainant_id` = _id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `FetchAllRespondents` */

/*!50003 DROP PROCEDURE IF EXISTS  `FetchAllRespondents` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `FetchAllRespondents`(in id int)
BEGIN
	
SELECT 
    resident.`resident_id` as id, 
    CONCAT(`resident`.`last_name`, ', ', `resident`.`first_name`, ' ', IFNULL(`resident`.`middle_name`, ''), ' ', IFNULL(`resident`.`suffix`, '')) AS `full_name`,
    'Resident' AS `status`,
    `resident`.`img_filename`
FROM 
    `tbl_other_respondents`
JOIN 
    `resident` ON `tbl_other_respondents`.`res_person_1` = `resident`.`resident_id`
WHERE `tbl_other_respondents`.`res_person_1` IS NOT NULL AND `tbl_other_respondents`.`respondent_id` = id
UNION ALL
SELECT 
    resident.`resident_id` as id,
    CONCAT(`resident`.`last_name`, ', ', `resident`.`first_name`, ' ', IFNULL(`resident`.`middle_name`, ''), ' ', IFNULL(`resident`.`suffix`, '')) AS `full_name`,
    'Resident' AS `status`,
    `resident`.`img_filename`
FROM 
    `tbl_other_respondents`
JOIN 
    `resident` ON `tbl_other_respondents`.`res_person_2` = `resident`.`resident_id`
WHERE `tbl_other_respondents`.`res_person_2` IS NOT NULL  AND `tbl_other_respondents`.`respondent_id` = id
UNION ALL
SELECT 
    resident.`resident_id` as id,
    CONCAT(`resident`.`last_name`, ', ', `resident`.`first_name`, ' ', IFNULL(`resident`.`middle_name`, ''), ' ', IFNULL(`resident`.`suffix`, '')) AS `full_name`,
    'Resident' AS `status`,
    `resident`.`img_filename`
FROM 
    `tbl_other_respondents`
JOIN 
    `resident` ON `tbl_other_respondents`.`res_person_3` = `resident`.`resident_id`
WHERE `tbl_other_respondents`.`res_person_3` IS NOT NULL  AND `tbl_other_respondents`.`respondent_id` = id
UNION ALL
SELECT 
    resident.`resident_id` as id,
    CONCAT(`resident`.`last_name`, ', ', `resident`.`first_name`, ' ', IFNULL(`resident`.`middle_name`, ''), ' ', IFNULL(`resident`.`suffix`, '')) AS `full_name`,
    'Resident' AS `status`,
    `resident`.`img_filename`
FROM 
    `tbl_other_respondents`
JOIN 
    `resident` ON `tbl_other_respondents`.`res_person_4` = `resident`.`resident_id`
WHERE `tbl_other_respondents`.`res_person_4` IS NOT NULL  AND `tbl_other_respondents`.`respondent_id` = id
UNION ALL
SELECT 
	resident.`resident_id` as id,
    CONCAT(`resident`.`last_name`, ', ', `resident`.`first_name`, ' ', IFNULL(`resident`.`middle_name`, ''), ' ', IFNULL(`resident`.`suffix`, '')) AS `full_name`,
    'Resident' AS `status`,
    `resident`.`img_filename`
FROM 
    `tbl_other_respondents`
JOIN 
    `resident` ON `tbl_other_respondents`.`res_person_5` = `resident`.`resident_id`
WHERE `tbl_other_respondents`.`res_person_5` IS NOT NULL  AND `tbl_other_respondents`.`respondent_id` = id
UNION ALL
SELECT 
    non_resident.`nresident_id` as id,
    CONCAT(`non_resident`.`last_name`, ', ', `non_resident`.`first_name`, ' ', IFNULL(`non_resident`.`middle_name`, ''), ' ', IFNULL(`non_resident`.`suffix`, '')) AS `full_name`,
    'Non-Resident' AS `status`,
    `non_resident`.`img_filename`
FROM 
    `tbl_other_respondents`
JOIN 
    `non_resident` ON `tbl_other_respondents`.`nres_person_1` = `non_resident`.`nresident_id`
WHERE `tbl_other_respondents`.`nres_person_1` IS NOT NULL  AND `tbl_other_respondents`.`respondent_id` = id
UNION ALL
SELECT 
    non_resident.`nresident_id` as id,
    CONCAT(`non_resident`.`last_name`, ', ', `non_resident`.`first_name`, ' ', IFNULL(`non_resident`.`middle_name`, ''), ' ', IFNULL(`non_resident`.`suffix`, '')) AS `full_name`,
    'Non-Resident' AS `status`,
    `non_resident`.`img_filename`
FROM 
    `tbl_other_respondents`
JOIN 
    `non_resident` ON `tbl_other_respondents`.`nres_person_2` = `non_resident`.`nresident_id`
WHERE `tbl_other_respondents`.`nres_person_2` IS NOT NULL  AND `tbl_other_respondents`.`respondent_id` = id
UNION ALL
SELECT 
    non_resident.`nresident_id` as id,
    CONCAT(`non_resident`.`last_name`, ', ', `non_resident`.`first_name`, ' ', IFNULL(`non_resident`.`middle_name`, ''), ' ', IFNULL(`non_resident`.`suffix`, '')) AS `full_name`,
    'Non-Resident' AS `status`,
    `non_resident`.`img_filename`
FROM 
    `tbl_other_respondents`
JOIN 
    `non_resident` ON `tbl_other_respondents`.`nres_person_3` = `non_resident`.`nresident_id`
WHERE `tbl_other_respondents`.`nres_person_3` IS NOT NULL  AND `tbl_other_respondents`.`respondent_id` = id
UNION ALL
SELECT 
    non_resident.`nresident_id` as id,
    CONCAT(`non_resident`.`last_name`, ', ', `non_resident`.`first_name`, ' ', IFNULL(`non_resident`.`middle_name`, ''), ' ', IFNULL(`non_resident`.`suffix`, '')) AS `full_name`,
    'Non-Resident' AS `status`,
    `non_resident`.`img_filename`
FROM 
    `tbl_other_respondents`
JOIN 
    `non_resident` ON `tbl_other_respondents`.`nres_person_4` = `non_resident`.`nresident_id`
WHERE `tbl_other_respondents`.`nres_person_4` IS NOT NULL  AND `tbl_other_respondents`.`respondent_id` = id
UNION ALL
SELECT 
    non_resident.`nresident_id` as id,
    CONCAT(`non_resident`.`last_name`, ', ', `non_resident`.`first_name`, ' ', IFNULL(`non_resident`.`middle_name`, ''), ' ', IFNULL(`non_resident`.`suffix`, '')) AS `full_name`,
    'Non-Resident' AS `status`,
    `non_resident`.`img_filename`
FROM 
    `tbl_other_respondents`
JOIN 
    `non_resident` ON `tbl_other_respondents`.`nres_person_5` = `non_resident`.`nresident_id`
WHERE `tbl_other_respondents`.`nres_person_5` IS NOT NULL  AND `tbl_other_respondents`.`respondent_id` = id;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `FetchAllRespondentsID` */

/*!50003 DROP PROCEDURE IF EXISTS  `FetchAllRespondentsID` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `FetchAllRespondentsID`(in id int)
BEGIN
	
		SELECT 
    resident.`resident_id` AS id,
    'Resident' AS `status`
FROM 
    `tbl_other_respondents`
JOIN 
    `resident` ON `tbl_other_respondents`.`res_person_1` = `resident`.`resident_id`
WHERE `tbl_other_respondents`.`res_person_1` IS NOT NULL AND `tbl_other_respondents`.`respondent_id` = id
UNION ALL
SELECT 
    resident.`resident_id` AS id,
    'Resident' AS `status`
FROM 
    `tbl_other_respondents`
JOIN 
    `resident` ON `tbl_other_respondents`.`res_person_2` = `resident`.`resident_id`
WHERE `tbl_other_respondents`.`res_person_2` IS NOT NULL AND `tbl_other_respondents`.`respondent_id` = id
UNION ALL
SELECT 
	resident.`resident_id` AS id,
    'Resident' AS `status`
FROM 
    `tbl_other_respondents`
JOIN 
    `resident` ON `tbl_other_respondents`.`res_person_3` = `resident`.`resident_id`
WHERE `tbl_other_respondents`.`res_person_3` IS NOT NULL AND `tbl_other_respondents`.`respondent_id` = id
UNION ALL
SELECT 
	resident.`resident_id` AS id,   
    'Resident' AS `status`
FROM 
    `tbl_other_respondents`
JOIN 
    `resident` ON `tbl_other_respondents`.`res_person_4` = `resident`.`resident_id`
WHERE `tbl_other_respondents`.`res_person_4` IS NOT NULL AND `tbl_other_respondents`.`respondent_id` = id
UNION ALL
SELECT 
	resident.`resident_id` AS id,
    'Resident' AS `status`
FROM 
    `tbl_other_respondents`
JOIN 
    `resident` ON `tbl_other_respondents`.`res_person_5` = `resident`.`resident_id`
WHERE `tbl_other_respondents`.`res_person_5` IS NOT NULL AND `tbl_other_respondents`.`respondent_id` = id
UNION ALL
SELECT 
	non_resident.`nresident_id` AS id,    
    'Non-Resident' AS `status`
FROM 
    `tbl_other_respondents`
JOIN 
    `non_resident` ON `tbl_other_respondents`.`nres_person_1` = `non_resident`.`nresident_id`
WHERE `tbl_other_respondents`.`nres_person_1` IS NOT NULL AND `tbl_other_respondents`.`respondent_id` = id
UNION ALL
SELECT 
	non_resident.`nresident_id` AS id,
    'Non-Resident' AS `status`
FROM 
    `tbl_other_respondents`
JOIN 
    `non_resident` ON `tbl_other_respondents`.`nres_person_2` = `non_resident`.`nresident_id`
WHERE `tbl_other_respondents`.`nres_person_2` IS NOT NULL AND `tbl_other_respondents`.`respondent_id` = id
UNION ALL
SELECT 
	non_resident.`nresident_id` AS id,
    'Non-Resident' AS `status`
FROM 
    `tbl_other_respondents`
JOIN 
    `non_resident` ON `tbl_other_respondents`.`nres_person_3` = `non_resident`.`nresident_id`
WHERE `tbl_other_respondents`.`nres_person_3` IS NOT NULL AND `tbl_other_respondents`.`respondent_id` = id
UNION ALL
SELECT 
	non_resident.`nresident_id` AS id,
    'Non-Resident' AS `status`
FROM 
    `tbl_other_respondents`
JOIN 
    `non_resident` ON `tbl_other_respondents`.`nres_person_4` = `non_resident`.`nresident_id`
WHERE `tbl_other_respondents`.`nres_person_4` IS NOT NULL AND `tbl_other_respondents`.`respondent_id` = id
UNION ALL
SELECT 
	non_resident.`nresident_id` AS id,
    'Non-Resident' AS `status`
FROM 
    `tbl_other_respondents`
JOIN 
    `non_resident` ON `tbl_other_respondents`.`nres_person_5` = `non_resident`.`nresident_id`
WHERE `tbl_other_respondents`.`nres_person_5` IS NOT NULL AND `tbl_other_respondents`.`respondent_id` = id;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `FetchDocumentAuditDetails` */

/*!50003 DROP PROCEDURE IF EXISTS  `FetchDocumentAuditDetails` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `FetchDocumentAuditDetails`(in aud_id int)
BEGIN
	SELECT JSON_EXTRACT(action_data, '$.old_values') AS old_entry,
				JSON_EXTRACT(action_data, '$.new_values') AS new_entry, 
			 CASE 
				WHEN `tda`.`resident_no` IS NOT NULL THEN r.`last_name`
				ELSE nr.`last_name`
			    END AS `last_name`,
			    CASE 
				WHEN `tda`.`resident_no` IS NOT NULL THEN r.`first_name`
				ELSE nr.`first_name`
			    END AS `first_name`,
			    CASE 
				WHEN `tda`.`resident_no` IS NOT NULL THEN r.`middle_name`
				ELSE nr.`middle_name`
			    END AS `middle_name`,
			    CASE 
				WHEN `tda`.`resident_no` IS NOT NULL THEN r.`suffix`
				ELSE nr.`suffix`
			    END AS `suffix`    ,
			     CASE 
		WHEN td.`Barangay_Clearance` IS NOT NULL THEN 'Barangay Clearance'
		WHEN td.`Certificate_of_Residency` IS NOT NULL THEN 'Certificate of Residency'
		WHEN td.`Certificate_of_Indigency` IS NOT NULL THEN 'Certificate of Indigency'
		WHEN td.`Certificate_of_Good_Moral` IS NOT NULL THEN 'Certificate of Good Moral'
		WHEN td.`Business_Permits` IS NOT NULL THEN 'Business Permits'
		WHEN td.`Building_Permits` IS NOT NULL THEN 'Building Permits'
		WHEN td.`Excavation_Permits` IS NOT NULL THEN 'Excavation Permits'
		WHEN td.`Fencing_Permits` IS NOT NULL THEN 'Fencing Permits'
		WHEN td.`FTJS` IS NOT NULL THEN 'First Time Job Seekers'
		WHEN td.`Oath_of_Undertaking` IS NOT NULL THEN 'Oath of Undertaking'
		WHEN td.`TPRS` IS NOT NULL THEN 'Tricycle Pedicab Regulatory Services'
		ELSE 'Unknown Document Type'
	    END AS `document_desc`
				
				 FROM `tbl_documents_audit` tda 
			LEFT JOIN resident r ON tda.resident_no = r.resident_id 
			LEFT JOIN non_resident nr ON tda.nresident_no = nr.nresident_id
			LEFT JOIN tbl_documents td ON td.docu_id = tda.document_no
				 
				 WHERE audit_id= aud_id;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `FetchNewEntryDocumentsAudit` */

/*!50003 DROP PROCEDURE IF EXISTS  `FetchNewEntryDocumentsAudit` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `FetchNewEntryDocumentsAudit`(IN aud_id INT)
BEGIN
    SELECT  
        CASE 
            WHEN `tda`.`resident_no` IS NOT NULL THEN r.`last_name`
            ELSE nr.`last_name`
        END AS `last_name`,
        CASE 
            WHEN `tda`.`resident_no` IS NOT NULL THEN r.`first_name`
            ELSE nr.`first_name`
        END AS `first_name`,
        CASE 
            WHEN `tda`.`resident_no` IS NOT NULL THEN r.`middle_name`
            ELSE nr.`middle_name`
        END AS `middle_name`,
        CASE 
            WHEN `tda`.`resident_no` IS NOT NULL THEN r.`suffix`
            ELSE nr.`suffix`
        END AS `suffix`,
        CASE 
            WHEN td.`Barangay_Clearance` IS NOT NULL THEN 'Barangay Clearance'
            WHEN td.`Certificate_of_Residency` IS NOT NULL THEN 'Certificate of Residency'
            WHEN td.`Certificate_of_Indigency` IS NOT NULL THEN 'Certificate of Indigency'
            WHEN td.`Certificate_of_Good_Moral` IS NOT NULL THEN 'Certificate of Good Moral'
            WHEN td.`Business_Permits` IS NOT NULL THEN 'Business Permits'
            WHEN td.`Building_Permits` IS NOT NULL THEN 'Building Permits'
            WHEN td.`Excavation_Permits` IS NOT NULL THEN 'Excavation Permits'
            WHEN td.`Fencing_Permits` IS NOT NULL THEN 'Fencing Permits'
            WHEN td.`FTJS` IS NOT NULL THEN 'First Time Job Seekers'
            WHEN td.`Oath_of_Undertaking` IS NOT NULL THEN 'Oath of Undertaking'
            WHEN td.`TPRS` IS NOT NULL THEN 'Tricycle Pedicab Regulatory Services'
            ELSE 'Unknown Document Type'
        END AS `document_desc`,
        JSON_EXTRACT(tda.action_data, '$.ID_number') AS `ID_number`,
        JSON_EXTRACT(tda.action_data, '$.expiration_date') AS `expiration_date`,
        JSON_EXTRACT(tda.action_data, '$.presented_id') AS `presented_id`
        
    FROM `tbl_documents_audit` tda
    LEFT JOIN resident r ON tda.resident_no = r.resident_id 
    LEFT JOIN non_resident nr ON tda.nresident_no = nr.nresident_id
    LEFT JOIN tbl_documents td ON td.docu_id = tda.document_no
    WHERE tda.audit_id = aud_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchAllDocuments` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchAllDocuments` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchAllDocuments`(IN Search VARCHAR(55), in start_from int, in lim int)
BEGIN
	
	SELECT
  `tbl_docu_request`.`request_id`           AS `request_id`,
  `tbl_cert_audit_trail`.`datetime_issued`  AS `date_issued`,
  (CASE WHEN (`tbl_docu_request`.`resident_no` IS NOT NULL) THEN '1' ELSE '0' END) AS `is_resident`,
  (CASE WHEN (`tbl_docu_request`.`resident_no` IS NOT NULL) THEN `resident`.`resident_id` ELSE `non_resident`.`nresident_id` END) AS `resident/nonres_id`,
  (CASE WHEN (`tbl_docu_request`.`resident_no` IS NOT NULL) THEN `resident`.`last_name` ELSE CONVERT(`non_resident`.`last_name` USING utf8mb4) END) AS `last_name`,
  (CASE WHEN (`tbl_docu_request`.`resident_no` IS NOT NULL) THEN `resident`.`first_name` ELSE CONVERT(`non_resident`.`first_name` USING utf8mb4) END) AS `first_name`,
  (CASE WHEN (`tbl_docu_request`.`resident_no` IS NOT NULL) THEN `resident`.`middle_name` ELSE CONVERT(`non_resident`.`middle_name` USING utf8mb4) END) AS `middle_name`,
  (CASE WHEN (`tbl_docu_request`.`resident_no` IS NOT NULL) THEN `resident`.`suffix` ELSE CONVERT(`non_resident`.`suffix` USING utf8mb4) END) AS `suffix`,
  (CASE WHEN (`tbl_docu_request`.`resident_no` IS NOT NULL) THEN `resident`.`house_num` ELSE CONVERT(`non_resident`.`house_num` USING utf8mb4) END) AS `house_num`,
  (CASE WHEN (`tbl_docu_request`.`resident_no` IS NOT NULL) THEN `resident`.`street` ELSE CONVERT(`non_resident`.`street` USING utf8mb4) END) AS `street`,
  (CASE WHEN (`tbl_docu_request`.`resident_no` IS NOT NULL) THEN `resident`.`subdivision` ELSE CONVERT(`non_resident`.`subdivision` USING utf8mb4) END) AS `subdivision`,
  (CASE WHEN (`tbl_docu_request`.`nresident_no` IS NOT NULL) THEN `non_resident`.`city` ELSE 'Caloocan City' END) AS `city`,
  (CASE WHEN (`tbl_documents`.`Barangay_Clearance` IS NOT NULL) THEN 'Barangay Clearance' WHEN (`tbl_documents`.`Certificate_of_Residency` IS NOT NULL) THEN 'Certificate of Residency' WHEN (`tbl_documents`.`Certificate_of_Indigency` IS NOT NULL) THEN 'Certificate of Indigency' WHEN (`tbl_documents`.`Certificate_of_Good_Moral` IS NOT NULL) THEN 'Certificate of Good Moral' WHEN (`tbl_documents`.`Business_Permits` IS NOT NULL) THEN 'Business Permits' WHEN (`tbl_documents`.`Building_Permits` IS NOT NULL) THEN 'Building Permits' WHEN (`tbl_documents`.`Excavation_Permits` IS NOT NULL) THEN 'Excavation Permits' WHEN (`tbl_documents`.`Fencing_Permits` IS NOT NULL) THEN 'Fencing Permits' WHEN (`tbl_documents`.`FTJS` IS NOT NULL) THEN 'First Time Job Seekers' WHEN (`tbl_documents`.`Oath_of_Undertaking` IS NOT NULL) THEN 'Oath of Undertaking' WHEN (`tbl_documents`.`TPRS` IS NOT NULL) THEN 'Tricycle Pedicab Regulatory Services' ELSE 'Unknown Document Type' END) AS `document_desc`,
  `tbl_docu_request`.`age`                  AS `age`,
  (CASE WHEN (`tbl_docu_request`.`resident_no` IS NOT NULL) THEN `resident`.`sex` ELSE CONVERT(`non_resident`.`sex` USING utf8mb4) END) AS `sex`,
  `tbl_docu_request`.`presented_id`         AS `presented_id`,
  `tbl_docu_request`.`ID_number`            AS `ID_number`,
  `tbl_docu_request`.`purpose`              AS `purpose`,
  `tbl_docu_request`.`pdffile`              AS `pdffile`,
  `tbl_docu_request`.`expiration_date`       AS `expiration`,
  `tbl_docu_request`.`status`               AS `status`,
  `tbl_docu_request`.`is_deleted`           AS `is_deleted`,
  `tbl_cert_audit_trail`.`datetime_edited`  AS `date_edited`,
  `tbl_cert_audit_trail`.`datetime_deleted` AS `date_deleted`
FROM ((((`tbl_docu_request`
      LEFT JOIN `resident`
        ON ((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`)))
     LEFT JOIN `non_resident`
       ON ((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`)))
    JOIN `tbl_documents`
      ON ((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`)))
   JOIN `tbl_cert_audit_trail`
     ON ((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`)))
WHERE `tbl_docu_request`.`is_deleted` = 0 
AND (`resident`.`last_name` LIKE search 
     OR `non_resident`.`last_name` LIKE search 
     OR `resident`.`first_name` LIKE search 
     OR `non_resident`.`first_name` LIKE search 
     OR `resident`.`middle_name` LIKE search 
     OR `non_resident`.`middle_name` LIKE search 
     OR `tbl_docu_request`.`request_id` LIKE search) 
ORDER BY `tbl_docu_request`.`request_id` DESC
LIMIT start_from, lim;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchBlotterRecords` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchBlotterRecords` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchBlotterRecords`(IN Search VARCHAR(55), IN start_from INT, IN lim INT)
BEGIN
		
		SELECT
  `tbl_blotters`.`blotter_id` AS `blotter_id`,
  `tbl_blotter_audit_trail`.`blotter_add_dt` AS `blotter_add_dt`,
  CASE 
    WHEN `tbl_blotters`.`res_complainant_no` IS NOT NULL THEN 'Resident' 
    WHEN `tbl_blotters`.`nres_complainant_no` IS NOT NULL THEN 'Non-Resident' 
    ELSE 'unknown' 
  END AS `complainant_status`,
  CASE 
    WHEN `tbl_blotters`.`res_complainant_no` IS NOT NULL THEN `tbl_blotters`.`res_complainant_no` 
    WHEN `tbl_blotters`.`nres_complainant_no` IS NOT NULL THEN `tbl_blotters`.`nres_complainant_no` 
    ELSE 'unknown' 
  END AS `complainant_no`,
  CASE 
    WHEN `tbl_blotters`.`res_respondent_no` IS NOT NULL THEN 'Resident' 
    WHEN `tbl_blotters`.`nres_respondent_no` IS NOT NULL THEN 'Non-Resident' 
    ELSE 'unknown' 
  END AS `respondent_status`,
  CASE 
    WHEN `tbl_blotters`.`res_respondent_no` IS NOT NULL THEN `tbl_blotters`.`res_respondent_no` 
    WHEN `tbl_blotters`.`nres_respondent_no` IS NOT NULL THEN `tbl_blotters`.`nres_respondent_no` 
    ELSE 'unknown' 
  END AS `respondent_no`,
  CASE 
    WHEN `tbl_blotters`.`res_complainant_no` IS NOT NULL THEN `resident_complainant`.`img_filename` 
    WHEN `tbl_blotters`.`nres_complainant_no` IS NOT NULL THEN CONVERT(`non_resident_complainant`.`img_filename` USING utf8mb4) 
    ELSE 'unknown' 
  END AS `complainant_filename`,
  CASE 
    WHEN `tbl_blotters`.`res_respondent_no` IS NOT NULL THEN `resident_respondent`.`img_filename` 
    WHEN `tbl_blotters`.`nres_respondent_no` IS NOT NULL THEN CONVERT(`non_resident_respondent`.`img_filename` USING utf8mb4) 
    ELSE 'unknown' 
  END AS `respondent_filename`,
  CASE 
    WHEN `tbl_blotters`.`res_complainant_no` IS NOT NULL THEN CONCAT(`resident_complainant`.`house_num`, ', ', `resident_complainant`.`street`, ', ', `resident_complainant`.`subdivision`, ', Camarin Caloocan City') 
    WHEN `tbl_blotters`.`nres_complainant_no` IS NOT NULL THEN CONVERT(CONCAT(`non_resident_complainant`.`house_num`, ', ', `non_resident_complainant`.`street`, ', ', `non_resident_complainant`.`subdivision`, ', ', `non_resident_complainant`.`city`, ', ', `non_resident_complainant`.`province`, ', ', `non_resident_complainant`.`zipcode`) USING utf8mb4) 
    ELSE 'unknown' 
  END AS `complainant_address`,
  CASE 
    WHEN `tbl_blotters`.`res_respondent_no` IS NOT NULL THEN CONCAT(`resident_respondent`.`house_num`, ', ', `resident_respondent`.`street`, ', ', `resident_respondent`.`subdivision`, ', Camarin Caloocan City') 
    WHEN `tbl_blotters`.`nres_respondent_no` IS NOT NULL THEN CONVERT(CONCAT(`non_resident_respondent`.`house_num`, ', ', `non_resident_respondent`.`street`, ', ', `non_resident_respondent`.`subdivision`, ', ', `non_resident_respondent`.`city`, ', ', `non_resident_respondent`.`province`, ', ', `non_resident_respondent`.`zipcode`) USING utf8mb4) 
    ELSE 'unknown' 
  END AS `respondent_address`,
  `tbl_blotters`.`blotter_type` AS `blotter_type`,
  `tbl_blotters`.`desc_incident` AS `desc_incident`,
  `tbl_blotters`.`incident_dt` AS `incident_dt`,
  `tbl_blotters`.`report_status` AS `report_status`,
  `tbl_blotters`.`is_deleted` AS `is_deleted`,
  CASE 
    WHEN `tbl_blotters`.`res_complainant_no` IS NOT NULL THEN `resident_complainant`.`last_name` 
    WHEN `tbl_blotters`.`nres_complainant_no` IS NOT NULL THEN CONVERT(`non_resident_complainant`.`last_name` USING utf8mb4) 
    ELSE 'unknown' 
  END AS `complainant_last_name`,
  CASE 
    WHEN `tbl_blotters`.`res_complainant_no` IS NOT NULL THEN `resident_complainant`.`first_name` 
    WHEN `tbl_blotters`.`nres_complainant_no` IS NOT NULL THEN CONVERT(`non_resident_complainant`.`first_name` USING utf8mb4) 
    ELSE 'unknown' 
  END AS `complainant_first_name`,
  CASE 
    WHEN `tbl_blotters`.`res_complainant_no` IS NOT NULL THEN `resident_complainant`.`middle_name` 
    WHEN `tbl_blotters`.`nres_complainant_no` IS NOT NULL THEN CONVERT(`non_resident_complainant`.`middle_name` USING utf8mb4) 
    ELSE 'unknown' 
  END AS `complainant_middle_name`,
  CASE 
    WHEN `tbl_blotters`.`res_complainant_no` IS NOT NULL THEN `resident_complainant`.`suffix` 
    WHEN `tbl_blotters`.`nres_complainant_no` IS NOT NULL THEN CONVERT(`non_resident_complainant`.`suffix` USING utf8mb4) 
    ELSE 'unknown' 
  END AS `complainant_suffix`,
  CASE 
    WHEN `tbl_blotters`.`res_respondent_no` IS NOT NULL THEN `resident_respondent`.`last_name` 
    WHEN `tbl_blotters`.`nres_respondent_no` IS NOT NULL THEN CONVERT(`non_resident_respondent`.`last_name` USING utf8mb4) 
    ELSE 'unknown' 
  END AS `respondent_last_name`,
  CASE 
    WHEN `tbl_blotters`.`res_respondent_no` IS NOT NULL THEN `resident_respondent`.`first_name` 
    WHEN `tbl_blotters`.`nres_respondent_no` IS NOT NULL THEN CONVERT(`non_resident_respondent`.`first_name` USING utf8mb4) 
    ELSE 'unknown' 
  END AS `respondent_first_name`,
  CASE 
    WHEN `tbl_blotters`.`res_respondent_no` IS NOT NULL THEN `resident_respondent`.`middle_name` 
    WHEN `tbl_blotters`.`nres_respondent_no` IS NOT NULL THEN CONVERT(`non_resident_respondent`.`middle_name` USING utf8mb4) 
    ELSE 'unknown' 
  END AS `respondent_middle_name`,
  CASE 
    WHEN `tbl_blotters`.`res_respondent_no` IS NOT NULL THEN `resident_respondent`.`suffix` 
    WHEN `tbl_blotters`.`nres_respondent_no` IS NOT NULL THEN CONVERT(`non_resident_respondent`.`suffix` USING utf8mb4) 
    ELSE 'unknown' 
  END AS `respondent_suffix`
FROM `tbl_blotters`
JOIN `tbl_blotter_audit_trail` ON `tbl_blotters`.`blot_at_no` = `tbl_blotter_audit_trail`.`blotter_at_id`
LEFT JOIN `resident` `resident_complainant` ON `tbl_blotters`.`res_complainant_no` = `resident_complainant`.`resident_id`
LEFT JOIN `non_resident` `non_resident_complainant` ON `tbl_blotters`.`nres_complainant_no` = `non_resident_complainant`.`nresident_id`
LEFT JOIN `resident` `resident_respondent` ON `tbl_blotters`.`res_respondent_no` = `resident_respondent`.`resident_id`
LEFT JOIN `non_resident` `non_resident_respondent` ON `tbl_blotters`.`nres_respondent_no` = `non_resident_respondent`.`nresident_id`
WHERE tbl_blotters.`is_deleted` = 0
AND 
  (resident_complainant.last_name LIKE search OR 
   non_resident_complainant.last_name LIKE search OR 
   resident_respondent.last_name LIKE search OR 
   non_resident_respondent.last_name LIKE search OR 
   tbl_blotters.`desc_incident` LIKE search OR 
  tbl_blotters.`incident_dt` LIKE search)
   
ORDER BY tbl_blotter_audit_trail.blotter_add_dt DESC limit start_from, lim
;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchBuildingPermits` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchBuildingPermits` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchBuildingPermits`(in req_id varchar(255))
BEGIN
	
	SELECT tbl_docu_request.request_id, 
       tbl_building_permits.`building_permit_id`, 
       CONCAT(tbl_building_permits.blg_house_no,' ',tbl_building_permits.street,' ',tbl_building_permits.`subd`) AS address, 
       tbl_building_permits.`permit_type`
FROM tbl_docu_request
JOIN tbl_documents ON tbl_docu_request.document_no = tbl_documents.docu_id
JOIN tbl_building_permits ON tbl_documents.Building_Permits = tbl_building_permits.`building_permit_id`
WHERE tbl_docu_request.request_id = req_id;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchBusinessPermits` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchBusinessPermits` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchBusinessPermits`(in req_id varchar(255))
BEGIN
	
	SELECT tbl_docu_request.request_id, 
       tbl_business_permits.store_name, 
       concat(tbl_business_permits.blg_house_no,' ',tbl_business_permits.street,' ',tbl_business_permits.subdivision) as address, 
       tbl_business_permits.type_of_buss
FROM tbl_docu_request
JOIN tbl_documents ON tbl_docu_request.document_no = tbl_documents.docu_id
JOIN tbl_business_permits ON tbl_documents.Business_Permits = tbl_business_permits.business_id
WHERE tbl_docu_request.request_id = req_id;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchDelDocu` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchDelDocu` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchDelDocu`(in search varchar(55), in start_from int, In lim int)
BEGIN
	
		SELECT
  `tbl_docu_request`.`request_id`           AS `request_id`,
  `tbl_cert_audit_trail`.`datetime_issued`  AS `date_issued`,
  (CASE WHEN (`tbl_docu_request`.`resident_no` IS NOT NULL) THEN '1' ELSE '0' END) AS `is_resident`,
  (CASE WHEN (`tbl_docu_request`.`resident_no` IS NOT NULL) THEN `resident`.`resident_id` ELSE `non_resident`.`nresident_id` END) AS `resident/nonres_id`,
  (CASE WHEN (`tbl_docu_request`.`resident_no` IS NOT NULL) THEN `resident`.`last_name` ELSE CONVERT(`non_resident`.`last_name` USING utf8mb4) END) AS `last_name`,
  (CASE WHEN (`tbl_docu_request`.`resident_no` IS NOT NULL) THEN `resident`.`first_name` ELSE CONVERT(`non_resident`.`first_name` USING utf8mb4) END) AS `first_name`,
  (CASE WHEN (`tbl_docu_request`.`resident_no` IS NOT NULL) THEN `resident`.`middle_name` ELSE CONVERT(`non_resident`.`middle_name` USING utf8mb4) END) AS `middle_name`,
  (CASE WHEN (`tbl_docu_request`.`resident_no` IS NOT NULL) THEN `resident`.`suffix` ELSE CONVERT(`non_resident`.`suffix` USING utf8mb4) END) AS `suffix`,
  (CASE WHEN (`tbl_docu_request`.`resident_no` IS NOT NULL) THEN `resident`.`house_num` ELSE CONVERT(`non_resident`.`house_num` USING utf8mb4) END) AS `house_num`,
  (CASE WHEN (`tbl_docu_request`.`resident_no` IS NOT NULL) THEN `resident`.`street` ELSE CONVERT(`non_resident`.`street` USING utf8mb4) END) AS `street`,
  (CASE WHEN (`tbl_docu_request`.`resident_no` IS NOT NULL) THEN `resident`.`subdivision` ELSE CONVERT(`non_resident`.`subdivision` USING utf8mb4) END) AS `subdivision`,
  (CASE WHEN (`tbl_docu_request`.`nresident_no` IS NOT NULL) THEN `non_resident`.`city` ELSE 'Caloocan City' END) AS `city`,
  (CASE WHEN (`tbl_documents`.`Barangay_Clearance` IS NOT NULL) THEN 'Barangay Clearance' WHEN (`tbl_documents`.`Certificate_of_Residency` IS NOT NULL) THEN 'Certificate of Residency' WHEN (`tbl_documents`.`Certificate_of_Indigency` IS NOT NULL) THEN 'Certificate of Indigency' WHEN (`tbl_documents`.`Certificate_of_Good_Moral` IS NOT NULL) THEN 'Certificate of Good Moral' WHEN (`tbl_documents`.`Business_Permits` IS NOT NULL) THEN 'Business Permits' WHEN (`tbl_documents`.`Building_Permits` IS NOT NULL) THEN 'Building Permits' WHEN (`tbl_documents`.`Excavation_Permits` IS NOT NULL) THEN 'Excavation Permits' WHEN (`tbl_documents`.`Fencing_Permits` IS NOT NULL) THEN 'Fencing Permits' WHEN (`tbl_documents`.`FTJS` IS NOT NULL) THEN 'First Time Job Seekers' WHEN (`tbl_documents`.`Oath_of_Undertaking` IS NOT NULL) THEN 'Oath of Undertaking' WHEN (`tbl_documents`.`TPRS` IS NOT NULL) THEN 'Tricycle Pedicab Regulatory Services' ELSE 'Unknown Document Type' END) AS `document_desc`,
  `tbl_docu_request`.`age`                  AS `age`,
  (CASE WHEN (`tbl_docu_request`.`resident_no` IS NOT NULL) THEN `resident`.`sex` ELSE CONVERT(`non_resident`.`sex` USING utf8mb4) END) AS `sex`,
  `tbl_docu_request`.`presented_id`         AS `presented_id`,
  `tbl_docu_request`.`ID_number`            AS `ID_number`,
  `tbl_docu_request`.`purpose`              AS `purpose`,
  `tbl_docu_request`.`pdffile`              AS `pdffile`,
  `tbl_cert_audit_trail`.`expiration`       AS `expiration`,
  `tbl_docu_request`.`status`               AS `status`,
  `tbl_docu_request`.`is_deleted`           AS `is_deleted`,
  `tbl_cert_audit_trail`.`datetime_edited`  AS `date_edited`,
  `tbl_cert_audit_trail`.`datetime_deleted` AS `date_deleted`
FROM ((((`tbl_docu_request`
      LEFT JOIN `resident`
        ON ((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`)))
     LEFT JOIN `non_resident`
       ON ((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`)))
    JOIN `tbl_documents`
      ON ((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`)))
   JOIN `tbl_cert_audit_trail`
     ON ((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`)))
WHERE `tbl_docu_request`.`is_deleted` = 1 
AND (`resident`.`last_name` LIKE search 
     OR `non_resident`.`last_name` LIKE search 
     OR `resident`.`first_name` LIKE search 
     OR `non_resident`.`first_name` LIKE search 
     OR `resident`.`middle_name` LIKE search 
     OR `non_resident`.`middle_name` LIKE search 
     OR `tbl_docu_request`.`request_id` LIKE search) 
ORDER BY `tbl_docu_request`.`request_id` DESC
LIMIT start_from, lim;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchDocuForSpecificDates` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchDocuForSpecificDates` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchDocuForSpecificDates`(IN start_from DATE, IN end_date DATE)
BEGIN
    SELECT
        tbl_docu_request.`request_id` AS `request_id`,
        tbl_cert_audit_trail.`datetime_issued` AS `date_issued`,
        (CASE WHEN tbl_docu_request.`resident_no` IS NOT NULL THEN '1' ELSE '0' END) AS `is_resident`,
        (CASE WHEN tbl_docu_request.`resident_no` IS NOT NULL THEN resident.`resident_id` ELSE non_resident.`nresident_id` END) AS `resident_nonres_id`,
        (CASE WHEN tbl_docu_request.`resident_no` IS NOT NULL THEN resident.`last_name` ELSE CONVERT(non_resident.`last_name` USING utf8mb4) END) AS `last_name`,
        (CASE WHEN tbl_docu_request.`resident_no` IS NOT NULL THEN resident.`first_name` ELSE CONVERT(non_resident.`first_name` USING utf8mb4) END) AS `first_name`,
        (CASE WHEN tbl_docu_request.`resident_no` IS NOT NULL THEN resident.`middle_name` ELSE CONVERT(non_resident.`middle_name` USING utf8mb4) END) AS `middle_name`,
        (CASE WHEN tbl_docu_request.`resident_no` IS NOT NULL THEN resident.`suffix` ELSE CONVERT(non_resident.`suffix` USING utf8mb4) END) AS `suffix`,
        (CASE WHEN tbl_docu_request.`resident_no` IS NOT NULL THEN resident.`house_num` ELSE CONVERT(non_resident.`house_num` USING utf8mb4) END) AS `house_num`,
        (CASE WHEN tbl_docu_request.`resident_no` IS NOT NULL THEN resident.`street` ELSE CONVERT(non_resident.`street` USING utf8mb4) END) AS `street`,
        (CASE WHEN tbl_docu_request.`resident_no` IS NOT NULL THEN resident.`subdivision` ELSE CONVERT(non_resident.`subdivision` USING utf8mb4) END) AS `subdivision`,
        (CASE WHEN tbl_docu_request.`nresident_no` IS NOT NULL THEN non_resident.`city` ELSE 'Caloocan City' END) AS `city`,
        (CASE 
            WHEN tbl_documents.`Barangay_Clearance` IS NOT NULL THEN 'Barangay Clearance'
            WHEN tbl_documents.`Certificate_of_Residency` IS NOT NULL THEN 'Certificate of Residency'
            WHEN tbl_documents.`Certificate_of_Indigency` IS NOT NULL THEN 'Certificate of Indigency'
            WHEN tbl_documents.`Certificate_of_Good_Moral` IS NOT NULL THEN 'Certificate of Good Moral'
            WHEN tbl_documents.`Business_Permits` IS NOT NULL THEN 'Business Permits'
            WHEN tbl_documents.`Building_Permits` IS NOT NULL THEN 'Building Permits'
            WHEN tbl_documents.`Excavation_Permits` IS NOT NULL THEN 'Excavation Permits'
            WHEN tbl_documents.`Fencing_Permits` IS NOT NULL THEN 'Fencing Permits'
            WHEN tbl_documents.`FTJS` IS NOT NULL THEN 'First Time Job Seekers'
            WHEN tbl_documents.`Oath_of_Undertaking` IS NOT NULL THEN 'Oath of Undertaking'
            WHEN tbl_documents.`TPRS` IS NOT NULL THEN 'Tricycle Pedicab Regulatory Services'
            ELSE 'Unknown Document Type'
        END) AS `document_desc`,
        tbl_docu_request.`age` AS `age`,
        (CASE WHEN tbl_docu_request.`resident_no` IS NOT NULL THEN resident.`sex` ELSE CONVERT(non_resident.`sex` USING utf8mb4) END) AS `sex`,
        tbl_docu_request.`presented_id` AS `presented_id`,
        tbl_docu_request.`ID_number` AS `ID_number`,
        tbl_docu_request.`purpose` AS `purpose`,
        tbl_docu_request.`status` AS `status`,
        tbl_docu_request.`is_deleted` AS `is_deleted`,
        tbl_username.`username`
    FROM tbl_docu_request
    LEFT JOIN resident ON tbl_docu_request.`resident_no` = resident.`resident_id`
    LEFT JOIN non_resident ON tbl_docu_request.`nresident_no` = non_resident.`nresident_id`
    JOIN tbl_documents ON tbl_docu_request.`document_no` = tbl_documents.`docu_id`
    JOIN tbl_cert_audit_trail ON tbl_docu_request.`audit_trail_no` = tbl_cert_audit_trail.`audit_trail_id`
    LEFT JOIN tbl_username ON tbl_username.`username_id` = tbl_cert_audit_trail.`issued_by_no`
    WHERE tbl_docu_request.`is_deleted` = 0  
      AND tbl_cert_audit_trail.`datetime_issued` BETWEEN start_from AND end_date;
END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchDocumentsAudit` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchDocumentsAudit` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchDocumentsAudit`(
        IN search VARCHAR(255), 
        IN start_from INT
    )
BEGIN
    SELECT
        `ru`.`audit_id`         AS `audit_id`,
        `ru`.`action_type`      AS `action_type`,
        `ru`.`action_timestamp` AS `action_timestamp`,
        `tu`.`depart_no`        AS `depart_no`,
        `un`.`username`         AS `username`,
        tu.img_filename,
        CONCAT(
            COALESCE(`tu`.`lname`, ''), ', ', 
            COALESCE(`tu`.`fname`, ''), ' ', 
            COALESCE(`tu`.`mname`, ''), ' ', 
            COALESCE(`tu`.`suffix`, '')
        ) AS `fullname`
    FROM `tbl_documents_audit` `ru`
    LEFT JOIN `tbl_users` `tu`
        ON `ru`.`user_no` = `tu`.`user_id`
    LEFT JOIN `tbl_username` `un`
        ON `ru`.`user_no` = `un`.`username_id`
    LEFT JOIN `resident` r
        ON `ru`.`resident_no` = r.`resident_id`
    LEFT JOIN `non_resident` nr
        ON `ru`.`nresident_no` = nr.`nresident_id`
    WHERE (
        tu.`lname` LIKE CONCAT('%', search, '%') OR
        tu.`fname` LIKE CONCAT('%', search, '%') OR
        tu.`mname` LIKE CONCAT('%', search, '%') OR
        un.`username` LIKE CONCAT('%', search, '%')
    )
    ORDER BY `ru`.`action_timestamp` DESC 
    LIMIT start_from, 10;
END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchDocumentsAuditWithDate` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchDocumentsAuditWithDate` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchDocumentsAuditWithDate`(
      
        IN start_from INT,
        in start_date date,
        IN end_date date
    )
BEGIN
    SELECT
        `ru`.`audit_id`         AS `audit_id`,
        `ru`.`action_type`      AS `action_type`,
        `ru`.`action_timestamp` AS `action_timestamp`,
        `tu`.`depart_no`        AS `depart_no`,
        `un`.`username`         AS `username`,
        tu.img_filename,
        CONCAT(
            COALESCE(`tu`.`lname`, ''), ', ', 
            COALESCE(`tu`.`fname`, ''), ' ', 
            COALESCE(`tu`.`mname`, ''), ' ', 
            COALESCE(`tu`.`suffix`, '')
        ) AS `fullname`
    FROM `tbl_documents_audit` `ru`
    LEFT JOIN `tbl_users` `tu`
        ON `ru`.`user_no` = `tu`.`user_id`
    LEFT JOIN `tbl_username` `un`
        ON `ru`.`user_no` = `un`.`username_id`
    WHERE `ru`.`action_timestamp` >= CAST(start_date AS DATETIME)
AND `ru`.`action_timestamp` < CAST(end_date + INTERVAL 1 DAY AS DATETIME)
    ORDER BY `ru`.`action_timestamp` DESC 
    LIMIT start_from, 10;
END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchDocumentsAuditWithDateFilters` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchDocumentsAuditWithDateFilters` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchDocumentsAuditWithDateFilters`(
	IN search varchar(255),
        IN start_from INT,
        IN start_date DATE,
        IN end_date DATE
    )
BEGIN
    SELECT
        `ru`.`audit_id`         AS `audit_id`,
        `ru`.`action_type`      AS `action_type`,
        `ru`.`action_timestamp` AS `action_timestamp`,
        `tu`.`depart_no`        AS `depart_no`,
        `un`.`username`         AS `username`,
        tu.img_filename,
        CONCAT(
            COALESCE(`tu`.`lname`, ''), ', ', 
            COALESCE(`tu`.`fname`, ''), ' ', 
            COALESCE(`tu`.`mname`, ''), ' ', 
            COALESCE(`tu`.`suffix`, '')
        ) AS `fullname`
    FROM `tbl_documents_audit` `ru`
    LEFT JOIN `tbl_users` `tu`
        ON `ru`.`user_no` = `tu`.`user_id`
    LEFT JOIN `tbl_username` `un`
        ON `ru`.`user_no` = `un`.`username_id`
    WHERE (
        tu.`lname` LIKE CONCAT('%', search, '%') OR
        tu.`fname` LIKE CONCAT('%', search, '%') OR
        tu.`mname` LIKE CONCAT('%', search, '%') OR
        un.`username` LIKE CONCAT('%', search, '%')
    ) AND `ru`.`action_timestamp` >= CAST(start_date AS DATETIME)
AND `ru`.`action_timestamp` < CAST(end_date + INTERVAL 1 DAY AS DATETIME)
    ORDER BY `ru`.`action_timestamp` DESC 
    LIMIT start_from, 10;
END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchExcavationPermits` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchExcavationPermits` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchExcavationPermits`(in req_id varchar(255))
BEGIN
	
	SELECT tbl_docu_request.request_id, 
       tbl_excavation_permits.`exca_permit_id`, 
       CONCAT(tbl_excavation_permits.blg_house_no,' ',tbl_excavation_permits.street,' ',tbl_excavation_permits.`subd`) AS address 
	FROM tbl_docu_request
	JOIN tbl_documents ON tbl_docu_request.document_no = tbl_documents.docu_id
	JOIN tbl_excavation_permits ON tbl_documents.Excavation_Permits = tbl_excavation_permits.`exca_permit_id`
	WHERE tbl_docu_request.request_id = req_id;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchFencingPermits` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchFencingPermits` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchFencingPermits`(in req_id varchar(255))
BEGIN
	
	SELECT tbl_docu_request.request_id, 
       tbl_fencing_permit.`fencing_permit_id` , 
       CONCAT(tbl_fencing_permit.blg_house_no,' ',tbl_fencing_permit.street,' ',tbl_fencing_permit.`subd`) AS address, 
       tbl_fencing_permit.`estate_type`
	FROM tbl_docu_request
	JOIN tbl_documents ON tbl_docu_request.document_no = tbl_documents.docu_id
	JOIN tbl_fencing_permit ON tbl_documents.Fencing_Permits = tbl_fencing_permit.`fencing_permit_id`
	WHERE tbl_docu_request.request_id = req_id;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchIndigency` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchIndigency` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchIndigency`(in req_id varchar(255))
BEGIN
	
	SELECT tbl_docu_request.request_id, tbl_indigency.agency FROM tbl_docu_request
    JOIN tbl_documents ON tbl_docu_request.`document_no` = tbl_documents.`docu_id`
    JOIN tbl_indigency ON tbl_documents.`Certificate_of_Indigency` = tbl_indigency.`indigency_id` 
    WHERE tbl_docu_request.`request_id` = req_id;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchNonResident` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchNonResident` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchNonResident`(IN search_query VARCHAR(255), IN start_from INT, IN lim INT)
BEGIN
  SELECT
    `non_resident`.`nresident_id` AS `nresident_id`,
    DATE(`nonres_audit_trail`.`datetime_added`) AS datetime_added,
    `non_resident`.`img_filename` AS `img_filename`,
    `non_resident`.`last_name` AS `last_name`,
    `non_resident`.`first_name` AS `first_name`,
    `non_resident`.`middle_name` AS `middle_name`,
    `non_resident`.`suffix` AS `suffix`,
    `non_resident`.`house_num` AS `house_num`,
    `non_resident`.`street` AS `street`,
    `non_resident`.`subdivision` AS `subdivision`,
    `non_resident`.`district_brgy`,
    `non_resident`.`city`,
    `non_resident`.`province`,
    `non_resident`.`zipcode`,
    `non_resident`.`sex` AS `sex`,
    `non_resident`.`marital_status` AS `marital_status`,
    `non_resident`.`birth_date` AS `birth_date`,
    `non_resident`.`birth_place` AS `birth_place`,
    `non_resident`.`cellphone_num`,
    `non_resident`.`is_deleted`
  FROM `non_resident`
  JOIN `nonres_audit_trail` ON `non_resident`.`audit_trail_no` = `nonres_audit_trail`.`audit_trail_id`
  WHERE `is_deleted` = 0
    AND (`last_name` LIKE CONCAT('%', search_query, '%')
      OR `first_name` LIKE CONCAT('%', search_query, '%')
      OR `middle_name` LIKE CONCAT('%', search_query, '%'))
  ORDER BY `last_name` ASC
  LIMIT start_from, lim;
END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchNonResidentAudit` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchNonResidentAudit` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchNonResidentAudit`(IN search VARCHAR(255), IN start_from INT)
BEGIN
    SELECT
        `ru`.`audit_id`         AS `audit_id`,
        `ru`.`action_type`      AS `action_type`,
        `ru`.`action_timestamp` AS `action_timestamp`,
        `tu`.`depart_no`        AS `depart_no`,
        `un`.`username`         AS `username`,
        `tu`.`img_filename`     AS `img_filename`,
        CONCAT(`tu`.`lname`, ', ', `tu`.`fname`, ' ', `tu`.`mname`, ' ', `tu`.`suffix`) AS `fullname`
    FROM `nonresident_audit` `ru`
    JOIN `tbl_users` `tu`
        ON `ru`.`user_no` = `tu`.`user_id`
    JOIN `tbl_username` `un`
        ON `ru`.`user_no` = `un`.`username_id`
    WHERE
        `tu`.`fname` LIKE CONCAT('%', search, '%')
        OR `tu`.`mname` LIKE CONCAT('%', search, '%')
        OR `tu`.`lname` LIKE CONCAT('%', search, '%')
        OR `un`.`username` LIKE CONCAT('%', search, '%')
    ORDER BY `ru`.`action_timestamp` DESC
    LIMIT start_from, 10;
END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchNonResidentAuditIWithDateFilter` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchNonResidentAuditIWithDateFilter` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchNonResidentAuditIWithDateFilter`(
    IN start_from INT, 
    IN start_date DATE, 
    IN end_date DATE
)
BEGIN
    SELECT
        `ru`.`audit_id`         AS `audit_id`,
        `ru`.`action_type`      AS `action_type`,
        `ru`.`action_timestamp` AS `action_timestamp`,
        `tu`.`depart_no`        AS `depart_no`,
        `un`.`username`         AS `username`,
        `tu`.`img_filename`     AS `img_filename`,
        CONCAT(`tu`.`lname`, ', ', `tu`.`fname`, ' ', `tu`.`mname`, ' ', `tu`.`suffix`) AS `fullname`
    FROM `nonresident_audit` `ru`
    JOIN `tbl_users` `tu`
        ON `ru`.`user_no` = `tu`.`user_id`
    JOIN `tbl_username` `un`
        ON `ru`.`user_no` = `un`.`username_id`
    WHERE `ru`.`action_timestamp` >= CAST(start_date AS DATETIME)
AND `ru`.`action_timestamp` < CAST(end_date + INTERVAL 1 DAY AS DATETIME)

    ORDER BY `ru`.`action_timestamp` DESC
    LIMIT start_from, 10;
END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchNonResidentDeleted` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchNonResidentDeleted` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchNonResidentDeleted`(IN search_query VARCHAR(55), IN start_from INT, IN lim INT)
BEGIN
  SELECT
    `non_resident`.`nresident_id` AS `nresident_id`,
    DATE(`nonres_audit_trail`.`datetime_added`) AS datetime_added,
    `non_resident`.`img_filename` AS `img_filename`,
    `non_resident`.`last_name` AS `last_name`,
    `non_resident`.`first_name` AS `first_name`,
    `non_resident`.`middle_name` AS `middle_name`,
    `non_resident`.`suffix` AS `suffix`,
    `non_resident`.`house_num` AS `house_num`,
    `non_resident`.`street` AS `street`,
    `non_resident`.`subdivision` AS `subdivision`,
    `non_resident`.`district_brgy`,
    `non_resident`.`city`,
    `non_resident`.`province`,
    `non_resident`.`zipcode`,
    `non_resident`.`sex` AS `sex`,
    `non_resident`.`marital_status` AS `marital_status`,
    `non_resident`.`birth_date` AS `birth_date`,
    `non_resident`.`birth_place` AS `birth_place`,
    `non_resident`.`cellphone_num` AS `contact_num`,
    `non_resident`.`is_deleted`
  FROM `non_resident`
  JOIN `nonres_audit_trail` ON `non_resident`.`audit_trail_no` = `nonres_audit_trail`.`audit_trail_id`
  WHERE `is_deleted` = 1
    AND (`last_name` LIKE search_query
      OR `first_name` LIKE search_query
      OR `middle_name` LIKE search_query)
  ORDER BY `last_name` ASC
  LIMIT start_from, lim;
END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchNonResidentDocu` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchNonResidentDocu` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchNonResidentDocu`(IN id INT, IN start_from int, in lim int)
BEGIN
  SELECT
    `tbl_docu_request`.`request_id` AS `request_id`,
    `tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,
    `non_resident`.`nresident_id` AS `nonres_id`,
    CONVERT(`non_resident`.`last_name` USING utf8mb4) AS `last_name`,
    CONVERT(`non_resident`.`first_name` USING utf8mb4) AS `first_name`,
    CONVERT(`non_resident`.`middle_name` USING utf8mb4) AS `middle_name`,
    CONVERT(`non_resident`.`suffix` USING utf8mb4) AS `suffix`,
    CONVERT(`non_resident`.`house_num` USING utf8mb4) AS `house_num`,
    CONVERT(`non_resident`.`street` USING utf8mb4) AS `street`,
    CONVERT(`non_resident`.`subdivision` USING utf8mb4) AS `subdivision`,
    'Caloocan City' AS `city`, -- Assuming city is always 'Caloocan City' for non-residents
    (CASE WHEN (`tbl_documents`.`Barangay_Clearance` IS NOT NULL) THEN 'Barangay Clearance' 
          WHEN (`tbl_documents`.`Certificate_of_Residency` IS NOT NULL) THEN 'Certificate of Residency' 
          WHEN (`tbl_documents`.`Certificate_of_Indigency` IS NOT NULL) THEN 'Certificate of Indigency' 
          WHEN (`tbl_documents`.`Certificate_of_Good_Moral` IS NOT NULL) THEN 'Certificate of Good Moral' 
          WHEN (`tbl_documents`.`Business_Permits` IS NOT NULL) THEN 'Business Permits' 
          WHEN (`tbl_documents`.`Building_Permits` IS NOT NULL) THEN 'Building Permits' 
          WHEN (`tbl_documents`.`Excavation_Permits` IS NOT NULL) THEN 'Excavation Permits' 
          WHEN (`tbl_documents`.`Fencing_Permits` IS NOT NULL) THEN 'Fencing Permits' 
          WHEN (`tbl_documents`.`FTJS` IS NOT NULL) THEN 'First Time Job Seekers' 
          WHEN (`tbl_documents`.`Oath_of_Undertaking` IS NOT NULL) THEN 'Oath of Undertaking' 
          WHEN (`tbl_documents`.`TPRS` IS NOT NULL) THEN 'Tricycle Pedicab Regulatory Services' 
          ELSE 'Unknown Document Type' END) AS `document_desc`,
    `tbl_docu_request`.`age` AS `age`,
    CONVERT(`non_resident`.`sex` USING utf8mb4) AS `sex`,
    `tbl_docu_request`.`presented_id` AS `presented_id`,
    `tbl_docu_request`.`ID_number` AS `ID_number`,
    `tbl_docu_request`.`purpose` AS `purpose`,
    `tbl_docu_request`.`pdffile` AS `pdffile`,
    `tbl_docu_request`.`expiration_date` AS `expiration`,
    `tbl_docu_request`.`status` AS `status`,
    `tbl_docu_request`.`is_deleted` AS `is_deleted`,
    `tbl_cert_audit_trail`.`datetime_edited` AS `date_edited`,
    `tbl_cert_audit_trail`.`datetime_deleted` AS `date_deleted`
  FROM (((`tbl_docu_request`
        LEFT JOIN `non_resident` ON (`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))
       JOIN `tbl_documents` ON (`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))
     JOIN `tbl_cert_audit_trail` ON (`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))
  WHERE `tbl_docu_request`.`is_deleted` = 0 
    AND `tbl_docu_request`.`resident_no` IS NULL
    AND non_resident.`nresident_id` = id ORDER BY tbl_docu_request.request_id DESC LIMIT start_from, lim;
END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchResident` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchResident` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchResident`(in search varchar(255), in start_from int, in lim int)
BEGIN
	
	SELECT 
            `resident`.`resident_id`       AS `resident_id`,
            `res_audit_trail`.`added_dt` AS `date_recorded`,
            `resident`.`img_filename`      AS `img_filename`,
            `resident`.`last_name`         AS `last_name`,
            `resident`.`first_name`        AS `first_name`,
            `resident`.`middle_name`       AS `middle_name`,
            `resident`.`suffix`            AS `suffix`,
            `resident`.`house_num`         AS `house_num`,
            `resident`.`street`            AS `street`,
            `resident`.`subdivision`       AS `subdivision`,
            `resident`.`resident_since`    AS `resident_since`,
            `resident`.`sex`               AS `sex`,
            `resident`.`marital_status`    AS `marital_status`,
            `resident`.`birth_date`        AS `birth_date`,
            `resident`.`birth_place`       AS `birth_place`,
            `resident`.`cellphone_num`     AS `cellphone_num`,
            `resident`.`is_a_voter`        AS `is_a_voter` ,
            `resident`.`is_deleted`
            FROM resident 
            JOIN res_audit_trail 
            ON resident.audit_trail = res_audit_trail.res_at_id
            WHERE is_deleted=0 AND (last_name LIKE search OR first_name LIKE search OR middle_name LIKE search)
            ORDER BY last_name  ASC LIMIT start_from, lim;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchResidentAudit` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchResidentAudit` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchResidentAudit`(IN search VARCHAR(255), IN start_from INT)
BEGIN
    SELECT
        `ru`.`audit_id`         AS `audit_id`,
        `ru`.`action_type`      AS `action_type`,
        `ru`.`action_timestamp` AS `action_timestamp`,
        `tu`.`depart_no`        AS `depart_no`,
        `un`.`username`         AS `username`,
        `tu`.`img_filename`     AS `img_filename`,
        CONCAT(`tu`.`lname`, ', ', `tu`.`fname`, ' ', `tu`.`mname`, ' ', `tu`.`suffix`) AS `fullname`
    FROM `resident_audit` `ru`
    JOIN `tbl_users` `tu`
        ON `ru`.`user_no` = `tu`.`user_id`
    JOIN `tbl_username` `un`
        ON `ru`.`user_no` = `un`.`username_id`
    WHERE
        `tu`.`fname` LIKE CONCAT('%', search, '%')
        OR `tu`.`mname` LIKE CONCAT('%', search, '%')
        OR `tu`.`lname` LIKE CONCAT('%', search, '%')
        OR `un`.`username` LIKE CONCAT('%', search, '%')
    ORDER BY `ru`.`action_timestamp` DESC
    LIMIT start_from, 10;
END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchResidentAuditIWithDate` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchResidentAuditIWithDate` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchResidentAuditIWithDate`(
    IN search VARCHAR(255), 
    IN start_from INT, 
    IN start_date DATE, 
    IN end_date DATE
)
BEGIN
    SELECT
        `ru`.`audit_id`         AS `audit_id`,
        `ru`.`action_type`      AS `action_type`,
        `ru`.`action_timestamp` AS `action_timestamp`,
        `tu`.`depart_no`        AS `depart_no`,
        `un`.`username`         AS `username`,
        `tu`.`img_filename`     AS `img_filename`,
        CONCAT(`tu`.`lname`, ', ', `tu`.`fname`, ' ', `tu`.`mname`, ' ', `tu`.`suffix`) AS `fullname`
    FROM `nonresident_audit` `ru`
    JOIN `tbl_users` `tu`
        ON `ru`.`user_no` = `tu`.`user_id`
    JOIN `tbl_username` `un`
        ON `ru`.`user_no` = `un`.`username_id`
    WHERE
        (
            `tu`.`fname` LIKE CONCAT('%', search, '%')
            OR `tu`.`mname` LIKE CONCAT('%', search, '%')
            OR `tu`.`lname` LIKE CONCAT('%', search, '%')
            OR `un`.`username` LIKE CONCAT('%', search, '%')
        )
        AND `ru`.`action_timestamp` >= CAST(start_date AS DATETIME)
AND `ru`.`action_timestamp` < CAST(end_date + INTERVAL 1 DAY AS DATETIME)

    ORDER BY `ru`.`action_timestamp` DESC
    LIMIT start_from, 10;
END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchResidentAuditIWithDateFilter` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchResidentAuditIWithDateFilter` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchResidentAuditIWithDateFilter`(
    IN start_from INT, 
    IN start_date DATE, 
    IN end_date DATE
)
BEGIN
    SELECT
        `ru`.`audit_id`         AS `audit_id`,
        `ru`.`action_type`      AS `action_type`,
        `ru`.`action_timestamp` AS `action_timestamp`,
        `tu`.`depart_no`        AS `depart_no`,
        `un`.`username`         AS `username`,
        `tu`.`img_filename`     AS `img_filename`,
        CONCAT(`tu`.`lname`, ', ', `tu`.`fname`, ' ', `tu`.`mname`, ' ', `tu`.`suffix`) AS `fullname`
    FROM `resident_audit` `ru`
    JOIN `tbl_users` `tu`
        ON `ru`.`user_no` = `tu`.`user_id`
    JOIN `tbl_username` `un`
        ON `ru`.`user_no` = `un`.`username_id`
    WHERE `ru`.`action_timestamp` >= CAST(start_date AS DATETIME)
AND `ru`.`action_timestamp` < CAST(end_date + INTERVAL 1 DAY AS DATETIME)

    ORDER BY `ru`.`action_timestamp` DESC
    LIMIT start_from, 10;
END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchResidentDeleted` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchResidentDeleted` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchResidentDeleted`(in search varchar(255), in start_from int, in lim int)
BEGIN
	
	SELECT 
            `resident`.`resident_id`       AS `resident_id`,
            `res_audit_trail`.`added_dt` AS `date_recorded`,
            `resident`.`img_filename`      AS `img_filename`,
            `resident`.`last_name`         AS `last_name`,
            `resident`.`first_name`        AS `first_name`,
            `resident`.`middle_name`       AS `middle_name`,
            `resident`.`suffix`            AS `suffix`,
            `resident`.`house_num`         AS `house_num`,
            `resident`.`street`            AS `street`,
            `resident`.`subdivision`       AS `subdivision`,
            `resident`.`resident_since`    AS `resident_since`,
            `resident`.`sex`               AS `sex`,
            `resident`.`marital_status`    AS `marital_status`,
            `resident`.`birth_date`        AS `birth_date`,
            `resident`.`birth_place`       AS `birth_place`,
            `resident`.`cellphone_num`     AS `cellphone_num`,
            `resident`.`is_a_voter`        AS `is_a_voter` ,
            `resident`.`is_deleted`
            FROM resident 
            JOIN res_audit_trail 
            ON resident.audit_trail = res_audit_trail.res_at_id
            WHERE is_deleted=1 AND (last_name LIKE search OR first_name LIKE search OR middle_name LIKE search)
            ORDER BY last_name  ASC LIMIT start_from, lim;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchResidentDocu` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchResidentDocu` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchResidentDocu`(IN id INT, IN start_from INT, IN lim INT)
BEGIN
  SELECT
    `tbl_docu_request`.`request_id` AS `request_id`,
    `tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,
    `resident`.`resident_id` AS `res_id`,
    CONVERT(`resident`.`last_name` USING utf8mb4) AS `last_name`,
    CONVERT(`resident`.`first_name` USING utf8mb4) AS `first_name`,
    CONVERT(`resident`.`middle_name` USING utf8mb4) AS `middle_name`,
    CONVERT(`resident`.`suffix` USING utf8mb4) AS `suffix`,
    CONVERT(`resident`.`house_num` USING utf8mb4) AS `house_num`,
    CONVERT(`resident`.`street` USING utf8mb4) AS `street`,
    CONVERT(`resident`.`subdivision` USING utf8mb4) AS `subdivision`,
    'Caloocan City' AS `city`, -- Assuming city is always 'Caloocan City' for non-residents
    (CASE WHEN (`tbl_documents`.`Barangay_Clearance` IS NOT NULL) THEN 'Barangay Clearance' 
          WHEN (`tbl_documents`.`Certificate_of_Residency` IS NOT NULL) THEN 'Certificate of Residency' 
          WHEN (`tbl_documents`.`Certificate_of_Indigency` IS NOT NULL) THEN 'Certificate of Indigency' 
          WHEN (`tbl_documents`.`Certificate_of_Good_Moral` IS NOT NULL) THEN 'Certificate of Good Moral' 
          WHEN (`tbl_documents`.`Business_Permits` IS NOT NULL) THEN 'Business Permits' 
          WHEN (`tbl_documents`.`Building_Permits` IS NOT NULL) THEN 'Building Permits' 
          WHEN (`tbl_documents`.`Excavation_Permits` IS NOT NULL) THEN 'Excavation Permits' 
          WHEN (`tbl_documents`.`Fencing_Permits` IS NOT NULL) THEN 'Fencing Permits' 
          WHEN (`tbl_documents`.`FTJS` IS NOT NULL) THEN 'First Time Job Seekers' 
          WHEN (`tbl_documents`.`Oath_of_Undertaking` IS NOT NULL) THEN 'Oath of Undertaking' 
          WHEN (`tbl_documents`.`TPRS` IS NOT NULL) THEN 'Tricycle Pedicab Regulatory Services' 
          ELSE 'Unknown Document Type' END) AS `document_desc`,
    `tbl_docu_request`.`age` AS `age`,
    CONVERT(`resident`.`sex` USING utf8mb4) AS `sex`,
    `tbl_docu_request`.`presented_id` AS `presented_id`,
    `tbl_docu_request`.`ID_number` AS `ID_number`,
    `tbl_docu_request`.`purpose` AS `purpose`,
    `tbl_docu_request`.`pdffile` AS `pdffile`,
    tbl_docu_request.`expiration_date` AS `expiration`,
    `tbl_docu_request`.`status` AS `status`,
    `tbl_docu_request`.`is_deleted` AS `is_deleted`,
    `tbl_cert_audit_trail`.`datetime_edited` AS `date_edited`,
    `tbl_cert_audit_trail`.`datetime_deleted` AS `date_deleted`
  FROM (((`tbl_docu_request`
        LEFT JOIN `resident` ON (`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))
       JOIN `tbl_documents` ON (`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))
     JOIN `tbl_cert_audit_trail` ON (`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))
 WHERE `tbl_docu_request`.`is_deleted` = 0 
  AND `tbl_docu_request`.`resident_no` = id 
ORDER BY `tbl_docu_request`.`request_id` DESC 
LIMIT start_from, lim;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchTPRS` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchTPRS` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchTPRS`(IN req_id varchar(255))
BEGIN
    SELECT tbl_docu_request.`request_id`, 
           tbl_tprs.`tprs_id`, 
           tbl_tprs.`toda`,
           tbl_tprs.`route`,
           tbl_tprs.`platenum`,
           tbl_tprs.`chasisnum`,
           tbl_tprs.`enginenum`,
           tbl_tprs.`makertype`
    FROM tbl_docu_request
    JOIN tbl_documents ON tbl_docu_request.`document_no` = tbl_documents.`docu_id`
    JOIN tbl_tprs ON tbl_documents.`TPRS` = tbl_tprs.`tprs_id` 
    WHERE tbl_docu_request.`request_id` = req_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `SearchUsers` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchUsers` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchUsers`(IN search varchar(55), in start_from int, in is_deleted int)
BEGIN
    SELECT
        tu.user_id AS user_id,
        tu.img_filename AS img_filename,
        tu.fname AS fname,
        tu.mname AS mname,
        tu.lname AS lname,
        tu.suffix AS suffix,
        tu.depart_no AS depart_no,
        tu.isactive AS isactive,
        un.username AS username,
        aut.created_dt AS created_dt,
        un.username AS created_by,
        aut.last_login AS last_login,
        tu.isdeleted AS is_deleted
    FROM tbl_users tu
        JOIN tbl_username un ON tu.username_no = un.username_id
         JOIN tbl_username ON aut.created_by = un.username_id
        JOIN tbl_users_audit_trail aut ON aut.user_at_id = tu.user_at_no
    WHERE tu.isdeleted = is_deleted
        AND (
            tu.fname LIKE CONCAT('%', search, '%')
            OR tu.lname LIKE CONCAT('%', search, '%')
            OR tu.mname LIKE CONCAT('%', search, '%')
            OR un.username LIKE CONCAT('%', search, '%')
        )
    ORDER BY aut.created_dt DESC
    LIMIT start_from, 10;
     

	END */$$
DELIMITER ;

/*Table structure for table `vw_all_brgy_clearance` */

DROP TABLE IF EXISTS `vw_all_brgy_clearance`;

/*!50001 DROP VIEW IF EXISTS `vw_all_brgy_clearance` */;
/*!50001 DROP TABLE IF EXISTS `vw_all_brgy_clearance` */;

/*!50001 CREATE TABLE  `vw_all_brgy_clearance`(
 `request_id` varchar(255) ,
 `last_name` varchar(255) ,
 `first_name` varchar(255) ,
 `middle_name` varchar(255) ,
 `suffix` varchar(10) ,
 `house_num` varchar(255) ,
 `street` varchar(255) ,
 `subdivision` varchar(255) ,
 `age` int(10) ,
 `presented_id` varchar(255) ,
 `ID_number` varchar(255) ,
 `purpose` varchar(255) ,
 `date_issued` datetime ,
 `expires` date ,
 `department_issued` varchar(50) ,
 `issued_by` varchar(255) ,
 `status` tinyint(3) ,
 `is_deleted` tinyint(2) 
)*/;

/*Table structure for table `vw_all_build_permits` */

DROP TABLE IF EXISTS `vw_all_build_permits`;

/*!50001 DROP VIEW IF EXISTS `vw_all_build_permits` */;
/*!50001 DROP TABLE IF EXISTS `vw_all_build_permits` */;

/*!50001 CREATE TABLE  `vw_all_build_permits`(
 `request_id` varchar(255) ,
 `last_name` varchar(255) ,
 `first_name` varchar(255) ,
 `middle_name` varchar(255) ,
 `suffix` varchar(10) ,
 `owner_status` varchar(12) ,
 `age` int(10) ,
 `presented_id` varchar(255) ,
 `ID_number` varchar(255) ,
 `purpose` varchar(255) ,
 `blg_house_no` varchar(255) ,
 `street` varchar(255) ,
 `subd` varchar(255) ,
 `date_issued` datetime ,
 `expires` date ,
 `department_issued` varchar(50) ,
 `issued_by` varchar(255) ,
 `status` tinyint(3) ,
 `is_deleted` tinyint(2) 
)*/;

/*Table structure for table `vw_all_buss_permits` */

DROP TABLE IF EXISTS `vw_all_buss_permits`;

/*!50001 DROP VIEW IF EXISTS `vw_all_buss_permits` */;
/*!50001 DROP TABLE IF EXISTS `vw_all_buss_permits` */;

/*!50001 CREATE TABLE  `vw_all_buss_permits`(
 `request_id` varchar(255) ,
 `last_name` varchar(255) ,
 `first_name` varchar(255) ,
 `middle_name` varchar(255) ,
 `suffix` varchar(10) ,
 `owner_status` varchar(12) ,
 `age` int(10) ,
 `presented_id` varchar(255) ,
 `ID_number` varchar(255) ,
 `purpose` varchar(255) ,
 `store_name` varchar(255) ,
 `blg_house_no` varchar(255) ,
 `street` varchar(255) ,
 `subdivision` varchar(255) ,
 `type_of_buss` varchar(255) ,
 `date_issued` datetime ,
 `expires` date ,
 `department_issued` varchar(50) ,
 `issued_by` varchar(255) ,
 `status` tinyint(3) ,
 `is_deleted` tinyint(2) 
)*/;

/*Table structure for table `vw_all_cgmoral` */

DROP TABLE IF EXISTS `vw_all_cgmoral`;

/*!50001 DROP VIEW IF EXISTS `vw_all_cgmoral` */;
/*!50001 DROP TABLE IF EXISTS `vw_all_cgmoral` */;

/*!50001 CREATE TABLE  `vw_all_cgmoral`(
 `request_id` varchar(255) ,
 `last_name` varchar(255) ,
 `first_name` varchar(255) ,
 `middle_name` varchar(255) ,
 `suffix` varchar(10) ,
 `house_num` varchar(255) ,
 `street` varchar(255) ,
 `subdivision` varchar(255) ,
 `age` int(10) ,
 `presented_id` varchar(255) ,
 `ID_number` varchar(255) ,
 `purpose` varchar(255) ,
 `date_issued` datetime ,
 `expires` date ,
 `department_issued` varchar(50) ,
 `issued_by` varchar(255) ,
 `status` tinyint(3) ,
 `is_deleted` tinyint(2) 
)*/;

/*Table structure for table `vw_all_cindigency` */

DROP TABLE IF EXISTS `vw_all_cindigency`;

/*!50001 DROP VIEW IF EXISTS `vw_all_cindigency` */;
/*!50001 DROP TABLE IF EXISTS `vw_all_cindigency` */;

/*!50001 CREATE TABLE  `vw_all_cindigency`(
 `request_id` varchar(255) ,
 `last_name` varchar(255) ,
 `first_name` varchar(255) ,
 `middle_name` varchar(255) ,
 `suffix` varchar(10) ,
 `house_num` varchar(255) ,
 `street` varchar(255) ,
 `subdivision` varchar(255) ,
 `age` int(10) ,
 `presented_id` varchar(255) ,
 `ID_number` varchar(255) ,
 `purpose` varchar(255) ,
 `date_issued` datetime ,
 `expires` date ,
 `department_issued` varchar(50) ,
 `issued_by` varchar(255) ,
 `status` tinyint(3) ,
 `is_deleted` tinyint(2) 
)*/;

/*Table structure for table `vw_all_cresidency` */

DROP TABLE IF EXISTS `vw_all_cresidency`;

/*!50001 DROP VIEW IF EXISTS `vw_all_cresidency` */;
/*!50001 DROP TABLE IF EXISTS `vw_all_cresidency` */;

/*!50001 CREATE TABLE  `vw_all_cresidency`(
 `request_id` varchar(255) ,
 `last_name` varchar(255) ,
 `first_name` varchar(255) ,
 `middle_name` varchar(255) ,
 `suffix` varchar(10) ,
 `house_num` varchar(255) ,
 `street` varchar(255) ,
 `subdivision` varchar(255) ,
 `age` int(10) ,
 `presented_id` varchar(255) ,
 `ID_number` varchar(255) ,
 `purpose` varchar(255) ,
 `date_issued` datetime ,
 `expires` date ,
 `department_issued` varchar(50) ,
 `issued_by` varchar(255) ,
 `status` tinyint(3) ,
 `is_deleted` tinyint(2) 
)*/;

/*Table structure for table `vw_all_documents` */

DROP TABLE IF EXISTS `vw_all_documents`;

/*!50001 DROP VIEW IF EXISTS `vw_all_documents` */;
/*!50001 DROP TABLE IF EXISTS `vw_all_documents` */;

/*!50001 CREATE TABLE  `vw_all_documents`(
 `request_id` varchar(255) ,
 `date_issued` datetime ,
 `is_resident` varchar(1) ,
 `resident/nonres_id` bigint(55) ,
 `last_name` varchar(255) ,
 `first_name` varchar(255) ,
 `middle_name` varchar(255) ,
 `suffix` varchar(10) ,
 `house_num` varchar(255) ,
 `street` varchar(255) ,
 `subdivision` varchar(255) ,
 `city` varchar(255) ,
 `document_desc` varchar(36) ,
 `age` int(10) ,
 `sex` varchar(255) ,
 `presented_id` varchar(255) ,
 `ID_number` varchar(255) ,
 `purpose` varchar(255) ,
 `pdffile` varchar(255) ,
 `expiration` date ,
 `status` tinyint(3) ,
 `is_deleted` tinyint(2) ,
 `date_edited` datetime ,
 `date_deleted` date 
)*/;

/*Table structure for table `vw_all_exca_permits` */

DROP TABLE IF EXISTS `vw_all_exca_permits`;

/*!50001 DROP VIEW IF EXISTS `vw_all_exca_permits` */;
/*!50001 DROP TABLE IF EXISTS `vw_all_exca_permits` */;

/*!50001 CREATE TABLE  `vw_all_exca_permits`(
 `request_id` varchar(255) ,
 `last_name` varchar(255) ,
 `first_name` varchar(255) ,
 `middle_name` varchar(255) ,
 `suffix` varchar(10) ,
 `owner_status` varchar(12) ,
 `age` int(10) ,
 `presented_id` varchar(255) ,
 `ID_number` varchar(255) ,
 `purpose` varchar(255) ,
 `blg_house_no` varchar(255) ,
 `street` varchar(255) ,
 `subd` varchar(255) ,
 `date_issued` datetime ,
 `expires` date ,
 `department_issued` varchar(50) ,
 `issued_by` varchar(255) ,
 `status` tinyint(3) ,
 `is_deleted` tinyint(2) 
)*/;

/*Table structure for table `vw_all_ftjs` */

DROP TABLE IF EXISTS `vw_all_ftjs`;

/*!50001 DROP VIEW IF EXISTS `vw_all_ftjs` */;
/*!50001 DROP TABLE IF EXISTS `vw_all_ftjs` */;

/*!50001 CREATE TABLE  `vw_all_ftjs`(
 `request_id` varchar(255) ,
 `last_name` varchar(255) ,
 `first_name` varchar(255) ,
 `middle_name` varchar(255) ,
 `suffix` varchar(10) ,
 `house_num` varchar(255) ,
 `street` varchar(255) ,
 `subdivision` varchar(255) ,
 `age` int(10) ,
 `presented_id` varchar(255) ,
 `ID_number` varchar(255) ,
 `purpose` varchar(255) ,
 `date_issued` datetime ,
 `expires` date ,
 `department_issued` varchar(50) ,
 `issued_by` varchar(255) ,
 `status` tinyint(3) ,
 `is_deleted` tinyint(2) 
)*/;

/*Table structure for table `vw_all_out` */

DROP TABLE IF EXISTS `vw_all_out`;

/*!50001 DROP VIEW IF EXISTS `vw_all_out` */;
/*!50001 DROP TABLE IF EXISTS `vw_all_out` */;

/*!50001 CREATE TABLE  `vw_all_out`(
 `request_id` varchar(255) ,
 `last_name` varchar(255) ,
 `first_name` varchar(255) ,
 `middle_name` varchar(255) ,
 `suffix` varchar(10) ,
 `house_no` varchar(255) ,
 `street` varchar(255) ,
 `subdivision` varchar(255) ,
 `age` int(10) ,
 `presented_id` varchar(255) ,
 `ID_number` varchar(255) ,
 `purpose` varchar(255) ,
 `date_issued` datetime ,
 `expires` date ,
 `department_issued` varchar(50) ,
 `issued_by` varchar(255) ,
 `status` tinyint(3) ,
 `is_deleted` tinyint(2) 
)*/;

/*Table structure for table `vw_all_res_cert` */

DROP TABLE IF EXISTS `vw_all_res_cert`;

/*!50001 DROP VIEW IF EXISTS `vw_all_res_cert` */;
/*!50001 DROP TABLE IF EXISTS `vw_all_res_cert` */;

/*!50001 CREATE TABLE  `vw_all_res_cert`(
 `request_id` varchar(255) ,
 `resident_no` int(55) ,
 `cert_type` varchar(36) ,
 `date_issued` datetime ,
 `expiration` date ,
 `purpose` varchar(255) ,
 `age` int(10) ,
 `presented_id` varchar(255) ,
 `ID_number` varchar(255) ,
 `status` tinyint(3) 
)*/;

/*Table structure for table `vw_all_tprs` */

DROP TABLE IF EXISTS `vw_all_tprs`;

/*!50001 DROP VIEW IF EXISTS `vw_all_tprs` */;
/*!50001 DROP TABLE IF EXISTS `vw_all_tprs` */;

/*!50001 CREATE TABLE  `vw_all_tprs`(
 `request_id` varchar(255) ,
 `last_name` varchar(255) ,
 `first_name` varchar(255) ,
 `middle_name` varchar(255) ,
 `suffix` varchar(10) ,
 `owner_status` varchar(12) ,
 `age` int(10) ,
 `presented_id` varchar(255) ,
 `ID_number` varchar(255) ,
 `purpose` varchar(255) ,
 `toda` varchar(255) ,
 `route` varchar(255) ,
 `platenum` varchar(255) ,
 `chasisnum` varchar(255) ,
 `makertype` varchar(255) ,
 `engine_no` varchar(255) ,
 `date_issued` datetime ,
 `expires` date ,
 `department_issued` varchar(50) ,
 `issued_by` varchar(255) ,
 `status` tinyint(3) ,
 `is_deleted` tinyint(2) 
)*/;

/*Table structure for table `vw_blotters` */

DROP TABLE IF EXISTS `vw_blotters`;

/*!50001 DROP VIEW IF EXISTS `vw_blotters` */;
/*!50001 DROP TABLE IF EXISTS `vw_blotters` */;

/*!50001 CREATE TABLE  `vw_blotters`(
 `blotter_id` int(55) ,
 `blotter_add_dt` datetime ,
 `complainant_status` varchar(12) ,
 `complainant_no` varchar(55) ,
 `respondent_status` varchar(12) ,
 `respondent_no` varchar(55) ,
 `complainant_filename` varchar(255) ,
 `respondent_filename` varchar(255) ,
 `complainant_address` text ,
 `respondent_address` text ,
 `blotter_type` tinyint(5) ,
 `desc_incident` varchar(255) ,
 `incident_dt` datetime ,
 `report_status` tinyint(5) ,
 `is_deleted` tinyint(5) ,
 `complainant_last_name` varchar(255) ,
 `complainant_first_name` varchar(255) ,
 `complainant_middle_name` varchar(255) ,
 `complainant_suffix` varchar(10) ,
 `respondent_last_name` varchar(255) ,
 `respondent_first_name` varchar(255) ,
 `respondent_middle_name` varchar(255) ,
 `respondent_suffix` varchar(10) 
)*/;

/*Table structure for table `vw_blotters_deleted` */

DROP TABLE IF EXISTS `vw_blotters_deleted`;

/*!50001 DROP VIEW IF EXISTS `vw_blotters_deleted` */;
/*!50001 DROP TABLE IF EXISTS `vw_blotters_deleted` */;

/*!50001 CREATE TABLE  `vw_blotters_deleted`(
 `blotter_id` int(55) ,
 `blotter_add_dt` datetime ,
 `complainant_status` varchar(12) ,
 `complainant_no` varchar(55) ,
 `respondent_status` varchar(12) ,
 `respondent_no` varchar(55) ,
 `complainant_filename` varchar(255) ,
 `respondent_filename` varchar(255) ,
 `complainant_address` text ,
 `respondent_address` text ,
 `blotter_type` tinyint(5) ,
 `desc_incident` varchar(255) ,
 `incident_dt` datetime ,
 `report_status` tinyint(5) ,
 `is_deleted` tinyint(5) ,
 `complainant_last_name` varchar(255) ,
 `complainant_first_name` varchar(255) ,
 `complainant_middle_name` varchar(255) ,
 `complainant_suffix` varchar(10) ,
 `respondent_last_name` varchar(255) ,
 `respondent_first_name` varchar(255) ,
 `respondent_middle_name` varchar(255) ,
 `respondent_suffix` varchar(10) 
)*/;

/*Table structure for table `vw_blotters_schedule` */

DROP TABLE IF EXISTS `vw_blotters_schedule`;

/*!50001 DROP VIEW IF EXISTS `vw_blotters_schedule` */;
/*!50001 DROP TABLE IF EXISTS `vw_blotters_schedule` */;

/*!50001 CREATE TABLE  `vw_blotters_schedule`(
 `blotter_id` int(55) ,
 `complainant_fullname` text ,
 `complainant_status` varchar(12) ,
 `respondent_fullname` text ,
 `respondent_status` varchar(12) ,
 `desc_incident` varchar(255) ,
 `incident_dt` datetime ,
 `location_of_incident` varchar(255) ,
 `date_of_resolution` date ,
 `mediation_date` date ,
 `mediation_starttime` time ,
 `mediation_endtime` time ,
 `schedule_color` varchar(55) ,
 `report_status` tinyint(5) 
)*/;

/*Table structure for table `vw_deleted_docu` */

DROP TABLE IF EXISTS `vw_deleted_docu`;

/*!50001 DROP VIEW IF EXISTS `vw_deleted_docu` */;
/*!50001 DROP TABLE IF EXISTS `vw_deleted_docu` */;

/*!50001 CREATE TABLE  `vw_deleted_docu`(
 `request_id` varchar(255) ,
 `date_issued` datetime ,
 `is_resident` varchar(1) ,
 `resident/nonres_id` bigint(55) ,
 `last_name` varchar(255) ,
 `first_name` varchar(255) ,
 `middle_name` varchar(255) ,
 `suffix` varchar(10) ,
 `house_num` varchar(255) ,
 `street` varchar(255) ,
 `subdivision` varchar(255) ,
 `city` varchar(255) ,
 `document_desc` varchar(36) ,
 `age` int(10) ,
 `sex` varchar(255) ,
 `presented_id` varchar(255) ,
 `ID_number` varchar(255) ,
 `purpose` varchar(255) ,
 `pdffile` varchar(255) ,
 `expiration` date ,
 `status` tinyint(3) ,
 `is_deleted` tinyint(2) ,
 `date_edited` datetime ,
 `date_deleted` date 
)*/;

/*Table structure for table `vw_documents_audit` */

DROP TABLE IF EXISTS `vw_documents_audit`;

/*!50001 DROP VIEW IF EXISTS `vw_documents_audit` */;
/*!50001 DROP TABLE IF EXISTS `vw_documents_audit` */;

/*!50001 CREATE TABLE  `vw_documents_audit`(
 `audit_id` int(11) ,
 `action_type` enum('INSERT','UPDATE','DELETE','RECOVER') ,
 `action_timestamp` timestamp ,
 `depart_no` int(55) ,
 `username` varchar(255) ,
 `img_filename` varchar(255) ,
 `fullname` varchar(224) 
)*/;

/*Table structure for table `vw_nonresident` */

DROP TABLE IF EXISTS `vw_nonresident`;

/*!50001 DROP VIEW IF EXISTS `vw_nonresident` */;
/*!50001 DROP TABLE IF EXISTS `vw_nonresident` */;

/*!50001 CREATE TABLE  `vw_nonresident`(
 `nresident_id` int(55) ,
 `datetime_added` datetime ,
 `img_filename` varchar(255) ,
 `last_name` varchar(255) ,
 `first_name` varchar(255) ,
 `middle_name` varchar(255) ,
 `suffix` varchar(10) ,
 `house_num` varchar(255) ,
 `street` varchar(255) ,
 `subdivision` varchar(255) ,
 `district_brgy` varchar(255) ,
 `city` varchar(255) ,
 `province` varchar(255) ,
 `zipcode` varchar(255) ,
 `sex` varchar(55) ,
 `marital_status` varchar(255) ,
 `birth_date` date ,
 `birth_place` varchar(255) ,
 `cellphone_num` varchar(50) ,
 `audit_trail_no` int(55) ,
 `is_deleted` tinyint(2) 
)*/;

/*Table structure for table `vw_nonresident_audit` */

DROP TABLE IF EXISTS `vw_nonresident_audit`;

/*!50001 DROP VIEW IF EXISTS `vw_nonresident_audit` */;
/*!50001 DROP TABLE IF EXISTS `vw_nonresident_audit` */;

/*!50001 CREATE TABLE  `vw_nonresident_audit`(
 `audit_id` int(11) ,
 `action_type` enum('INSERT','UPDATE','DELETE','RECOVER') ,
 `action_timestamp` timestamp ,
 `depart_no` int(55) ,
 `username` varchar(255) ,
 `img_filename` varchar(255) ,
 `fullname` varchar(224) 
)*/;

/*Table structure for table `vw_nonresident_deleted` */

DROP TABLE IF EXISTS `vw_nonresident_deleted`;

/*!50001 DROP VIEW IF EXISTS `vw_nonresident_deleted` */;
/*!50001 DROP TABLE IF EXISTS `vw_nonresident_deleted` */;

/*!50001 CREATE TABLE  `vw_nonresident_deleted`(
 `nresident_id` int(55) ,
 `datetime_added` date ,
 `img_filename` varchar(255) ,
 `last_name` varchar(255) ,
 `first_name` varchar(255) ,
 `middle_name` varchar(255) ,
 `suffix` varchar(10) ,
 `house_num` varchar(255) ,
 `street` varchar(255) ,
 `subdivision` varchar(255) ,
 `district_brgy` varchar(255) ,
 `city` varchar(255) ,
 `province` varchar(255) ,
 `zipcode` varchar(255) ,
 `sex` varchar(55) ,
 `marital_status` varchar(255) ,
 `birth_date` date ,
 `birth_place` varchar(255) ,
 `cellphone_num` varchar(50) ,
 `is_deleted` tinyint(2) 
)*/;

/*Table structure for table `vw_resident` */

DROP TABLE IF EXISTS `vw_resident`;

/*!50001 DROP VIEW IF EXISTS `vw_resident` */;
/*!50001 DROP TABLE IF EXISTS `vw_resident` */;

/*!50001 CREATE TABLE  `vw_resident`(
 `resident_id` int(55) ,
 `date_recorded` datetime ,
 `img_filename` varchar(255) ,
 `last_name` varchar(255) ,
 `first_name` varchar(255) ,
 `middle_name` varchar(255) ,
 `suffix` varchar(10) ,
 `house_num` varchar(255) ,
 `street` varchar(255) ,
 `subdivision` varchar(255) ,
 `resident_since` varchar(255) ,
 `sex` varchar(255) ,
 `marital_status` varchar(50) ,
 `birth_date` date ,
 `birth_place` varchar(255) ,
 `cellphone_num` varchar(55) ,
 `is_a_voter` tinyint(2) ,
 `is_deleted` tinyint(2) 
)*/;

/*Table structure for table `vw_resident_audit` */

DROP TABLE IF EXISTS `vw_resident_audit`;

/*!50001 DROP VIEW IF EXISTS `vw_resident_audit` */;
/*!50001 DROP TABLE IF EXISTS `vw_resident_audit` */;

/*!50001 CREATE TABLE  `vw_resident_audit`(
 `audit_id` int(11) ,
 `action_type` enum('INSERT','UPDATE','DELETE','RECOVER') ,
 `action_timestamp` timestamp ,
 `depart_no` int(55) ,
 `username` varchar(255) ,
 `img_filename` varchar(255) ,
 `fullname` varchar(224) 
)*/;

/*Table structure for table `vw_resident_deleted` */

DROP TABLE IF EXISTS `vw_resident_deleted`;

/*!50001 DROP VIEW IF EXISTS `vw_resident_deleted` */;
/*!50001 DROP TABLE IF EXISTS `vw_resident_deleted` */;

/*!50001 CREATE TABLE  `vw_resident_deleted`(
 `resident_id` int(55) ,
 `date_recorded` datetime ,
 `img_filename` varchar(255) ,
 `last_name` varchar(255) ,
 `first_name` varchar(255) ,
 `middle_name` varchar(255) ,
 `suffix` varchar(10) ,
 `house_num` varchar(255) ,
 `street` varchar(255) ,
 `subdivision` varchar(255) ,
 `resident_since` varchar(255) ,
 `sex` varchar(255) ,
 `marital_status` varchar(50) ,
 `birth_date` date ,
 `birth_place` varchar(255) ,
 `cellphone_num` varchar(55) ,
 `is_a_voter` tinyint(2) ,
 `is_deleted` tinyint(2) 
)*/;

/*Table structure for table `vw_resonly_cert` */

DROP TABLE IF EXISTS `vw_resonly_cert`;

/*!50001 DROP VIEW IF EXISTS `vw_resonly_cert` */;
/*!50001 DROP TABLE IF EXISTS `vw_resonly_cert` */;

/*!50001 CREATE TABLE  `vw_resonly_cert`(
 `request_id` varchar(255) ,
 `date_issued` datetime ,
 `resident_id` int(55) ,
 `document_desc` varchar(36) ,
 `age` int(10) ,
 `sex` varchar(255) ,
 `presented_id` varchar(255) ,
 `ID_number` varchar(255) ,
 `purpose` varchar(255) ,
 `pdffile` varchar(255) ,
 `expiration` date ,
 `status` tinyint(3) ,
 `is_deleted` tinyint(2) ,
 `date_edited` datetime ,
 `date_deleted` date 
)*/;

/*Table structure for table `vw_select_nonresident` */

DROP TABLE IF EXISTS `vw_select_nonresident`;

/*!50001 DROP VIEW IF EXISTS `vw_select_nonresident` */;
/*!50001 DROP TABLE IF EXISTS `vw_select_nonresident` */;

/*!50001 CREATE TABLE  `vw_select_nonresident`(
 `nresident_id` int(55) ,
 `img_filename` varchar(255) ,
 `full_name` text ,
 `address` text ,
 `sex` varchar(55) ,
 `marital_status` varchar(255) ,
 `birth_date` date ,
 `cellphone_num` varchar(50) 
)*/;

/*Table structure for table `vw_select_resident` */

DROP TABLE IF EXISTS `vw_select_resident`;

/*!50001 DROP VIEW IF EXISTS `vw_select_resident` */;
/*!50001 DROP TABLE IF EXISTS `vw_select_resident` */;

/*!50001 CREATE TABLE  `vw_select_resident`(
 `resident_id` int(55) ,
 `img_filename` varchar(255) ,
 `full_name` text ,
 `address` text ,
 `sex` varchar(255) ,
 `marital_status` varchar(50) ,
 `birth_date` date ,
 `cellphone_num` varchar(55) ,
 `is_a_voter` tinyint(2) 
)*/;

/*Table structure for table `vw_users` */

DROP TABLE IF EXISTS `vw_users`;

/*!50001 DROP VIEW IF EXISTS `vw_users` */;
/*!50001 DROP TABLE IF EXISTS `vw_users` */;

/*!50001 CREATE TABLE  `vw_users`(
 `user_id` int(11) ,
 `img_filename` varchar(255) ,
 `fname` varchar(55) ,
 `mname` varchar(55) ,
 `lname` varchar(55) ,
 `suffix` varchar(55) ,
 `depart_no` int(55) ,
 `isactive` tinyint(11) ,
 `username` varchar(255) ,
 `created_dt` datetime ,
 `last_login` datetime ,
 `is_deleted` tinyint(11) ,
 `created_by` varchar(255) 
)*/;

/*View structure for view vw_all_brgy_clearance */

/*!50001 DROP TABLE IF EXISTS `vw_all_brgy_clearance` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_brgy_clearance` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_brgy_clearance` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_num`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_docu_request`.`expiration_date` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from ((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`))) where (`tbl_documents`.`Barangay_Clearance` is not null)) */;

/*View structure for view vw_all_build_permits */

/*!50001 DROP TABLE IF EXISTS `vw_all_build_permits` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_build_permits` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_build_permits` AS (select `tbl_docu_request`.`request_id` AS `request_id`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`last_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`last_name` else NULL end) using utf8mb4)) AS `last_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`first_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`first_name` else NULL end) using utf8mb4)) AS `first_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`middle_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`middle_name` else NULL end) using utf8mb4)) AS `middle_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`suffix` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`suffix` else NULL end) using utf8mb4)) AS `suffix`,(case when (`tbl_docu_request`.`resident_no` is not null) then 'Resident' when (`tbl_docu_request`.`nresident_no` is not null) then 'Non-Resident' else 'Unknown' end) AS `owner_status`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_building_permits`.`blg_house_no` AS `blg_house_no`,`tbl_building_permits`.`street` AS `street`,`tbl_building_permits`.`subd` AS `subd`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_docu_request`.`expiration_date` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from (((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) join `tbl_building_permits` on((`tbl_documents`.`Building_Permits` = `tbl_building_permits`.`building_permit_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`)))) */;

/*View structure for view vw_all_buss_permits */

/*!50001 DROP TABLE IF EXISTS `vw_all_buss_permits` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_buss_permits` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_buss_permits` AS (select `tbl_docu_request`.`request_id` AS `request_id`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`last_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`last_name` else NULL end) using utf8mb4)) AS `last_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`first_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`first_name` else NULL end) using utf8mb4)) AS `first_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`middle_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`middle_name` else NULL end) using utf8mb4)) AS `middle_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`suffix` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`suffix` else NULL end) using utf8mb4)) AS `suffix`,(case when (`tbl_docu_request`.`resident_no` is not null) then 'Resident' when (`tbl_docu_request`.`nresident_no` is not null) then 'Non-Resident' else 'Unknown' end) AS `owner_status`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_business_permits`.`store_name` AS `store_name`,`tbl_business_permits`.`blg_house_no` AS `blg_house_no`,`tbl_business_permits`.`street` AS `street`,`tbl_business_permits`.`subdivision` AS `subdivision`,`tbl_business_permits`.`type_of_buss` AS `type_of_buss`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_docu_request`.`expiration_date` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from (((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`Business_Permits`))) join `tbl_business_permits` on((`tbl_documents`.`Business_Permits` = `tbl_business_permits`.`business_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`)))) */;

/*View structure for view vw_all_cgmoral */

/*!50001 DROP TABLE IF EXISTS `vw_all_cgmoral` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_cgmoral` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_cgmoral` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_num`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_docu_request`.`expiration_date` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from ((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`))) where (`tbl_documents`.`Certificate_of_Good_Moral` is not null)) */;

/*View structure for view vw_all_cindigency */

/*!50001 DROP TABLE IF EXISTS `vw_all_cindigency` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_cindigency` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_cindigency` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_num`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_docu_request`.`expiration_date` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from (((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`))) where (`tbl_documents`.`Certificate_of_Indigency` is not null)) */;

/*View structure for view vw_all_cresidency */

/*!50001 DROP TABLE IF EXISTS `vw_all_cresidency` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_cresidency` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_cresidency` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_num`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_docu_request`.`expiration_date` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from ((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`))) where (`tbl_documents`.`Certificate_of_Residency` is not null)) */;

/*View structure for view vw_all_documents */

/*!50001 DROP TABLE IF EXISTS `vw_all_documents` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_documents` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_documents` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,(case when (`tbl_docu_request`.`resident_no` is not null) then '1' else '0' end) AS `is_resident`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`resident_id` else `non_resident`.`nresident_id` end) AS `resident/nonres_id`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`last_name` else convert(`non_resident`.`last_name` using utf8mb4) end) AS `last_name`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`first_name` else convert(`non_resident`.`first_name` using utf8mb4) end) AS `first_name`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`middle_name` else convert(`non_resident`.`middle_name` using utf8mb4) end) AS `middle_name`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`suffix` else convert(`non_resident`.`suffix` using utf8mb4) end) AS `suffix`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`house_num` else convert(`non_resident`.`house_num` using utf8mb4) end) AS `house_num`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`street` else convert(`non_resident`.`street` using utf8mb4) end) AS `street`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`subdivision` else convert(`non_resident`.`subdivision` using utf8mb4) end) AS `subdivision`,(case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`city` else 'Caloocan City' end) AS `city`,(case when (`tbl_documents`.`Barangay_Clearance` is not null) then 'Barangay Clearance' when (`tbl_documents`.`Certificate_of_Residency` is not null) then 'Certificate of Residency' when (`tbl_documents`.`Certificate_of_Indigency` is not null) then 'Certificate of Indigency' when (`tbl_documents`.`Certificate_of_Good_Moral` is not null) then 'Certificate of Good Moral' when (`tbl_documents`.`Business_Permits` is not null) then 'Business Permits' when (`tbl_documents`.`Building_Permits` is not null) then 'Building Permits' when (`tbl_documents`.`Excavation_Permits` is not null) then 'Excavation Permits' when (`tbl_documents`.`Fencing_Permits` is not null) then 'Fencing Permits' when (`tbl_documents`.`FTJS` is not null) then 'First Time Job Seekers' when (`tbl_documents`.`Oath_of_Undertaking` is not null) then 'Oath of Undertaking' when (`tbl_documents`.`TPRS` is not null) then 'Tricycle Pedicab Regulatory Services' else 'Unknown Document Type' end) AS `document_desc`,`tbl_docu_request`.`age` AS `age`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`sex` else convert(`non_resident`.`sex` using utf8mb4) end) AS `sex`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_docu_request`.`pdffile` AS `pdffile`,`tbl_docu_request`.`expiration_date` AS `expiration`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted`,`tbl_cert_audit_trail`.`datetime_edited` AS `date_edited`,`tbl_cert_audit_trail`.`datetime_deleted` AS `date_deleted` from ((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) where (`tbl_docu_request`.`is_deleted` = 0)) */;

/*View structure for view vw_all_exca_permits */

/*!50001 DROP TABLE IF EXISTS `vw_all_exca_permits` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_exca_permits` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_exca_permits` AS (select `tbl_docu_request`.`request_id` AS `request_id`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`last_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`last_name` else NULL end) using utf8mb4)) AS `last_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`first_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`first_name` else NULL end) using utf8mb4)) AS `first_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`middle_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`middle_name` else NULL end) using utf8mb4)) AS `middle_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`suffix` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`suffix` else NULL end) using utf8mb4)) AS `suffix`,(case when (`tbl_docu_request`.`resident_no` is not null) then 'Resident' when (`tbl_docu_request`.`nresident_no` is not null) then 'Non-Resident' else 'Unknown' end) AS `owner_status`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_excavation_permits`.`blg_house_no` AS `blg_house_no`,`tbl_excavation_permits`.`street` AS `street`,`tbl_excavation_permits`.`subd` AS `subd`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_docu_request`.`expiration_date` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from (((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) join `tbl_excavation_permits` on((`tbl_documents`.`Building_Permits` = `tbl_excavation_permits`.`exca_permit_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`)))) */;

/*View structure for view vw_all_ftjs */

/*!50001 DROP TABLE IF EXISTS `vw_all_ftjs` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_ftjs` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_ftjs` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_num`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_docu_request`.`expiration_date` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from ((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`))) where (`tbl_documents`.`FTJS` is not null)) */;

/*View structure for view vw_all_out */

/*!50001 DROP TABLE IF EXISTS `vw_all_out` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_out` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_out` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_no`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_docu_request`.`expiration_date` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from ((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`))) where (`tbl_documents`.`Oath_of_Undertaking` is not null)) */;

/*View structure for view vw_all_res_cert */

/*!50001 DROP TABLE IF EXISTS `vw_all_res_cert` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_res_cert` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_res_cert` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`tbl_docu_request`.`resident_no` AS `resident_no`,(case when (`tbl_documents`.`Barangay_Clearance` is not null) then 'Barangay Clearance' when (`tbl_documents`.`Certificate_of_Residency` is not null) then 'Certificate of Residency' when (`tbl_documents`.`Certificate_of_Indigency` is not null) then 'Certificate of Indigency' when (`tbl_documents`.`Certificate_of_Good_Moral` is not null) then 'Certificate of Good Moral' when (`tbl_documents`.`FTJS` is not null) then 'First Time Job Seeker' when (`tbl_documents`.`Oath_of_Undertaking` is not null) then 'Oath of Undertaking' when (`tbl_documents`.`Business_Permits` is not null) then 'Business Permits' when (`tbl_documents`.`Building_Permits` is not null) then 'Building Permits' when (`tbl_documents`.`Fencing_Permits` is not null) then 'Fencing Permit' when (`tbl_documents`.`Excavation_Permits` is not null) then 'Excavation Permit' when (`tbl_documents`.`TPRS` is not null) then 'Tricycle Pedicab Regulatory Services' else 'Unknown' end) AS `cert_type`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_docu_request`.`expiration_date` AS `expiration`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`status` AS `status` from (((`tbl_docu_request` join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`)))) */;

/*View structure for view vw_all_tprs */

/*!50001 DROP TABLE IF EXISTS `vw_all_tprs` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_tprs` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_tprs` AS (select `tbl_docu_request`.`request_id` AS `request_id`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`last_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`last_name` else NULL end) using utf8mb4)) AS `last_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`first_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`first_name` else NULL end) using utf8mb4)) AS `first_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`middle_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`middle_name` else NULL end) using utf8mb4)) AS `middle_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`suffix` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`suffix` else NULL end) using utf8mb4)) AS `suffix`,(case when (`tbl_docu_request`.`resident_no` is not null) then 'Resident' when (`tbl_docu_request`.`nresident_no` is not null) then 'Non-Resident' else 'Unknown' end) AS `owner_status`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_tprs`.`toda` AS `toda`,`tbl_tprs`.`route` AS `route`,`tbl_tprs`.`platenum` AS `platenum`,`tbl_tprs`.`chasisnum` AS `chasisnum`,`tbl_tprs`.`makertype` AS `makertype`,`tbl_tprs`.`enginenum` AS `engine_no`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_docu_request`.`expiration_date` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from (((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) join `tbl_tprs` on((`tbl_documents`.`Building_Permits` = `tbl_tprs`.`tprs_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`)))) */;

/*View structure for view vw_blotters */

/*!50001 DROP TABLE IF EXISTS `vw_blotters` */;
/*!50001 DROP VIEW IF EXISTS `vw_blotters` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_blotters` AS (select `tbl_blotters`.`blotter_id` AS `blotter_id`,`tbl_blotter_audit_trail`.`blotter_add_dt` AS `blotter_add_dt`,(case when (`tbl_blotters`.`res_complainant_no` is not null) then 'Resident' when (`tbl_blotters`.`nres_complainant_no` is not null) then 'Non-Resident' else 'unknown' end) AS `complainant_status`,(case when (`tbl_blotters`.`res_complainant_no` is not null) then `tbl_blotters`.`res_complainant_no` when (`tbl_blotters`.`nres_complainant_no` is not null) then `tbl_blotters`.`nres_complainant_no` else 'unknown' end) AS `complainant_no`,(case when (`tbl_blotters`.`res_respondent_no` is not null) then 'Resident' when (`tbl_blotters`.`nres_respondent_no` is not null) then 'Non-Resident' else 'unknown' end) AS `respondent_status`,(case when (`tbl_blotters`.`res_respondent_no` is not null) then `tbl_blotters`.`res_respondent_no` when (`tbl_blotters`.`nres_respondent_no` is not null) then `tbl_blotters`.`nres_respondent_no` else 'unknown' end) AS `respondent_no`,(case when (`tbl_blotters`.`res_complainant_no` is not null) then `resident_complainant`.`img_filename` when (`tbl_blotters`.`nres_complainant_no` is not null) then convert(`non_resident_complainant`.`img_filename` using utf8mb4) else 'unknown' end) AS `complainant_filename`,(case when (`tbl_blotters`.`res_respondent_no` is not null) then `resident_respondent`.`img_filename` when (`tbl_blotters`.`nres_respondent_no` is not null) then convert(`non_resident_respondent`.`img_filename` using utf8mb4) else 'unknown' end) AS `respondent_filename`,(case when (`tbl_blotters`.`res_complainant_no` is not null) then concat(`resident_complainant`.`house_num`,', ',`resident_complainant`.`street`,', ',`resident_complainant`.`subdivision`,', Camarin Caloocan City') when (`tbl_blotters`.`nres_complainant_no` is not null) then convert(concat(`non_resident_complainant`.`house_num`,', ',`non_resident_complainant`.`street`,', ',`non_resident_complainant`.`subdivision`,', ',`non_resident_complainant`.`city`,', ',`non_resident_complainant`.`province`,', ',`non_resident_complainant`.`zipcode`) using utf8mb4) else 'unknown' end) AS `complainant_address`,(case when (`tbl_blotters`.`res_respondent_no` is not null) then concat(`resident_respondent`.`house_num`,', ',`resident_respondent`.`street`,', ',`resident_respondent`.`subdivision`,', Camarin Caloocan City') when (`tbl_blotters`.`nres_respondent_no` is not null) then convert(concat(`non_resident_respondent`.`house_num`,', ',`non_resident_respondent`.`street`,', ',`non_resident_respondent`.`subdivision`,', ',`non_resident_respondent`.`city`,', ',`non_resident_respondent`.`province`,', ',`non_resident_respondent`.`zipcode`) using utf8mb4) else 'unknown' end) AS `respondent_address`,`tbl_blotters`.`blotter_type` AS `blotter_type`,`tbl_blotters`.`desc_incident` AS `desc_incident`,`tbl_blotters`.`incident_dt` AS `incident_dt`,`tbl_blotters`.`report_status` AS `report_status`,`tbl_blotters`.`is_deleted` AS `is_deleted`,(case when (`tbl_blotters`.`res_complainant_no` is not null) then `resident_complainant`.`last_name` when (`tbl_blotters`.`nres_complainant_no` is not null) then convert(`non_resident_complainant`.`last_name` using utf8mb4) else 'unknown' end) AS `complainant_last_name`,(case when (`tbl_blotters`.`res_complainant_no` is not null) then `resident_complainant`.`first_name` when (`tbl_blotters`.`nres_complainant_no` is not null) then convert(`non_resident_complainant`.`first_name` using utf8mb4) else 'unknown' end) AS `complainant_first_name`,(case when (`tbl_blotters`.`res_complainant_no` is not null) then `resident_complainant`.`middle_name` when (`tbl_blotters`.`nres_complainant_no` is not null) then convert(`non_resident_complainant`.`middle_name` using utf8mb4) else 'unknown' end) AS `complainant_middle_name`,(case when (`tbl_blotters`.`res_complainant_no` is not null) then `resident_complainant`.`suffix` when (`tbl_blotters`.`nres_complainant_no` is not null) then convert(`non_resident_complainant`.`suffix` using utf8mb4) else 'unknown' end) AS `complainant_suffix`,(case when (`tbl_blotters`.`res_respondent_no` is not null) then `resident_respondent`.`last_name` when (`tbl_blotters`.`nres_respondent_no` is not null) then convert(`non_resident_respondent`.`last_name` using utf8mb4) else 'unknown' end) AS `respondent_last_name`,(case when (`tbl_blotters`.`res_respondent_no` is not null) then `resident_respondent`.`first_name` when (`tbl_blotters`.`nres_respondent_no` is not null) then convert(`non_resident_respondent`.`first_name` using utf8mb4) else 'unknown' end) AS `respondent_first_name`,(case when (`tbl_blotters`.`res_respondent_no` is not null) then `resident_respondent`.`middle_name` when (`tbl_blotters`.`nres_respondent_no` is not null) then convert(`non_resident_respondent`.`middle_name` using utf8mb4) else 'unknown' end) AS `respondent_middle_name`,(case when (`tbl_blotters`.`res_respondent_no` is not null) then `resident_respondent`.`suffix` when (`tbl_blotters`.`nres_respondent_no` is not null) then convert(`non_resident_respondent`.`suffix` using utf8mb4) else 'unknown' end) AS `respondent_suffix` from (((((`tbl_blotters` join `tbl_blotter_audit_trail` on((`tbl_blotters`.`blot_at_no` = `tbl_blotter_audit_trail`.`blotter_at_id`))) left join `resident` `resident_complainant` on((`tbl_blotters`.`res_complainant_no` = `resident_complainant`.`resident_id`))) left join `non_resident` `non_resident_complainant` on((`tbl_blotters`.`nres_complainant_no` = `non_resident_complainant`.`nresident_id`))) left join `resident` `resident_respondent` on((`tbl_blotters`.`res_respondent_no` = `resident_respondent`.`resident_id`))) left join `non_resident` `non_resident_respondent` on((`tbl_blotters`.`nres_respondent_no` = `non_resident_respondent`.`nresident_id`)))) */;

/*View structure for view vw_blotters_deleted */

/*!50001 DROP TABLE IF EXISTS `vw_blotters_deleted` */;
/*!50001 DROP VIEW IF EXISTS `vw_blotters_deleted` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_blotters_deleted` AS select `tbl_blotters`.`blotter_id` AS `blotter_id`,`tbl_blotter_audit_trail`.`blotter_add_dt` AS `blotter_add_dt`,(case when (`tbl_blotters`.`res_complainant_no` is not null) then 'Resident' when (`tbl_blotters`.`nres_complainant_no` is not null) then 'Non-Resident' else 'unknown' end) AS `complainant_status`,(case when (`tbl_blotters`.`res_complainant_no` is not null) then `tbl_blotters`.`res_complainant_no` when (`tbl_blotters`.`nres_complainant_no` is not null) then `tbl_blotters`.`nres_complainant_no` else 'unknown' end) AS `complainant_no`,(case when (`tbl_blotters`.`res_respondent_no` is not null) then 'Resident' when (`tbl_blotters`.`nres_respondent_no` is not null) then 'Non-Resident' else 'unknown' end) AS `respondent_status`,(case when (`tbl_blotters`.`res_respondent_no` is not null) then `tbl_blotters`.`res_respondent_no` when (`tbl_blotters`.`nres_respondent_no` is not null) then `tbl_blotters`.`nres_respondent_no` else 'unknown' end) AS `respondent_no`,(case when (`tbl_blotters`.`res_complainant_no` is not null) then `resident_complainant`.`img_filename` when (`tbl_blotters`.`nres_complainant_no` is not null) then convert(`non_resident_complainant`.`img_filename` using utf8mb4) else 'unknown' end) AS `complainant_filename`,(case when (`tbl_blotters`.`res_respondent_no` is not null) then `resident_respondent`.`img_filename` when (`tbl_blotters`.`nres_respondent_no` is not null) then convert(`non_resident_respondent`.`img_filename` using utf8mb4) else 'unknown' end) AS `respondent_filename`,(case when (`tbl_blotters`.`res_complainant_no` is not null) then concat(`resident_complainant`.`house_num`,', ',`resident_complainant`.`street`,', ',`resident_complainant`.`subdivision`,', Camarin Caloocan City') when (`tbl_blotters`.`nres_complainant_no` is not null) then convert(concat(`non_resident_complainant`.`house_num`,', ',`non_resident_complainant`.`street`,', ',`non_resident_complainant`.`subdivision`,', ',`non_resident_complainant`.`city`,', ',`non_resident_complainant`.`province`,', ',`non_resident_complainant`.`zipcode`) using utf8mb4) else 'unknown' end) AS `complainant_address`,(case when (`tbl_blotters`.`res_respondent_no` is not null) then concat(`resident_respondent`.`house_num`,', ',`resident_respondent`.`street`,', ',`resident_respondent`.`subdivision`,', Camarin Caloocan City') when (`tbl_blotters`.`nres_respondent_no` is not null) then convert(concat(`non_resident_respondent`.`house_num`,', ',`non_resident_respondent`.`street`,', ',`non_resident_respondent`.`subdivision`,', ',`non_resident_respondent`.`city`,', ',`non_resident_respondent`.`province`,', ',`non_resident_respondent`.`zipcode`) using utf8mb4) else 'unknown' end) AS `respondent_address`,`tbl_blotters`.`blotter_type` AS `blotter_type`,`tbl_blotters`.`desc_incident` AS `desc_incident`,`tbl_blotters`.`incident_dt` AS `incident_dt`,`tbl_blotters`.`report_status` AS `report_status`,`tbl_blotters`.`is_deleted` AS `is_deleted`,(case when (`tbl_blotters`.`res_complainant_no` is not null) then `resident_complainant`.`last_name` when (`tbl_blotters`.`nres_complainant_no` is not null) then convert(`non_resident_complainant`.`last_name` using utf8mb4) else 'unknown' end) AS `complainant_last_name`,(case when (`tbl_blotters`.`res_complainant_no` is not null) then `resident_complainant`.`first_name` when (`tbl_blotters`.`nres_complainant_no` is not null) then convert(`non_resident_complainant`.`first_name` using utf8mb4) else 'unknown' end) AS `complainant_first_name`,(case when (`tbl_blotters`.`res_complainant_no` is not null) then `resident_complainant`.`middle_name` when (`tbl_blotters`.`nres_complainant_no` is not null) then convert(`non_resident_complainant`.`middle_name` using utf8mb4) else 'unknown' end) AS `complainant_middle_name`,(case when (`tbl_blotters`.`res_complainant_no` is not null) then `resident_complainant`.`suffix` when (`tbl_blotters`.`nres_complainant_no` is not null) then convert(`non_resident_complainant`.`suffix` using utf8mb4) else 'unknown' end) AS `complainant_suffix`,(case when (`tbl_blotters`.`res_respondent_no` is not null) then `resident_respondent`.`last_name` when (`tbl_blotters`.`nres_respondent_no` is not null) then convert(`non_resident_respondent`.`last_name` using utf8mb4) else 'unknown' end) AS `respondent_last_name`,(case when (`tbl_blotters`.`res_respondent_no` is not null) then `resident_respondent`.`first_name` when (`tbl_blotters`.`nres_respondent_no` is not null) then convert(`non_resident_respondent`.`first_name` using utf8mb4) else 'unknown' end) AS `respondent_first_name`,(case when (`tbl_blotters`.`res_respondent_no` is not null) then `resident_respondent`.`middle_name` when (`tbl_blotters`.`nres_respondent_no` is not null) then convert(`non_resident_respondent`.`middle_name` using utf8mb4) else 'unknown' end) AS `respondent_middle_name`,(case when (`tbl_blotters`.`res_respondent_no` is not null) then `resident_respondent`.`suffix` when (`tbl_blotters`.`nres_respondent_no` is not null) then convert(`non_resident_respondent`.`suffix` using utf8mb4) else 'unknown' end) AS `respondent_suffix` from (((((`tbl_blotters` join `tbl_blotter_audit_trail` on((`tbl_blotters`.`blot_at_no` = `tbl_blotter_audit_trail`.`blotter_at_id`))) left join `resident` `resident_complainant` on((`tbl_blotters`.`res_complainant_no` = `resident_complainant`.`resident_id`))) left join `non_resident` `non_resident_complainant` on((`tbl_blotters`.`nres_complainant_no` = `non_resident_complainant`.`nresident_id`))) left join `resident` `resident_respondent` on((`tbl_blotters`.`res_respondent_no` = `resident_respondent`.`resident_id`))) left join `non_resident` `non_resident_respondent` on((`tbl_blotters`.`nres_respondent_no` = `non_resident_respondent`.`nresident_id`))) where (`tbl_blotters`.`is_deleted` = 1) */;

/*View structure for view vw_blotters_schedule */

/*!50001 DROP TABLE IF EXISTS `vw_blotters_schedule` */;
/*!50001 DROP VIEW IF EXISTS `vw_blotters_schedule` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_blotters_schedule` AS select `b`.`blotter_id` AS `blotter_id`,(case when (`r1`.`resident_id` is not null) then concat(`r1`.`first_name`,' ',`r1`.`last_name`,' ',`r1`.`middle_name`,' ',`r1`.`suffix`) else convert(concat(`nr1`.`first_name`,' ',`nr1`.`last_name`,' ',`nr1`.`middle_name`) using utf8mb4) end) AS `complainant_fullname`,(case when (`r1`.`resident_id` is not null) then 'Resident' else 'Non-Resident' end) AS `complainant_status`,(case when (`r2`.`resident_id` is not null) then concat(`r2`.`first_name`,' ',`r2`.`last_name`,' ',`r2`.`middle_name`,' ',`r2`.`suffix`) else convert(concat(`nr2`.`first_name`,' ',`nr2`.`last_name`,' ',`nr2`.`middle_name`) using utf8mb4) end) AS `respondent_fullname`,(case when (`r2`.`resident_id` is not null) then 'Resident' else 'Non-Resident' end) AS `respondent_status`,`b`.`desc_incident` AS `desc_incident`,`b`.`incident_dt` AS `incident_dt`,`b`.`location_of_incident` AS `location_of_incident`,`b`.`date_of_resolution` AS `date_of_resolution`,`b`.`mediation_date` AS `mediation_date`,`b`.`mediation_starttime` AS `mediation_starttime`,`b`.`mediation_endtime` AS `mediation_endtime`,`b`.`schedule_color` AS `schedule_color`,`b`.`report_status` AS `report_status` from ((((`tbl_blotters` `b` left join `resident` `r1` on((`b`.`res_complainant_no` = `r1`.`resident_id`))) left join `non_resident` `nr1` on((`b`.`nres_complainant_no` = `nr1`.`nresident_id`))) left join `resident` `r2` on((`b`.`res_respondent_no` = `r2`.`resident_id`))) left join `non_resident` `nr2` on((`b`.`nres_respondent_no` = `nr2`.`nresident_id`))) */;

/*View structure for view vw_deleted_docu */

/*!50001 DROP TABLE IF EXISTS `vw_deleted_docu` */;
/*!50001 DROP VIEW IF EXISTS `vw_deleted_docu` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_deleted_docu` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,(case when (`tbl_docu_request`.`resident_no` is not null) then '1' else '0' end) AS `is_resident`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`resident_id` else `non_resident`.`nresident_id` end) AS `resident/nonres_id`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`last_name` else convert(`non_resident`.`last_name` using utf8mb4) end) AS `last_name`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`first_name` else convert(`non_resident`.`first_name` using utf8mb4) end) AS `first_name`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`middle_name` else convert(`non_resident`.`middle_name` using utf8mb4) end) AS `middle_name`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`suffix` else convert(`non_resident`.`suffix` using utf8mb4) end) AS `suffix`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`house_num` else convert(`non_resident`.`house_num` using utf8mb4) end) AS `house_num`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`street` else convert(`non_resident`.`street` using utf8mb4) end) AS `street`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`subdivision` else convert(`non_resident`.`subdivision` using utf8mb4) end) AS `subdivision`,(case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`city` else 'Caloocan City' end) AS `city`,(case when (`tbl_documents`.`Barangay_Clearance` is not null) then 'Barangay Clearance' when (`tbl_documents`.`Certificate_of_Residency` is not null) then 'Certificate of Residency' when (`tbl_documents`.`Certificate_of_Indigency` is not null) then 'Certificate of Indigency' when (`tbl_documents`.`Certificate_of_Good_Moral` is not null) then 'Certificate of Good Moral' when (`tbl_documents`.`Business_Permits` is not null) then 'Business Permits' when (`tbl_documents`.`Building_Permits` is not null) then 'Building Permits' when (`tbl_documents`.`Excavation_Permits` is not null) then 'Excavation Permits' when (`tbl_documents`.`Fencing_Permits` is not null) then 'Fencing Permits' when (`tbl_documents`.`FTJS` is not null) then 'First Time Job Seekers' when (`tbl_documents`.`Oath_of_Undertaking` is not null) then 'Oath of Undertaking' when (`tbl_documents`.`TPRS` is not null) then 'Tricycle Pedicab Regulatory Services' else 'Unknown Document Type' end) AS `document_desc`,`tbl_docu_request`.`age` AS `age`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`sex` else convert(`non_resident`.`sex` using utf8mb4) end) AS `sex`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_docu_request`.`pdffile` AS `pdffile`,`tbl_docu_request`.`expiration_date` AS `expiration`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted`,`tbl_cert_audit_trail`.`datetime_edited` AS `date_edited`,`tbl_cert_audit_trail`.`datetime_deleted` AS `date_deleted` from ((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) where (`tbl_docu_request`.`is_deleted` = 1)) */;

/*View structure for view vw_documents_audit */

/*!50001 DROP TABLE IF EXISTS `vw_documents_audit` */;
/*!50001 DROP VIEW IF EXISTS `vw_documents_audit` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_documents_audit` AS select `ru`.`audit_id` AS `audit_id`,`ru`.`action_type` AS `action_type`,`ru`.`action_timestamp` AS `action_timestamp`,`tu`.`depart_no` AS `depart_no`,`un`.`username` AS `username`,`tu`.`img_filename` AS `img_filename`,concat(`tu`.`lname`,', ',coalesce(`tu`.`fname`,''),' ',coalesce(`tu`.`mname`,''),' ',coalesce(`tu`.`suffix`,'')) AS `fullname` from ((((`tbl_documents_audit` `ru` left join `tbl_users` `tu` on((`ru`.`user_no` = `tu`.`user_id`))) left join `tbl_username` `un` on((`ru`.`user_no` = `un`.`username_id`))) left join `resident` `r` on((`ru`.`resident_no` = `r`.`resident_id`))) left join `non_resident` `nr` on((`ru`.`nresident_no` = `nr`.`nresident_id`))) */;

/*View structure for view vw_nonresident */

/*!50001 DROP TABLE IF EXISTS `vw_nonresident` */;
/*!50001 DROP VIEW IF EXISTS `vw_nonresident` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_nonresident` AS (select `non_resident`.`nresident_id` AS `nresident_id`,`nonres_audit_trail`.`datetime_added` AS `datetime_added`,`non_resident`.`img_filename` AS `img_filename`,`non_resident`.`last_name` AS `last_name`,`non_resident`.`first_name` AS `first_name`,`non_resident`.`middle_name` AS `middle_name`,`non_resident`.`suffix` AS `suffix`,`non_resident`.`house_num` AS `house_num`,`non_resident`.`street` AS `street`,`non_resident`.`subdivision` AS `subdivision`,`non_resident`.`district_brgy` AS `district_brgy`,`non_resident`.`city` AS `city`,`non_resident`.`province` AS `province`,`non_resident`.`zipcode` AS `zipcode`,`non_resident`.`sex` AS `sex`,`non_resident`.`marital_status` AS `marital_status`,`non_resident`.`birth_date` AS `birth_date`,`non_resident`.`birth_place` AS `birth_place`,`non_resident`.`cellphone_num` AS `cellphone_num`,`non_resident`.`audit_trail_no` AS `audit_trail_no`,`non_resident`.`is_deleted` AS `is_deleted` from (`non_resident` join `nonres_audit_trail` on((`non_resident`.`audit_trail_no` = `nonres_audit_trail`.`audit_trail_id`))) where (`non_resident`.`is_deleted` = 0)) */;

/*View structure for view vw_nonresident_audit */

/*!50001 DROP TABLE IF EXISTS `vw_nonresident_audit` */;
/*!50001 DROP VIEW IF EXISTS `vw_nonresident_audit` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_nonresident_audit` AS select `ru`.`audit_id` AS `audit_id`,`ru`.`action_type` AS `action_type`,`ru`.`action_timestamp` AS `action_timestamp`,`tu`.`depart_no` AS `depart_no`,`un`.`username` AS `username`,`tu`.`img_filename` AS `img_filename`,concat(`tu`.`lname`,', ',`tu`.`fname`,' ',`tu`.`mname`,' ',`tu`.`suffix`) AS `fullname` from ((`nonresident_audit` `ru` join `tbl_users` `tu` on((`ru`.`user_no` = `tu`.`user_id`))) join `tbl_username` `un` on((`ru`.`user_no` = `un`.`username_id`))) */;

/*View structure for view vw_nonresident_deleted */

/*!50001 DROP TABLE IF EXISTS `vw_nonresident_deleted` */;
/*!50001 DROP VIEW IF EXISTS `vw_nonresident_deleted` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_nonresident_deleted` AS (select `non_resident`.`nresident_id` AS `nresident_id`,cast(`nonres_audit_trail`.`datetime_added` as date) AS `datetime_added`,`non_resident`.`img_filename` AS `img_filename`,`non_resident`.`last_name` AS `last_name`,`non_resident`.`first_name` AS `first_name`,`non_resident`.`middle_name` AS `middle_name`,`non_resident`.`suffix` AS `suffix`,`non_resident`.`house_num` AS `house_num`,`non_resident`.`street` AS `street`,`non_resident`.`subdivision` AS `subdivision`,`non_resident`.`district_brgy` AS `district_brgy`,`non_resident`.`city` AS `city`,`non_resident`.`province` AS `province`,`non_resident`.`zipcode` AS `zipcode`,`non_resident`.`sex` AS `sex`,`non_resident`.`marital_status` AS `marital_status`,`non_resident`.`birth_date` AS `birth_date`,`non_resident`.`birth_place` AS `birth_place`,`non_resident`.`cellphone_num` AS `cellphone_num`,`non_resident`.`is_deleted` AS `is_deleted` from (`non_resident` join `nonres_audit_trail` on((`non_resident`.`audit_trail_no` = `nonres_audit_trail`.`audit_trail_id`))) where (`non_resident`.`is_deleted` = 1)) */;

/*View structure for view vw_resident */

/*!50001 DROP TABLE IF EXISTS `vw_resident` */;
/*!50001 DROP VIEW IF EXISTS `vw_resident` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_resident` AS (select `resident`.`resident_id` AS `resident_id`,`res_audit_trail`.`added_dt` AS `date_recorded`,`resident`.`img_filename` AS `img_filename`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_num`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`resident`.`resident_since` AS `resident_since`,`resident`.`sex` AS `sex`,`resident`.`marital_status` AS `marital_status`,`resident`.`birth_date` AS `birth_date`,`resident`.`birth_place` AS `birth_place`,`resident`.`cellphone_num` AS `cellphone_num`,`resident`.`is_a_voter` AS `is_a_voter`,`resident`.`is_deleted` AS `is_deleted` from (`resident` join `res_audit_trail` on((`resident`.`audit_trail` = `res_audit_trail`.`res_at_id`))) where (`resident`.`is_deleted` = 0)) */;

/*View structure for view vw_resident_audit */

/*!50001 DROP TABLE IF EXISTS `vw_resident_audit` */;
/*!50001 DROP VIEW IF EXISTS `vw_resident_audit` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_resident_audit` AS (select `ru`.`audit_id` AS `audit_id`,`ru`.`action_type` AS `action_type`,`ru`.`action_timestamp` AS `action_timestamp`,`tu`.`depart_no` AS `depart_no`,`un`.`username` AS `username`,`tu`.`img_filename` AS `img_filename`,concat(`tu`.`lname`,', ',`tu`.`fname`,' ',`tu`.`mname`,' ',`tu`.`suffix`) AS `fullname` from ((`resident_audit` `ru` join `tbl_users` `tu` on((`ru`.`user_no` = `tu`.`user_id`))) join `tbl_username` `un` on((`ru`.`user_no` = `un`.`username_id`)))) */;

/*View structure for view vw_resident_deleted */

/*!50001 DROP TABLE IF EXISTS `vw_resident_deleted` */;
/*!50001 DROP VIEW IF EXISTS `vw_resident_deleted` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_resident_deleted` AS (select `resident`.`resident_id` AS `resident_id`,`res_audit_trail`.`added_dt` AS `date_recorded`,`resident`.`img_filename` AS `img_filename`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_num`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`resident`.`resident_since` AS `resident_since`,`resident`.`sex` AS `sex`,`resident`.`marital_status` AS `marital_status`,`resident`.`birth_date` AS `birth_date`,`resident`.`birth_place` AS `birth_place`,`resident`.`cellphone_num` AS `cellphone_num`,`resident`.`is_a_voter` AS `is_a_voter`,`resident`.`is_deleted` AS `is_deleted` from (`resident` join `res_audit_trail` on((`resident`.`audit_trail` = `res_audit_trail`.`res_at_id`))) where (`resident`.`is_deleted` = 1)) */;

/*View structure for view vw_resonly_cert */

/*!50001 DROP TABLE IF EXISTS `vw_resonly_cert` */;
/*!50001 DROP VIEW IF EXISTS `vw_resonly_cert` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_resonly_cert` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`resident`.`resident_id` AS `resident_id`,(case when (`tbl_documents`.`Barangay_Clearance` is not null) then 'Barangay Clearance' when (`tbl_documents`.`Certificate_of_Residency` is not null) then 'Certificate of Residency' when (`tbl_documents`.`Certificate_of_Indigency` is not null) then 'Certificate of Indigency' when (`tbl_documents`.`Certificate_of_Good_Moral` is not null) then 'Certificate of Good Moral' when (`tbl_documents`.`Business_Permits` is not null) then 'Business Permits' when (`tbl_documents`.`Building_Permits` is not null) then 'Building Permits' when (`tbl_documents`.`Excavation_Permits` is not null) then 'Excavation Permits' when (`tbl_documents`.`Fencing_Permits` is not null) then 'Fencing Permits' when (`tbl_documents`.`FTJS` is not null) then 'First Time Job Seekers' when (`tbl_documents`.`Oath_of_Undertaking` is not null) then 'Oath of Undertaking' when (`tbl_documents`.`TPRS` is not null) then 'Tricycle Pedicab Regulatory Services' else 'Unknown Document Type' end) AS `document_desc`,`tbl_docu_request`.`age` AS `age`,`resident`.`sex` AS `sex`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_docu_request`.`pdffile` AS `pdffile`,`tbl_docu_request`.`expiration_date` AS `expiration`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted`,`tbl_cert_audit_trail`.`datetime_edited` AS `date_edited`,`tbl_cert_audit_trail`.`datetime_deleted` AS `date_deleted` from ((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`)))) */;

/*View structure for view vw_select_nonresident */

/*!50001 DROP TABLE IF EXISTS `vw_select_nonresident` */;
/*!50001 DROP VIEW IF EXISTS `vw_select_nonresident` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_select_nonresident` AS (select `non_resident`.`nresident_id` AS `nresident_id`,`non_resident`.`img_filename` AS `img_filename`,concat(`non_resident`.`last_name`,', ',`non_resident`.`first_name`,' ',`non_resident`.`middle_name`,' ',`non_resident`.`suffix`) AS `full_name`,concat(`non_resident`.`house_num`,' ',`non_resident`.`street`,' ',`non_resident`.`subdivision`,' ',`non_resident`.`district_brgy`,' ',`non_resident`.`city`,' ',`non_resident`.`province`,' ',`non_resident`.`zipcode`) AS `address`,`non_resident`.`sex` AS `sex`,`non_resident`.`marital_status` AS `marital_status`,`non_resident`.`birth_date` AS `birth_date`,`non_resident`.`cellphone_num` AS `cellphone_num` from `non_resident` where (`non_resident`.`is_deleted` = 0)) */;

/*View structure for view vw_select_resident */

/*!50001 DROP TABLE IF EXISTS `vw_select_resident` */;
/*!50001 DROP VIEW IF EXISTS `vw_select_resident` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_select_resident` AS (select `resident`.`resident_id` AS `resident_id`,`resident`.`img_filename` AS `img_filename`,concat(`resident`.`last_name`,', ',`resident`.`first_name`,' ',`resident`.`middle_name`,' ',`resident`.`suffix`) AS `full_name`,concat(`resident`.`house_num`,' ',`resident`.`street`,' ',`resident`.`subdivision`,' Camarin Caloocan City') AS `address`,`resident`.`sex` AS `sex`,`resident`.`marital_status` AS `marital_status`,`resident`.`birth_date` AS `birth_date`,`resident`.`cellphone_num` AS `cellphone_num`,`resident`.`is_a_voter` AS `is_a_voter` from `resident` where (`resident`.`is_deleted` = 0)) */;

/*View structure for view vw_users */

/*!50001 DROP TABLE IF EXISTS `vw_users` */;
/*!50001 DROP VIEW IF EXISTS `vw_users` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_users` AS (select `tu`.`user_id` AS `user_id`,`tu`.`img_filename` AS `img_filename`,`tu`.`fname` AS `fname`,`tu`.`mname` AS `mname`,`tu`.`lname` AS `lname`,`tu`.`suffix` AS `suffix`,`tu`.`depart_no` AS `depart_no`,`tu`.`isactive` AS `isactive`,`un`.`username` AS `username`,`aut`.`created_dt` AS `created_dt`,`aut`.`last_login` AS `last_login`,`tu`.`isdeleted` AS `is_deleted`,`un_created`.`username` AS `created_by` from (((`tbl_users` `tu` join `tbl_username` `un` on((`tu`.`username_no` = `un`.`username_id`))) join `tbl_users_audit_trail` `aut` on((`aut`.`user_at_id` = `tu`.`user_at_no`))) join `tbl_username` `un_created` on((`aut`.`created_by` = `un_created`.`username_id`)))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
