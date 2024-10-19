/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 5.7.20-log : Database - bims
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bims` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `non_resident` */

insert  into `non_resident`(`nresident_id`,`img_filename`,`last_name`,`first_name`,`middle_name`,`suffix`,`house_num`,`street`,`subdivision`,`district_brgy`,`city`,`province`,`zipcode`,`sex`,`marital_status`,`birth_place`,`birth_date`,`cellphone_num`,`audit_trail_no`,`is_deleted`) values 
(1,'1images.jpg','Rabanes','Fernan','Jarito','','Blk 9 Lot 3','Kamatis st','Ramirez Subd','Novaliches','Quezon City','Metro Manila','1423','Male','Single','Tuguegarao','1998-06-16','090956565454',1,0),
(2,'1images (1).jpg','Lim','Nicholas','Mahestro','','12','Zapote Rd','Cielito Homes','Camarin Brgy 175','Caloocan City','Metro Manila','1423','Male','Single','San Nicolas Pangasinan','1998-09-29','0966565666544',2,0),
(3,'2f070627687d52995cfabf5c1bbde057.jpg','Lim','Mario','Jaen','III','Blk 12 Lot 4','Hillcrest st','Rolling Stone Subd','Novaliches','Quezon City','Metro Manila','1420','Male','Married','Madella Quirino','1990-05-02','090913457854',3,0),
(4,'capture_1729251630.jpg','Chavez','Celestina','Mariano','','Blk 12 Lot 13','Josephine st','La Forteza Subd','Camarin','Caloocan City','Metro Manila','1432','Female','Married','Lipa Batangas','2024-10-16','09064545125',4,0),
(5,'ren.jpg','La Torre','Nicholas','Trinidad','III','Blk 12 Lot 13','Davao st','Kingdom subd','Novaliches','Quezon City','Metro Manila','1411','Male','Married','Davao City','2000-01-01','090541236585',5,0),
(6,'alingpuring.jpg','Lumauig','Marivic','Galindez','','Blk 8 Lot 4','Jeremiah st','Cielito Homes','Novaliches','Quezon City','Metro Manila','60007','Female','Single','Bagabag Nueva Viscaya','1990-06-12','09054321268',6,0);

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `nonres_audit_trail` */

insert  into `nonres_audit_trail`(`audit_trail_id`,`dept_added_no`,`user_added_no`,`datetime_added`,`dept_edited_no`,`user_edited_no`,`last_edited_dt`,`dept_deleted_no`,`user_deleted_no`,`last_deleted_dt`,`dept_recovered_no`,`user_recovered_no`,`last_recovered_dt`) values 
(1,NULL,NULL,'2024-09-04 10:12:00',NULL,NULL,'2024-09-24 18:04:40',NULL,NULL,'2024-09-25 03:03:50',NULL,NULL,NULL),
(2,NULL,NULL,'2024-09-24 18:32:14',NULL,NULL,'2024-10-19 11:53:27',NULL,NULL,'2024-10-18 21:11:33',NULL,NULL,'2024-10-18 21:27:34'),
(3,NULL,NULL,'2024-10-03 00:48:06',NULL,NULL,'2024-10-03 01:46:56',NULL,NULL,'2024-10-12 12:30:24',NULL,NULL,NULL),
(4,NULL,NULL,'2024-10-03 00:48:33',NULL,NULL,NULL,NULL,NULL,'2024-10-19 11:58:07',NULL,NULL,'2024-10-19 11:58:12'),
(5,NULL,NULL,'2024-10-03 00:59:05',NULL,NULL,'2024-10-19 13:56:18',NULL,NULL,'2024-10-19 00:10:29',NULL,NULL,NULL),
(6,NULL,NULL,'2024-10-03 00:59:35',NULL,NULL,'2024-10-19 11:36:13',NULL,NULL,NULL,NULL,NULL,NULL),
(7,NULL,NULL,'2024-10-03 01:02:24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(8,NULL,NULL,'2024-10-03 01:04:17',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(9,NULL,NULL,'2024-10-03 01:04:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(10,NULL,NULL,'2024-10-03 01:07:54',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(11,NULL,NULL,'2024-10-03 01:09:31',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(12,NULL,NULL,'2024-10-03 01:18:04',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(13,NULL,NULL,'2024-10-03 01:18:46',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(14,NULL,NULL,'2024-10-18 19:40:30',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(15,NULL,NULL,'2024-10-18 21:18:02',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(16,NULL,NULL,'2024-10-19 00:17:26',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `res_audit_trail` */

DROP TABLE IF EXISTS `res_audit_trail`;

CREATE TABLE `res_audit_trail` (
  `res_at_id` int(55) NOT NULL AUTO_INCREMENT,
  `added_depart_no` int(55) DEFAULT NULL,
  `added_by_no` int(55) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `time_added` time DEFAULT NULL,
  `edited_depart_no` int(55) DEFAULT NULL,
  `last_edited_by` int(55) DEFAULT NULL,
  `last_edited_dt` date DEFAULT NULL,
  `last_edited_tm` time DEFAULT NULL,
  `dept_del_no` int(55) DEFAULT NULL,
  `del_by_no` int(55) DEFAULT NULL,
  `del_date` date DEFAULT NULL,
  `del_time` time DEFAULT NULL,
  `dept_rec_no` int(55) DEFAULT NULL,
  `rec_by_no` int(55) DEFAULT NULL,
  `rec_date` date DEFAULT NULL,
  `rec_time` time DEFAULT NULL,
  PRIMARY KEY (`res_at_id`),
  KEY `res_depart_fk` (`added_depart_no`),
  KEY `res_addedby_fk` (`added_by_no`),
  KEY `res_edited_by` (`last_edited_by`),
  CONSTRAINT `res_addedby_fk` FOREIGN KEY (`added_by_no`) REFERENCES `tbl_username` (`username_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `res_depart_fk` FOREIGN KEY (`added_depart_no`) REFERENCES `departments_list` (`department_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `res_edited_by` FOREIGN KEY (`last_edited_by`) REFERENCES `tbl_username` (`username_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

/*Data for the table `res_audit_trail` */

insert  into `res_audit_trail`(`res_at_id`,`added_depart_no`,`added_by_no`,`date_added`,`time_added`,`edited_depart_no`,`last_edited_by`,`last_edited_dt`,`last_edited_tm`,`dept_del_no`,`del_by_no`,`del_date`,`del_time`,`dept_rec_no`,`rec_by_no`,`rec_date`,`rec_time`) values 
(1,NULL,NULL,'2024-09-03','15:42:52',NULL,NULL,'2024-09-19','11:27:24',NULL,NULL,'2024-09-13','15:30:23',NULL,NULL,'2024-09-13','15:31:47'),
(2,NULL,NULL,'2024-09-03','15:44:00',NULL,NULL,'2024-09-04','09:54:55',NULL,NULL,'2024-09-26','19:57:50',NULL,NULL,'2024-09-26','19:54:44'),
(3,NULL,NULL,'2024-09-03','15:45:08',NULL,NULL,'2024-09-19','11:27:33',NULL,NULL,'2024-09-26','19:57:40',NULL,NULL,'2024-09-26','19:56:36'),
(4,NULL,NULL,'2024-09-03','15:56:12',NULL,NULL,'2024-09-19','11:27:47',NULL,NULL,'2024-09-26','19:56:05',NULL,NULL,'2024-09-07','18:09:18'),
(5,NULL,NULL,'2024-09-03','15:56:57',NULL,NULL,'2024-09-12','14:04:20',NULL,NULL,'2024-09-26','19:57:35',NULL,NULL,'2024-09-26','19:56:42'),
(6,NULL,NULL,'2024-09-03','15:58:04',NULL,NULL,'2024-09-19','11:28:03',NULL,NULL,'2024-09-26','19:55:53',NULL,NULL,'2024-09-26','19:54:20'),
(7,NULL,NULL,'2024-09-10','17:46:56',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(8,NULL,NULL,'2024-09-03','16:00:19',NULL,NULL,'2024-09-12','14:03:45',NULL,NULL,'2024-10-17','14:59:38',NULL,NULL,'2024-10-17','14:59:59'),
(9,NULL,NULL,'2024-09-03','16:02:53',NULL,NULL,'2024-09-12','14:04:08',NULL,NULL,'2024-09-26','20:00:18',NULL,NULL,'2024-09-26','19:59:03'),
(10,NULL,NULL,'2024-09-03','16:07:36',NULL,NULL,'2024-09-03','18:39:34',NULL,NULL,'2024-09-26','20:01:46',NULL,NULL,'2024-09-26','20:00:55'),
(11,NULL,NULL,'2024-09-10','17:46:23',NULL,NULL,'2024-09-16','22:51:12',NULL,NULL,'2024-10-17','22:57:05',NULL,NULL,NULL,NULL),
(12,NULL,NULL,'2024-09-03','16:14:48',NULL,NULL,'2024-10-02','03:13:39',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(13,NULL,NULL,'2024-09-03','16:15:39',NULL,NULL,'2024-09-08','03:34:04',NULL,NULL,'2024-09-13','15:39:32',NULL,NULL,'2024-09-08','11:53:41'),
(14,NULL,NULL,'2024-09-03','18:30:55',NULL,NULL,'2024-09-16','11:30:29',NULL,NULL,'2024-09-04','14:58:55',NULL,NULL,'2024-09-05','23:24:21'),
(15,NULL,NULL,'2024-09-03','18:39:05',NULL,NULL,'2024-10-19','12:27:39',NULL,NULL,'2024-09-10','15:41:27',NULL,NULL,'2024-09-26','19:53:34'),
(16,NULL,NULL,'2024-09-07','23:54:29',NULL,NULL,'2024-09-10','14:58:50',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(17,NULL,NULL,'2024-09-07','23:54:41',NULL,NULL,'2024-09-12','14:05:20',NULL,NULL,'2024-10-17','23:02:27',NULL,NULL,'2024-09-26','19:53:38'),
(18,NULL,NULL,'2024-09-07','23:57:51',NULL,NULL,'2024-09-12','14:05:08',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(19,NULL,NULL,'2024-09-11','19:37:19',NULL,NULL,'2024-09-12','14:04:43',NULL,NULL,'2024-10-17','22:57:14',NULL,NULL,NULL,NULL),
(20,NULL,NULL,'2024-09-25','18:41:01',NULL,NULL,'2024-10-19','15:30:32',NULL,NULL,'2024-09-25','18:41:53',NULL,NULL,'2024-09-26','19:56:29');

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

/*Data for the table `resident` */

insert  into `resident`(`resident_id`,`img_filename`,`last_name`,`first_name`,`middle_name`,`suffix`,`house_num`,`street`,`subdivision`,`resident_since`,`sex`,`marital_status`,`birth_date`,`birth_place`,`cellphone_num`,`is_a_voter`,`audit_trail`,`is_deleted`) values 
(1,'capture_24-09-131726191126.jpg','Tecson','Reno','Hofileña','','Blk 12 Lot 4','Isaiah st','Cielito Homes','2015','Male','Single','1992-01-18','Malolos Bulacan','09568989899',0,1,0),
(2,'8406e341a7981729777f9dee8b55be99 (1).jpg','Tecson','Randy','Hofileña','','Blk 12 Lot 4','Isaiah st','Cielito Homes','2003','Male','Single','1992-01-08','Bulacan Bulacan','09656565655',0,2,1),
(3,'Miranda_Hallow.png','Tecson','Miranda','Hofileña','','Blk 12 Lot 4','Isaiah st','Cielito Homes','2006','Female','Married','1994-01-15','Plaridel Bulacan','09656565655',1,3,1),
(4,'Lavi_2006.png','Tecson','James','Hofileña','','Blk 12 Lot 4','Isaiah st','Cielito Homes','2007','Male','Single','1993-02-18','Pulilan Bulacan','09669898989',0,4,1),
(5,'alingpuring.jpg','Tecson','Puring','Ulatan','','Blk 12 Lot 3','Isaiah st','Cielito Homes','2007','Female','Single','1993-02-18','Bustos Bulacan','09669898989',0,5,1),
(6,'Shirou.png','Tecson','Gardo','Hofileña','','Blk 12 Lot 2','Isaiah st','Cielito Homes','2009','Male','Married','1988-02-27','San Miguel Bulacan','09064154588',1,6,1),
(8,'images (1).jpg','Yalong','Aaaron','Armengol','','Blk 12 Lot 5','Isaiah st','Cielito Homes','2015','Male','Single','1986-03-21','Gapan Nueva Ecjia','09565656565',1,8,0),
(9,'miano.jpg','Tecson','Franklin','Miano','','Blk 12 Lot 5','Isaiah st','Cielito Homes','2015','Male','Married','1986-03-21','Cabiao Nueva Ecjia','09565656564',1,9,1),
(10,'Karen-Bennett-200x200px.jpg','Tecson','Kiana','Macabara','','Blk 8 lot 5B','Jeremiah st','Cielito Homes','2015','Female','Married','1988-09-13','Valenzuela City','09565656565',0,10,1),
(11,'capture_24-09-161726498272.jpg','Salas','Norberto','Torres','','12','Zabarte rd','','2002','Male','Single','2002-08-23','Caloocan City','09565656566',0,11,1),
(12,'Shiroe_portal.png','Salas','Robert','Lumauig','','Blk 8 lot 4','Jeremiah st','Cielito Homes','2002','Male','Single','2002-10-16','Caloocan City','09064121066',0,12,0),
(13,'Akatsuki_portal.png','Salas','Akatsuki','Lumauig','','Blk 8 lot 4','Jeremiah st','Cielito Homes','2004','Female','Single','2004-12-16','Caloocan City','09054321268',1,13,1),
(14,'6c2e2762dc133ba55627875e9fa27f33.jpg','Dayao','Hiro','Timbol','','Blk 8 lot 3','Jeremiah st','Cielito Homes','2013','Male','Married','1990-04-03','Palauig Quezon','09665656565',1,14,0),
(15,'Minori_portal (1).png','Atchico','Denise','Tamaro','','Blk 14 lot 13','Moises st','Cielito Homes','2019','Female','Single','1999-04-24','Palauig Quezon','09665656565',0,15,0),
(16,'soul (1).jpg','Labancas','Danilo','Lim','','Blk 12 Lot 4','Kang kong st','Kassel Villas','2006','Male','Single','2002-10-16','Bulacan Bulacan','09056565656',1,16,0),
(17,'capture_24-09-121726121120.jpg','Japerson','Henry','','','123','Zabarte Rd','','2012','Male','Single','2002-10-16','Caloocan City','0906412066',0,17,1),
(18,'Naotsugu_portal.png','Operacio','Tim','Lucarnas','','12','Virgo st Corner Aries st','Maria Luisa Subd','2002','Male','Single','2002-10-16','Malabon City','09545454544',1,18,0),
(19,'Allenwalkerimage.png','Salas','Roberto','Lumauig','','Blk 12 Lot 4','Isaiah st','Cielito Homes','2002','Male','Single','2001-10-16','Caloocan City','09064121066',1,19,1),
(20,'capture_1727260861.jpg','Salas','Robert','Lumauig','','Blk 8 Lot 4','Jeremiah st','','2002','Male','Single','2002-10-16','Caloocan City','09064121066',0,20,0);

/*Table structure for table `tbl_blotter_audit_trail` */

DROP TABLE IF EXISTS `tbl_blotter_audit_trail`;

CREATE TABLE `tbl_blotter_audit_trail` (
  `blotter_at_id` int(255) NOT NULL AUTO_INCREMENT,
  `assist_by_no` int(55) DEFAULT NULL,
  `blotter_date` date DEFAULT NULL,
  `blotter_time` time DEFAULT NULL,
  PRIMARY KEY (`blotter_at_id`),
  KEY `fk_assist_by` (`assist_by_no`),
  CONSTRAINT `fk_assist_by` FOREIGN KEY (`assist_by_no`) REFERENCES `tbl_username` (`username_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_blotter_audit_trail` */

/*Table structure for table `tbl_blotters` */

DROP TABLE IF EXISTS `tbl_blotters`;

CREATE TABLE `tbl_blotters` (
  `blotter_id` int(11) NOT NULL,
  `res_complainant_no` int(55) DEFAULT NULL,
  `nres_complainant_no` int(55) DEFAULT NULL,
  `res_repondent_no` int(55) DEFAULT NULL,
  `nres_respondent_no` int(55) DEFAULT NULL,
  `otherp_involved_no` int(55) DEFAULT NULL,
  `report_status` tinyint(5) NOT NULL,
  `date_of_incident` date NOT NULL,
  `time_of_incident` time NOT NULL,
  `location_of_incident` varchar(255) NOT NULL,
  `date_of_resolution` date NOT NULL,
  `statemnt` longtext NOT NULL,
  `blot_at_no` int(55) NOT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`blotter_id`),
  KEY `blotter_at_fk` (`blot_at_no`),
  KEY `nres_complainant_fk` (`nres_complainant_no`),
  KEY `nres_respondent_fk` (`nres_respondent_no`),
  KEY `res_respondent_fk` (`res_repondent_no`),
  KEY `res_complainant_fk` (`res_complainant_no`),
  KEY `person_involved_fk` (`otherp_involved_no`),
  CONSTRAINT `blotter_at_fk` FOREIGN KEY (`blot_at_no`) REFERENCES `tbl_blotter_audit_trail` (`blotter_at_id`),
  CONSTRAINT `nres_complainant_fk` FOREIGN KEY (`nres_complainant_no`) REFERENCES `non_resident` (`nresident_id`),
  CONSTRAINT `nres_respondent_fk` FOREIGN KEY (`nres_respondent_no`) REFERENCES `non_resident` (`nresident_id`),
  CONSTRAINT `person_involved_fk` FOREIGN KEY (`otherp_involved_no`) REFERENCES `tbl_persons_involved` (`person_involved_id`),
  CONSTRAINT `res_complainant_fk` FOREIGN KEY (`res_complainant_no`) REFERENCES `resident` (`resident_id`),
  CONSTRAINT `res_respondent_fk` FOREIGN KEY (`res_repondent_no`) REFERENCES `resident` (`resident_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_blotters` */

/*Table structure for table `tbl_building_permits` */

DROP TABLE IF EXISTS `tbl_building_permits`;

CREATE TABLE `tbl_building_permits` (
  `building_permit_id` int(55) NOT NULL AUTO_INCREMENT,
  `blg_house_no` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `subd` varchar(255) DEFAULT NULL,
  `permit_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`building_permit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

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
(18,'Blk 12 Lot 3','Yang st','Almar Subd','Extension');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

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
(11,'Q3-Q4','Umbalin Furniture','123','Genesis st Corner Zabarte','Cielito Homes','Funiture Store');

/*Table structure for table `tbl_cert_audit_trail` */

DROP TABLE IF EXISTS `tbl_cert_audit_trail`;

CREATE TABLE `tbl_cert_audit_trail` (
  `audit_trail_id` int(50) NOT NULL AUTO_INCREMENT,
  `issuing_dept_no` int(50) DEFAULT NULL,
  `issued_by_no` int(50) DEFAULT NULL,
  `datetime_issued` datetime NOT NULL,
  `expiration` date DEFAULT NULL,
  `edited_by_no` int(55) DEFAULT NULL,
  `datetime_edited` datetime DEFAULT NULL,
  `deleted_by_no` int(55) DEFAULT NULL,
  `datetime_deleted` date DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_cert_audit_trail` */

insert  into `tbl_cert_audit_trail`(`audit_trail_id`,`issuing_dept_no`,`issued_by_no`,`datetime_issued`,`expiration`,`edited_by_no`,`datetime_edited`,`deleted_by_no`,`datetime_deleted`,`recovered_by_no`,`datetime_recovered`,`recovered_time`) values 
(1,NULL,NULL,'2024-10-14 01:34:59','2025-01-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(2,NULL,NULL,'2024-10-14 01:54:23','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(3,NULL,NULL,'2024-10-14 02:01:50','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(4,NULL,NULL,'2024-10-14 02:04:49','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(5,NULL,NULL,'2024-10-14 02:09:36','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(6,NULL,NULL,'2024-10-14 02:19:44','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(7,NULL,NULL,'2024-10-14 02:22:03','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(8,NULL,NULL,'2024-10-14 02:24:15','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(9,NULL,NULL,'2024-10-14 02:24:48','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(10,NULL,NULL,'2024-10-14 02:26:20','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(11,NULL,NULL,'2024-10-14 02:26:55','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(12,NULL,NULL,'2024-10-14 02:27:56','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(13,NULL,NULL,'2024-10-14 02:28:08','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(14,NULL,NULL,'2024-10-14 02:28:32','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(15,NULL,NULL,'2024-10-14 02:30:29','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(16,NULL,NULL,'2024-10-14 02:31:26','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(17,NULL,NULL,'2024-10-14 02:33:07','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(18,NULL,NULL,'2024-10-14 02:35:23','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(19,NULL,NULL,'2024-10-14 02:40:36','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(20,NULL,NULL,'2024-10-14 02:42:15','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(21,NULL,NULL,'2024-10-14 12:38:44','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(22,NULL,NULL,'2024-10-14 12:40:33','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(23,NULL,NULL,'2024-10-14 12:41:04','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(24,NULL,NULL,'2024-10-14 19:07:38','2025-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(25,NULL,NULL,'2024-10-15 20:07:51','2025-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(26,NULL,NULL,'2024-10-16 14:52:19','2025-10-16',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(27,NULL,NULL,'2024-10-16 14:54:22','2025-10-16',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(28,NULL,NULL,'2024-10-16 14:54:36','2025-10-16',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(29,NULL,NULL,'2024-10-16 14:54:53','2025-10-16',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(30,NULL,NULL,'2024-10-16 14:57:20','2025-10-16',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(31,NULL,NULL,'2024-10-16 14:58:38','2025-10-16',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(32,NULL,NULL,'2024-10-16 15:11:33','2025-10-16',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(33,NULL,NULL,'2024-10-16 18:56:35','2025-10-16',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(34,NULL,NULL,'2024-10-19 13:22:31','2025-01-19',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(35,NULL,NULL,'2024-10-19 19:23:50','2025-01-19',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(36,NULL,NULL,'2024-10-19 19:27:51','2025-01-19',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(37,NULL,NULL,'2024-10-19 19:28:02','2025-01-19',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(38,NULL,NULL,'2024-10-19 19:29:25','2025-01-19',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(39,NULL,NULL,'2024-10-19 13:34:11','2025-10-19',NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `tbl_docu_request` */

DROP TABLE IF EXISTS `tbl_docu_request`;

CREATE TABLE `tbl_docu_request` (
  `request_id` varchar(255) NOT NULL,
  `resident_no` int(55) DEFAULT NULL,
  `nresident_no` int(55) DEFAULT NULL,
  `document_no` int(55) DEFAULT NULL,
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

insert  into `tbl_docu_request`(`request_id`,`resident_no`,`nresident_no`,`document_no`,`age`,`presented_id`,`ID_number`,`purpose`,`audit_trail_no`,`pdffile`,`status`,`is_deleted`) values 
('2024-000001',1,NULL,1,32,'National ID','PCN-123455678890','Maynilad Application',1,'generated_pdf_1728840899.pdf',0,0),
('2024-000002',NULL,1,2,26,'Drivers License','N42-2121212121212','Getting Business Permit',2,'generated_pdf_1728842063.pdf',0,1),
('2024-000003',12,NULL,3,21,'Drivers License','N42-2010345','Getting Business Permit',3,'generated_pdf_1728842510.pdf',0,1),
('2024-000004',1,NULL,4,32,'Drivers License','N42-2010345','Getting Business Permit',4,'generated_pdf_1728842689.pdf',0,0),
('2024-000005',8,NULL,5,38,'Drivers License','N42-2010345','Getting Business Permit',5,'generated_pdf_1728842976.pdf',0,1),
('2024-000006',NULL,2,6,26,'SSS ID','SSS-1234455677','Securing Building Permit',6,'generated_pdf_1728843584.pdf',0,1),
('2024-000007',NULL,2,7,26,'SSS ID','SSS-1234455677','Securing Building Permit',7,'generated_pdf_1728843723.pdf',0,1),
('2024-000008',NULL,2,8,26,'SSS ID','SSS-1234455677','Securing Building Permit',8,'generated_pdf_1728843855.pdf',0,1),
('2024-000009',NULL,2,9,26,'SSS ID','SSS-1234455677','Securing Building Permit',9,'generated_pdf_1728843888.pdf',0,1),
('2024-000010',NULL,2,10,26,'SSS ID','SSS-1234455677','Securing Building Permit',10,'generated_pdf_1728843980.pdf',0,1),
('2024-000011',NULL,2,11,26,'SSS ID','SSS-1234455677','Securing Building Permit',11,'generated_pdf_1728844015.pdf',0,1),
('2024-000012',NULL,2,12,26,'SSS ID','SSS-1234455677','Securing Building Permit',12,'generated_pdf_1728844076.pdf',0,1),
('2024-000013',NULL,2,13,26,'SSS ID','SSS-1234455677','Securing Building Permit',13,'generated_pdf_1728844088.pdf',0,0),
('2024-000014',NULL,2,14,26,'SSS ID','SSS-1234455677','Securing Building Permit',14,'generated_pdf_1728844112.pdf',0,0),
('2024-000015',NULL,2,15,26,'SSS ID','SSS-1234455677','Securing Building Permit',15,'generated_pdf_1728844229.pdf',0,1),
('2024-000016',NULL,2,16,26,'SSS ID','SSS-1234455677','Securing Building Permit',16,'generated_pdf_1728844286.pdf',0,1),
('2024-000017',NULL,2,17,26,'SSS ID','SSS-1234455677','Securing Building Permit',17,'generated_pdf_1728844387.pdf',0,1),
('2024-000018',NULL,3,18,34,'SSS ID','SSS-1234455677','Securing Building Permit',18,'generated_pdf_1728844523.pdf',0,1),
('2024-000019',NULL,3,19,34,'Passport','PASS-1234567898998','Securing Excavation Permit',19,'generated_pdf_1728844836.pdf',0,0),
('2024-000020',NULL,3,20,34,'School ID','19-4545454545','Securing Fencing Permit',20,'generated_pdf_1728844935.pdf',0,0),
('2024-000021',8,NULL,21,38,'GSIS ID','GSIS-123345567789','Securing Building Permit',21,'generated_pdf_1728880724.pdf',2,0),
('2024-000022',8,NULL,22,38,'GSIS ID','GSIS-123345567789','Securing Building Permit',22,'generated_pdf_1728880833.pdf',0,0),
('2024-000023',8,NULL,23,38,'GSIS ID','GSIS-123345567789','Securing Building Permit',23,'generated_pdf_1728880864.pdf',0,1),
('2024-000024',12,NULL,24,21,'Drivers License','N42-1212121212121','Securing Building Permit',24,'generated_pdf_1728904058.pdf',0,1),
('2024-000025',NULL,1,25,26,'NBI Clearance','NBI-12122434345454','Getting Business Permit',25,'generated_pdf_1728994071.pdf',0,1),
('2024-000026',NULL,2,26,26,'LTOPF ID','LTOF-1234567890','Getting Business Permit',26,'generated_pdf_1729061539.pdf',0,1),
('2024-000027',NULL,2,27,26,'LTOPF ID','LTOF-1234567890','Getting Business Permit',27,'generated_pdf_1729061662.pdf',0,0),
('2024-000028',NULL,2,28,26,'LTOPF ID','LTOF-1234567890','Getting Business Permit',28,'generated_pdf_1729061676.pdf',0,0),
('2024-000029',NULL,2,29,26,'LTOPF ID','LTOF-1234567890','Getting Business Permit',29,'generated_pdf_1729061693.pdf',0,0),
('2024-000030',NULL,2,30,26,'LTOPF ID','LTOF-1234567890','Getting Business Permit',30,'generated_pdf_1729061840.pdf',0,0),
('2024-000031',NULL,1,31,26,'Drivers License','N42-12121324343434','Securing Building Permit',31,'generated_pdf_1729061918.pdf',0,0),
('2024-000032',NULL,3,32,34,'Postal ID','POS-1234567890','Getting Business Permit',32,'generated_pdf_1729062693.pdf',0,1),
('2024-000033',12,NULL,33,22,'School ID','21-00259','Securing Excavation Permit',33,'generated_pdf_1729076195.pdf',0,0),
('2024-000034',8,NULL,34,38,'National ID','df4545454545','Verification Purposes',34,'generated_pdf_1729336951.pdf',0,0),
('2024-000035',8,NULL,35,38,'NBI Clearance','df4545454545','Medical Assistance',35,'generated_pdf_1729337030.pdf',0,0),
('2024-000036',8,NULL,36,38,'NBI Clearance','df4545454545','Medical Assistance',36,'generated_pdf_1729337271.pdf',0,0),
('2024-000037',8,NULL,37,38,'NBI Clearance','df4545454545','Medical Assistance',37,'generated_pdf_1729337282.pdf',0,0),
('2024-000038',8,NULL,38,38,'NBI Clearance','df4545454545','Medical Assistance',38,'generated_pdf_1729337365.pdf',0,0),
('2024-000039',8,NULL,39,38,'Postal ID','df4545454545','Employment',39,'C:/xampp/htdocs//BIMS-with-Template/documents/first_time_job_seeker/generated_pdf_1729337651.pdf',0,0);

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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

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
(39,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `tbl_excavation_permits` */

DROP TABLE IF EXISTS `tbl_excavation_permits`;

CREATE TABLE `tbl_excavation_permits` (
  `exca_permit_id` int(55) NOT NULL AUTO_INCREMENT,
  `blg_house_no` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `subd` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`exca_permit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_excavation_permits` */

insert  into `tbl_excavation_permits`(`exca_permit_id`,`blg_house_no`,`street`,`subd`) values 
(1,'12','Zabarte',''),
(2,'Blk 8 Lot 4','Jeremiah st','Cielito Homes');

/*Table structure for table `tbl_fencing_permit` */

DROP TABLE IF EXISTS `tbl_fencing_permit`;

CREATE TABLE `tbl_fencing_permit` (
  `fencing_permit_id` int(55) NOT NULL AUTO_INCREMENT,
  `blg_house_no` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `subd` varchar(255) DEFAULT NULL,
  `estate_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`fencing_permit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_fencing_permit` */

insert  into `tbl_fencing_permit`(`fencing_permit_id`,`blg_house_no`,`street`,`subd`,`estate_type`) values 
(1,'12','Zabarte','','Commercial');

/*Table structure for table `tbl_indigency` */

DROP TABLE IF EXISTS `tbl_indigency`;

CREATE TABLE `tbl_indigency` (
  `indigency_id` int(55) NOT NULL AUTO_INCREMENT,
  `agency` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`indigency_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_indigency` */

insert  into `tbl_indigency`(`indigency_id`,`agency`) values 
(1,'Public Attorneys Office'),
(2,'PCSO'),
(3,'PCSO'),
(4,'PCSO');

/*Table structure for table `tbl_persons_involved` */

DROP TABLE IF EXISTS `tbl_persons_involved`;

CREATE TABLE `tbl_persons_involved` (
  `person_involved_id` int(55) NOT NULL AUTO_INCREMENT,
  `person_1` int(55) DEFAULT NULL,
  `person_2` int(55) DEFAULT NULL,
  `person_3` int(55) DEFAULT NULL,
  `person_4` int(55) DEFAULT NULL,
  `person_5` int(55) DEFAULT NULL,
  PRIMARY KEY (`person_involved_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_persons_involved` */

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_tprs` */

/*Table structure for table `tbl_username` */

DROP TABLE IF EXISTS `tbl_username`;

CREATE TABLE `tbl_username` (
  `username_id` int(55) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`username_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_username` */

insert  into `tbl_username`(`username_id`,`username`) values 
(1,'Robert Salas');

/*Table structure for table `tbl_users` */

DROP TABLE IF EXISTS `tbl_users`;

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username_no` int(55) NOT NULL,
  `pword` varchar(255) NOT NULL,
  `depart_no` int(55) NOT NULL,
  `isactive` tinyint(11) NOT NULL,
  `isremoved` tinyint(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `username_fk` (`username_no`),
  KEY `depart_fk` (`depart_no`),
  CONSTRAINT `depart_fk` FOREIGN KEY (`depart_no`) REFERENCES `departments_list` (`department_id`),
  CONSTRAINT `username_fk` FOREIGN KEY (`username_no`) REFERENCES `tbl_username` (`username_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_users` */

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
        
    -- For Oath of Undertaking/FTJS
    ELSEIF certificate_type = 'Oath_of_Undertaking' THEN
        INSERT INTO tbl_documents(Oath_of_Undertaking)
        SELECT IFNULL(MAX(Oath_of_Undertaking), 0) + 1 FROM tbl_documents;
    
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
    `non_resident`.`cellphone_num` AS `contact_num`,
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
    `tbl_cert_audit_trail`.`expiration` AS `expiration`,
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
            `res_audit_trail`.`date_added` AS `date_recorded`,
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

/* Procedure structure for procedure `SearchResidentDeleted` */

/*!50003 DROP PROCEDURE IF EXISTS  `SearchResidentDeleted` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchResidentDeleted`(in search varchar(255), in start_from int, in lim int)
BEGIN
	
	SELECT 
            `resident`.`resident_id`       AS `resident_id`,
            `res_audit_trail`.`date_added` AS `date_recorded`,
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
    `tbl_cert_audit_trail`.`expiration` AS `expiration`,
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

/*Table structure for table `vw_deleted_nonresident` */

DROP TABLE IF EXISTS `vw_deleted_nonresident`;

/*!50001 DROP VIEW IF EXISTS `vw_deleted_nonresident` */;
/*!50001 DROP TABLE IF EXISTS `vw_deleted_nonresident` */;

/*!50001 CREATE TABLE  `vw_deleted_nonresident`(
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
 `contact_num` varchar(50) ,
 `is_deleted` tinyint(2) 
)*/;

/*Table structure for table `vw_nonresident` */

DROP TABLE IF EXISTS `vw_nonresident`;

/*!50001 DROP VIEW IF EXISTS `vw_nonresident` */;
/*!50001 DROP TABLE IF EXISTS `vw_nonresident` */;

/*!50001 CREATE TABLE  `vw_nonresident`(
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
 `audit_trail_no` int(55) ,
 `is_deleted` tinyint(2) 
)*/;

/*Table structure for table `vw_resident` */

DROP TABLE IF EXISTS `vw_resident`;

/*!50001 DROP VIEW IF EXISTS `vw_resident` */;
/*!50001 DROP TABLE IF EXISTS `vw_resident` */;

/*!50001 CREATE TABLE  `vw_resident`(
 `resident_id` int(55) ,
 `date_recorded` date ,
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

/*View structure for view vw_all_brgy_clearance */

/*!50001 DROP TABLE IF EXISTS `vw_all_brgy_clearance` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_brgy_clearance` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_brgy_clearance` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_num`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from ((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`))) where (`tbl_documents`.`Barangay_Clearance` is not null)) */;

/*View structure for view vw_all_build_permits */

/*!50001 DROP TABLE IF EXISTS `vw_all_build_permits` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_build_permits` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_build_permits` AS (select `tbl_docu_request`.`request_id` AS `request_id`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`last_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`last_name` else NULL end) using utf8mb4)) AS `last_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`first_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`first_name` else NULL end) using utf8mb4)) AS `first_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`middle_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`middle_name` else NULL end) using utf8mb4)) AS `middle_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`suffix` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`suffix` else NULL end) using utf8mb4)) AS `suffix`,(case when (`tbl_docu_request`.`resident_no` is not null) then 'Resident' when (`tbl_docu_request`.`nresident_no` is not null) then 'Non-Resident' else 'Unknown' end) AS `owner_status`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_building_permits`.`blg_house_no` AS `blg_house_no`,`tbl_building_permits`.`street` AS `street`,`tbl_building_permits`.`subd` AS `subd`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from (((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) join `tbl_building_permits` on((`tbl_documents`.`Building_Permits` = `tbl_building_permits`.`building_permit_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`)))) */;

/*View structure for view vw_all_buss_permits */

/*!50001 DROP TABLE IF EXISTS `vw_all_buss_permits` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_buss_permits` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_buss_permits` AS (select `tbl_docu_request`.`request_id` AS `request_id`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`last_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`last_name` else NULL end) using utf8mb4)) AS `last_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`first_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`first_name` else NULL end) using utf8mb4)) AS `first_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`middle_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`middle_name` else NULL end) using utf8mb4)) AS `middle_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`suffix` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`suffix` else NULL end) using utf8mb4)) AS `suffix`,(case when (`tbl_docu_request`.`resident_no` is not null) then 'Resident' when (`tbl_docu_request`.`nresident_no` is not null) then 'Non-Resident' else 'Unknown' end) AS `owner_status`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_business_permits`.`store_name` AS `store_name`,`tbl_business_permits`.`blg_house_no` AS `blg_house_no`,`tbl_business_permits`.`street` AS `street`,`tbl_business_permits`.`subdivision` AS `subdivision`,`tbl_business_permits`.`type_of_buss` AS `type_of_buss`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from (((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`Business_Permits`))) join `tbl_business_permits` on((`tbl_documents`.`Business_Permits` = `tbl_business_permits`.`business_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`)))) */;

/*View structure for view vw_all_cgmoral */

/*!50001 DROP TABLE IF EXISTS `vw_all_cgmoral` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_cgmoral` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_cgmoral` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_num`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from ((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`))) where (`tbl_documents`.`Certificate_of_Good_Moral` is not null)) */;

/*View structure for view vw_all_cindigency */

/*!50001 DROP TABLE IF EXISTS `vw_all_cindigency` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_cindigency` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_cindigency` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_num`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from (((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`))) where (`tbl_documents`.`Certificate_of_Indigency` is not null)) */;

/*View structure for view vw_all_cresidency */

/*!50001 DROP TABLE IF EXISTS `vw_all_cresidency` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_cresidency` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_cresidency` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_num`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from ((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`))) where (`tbl_documents`.`Certificate_of_Residency` is not null)) */;

/*View structure for view vw_all_documents */

/*!50001 DROP TABLE IF EXISTS `vw_all_documents` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_documents` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_documents` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,(case when (`tbl_docu_request`.`resident_no` is not null) then '1' else '0' end) AS `is_resident`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`resident_id` else `non_resident`.`nresident_id` end) AS `resident/nonres_id`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`last_name` else convert(`non_resident`.`last_name` using utf8mb4) end) AS `last_name`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`first_name` else convert(`non_resident`.`first_name` using utf8mb4) end) AS `first_name`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`middle_name` else convert(`non_resident`.`middle_name` using utf8mb4) end) AS `middle_name`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`suffix` else convert(`non_resident`.`suffix` using utf8mb4) end) AS `suffix`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`house_num` else convert(`non_resident`.`house_num` using utf8mb4) end) AS `house_num`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`street` else convert(`non_resident`.`street` using utf8mb4) end) AS `street`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`subdivision` else convert(`non_resident`.`subdivision` using utf8mb4) end) AS `subdivision`,(case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`city` else 'Caloocan City' end) AS `city`,(case when (`tbl_documents`.`Barangay_Clearance` is not null) then 'Barangay Clearance' when (`tbl_documents`.`Certificate_of_Residency` is not null) then 'Certificate of Residency' when (`tbl_documents`.`Certificate_of_Indigency` is not null) then 'Certificate of Indigency' when (`tbl_documents`.`Certificate_of_Good_Moral` is not null) then 'Certificate of Good Moral' when (`tbl_documents`.`Business_Permits` is not null) then 'Business Permits' when (`tbl_documents`.`Building_Permits` is not null) then 'Building Permits' when (`tbl_documents`.`Excavation_Permits` is not null) then 'Excavation Permits' when (`tbl_documents`.`Fencing_Permits` is not null) then 'Fencing Permits' when (`tbl_documents`.`FTJS` is not null) then 'First Time Job Seekers' when (`tbl_documents`.`Oath_of_Undertaking` is not null) then 'Oath of Undertaking' when (`tbl_documents`.`TPRS` is not null) then 'Tricycle Pedicab Regulatory Services' else 'Unknown Document Type' end) AS `document_desc`,`tbl_docu_request`.`age` AS `age`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`sex` else convert(`non_resident`.`sex` using utf8mb4) end) AS `sex`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_docu_request`.`pdffile` AS `pdffile`,`tbl_cert_audit_trail`.`expiration` AS `expiration`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted`,`tbl_cert_audit_trail`.`datetime_edited` AS `date_edited`,`tbl_cert_audit_trail`.`datetime_deleted` AS `date_deleted` from ((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) where (`tbl_docu_request`.`is_deleted` = 0)) */;

/*View structure for view vw_all_exca_permits */

/*!50001 DROP TABLE IF EXISTS `vw_all_exca_permits` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_exca_permits` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_exca_permits` AS (select `tbl_docu_request`.`request_id` AS `request_id`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`last_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`last_name` else NULL end) using utf8mb4)) AS `last_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`first_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`first_name` else NULL end) using utf8mb4)) AS `first_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`middle_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`middle_name` else NULL end) using utf8mb4)) AS `middle_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`suffix` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`suffix` else NULL end) using utf8mb4)) AS `suffix`,(case when (`tbl_docu_request`.`resident_no` is not null) then 'Resident' when (`tbl_docu_request`.`nresident_no` is not null) then 'Non-Resident' else 'Unknown' end) AS `owner_status`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_excavation_permits`.`blg_house_no` AS `blg_house_no`,`tbl_excavation_permits`.`street` AS `street`,`tbl_excavation_permits`.`subd` AS `subd`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from (((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) join `tbl_excavation_permits` on((`tbl_documents`.`Building_Permits` = `tbl_excavation_permits`.`exca_permit_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`)))) */;

/*View structure for view vw_all_ftjs */

/*!50001 DROP TABLE IF EXISTS `vw_all_ftjs` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_ftjs` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_ftjs` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_num`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from ((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`))) where (`tbl_documents`.`FTJS` is not null)) */;

/*View structure for view vw_all_out */

/*!50001 DROP TABLE IF EXISTS `vw_all_out` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_out` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_out` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_no`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from ((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`))) where (`tbl_documents`.`Oath_of_Undertaking` is not null)) */;

/*View structure for view vw_all_res_cert */

/*!50001 DROP TABLE IF EXISTS `vw_all_res_cert` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_res_cert` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_res_cert` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`tbl_docu_request`.`resident_no` AS `resident_no`,(case when (`tbl_documents`.`Barangay_Clearance` is not null) then 'Barangay Clearance' when (`tbl_documents`.`Certificate_of_Residency` is not null) then 'Certificate of Residency' when (`tbl_documents`.`Certificate_of_Indigency` is not null) then 'Certificate of Indigency' when (`tbl_documents`.`Certificate_of_Good_Moral` is not null) then 'Certificate of Good Moral' when (`tbl_documents`.`FTJS` is not null) then 'First Time Job Seeker' when (`tbl_documents`.`Oath_of_Undertaking` is not null) then 'Oath of Undertaking' when (`tbl_documents`.`Business_Permits` is not null) then 'Business Permits' when (`tbl_documents`.`Building_Permits` is not null) then 'Building Permits' when (`tbl_documents`.`Fencing_Permits` is not null) then 'Fencing Permit' when (`tbl_documents`.`Excavation_Permits` is not null) then 'Excavation Permit' when (`tbl_documents`.`TPRS` is not null) then 'Tricycle Pedicab Regulatory Services' else 'Unknown' end) AS `cert_type`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expiration`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`status` AS `status` from (((`tbl_docu_request` join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`)))) */;

/*View structure for view vw_all_tprs */

/*!50001 DROP TABLE IF EXISTS `vw_all_tprs` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_tprs` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_tprs` AS (select `tbl_docu_request`.`request_id` AS `request_id`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`last_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`last_name` else NULL end) using utf8mb4)) AS `last_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`first_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`first_name` else NULL end) using utf8mb4)) AS `first_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`middle_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`middle_name` else NULL end) using utf8mb4)) AS `middle_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`suffix` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`suffix` else NULL end) using utf8mb4)) AS `suffix`,(case when (`tbl_docu_request`.`resident_no` is not null) then 'Resident' when (`tbl_docu_request`.`nresident_no` is not null) then 'Non-Resident' else 'Unknown' end) AS `owner_status`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_tprs`.`toda` AS `toda`,`tbl_tprs`.`route` AS `route`,`tbl_tprs`.`platenum` AS `platenum`,`tbl_tprs`.`chasisnum` AS `chasisnum`,`tbl_tprs`.`makertype` AS `makertype`,`tbl_tprs`.`enginenum` AS `engine_no`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from (((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) join `tbl_tprs` on((`tbl_documents`.`Building_Permits` = `tbl_tprs`.`tprs_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`)))) */;

/*View structure for view vw_deleted_docu */

/*!50001 DROP TABLE IF EXISTS `vw_deleted_docu` */;
/*!50001 DROP VIEW IF EXISTS `vw_deleted_docu` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_deleted_docu` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,(case when (`tbl_docu_request`.`resident_no` is not null) then '1' else '0' end) AS `is_resident`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`resident_id` else `non_resident`.`nresident_id` end) AS `resident/nonres_id`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`last_name` else convert(`non_resident`.`last_name` using utf8mb4) end) AS `last_name`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`first_name` else convert(`non_resident`.`first_name` using utf8mb4) end) AS `first_name`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`middle_name` else convert(`non_resident`.`middle_name` using utf8mb4) end) AS `middle_name`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`suffix` else convert(`non_resident`.`suffix` using utf8mb4) end) AS `suffix`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`house_num` else convert(`non_resident`.`house_num` using utf8mb4) end) AS `house_num`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`street` else convert(`non_resident`.`street` using utf8mb4) end) AS `street`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`subdivision` else convert(`non_resident`.`subdivision` using utf8mb4) end) AS `subdivision`,(case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`city` else 'Caloocan City' end) AS `city`,(case when (`tbl_documents`.`Barangay_Clearance` is not null) then 'Barangay Clearance' when (`tbl_documents`.`Certificate_of_Residency` is not null) then 'Certificate of Residency' when (`tbl_documents`.`Certificate_of_Indigency` is not null) then 'Certificate of Indigency' when (`tbl_documents`.`Certificate_of_Good_Moral` is not null) then 'Certificate of Good Moral' when (`tbl_documents`.`Business_Permits` is not null) then 'Business Permits' when (`tbl_documents`.`Building_Permits` is not null) then 'Building Permits' when (`tbl_documents`.`Excavation_Permits` is not null) then 'Excavation Permits' when (`tbl_documents`.`Fencing_Permits` is not null) then 'Fencing Permits' when (`tbl_documents`.`FTJS` is not null) then 'First Time Job Seekers' when (`tbl_documents`.`Oath_of_Undertaking` is not null) then 'Oath of Undertaking' when (`tbl_documents`.`TPRS` is not null) then 'Tricycle Pedicab Regulatory Services' else 'Unknown Document Type' end) AS `document_desc`,`tbl_docu_request`.`age` AS `age`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`sex` else convert(`non_resident`.`sex` using utf8mb4) end) AS `sex`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_docu_request`.`pdffile` AS `pdffile`,`tbl_cert_audit_trail`.`expiration` AS `expiration`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted`,`tbl_cert_audit_trail`.`datetime_edited` AS `date_edited`,`tbl_cert_audit_trail`.`datetime_deleted` AS `date_deleted` from ((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) where (`tbl_docu_request`.`is_deleted` = 1)) */;

/*View structure for view vw_deleted_nonresident */

/*!50001 DROP TABLE IF EXISTS `vw_deleted_nonresident` */;
/*!50001 DROP VIEW IF EXISTS `vw_deleted_nonresident` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_deleted_nonresident` AS (select `non_resident`.`nresident_id` AS `nresident_id`,cast(`nonres_audit_trail`.`datetime_added` as date) AS `datetime_added`,`non_resident`.`img_filename` AS `img_filename`,`non_resident`.`last_name` AS `last_name`,`non_resident`.`first_name` AS `first_name`,`non_resident`.`middle_name` AS `middle_name`,`non_resident`.`suffix` AS `suffix`,`non_resident`.`house_num` AS `house_num`,`non_resident`.`street` AS `street`,`non_resident`.`subdivision` AS `subdivision`,`non_resident`.`district_brgy` AS `district_brgy`,`non_resident`.`city` AS `city`,`non_resident`.`province` AS `province`,`non_resident`.`zipcode` AS `zipcode`,`non_resident`.`sex` AS `sex`,`non_resident`.`marital_status` AS `marital_status`,`non_resident`.`birth_date` AS `birth_date`,`non_resident`.`birth_place` AS `birth_place`,`non_resident`.`cellphone_num` AS `contact_num`,`non_resident`.`is_deleted` AS `is_deleted` from (`non_resident` join `nonres_audit_trail` on((`non_resident`.`audit_trail_no` = `nonres_audit_trail`.`audit_trail_id`))) where (`non_resident`.`is_deleted` = 1)) */;

/*View structure for view vw_nonresident */

/*!50001 DROP TABLE IF EXISTS `vw_nonresident` */;
/*!50001 DROP VIEW IF EXISTS `vw_nonresident` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_nonresident` AS (select `non_resident`.`nresident_id` AS `nresident_id`,cast(`nonres_audit_trail`.`datetime_added` as date) AS `datetime_added`,`non_resident`.`img_filename` AS `img_filename`,`non_resident`.`last_name` AS `last_name`,`non_resident`.`first_name` AS `first_name`,`non_resident`.`middle_name` AS `middle_name`,`non_resident`.`suffix` AS `suffix`,`non_resident`.`house_num` AS `house_num`,`non_resident`.`street` AS `street`,`non_resident`.`subdivision` AS `subdivision`,`non_resident`.`district_brgy` AS `district_brgy`,`non_resident`.`city` AS `city`,`non_resident`.`province` AS `province`,`non_resident`.`zipcode` AS `zipcode`,`non_resident`.`sex` AS `sex`,`non_resident`.`marital_status` AS `marital_status`,`non_resident`.`birth_date` AS `birth_date`,`non_resident`.`birth_place` AS `birth_place`,`non_resident`.`cellphone_num` AS `cellphone_num`,`non_resident`.`audit_trail_no` AS `audit_trail_no`,`non_resident`.`is_deleted` AS `is_deleted` from (`non_resident` join `nonres_audit_trail` on((`non_resident`.`audit_trail_no` = `nonres_audit_trail`.`audit_trail_id`))) where (`non_resident`.`is_deleted` = 0)) */;

/*View structure for view vw_resident */

/*!50001 DROP TABLE IF EXISTS `vw_resident` */;
/*!50001 DROP VIEW IF EXISTS `vw_resident` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_resident` AS (select `resident`.`resident_id` AS `resident_id`,`res_audit_trail`.`date_added` AS `date_recorded`,`resident`.`img_filename` AS `img_filename`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_num`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`resident`.`resident_since` AS `resident_since`,`resident`.`sex` AS `sex`,`resident`.`marital_status` AS `marital_status`,`resident`.`birth_date` AS `birth_date`,`resident`.`birth_place` AS `birth_place`,`resident`.`cellphone_num` AS `cellphone_num`,`resident`.`is_a_voter` AS `is_a_voter`,`resident`.`is_deleted` AS `is_deleted` from (`resident` join `res_audit_trail` on((`resident`.`audit_trail` = `res_audit_trail`.`res_at_id`))) where (`resident`.`is_deleted` = 0)) */;

/*View structure for view vw_resonly_cert */

/*!50001 DROP TABLE IF EXISTS `vw_resonly_cert` */;
/*!50001 DROP VIEW IF EXISTS `vw_resonly_cert` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_resonly_cert` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,`resident`.`resident_id` AS `resident_id`,(case when (`tbl_documents`.`Barangay_Clearance` is not null) then 'Barangay Clearance' when (`tbl_documents`.`Certificate_of_Residency` is not null) then 'Certificate of Residency' when (`tbl_documents`.`Certificate_of_Indigency` is not null) then 'Certificate of Indigency' when (`tbl_documents`.`Certificate_of_Good_Moral` is not null) then 'Certificate of Good Moral' when (`tbl_documents`.`Business_Permits` is not null) then 'Business Permits' when (`tbl_documents`.`Building_Permits` is not null) then 'Building Permits' when (`tbl_documents`.`Excavation_Permits` is not null) then 'Excavation Permits' when (`tbl_documents`.`Fencing_Permits` is not null) then 'Fencing Permits' when (`tbl_documents`.`FTJS` is not null) then 'First Time Job Seekers' when (`tbl_documents`.`Oath_of_Undertaking` is not null) then 'Oath of Undertaking' when (`tbl_documents`.`TPRS` is not null) then 'Tricycle Pedicab Regulatory Services' else 'Unknown Document Type' end) AS `document_desc`,`tbl_docu_request`.`age` AS `age`,`resident`.`sex` AS `sex`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_docu_request`.`pdffile` AS `pdffile`,`tbl_cert_audit_trail`.`expiration` AS `expiration`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted`,`tbl_cert_audit_trail`.`datetime_edited` AS `date_edited`,`tbl_cert_audit_trail`.`datetime_deleted` AS `date_deleted` from ((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`)))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
