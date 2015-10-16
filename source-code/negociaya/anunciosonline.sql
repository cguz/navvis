/*
SQLyog Community Edition- MySQL GUI v6.16
MySQL - 5.0.51a-community-nt : Database - anunciosonline
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

create database if not exists `anunciosonline`;

USE `anunciosonline`;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `anuncio` */

DROP TABLE IF EXISTS `anuncio`;

CREATE TABLE `anuncio` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `codigo_ciudad` varchar(10) NOT NULL,
  `particular` char(1) NOT NULL default '0',
  `categoria_id` int(10) unsigned NOT NULL,
  `vende` char(1) NOT NULL default '0',
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` varchar(20) NOT NULL default '0',
  `publicar` char(1) NOT NULL default '0',
  `comentario` text,
  `usuario_id` int(10) unsigned NOT NULL,
  `fecha` datetime NOT NULL,
  `contactos` int(10) unsigned default '0',
  `revisado` char(1) default '0',
  `visitas` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `anuncio` */

insert  into `anuncio`(`id`,`codigo_ciudad`,`particular`,`categoria_id`,`vende`,`titulo`,`descripcion`,`precio`,`publicar`,`comentario`,`usuario_id`,`fecha`,`contactos`,`revisado`,`visitas`) values (1,'BAD','1',4,'1','Juego FAMA','Espectacular Juego hecho en Turbo C para DOS, maneja colores y cursores de teclado.','10','1','ok',1,'2008-05-19 17:40:50',0,'1',8),(2,'ALB','0',11,'1','Sipote Casa Ya','Sipote casa frente a las playas de Cartagena, mejor dicho ta bien pupis nice, bien buena pa armar el rumbon ya tu sabes...\r\n\r\nEl Cesar...','150000','1','porq si!!',2,'2008-05-19 17:40:50',0,'1',2),(3,'ALI','1',3,'1','prueba','prueba','3210','0','porq no!!!',3,'2008-05-19 18:40:22',0,'1',0);

/*Table structure for table `categoria` */

DROP TABLE IF EXISTS `categoria`;

CREATE TABLE `categoria` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(255) NOT NULL,
  `grupo` varchar(255) NOT NULL,
  `filtros` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idu_nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

/*Data for the table `categoria` */

insert  into `categoria`(`id`,`nombre`,`grupo`,`filtros`) values (1,'Coches','VEHÍCULOS',''),(2,'Accesorios de Coches','VEHÍCULOS',''),(3,'Motos','VEHÍCULOS',''),(4,'Quads','VEHÍCULOS',''),(5,'Accesorios de Motos','VEHÍCULOS',''),(6,'Caravanas','VEHÍCULOS',''),(7,'Barcos y Náutica','VEHÍCULOS',''),(8,'Vehículos Industriales','VEHÍCULOS',''),(9,'Pisos','INMOBILIARIA',''),(10,'Casas y Chalés','INMOBILIARIA',''),(11,'Parcelas y Terrenos','INMOBILIARIA',''),(12,'Garajes y Trasteros','INMOBILIARIA',''),(13,'Locales, Oficinas y Naves','INMOBILIARIA',''),(14,'Alquiler para Vacaciones','INMOBILIARIA',''),(15,'Informática y Juegos','ELECTRÓNICA',''),(16,'Audio, Video y Fotografía','ELECTRÓNICA',''),(17,'Teléfonos y Otros Electrónica','ELECTRÓNICA',''),(18,'Deportes','OCIO Y DEPORTE',''),(19,'Animales','OCIO Y DEPORTE',''),(20,'Música, Películas y Libros','OCIO Y DEPORTE',''),(21,'Tiempo Libre y Otros','OCIO Y DEPORTE',''),(22,'Coleccionables','OCIO Y DEPORTE',''),(23,'Para la Casa','CASA Y JARDÍN',''),(24,'Para Jardín y Agricultura','CASA Y JARDÍN',''),(25,'Para los niños','CASA Y JARDÍN',''),(26,'Ropa, Complementos y Joyas','CASA Y JARDÍN',''),(27,'Negocios y Traspasos','NEGOCIOS Y EMPLEO',''),(28,'Empleo','NEGOCIOS Y EMPLEO',''),(29,'Enseñanza','NEGOCIOS Y EMPLEO',''),(30,'Servicios Profesionales','NEGOCIOS Y EMPLEO',''),(31,'Otros','---','');

/*Table structure for table `ciudad` */

DROP TABLE IF EXISTS `ciudad`;

CREATE TABLE `ciudad` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(255) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idu_codigo` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

/*Data for the table `ciudad` */

insert  into `ciudad`(`id`,`nombre`,`codigo`) values (1,'Álava/Araba','ALA'),(2,'Albacete','ALB'),(3,'Alicante/Alacant','ALI'),(4,'Almería','ALM'),(5,'Asturias','AST'),(6,'Ávila','AVI'),(7,'Badajoz','BAD'),(8,'Baleares/Balears','BAL'),(9,'Barcelona','BAR'),(10,'Burgos','BUR'),(11,'Cáceres','CAC'),(12,'Cádiz','CAD'),(13,'Cantabria','CAN'),(14,'Castellón/Castelló','CAS'),(15,'Ceuta','CEU'),(16,'Ciudad Real','CIU'),(17,'Córdoba','COR'),(18,'Cuenca','CUE'),(19,'Girona','GIR'),(20,'Granada','GRA'),(21,'Guadalajara','GUA'),(22,'Guipúzcoa/Gipuzkoa','GUI'),(23,'Huelva','HUE'),(24,'Huesca','HUS'),(25,'Jaén','JAE'),(26,'La Coruña/A Coruña','LAC'),(27,'La Rioja','LAR'),(28,'Las Palmas','LAS'),(29,'León','LEO'),(30,'Lleida','LLE'),(31,'Lugo','LUG'),(32,'Madrid','MAD'),(33,'Málaga','MAL'),(34,'Melilla','MEL'),(35,'Murcia','MUR'),(36,'Navarra','NAV'),(37,'Orense/Ourense','ORE'),(38,'Palencia','PAL'),(39,'Pontevedra','PON'),(40,'Salamanca','SAL'),(41,'Segovia','SEG'),(42,'Sevilla','SEV'),(43,'Soria','SOR'),(44,'Sta. C. de Tenerife','STA'),(45,'Tarragona','TAR'),(46,'Teruel','TER'),(47,'Toledo','TOL'),(48,'Valencia/València','VAL'),(49,'Valladolid','VAA'),(50,'Vizcaya/Bizkaia','VIZ'),(51,'Zamora','ZAM'),(52,'Zaragoza','ZAR');

/*Table structure for table `imagen` */

DROP TABLE IF EXISTS `imagen`;

CREATE TABLE `imagen` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `url` text,
  `anuncio_id` int(10) unsigned NOT NULL,
  `ruta` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `imagen` */

insert  into `imagen`(`id`,`url`,`anuncio_id`,`ruta`) values (7,'./archivos/1211557273_HOLA.png',2,'D:/Documentos/my_desarrollo/AnunciosOnLine/source/archivos/1211557273_HOLA.png');

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `contrasena` varchar(50) NOT NULL,
  `administrador` char(1) NOT NULL default '0',
  `mostrar_tel` char(1) default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idu_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `usuario` */

insert  into `usuario`(`id`,`nombre`,`email`,`telefono`,`contrasena`,`administrador`,`mostrar_tel`) values (1,'Cesar Guzman','cesar@example.com','9876543210','14413cf3d2d081ed52b2860afbaa450087b35034','0','1'),(3,'prueba','prueba@example.com','987654','14413cf3d2d081ed52b2860afbaa450087b35034','0','1');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
