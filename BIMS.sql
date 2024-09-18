/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 5.7.44-log : Database - bims
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bims` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `bims`;

/*Table structure for table `brgy_officials` */

DROP TABLE IF EXISTS `brgy_officials`;

CREATE TABLE `brgy_officials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `official_name` varchar(255) NOT NULL,
  `official_position` varchar(255) NOT NULL,
  `date_last_edited` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

/*Data for the table `brgy_officials` */

insert  into `brgy_officials`(`id`,`official_name`,`official_position`,`date_last_edited`) values 
(1,'Donna De Gana','Punong Barangay','2024-08-18'),
(2,'Darwin L. Dela Cruz','Kagawad at Secretary','2024-04-22'),
(3,'Eloisa Marie T. Encarnation','Kagawad','2024-04-30'),
(4,'Gina T. Ortiz','Kagawad','2024-04-30'),
(5,'Francis S. Acosta','Kagawad','2024-04-30'),
(6,'Renato C. Busante','Kagawad','2024-04-30'),
(7,'Christy Joy V. Calilung','Kagawad','2024-04-30'),
(8,'Loreto D. Derrada','Kagawad','2024-04-30'),
(9,'Vince B. Salvani','Kagawad','2024-04-30'),
(10,'Loida M. Francisco','Barangay-Secretary','2024-04-30'),
(11,'Dave A. Ramirez','Treasurer','2024-05-23'),
(12,'Ginny Abiertas','Kagawad','2024-05-23');

/*Table structure for table `certificate-img` */

DROP TABLE IF EXISTS `certificate-img`;

CREATE TABLE `certificate-img` (
  `img_id` int(12) NOT NULL AUTO_INCREMENT,
  `purpose` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  PRIMARY KEY (`img_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `certificate-img` */

insert  into `certificate-img`(`img_id`,`purpose`,`filename`) values 
(1,'City Logo','CaloocanCityLogo.png'),
(2,'Barangay Logo','Brgy177.png'),
(3,'Government Logo','BagongPinas.png'),
(4,'watermark','watermark.png');

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
  `distric_brgy` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) DEFAULT NULL,
  `sex` varchar(55) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `contact_num` bigint(50) NOT NULL,
  `audit_trail_no` int(55) DEFAULT NULL,
  `is_deleted` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`nresident_id`),
  KEY `nres_audit_trail` (`audit_trail_no`),
  CONSTRAINT `nres_audit_trail` FOREIGN KEY (`audit_trail_no`) REFERENCES `nonres_audit_trail` (`audit_trail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `non_resident` */

insert  into `non_resident`(`nresident_id`,`img_filename`,`last_name`,`first_name`,`middle_name`,`suffix`,`house_num`,`street`,`subdivision`,`distric_brgy`,`city`,`province`,`sex`,`birth_date`,`contact_num`,`audit_trail_no`,`is_deleted`) values 
(1,NULL,'Rabanes','Fernan','Jarito',NULL,'Blk 9 Lot 3','Kamatis st','Ramirez Subd','Novaliches ','Quezon City',NULL,'Male','1998-06-16',90956565454,1,0);

/*Table structure for table `nonres_audit_trail` */

DROP TABLE IF EXISTS `nonres_audit_trail`;

CREATE TABLE `nonres_audit_trail` (
  `audit_trail_id` int(55) NOT NULL AUTO_INCREMENT,
  `depart_no` int(55) DEFAULT NULL,
  `user_no` int(55) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `time_added` time DEFAULT NULL,
  `last_edited_date` date DEFAULT NULL,
  `last_edited_time` time DEFAULT NULL,
  PRIMARY KEY (`audit_trail_id`),
  KEY `nres_dept_fk` (`depart_no`),
  KEY `nres_user_fk` (`user_no`),
  CONSTRAINT `nres_dept_fk` FOREIGN KEY (`depart_no`) REFERENCES `departments_list` (`department_id`),
  CONSTRAINT `nres_user_fk` FOREIGN KEY (`user_no`) REFERENCES `tbl_username` (`username_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `nonres_audit_trail` */

insert  into `nonres_audit_trail`(`audit_trail_id`,`depart_no`,`user_no`,`date_added`,`time_added`,`last_edited_date`,`last_edited_time`) values 
(1,NULL,NULL,'2024-09-04','04:00:00','2024-09-12','06:00:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

/*Data for the table `res_audit_trail` */

insert  into `res_audit_trail`(`res_at_id`,`added_depart_no`,`added_by_no`,`date_added`,`time_added`,`edited_depart_no`,`last_edited_by`,`last_edited_dt`,`last_edited_tm`,`dept_del_no`,`del_by_no`,`del_date`,`del_time`,`dept_rec_no`,`rec_by_no`,`rec_date`,`rec_time`) values 
(1,NULL,NULL,'2024-09-03','15:42:52',NULL,NULL,'2024-09-13','09:32:06',NULL,NULL,'2024-09-13','15:30:23',NULL,NULL,'2024-09-13','15:31:47'),
(2,NULL,NULL,'2024-09-03','15:44:00',NULL,NULL,'2024-09-04','09:54:55',NULL,NULL,'2024-09-12','14:07:05',NULL,NULL,'2024-09-07','18:09:16'),
(3,NULL,NULL,'2024-09-03','15:45:08',NULL,NULL,'2024-09-03','23:37:39',NULL,NULL,'2024-09-04','14:58:47',NULL,NULL,'2024-09-07','18:09:27'),
(4,NULL,NULL,'2024-09-03','15:56:12',NULL,NULL,'2024-09-03','23:37:58',NULL,NULL,'2024-09-04','14:58:44',NULL,NULL,'2024-09-07','18:09:18'),
(5,NULL,NULL,'2024-09-03','15:56:57',NULL,NULL,'2024-09-12','14:04:20',NULL,NULL,'2024-09-04','14:58:40',NULL,NULL,'2024-09-07','18:09:21'),
(6,NULL,NULL,'2024-09-03','15:58:04',NULL,NULL,'2024-09-08','03:58:15',NULL,NULL,'2024-09-04','14:58:14',NULL,NULL,'2024-09-07','18:09:25'),
(7,NULL,NULL,'2024-09-10','17:46:56',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(8,NULL,NULL,'2024-09-03','16:00:19',NULL,NULL,'2024-09-12','14:03:45',NULL,NULL,'2024-09-04','14:58:21',NULL,NULL,'2024-09-07','18:09:03'),
(9,NULL,NULL,'2024-09-03','16:02:53',NULL,NULL,'2024-09-12','14:04:08',NULL,NULL,'2024-09-08','03:53:36',NULL,NULL,'2024-09-08','03:53:49'),
(10,NULL,NULL,'2024-09-03','16:07:36',NULL,NULL,'2024-09-03','18:39:34',NULL,NULL,'2024-09-04','14:58:27',NULL,NULL,'2024-09-07','18:08:57'),
(11,NULL,NULL,'2024-09-10','17:46:23',NULL,NULL,'2024-09-16','22:51:12',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(12,NULL,NULL,'2024-09-03','16:14:48',NULL,NULL,'2024-09-08','03:33:59',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(13,NULL,NULL,'2024-09-03','16:15:39',NULL,NULL,'2024-09-08','03:34:04',NULL,NULL,'2024-09-13','15:39:32',NULL,NULL,'2024-09-08','11:53:41'),
(14,NULL,NULL,'2024-09-03','18:30:55',NULL,NULL,'2024-09-16','11:30:29',NULL,NULL,'2024-09-04','14:58:55',NULL,NULL,'2024-09-05','23:24:21'),
(15,NULL,NULL,'2024-09-03','18:39:05',NULL,NULL,'2024-09-10','15:07:53',NULL,NULL,'2024-09-10','15:41:27',NULL,NULL,NULL,NULL),
(16,NULL,NULL,'2024-09-07','23:54:29',NULL,NULL,'2024-09-10','14:58:50',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(17,NULL,NULL,'2024-09-07','23:54:41',NULL,NULL,'2024-09-12','14:05:20',NULL,NULL,'2024-09-17','16:27:52',NULL,NULL,NULL,NULL),
(18,NULL,NULL,'2024-09-07','23:57:51',NULL,NULL,'2024-09-12','14:05:08',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(19,NULL,NULL,'2024-09-11','19:37:19',NULL,NULL,'2024-09-12','14:04:43',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

/*Data for the table `resident` */

insert  into `resident`(`resident_id`,`img_filename`,`last_name`,`first_name`,`middle_name`,`suffix`,`house_num`,`street`,`subdivision`,`resident_since`,`sex`,`marital_status`,`birth_date`,`birth_place`,`cellphone_num`,`is_a_voter`,`audit_trail`,`is_deleted`) values 
(1,'capture_24-09-131726191126.jpg','Tecson','Reno','Hofileña','','Blk 12 Lot 4','Isaiah st','Cielito Homes','2015','Male','Single','1992-01-18','Malolos Bulacan','09568989899',0,1,0),
(2,'8406e341a7981729777f9dee8b55be99 (1).jpg','Tecson','Randy','Hofileña','','Blk 12 Lot 4','Isaiah st','Cielito Homes','2003','Male','Single','1992-01-08','Bulacan Bulacan','09656565655',0,2,1),
(3,'Miranda_Hallow.png','Tecson','Miranda','Hofileña','','Blk 12 Lot 4','Isaiah st','Cielito Homes','2006','Female','Married','1994-01-15','Plaridel Bulacan','09656565655',1,3,0),
(4,'Lavi_2006.png','Tecson','James','Hofileña','','Blk 12 Lot 4','Isaiah st','Cielito Homes','2007','Male','Single','1993-02-18','Pulilan Bulacan','09669898989',0,4,0),
(5,'alingpuring.jpg','Tecson','Puring','Ulatan','','Blk 12 Lot 3','Isaiah st','Cielito Homes','2007','Female','Single','1993-02-18','Bustos Bulacan','09669898989',0,5,0),
(6,'Shirou.png','Tecson','Gardo','Hofileña','','Blk 12 Lot 2','Isaiah st','Cielito Homes','2009','Male','Married','1988-02-27','San Miguel Bulacan','09064154588',1,6,0),
(8,'images (1).jpg','Yalong','Aaaron','Armengol','','Blk 12 Lot 5','Isaiah st','Cielito Homes','2015','Male','Single','1986-03-21','Gapan Nueva Ecjia','09565656565',1,8,0),
(9,'miano.jpg','Tecson','Franklin','Miano','','Blk 12 Lot 5','Isaiah st','Cielito Homes','2015','Male','Married','1986-03-21','Cabiao Nueva Ecjia','09565656564',1,9,0),
(10,'Karen-Bennett-200x200px.jpg','Tecson','Kiana','Macabara','','Blk 8 lot 5B','Jeremiah st','Cielito Homes','2015','Female','Married','1988-09-13','Valenzuela City','09565656565',0,10,0),
(11,'capture_24-09-161726498272.jpg','Salas','Norberto','Torres','','12','Zabarte rd','','2002','Male','Single','2002-08-23','Caloocan City','09565656566',0,11,0),
(12,'Shiroe_portal.jpg','Salas','Robert','Lumauig','','Blk 8 lot 4','Jeremiah st','Cielito Homes','2002','Male','Single','2002-10-16','Caloocan City','09064121066',0,12,0),
(13,'Akatsuki_portal.png','Salas','Akatsuki','Lumauig','','Blk 8 lot 4','Jeremiah st','Cielito Homes','2004','Female','Single','2004-12-16','Caloocan City','09054321268',1,13,1),
(14,'6c2e2762dc133ba55627875e9fa27f33.jpg','Dayao','Hiro','Timbol','','Blk 8 lot 3','Jeremiah st','Cielito Homes','2013','Male','Married','1990-04-03','Palauig Quezon','09665656565',1,14,0),
(15,'Minori_portal.png','Atchico','Denise','Tamaro','','Blk 14 lot 13','Moises st','Cielito Homes','2019','Female','Single','1999-04-24','Palauig Quezon','09665656565',0,15,1),
(16,'soul (1).jpg','Labancas','Danilo','Lim','','Blk 12 Lot 4','Kang kong st','Kassel Villas','2006','Male','Single','2002-10-16','Bulacan Bulacan','09056565656',1,16,0),
(17,'capture_24-09-121726121120.jpg','Japerson','Henry','','','123','Zabarte Rd','','2012','Male','Single','2002-10-16','Caloocan City','0906412066',0,17,1),
(18,'Naotsugu_portal.png','Operacio','Tim','Lucarnas','','12','Virgo st Corner Aries st','Maria Luisa Subd','2002','Male','Single','2002-10-16','Malabon City','09545454544',1,18,0),
(19,'Allenwalkerimage.png','Salas','Roberto','Lumauig','','Blk 12 Lot 4','Isaiah st','Cielito Homes','2002','Male','Single','2001-10-16','Caloocan City','09064121066',1,19,0);

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
  PRIMARY KEY (`building_permit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_building_permits` */

insert  into `tbl_building_permits`(`building_permit_id`,`blg_house_no`,`street`,`subd`) values 
(1,'723','Virgo st','Maria Lusisa');

/*Table structure for table `tbl_business_permits` */

DROP TABLE IF EXISTS `tbl_business_permits`;

CREATE TABLE `tbl_business_permits` (
  `business_id` int(55) NOT NULL AUTO_INCREMENT,
  `request_id` varchar(255) NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `blg_house_no` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `subdivision` varchar(255) DEFAULT NULL,
  `type_of_buss` varchar(255) NOT NULL,
  PRIMARY KEY (`business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_business_permits` */

insert  into `tbl_business_permits`(`business_id`,`request_id`,`store_name`,`blg_house_no`,`street`,`subdivision`,`type_of_buss`) values 
(1,'','Robert Computer Shop','Blk 5 Lot 3','Genesis st','Cielito Homes','Computer Shop'),
(2,'','Master Siomai','Blk 3 Lot 9','Genesis st','Cielito Homes','Food Stand');

/*Table structure for table `tbl_cert_audit_trail` */

DROP TABLE IF EXISTS `tbl_cert_audit_trail`;

CREATE TABLE `tbl_cert_audit_trail` (
  `audit_trail_id` int(50) NOT NULL AUTO_INCREMENT,
  `issuing_dept_no` int(50) DEFAULT NULL,
  `issued_by_no` int(50) DEFAULT NULL,
  `date_issued` date NOT NULL,
  `time_issued` time NOT NULL,
  `expiration` date DEFAULT NULL,
  `edited_by_no` int(55) DEFAULT NULL,
  `date_edited` date DEFAULT NULL,
  `time_edited` time DEFAULT NULL,
  `deleted_by_no` int(55) DEFAULT NULL,
  `date_deleted` date DEFAULT NULL,
  `time_deleted` time DEFAULT NULL,
  `recovered_by_no` int(55) DEFAULT NULL,
  `recovered_date` date DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_cert_audit_trail` */

insert  into `tbl_cert_audit_trail`(`audit_trail_id`,`issuing_dept_no`,`issued_by_no`,`date_issued`,`time_issued`,`expiration`,`edited_by_no`,`date_edited`,`time_edited`,`deleted_by_no`,`date_deleted`,`time_deleted`,`recovered_by_no`,`recovered_date`,`recovered_time`) values 
(1,NULL,NULL,'2024-09-10','10:23:45','2024-09-25',NULL,'2024-09-17','08:14:40',NULL,NULL,NULL,NULL,NULL,NULL);

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
  CONSTRAINT `toknowtheaudittrail` FOREIGN KEY (`audit_trail_no`) REFERENCES `tbl_cert_audit_trail` (`audit_trail_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `toknowthenresident` FOREIGN KEY (`nresident_no`) REFERENCES `non_resident` (`nresident_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `toknowtheresident` FOREIGN KEY (`resident_no`) REFERENCES `resident` (`resident_id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_docu_request` */

insert  into `tbl_docu_request`(`request_id`,`resident_no`,`nresident_no`,`document_no`,`age`,`presented_id`,`ID_number`,`purpose`,`audit_trail_no`,`pdffile`,`status`,`is_deleted`) values 
('2024-000001',1,NULL,1,32,'National ID','TYO-12345612','Verification Purposes',1,NULL,0,0);

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
  CONSTRAINT `bpermit_fk` FOREIGN KEY (`Business_Permits`) REFERENCES `tbl_business_permits` (`business_id`),
  CONSTRAINT `build_permit_fk` FOREIGN KEY (`Building_Permits`) REFERENCES `tbl_building_permits` (`building_permit_id`),
  CONSTRAINT `exca_fk` FOREIGN KEY (`Excavation_Permits`) REFERENCES `tbl_excavation_permits` (`exca_permit_id`),
  CONSTRAINT `f_permit_fk` FOREIGN KEY (`Fencing_Permits`) REFERENCES `tbl_fencing_permit` (`fencing_permit_id`),
  CONSTRAINT `tprs_fk` FOREIGN KEY (`TPRS`) REFERENCES `tbl_tprs` (`tprs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_documents` */

insert  into `tbl_documents`(`docu_id`,`Barangay_Clearance`,`Certificate_of_Residency`,`Certificate_of_Indigency`,`Certificate_of_Good_Moral`,`FTJS`,`Oath_of_Undertaking`,`Business_Permits`,`Building_Permits`,`Excavation_Permits`,`Fencing_Permits`,`TPRS`) values 
(1,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `tbl_excavation_permits` */

DROP TABLE IF EXISTS `tbl_excavation_permits`;

CREATE TABLE `tbl_excavation_permits` (
  `exca_permit_id` int(55) NOT NULL AUTO_INCREMENT,
  `blg_house_no` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `subd` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`exca_permit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_excavation_permits` */

/*Table structure for table `tbl_fencing_permit` */

DROP TABLE IF EXISTS `tbl_fencing_permit`;

CREATE TABLE `tbl_fencing_permit` (
  `fencing_permit_id` int(55) NOT NULL AUTO_INCREMENT,
  `blg/house_no` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `subd` varchar(255) DEFAULT NULL,
  `estate_type` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`fencing_permit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_fencing_permit` */

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
  `tprs_id` int(50) NOT NULL,
  `toda` varchar(255) NOT NULL,
  `route` varchar(255) NOT NULL,
  `platenum` varchar(255) NOT NULL,
  `chasisnum` varchar(255) NOT NULL,
  `makertype` varchar(255) NOT NULL,
  `engine_no` varchar(255) NOT NULL,
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

/*!50106 CREATE DEFINER=`root`@`localhost` EVENT `evt_update_cert_status` ON SCHEDULE EVERY 1 DAY STARTS '2024-09-13 08:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    UPDATE vw_all_documents
    SET `status` = 1
    WHERE `expiration` <= NOW();
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
 `date_issued` date ,
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
 `date_issued` date ,
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
 `date_issued` date ,
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
 `date_issued` date ,
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
 `date_issued` date ,
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
 `date_issued` date ,
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
 `date_issued` date ,
 `is_resident` varchar(12) ,
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
 `date_edited` date ,
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
 `date_issued` date ,
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
 `date_issued` date ,
 `expires` date ,
 `department_issued` varchar(50) ,
 `issued_by` varchar(255) ,
 `status` tinyint(3) ,
 `is_deleted` tinyint(2) 
)*/;

/*Table structure for table `vw_all_nonresident` */

DROP TABLE IF EXISTS `vw_all_nonresident`;

/*!50001 DROP VIEW IF EXISTS `vw_all_nonresident` */;
/*!50001 DROP TABLE IF EXISTS `vw_all_nonresident` */;

/*!50001 CREATE TABLE  `vw_all_nonresident`(
 `nresident_id` int(55) ,
 `img_filename` varchar(255) ,
 `last_name` varchar(255) ,
 `first_name` varchar(255) ,
 `middle_name` varchar(255) ,
 `suffix` varchar(10) ,
 `house_num` varchar(255) ,
 `street` varchar(255) ,
 `subdivision` varchar(255) ,
 `distric_brgy` varchar(255) ,
 `city` varchar(255) ,
 `sex` varchar(55) ,
 `birth_date` date ,
 `contact_num` bigint(50) ,
 `audit_trail_no` int(55) ,
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
 `date_issued` date ,
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
 `date_issued` date ,
 `expiration` date ,
 `purpose` varchar(255) ,
 `age` int(10) ,
 `presented_id` varchar(255) ,
 `ID_number` varchar(255) ,
 `status` tinyint(3) 
)*/;

/*Table structure for table `vw_all_resident` */

DROP TABLE IF EXISTS `vw_all_resident`;

/*!50001 DROP VIEW IF EXISTS `vw_all_resident` */;
/*!50001 DROP TABLE IF EXISTS `vw_all_resident` */;

/*!50001 CREATE TABLE  `vw_all_resident`(
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
 `date_issued` date ,
 `expires` date ,
 `department_issued` varchar(50) ,
 `issued_by` varchar(255) ,
 `status` tinyint(3) ,
 `is_deleted` tinyint(2) 
)*/;

/*View structure for view vw_all_brgy_clearance */

/*!50001 DROP TABLE IF EXISTS `vw_all_brgy_clearance` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_brgy_clearance` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_brgy_clearance` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_num`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_cert_audit_trail`.`date_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from ((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`))) where (`tbl_documents`.`Barangay_Clearance` is not null)) */;

/*View structure for view vw_all_build_permits */

/*!50001 DROP TABLE IF EXISTS `vw_all_build_permits` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_build_permits` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_build_permits` AS (select `tbl_docu_request`.`request_id` AS `request_id`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`last_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`last_name` else NULL end) using utf8mb4)) AS `last_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`first_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`first_name` else NULL end) using utf8mb4)) AS `first_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`middle_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`middle_name` else NULL end) using utf8mb4)) AS `middle_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`suffix` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`suffix` else NULL end) using utf8mb4)) AS `suffix`,(case when (`tbl_docu_request`.`resident_no` is not null) then 'Resident' when (`tbl_docu_request`.`nresident_no` is not null) then 'Non-Resident' else 'Unknown' end) AS `owner_status`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_building_permits`.`blg_house_no` AS `blg_house_no`,`tbl_building_permits`.`street` AS `street`,`tbl_building_permits`.`subd` AS `subd`,`tbl_cert_audit_trail`.`date_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from (((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) join `tbl_building_permits` on((`tbl_documents`.`Building_Permits` = `tbl_building_permits`.`building_permit_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`)))) */;

/*View structure for view vw_all_buss_permits */

/*!50001 DROP TABLE IF EXISTS `vw_all_buss_permits` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_buss_permits` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_buss_permits` AS (select `tbl_docu_request`.`request_id` AS `request_id`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`last_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`last_name` else NULL end) using utf8mb4)) AS `last_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`first_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`first_name` else NULL end) using utf8mb4)) AS `first_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`middle_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`middle_name` else NULL end) using utf8mb4)) AS `middle_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`suffix` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`suffix` else NULL end) using utf8mb4)) AS `suffix`,(case when (`tbl_docu_request`.`resident_no` is not null) then 'Resident' when (`tbl_docu_request`.`nresident_no` is not null) then 'Non-Resident' else 'Unknown' end) AS `owner_status`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_business_permits`.`store_name` AS `store_name`,`tbl_business_permits`.`blg_house_no` AS `blg_house_no`,`tbl_business_permits`.`street` AS `street`,`tbl_business_permits`.`subdivision` AS `subdivision`,`tbl_business_permits`.`type_of_buss` AS `type_of_buss`,`tbl_cert_audit_trail`.`date_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from (((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`Business_Permits`))) join `tbl_business_permits` on((`tbl_documents`.`Business_Permits` = `tbl_business_permits`.`business_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`)))) */;

/*View structure for view vw_all_cgmoral */

/*!50001 DROP TABLE IF EXISTS `vw_all_cgmoral` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_cgmoral` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_cgmoral` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_num`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_cert_audit_trail`.`date_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from ((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`))) where (`tbl_documents`.`Certificate_of_Good_Moral` is not null)) */;

/*View structure for view vw_all_cindigency */

/*!50001 DROP TABLE IF EXISTS `vw_all_cindigency` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_cindigency` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_cindigency` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_num`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_cert_audit_trail`.`date_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from (((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`))) where (`tbl_documents`.`Certificate_of_Indigency` is not null)) */;

/*View structure for view vw_all_cresidency */

/*!50001 DROP TABLE IF EXISTS `vw_all_cresidency` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_cresidency` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_cresidency` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_num`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_cert_audit_trail`.`date_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from ((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`))) where (`tbl_documents`.`Certificate_of_Residency` is not null)) */;

/*View structure for view vw_all_documents */

/*!50001 DROP TABLE IF EXISTS `vw_all_documents` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_documents` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_documents` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`tbl_cert_audit_trail`.`date_issued` AS `date_issued`,(case when (`tbl_docu_request`.`resident_no` is not null) then 'Resident' else 'Non-Resident' end) AS `is_resident`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`resident_id` else `non_resident`.`nresident_id` end) AS `resident/nonres_id`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`last_name` else convert(`non_resident`.`last_name` using utf8mb4) end) AS `last_name`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`first_name` else convert(`non_resident`.`first_name` using utf8mb4) end) AS `first_name`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`middle_name` else convert(`non_resident`.`middle_name` using utf8mb4) end) AS `middle_name`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`suffix` else convert(`non_resident`.`suffix` using utf8mb4) end) AS `suffix`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`house_num` else convert(`non_resident`.`house_num` using utf8mb4) end) AS `house_num`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`street` else convert(`non_resident`.`street` using utf8mb4) end) AS `street`,(case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`subdivision` else convert(`non_resident`.`subdivision` using utf8mb4) end) AS `subdivision`,(case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`city` else 'Caloocan City' end) AS `city`,(case when (`tbl_documents`.`Barangay_Clearance` is not null) then 'Barangay Clearance' when (`tbl_documents`.`Certificate_of_Residency` is not null) then 'Certificate of Residency' when (`tbl_documents`.`Certificate_of_Indigency` is not null) then 'Certificate of Indigency' when (`tbl_documents`.`Certificate_of_Good_Moral` is not null) then 'Certificate of Good Moral' when (`tbl_documents`.`Business_Permits` is not null) then 'Business Permits' when (`tbl_documents`.`Building_Permits` is not null) then 'Building Permits' when (`tbl_documents`.`Excavation_Permits` is not null) then 'Excavation Permits' when (`tbl_documents`.`Fencing_Permits` is not null) then 'Fencing Permits' when (`tbl_documents`.`FTJS` is not null) then 'First Time Job Seekers' when (`tbl_documents`.`Oath_of_Undertaking` is not null) then 'Oath of Undertaking' when (`tbl_documents`.`TPRS` is not null) then 'Tricycle Pedicab Regulatory Services' else 'Unknown Document Type' end) AS `document_desc`,`tbl_docu_request`.`age` AS `age`,`resident`.`sex` AS `sex`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_docu_request`.`pdffile` AS `pdffile`,`tbl_cert_audit_trail`.`expiration` AS `expiration`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted`,`tbl_cert_audit_trail`.`date_edited` AS `date_edited`,`tbl_cert_audit_trail`.`date_deleted` AS `date_deleted` from ((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`)))) */;

/*View structure for view vw_all_exca_permits */

/*!50001 DROP TABLE IF EXISTS `vw_all_exca_permits` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_exca_permits` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_exca_permits` AS (select `tbl_docu_request`.`request_id` AS `request_id`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`last_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`last_name` else NULL end) using utf8mb4)) AS `last_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`first_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`first_name` else NULL end) using utf8mb4)) AS `first_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`middle_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`middle_name` else NULL end) using utf8mb4)) AS `middle_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`suffix` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`suffix` else NULL end) using utf8mb4)) AS `suffix`,(case when (`tbl_docu_request`.`resident_no` is not null) then 'Resident' when (`tbl_docu_request`.`nresident_no` is not null) then 'Non-Resident' else 'Unknown' end) AS `owner_status`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_excavation_permits`.`blg_house_no` AS `blg_house_no`,`tbl_excavation_permits`.`street` AS `street`,`tbl_excavation_permits`.`subd` AS `subd`,`tbl_cert_audit_trail`.`date_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from (((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) join `tbl_excavation_permits` on((`tbl_documents`.`Building_Permits` = `tbl_excavation_permits`.`exca_permit_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`)))) */;

/*View structure for view vw_all_ftjs */

/*!50001 DROP TABLE IF EXISTS `vw_all_ftjs` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_ftjs` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_ftjs` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_num`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_cert_audit_trail`.`date_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from ((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`))) where (`tbl_documents`.`FTJS` is not null)) */;

/*View structure for view vw_all_nonresident */

/*!50001 DROP TABLE IF EXISTS `vw_all_nonresident` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_nonresident` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_nonresident` AS (select `non_resident`.`nresident_id` AS `nresident_id`,`non_resident`.`img_filename` AS `img_filename`,`non_resident`.`last_name` AS `last_name`,`non_resident`.`first_name` AS `first_name`,`non_resident`.`middle_name` AS `middle_name`,`non_resident`.`suffix` AS `suffix`,`non_resident`.`house_num` AS `house_num`,`non_resident`.`street` AS `street`,`non_resident`.`subdivision` AS `subdivision`,`non_resident`.`distric_brgy` AS `distric_brgy`,`non_resident`.`city` AS `city`,`non_resident`.`sex` AS `sex`,`non_resident`.`birth_date` AS `birth_date`,`non_resident`.`contact_num` AS `contact_num`,`non_resident`.`audit_trail_no` AS `audit_trail_no`,`non_resident`.`is_deleted` AS `is_deleted` from (`non_resident` join `nonres_audit_trail` on((`non_resident`.`audit_trail_no` = `nonres_audit_trail`.`audit_trail_id`)))) */;

/*View structure for view vw_all_out */

/*!50001 DROP TABLE IF EXISTS `vw_all_out` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_out` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_out` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_no`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_cert_audit_trail`.`date_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from ((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`))) where (`tbl_documents`.`Oath_of_Undertaking` is not null)) */;

/*View structure for view vw_all_res_cert */

/*!50001 DROP TABLE IF EXISTS `vw_all_res_cert` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_res_cert` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_res_cert` AS (select `tbl_docu_request`.`request_id` AS `request_id`,`tbl_docu_request`.`resident_no` AS `resident_no`,(case when (`tbl_documents`.`Barangay_Clearance` is not null) then 'Barangay Clearance' when (`tbl_documents`.`Certificate_of_Residency` is not null) then 'Certificate of Residency' when (`tbl_documents`.`Certificate_of_Indigency` is not null) then 'Certificate of Indigency' when (`tbl_documents`.`Certificate_of_Good_Moral` is not null) then 'Certificate of Good Moral' when (`tbl_documents`.`FTJS` is not null) then 'First Time Job Seeker' when (`tbl_documents`.`Oath_of_Undertaking` is not null) then 'Oath of Undertaking' when (`tbl_documents`.`Business_Permits` is not null) then 'Business Permits' when (`tbl_documents`.`Building_Permits` is not null) then 'Building Permits' when (`tbl_documents`.`Fencing_Permits` is not null) then 'Fencing Permit' when (`tbl_documents`.`Excavation_Permits` is not null) then 'Excavation Permit' when (`tbl_documents`.`Certificate_of_Indigency` is not null) then 'Tricycle Pedecab Regulatory Services' else 'Unknown' end) AS `cert_type`,`tbl_cert_audit_trail`.`date_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expiration`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`status` AS `status` from (((`tbl_docu_request` join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`)))) */;

/*View structure for view vw_all_resident */

/*!50001 DROP TABLE IF EXISTS `vw_all_resident` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_resident` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_resident` AS (select `resident`.`resident_id` AS `resident_id`,`res_audit_trail`.`date_added` AS `date_recorded`,`resident`.`img_filename` AS `img_filename`,`resident`.`last_name` AS `last_name`,`resident`.`first_name` AS `first_name`,`resident`.`middle_name` AS `middle_name`,`resident`.`suffix` AS `suffix`,`resident`.`house_num` AS `house_num`,`resident`.`street` AS `street`,`resident`.`subdivision` AS `subdivision`,`resident`.`resident_since` AS `resident_since`,`resident`.`sex` AS `sex`,`resident`.`marital_status` AS `marital_status`,`resident`.`birth_date` AS `birth_date`,`resident`.`birth_place` AS `birth_place`,`resident`.`cellphone_num` AS `cellphone_num`,`resident`.`is_a_voter` AS `is_a_voter`,`resident`.`is_deleted` AS `is_deleted` from (`resident` join `res_audit_trail` on((`resident`.`audit_trail` = `res_audit_trail`.`res_at_id`))) where (`resident`.`is_deleted` = 0)) */;

/*View structure for view vw_all_tprs */

/*!50001 DROP TABLE IF EXISTS `vw_all_tprs` */;
/*!50001 DROP VIEW IF EXISTS `vw_all_tprs` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_all_tprs` AS (select `tbl_docu_request`.`request_id` AS `request_id`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`last_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`last_name` else NULL end) using utf8mb4)) AS `last_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`first_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`first_name` else NULL end) using utf8mb4)) AS `first_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`middle_name` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`middle_name` else NULL end) using utf8mb4)) AS `middle_name`,coalesce((case when (`tbl_docu_request`.`resident_no` is not null) then `resident`.`suffix` else NULL end),convert((case when (`tbl_docu_request`.`nresident_no` is not null) then `non_resident`.`suffix` else NULL end) using utf8mb4)) AS `suffix`,(case when (`tbl_docu_request`.`resident_no` is not null) then 'Resident' when (`tbl_docu_request`.`nresident_no` is not null) then 'Non-Resident' else 'Unknown' end) AS `owner_status`,`tbl_docu_request`.`age` AS `age`,`tbl_docu_request`.`presented_id` AS `presented_id`,`tbl_docu_request`.`ID_number` AS `ID_number`,`tbl_docu_request`.`purpose` AS `purpose`,`tbl_tprs`.`toda` AS `toda`,`tbl_tprs`.`route` AS `route`,`tbl_tprs`.`platenum` AS `platenum`,`tbl_tprs`.`chasisnum` AS `chasisnum`,`tbl_tprs`.`makertype` AS `makertype`,`tbl_tprs`.`engine_no` AS `engine_no`,`tbl_cert_audit_trail`.`date_issued` AS `date_issued`,`tbl_cert_audit_trail`.`expiration` AS `expires`,`departments_list`.`department_desc` AS `department_issued`,`tbl_username`.`username` AS `issued_by`,`tbl_docu_request`.`status` AS `status`,`tbl_docu_request`.`is_deleted` AS `is_deleted` from (((((((`tbl_docu_request` left join `resident` on((`tbl_docu_request`.`resident_no` = `resident`.`resident_id`))) left join `non_resident` on((`tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`))) left join `tbl_documents` on((`tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`))) join `tbl_tprs` on((`tbl_documents`.`Building_Permits` = `tbl_tprs`.`tprs_id`))) left join `tbl_cert_audit_trail` on((`tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`))) left join `departments_list` on((`tbl_cert_audit_trail`.`issuing_dept_no` = `departments_list`.`department_id`))) left join `tbl_username` on((`tbl_cert_audit_trail`.`issued_by_no` = `tbl_username`.`username_id`)))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
