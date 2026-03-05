db_surat_desarukunrukun-- MySQL dump 10.13  Distrib 8.0.31, for macos12 (x86_64)
--
-- Host: localhost    Database: db_surat_desa
-- ------------------------------------------------------
-- Server version	8.0.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `document_log`
--

DROP TABLE IF EXISTS `document_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `document_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `detail` json NOT NULL,
  `doc_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `local_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document_log`
--

LOCK TABLES `document_log` WRITE;
/*!40000 ALTER TABLE `document_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `family`
--

DROP TABLE IF EXISTS `family`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `family` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `no_kk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rt_id` bigint unsigned NOT NULL,
  `rw_id` bigint unsigned NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `family_head_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `family_no_kk_unique` (`no_kk`),
  KEY `family_rt_id_foreign` (`rt_id`),
  KEY `family_rw_id_foreign` (`rw_id`),
  KEY `family_family_head_id_foreign` (`family_head_id`),
  CONSTRAINT `family_family_head_id_foreign` FOREIGN KEY (`family_head_id`) REFERENCES `warga` (`id`) ON DELETE SET NULL,
  CONSTRAINT `family_rt_id_foreign` FOREIGN KEY (`rt_id`) REFERENCES `rukun` (`id`) ON DELETE CASCADE,
  CONSTRAINT `family_rw_id_foreign` FOREIGN KEY (`rw_id`) REFERENCES `rukun` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `family`
--

LOCK TABLES `family` WRITE;
/*!40000 ALTER TABLE `family` DISABLE KEYS */;
/*!40000 ALTER TABLE `family` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jabatan`
--

DROP TABLE IF EXISTS `jabatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jabatan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jabatan_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jabatan`
--

LOCK TABLES `jabatan` WRITE;
/*!40000 ALTER TABLE `jabatan` DISABLE KEYS */;
INSERT INTO `jabatan` VALUES (1,'Administrator','administrator','Admin sistem','2026-02-09 02:24:56','2026-02-09 02:24:56'),(2,'Kepala Lurah','kepala_lurah','Kepala Lurah dengan akses view/lihat arsip surat dan laporan warga. Dapat melihat semua data tapi tidak bisa edit atau hapus.','2026-02-10 01:04:32','2026-02-10 01:04:32'),(3,'Sekretaris Lurah','sekre_lurah','Sekretaris Lurah yang mengelola surat. Bisa edit format/isi surat, impor data warga, tapi tidak bisa hapus/delete warga dan tidak bisa mengatur template surat.','2026-02-10 01:04:32','2026-02-10 01:04:32'),(4,'Staff Pelayanan Umum','staff_pelayanan','Staff yang melayani warga untuk pembuatan surat. Bisa membuat surat untuk warga, input data pemohon, dan cetak surat.','2026-02-10 01:04:32','2026-02-10 01:04:32');
/*!40000 ALTER TABLE `jabatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lurah_config`
--

DROP TABLE IF EXISTS `lurah_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lurah_config` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pos_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lurah_config`
--

LOCK TABLES `lurah_config` WRITE;
/*!40000 ALTER TABLE `lurah_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `lurah_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2026_02_09_030528_create_jabatans_table',1),(2,'2026_02_09_030600_create_users_table',1),(3,'2026_02_09_031926_create_user_details_table',1),(4,'2026_02_09_085617_create_rukun_table',1),(5,'2026_02_09_085706_create_family_table',1),(6,'2026_02_09_085738_create_warga_table',1),(7,'2026_02_09_091032_add_family_head_to_family_table',1),(8,'2026_02_09_092922_create_lurah_config_table',2),(9,'2026_02_09_092950_create_document_log_table',2),(10,'2026_02_11_010255_add_name_to_user_detail_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rukun`
--

DROP TABLE IF EXISTS `rukun`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rukun` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('RT','RW') COLLATE utf8mb4_unicode_ci NOT NULL,
  `no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rukun`
--

LOCK TABLES `rukun` WRITE;
/*!40000 ALTER TABLE `rukun` DISABLE KEYS */;
INSERT INTO `rukun` VALUES (1,'RT','001','2026-02-11 05:28:42','2026-02-11 05:28:42'),(3,'RW','001','2026-02-11 05:42:11','2026-02-11 05:42:11'),(4,'RT','002','2026-02-12 03:16:10','2026-02-12 03:16:24');
/*!40000 ALTER TABLE `rukun` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_detail`
--

DROP TABLE IF EXISTS `user_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_detail` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_detail_user_id_foreign` (`user_id`),
  CONSTRAINT `user_detail_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_detail`
--

LOCK TABLES `user_detail` WRITE;
/*!40000 ALTER TABLE `user_detail` DISABLE KEYS */;
INSERT INTO `user_detail` VALUES (3,'77674548989','Inggar','45678677','kjhgxfzdzghjkg','2007-07-07','456786567858','active',9,'2026-02-12 01:55:36','2026-02-12 01:55:36');
/*!40000 ALTER TABLE `user_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_jabatan_id_foreign` (`jabatan_id`),
  CONSTRAINT `users_jabatan_id_foreign` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin@pemantapan2.com','$2y$12$ziJpjAL4NvMx4wGc5/uRHumwe2ngf9kzxhHuWlhZ5pFi98oXOc7Gi',1,'2026-02-09 02:24:57','2026-02-09 02:24:57'),(9,'staff@pemantapan2.com','$2y$12$L7Jd3kU2veFh0TVwPuASdetfDdta1lLSO8Oe4ZZKW.P61m8m8ZIpK',4,'2026-02-12 01:55:36','2026-02-12 01:55:36');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `warga`
--

DROP TABLE IF EXISTS `warga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `warga` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_kk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `religious` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `education` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `living_status` enum('hidup','meninggal','pindah','tidak_diketeahui') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hidup',
  `married_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `occupation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `warga_nik_unique` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warga`
--

LOCK TABLES `warga` WRITE;
/*!40000 ALTER TABLE `warga` DISABLE KEYS */;
/*!40000 ALTER TABLE `warga` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-12 17:39:08
