-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017 年 2 月 21 日 11:55
-- サーバのバージョン： 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gs_db`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `gs_cms_table`
--

CREATE TABLE `gs_cms_table` (
  `id` int(12) NOT NULL COMMENT 'ユニークキー',
  `title` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '記事タイトル',
  `article` text COLLATE utf8_unicode_ci NOT NULL COMMENT '記事詳細',
  `upfile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `indate` datetime NOT NULL COMMENT '登録日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `gs_cms_table`
--

INSERT INTO `gs_cms_table` (`id`, `title`, `article`, `upfile`, `indate`) VALUES
(7, 'test', '<p>ワードみたいに使ってね v（＊＾_＾＊）v</p>\r\n', './upload/good.png', '2017-02-20 19:56:08'),
(8, 'エンジェル', '<p>ワードみたいに使ってね v（＊＾_＾＊）v</p>\r\n', './upload/e255ba9a3a5eb34fbbb3e4ed2c59a2edgood.png', '2017-02-21 10:20:56'),
(9, 'test', '<p>ワードみたいに使ってね v（＊＾_＾＊）v</p>\r\n', '', '2017-02-21 15:52:51');

-- --------------------------------------------------------

--
-- テーブルの構造 `gs_user_table`
--

CREATE TABLE `gs_user_table` (
  `id` int(12) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `lid` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `lpw` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `kanri_flg` int(1) NOT NULL,
  `life_flg` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `gs_user_table`
--

INSERT INTO `gs_user_table` (`id`, `name`, `lid`, `lpw`, `kanri_flg`, `life_flg`) VALUES
(14, '我妻', 'やんい', '$2y$10$t5x7Ysb29TtBUTTGTdtzwuP.eCgPzueYOaem5WfVFy0FMuhFRn4lK', 1, 1),
(26, '謝イシン', 'ichen', '$2y$10$DGhB85bRCv2iBX.R2tD8W.VUy3VSOxAdFGIS6VDDOi1ujWa/pkFiy', 0, 1),
(35, '鈴木ヒロタケ', 'suzuki', '$2y$10$t5x7Ysb29TtBUTTGTdtzwuP.eCgPzueYOaem5WfVFy0FMuhFRn4lK', 0, 0),
(36, 'test11', 'test11', '$2y$10$ZTsnuWOs97cUqHM9TyJc.eQphdMLa0Vadf89syABJNRBRs9LBDTpq', 1, 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `tr_users`
--

CREATE TABLE `tr_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `university` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `tr_users`
--

INSERT INTO `tr_users` (`id`, `name`, `email`, `password`, `university`, `created`, `updated`) VALUES
(1, '鈴木', 'suzuki@harpoo.co.jp', '$2y$10$ZQ/jUFLHjxjFfXIQqtVeYe6gPZGPxQty9nqxqoD4BYkR9mI9Vyygy', 1, '2017-02-14 14:52:30', '2017-02-14 14:52:30'),
(2, '我妻陽一', 'waga4155@gmail.com', '$2y$10$iOF/2RTtCXL5yp6R4wiMkeNoOaehHQkxe9/SSETcJ3kBhFBnVpYjC', 2, '2017-02-14 17:18:07', '2017-02-14 17:18:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gs_cms_table`
--
ALTER TABLE `gs_cms_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gs_user_table`
--
ALTER TABLE `gs_user_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tr_users`
--
ALTER TABLE `tr_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gs_cms_table`
--
ALTER TABLE `gs_cms_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT COMMENT 'ユニークキー', AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `gs_user_table`
--
ALTER TABLE `gs_user_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `tr_users`
--
ALTER TABLE `tr_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
