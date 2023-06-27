-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Jun 2023 pada 07.09
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `codes`
--

CREATE TABLE `codes` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `code` varchar(5) NOT NULL,
  `expire` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_form`
--

CREATE TABLE `user_form` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(300) NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_form`
--

INSERT INTO `user_form` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(100, 'Achmad Tirto Sudiro', 'achmadtirtosudirosudiro@gmail.com', '$2y$10$fr0DBnedUNZ5uWsYoPlXwOJ85DKJwLLwTpdmrMWg2rIk/lTMIvnkK', 'admin'),
(123, 'User', 'user@gmail.com', '$2y$10$5BPoiCQ5ks.PrK3h3d7Fse.Se6uKjNZ6lTp4u5vGHOteimfRIx67C', 'user'),
(172, 'adm', 'adm@gmail.com', '$2y$10$BA0fc6KH2A3ziz2FQvXTpOIp20EkCPuR03LNmtpAlEs5N/JByUNvy', 'admin'),
(174, 'usr', 'usr@gmail.com', '$2y$10$kW9jPFwVVK1w9aQ2KW5Su.valcbUdYQTDgkvbFp62htNUvwMBaIRa', 'user'),
(178, 'admin', 'admin@gmail.com', '$2y$10$7uUW.vTHdK8eRE/kI/Nw8OwB5zY1HHe1ytO9GGfmhyMP7lI4Ecyx6', 'admin'),
(183, 'adam', 'adam@gmail.com', '$2y$10$WWlhvngYAoh9I7wLu69kgua/L.BAv8vDYkDiXS9gxV.aMeMVNTVI.', 'admin'),
(184, 'uc', 'uc@gmail.com', '$2y$10$MRv1HPBaED3BHQ12uVVbiu1zI5uG8w7Si.lcXVpu8X78U1ggadgt2', 'user'),
(185, 'Thirfa Nur Mufida', 'thirfa@gmail.com', '$2y$10$.damFFR3vHEIIppbVppq7.Hwe3i8OwiU3cr9xA81wZ6dZkG0S0oj.', 'admin'),
(186, 'Ok', 'ok@gmail.com', '$2y$10$Ig6U/crekOytuh6RJ7Q.weeGyyJiBlljDNcn63Hd4l155g7RhMzEy', 'user'),
(187, 'Atok Dalang', 'dalanga85@gmail.com', '$2y$10$NHNMHOjX9jEszoK5T5KGhefIFRQPLu6GG8.WphlSn/4eEgo97FHJm', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `codes`
--
ALTER TABLE `codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `expire` (`expire`),
  ADD KEY `email` (`email`);

--
-- Indeks untuk tabel `user_form`
--
ALTER TABLE `user_form`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `codes`
--
ALTER TABLE `codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `user_form`
--
ALTER TABLE `user_form`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
