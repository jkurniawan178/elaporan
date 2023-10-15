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
  `tgl_elitigasi` date DEFAULT NULL,
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

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
