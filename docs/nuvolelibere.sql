-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Giu 14, 2012 alle 17:43
-- Versione del server: 5.5.24
-- Versione PHP: 5.3.10-1ubuntu3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nuvolelibere`
--
CREATE DATABASE `nuvolelibere` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `nuvolelibere`;

-- --------------------------------------------------------

--
-- Struttura della tabella `ge_role`
--

CREATE TABLE IF NOT EXISTS `ge_role` (
  `uid` int(10) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `ge_user`
--

CREATE TABLE IF NOT EXISTS `ge_user` (
  `uid` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(40) NOT NULL,
  `active` int(1) NOT NULL,
  `code` varchar(32) NOT NULL,
  `code_time` int(10) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `ge_role`
--
ALTER TABLE `ge_role`
  ADD CONSTRAINT `ge_role_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `ge_user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
