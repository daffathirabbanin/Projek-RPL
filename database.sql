-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: rpl_mi_nurulikhlas
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `data_ayah`
--

DROP TABLE IF EXISTS `data_ayah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_ayah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nama_ayah` varchar(150) DEFAULT NULL,
  `nik_ayah` varchar(20) DEFAULT NULL,
  `tahun_lahir_ayah` year(4) DEFAULT NULL,
  `pendidikan_ayah` varchar(50) DEFAULT NULL,
  `pekerjaan_ayah` varchar(100) DEFAULT NULL,
  `penghasilan_bulanan_ayah` varchar(50) DEFAULT NULL,
  `kebutuhan_khusus_ayah` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `data_ayah_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_ayah`
--

LOCK TABLES `data_ayah` WRITE;
/*!40000 ALTER TABLE `data_ayah` DISABLE KEYS */;
INSERT INTO `data_ayah` VALUES (2,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,7,'xxxx','xxxxx',2006,'SMA/SMK','xxxx','<1jt',''),(6,8,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,11,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `data_ayah` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_ibu`
--

DROP TABLE IF EXISTS `data_ibu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_ibu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nama_ibu` varchar(150) DEFAULT NULL,
  `nik_ibu` varchar(20) DEFAULT NULL,
  `tahun_lahir_ibu` year(4) DEFAULT NULL,
  `pendidikan_ibu` varchar(50) DEFAULT NULL,
  `pekerjaan_ibu` varchar(100) DEFAULT NULL,
  `penghasilan_bulanan_ibu` varchar(50) DEFAULT NULL,
  `kebutuhan_khusus_ibu` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `data_ibu_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_ibu`
--

LOCK TABLES `data_ibu` WRITE;
/*!40000 ALTER TABLE `data_ibu` DISABLE KEYS */;
INSERT INTO `data_ibu` VALUES (2,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,7,'xxxx','xxx',2001,'S1','xxx','1-3jt',''),(6,8,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,11,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `data_ibu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_kontak`
--

DROP TABLE IF EXISTS `data_kontak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_kontak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `notlp_rumah` varchar(20) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `data_kontak_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_kontak`
--

LOCK TABLES `data_kontak` WRITE;
/*!40000 ALTER TABLE `data_kontak` DISABLE KEYS */;
INSERT INTO `data_kontak` VALUES (2,3,NULL,NULL,NULL),(3,4,NULL,NULL,NULL),(5,7,'09098','000000','andikadaffafathirabbani@gmail.com'),(6,8,NULL,NULL,NULL),(7,11,NULL,NULL,NULL);
/*!40000 ALTER TABLE `data_kontak` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_periodik`
--

DROP TABLE IF EXISTS `data_periodik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_periodik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tinggi_badan` decimal(5,2) DEFAULT NULL,
  `berat_badan` decimal(5,2) DEFAULT NULL,
  `lingkar_kepala` decimal(5,2) DEFAULT NULL,
  `jarak_tempat_tinggal` enum('kurang_dari_1_km','lebih_dari_1_km') DEFAULT NULL,
  `jarak_km` decimal(6,2) DEFAULT NULL,
  `waktu_jam` int(11) DEFAULT 0,
  `waktu_menit` int(11) DEFAULT 0,
  `jumlah_saudara_kandung` int(11) DEFAULT 0,
  `asal_sekolah` varchar(200) DEFAULT NULL,
  `jenis_sekolah_asal` enum('TK','PAUD','Lainnya') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `data_periodik_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_periodik`
--

LOCK TABLES `data_periodik` WRITE;
/*!40000 ALTER TABLE `data_periodik` DISABLE KEYS */;
INSERT INTO `data_periodik` VALUES (2,3,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL),(3,4,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL),(5,7,195.00,70.00,21.00,'kurang_dari_1_km',1.00,1,1,2,NULL,NULL),(6,8,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL),(7,11,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL);
/*!40000 ALTER TABLE `data_periodik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_pribadi`
--

DROP TABLE IF EXISTS `data_pribadi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_pribadi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nama_lengkap` varchar(150) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `no_kk` varchar(20) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `kewarganegaraan` varchar(30) DEFAULT 'WNI',
  `alamat_jalan` text DEFAULT NULL,
  `rt` varchar(5) DEFAULT NULL,
  `rw` varchar(5) DEFAULT NULL,
  `dusun` varchar(100) DEFAULT NULL,
  `kelurahan` varchar(100) DEFAULT NULL,
  `kecamatan` varchar(100) DEFAULT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `lintang` varchar(50) DEFAULT NULL,
  `bujur` varchar(50) DEFAULT NULL,
  `tempat_tinggal` varchar(50) DEFAULT NULL,
  `moda_transportasi` varchar(50) DEFAULT NULL,
  `anak_ke` int(11) DEFAULT NULL,
  `pekerjaan` varchar(100) DEFAULT NULL,
  `punya_kip` enum('ya','tidak') DEFAULT 'tidak',
  `status_kip` varchar(50) DEFAULT NULL,
  `alasan_tolak_pip` text DEFAULT NULL,
  `status_daftar` enum('menunggu','diterima','ditolak') DEFAULT 'menunggu',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `data_pribadi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_pribadi`
--

LOCK TABLES `data_pribadi` WRITE;
/*!40000 ALTER TABLE `data_pribadi` DISABLE KEYS */;
INSERT INTO `data_pribadi` VALUES (2,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'WNI',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'tidak',NULL,NULL,'menunggu'),(3,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'WNI',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'tidak',NULL,NULL,'menunggu'),(5,7,'Andika Daffa fathi rabbani','L','231011402403','1234567891234567','3302201001050001','jakarta','2026-05-03','WNI','lentera','06','07','sradidi','suradita','cisauk','15343',NULL,NULL,'Bersama Orang Tua','Jalan Kaki',2,NULL,'tidak',NULL,NULL,'menunggu'),(6,8,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'WNI',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'tidak',NULL,NULL,'menunggu'),(7,11,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'WNI',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'tidak',NULL,NULL,'menunggu');
/*!40000 ALTER TABLE `data_pribadi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_wali`
--

DROP TABLE IF EXISTS `data_wali`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_wali` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nama_wali` varchar(150) DEFAULT NULL,
  `nik_wali` varchar(20) DEFAULT NULL,
  `tahun_lahir_wali` year(4) DEFAULT NULL,
  `pendidikan_wali` varchar(50) DEFAULT NULL,
  `pekerjaan_wali` varchar(100) DEFAULT NULL,
  `penghasilan_bulanan_wali` varchar(50) DEFAULT NULL,
  `kebutuhan_khusus_wali` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `data_wali_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_wali`
--

LOCK TABLES `data_wali` WRITE;
/*!40000 ALTER TABLE `data_wali` DISABLE KEYS */;
INSERT INTO `data_wali` VALUES (2,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,7,'','',0000,'','','',''),(6,8,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,11,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `data_wali` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dokumen`
--

DROP TABLE IF EXISTS `dokumen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dokumen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `kk` varchar(255) DEFAULT NULL,
  `akta` varchar(255) DEFAULT NULL,
  `ijazah` varchar(255) DEFAULT NULL,
  `foto_3x4` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `dokumen_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dokumen`
--

LOCK TABLES `dokumen` WRITE;
/*!40000 ALTER TABLE `dokumen` DISABLE KEYS */;
INSERT INTO `dokumen` VALUES (2,3,NULL,NULL,NULL,NULL,'2026-05-21 18:21:24'),(3,4,NULL,NULL,NULL,NULL,'2026-05-22 03:45:23'),(5,8,'uploads/dokumen/8_kk_1779447664.pdf',NULL,NULL,NULL,'2026-05-22 11:01:04'),(6,7,'uploads/dokumen/7_kk_1779580620.pdf','uploads/dokumen/7_akta_1779580620.pdf','uploads/dokumen/7_ijazah_1779580620.pdf','uploads/dokumen/7_foto_3x4_1779580620.jpeg','2026-05-23 23:57:00'),(7,11,NULL,NULL,NULL,NULL,'2026-05-25 13:27:30');
/*!40000 ALTER TABLE `dokumen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pendaftaran`
--

DROP TABLE IF EXISTS `pendaftaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pendaftaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status` enum('belum_mendaftar','nunggu_verifikasi','dokumen_diterima','diterima','ditolak','perlu_revisi','nunggu_pengumuman') DEFAULT 'belum_mendaftar',
  `catatan` text DEFAULT NULL,
  `revisi_json` text DEFAULT NULL,
  `jadwal_tes` date DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `pendaftaran_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pendaftaran`
--

LOCK TABLES `pendaftaran` WRITE;
/*!40000 ALTER TABLE `pendaftaran` DISABLE KEYS */;
INSERT INTO `pendaftaran` VALUES (2,3,'belum_mendaftar',NULL,NULL,NULL,'2026-05-21 18:21:24','2026-05-21 18:21:24'),(3,4,'belum_mendaftar',NULL,NULL,NULL,'2026-05-22 03:45:23','2026-05-22 03:45:23'),(5,8,'belum_mendaftar',NULL,NULL,NULL,'2026-05-22 10:31:37','2026-05-22 10:31:37'),(6,7,'diterima','',NULL,'2026-05-24 09:05:41','2026-05-23 23:50:06','2026-05-24 09:05:41'),(7,11,'belum_mendaftar',NULL,NULL,NULL,'2026-05-25 13:27:30','2026-05-25 13:27:30');
/*!40000 ALTER TABLE `pendaftaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `setting_key` varchar(50) NOT NULL,
  `setting_value` varchar(255) NOT NULL,
  PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES ('gelombang_aktif','3'),('jadwal_g1_daftar','01 Januari - 23 Maret 2026'),('jadwal_g1_hasil','28 Maret 2026'),('jadwal_g1_nama','Gelombang 1'),('jadwal_g1_sosial','24 Maret 2026'),('jadwal_g2_daftar','01 April - 27 Mei 2026'),('jadwal_g2_hasil','01 Juni 2026'),('jadwal_g2_nama','Gelombang 2'),('jadwal_g2_sosial','28 Mei 2026'),('jadwal_g3_daftar','15 Juni - 30 Juni 2026'),('jadwal_g3_hasil','05 Juli 2026'),('jadwal_g3_nama','Gelombang 3'),('jadwal_g3_sosial','01 Juli 2026'),('kuota_pendaftaran','200'),('release_announcement_datetime','');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (3,'Andika Daffa fathi rabbani','ac@mail.com',NULL,'$2y$10$aLCJ5gwo6YnpSPRR.58z7u1MLy60HofT9XlYztairoKUU6ybgbRCa','user','2026-05-21 18:21:24'),(4,'Andika daffa fathi rabbani',' v  ',NULL,'$2y$10$cTwb9kP99RnHIU1aQ2qiTOE5pryfZIlznpxMMEWBeBQfgWAEK9eFC','user','2026-05-22 03:45:23'),(6,'Andika Daffa fathi rabbani','231011402403@gmail.com',NULL,'$2y$10$huGyTLLkzpIZzM.Mar6FEOVzi2DOW.HedBvBpNjT4/6B4JgbFYeyG','admin','2026-05-22 09:29:10'),(7,'Andika Daffa fathi rabbani','andikadaffafathirabbani@gmail.com',NULL,'$2y$10$JLLBmR4yd1XLQrEH9nxS9.2Bx1YOjYQuIdKgkPkPLQL0dutSAmke6','user','2026-05-22 10:29:48'),(8,'daffa','123@gmail.com',NULL,'$2y$10$lpTtTi/EYfqWeh1GDr1n7eo4Wj6qn1QoCrxfCxtbgAEDXtRXulfK2','user','2026-05-22 10:31:37'),(9,'abi','abi@gmail.com',NULL,'$2y$10$hH.tEVRNjm4Q6xWn/452CO3A9qn0fy7TN5.FTbT.2fSTRfnFgKBXW','admin','2026-05-25 13:25:07'),(10,'rava','rava@gmail.com',NULL,'$2y$10$anjr8QIgcwdR1FCgu.9kgupExhCEKPfV/aJY/n5PD059KEs.kMtkS','admin','2026-05-25 13:25:40'),(11,'daff','daff@gmail.com',NULL,'$2y$10$APRe7Wpnb/56Ptn5bbey0efeZvcMiZhIlBd3oiAObaeUUW2zWoTlm','user','2026-05-25 13:27:30');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-25 21:14:00
