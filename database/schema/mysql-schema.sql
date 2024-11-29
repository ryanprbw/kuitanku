/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `role` enum('super_admin','admin_bidang','staff') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'staff',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admins_user_id_foreign` (`user_id`),
  CONSTRAINT `admins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bendaharas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bendaharas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` char(18) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bidangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bidangs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_bidang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bidangs_nama_bidang_unique` (`nama_bidang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `detail_belanjas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_belanjas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sub_rincian_belanjas_id` bigint(20) unsigned NOT NULL,
  `nama_detail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detail_belanjas_sub_rincian_belanjas_id_foreign` (`sub_rincian_belanjas_id`),
  CONSTRAINT `detail_belanjas_sub_rincian_belanjas_id_foreign` FOREIGN KEY (`sub_rincian_belanjas_id`) REFERENCES `sub_rincian_belanjas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `kegiatans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kegiatans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `program_id` bigint(20) unsigned NOT NULL,
  `bidang_id` bigint(20) unsigned NOT NULL,
  `nama_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggaran` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kegiatans_programs_id_foreign` (`program_id`) USING BTREE,
  KEY `kegiatans_bidang_id_foreign` (`bidang_id`),
  CONSTRAINT `kegiatans_bidang_id_foreign` FOREIGN KEY (`bidang_id`) REFERENCES `bidangs` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `kegiatans_programs_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `kepala_dinas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kepala_dinas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` char(18) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `kode_rekening_bidangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kode_rekening_bidangs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_rekenings_id` bigint(20) unsigned NOT NULL,
  `bidang_id` bigint(20) unsigned NOT NULL,
  `anggaran` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kode_rekening_bidangs_kode_rekenings_id_foreign` (`kode_rekenings_id`),
  KEY `kode_rekening_bidangs_bidang_id_foreign` (`bidang_id`),
  CONSTRAINT `kode_rekening_bidangs_bidang_id_foreign` FOREIGN KEY (`bidang_id`) REFERENCES `bidangs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `kode_rekening_bidangs_kode_rekenings_id_foreign` FOREIGN KEY (`kode_rekenings_id`) REFERENCES `kode_rekenings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `kode_rekenings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kode_rekenings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_kode_rekening` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggaran` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `sub_kegiatan_id` bigint(20) unsigned DEFAULT NULL,
  `bidang_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kode_rekenings_sub_kegiatan_id_foreign` (`sub_kegiatan_id`),
  KEY `kode_rekenings_bidang_id_foreign` (`bidang_id`),
  CONSTRAINT `kode_rekenings_bidang_id_foreign` FOREIGN KEY (`bidang_id`) REFERENCES `bidangs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `kode_rekenings_sub_kegiatan_id_foreign` FOREIGN KEY (`sub_kegiatan_id`) REFERENCES `sub_kegiatans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pegawais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pegawais` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nip` char(18) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pangkat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_rekening` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_bank` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bidang_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pegawais_bidang_id_foreign` (`bidang_id`),
  CONSTRAINT `pegawais_bidang_id_foreign` FOREIGN KEY (`bidang_id`) REFERENCES `bidangs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pptks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pptks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bidang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `skpd_id` bigint(20) unsigned NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggaran` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bidang_id` bigint(20) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `programs_skpd_id_foreign` (`skpd_id`),
  KEY `programs_bidang_id_foreign` (`bidang_id`),
  CONSTRAINT `programs_bidang_id_foreign` FOREIGN KEY (`bidang_id`) REFERENCES `bidangs` (`id`) ON DELETE SET NULL,
  CONSTRAINT `programs_skpd_id_foreign` FOREIGN KEY (`skpd_id`) REFERENCES `skpds` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `rincian_belanja_umums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rincian_belanja_umums` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_rekening_id` bigint(20) unsigned NOT NULL,
  `program_id` bigint(20) unsigned NOT NULL,
  `kegiatan_id` bigint(20) unsigned NOT NULL,
  `sub_kegiatan_id` bigint(20) unsigned NOT NULL,
  `kepala_dinas_id` bigint(20) unsigned NOT NULL,
  `pptk_id` bigint(20) unsigned NOT NULL,
  `bendahara_id` bigint(20) unsigned NOT NULL,
  `penerima_id` bigint(20) unsigned NOT NULL,
  `bidang_id` bigint(20) unsigned DEFAULT NULL,
  `anggaran` decimal(15,0) NOT NULL,
  `terbilang_rupiah` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Terbilang uang dalam teks',
  `untuk_pengeluaran` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sebesar` decimal(15,0) DEFAULT NULL COMMENT 'Jumlah uang yang diinput untuk perhitungan bruto',
  `bruto` decimal(15,0) DEFAULT NULL COMMENT 'Bruto yang sama dengan sebesar',
  `dpp` decimal(15,0) DEFAULT NULL COMMENT 'Dasar Pengenaan Pajak',
  `pph21` decimal(15,0) DEFAULT NULL COMMENT 'PPh Pasal 21',
  `pph22` decimal(15,0) DEFAULT NULL COMMENT 'PPh Pasal 22',
  `pph23` decimal(15,0) DEFAULT NULL COMMENT 'PPh Pasal 23',
  `pbjt` decimal(15,0) DEFAULT NULL COMMENT 'Pajak Barang dan Jasa (10% dari DPP)',
  `total_pajak` decimal(15,0) DEFAULT NULL,
  `netto` decimal(15,0) DEFAULT NULL COMMENT 'Nilai netto setelah pajak dikurangi dari pengeluaran',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `rincian_belanja_umum_kode_rekening_id_foreign` (`kode_rekening_id`),
  KEY `rincian_belanja_umum_kepala_dinas_id_foreign` (`kepala_dinas_id`),
  KEY `rincian_belanja_umum_pptk_id_foreign` (`pptk_id`),
  KEY `rincian_belanja_umum_bendahara_id_foreign` (`bendahara_id`),
  KEY `rincian_belanja_umum_penerima_id_foreign` (`penerima_id`),
  KEY `rincian_belanja_umums_program_id_foreign` (`program_id`),
  KEY `rincian_belanja_umums_kegiatan_id_foreign` (`kegiatan_id`),
  KEY `rincian_belanja_umums_sub_kegiatan_id_foreign` (`sub_kegiatan_id`),
  KEY `rincian_belanja_umums_bidang_id_foreign` (`bidang_id`),
  CONSTRAINT `rincian_belanja_umum_bendahara_id_foreign` FOREIGN KEY (`bendahara_id`) REFERENCES `bendaharas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rincian_belanja_umum_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rincian_belanja_umum_kepala_dinas_id_foreign` FOREIGN KEY (`kepala_dinas_id`) REFERENCES `kepala_dinas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rincian_belanja_umum_kode_rekening_id_foreign` FOREIGN KEY (`kode_rekening_id`) REFERENCES `kode_rekenings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rincian_belanja_umum_penerima_id_foreign` FOREIGN KEY (`penerima_id`) REFERENCES `pegawais` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rincian_belanja_umum_pptk_id_foreign` FOREIGN KEY (`pptk_id`) REFERENCES `pptks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rincian_belanja_umum_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rincian_belanja_umum_sub_kegiatan_id_foreign` FOREIGN KEY (`sub_kegiatan_id`) REFERENCES `sub_kegiatans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rincian_belanja_umums_bidang_id_foreign` FOREIGN KEY (`bidang_id`) REFERENCES `bidangs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rincian_belanja_umums_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rincian_belanja_umums_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rincian_belanja_umums_sub_kegiatan_id_foreign` FOREIGN KEY (`sub_kegiatan_id`) REFERENCES `sub_kegiatans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `rincian_belanja_v2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rincian_belanja_v2` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `program_id` bigint(20) unsigned NOT NULL,
  `kegiatan_id` bigint(20) unsigned NOT NULL,
  `sub_kegiatan_id` bigint(20) unsigned NOT NULL,
  `kode_rekening_id` bigint(20) unsigned NOT NULL,
  `terbilang` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `untuk_pengeluaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_st` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_st` date NOT NULL,
  `nomor_spd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_spd` date NOT NULL,
  `anggaran` decimal(15,2) NOT NULL,
  `kepala_dinas_id` bigint(20) unsigned NOT NULL,
  `pptk_id` bigint(20) unsigned NOT NULL,
  `bendahara_id` bigint(20) unsigned NOT NULL,
  `pegawai_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rincian_belanja_v2_program_id_foreign` (`program_id`),
  KEY `rincian_belanja_v2_kegiatan_id_foreign` (`kegiatan_id`),
  KEY `rincian_belanja_v2_sub_kegiatan_id_foreign` (`sub_kegiatan_id`),
  KEY `rincian_belanja_v2_kode_rekening_id_foreign` (`kode_rekening_id`),
  KEY `rincian_belanja_v2_kepala_dinas_id_foreign` (`kepala_dinas_id`),
  KEY `rincian_belanja_v2_pptk_id_foreign` (`pptk_id`),
  KEY `rincian_belanja_v2_bendahara_id_foreign` (`bendahara_id`),
  KEY `rincian_belanja_v2_pegawai_id_foreign` (`pegawai_id`),
  CONSTRAINT `rincian_belanja_v2_bendahara_id_foreign` FOREIGN KEY (`bendahara_id`) REFERENCES `bendaharas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rincian_belanja_v2_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rincian_belanja_v2_kepala_dinas_id_foreign` FOREIGN KEY (`kepala_dinas_id`) REFERENCES `kepala_dinas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rincian_belanja_v2_kode_rekening_id_foreign` FOREIGN KEY (`kode_rekening_id`) REFERENCES `kode_rekenings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rincian_belanja_v2_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawais` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rincian_belanja_v2_pptk_id_foreign` FOREIGN KEY (`pptk_id`) REFERENCES `pptks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rincian_belanja_v2_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rincian_belanja_v2_sub_kegiatan_id_foreign` FOREIGN KEY (`sub_kegiatan_id`) REFERENCES `sub_kegiatans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `skpds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skpds` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_skpd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggaran` decimal(15,2) NOT NULL DEFAULT 10000000000.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sub_kegiatans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sub_kegiatans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bidang_id` bigint(20) unsigned DEFAULT NULL,
  `kegiatan_id` bigint(20) unsigned NOT NULL,
  `nama_sub_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggaran` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sub_kegiatans_kegiatans_id_foreign` (`kegiatan_id`) USING BTREE,
  KEY `sub_kegiatans_bidang_id_foreign` (`bidang_id`),
  CONSTRAINT `sub_kegiatans_bidang_id_foreign` FOREIGN KEY (`bidang_id`) REFERENCES `bidangs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sub_kegiatans_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sub_rincian_belanjas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sub_rincian_belanjas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rincian_belanjas_id` bigint(20) unsigned NOT NULL,
  `nama_sub_rincian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggaran` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sub_rincian_belanjas_rincian_belanjas_id_foreign` (`rincian_belanjas_id`),
  CONSTRAINT `sub_rincian_belanjas_rincian_belanjas_id_foreign` FOREIGN KEY (`rincian_belanjas_id`) REFERENCES `kode_rekenings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bidang_id` bigint(20) unsigned DEFAULT NULL,
  `role` enum('superadmin','admin','bidang') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bidang',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_bidang_id_foreign` (`bidang_id`),
  CONSTRAINT `users_bidang_id_foreign` FOREIGN KEY (`bidang_id`) REFERENCES `bidangs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'0001_01_01_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2024_10_09_094047_create_skpd_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2024_10_09_094135_create_program_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2024_10_09_094154_create_kegiatan_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2024_10_09_094212_create_sub_kegiatan_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2024_10_09_094253_create_rincian_belanja_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2024_10_09_094312_create_sub_rincian_belanja_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2024_10_09_094326_create_detail_belanja_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2024_11_13_032636_create_pptks_table',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2024_11_13_044340_create_kepala_dinas_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2024_11_13_045447_create_bendahara_table',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2024_11_13_054456_create_pegawais_table',5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25,'2024_11_13_085943_rename_rincian_belanjas_to_kode_rekenings',6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2024_11_13_095309_create_rincian_belanja_v2_table',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28,'2024_11_18_063501_add_bidang_id_to_programs_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29,'2024_11_18_072553_add_bidang_and_role_to_users_table',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30,'2024_11_18_083956_create_kode_rekening_bidangs_table',10);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (34,'2024_11_19_054720_create_rincian_belanja_umum_table',11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (35,'2024_11_19_092238_update_rincian_belanja_umum_table',12);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (36,'2024_11_19_092916_add_deleted_at_to_programs_table',13);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (37,'2024_11_19_093428_add_soft_deletes_to_kegiatans_table',14);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (41,'2024_11_19_095846_update_sub_kegiatans_table',15);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (42,'2024_11_19_102855_update_kode_rekenings_table',16);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (43,'2024_11_19_103101_fix_kode_rekenings_table',17);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (44,'2024_11_19_103344_update_foreign_key_on_kode_rekenings',18);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (45,'2024_11_19_103548_update_sub_kegiatan_nullable_on_kode_rekenings',18);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (46,'2024_11_19_114045_update_rincian_belanja_umums_table',19);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (47,'2024_11_19_123907_add_netto_to_rincian_belanja_umums_table',19);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (48,'2024_11_20_110759_create_admins_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (49,'2024_11_20_110759_create_bendaharas_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (50,'2024_11_20_110759_create_bidangs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (51,'2024_11_20_110759_create_cache_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (52,'2024_11_20_110759_create_cache_locks_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (53,'2024_11_20_110759_create_detail_belanjas_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (54,'2024_11_20_110759_create_failed_jobs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (55,'2024_11_20_110759_create_job_batches_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (56,'2024_11_20_110759_create_jobs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (57,'2024_11_20_110759_create_kegiatans_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (58,'2024_11_20_110759_create_kepala_dinas_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (59,'2024_11_20_110759_create_kode_rekening_bidangs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (60,'2024_11_20_110759_create_kode_rekenings_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (61,'2024_11_20_110759_create_password_reset_tokens_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (62,'2024_11_20_110759_create_pegawais_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (63,'2024_11_20_110759_create_pptks_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (64,'2024_11_20_110759_create_programs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (65,'2024_11_20_110759_create_rincian_belanja_umums_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (66,'2024_11_20_110759_create_rincian_belanja_v2_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (67,'2024_11_20_110759_create_sessions_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (68,'2024_11_20_110759_create_skpds_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (69,'2024_11_20_110759_create_sub_kegiatans_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (70,'2024_11_20_110759_create_sub_rincian_belanjas_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (71,'2024_11_20_110759_create_users_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (72,'2024_11_20_110802_add_foreign_keys_to_admins_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (73,'2024_11_20_110802_add_foreign_keys_to_detail_belanjas_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (74,'2024_11_20_110802_add_foreign_keys_to_kegiatans_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (75,'2024_11_20_110802_add_foreign_keys_to_kode_rekening_bidangs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (76,'2024_11_20_110802_add_foreign_keys_to_kode_rekenings_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (77,'2024_11_20_110802_add_foreign_keys_to_pegawais_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (78,'2024_11_20_110802_add_foreign_keys_to_programs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (79,'2024_11_20_110802_add_foreign_keys_to_rincian_belanja_umums_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (80,'2024_11_20_110802_add_foreign_keys_to_rincian_belanja_v2_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (81,'2024_11_20_110802_add_foreign_keys_to_sub_kegiatans_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (82,'2024_11_20_110802_add_foreign_keys_to_sub_rincian_belanjas_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (83,'2024_11_20_110802_add_foreign_keys_to_users_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (84,'2024_11_20_111203_add_bidang_id_to_kode_rekenings_table',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (85,'2024_11_20_113250_add_bidang_id_to_sub_kegiatans_table',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (86,'2024_11_20_114544_change_role_column_to_enum_in_users_table',22);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (87,'2024_11_21_021839_update_rincian_belanja_umums_table',23);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (88,'2024_11_21_093930_add_bidang_id_to_rincian_belanja_umums_table',24);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (89,'2024_11_22_035542_create_admins_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (90,'2024_11_22_035542_create_bendaharas_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (91,'2024_11_22_035542_create_bidangs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (92,'2024_11_22_035542_create_cache_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (93,'2024_11_22_035542_create_cache_locks_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (94,'2024_11_22_035542_create_detail_belanjas_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (95,'2024_11_22_035542_create_failed_jobs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (96,'2024_11_22_035542_create_job_batches_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (97,'2024_11_22_035542_create_jobs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (98,'2024_11_22_035542_create_kegiatans_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (99,'2024_11_22_035542_create_kepala_dinas_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (100,'2024_11_22_035542_create_kode_rekening_bidangs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (101,'2024_11_22_035542_create_kode_rekenings_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (102,'2024_11_22_035542_create_password_reset_tokens_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (103,'2024_11_22_035542_create_pegawais_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (104,'2024_11_22_035542_create_pptks_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (105,'2024_11_22_035542_create_programs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (106,'2024_11_22_035542_create_rincian_belanja_umums_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (107,'2024_11_22_035542_create_rincian_belanja_v2_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (108,'2024_11_22_035542_create_sessions_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (109,'2024_11_22_035542_create_skpds_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (110,'2024_11_22_035542_create_sub_kegiatans_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (111,'2024_11_22_035542_create_sub_rincian_belanjas_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (112,'2024_11_22_035542_create_users_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (113,'2024_11_22_035545_add_foreign_keys_to_admins_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (114,'2024_11_22_035545_add_foreign_keys_to_detail_belanjas_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (115,'2024_11_22_035545_add_foreign_keys_to_kegiatans_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (116,'2024_11_22_035545_add_foreign_keys_to_kode_rekening_bidangs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (117,'2024_11_22_035545_add_foreign_keys_to_kode_rekenings_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (118,'2024_11_22_035545_add_foreign_keys_to_pegawais_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (119,'2024_11_22_035545_add_foreign_keys_to_programs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (120,'2024_11_22_035545_add_foreign_keys_to_rincian_belanja_umums_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (121,'2024_11_22_035545_add_foreign_keys_to_rincian_belanja_v2_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (122,'2024_11_22_035545_add_foreign_keys_to_sub_kegiatans_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (123,'2024_11_22_035545_add_foreign_keys_to_sub_rincian_belanjas_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (124,'2024_11_22_035545_add_foreign_keys_to_users_table',0);
