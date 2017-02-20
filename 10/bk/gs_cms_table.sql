-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017 年 2 月 17 日 19:42
-- サーバのバージョン： 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gs_db`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `gs_cms_table`
--

CREATE TABLE IF NOT EXISTS `gs_cms_table` (
`id` int(12) NOT NULL COMMENT 'ユニークキー',
  `title` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '記事タイトル',
  `article` text COLLATE utf8_unicode_ci NOT NULL COMMENT '記事詳細',
  `indate` datetime NOT NULL COMMENT '登録日'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `gs_cms_table`
--

INSERT INTO `gs_cms_table` (`id`, `title`, `article`, `indate`) VALUES
(1, 'テスト１', '<p><strong>ワードみたいに使ってね v（＊＾_＾＊）v</strong></p>\r\n', '2017-02-18 03:27:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gs_cms_table`
--
ALTER TABLE `gs_cms_table`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gs_cms_table`
--
ALTER TABLE `gs_cms_table`
MODIFY `id` int(12) NOT NULL AUTO_INCREMENT COMMENT 'ユニークキー',AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
