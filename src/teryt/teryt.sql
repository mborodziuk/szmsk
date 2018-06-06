-- phpMyAdmin SQL Dump
-- version 3.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 12 Kwi 2011, 11:51
-- Wersja serwera: 5.0.84
-- Wersja PHP: 5.2.1


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `teryt`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `simc`
--

CREATE TABLE simc (
  id serial primary key,
  woj varchar(2) NOT NULL,
  pow varchar(2) NOT NULL,
  gmi varchar(2) NOT NULL,
  rodz_gmi smallint NOT NULL,
   rm  varchar(2) NOT NULL,
   mz  smallint NOT NULL,
   nazwa  varchar(50) NOT NULL,
   sym  varchar(8) NOT NULL,
   sympod  varchar(8) NOT NULL,
   stan_na  date NOT NULL
);

-- --------------------------------------------------------

--
-- Struktura tabeli dla   terc 
--

CREATE TABLE terc (
   id  serial primary key,
   woj  varchar(2) NOT NULL,
   pow  varchar(2) NOT NULL,
   gmi  varchar(2) NOT NULL,
   rodz  varchar(11) NOT NULL,
   nazwa  varchar(100) NOT NULL,
   nazdod  varchar(100) NOT NULL,
   stan_na  date NOT NULL
);

-- --------------------------------------------------------

--
-- Struktura tabeli dla   ulic 
--

CREATE TABLE ulic (
   id  serial primary key,
   woj  varchar(2) NOT NULL,
   pow  varchar(2) NOT NULL,
   gmi  varchar(2) NOT NULL,
   rodz_gmi  smallint NOT NULL,
   sym  varchar(10) NOT NULL,
   sym_ul  varchar(10) NOT NULL,
   cecha  varchar(10) NOT NULL,
   nazwa_1  varchar(100) NOT NULL,
   nazwa_2  varchar(100) NOT NULL,
   stan_na  date NOT NULL
);

-- --------------------------------------------------------

--
-- Struktura tabeli dla   wmrodz 
--

CREATE TABLE wmrodz (
   id  serial primary key,
   rm  varchar(2) NOT NULL,
   nazwa_rm  varchar(50) NOT NULL,
   stan_na  date NOT NULL
);
