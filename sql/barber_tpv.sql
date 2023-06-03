-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 03-06-2023 a las 15:49:56
-- Versión del servidor: 5.7.36
-- Versión de PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `barbertpv`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `basket`
--

DROP TABLE IF EXISTS `basket`;
CREATE TABLE IF NOT EXISTS `basket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `payType` int(1) DEFAULT NULL,
  `total` float DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dateCalc` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `basketproduct`
--

DROP TABLE IF EXISTS `basketproduct`;
CREATE TABLE IF NOT EXISTS `basketproduct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `basketID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `basket_dt`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `basket_dt`;
CREATE TABLE IF NOT EXISTS `basket_dt` (
`formattedDate` varchar(24)
,`basketID` int(11)
,`userID` int(11)
,`userName` varchar(100)
,`userLastName` varchar(100)
,`payType` int(1)
,`paymentMethod` varchar(8)
,`total` float
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `basket_view`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `basket_view`;
CREATE TABLE IF NOT EXISTS `basket_view` (
`basketID` int(11)
,`productID` int(11)
,`basketproductID` int(11)
,`productName` varchar(200)
,`productCost` float
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `cost` float NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tpv`
--

DROP TABLE IF EXISTS `tpv`;
CREATE TABLE IF NOT EXISTS `tpv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_user` int(11) NOT NULL,
  `fk_product` int(11) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(999) COLLATE utf8_spanish_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `lastName` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `role` int(1) NOT NULL COMMENT '1 = Administrador 2 = Basico',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura para la vista `basket_dt`
--
DROP TABLE IF EXISTS `basket_dt`;

DROP VIEW IF EXISTS `basket_dt`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `basket_dt`  AS SELECT date_format(`basket`.`date`,'%d-%m-%Y %H:%i:%s') AS `formattedDate`, `basket`.`id` AS `basketID`, `basket`.`userID` AS `userID`, `user`.`name` AS `userName`, `user`.`lastName` AS `userLastName`, `basket`.`payType` AS `payType`, (case when (`basket`.`payType` = 1) then 'Efectivo' when (`basket`.`payType` = 2) then 'Tarjeta' end) AS `paymentMethod`, `basket`.`total` AS `total` FROM (`basket` join `user` on((`user`.`id` = `basket`.`userID`))) WHERE (`basket`.`total` is not null) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `basket_view`
--
DROP TABLE IF EXISTS `basket_view`;

DROP VIEW IF EXISTS `basket_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `basket_view`  AS SELECT `basketproduct`.`basketID` AS `basketID`, `basketproduct`.`productID` AS `productID`, `basketproduct`.`id` AS `basketproductID`, `product`.`name` AS `productName`, `product`.`cost` AS `productCost` FROM (`basketproduct` join `product` on((`basketproduct`.`productID` = `product`.`id`))) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
