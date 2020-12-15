-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Jul 2020 pada 19.35
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kajianid`
--

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `sessions`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `sessions` (
`session_key` varchar(20)
,`user_email` varchar(50)
,`name` varchar(100)
,`login_date` timestamp
);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_article`
--

CREATE TABLE `tbl_article` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `content` longtext NOT NULL,
  `has_img` tinyint(1) NOT NULL DEFAULT 0,
  `extension` varchar(6) DEFAULT NULL,
  `ustadz_id` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_article`
--

INSERT INTO `tbl_article` (`id`, `title`, `post_date`, `content`, `has_img`, `extension`, `ustadz_id`) VALUES
(2, 'Larangan Bermuka Dua', '2020-07-15 03:37:04', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis malesuada libero et bibendum aliquam. Curabitur vehicula purus ac nunc facilisis, eu tempor massa tincidunt. In orci erat, posuere in mi eu, placerat rhoncus dui. Morbi fringilla accumsan vestibulum. Aliquam quis consequat tellus. Aliquam nec pulvinar ipsum. Phasellus id ornare purus. Donec justo eros, rhoncus eu urna id, ultricies faucibus risus. Vestibulum convallis, arcu eget pulvinar tempus, lorem lectus cursus risus, eget viverra mi mi ac libero. Quisque cursus, tellus eu blandit auctor, nisi ex dapibus est, sit amet ultricies magna arcu convallis urna.\r\n\r\nFusce semper tortor ac dignissim aliquam. Vivamus pharetra erat tristique tristique cursus. Vestibulum hendrerit, ligula id vehicula ultricies, quam urna vestibulum turpis, ut pretium nibh erat in ante. Etiam pretium nisl risus, a dignissim tellus consectetur vehicula. Suspendisse maximus erat erat, ut maximus diam laoreet et. Vestibulum quis ultricies sapien, hendrerit viverra nibh. Morbi lacinia metus ac hendrerit fermentum. Praesent placerat metus id lacinia cursus. Suspendisse in magna dolor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.\r\n\r\nAliquam fringilla, arcu sed varius pulvinar, augue odio posuere nibh, vitae ornare odio felis vitae leo. Proin blandit placerat dolor at faucibus. Sed at efficitur dui. Ut in est cursus, faucibus nulla ut, fringilla elit. Aliquam eget ipsum in enim interdum mattis. In eu scelerisque mi, eget hendrerit neque. Aenean lobortis ipsum eu lacus molestie tincidunt. Cras luctus enim mauris, a eleifend nisl auctor a.', 0, NULL, 'admin'),
(3, 'Indahnya berbagi', '2020-07-15 08:13:39', 'oawifoawnfoanfoawnf', 0, NULL, 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_article_likes`
--

CREATE TABLE `tbl_article_likes` (
  `article_id` int(11) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_article_likes`
--

INSERT INTO `tbl_article_likes` (`article_id`, `user_email`, `timestamp`) VALUES
(3, 'dwichan@outlook.com', '2020-07-20 15:12:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_info`
--

CREATE TABLE `tbl_info` (
  `id` int(11) NOT NULL,
  `kajian_title` varchar(100) NOT NULL,
  `ustadz_id` varchar(12) NOT NULL,
  `mosque_id` int(11) NOT NULL,
  `address` text DEFAULT NULL,
  `place` enum('Video','Di Tempat','Live Streaming') NOT NULL DEFAULT 'Di Tempat',
  `youtube_link` text DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `img_resource` text DEFAULT NULL,
  `date_announce` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_due` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_info`
--

INSERT INTO `tbl_info` (`id`, `kajian_title`, `ustadz_id`, `mosque_id`, `address`, `place`, `youtube_link`, `description`, `img_resource`, `date_announce`, `date_due`) VALUES
(1, 'Kajian Utama Kita', 'admin', 1, 'oawidnoandoaindowin', 'Di Tempat', NULL, 'oawifnoafnoainfoafnoaifnoaiwnfoawfn', NULL, '2020-07-20 14:55:46', '2020-07-31 21:55:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_mosque`
--

CREATE TABLE `tbl_mosque` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `lat_lng` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `ustadz_id` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_mosque`
--

INSERT INTO `tbl_mosque` (`id`, `name`, `lat_lng`, `address`, `ustadz_id`) VALUES
(1, 'Masjid Fatimatuzzahra', '-7.0,109.0', 'Jalan Jalan', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_session`
--

CREATE TABLE `tbl_session` (
  `session_key` varchar(20) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `login_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_session`
--

INSERT INTO `tbl_session` (`session_key`, `user_email`, `login_date`) VALUES
('r8uFGplSaq3U4B_vfEt$', 'dwichan@outlook.com', '2020-07-18 15:56:46'),
('Z3NV5hJm2qRYD6QfOxyB', 'user@user.com', '2020-07-18 14:33:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_users`
--

CREATE TABLE `tbl_users` (
  `email` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `birth` date DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_users`
--

INSERT INTO `tbl_users` (`email`, `name`, `password`, `birth`, `phone`, `address`) VALUES
('dwichan@outlook.com', 'User', 'MTIzNDU2', '2000-07-17', '082221010929', 'ssegseegagae');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_ustadz`
--

CREATE TABLE `tbl_ustadz` (
  `id` varchar(12) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `gender` char(1) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_ustadz`
--

INSERT INTO `tbl_ustadz` (`id`, `name`, `phone`, `gender`, `email`, `address`, `password`) VALUES
('admin', 'Ust. Habibullah', '088394274927', 'L', 'habibullah@gmail.com', 'Jalan Panjang No. 8a', '123456');

-- --------------------------------------------------------

--
-- Struktur untuk view `sessions`
--
DROP TABLE IF EXISTS `sessions`;

CREATE VIEW `sessions`  AS  select `a`.`session_key` AS `session_key`,`a`.`user_email` AS `user_email`,`b`.`name` AS `name`,`a`.`login_date` AS `login_date` from (`tbl_session` `a` join `tbl_users` `b` on(`a`.`user_email` = `b`.`email`)) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_article`
--
ALTER TABLE `tbl_article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ustadz_id` (`ustadz_id`);

--
-- Indeks untuk tabel `tbl_article_likes`
--
ALTER TABLE `tbl_article_likes`
  ADD KEY `article_id` (`article_id`),
  ADD KEY `user_email` (`user_email`);

--
-- Indeks untuk tabel `tbl_info`
--
ALTER TABLE `tbl_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ustadz_id` (`ustadz_id`),
  ADD KEY `mosque_id` (`mosque_id`);

--
-- Indeks untuk tabel `tbl_mosque`
--
ALTER TABLE `tbl_mosque`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ustadz_id` (`ustadz_id`);

--
-- Indeks untuk tabel `tbl_session`
--
ALTER TABLE `tbl_session`
  ADD PRIMARY KEY (`session_key`);

--
-- Indeks untuk tabel `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `tbl_ustadz`
--
ALTER TABLE `tbl_ustadz`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_article`
--
ALTER TABLE `tbl_article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_info`
--
ALTER TABLE `tbl_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_mosque`
--
ALTER TABLE `tbl_mosque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_article`
--
ALTER TABLE `tbl_article`
  ADD CONSTRAINT `tbl_article_ibfk_1` FOREIGN KEY (`ustadz_id`) REFERENCES `tbl_ustadz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_article_likes`
--
ALTER TABLE `tbl_article_likes`
  ADD CONSTRAINT `tbl_article_likes_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `tbl_article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_article_likes_ibfk_2` FOREIGN KEY (`user_email`) REFERENCES `tbl_users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_info`
--
ALTER TABLE `tbl_info`
  ADD CONSTRAINT `tbl_info_ibfk_1` FOREIGN KEY (`ustadz_id`) REFERENCES `tbl_ustadz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_info_ibfk_2` FOREIGN KEY (`mosque_id`) REFERENCES `tbl_mosque` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_mosque`
--
ALTER TABLE `tbl_mosque`
  ADD CONSTRAINT `tbl_mosque_ibfk_1` FOREIGN KEY (`ustadz_id`) REFERENCES `tbl_ustadz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
