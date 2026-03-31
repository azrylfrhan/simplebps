-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 15, 2026 at 10:28 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spkl_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hari_libur`
--

CREATE TABLE `hari_libur` (
  `id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hari_libur`
--

INSERT INTO `hari_libur` (`id`, `tanggal`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, '2025-01-01', 'Tahun Baru 2025 Masehi', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(2, '2025-01-27', 'Isra\' Mi\'raj Nabi Muhammad SAW', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(3, '2025-01-28', 'Cuti Bersama Tahun Baru Imlek 2576 Kongzili', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(4, '2025-01-29', 'Tahun Baru Imlek 2576 Kongzili', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(5, '2025-03-28', 'Cuti Bersama Hari Raya Nyepi Tahun Baru Saka 1947', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(6, '2025-03-29', 'Hari Raya Nyepi Tahun Baru Saka 1947', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(7, '2025-03-31', 'Hari Raya Idul Fitri 1446H', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(8, '2025-04-01', 'Hari Raya Idul Fitri 1446H', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(9, '2025-04-02', 'Cuti Bersama Hari Raya Idul Fitri 1446H', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(10, '2025-04-03', 'Cuti Bersama Hari Raya Idul Fitri 1446H', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(11, '2025-04-04', 'Cuti Bersama Hari Raya Idul Fitri 1446H', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(12, '2025-04-07', 'Cuti Bersama Hari Raya Idul Fitri 1446H', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(13, '2025-04-18', 'Wafat Yesus Kristus', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(14, '2025-04-20', 'Kebangkitan Yesus Kristus', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(15, '2025-05-01', 'Hari Buruh Internasional', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(16, '2025-05-12', 'Hari Raya Waisak 2569 BE', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(17, '2025-05-13', 'Cuti Bersama Hari Raya Waisak 2569 BE', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(18, '2025-05-29', 'Kenaikan Yesus Kristus', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(19, '2025-05-30', 'Cuti Bersama Kenaikan Yesus Kristus', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(20, '2025-06-01', 'Hari Lahir Pancasila', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(21, '2025-06-06', 'Hari Raya Idul Adha 1446H', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(22, '2025-06-09', 'Cuti Bersama Hari Raya Idul Adha 1446H', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(23, '2025-06-27', 'Tahun Baru Islam 1 Muharram 1447H', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(24, '2025-08-17', 'Hari Kemerdekaan Republik Indonesia ke 80', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(25, '2025-08-18', 'Libur Nasional Kemerdekaan Republik Indonesia', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(26, '2025-09-05', 'Maulid Nabi Muhammad SAW', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(27, '2025-12-25', 'Hari Raya Natal', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(28, '2025-12-26', 'Cuti Bersama Hari Raya Natal', '2025-12-01 19:37:38', '2025-12-01 19:37:38'),
(29, '2026-01-01', 'Tahun Baru 2026 Masehi', '2026-01-11 18:20:32', '2026-01-11 18:20:32'),
(30, '2026-01-16', 'Isra Mikraj Nabi Muhammad S.A.W.', '2026-01-11 18:20:32', '2026-01-11 18:20:32'),
(31, '2026-02-16', 'Tahun Baru Imlek 2577 Kongzili', '2026-01-11 18:20:32', '2026-01-11 18:20:32'),
(32, '2026-02-17', 'Tahun Baru Imlek 2577 Kongzili', '2026-01-11 18:20:32', '2026-01-11 18:20:32'),
(33, '2026-03-18', 'Hari Suci Nyepi (Tahun Baru Saka 1948)', '2026-01-11 18:20:32', '2026-01-11 18:20:32'),
(34, '2026-03-19', 'Hari Suci Nyepi (Tahun Baru Saka 1948)', '2026-01-11 18:20:32', '2026-01-11 18:20:32'),
(35, '2026-03-20', 'Idul Fitri 1447 Hijriah', '2026-01-11 18:20:32', '2026-01-11 18:20:32'),
(36, '2026-03-21', 'Idul Fitri 1447 Hijriah', '2026-01-11 18:20:32', '2026-01-11 18:20:32'),
(37, '2026-03-22', 'Idul Fitri 1447 Hijriah', '2026-01-11 18:20:32', '2026-01-11 18:20:32'),
(38, '2026-03-23', 'Idul Fitri 1447 Hijriah', '2026-01-11 18:20:32', '2026-01-11 18:20:32'),
(39, '2026-03-24', 'Idul Fitri 1447 Hijriah', '2026-01-11 18:20:32', '2026-01-11 18:20:32'),
(40, '2026-04-03', 'Wafat Yesus Kristus', '2026-01-11 18:20:32', '2026-01-11 18:20:32'),
(41, '2026-04-05', 'Kebangkitan Yesus Kristus (Paskah)', '2026-01-11 18:20:32', '2026-01-11 18:20:32'),
(42, '2026-05-01', 'Hari Buruh Internasional', '2026-01-11 18:20:32', '2026-01-11 18:20:32'),
(43, '2026-05-14', 'Kenaikan Yesus Kristus', '2026-01-11 18:20:33', '2026-01-11 18:20:33'),
(44, '2026-05-15', 'Kenaikan Yesus Kristus', '2026-01-11 18:20:33', '2026-01-11 18:20:33'),
(45, '2026-05-27', 'Idul Adha 1447 Hijriah', '2026-01-11 18:20:33', '2026-01-11 18:20:33'),
(46, '2026-05-28', 'Idul Adha 1447 Hijriah', '2026-01-11 18:20:33', '2026-01-11 18:20:33'),
(47, '2026-05-31', 'Hari Raya Waisak 2570 BE', '2026-01-11 18:20:33', '2026-01-11 18:20:33'),
(48, '2026-06-01', 'Hari Lahir Pancasila', '2026-01-11 18:20:33', '2026-01-11 18:20:33'),
(49, '2026-06-16', '1 Muharam Tahun Baru Islam 1448 Hijriah', '2026-01-11 18:20:33', '2026-01-11 18:20:33'),
(50, '2026-08-17', 'Proklamasi Kemerdekaan', '2026-01-11 18:20:33', '2026-01-11 18:20:33'),
(51, '2026-08-25', 'Maulid Nabi Muhammad S.A.W.', '2026-01-11 18:20:33', '2026-01-11 18:20:33'),
(52, '2026-12-25', 'Kelahiran Yesus Kristus', '2026-01-11 18:20:33', '2026-01-11 18:20:33');

-- --------------------------------------------------------

--
-- Table structure for table `konfigurasi`
--

CREATE TABLE `konfigurasi` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `konfigurasi`
--

INSERT INTO `konfigurasi` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(4, 'tempat_ttd', 'Manado', '2026-01-08 00:21:48', '2026-01-08 00:21:48'),
(5, 'jabatan_spkl', 'Kuasa Pengguna Anggaran', '2026-01-08 00:21:49', '2026-01-08 00:22:57'),
(6, 'nama_spkl', 'Nama', '2026-01-08 00:21:49', '2026-01-15 14:25:46'),
(7, 'tgl_spkl_manual', '15 Agustus 2025', '2026-01-08 00:21:49', '2026-01-08 00:22:57'),
(8, 'jabatan_rekap', 'Ketua Tim Kerja SDM', '2026-01-08 00:21:49', '2026-01-08 00:24:33'),
(9, 'nama_rekap', 'Nama', '2026-01-08 00:21:49', '2026-01-15 14:25:46'),
(10, 'tgl_rekap_manual', '15 Agustus 2025', '2026-01-08 00:21:49', '2026-01-08 00:21:49');

-- --------------------------------------------------------

--
-- Table structure for table `lembur`
--

CREATE TABLE `lembur` (
  `id` bigint UNSIGNED NOT NULL,
  `pegawai_id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `nomor_spkl` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `maksud_lembur` text COLLATE utf8mb4_unicode_ci,
  `dibuat_oleh` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lembur`
--

INSERT INTO `lembur` (`id`, `pegawai_id`, `tanggal`, `jam_mulai`, `jam_selesai`, `nomor_spkl`, `maksud_lembur`, `dibuat_oleh`, `created_at`, `updated_at`) VALUES
(13, 55, '2025-05-24', '10:55:58', '16:24:44', NULL, 'Realisasi BOS', 1, '2026-01-10 21:14:13', '2026-01-10 21:20:10'),
(14, 64, '2025-05-17', '10:08:15', '17:04:04', NULL, 'Pencatatan LPSE', 1, '2026-01-10 21:14:14', '2026-01-10 21:20:10'),
(15, 64, '2025-05-24', '11:19:23', '18:20:30', NULL, 'Realisasi BOS', 1, '2026-01-10 21:14:14', '2026-01-10 21:20:10'),
(16, 64, '2025-05-08', '07:22:45', '18:12:26', NULL, 'Penyusunan materi paparan Coretax', 1, '2026-01-10 21:14:14', '2026-01-10 21:20:10'),
(17, 64, '2025-05-09', '07:05:12', '18:00:58', NULL, 'Membuat bupot PPh', 1, '2026-01-10 21:14:14', '2026-01-10 21:20:10'),
(18, 64, '2025-05-15', '07:18:30', '19:07:55', NULL, 'Pelaporan Perpajakan', 1, '2026-01-10 21:14:14', '2026-01-10 21:20:10'),
(19, 59, '2025-05-10', '07:52:47', '15:02:31', NULL, 'Finalisasi Ranwal Renstra BPS Provinsi Sulawesi Utara', 1, '2026-01-10 21:14:14', '2026-01-10 21:20:10'),
(20, 59, '2025-05-13', '07:47:14', '15:12:21', NULL, 'Finalisasi Rancangan Awal Rencana Strategis 2025-2029', 1, '2026-01-10 21:14:14', '2026-01-10 21:20:10');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_12_01_205606_create_all_tables', 1),
(2, '2025_12_02_004711_create_konfigurasi_table', 2),
(3, '2025_12_03_000000_create_pengajuan_lembur_table', 3),
(5, '2025_12_30_160345_add_role_and_status_to_users_table', 4),
(6, '2025_12_30_162728_create_cache_table', 5),
(7, '2026_01_12_043731_add_kolom_is_read_ke_pengajuan_lembur', 6),
(8, '2026_01_12_070912_add_is_revisi_to_pengajuan_lembur_table', 7),
(9, '2026_01_12_101626_make_tim_id_nullable_on_pegawai_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tim_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nama_lengkap`, `jabatan`, `tim_id`, `created_at`, `updated_at`) VALUES
(2, 'Norma Olga Frida Regar, S.Si., M.Si', 'Statistisi Ahli Madya  ', 2, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(3, 'Titien Kristiningsih, SST., SE., M.Si', 'Statistisi Ahli Madya  ', 2, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(5, 'Sirly Catharina Worotikan, SE, M.Si', 'Statistisi Ahli Madya  ', 2, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(7, 'Viktor Prima Sirait, SST, M.S.E', 'Statistisi Ahli Madya  ', 2, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(8, 'Purnama Cahya Sari Silalahi, SST, M.Si', 'Statistisi Ahli Muda  ', 2, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(9, 'Ir. Starry Nouva Solang, M.Si.', 'Statistisi Ahli Muda  ', 2, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(10, 'Ratna Sulistyowati, SST, SAB, M.Si', 'Statistisi Ahli Madya  ', 2, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(11, 'Sih Kawuri Sejati, SST, M.E.K.K', 'Statistisi Ahli Madya  ', 2, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(12, 'Daniel Tri Hemawan, SE', 'Statistisi Ahli Muda  ', 2, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(13, 'Ryko Aprianto Puasa, SE', 'Statistisi Ahli Muda  ', 2, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(14, 'Rahmadi, S.ST', 'Pranata Komputer Ahli Muda  ', 2, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(16, 'Erna Kusumawati, SST', 'Statistisi Ahli Muda  ', 2, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(17, 'Hahotan Sagala, SST, M.Ec.Dev.', 'Pranata Komputer Ahli Muda  ', 2, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(18, 'Junitha Joce Sahureka, SST', 'Statistisi Ahli Muda  ', 2, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(19, 'Nabella Intan Karasta, S.Tr.Stat.', 'Statistisi Ahli Pertama  ', 4, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(20, 'Eldorado Alfu Ilmy, S.Tr.Stat.', 'Statistisi Ahli Pertama  ', 4, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(21, 'Dian Teguh Prasetyo, S.Tr.Stat.', 'Statistisi Ahli Pertama  ', 4, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(23, 'Muhammad Rifqi Mubarak, S.Tr.Stat.', 'Pranata Komputer Ahli Pertama  ', 4, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(24, 'Ponimin, S.Tr.Stat.', 'Pranata Komputer Ahli Pertama  ', 4, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(25, 'Salonica Oktaviani, SST', 'Statistisi Ahli Pertama  ', 4, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(26, 'Joice Juliana Koyongian, S.M.', 'Statistisi Ahli Pertama  ', 4, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(27, 'Yulius Wendi Triandaru, SST', 'Pranata Komputer Ahli Pertama  ', 4, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(29, 'Mariane Esther Rantung, SST', 'Statistisi Ahli Pertama  ', 4, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(30, 'Ratriani Retno Wardani, S.Tr.Stat.', 'Pranata Komputer Ahli Pertama  ', 4, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(32, 'Frisda Arisanti Tarigan, S.E.', 'Statistisi Ahli Pertama  ', 4, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(34, 'Samuelin Caroles Pandelaki, A.Md.Stat.', 'Statistisi Terampil  ', 3, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(37, 'Priska Harto Lolowang, SH', 'Pranata SDM Aparatur Penyelia ', 3, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(38, 'Jermias Oscar Jeffry Sahambangun, SE', 'Statistisi Ahli Muda ', 3, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(39, 'Johanna Maria Farida Tampemawa, S.E.', 'Statistisi Ahli Muda ', 3, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(40, 'Sarjani Harini Martiningsih, S.Si', 'Analis SDM Aparatur Ahli Muda ', 3, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(41, 'Bregitta Sisilia Lasut, SS', 'Statistisi Ahli Muda', 4, '2025-12-01 15:34:41', '2026-01-10 19:57:47'),
(42, 'Randy Pratama Lumenta, SST, M.A.P', 'Analis Anggaran Ahli Muda ', 3, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(43, 'Steven Kalvin Montolalu, S.E.', 'Statistisi Ahli Muda ', 3, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(44, 'Yola Christhy Larinse, SST', 'Statistisi Ahli Muda ', 3, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(45, 'Wisnu Triaji, SE', 'Analis Pengelolaan Keuangan APBN Ahli Muda', 1, '2025-12-01 15:34:41', '2026-01-10 19:56:28'),
(46, 'Radjid Dwi Iskandar, S.M.', 'Arsiparis Ahli Pertama ', 3, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(47, 'Nurul Hayati Unonongo, SST', 'Pranata Keuangan APBN Mahir ', 3, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(48, 'Irene Ruth Longkutoy, SH', 'Analis SDM Aparatur Ahli Pertama ', 3, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(49, 'Nurul Hidayah, S.Tr.Stat.', 'Statistisi Ahli Pertama ', 3, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(50, 'Mia Wahyumiranti, S.M.', 'Analis Pengelolaan Keuangan APBN Ahli Pertama ', 3, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(51, 'Insan Riski Dwi Perdana, S.Tr.Stat.', 'Statistisi Ahli Pertama ', 3, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(52, 'Denis Diego Kaparang, S.A.P', 'Analis SDM Aparatur Ahli Pertama ', 3, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(53, 'Tri Hidayati, S.Si', 'Statistisi Ahli Pertama ', 1, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(54, 'Christian Leonardo Pratama Tamboto, S.Tr.Stat.', 'Statistisi Ahli Pertama ', 1, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(55, 'Afifah Syabaniah Sanubari Langkau, S.Stat.', 'Statistisi Terampil ', 1, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(56, 'Danty Welmin Yoshida Fatima, S.Tr.Stat.', 'Statistisi Ahli Pertama ', 1, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(57, 'Ilham Alifian Firmansyah, S.Tr.Stat.', 'Pranata Komputer Ahli Pertama ', 1, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(58, 'Novert Cyril Lengkong, S.Tr.Stat.', 'Statistisi Ahli Pertama ', 1, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(59, 'Friska Patricia Raintung, S.E.', 'Pengelola Pengadaan Barang dan Jasa Ahli Pertama ', 1, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(60, 'Yuan Philips Gigir, A.Md.Ak.', 'Arsiparis Terampil ', 1, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(61, 'Muhammad Alifh, A.Md.Stat.', 'Statistisi Terampil ', 1, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(62, 'Regina Pangau, A.Md.T', 'Statistisi Terampil ', 1, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(63, 'Mustika Aridya Arum, A.Md.Kb.N.', 'Pranata Keuangan APBN Terampil ', 1, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(64, 'Wardzatul Khoiriyah, A.Md.Kb.N.', 'Pranata Keuangan APBN Terampil ', 1, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(65, 'Stela Engeline Doris Lomboan', 'Staf Bagian Umum', 1, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(66, 'Muh. Miriansyah Putra Watupongoh, S.S', 'Staf Bagian Umum', 1, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(67, 'Michelle Jessica Suprapto, S.Psi', 'Staf Bagian Umum', 1, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(68, 'Nurul Fatmah Khoiriah, A.Md.S.I.Ak', 'Staf Bagian Umum', 1, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(69, 'Marlina Tuti Handayani, A.Md', 'Staf Bagian Umum', 1, '2025-12-01 15:34:41', '2025-12-01 15:34:41'),
(70, 'Rosniar Eliana, SST., M.Stat.', 'Statistisi Ahli Muda  ', 1, '2025-12-01 15:44:32', '2025-12-01 15:44:32'),
(71, 'Tiara Dameani, S.ST', 'Pranata Komputer Ahli Muda  ', 1, '2025-12-01 15:44:32', '2025-12-01 15:44:32'),
(72, 'Zaenuri Putro Utomo, S.Si., M.Eng.', 'Pranata Komputer Ahli Muda  ', 1, '2025-12-01 15:44:32', '2025-12-01 15:44:32'),
(73, 'Deesye Loury Bue, SE, M.Si.', 'Statistisi Ahli Muda  ', 1, '2025-12-01 15:44:32', '2025-12-01 15:44:32'),
(74, 'Marnita Simatupang, SST, M.Stat.', 'Statistisi Ahli Muda  ', 1, '2025-12-01 15:44:32', '2025-12-01 15:44:32'),
(75, 'Windha Wijaya, SST', 'Statistisi Ahli Muda  ', 1, '2025-12-01 15:44:32', '2025-12-01 15:44:32'),
(77, 'Kristin Paskahrani Bakara, SST', 'Statistisi Ahli Muda  ', 1, '2025-12-01 15:44:32', '2025-12-01 15:44:32'),
(78, 'Intan Angelia Senduk, SST', 'Pranata Komputer Ahli Muda  ', 1, '2025-12-01 15:44:32', '2025-12-01 15:44:32'),
(79, 'Prima Puspita Indra Murti, SST, M.Si.', 'Statistisi Ahli Muda  ', 1, '2025-12-01 15:44:32', '2025-12-01 15:44:32'),
(80, 'Satria June Adwendi, SST, M.Si.', 'Pranata Komputer Ahli Pertama  ', 1, '2025-12-01 15:44:32', '2025-12-01 15:44:32'),
(81, 'Piky Pomantow, A.Md. Kom', 'Statistisi Mahir  ', 1, '2025-12-01 15:44:32', '2025-12-01 15:44:32'),
(82, 'Jolly Jody Pesik, A.Md. Kom', 'Statistisi Mahir  ', 1, '2025-12-01 15:44:32', '2025-12-01 15:44:32'),
(83, 'Nurfadhila Fahmi Utami, S.Stat.', 'Statistisi Ahli Pertama  ', 1, '2025-12-01 15:44:32', '2025-12-01 15:44:32'),
(84, 'Muhammad Iqbal, S.Stat.', 'Statistisi Ahli Pertama  ', 1, '2025-12-01 15:44:32', '2025-12-01 15:44:32'),
(86, 'Zulfa Nur Fajri Ramadhani, S.Tr.Stat.', 'Statistisi Ahli Pertama  ', 1, '2025-12-01 15:44:32', '2025-12-01 15:44:32'),
(87, 'Putri Sekarsinung, S.Tr.Stat.', 'Statistisi Ahli Pertama  ', 1, '2025-12-01 15:44:32', '2025-12-01 15:44:32'),
(88, 'Bhayu Prabowo, SST.,M.Ec.Dev', 'Kepala Bagian Umum', NULL, '2026-01-12 02:37:37', '2026-01-12 02:37:37');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_lembur`
--

CREATE TABLE `pengajuan_lembur` (
  `id` bigint UNSIGNED NOT NULL,
  `pegawai_id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `lama_jam_taksiran` int NOT NULL,
  `lama_jam_disetujui` int DEFAULT NULL,
  `maksud_lembur` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_revisi` tinyint(1) NOT NULL DEFAULT '0',
  `is_read_operator` tinyint(1) NOT NULL DEFAULT '0',
  `is_read_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_read_kabag` tinyint(1) NOT NULL DEFAULT '0',
  `catatan_verifikator` text COLLATE utf8mb4_unicode_ci,
  `dibuat_oleh` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengajuan_lembur`
--

INSERT INTO `pengajuan_lembur` (`id`, `pegawai_id`, `tanggal`, `lama_jam_taksiran`, `lama_jam_disetujui`, `maksud_lembur`, `status`, `is_revisi`, `is_read_operator`, `is_read_admin`, `is_read_kabag`, `catatan_verifikator`, `dibuat_oleh`, `created_at`, `updated_at`) VALUES
(1, 55, '2025-12-18', 2, 2, 'menyelesaikan  laporan', 'disetujui', 0, 1, 1, 0, NULL, 2, '2025-12-30 09:39:35', '2026-01-15 12:29:08'),
(6, 78, '2025-12-12', 3, 3, 'Melakukan Monitoring dan Evaluasi Kinerja Pegawai', 'disetujui', 0, 1, 1, 0, NULL, 2, '2025-12-30 10:55:36', '2026-01-15 12:29:08'),
(7, 78, '2025-12-11', 2, 2, 'Melakukan Monitoring dan Evaluasi Kinerja Pegawai', 'disetujui', 0, 1, 1, 0, NULL, 2, '2025-12-30 10:56:01', '2026-01-15 12:29:08'),
(8, 78, '2025-12-09', 3, 3, 'Melakukan Monitoring dan Evaluasi Kinerja Pegawai', 'disetujui', 0, 1, 1, 0, NULL, 2, '2025-12-30 10:56:29', '2026-01-15 12:29:08'),
(11, 78, '2025-12-10', 2, 2, 'Melakukan Monitoring dan Evaluasi Kinerja Pegawai\r\nMelakukan pemeriksaan bahan tayang BRS Keadaan Ketenagakerjaan Provinsi Sulawesi Utara Februari 2025', 'disetujui', 0, 1, 1, 0, NULL, 2, '2026-01-09 08:49:26', '2026-01-15 12:29:08'),
(12, 55, '2025-05-12', 3, 3, 'Pencatatan LPSE', 'disetujui', 0, 1, 1, 0, NULL, 2, '2026-01-10 20:01:50', '2026-01-15 12:29:08'),
(13, 55, '2025-05-24', 4, 4, 'Realisasi BOS', 'disetujui', 0, 1, 1, 0, NULL, 2, '2026-01-10 20:02:23', '2026-01-15 12:29:08'),
(14, 64, '2025-05-17', 3, 3, 'Pencatatan LPSE', 'disetujui', 0, 1, 1, 0, NULL, 2, '2026-01-10 20:03:19', '2026-01-15 12:29:08'),
(15, 64, '2025-05-24', 3, 3, 'Realisasi BOS', 'disetujui', 0, 1, 1, 0, NULL, 2, '2026-01-10 20:04:03', '2026-01-15 12:29:08'),
(16, 64, '2025-05-08', 3, 3, 'Penyusunan materi paparan Coretax', 'disetujui', 0, 1, 1, 0, NULL, 2, '2026-01-10 20:04:42', '2026-01-15 12:29:08'),
(17, 64, '2025-05-09', 3, 3, 'Membuat bupot PPh', 'disetujui', 0, 1, 1, 0, NULL, 2, '2026-01-10 20:05:10', '2026-01-15 12:29:08'),
(18, 64, '2025-05-15', 3, 3, 'Pelaporan Perpajakan', 'disetujui', 0, 1, 1, 0, NULL, 2, '2026-01-10 20:05:54', '2026-01-15 12:29:08'),
(19, 59, '2025-05-10', 3, 3, 'Finalisasi Ranwal Renstra BPS Provinsi Sulawesi Utara', 'disetujui', 0, 1, 1, 0, NULL, 2, '2026-01-10 20:06:39', '2026-01-15 12:29:08'),
(20, 59, '2025-05-13', 3, 3, 'Finalisasi Rancangan Awal Rencana Strategis 2025-2029', 'disetujui', 0, 1, 1, 0, NULL, 2, '2026-01-10 20:07:05', '2026-01-15 12:29:08'),
(26, 88, '2026-01-17', 3, NULL, 'mengerjakan laporan', 'disetujui', 0, 1, 1, 1, NULL, 5, '2026-01-12 02:47:44', '2026-01-15 12:29:08'),
(27, 32, '2026-01-19', 3, NULL, 'membuat laporan', 'pending', 0, 1, 0, 1, NULL, 3, '2026-01-12 02:49:20', '2026-01-15 12:23:57'),
(28, 21, '2026-02-01', 2, NULL, 'Membuat Konten IG', 'disetujui', 0, 1, 1, 1, NULL, 3, '2026-01-12 02:56:21', '2026-01-15 12:29:08'),
(30, 3, '2026-01-17', 2, NULL, 'test', 'pending', 0, 1, 0, 1, NULL, 5, '2026-01-12 19:25:20', '2026-01-15 12:23:57');

-- --------------------------------------------------------

--
-- Table structure for table `tim`
--

CREATE TABLE `tim` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_tim` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ketua_tim` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tim`
--

INSERT INTO `tim` (`id`, `nama_tim`, `ketua_tim`, `created_at`, `updated_at`) VALUES
(1, 'Keuangan', 'y/n', '2025-12-01 14:03:24', '2026-01-15 14:26:53'),
(2, 'SDM', 'y/n', '2025-12-01 15:09:21', '2026-01-15 14:26:43'),
(3, 'Produksi', 'y/n', '2025-12-01 15:10:20', '2026-01-15 14:26:31'),
(4, 'Humas', 'y/n', '2025-12-01 15:10:30', '2026-01-15 14:26:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'operator',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `wajib_ganti_password` tinyint(1) NOT NULL DEFAULT '1',
  `tim_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `status`, `wajib_ganti_password`, `tim_id`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$12$bM1G.TSP6Cm78H6tGCUBAuF4qXyH5j2fWGvqpQqlxAHL43/WB/4oy', 'admin', 'aktif', 0, NULL, '2025-12-01 13:00:30', '2026-01-13 01:10:32'),
(2, 'keuangan123', '$2y$12$frHoPGEarQpYux.FB5Zfk.SNh8LMmL/nkh3w2WcC70FIHucIf9Z4O', 'operator', 'aktif', 0, 1, '2025-12-01 14:03:45', '2026-01-13 01:03:55'),
(3, 'humas123', '$2y$12$C43mUBLqHhOZOWFnFI5pS.PArjlsmHNf.Rik.0mVisifVMWt9XbAS', 'operator', 'aktif', 0, 4, '2025-12-01 19:25:49', '2026-01-15 12:16:58'),
(4, 'kabag123', '$2y$12$js3p7OCqBQ5QkSG6v3ZpCOMxtH3JlXOE5k.lHSKaTOlb8goyIUzXm', 'kabag', 'aktif', 0, NULL, '2025-12-30 08:28:15', '2026-01-11 22:31:01'),
(5, 'sdm456', '$2y$12$p.dRuFcFDlxD5YVnTLzuZuofVEeCwj4XIkJ.Kd9ePUNncZJpWRLFm', 'operator', 'aktif', 0, 2, '2026-01-12 02:22:04', '2026-01-14 09:24:39'),
(6, 'sdm123', '$2y$12$ieeMsY9LdOp0i3PGoFuJeux2HGsVrSbzwQV9Uf6Ah91XxBNhvMP7S', 'operator', 'aktif', 0, 2, '2026-01-14 09:09:25', '2026-01-14 09:10:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `hari_libur`
--
ALTER TABLE `hari_libur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hari_libur_tanggal_unique` (`tanggal`);

--
-- Indexes for table `konfigurasi`
--
ALTER TABLE `konfigurasi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `konfigurasi_key_unique` (`key`);

--
-- Indexes for table `lembur`
--
ALTER TABLE `lembur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lembur_nomor_spkl_unique` (`nomor_spkl`),
  ADD KEY `lembur_pegawai_id_foreign` (`pegawai_id`),
  ADD KEY `lembur_dibuat_oleh_foreign` (`dibuat_oleh`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pegawai_tim_id_foreign` (`tim_id`);

--
-- Indexes for table `pengajuan_lembur`
--
ALTER TABLE `pengajuan_lembur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengajuan_lembur_pegawai_id_foreign` (`pegawai_id`),
  ADD KEY `pengajuan_lembur_dibuat_oleh_foreign` (`dibuat_oleh`);

--
-- Indexes for table `tim`
--
ALTER TABLE `tim`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tim_nama_tim_unique` (`nama_tim`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_tim_id_foreign` (`tim_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hari_libur`
--
ALTER TABLE `hari_libur`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `konfigurasi`
--
ALTER TABLE `konfigurasi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lembur`
--
ALTER TABLE `lembur`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `pengajuan_lembur`
--
ALTER TABLE `pengajuan_lembur`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tim`
--
ALTER TABLE `tim`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lembur`
--
ALTER TABLE `lembur`
  ADD CONSTRAINT `lembur_dibuat_oleh_foreign` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `lembur_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_tim_id_foreign` FOREIGN KEY (`tim_id`) REFERENCES `tim` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengajuan_lembur`
--
ALTER TABLE `pengajuan_lembur`
  ADD CONSTRAINT `pengajuan_lembur_dibuat_oleh_foreign` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pengajuan_lembur_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_tim_id_foreign` FOREIGN KEY (`tim_id`) REFERENCES `tim` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
