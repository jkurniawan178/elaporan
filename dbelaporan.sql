/*
SQLyog Ultimate
MySQL - 10.3.38-MariaDB-log : Database - dbelaporan
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dbelaporan` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;

USE `dbelaporan`;

/*Table structure for table `elaporan_lipa` */

DROP TABLE IF EXISTS `elaporan_lipa`;

CREATE TABLE `elaporan_lipa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_jenis_laporan` int(11) NOT NULL,
  `jenis_laporan` varchar(100) NOT NULL,
  `periode_bulan` varchar(50) NOT NULL,
  `periode_tahun` varchar(200) NOT NULL,
  `tanggal_laporan` date NOT NULL,
  `edoc_excel` varchar(200) NOT NULL,
  `edoc_pdf` varchar(200) NOT NULL,
  `validasi_panitera` date NOT NULL,
  `validasi_ketua` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `elaporan_lipa_14` */

DROP TABLE IF EXISTS `elaporan_lipa_14`;

CREATE TABLE `elaporan_lipa_14` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bulan` varchar(10) NOT NULL,
  `tahun` varchar(10) NOT NULL,
  `realisasi` decimal(10,0) DEFAULT NULL,
  `jml_kegiatan` int(11) DEFAULT NULL,
  `jml_perkara` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `elaporan_lipa_15` */

DROP TABLE IF EXISTS `elaporan_lipa_15`;

CREATE TABLE `elaporan_lipa_15` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bulan` varchar(10) NOT NULL,
  `tahun` varchar(10) NOT NULL,
  `realisasi` decimal(10,0) DEFAULT NULL,
  `jml_perkara` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `elaporan_lipa_16` */

DROP TABLE IF EXISTS `elaporan_lipa_16`;

CREATE TABLE `elaporan_lipa_16` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bulan` varchar(10) NOT NULL,
  `tahun` varchar(10) NOT NULL,
  `realisasi` decimal(10,0) DEFAULT NULL,
  `jml_layanan` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `elaporan_lipa_24` */

DROP TABLE IF EXISTS `elaporan_lipa_24`;

CREATE TABLE `elaporan_lipa_24` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `perkara_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `elaporan_pagu_14` */

DROP TABLE IF EXISTS `elaporan_pagu_14`;

CREATE TABLE `elaporan_pagu_14` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tahun_anggaran` varchar(10) NOT NULL,
  `pagu_awal` decimal(10,0) NOT NULL,
  `pagu_revisi` decimal(10,0) DEFAULT NULL,
  `target_lokasi` int(11) NOT NULL,
  `target_kegiatan` int(11) NOT NULL,
  `target_perkara` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tahun_anggaran` (`tahun_anggaran`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `elaporan_pagu_15` */

DROP TABLE IF EXISTS `elaporan_pagu_15`;

CREATE TABLE `elaporan_pagu_15` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tahun_anggaran` varchar(10) NOT NULL,
  `pagu_awal` decimal(10,0) NOT NULL,
  `pagu_revisi` decimal(10,0) DEFAULT NULL,
  `target_perkara` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `elaporan_pagu_16` */

DROP TABLE IF EXISTS `elaporan_pagu_16`;

CREATE TABLE `elaporan_pagu_16` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tahun_anggaran` varchar(10) NOT NULL,
  `pagu_awal` decimal(10,0) NOT NULL,
  `pagu_revisi` decimal(10,0) DEFAULT NULL,
  `target_layanan` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `elaporan_saldo_awal` */

DROP TABLE IF EXISTS `elaporan_saldo_awal`;

CREATE TABLE `elaporan_saldo_awal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` varchar(10) NOT NULL,
  `saldo_awal_7a` decimal(10,0) NOT NULL,
  `saldo_awal_7b` decimal(10,0) NOT NULL,
  `saldo_awal_7c` decimal(10,0) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `jenis_laporan` */

DROP TABLE IF EXISTS `jenis_laporan`;

CREATE TABLE `jenis_laporan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_laporan` varchar(50) NOT NULL,
  `nama_laporan` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `jenis_laporan` */

insert  into `jenis_laporan`(`id`,`jenis_laporan`,`nama_laporan`) values 
(1,'lipa_1','LAPORAN KEADAAN PERKARA (LIPA.1)'),
(2,'lipa_2','LAPORAN PERKARA YANG DIMOHONKAN BANDING (LIPA.2)'),
(3,'lipa_3','LAPORAN YANG DIMOHONKAN KASASI (LIPA.3)'),
(4,'lipa_4','LAPORAN PERKARA YANG DIMOHONKAN PENINJAUAN KEMBALI (LIPA.4)'),
(5,'lipa_5','LAPORAN PERKARA YANG DIMOHONKAN EKSEKUSI (LIPA.5)'),
(6,'lipa_6','LAPORAN KEGIATAN HAKIM (LIPA.6)'),
(7,'lipa_7_a','LAPORAN KEUANGAN PERKARA (LIPA.7.A)'),
(8,'lipa_7_b','LAPORAN KEUANGAN PERKARA EKSEKUSI (LIPA.7.B)'),
(9,'lipa_7_c','LAPORAN KEUANGAN PERKARA KONSIGNASI(LIPA.7.C)'),
(10,'lipa_8','LAPORAN PERKARA DITERIMA, DICABUT DAN DIPUTUS MENURUT JENIS PERKARA (LIPA.8)'),
(11,'lipa_9','LAPORAN PERKARA KHUSUS PP. NO.10 TAHUN 1983 JO. PP. NO.45 TAHUN 1990 (LIPA.9)'),
(12,'lipa_10','LAPORAN PENYEBAB TERJADINYA PERCERAIAN (LIPA.10)'),
(13,'lipa_11','LAPORAN PERTANGGUNGJAWABAN UANG IWADL (LIPA.11)'),
(14,'lipa_12','LAPORAN MEDIASI (LIPA.12)'),
(15,'lipa_13','LAPORAN PENERBITAN AKTA CERAI (LIPA.13)'),
(16,'lipa_14','LAPORAN SIDANG DILUAR GEDUNG (LIPA.14)'),
(17,'lipa_15','LAPORAN PELAKSANAAN PEMBEBASAN BIAYA PERKARA (LIPA.15)'),
(18,'lipa_16','LAPORAN PELAKSANAAN POSYANKUM (LIPA.16)'),
(19,'lipa_17','LAPORAN PENERIMAAN HAK-HAK KEPANITERAAN (HHK) (LIPA.17)'),
(20,'lipa_18','LAPORAN PENERIMAAN HAK-HAK KEPANITERAAN LAINNYA (HHKL) (LIPA.18)'),
(21,'lipa_19','LAPORAN MINUTASI PERKARA (LIPA.19)'),
(22,'lipa_20','LAPORAN TINGKAT PENYELESAIAN PERKARA (LIPA.20)'),
(23,'lipa_21','LAPORAN VERZET TERHADAP PUTUSAN VERSTEK (LIPA.21)'),
(24,'lipa_22','LAPORAN PENANGANAN BANTUAN PANGGILAN ATAU PEMBERITAHUAN (LIPA.22)'),
(25,'lipa_23','LAPORAN (LIPA.23)'),
(26,'lipa_24','LAPORAN (LIPA.24)');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
