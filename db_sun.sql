# SQL Manager 2005 for MySQL 3.7.0.1
# ---------------------------------------
# Host     : localhost
# Port     : 3306
# Database : db_sun


SET FOREIGN_KEY_CHECKS=0;

DROP DATABASE IF EXISTS `db_sun`;

CREATE DATABASE `db_sun`
    CHARACTER SET 'utf8'
    COLLATE 'utf8_general_ci';

USE `db_sun`;

#
# Structure for the `clientes` table : 
#

DROP TABLE IF EXISTS `clientes`;

CREATE TABLE `clientes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `co_cli` varchar(6) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `nombre` varchar(60) DEFAULT NULL,
  `apellido` varchar(60) DEFAULT NULL,
  `descripcion` varchar(80) DEFAULT NULL,
  `borrado` tinyint(1) DEFAULT '0',
  `created_user` varchar(255) NOT NULL DEFAULT 'SYSTEM',
  `updated_user` varchar(255) NOT NULL DEFAULT 'SYSTEM',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `co_cli_email` (`co_cli`,`email`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `co_cli` (`co_cli`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for the `clientes` table  (LIMIT 0,500)
#

INSERT INTO `clientes` (`id`, `co_cli`, `email`, `password`, `remember_token`, `nombre`, `apellido`, `descripcion`, `borrado`, `created_user`, `updated_user`, `created_at`, `updated_at`, `deleted_at`) VALUES 
  (1,'A00001','usuario@test.com','cea383c968f411f7a22b7eceb0a66299699a01316baa2ee54dcba13bc2980223',NULL,'PEPE','LE PU','CEO',0,'ADMIN','ADMIN','2016-01-13 01:17:50','2016-01-13 01:17:50',NULL),
  (2,'A00002','usuario@test1.com','cea383c968f411f7a22b7eceb0a66299699a01316baa2ee54dcba13bc2980223',NULL,'CLIENTE','SEGUNDO','CEO',1,'ADMIN','ADMIN','2016-03-27 16:11:45','2016-03-27 16:11:45',NULL),
  (3,'A00003','liusvani@gmail.com','cea383c968f411f7a22b7eceb0a66299699a01316baa2ee54dcba13bc2980223',NULL,'LIUSVANI','SUAREZ','CEO',0,'ADMIN','ADMIN','2018-10-01','2018-10-01',NULL);

COMMIT;

#
# Structure for the `licencias` table : 
#

DROP TABLE IF EXISTS `licencias`;

CREATE TABLE `licencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `co_licencia` varchar(24) NOT NULL,
  `co_tipo_licencia` varchar(6) NOT NULL DEFAULT 'BASIC',
  `co_pro` varchar(10) NOT NULL DEFAULT 'KPIADMIN',
  `tipo_producto` varchar(45) DEFAULT 'ALGODON',
  `co_cli` varchar(6) NOT NULL,
  `codigo` varchar(255) DEFAULT NULL,
  `borrado` tinyint(1) DEFAULT '0',
  `ds_server` varchar(255) DEFAULT NULL,
  `ds_dbname` varchar(255) DEFAULT NULL,
  `ds_user` varchar(255) DEFAULT NULL,
  `ds_pass` varchar(255) DEFAULT NULL,
  `ds_port` varchar(10) DEFAULT NULL,
  `dw_server` varchar(255) DEFAULT NULL,
  `dw_dbname` varchar(255) DEFAULT NULL,
  `dw_user` varchar(255) DEFAULT NULL,
  `dw_pass` varchar(255) DEFAULT NULL,
  `dw_port` varchar(10) DEFAULT NULL,
  `empresa` varchar(255) DEFAULT NULL,
  `direc_fact` text,
  `tele_fact` varchar(255) DEFAULT NULL,
  `email_fact` varchar(255) DEFAULT NULL,
  `fecha_ult_sync` datetime DEFAULT NULL,
  `actualiza_sp` tinyint(1) DEFAULT '0',
  `actualiza_email` tinyint(1) DEFAULT '0',
  `created_user` varchar(255) NOT NULL,
  `updated_user` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `co_licencia` (`co_licencia`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for the `licencias` table  (LIMIT 0,500)
#

INSERT INTO `licencias` (`id`, `co_licencia`, `co_tipo_licencia`, `co_pro`, `tipo_producto`, `co_cli`, `codigo`, `borrado`, `ds_server`, `ds_dbname`, `ds_user`, `ds_pass`, `ds_port`, `dw_server`, `dw_dbname`, `dw_user`, `dw_pass`, `dw_port`, `empresa`, `direc_fact`, `tele_fact`, `email_fact`, `fecha_ult_sync`, `actualiza_sp`, `actualiza_email`, `created_user`, `updated_user`, `created_at`, `updated_at`) VALUES 
  (1,'A00KPIADMINA000012016010','BASIC','KPIADMIN','algodon','A00003','KPIADMINA00001',0,'localhost','wordpress','root','pass','3306','localhost','basededatosaconectar','lsb','lsbarzaga','3306','Enterprise TEST',NULL,NULL,NULL,NULL,0,0,'ADMIN','ADMIN','2018-10-01 00:30:21','2018-10-01 00:30:21'),
  (2,'A00KPIADMINA000012017010','BASIC','SM','ALGODON','A00001','SMA00001',0,'localhost','wordpress1','root','pass','3307','localhost','basededatosaconectar2','lsb','lsbarzaga','3306',NULL,NULL,NULL,NULL,NULL,0,0,'','','2018-10-25 22:58:03','2018-10-25 22:58:03'),
  (3,'A00KPIADMINA000012017021','BASIC','KPIADMIN','ALGODON','A00002','KPIADMINA00002',1,'localhost',NULL,NULL,NULL,NULL,'localhost','basededatosaconectar3','root',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'','','2018-10-25 23:15:11','2018-10-25 23:15:11');

COMMIT;

#
# Structure for the `licenciasdetalle` table : 
#

DROP TABLE IF EXISTS `licenciasdetalle`;

CREATE TABLE `licenciasdetalle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_licencia` int(11) NOT NULL,
  `co_licencia` varchar(24) NOT NULL,
  `co_tipo_licencia` varchar(6) NOT NULL,
  `co_pro` varchar(10) NOT NULL,
  `fe_inicio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fe_fin` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `borrado` tinyint(1) DEFAULT '0',
  `created_user` varchar(255) DEFAULT NULL,
  `updated_user` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for the `licenciasdetalle` table  (LIMIT 0,500)
#

INSERT INTO `licenciasdetalle` (`id`, `id_licencia`, `co_licencia`, `co_tipo_licencia`, `co_pro`, `fe_inicio`, `fe_fin`, `borrado`, `created_user`, `updated_user`, `created_at`, `updated_at`) VALUES 
  (1,1,'A00KPIADMINA000012016010','BASIC','KPIADMIN','2018-10-01 00:40:28','2019-11-04',0,'ADMIN','ADMIN','2016-01-13 00:40:28','2016-01-13 00:40:28'),
  (2,3,'A00KPIADMINA000012016010','BASIC','KPIADMIN','2018-10-25 23:16:09','2018-10-25 23:16:09',0,NULL,NULL,'2018-10-25 23:16:09','2018-10-25 23:16:09'),
  (3,2,'A00KPIADMINA000012017021','BASIC','SM','2018-10-25 23:23:48','2018-10-25 23:23:48',0,'ADMIN','ADMIN','2018-10-25 23:23:48','2018-10-25 23:23:48');

COMMIT;

#
# Structure for the `modulos_lice` table : 
#

DROP TABLE IF EXISTS `modulos_lice`;

CREATE TABLE `modulos_lice` (
  `co_modulo` varchar(6) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `created_user` varchar(255) DEFAULT NULL,
  `updated_user` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`co_modulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for the `modulos_lice` table  (LIMIT 0,500)
#

INSERT INTO `modulos_lice` (`co_modulo`, `descripcion`, `activo`, `created_user`, `updated_user`, `created_at`, `updated_at`, `deleted_at`) VALUES 
  ('BANCOS','BANCOS',1,'ADMIN','ADMIN','2016-01-13 00:02:10','2016-01-13 00:02:10',NULL),
  ('COMPRA','COMPRAS',1,'ADMIN','ADMIN','2016-01-13 00:02:10','2016-01-13 00:02:10',NULL),
  ('CXC','CXC',1,'ADMIN','ADMIN','2016-01-13 00:02:10','2016-01-13 00:02:10',NULL),
  ('CXP','CXP',1,'ADMIN','ADMIN','2016-01-13 00:02:10','2016-01-13 00:02:10',NULL),
  ('DASH1','MUESTRA EL DAHS 1',1,'ADMIN','ADMIN','2016-01-13 00:02:10','2016-01-13 00:02:10',NULL),
  ('DASH2','MUESTRA EL DAHS 2',1,'ADMIN','ADMIN','2016-01-13 00:02:10','2016-01-13 00:02:10',NULL),
  ('DASH3','MUESTRA EL DAHS 3',1,'ADMIN','ADMIN','2016-01-13 00:02:10','2016-01-13 00:02:10',NULL),
  ('ORDCOM','ORDCOMP',1,'ADMIN','ADMIN','2016-01-13 00:02:10','2016-01-13 00:02:10',NULL),
  ('PPTO','PPTO',1,'ADMIN','ADMIN','2016-01-13 00:02:10','2016-01-13 00:02:10',NULL),
  ('VENTAS','VENTAS',1,'ADMIN','ADMIN','2016-01-13 00:02:10','2016-01-13 00:02:10',NULL);

COMMIT;

#
# Structure for the `productos` table : 
#

DROP TABLE IF EXISTS `productos`;

CREATE TABLE `productos` (
  `co_pro` varchar(10) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '0',
  `created_user` varchar(255) DEFAULT NULL,
  `updated_user` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`co_pro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for the `productos` table  (LIMIT 0,500)
#

INSERT INTO `productos` (`co_pro`, `nombre`, `descripcion`, `activo`, `created_user`, `updated_user`, `created_at`, `updated_at`, `deleted_at`) VALUES 
  ('KPIADMIN','SALESFORCE','SALESFORCE',1,'ADMIN','ADMIN','2016-01-12 23:10:54','2016-01-12 23:10:54',NULL);

COMMIT;

#
# Structure for the `tipo_lice` table : 
#

DROP TABLE IF EXISTS `tipo_lice`;

CREATE TABLE `tipo_lice` (
  `co_tipo_lice` varchar(6) NOT NULL,
  `co_pro` varchar(10) NOT NULL,
  `descripcion` varchar(80) NOT NULL,
  `created_user` varchar(255) DEFAULT NULL,
  `updated_user` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`co_tipo_lice`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for the `tipo_lice` table  (LIMIT 0,500)
#

INSERT INTO `tipo_lice` (`co_tipo_lice`, `co_pro`, `descripcion`, `created_user`, `updated_user`, `created_at`, `updated_at`, `deleted_at`) VALUES 
  ('BASIC','KPIADMIN','BASICA','ADMIN','ADMIN','2016-01-12 23:53:39','2016-01-12 23:53:39',NULL);

COMMIT;

#
# Structure for the `tipo_liced` table : 
#

DROP TABLE IF EXISTS `tipo_liced`;

CREATE TABLE `tipo_liced` (
  `codigo` int(255) NOT NULL AUTO_INCREMENT,
  `co_tipo_lice` varchar(6) NOT NULL,
  `co_modulo` varchar(6) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `created_user` varchar(255) DEFAULT NULL,
  `updated_user` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `co_tipo_lice` (`co_tipo_lice`,`co_modulo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

#
# Data for the `tipo_liced` table  (LIMIT 0,500)
#

INSERT INTO `tipo_liced` (`codigo`, `co_tipo_lice`, `co_modulo`, `descripcion`, `created_user`, `updated_user`, `created_at`, `updated_at`, `deleted_at`) VALUES 
  (1,'BASIC','DASH1','MUESTRA EL DAHS 1','ADMIN','ADMIN','2016-01-13 00:09:17','2016-01-13 00:09:17',NULL),
  (2,'BASIC','DASH2','MUESTRA EL DAHS 2','ADMIN','ADMIN','2016-01-13 00:09:17','2016-01-13 00:09:17',NULL),
  (3,'BASIC','DASH3','MUESTRA EL DAHS 3','ADMIN','ADMIN','2016-01-13 00:09:17','2016-01-13 00:09:17',NULL),
  (4,'BASIC','VENTAS','MODULO VENTAS','ADMIN','ADMIN','2016-01-13 00:09:17','2016-01-13 00:09:17',NULL),
  (5,'BASIC','COMPRA','MODULO COMPRAS','ADMIN','ADMIN','2016-01-13 00:09:17','2016-01-13 00:09:17',NULL),
  (6,'BASIC','CXC','MODULO CXC','ADMIN','ADMIN','2016-01-13 00:09:17','2016-01-13 00:09:17',NULL),
  (7,'BASIC','CXP','MODULO CXP','ADMIN','ADMIN','2016-01-13 00:09:17','2016-01-13 00:09:17',NULL),
  (8,'BASIC','ORDCOM','MODULO ORDCOMP','ADMIN','ADMIN','2016-01-13 00:09:17','2016-01-13 00:09:17',NULL),
  (9,'BASIC','PPTO','MODULO PPTO','ADMIN','ADMIN','2017-01-25 16:13:25','2017-01-25 16:13:25',NULL),
  (10,'BASIC','BANCOS','MODULO BANCOS','ADMIN','ADMIN','2017-01-25 16:29:03','2017-01-25 16:29:03',NULL);

COMMIT;

#
# Definition for the `ObtenerInformacionClientes` procedure : 
#

DROP PROCEDURE IF EXISTS `ObtenerInformacionClientes`;

CREATE PROCEDURE `ObtenerInformacionClientes`(
				IN lcEmail 	VARCHAR(255),
				IN lcPassword	VARCHAR(255))
    NOT DETERMINISTIC
    SQL SECURITY DEFINER
    COMMENT ''
BEGIN
DECLARE mensaje1 varchar(255);
DECLARE mensaje2 VARCHAR(255);
DECLARE mensaje3 VARCHAR(255);
DECLARE mensaje4 VARCHAR(255);
DECLARE mensaje5 VARCHAR(255);
DECLARE mensaje6 VARCHAR(255);
DECLARE mensaje7 VARCHAR(255);
SET mensaje3 = 'Usuario y/o clave incorrecta';  #al no coincidir datos el SP no mostrara datos por ende el usuario o contrase;a son incorrectas
SET mensaje4 = 'Licencia próxima a vencer en XX días.';  #diferencia entre fecha fin y el dia actual
##SET mensaje5 = 'Producto elegido no contratado';   #no aplicar
SET mensaje6 = 'Usuario inactivo comuníquese con soporte';  #usuarioInactivo  = 1
	IF (NOT(lcEmail IS NULL) AND (NOT lcPassword IS NULL)) THEN
				
		
		SELECT a.id,a.nombre,a.email,a.password,a.remember_token,a.co_cli,a.nombre,a.apellido,a.descripcion,a.borrado as usuarioInactivo,
		       a.created_at,a.updated_at,a.deleted_at,
		       b.co_licencia,b.co_tipo_licencia,b.co_pro,b.dw_server,b.dw_dbname,b.dw_user,b.dw_pass,b.dw_port,b.borrado AS licenciaInactiva,
		       c.fe_inicio,c.fe_fin
		FROM clientes AS a         INNER JOIN licencias           AS b ON a.co_cli 	= b.co_cli
					   INNER JOIN licenciasDetalle    AS c ON b.id	= c.id_licencia AND
								    c.borrado = 0
		WHERE a.email = lcEmail AND a.password =lcPassword;
		
	END IF;	
END;

