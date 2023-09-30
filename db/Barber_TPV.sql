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
) 

DROP TABLE IF EXISTS `basketproduct`;
CREATE TABLE IF NOT EXISTS `basketproduct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `basketID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) 

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

DROP VIEW IF EXISTS `basket_view`;
CREATE TABLE IF NOT EXISTS `basket_view` (
`basketID` int(11)
,`productID` int(11)
,`basketproductID` int(11)
,`productName` varchar(200)
,`productCost` float
);

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `cost` float NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1 = Active\r\n0 = Inactive',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
)

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
) 

DROP TABLE IF EXISTS `basket_dt`;
DROP VIEW IF EXISTS `basket_dt`;
CREATE VIEW `basket_dt`  AS SELECT date_format(`basket`.`date`,'%d-%m-%Y %H:%i:%s') AS `formattedDate`, `basket`.`id` AS `basketID`, `basket`.`userID` AS `userID`, `user`.`name` AS `userName`, `user`.`lastName` AS `userLastName`, `basket`.`payType` AS `payType`, (case when (`basket`.`payType` = 1) then 'Efectivo' when (`basket`.`payType` = 2) then 'Tarjeta' end) AS `paymentMethod`, `basket`.`total` AS `total` FROM (`basket` join `user` on((`user`.`id` = `basket`.`userID`))) WHERE (`basket`.`total` is not null) ;

DROP TABLE IF EXISTS `basket_view`;

DROP VIEW IF EXISTS `basket_view`;
CREATE VIEW `basket_view`  AS SELECT `basketproduct`.`basketID` AS `basketID`, `basketproduct`.`productID` AS `productID`, `basketproduct`.`id` AS `basketproductID`, `product`.`name` AS `productName`, `product`.`cost` AS `productCost` FROM (`basketproduct` join `product` on((`basketproduct`.`productID` = `product`.`id`))) ;