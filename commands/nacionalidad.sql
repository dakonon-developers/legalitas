-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 28-06-2017 a las 12:32:45
-- Versión del servidor: 5.5.53-0+deb8u1
-- Versión de PHP: 5.6.29-0+deb8u1

INSERT INTO nacionalidad(id, fk_pais, nombre, abreviatura) VALUES
(1, 6, 'Angoleña', 'AGO'),
(2, 13, 'Argelina', 'DZA'),
(3, 43, 'Camerunesa', 'CMR'),
(4, 74, 'Etíope', 'ETH'),
(5, 92, 'Ecuatoguineana', 'GNQ'),
(6, 64, 'Egipcia', 'EGY'),
(7, 139, 'Liberiana', 'LBR'),
(8, 140, 'Libia', 'LBY'),
(9, 153, 'Marroquí', 'MAR'),
(10, 164, 'Namibia', 'NAM'),
(11, 170, 'Nigeriana', 'NGA'),
(12, 208, 'Senegalesa', 'SEN'),
(13, 218, 'Sudafricana', 'ZAF'),
(14, 231, 'Togolesa', 'TGO'),
(15, 44, 'Canadiense', 'CAN'),
(16, 72, 'Estadounidense', 'USA'),
(17, 157, 'Mexicana', 'MEX'),
(18, 27, 'Beliceña', 'BLZ'),
(19, 57, 'Costarricense', 'CRI'),
(20, 89, 'Guatemalteca', 'GTM'),
(21, 96, 'Hondureña', 'HND'),
(22, 168, 'Nicaragüense', 'NIC'),
(23, 180, 'Panameña', 'PAN'),
(24, 65, 'Salvadoreña', 'SLV'),
(25, 59, 'Cubana', 'CUB'),
(26, 16, 'Arubana', 'ABW'),
(27, 22, 'Bahameña', 'BHS'),
(28, 25, 'Barbadense', 'BRB'),
(29, 194, 'Dominicana', 'DOM'),
(30, 95, 'Haitiana', 'HTI'),
(31, 125, 'Jamaiquina', 'JAM'),
(32, 188, 'Puertorriqueña', 'PRI'),
(33, 201, 'Sancristobaleña', 'KNA'),
(34, 206, 'Santaluciana', 'LCA'),
(35, 14, 'Argentina', 'ARG'),
(36, 32, 'Boliviana', 'BOL'),
(37, 35, 'Brasileña', 'BRA'),
(38, 46, 'Chilena', 'CHL'),
(39, 50, 'Colombiana', 'COL'),
(40, 63, 'Ecuatoriana', 'ECU'),
(41, 94, 'Guyanesa', 'GUY'),
(42, 183, 'Paraguaya', 'PRY'),
(43, 184, 'Peruana', 'PER'),
(44, 222, 'Surinamesa', 'SUR'),
(45, 242, 'Uruguaya', 'URY'),
(46, 245, 'Venezolana', 'VEN'),
(47, 1, 'Afgana', 'AFG'),
(48, 21, 'Azerbaiyana', 'AZE'),
(49, 24, 'Bangladesí', 'BGD'),
(50, 47, 'China', 'CHN'),
(51, 67, 'Emiratí', 'ARE'),
(52, 75, 'Filipina', 'PHL'),
(53, 82, 'Georgiana', 'GEO'),
(54, 99, 'Indio', 'IND'),
(55, 101, 'Indonesia', 'IDN'),
(56, 123, 'Israelí', 'ISR'),
(57, 127, 'Japonesa', 'JPN'),
(58, 138, 'Libanesa', 'LBN'),
(59, 161, 'Mongola', 'MNG'),
(60, 54, 'Norcoreana', 'PRK'),
(61, 212, 'Siria', 'SYR'),
(62, 55, 'Surcoreana', 'KOR'),
(63, 246, 'Vietnamita', 'VNM'),
(64, 241, 'Europea', 'EU'),
(65, 3, 'Albanesa', 'ALB'),
(66, 4, 'Alemana', 'ARM'),
(67, 5, 'Andorrana', 'AND'),
(68, 15, 'Armenia', 'ARM'),
(69, 20, 'Austríaca', 'AUT'),
(70, 26, 'Belga', 'BEL'),
(71, 30, 'Bielorrusa', 'BLR'),
(72, 33, 'Bosnia', 'BIH'),
(73, 37, 'Búlgara', 'BGR'),
(74, 192, 'Checa', 'CZE'),
(75, 48, 'Chipriota', 'CYP'),
(76, 58, 'Croata', 'HRV'),
(77, 61, 'Danesa', 'DNK'),
(78, 69, 'Eslovaca', 'SVK'),
(79, 70, 'Eslovena', 'SVN'),
(80, 71, 'Española', 'ESP'),
(81, 73, 'Estonia', 'EST'),
(82, 76, 'Finlandesa', 'FIN'),
(83, 78, 'Francesa', 'FRA'),
(84, 86, 'Griega', 'GRC'),
(85, 98, 'Húngara', 'HUN'),
(86, 190, 'Británica', 'GBR'),
(87, 104, 'Irlandesa', 'IRL'),
(88, 124, 'Italiana', 'ITA'),
(89, 137, 'Letona', 'LVA'),
(90, 142, 'Lituana', 'LTU'),
(91, 143, 'Luxemburguesa', 'LUX'),
(92, 151, 'Maltesa', 'MLT'),
(93, 159, 'Moldava', 'MDV'),
(95, 172, 'Noruega', 'NOR'),
(96, 186, 'Polaca', 'POL'),
(97, 187, 'Portuguesa', 'PRT'),
(98, 196, 'Rumana', 'ROU'),
(99, 197, 'Rusa', 'RUS'),
(100, 220, 'Sueca', 'SWE'),
(101, 221, 'Suiza', 'CHE'),
(102, 237, 'Turca', 'TUR'),
(103, 239, 'Ucraniana', 'UKR'),
(104, 19, 'Australiana', 'AUS'),
(105, 174, 'Neozelandesa', 'NZL');
