-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Temps de generació: 09-07-2014 a les 10:46:33
-- Versió del servidor: 5.5.37-log
-- Versió de PHP: 5.4.23

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de dades: `aplicoop`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `albara`
--

DROP TABLE IF EXISTS `albara`;
CREATE TABLE IF NOT EXISTS `albara` (
  `numero` int(11) NOT NULL AUTO_INCREMENT,
  `proveidora` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `data` date NOT NULL,
  `totsi` float(7,2) NOT NULL,
  `totiva` float(7,2) NOT NULL,
  `tot` float(7,2) NOT NULL,
  `check1` enum('0','1') COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `notes` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`numero`),
  KEY `proveidora` (`proveidora`),
  KEY `data` (`data`),
  KEY `check1` (`check1`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `albara_linia`
--

DROP TABLE IF EXISTS `albara_linia`;
CREATE TABLE IF NOT EXISTS `albara_linia` (
  `numero` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `producte` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `quantitat` float(7,3) NOT NULL DEFAULT '0.000',
  KEY `producte` (`producte`),
  KEY `numero` (`numero`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `tipus` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `actiu` enum('activat','desactivat') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'activat',
  `estoc` enum('si','no') COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`tipus`),
  KEY `actiu` (`actiu`),
  KEY `estoc` (`estoc`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `cistella_check`
--

DROP TABLE IF EXISTS `cistella_check`;
CREATE TABLE IF NOT EXISTS `cistella_check` (
  `proces` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `grup` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `data` date NOT NULL,
  `check1` enum('0','1') COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `codi` varchar(6) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`data`,`proces`,`grup`),
  KEY `check1` (`check1`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `comanda`
--

DROP TABLE IF EXISTS `comanda`;
CREATE TABLE IF NOT EXISTS `comanda` (
  `numero` int(11) NOT NULL AUTO_INCREMENT,
  `usuari` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `proces` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `grup` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `sessionid` int(11) NOT NULL,
  `data` date NOT NULL,
  `check0` enum('0','1') COLLATE utf8_spanish_ci NOT NULL,
  `report0` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `data2` date NOT NULL,
  `check1` enum('0','1') COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `check2` enum('0','1') COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `numfact` int(11) NOT NULL,
  `notes` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`numero`),
  KEY `data` (`data`),
  KEY `check1` (`check1`),
  KEY `check2` (`check2`),
  KEY `usuari` (`usuari`),
  KEY `proces` (`proces`),
  KEY `grup` (`grup`),
  KEY `check0` (`check0`),
  KEY `data2` (`data2`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `comanda_linia`
--

DROP TABLE IF EXISTS `comanda_linia`;
CREATE TABLE IF NOT EXISTS `comanda_linia` (
  `numero` int(11) NOT NULL,
  `ref` varchar(7) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `quantitat` float(7,3) NOT NULL,
  `cistella` float(7,3) NOT NULL DEFAULT '0.000',
  `preu` float(7,2) NOT NULL,
  `iva` float(2,2) NOT NULL,
  `descompte` float(4,4) NOT NULL,
  KEY `numero` (`numero`),
  KEY `ref` (`ref`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `grups`
--

DROP TABLE IF EXISTS `grups`;
CREATE TABLE IF NOT EXISTS `grups` (
  `nom` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `actiu` enum('actiu','no actiu') COLLATE utf8_spanish_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  UNIQUE KEY `nom` (`nom`),
  KEY `actiu` (`actiu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `incidencia`
--

DROP TABLE IF EXISTS `incidencia`;
CREATE TABLE IF NOT EXISTS `incidencia` (
  `from` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `to` text COLLATE utf8_spanish_ci NOT NULL,
  `subject` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `message` text COLLATE utf8_spanish_ci NOT NULL,
  `data` datetime NOT NULL,
  `vist` enum('0','1') COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  KEY `from` (`from`),
  KEY `vist` (`vist`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `moneder`
--

DROP TABLE IF EXISTS `moneder`;
CREATE TABLE IF NOT EXISTS `moneder` (
  `sessio` datetime NOT NULL,
  `user` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `data` date NOT NULL,
  `familia` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `concepte` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `valor` float(7,2) NOT NULL,
  `notes` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  KEY `data` (`data`),
  KEY `sessio` (`sessio`),
  KEY `familia` (`familia`),
  KEY `concepte` (`concepte`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `notescrip`
--

DROP TABLE IF EXISTS `notescrip`;
CREATE TABLE IF NOT EXISTS `notescrip` (
  `numero` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `text` text COLLATE utf8_spanish_ci NOT NULL,
  `tipus` enum('dreta','esquerra') COLLATE utf8_spanish_ci NOT NULL,
  `caducitat` date NOT NULL,
  PRIMARY KEY (`numero`),
  KEY `tipus` (`tipus`),
  KEY `caducitat` (`caducitat`),
  KEY `nom` (`nom`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `processos`
--

DROP TABLE IF EXISTS `processos`;
CREATE TABLE IF NOT EXISTS `processos` (
  `nom` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `grup` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tipus` enum('període concret','continu') COLLATE utf8_spanish_ci NOT NULL,
  `data_inici` date DEFAULT NULL,
  `data_fi` date DEFAULT NULL,
  `periode` enum('','setmanal') COLLATE utf8_spanish_ci NOT NULL,
  `dia_recollida` enum('no','dilluns','dimarts','dimecres','dijous','divendres','dissabte','diumenge') COLLATE utf8_spanish_ci NOT NULL,
  `dia_tall` enum('','dilluns','dimarts','dimecres','dijous','divendres','dissabte','diumenge') COLLATE utf8_spanish_ci NOT NULL,
  `hora_tall` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `actiu` enum('actiu','aturat') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'actiu',
  UNIQUE KEY `nom` (`nom`,`grup`),
  KEY `actiu` (`actiu`),
  KEY `grup` (`grup`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `proces_linia`
--

DROP TABLE IF EXISTS `proces_linia`;
CREATE TABLE IF NOT EXISTS `proces_linia` (
  `proces` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `grup` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `categoria` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `ordre` smallint(6) NOT NULL,
  `actiu` enum('activat','desactivat') COLLATE utf8_spanish_ci NOT NULL,
  KEY `proces` (`proces`,`grup`,`categoria`),
  KEY `actiu` (`actiu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `productes`
--

DROP TABLE IF EXISTS `productes`;
CREATE TABLE IF NOT EXISTS `productes` (
  `ref` varchar(7) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `unitat` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `proveidora` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `categoria` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `subcategoria` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `actiu` enum('actiu','baixa') COLLATE utf8_spanish_ci NOT NULL,
  `preusi` float(7,2) NOT NULL,
  `iva` float(2,2) NOT NULL,
  `marge` float(7,4) NOT NULL,
  `descompte` float(4,4) NOT NULL,
  `estoc` float(9,3) NOT NULL DEFAULT '0.000',
  `notes` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`ref`),
  UNIQUE KEY `ref` (`ref`),
  KEY `categoria` (`categoria`),
  KEY `subcategoria` (`subcategoria`),
  KEY `actiu` (`actiu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `proveidores`
--

DROP TABLE IF EXISTS `proveidores`;
CREATE TABLE IF NOT EXISTS `proveidores` (
  `nom` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `actiu` enum('activat','desactivat') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'activat',
  `nomcomplert` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `contacte` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `adress` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telf1` varchar(9) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telf2` varchar(9) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fax` varchar(9) COLLATE utf8_spanish_ci DEFAULT NULL,
  `web` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email1` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email2` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`nom`),
  KEY `actiu` (`actiu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `sessionid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `date` datetime NOT NULL,
  `date2` datetime NOT NULL,
  PRIMARY KEY (`sessionid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Estructura de la taula `subcategoria`
--

DROP TABLE IF EXISTS `subcategoria`;
CREATE TABLE IF NOT EXISTS `subcategoria` (
  `subcategoria` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `categoria` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `actiu` enum('activada','desactivada') COLLATE utf8_spanish_ci NOT NULL,
  UNIQUE KEY `subcategoria` (`subcategoria`,`categoria`),
  KEY `categoria` (`categoria`),
  KEY `actiu` (`actiu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `usuaris`
--

DROP TABLE IF EXISTS `usuaris`;
CREATE TABLE IF NOT EXISTS `usuaris` (
  `nom` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `claudepas` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `tipus` enum('admin','user','prov','eco','cist','super') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'user',
  `tipus2` enum('actiu','baixa') COLLATE utf8_spanish_ci NOT NULL,
  `dia` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `moneder` float(7,2) NOT NULL,
  `components` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tel1` varchar(9) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tel2` varchar(9) COLLATE utf8_spanish_ci NOT NULL,
  `email1` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `email2` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `nomf` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `adressf` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `niff` varchar(9) COLLATE utf8_spanish_ci NOT NULL,
  `nota` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`nom`),
  KEY `dia` (`dia`),
  KEY `tipus2` (`tipus2`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Bolcant dades de la taula `usuaris`
--

INSERT INTO `usuaris` (`nom`, `claudepas`, `tipus`, `tipus2`, `dia`, `moneder`, `components`, `tel1`, `tel2`, `email1`, `email2`, `nomf`, `adressf`, `niff`, `nota`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'super', 'actiu', 'admin', 0.00, 'admin', '666666666', '', 'admin@admin.com', '', 'admin', 'admin', '12345678A', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
