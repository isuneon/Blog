# SQL Manager 2005 for MySQL 3.7.0.1
# ---------------------------------------
# Host     : localhost
# Port     : 3306
# Database : basededatosaconectar


SET FOREIGN_KEY_CHECKS=0;

DROP DATABASE IF EXISTS `basededatosaconectar`;

CREATE DATABASE `basededatosaconectar`
    CHARACTER SET 'latin1'
    COLLATE 'latin1_swedish_ci';

USE `basededatosaconectar`;

#
# Structure for the `blog` table : 
#

DROP TABLE IF EXISTS `blog`;

CREATE TABLE `blog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Definition for the `ObtenerInformacionBlog` procedure : 
#

DROP PROCEDURE IF EXISTS `ObtenerInformacionBlog`;

CREATE PROCEDURE `ObtenerInformacionBlog`(IN idBlog INTEGER(11))
    NOT DETERMINISTIC
    SQL SECURITY DEFINER
    COMMENT ''
BEGIN
     SELECT * from `blog` WHERE id = idBlog;
END;

#
# Definition for the `ObtenerInformacionBlogs` procedure : 
#

DROP PROCEDURE IF EXISTS `ObtenerInformacionBlogs`;

CREATE PROCEDURE `ObtenerInformacionBlogs`()
    NOT DETERMINISTIC
    SQL SECURITY DEFINER
    COMMENT ''
BEGIN
     SELECT * FROM `blog`;
END;

