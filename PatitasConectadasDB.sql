-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: dejandohuelladb
-- ------------------------------------------------------
-- Server version	8.0.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `actividadesvoluntarios`
--

DROP TABLE IF EXISTS `actividadesvoluntarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `actividadesvoluntarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `voluntario` int NOT NULL,
  `actividad` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_actividades_voluntario` (`voluntario`),
  CONSTRAINT `fk_actividades_voluntario` FOREIGN KEY (`voluntario`) REFERENCES `voluntarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividadesvoluntarios`
--

LOCK TABLES `actividadesvoluntarios` WRITE;
/*!40000 ALTER TABLE `actividadesvoluntarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `actividadesvoluntarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adopciones`
--

DROP TABLE IF EXISTS `adopciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adopciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `usuario` int NOT NULL,
  `mascota` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_adopciones_usuario` (`usuario`),
  KEY `fk_adopciones_mascota` (`mascota`),
  KEY `idx_adopciones_fecha` (`fecha`),
  CONSTRAINT `fk_adopciones_mascota` FOREIGN KEY (`mascota`) REFERENCES `mascotas` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_adopciones_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adopciones`
--

LOCK TABLES `adopciones` WRITE;
/*!40000 ALTER TABLE `adopciones` DISABLE KEYS */;
INSERT INTO `adopciones` VALUES (13,'2025-08-15 20:04:26',16,9),(14,'2025-08-15 20:04:45',8,2);
/*!40000 ALTER TABLE `adopciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `campanias`
--

DROP TABLE IF EXISTS `campanias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `campanias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `fechaInicio` datetime NOT NULL,
  `fechaFin` datetime NOT NULL,
  `objetivo` decimal(10,2) NOT NULL,
  `estado` enum('Activa','Inactiva','Planificada') NOT NULL DEFAULT 'Activa',
  `usuario` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_campanias_usuario` (`usuario`),
  KEY `idx_campanias_estado` (`estado`),
  KEY `idx_campanias_fechas` (`fechaInicio`,`fechaFin`),
  CONSTRAINT `fk_campanias_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campanias`
--

LOCK TABLES `campanias` WRITE;
/*!40000 ALTER TABLE `campanias` DISABLE KEYS */;
INSERT INTO `campanias` VALUES (17,'Esteriliza SJ','Jornada de esterilización en SJ','2025-08-05 09:00:00','2025-08-10 17:00:00',15000.00,'Activa',6),(18,'Alimento X Todos','Recolección de alimento','2025-08-01 08:00:00','2025-08-31 18:00:00',20000.00,'Activa',7),(19,'Vacuna Patitas','Campaña de vacunación','2025-09-01 09:00:00','2025-09-07 17:00:00',12000.00,'Activa',8),(20,'Hogar Temporal','Captación de hogares','2025-08-15 10:00:00','2025-09-15 18:00:00',8000.00,'Activa',9),(21,'Medicinas CR','Donación de medicinas','2025-08-10 09:00:00','2025-08-25 17:00:00',6000.00,'Activa',10),(22,'Día del Perrito','Evento familiar benéfico','2025-08-20 09:00:00','2025-08-20 17:00:00',3000.00,'Activa',11),(23,'Esteriliza II','Nueva jornada','2025-10-05 09:00:00','2025-10-10 17:00:00',16000.00,'Activa',12),(24,'Alimento Navidad','Recolección navideña','2025-12-01 08:00:00','2025-12-24 18:00:00',2500.00,'Activa',13),(25,'Medicinas II','Refuerzo medicinas','2025-09-10 09:00:00','2025-09-30 17:00:00',9000.00,'Activa',14),(26,'Higiene y Salud','Kits de higiene','2025-08-12 09:00:00','2025-08-22 17:00:00',4000.00,'Activa',15),(27,'Casitas','Construcción de casas','2025-08-18 09:00:00','2025-09-30 17:00:00',30000.00,'Activa',16),(28,'Rescate Rural','Apoyo zonas rurales','2025-08-25 09:00:00','2025-09-05 17:00:00',7000.00,'Activa',17),(29,'Consulta Gratuita','Atención veterinaria','2025-09-15 09:00:00','2025-09-15 17:00:00',2000.00,'Inactiva',18),(30,'AdoptaFest','Feria de adopción','2025-08-28 09:00:00','2025-08-28 16:00:00',15000.00,'Inactiva',19),(31,'Transportes','Fondo de transporte','2025-08-07 09:00:00','2025-09-07 17:00:00',50000.00,'Inactiva',20);
/*!40000 ALTER TABLE `campanias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `donacionescampanias`
--

DROP TABLE IF EXISTS `donacionescampanias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `donacionescampanias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `usuario` int NOT NULL,
  `campania` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_donaciones_usuario` (`usuario`),
  KEY `fk_donaciones_campania` (`campania`),
  KEY `idx_donaciones_fecha` (`fecha`),
  CONSTRAINT `fk_donaciones_campania` FOREIGN KEY (`campania`) REFERENCES `campanias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_donaciones_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `donacionescampanias`
--

LOCK TABLES `donacionescampanias` WRITE;
/*!40000 ALTER TABLE `donacionescampanias` DISABLE KEYS */;
INSERT INTO `donacionescampanias` VALUES (2,'2025-08-06 10:00:00',50000.00,6,17),(3,'2025-08-06 10:30:00',30000.00,7,17),(4,'2025-08-07 11:00:00',45000.00,8,18),(5,'2025-08-07 11:20:00',25000.00,9,18),(6,'2025-08-08 09:00:00',60000.00,10,20),(7,'2025-08-08 09:30:00',15000.00,11,20),(8,'2025-08-09 14:00:00',20000.00,12,21),(9,'2025-08-09 14:30:00',35000.00,13,21),(10,'2025-08-10 10:15:00',40000.00,14,22),(11,'2025-08-10 10:45:00',22000.00,15,22),(12,'2025-08-11 12:00:00',52000.00,16,26),(13,'2025-08-11 12:30:00',27000.00,17,26),(14,'2025-08-12 16:00:00',30000.00,18,27),(15,'2025-08-12 16:20:00',45000.00,19,28),(16,'2025-08-13 09:50:00',28000.00,20,31),(17,'2025-08-19 19:42:21',100.00,2,28);
/*!40000 ALTER TABLE `donacionescampanias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` datetime NOT NULL,
  `ubicacion` varchar(255) NOT NULL,
  `responsable` int NOT NULL,
  `tipo` enum('Presencial','Virtual') NOT NULL,
  `estado` enum('En curso','Planificado','Finalizado') NOT NULL DEFAULT 'Planificado',
  PRIMARY KEY (`id`),
  KEY `fk_eventos_responsable` (`responsable`),
  KEY `idx_eventos_fecha` (`fecha`),
  CONSTRAINT `fk_eventos_responsable` FOREIGN KEY (`responsable`) REFERENCES `usuarios` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos`
--

LOCK TABLES `eventos` WRITE;
/*!40000 ALTER TABLE `eventos` DISABLE KEYS */;
INSERT INTO `eventos` VALUES (1,'Evento de prueba','prueba','2025-08-29 18:00:00','San José ',1,'Virtual','Planificado'),(2,'PRueba2','dawdaw','2025-08-15 22:22:00','San José ',1,'Presencial','Planificado'),(3,'Feria Adopción SJ','Adopciones y charlas','2025-08-15 10:00:00','Parque Central SJ',6,'Presencial','Planificado'),(4,'Webinar Cuidados','Cuidados básicos','2025-08-16 18:00:00','Zoom',7,'Virtual','Planificado'),(5,'Caminata Mascotas','Recreativo','2025-08-17 08:00:00','Boulevard Rohrmoser',8,'Presencial','Planificado'),(6,'Taller Rescate','Capacitación','2025-08-18 09:00:00','Oficinas DH',9,'Presencial','Planificado'),(7,'Jornada Vacunación','Vacunas a bajo costo','2025-08-19 09:00:00','Barrio Dent',10,'Presencial','Planificado'),(8,'Encuentro Voluntarios','Organización actividades','2025-08-20 17:30:00','Casa Comunal',11,'Presencial','Planificado'),(9,'Foro Adopción','Buenas prácticas','2025-08-21 19:00:00','Teams',12,'Virtual','Planificado'),(10,'Feria Heredia','Adopciones','2025-08-22 10:00:00','Parque Heredia',13,'Presencial','Planificado'),(11,'Clínica Gratuita','Atención básica','2025-08-23 09:00:00','Salón Comunal',14,'Presencial','Finalizado'),(12,'Taller Tenencia','Tenencia responsable','2025-08-24 10:00:00','Zoom',15,'Virtual','Finalizado'),(13,'Kermés Solidaria','Recaudación fondos','2025-08-25 11:00:00','Escuela Local',16,'Presencial','Finalizado'),(14,'Jornada Esterilización','Esterilizaciones','2025-08-26 09:00:00','Barrio México',17,'Presencial','En curso'),(15,'Encuentro Adoptantes','Seguimiento','2025-08-27 17:00:00','Teams',18,'Virtual','En curso'),(16,'Expo Mascotas','Exposición y adopción','2025-08-28 10:00:00','Antigua Aduana',19,'Presencial','En curso'),(17,'Cierre de Mes','Balance de campañas','2025-08-31 16:00:00','Oficinas DH',20,'Presencial','En curso');
/*!40000 ALTER TABLE `eventos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventosasistencia`
--

DROP TABLE IF EXISTS `eventosasistencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventosasistencia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `evento` int NOT NULL,
  `usuario` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_evento_usuario` (`evento`,`usuario`),
  KEY `fk_asistencia_usuario` (`usuario`),
  CONSTRAINT `fk_asistencia_evento` FOREIGN KEY (`evento`) REFERENCES `eventos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_asistencia_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventosasistencia`
--

LOCK TABLES `eventosasistencia` WRITE;
/*!40000 ALTER TABLE `eventosasistencia` DISABLE KEYS */;
INSERT INTO `eventosasistencia` VALUES (1,2,2),(17,3,2),(2,3,7),(3,3,8),(4,4,6),(5,4,9),(6,5,10),(7,5,11),(8,6,12),(9,6,13),(10,7,14),(11,7,15),(12,8,16),(13,9,17),(14,10,18),(15,11,19),(16,12,20);
/*!40000 ALTER TABLE `eventosasistencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historialmedico`
--

DROP TABLE IF EXISTS `historialmedico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historialmedico` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mascota` int NOT NULL,
  `fecha_consulta` date NOT NULL,
  `motivo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diagnostico` text COLLATE utf8mb4_unicode_ci,
  `tratamiento` text COLLATE utf8mb4_unicode_ci,
  `veterinario` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `peso_kg` decimal(5,2) DEFAULT NULL,
  `temperatura_c` decimal(4,1) DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `proximo_control` date DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `adjunto_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_hist_mascota_fecha` (`mascota`,`fecha_consulta` DESC),
  KEY `idx_hist_mascota_control` (`mascota`,`proximo_control`),
  CONSTRAINT `fk_hist_mascota` FOREIGN KEY (`mascota`) REFERENCES `mascotas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historialmedico`
--

LOCK TABLES `historialmedico` WRITE;
/*!40000 ALTER TABLE `historialmedico` DISABLE KEYS */;
INSERT INTO `historialmedico` VALUES (3,18,'2025-08-07','Diagnostico de prueba','Diagnostico de prueba','Diagnostico de prueba','Dr.Justin',45.00,22.0,'0','2025-08-18',0,'','2025-08-21 01:48:39','2025-08-21 02:02:40'),(4,18,'2025-08-21','Otro Diagnostico de prueba','Otro Diagnostico de prueba','Otro Diagnostico de prueba','Otro Diagnostico de prueba',40.00,25.0,'Otro Diagnostico de prueba','2025-08-27',0,'','2025-08-21 02:03:05','2025-08-21 02:03:32'),(5,16,'2025-08-21','Está enferma','Está enferma','Está enferma','Dr.Justin',8.00,22.0,'No hay observaciones','2025-08-27',1,'https://lista-de-regalos-te-cocina.my.canva.site/plantilla-de-historial-m-dico-para-patitas-conectadas','2025-08-21 02:05:30','2025-08-21 02:09:53'),(6,17,'2025-08-21','Otro Diagnostico de prueba','Otro Diagnostico de prueba','Otro Diagnostico de prueba','Dr.Justin',25.00,22.0,'Otro Diagnostico de prueba','2025-08-20',0,'','2025-08-21 03:11:31','2025-08-21 03:11:50');
/*!40000 ALTER TABLE `historialmedico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventario`
--

DROP TABLE IF EXISTS `inventario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `cantidad` int NOT NULL,
  `fechaIngreso` datetime NOT NULL,
  `fechaCaducidad` datetime DEFAULT NULL,
  `proveedor` varchar(100) NOT NULL,
  `fuente` enum('Compra','Donación') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventario`
--

LOCK TABLES `inventario` WRITE;
/*!40000 ALTER TABLE `inventario` DISABLE KEYS */;
INSERT INTO `inventario` VALUES (1,'Concentrado Adulto','Alimento',10,'2025-08-01 09:00:00','2026-02-01 00:00:00','PetFoods CR','Donación'),(2,'Concentrado Cachorro','Alimento',8,'2025-08-02 10:00:00','2026-01-15 00:00:00','PetFoods CR','Compra'),(3,'Arena Sanitaria','Limpieza',20,'2025-08-03 11:00:00',NULL,'CatCare','Compra'),(4,'Pipetas Antipulgas','Medicamento',30,'2025-08-04 12:00:00','2026-08-01 00:00:00','VetLine','Donación'),(5,'Vendajes','Insumos',50,'2025-08-05 13:00:00',NULL,'SaludVet','Donación'),(6,'Shampoo Medicado','Medicamento',12,'2025-08-06 14:00:00','2026-03-01 00:00:00','VetLine','Compra'),(7,'Jeringas','Insumos',100,'2025-08-07 15:00:00',NULL,'SaludVet','Compra'),(8,'Antibióticos','Medicamento',15,'2025-08-08 16:00:00','2026-05-01 00:00:00','VetLine','Donación'),(9,'Collares','Accesorios',25,'2025-08-09 09:30:00',NULL,'PetShopCR','Compra'),(10,'Correas','Accesorios',25,'2025-08-09 09:40:00',NULL,'PetShopCR','Compra'),(11,'Platos','Accesorios',20,'2025-08-10 10:00:00',NULL,'PetShopCR','Donación'),(12,'Transportadoras','Accesorios',5,'2025-08-10 10:20:00',NULL,'PetShopCR','Donación'),(13,'Guantes','Insumos',200,'2025-08-11 11:00:00',NULL,'SaludVet','Compra'),(14,'Desparasitantes','Medicamento',40,'2025-08-12 12:00:00','2027-01-01 00:00:00','VetLine','Compra'),(15,'Snacks','Alimento',30,'2025-08-13 13:00:00','2026-04-01 00:00:00','PetFoods CR','Donación');
/*!40000 ALTER TABLE `inventario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mascotas`
--

DROP TABLE IF EXISTS `mascotas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mascotas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `raza` varchar(100) NOT NULL,
  `edad` int NOT NULL,
  `descripcion` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `estado` enum('Disponible','Adoptado','En comunicación','En tratamiento') NOT NULL DEFAULT 'Disponible',
  `usuario` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mascotas_usuarios` (`usuario`),
  KEY `idx_mascotas_estado` (`estado`),
  CONSTRAINT `fk_mascotas_usuarios` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mascotas`
--

LOCK TABLES `mascotas` WRITE;
/*!40000 ALTER TABLE `mascotas` DISABLE KEYS */;
INSERT INTO `mascotas` VALUES (1,'Tokyo','Salchicha',3,'Perro macho, amistoso con niños y educado','https://upload.wikimedia.org/wikipedia/commons/thumb/f/f4/MiniDachshund1_wb.jpg/330px-MiniDachshund1_wb.jpg','Disponible',2),(2,'Tara','Pastor Aleman',8,'La mascota ideal que todo dueño sueña con tener.','https://preview.redd.it/my-9-year-old-gsd-v0-lk1sb4v4imae1.jpg?width=1080&crop=smart&auto=webp&s=df39e13e52b26e64d4cfc615a21a769bd6a796b6','Adoptado',1),(3,'Atena','Pastor Aleman',2,'Hermosa mascota para todo tipo de familia','https://upload.wikimedia.org/wikipedia/commons/thumb/9/94/Cane_da_pastore_tedesco_adulto.jpg/640px-Cane_da_pastore_tedesco_adulto.jpg','Disponible',1),(4,'Luna','Mestizo',2,'Cariñosa y juguetona','https://resizer.glanacion.com/resizer/v2/perro-mestizo-que-es-caracteristicas-y-ventajas-FHQ5SODPSZF55IJJVMBUD4ZSYI.png?auth=45e766a279e2e932f0bde71da1f62874e1d4386af08716aa710500bbae064692&width=1280&height=854&quality=70&smart=true','Disponible',6),(5,'Max','Labrador',4,'Muy sociable y activo','https://cdn.pixabay.com/photo/2020/11/12/13/46/labrador-retriever-5735584_1280.jpg','Disponible',7),(6,'Coco','Poodle',3,'Pequeño y dócil','https://www.lavanguardia.com/files/og_thumbnail/files/fp/uploads/2024/02/29/65e0a25a86bd5.r_d.1686-1147-2822.jpeg','Disponible',8),(7,'Rocky','Pitbull',5,'Energético, requiere ejercicio','https://cdn0.uncomo.com/es/posts/4/9/4/red_nose_pitbull_45494_7_600.jpg','Disponible',9),(8,'Nala','Beagle',2,'Curiosa y amistosa','https://upload.wikimedia.org/wikipedia/commons/thumb/f/f5/MiloSmet.JPG/960px-MiloSmet.JPG','Disponible',10),(9,'Simba','Golden Retriever',1,'Cachorro muy listo','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTR6hnUHjTJk4n8POzOqEcOYoouYjLiDO8juQ&s','Adoptado',11),(10,'Mia','Siamés',3,'Gatita tranquila','https://www.infobae.com/new-resizer/7XuJqfeRF-dnk19gl7mUG21Ksmw=/arc-anglerfish-arc2-prod-infobae/public/EZSTXGDBEJGQFG3SDCFVSVY2N4.jpg','Disponible',12),(11,'Thor','Husky',1,'Le encanta correr','https://http2.mlstatic.com/D_Q_NP_2X_621461-MCR89560894903_082025-N.webp','Disponible',13),(12,'Bella','Border Collie',2,'Muy inteligente','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT7qau7bfpzt5oc1CFyCECwVl_iEX_jPvy6LA&s','Disponible',14),(13,'Toby','Bulldog',1,'Calmado y noble','https://mascotastoday.com/wp-content/uploads/2022/02/bulldogingles-mascotastoday.jpg','Disponible',15),(14,'Kira','Pastor Alemán',1,'Protectora y leal','https://http2.mlstatic.com/D_NQ_NP_2X_756506-MCR84660953255_052025-N.webp','Disponible',16),(15,'Bruno','Boxer',4,'Juguetón y fuerte','https://cdn.pixabay.com/photo/2024/12/27/19/02/dog-9294746_1280.jpg','Disponible',17),(16,'Lola','Cocker',1,'Tierna y cariñosa','https://limaonepets.com/wp-content/uploads/2023/05/Mesa-de-trabajo-1-1024x1024.jpg','En tratamiento',18),(17,'Milo','Mestizo',1,'Muy sociable','https://cdn0.expertoanimal.com/es/posts/1/9/7/como_saber_de_que_tamano_sera_un_perro_mestizo_22791_600.jpg','Disponible',19),(18,'Olaf','Mestizo',1,'Travieso y curioso.','https://upload.wikimedia.org/wikipedia/commons/thumb/8/8c/Poligraf_Poligrafovich.JPG/640px-Poligraf_Poligrafovich.JPG','Disponible',20);
/*!40000 ALTER TABLE `mascotas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reportes`
--

DROP TABLE IF EXISTS `reportes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reportes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `usuario` int NOT NULL,
  `mascota` int DEFAULT NULL,
  `provincia` varchar(100) NOT NULL,
  `canton` varchar(100) NOT NULL,
  `distrito` varchar(100) NOT NULL,
  `detalles` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_reportes_usuario` (`usuario`),
  KEY `fk_reportes_mascota` (`mascota`),
  KEY `idx_reportes_fecha` (`fecha`),
  CONSTRAINT `fk_reportes_mascota` FOREIGN KEY (`mascota`) REFERENCES `mascotas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_reportes_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reportes`
--

LOCK TABLES `reportes` WRITE;
/*!40000 ALTER TABLE `reportes` DISABLE KEYS */;
INSERT INTO `reportes` VALUES (1,'2025-08-01 08:00:00',6,NULL,'San José','Central','Carmen','Avistamiento de perro sin collar'),(2,'2025-08-01 18:30:00',7,4,'San José','Escazú','San Rafael','Seguimiento posadopción'),(3,'2025-08-02 07:45:00',8,NULL,'Alajuela','Central','San José','Gato herido en vía pública'),(4,'2025-08-02 20:10:00',9,NULL,'Cartago','La Unión','Tres Ríos','Reporte de abandono'),(5,'2025-08-03 09:25:00',10,5,'Heredia','Belén','San Antonio','Visita de verificación'),(6,'2025-08-03 17:15:00',11,NULL,'Guanacaste','Carrillo','Sardinal','Avistamiento con sarna'),(7,'2025-08-04 12:40:00',12,6,'Puntarenas','Central','Puntarenas','Seguimiento baño medicado'),(8,'2025-08-04 22:05:00',13,NULL,'Limón','Pococí','Guápiles','Perro extraviado'),(9,'2025-08-05 10:50:00',14,NULL,'San José','Desamparados','San Rafael Arriba','Cachorro encontrado'),(10,'2025-08-05 19:00:00',15,7,'San José','Goicoechea','Guadalupe','Revisión conducta'),(11,'2025-08-06 08:30:00',16,NULL,'Alajuela','San Carlos','Quesada','Gato atropellado'),(12,'2025-08-06 14:10:00',17,NULL,'Cartago','Oreamuno','San Rafael','Hogar temporal requerido'),(13,'2025-08-07 16:35:00',18,8,'Heredia','Santo Domingo','Santo Domingo','Control posadopción'),(14,'2025-08-07 21:20:00',19,NULL,'Guanacaste','Liberia','Liberia','Camada abandonada'),(15,'2025-08-08 11:00:00',20,NULL,'Puntarenas','Garabito','Jacó','Denuncia de maltrato');
/*!40000 ALTER TABLE `reportes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` enum('Administrador','Usuario','Voluntario') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador'),(2,'Usuario'),(3,'Voluntario');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tareasvoluntariado`
--

DROP TABLE IF EXISTS `tareasvoluntariado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tareasvoluntariado` (
  `id` int NOT NULL AUTO_INCREMENT,
  `voluntario` int NOT NULL,
  `titulo` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `fecha_asignacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_limite` datetime DEFAULT NULL,
  `estado` enum('Pendiente','En progreso','Completada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pendiente',
  `prioridad` enum('Baja','Media','Alta') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Media',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_tareas_vol` (`voluntario`,`estado`,`fecha_limite`),
  CONSTRAINT `fk_tarea_voluntario` FOREIGN KEY (`voluntario`) REFERENCES `voluntarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tareasvoluntariado`
--

LOCK TABLES `tareasvoluntariado` WRITE;
/*!40000 ALTER TABLE `tareasvoluntariado` DISABLE KEYS */;
INSERT INTO `tareasvoluntariado` VALUES (1,1,'Dar de comer','Dar de comer','2025-08-20 20:33:24',NULL,'Pendiente','Media','2025-08-21 02:33:24','2025-08-21 02:33:24'),(2,1,'Barrer','Barrer','2025-08-20 20:33:35',NULL,'En progreso','Alta','2025-08-21 02:33:35','2025-08-21 02:33:35');
/*!40000 ALTER TABLE `tareasvoluntariado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `rol` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_usuarios_roles` (`rol`),
  CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`rol`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Admin','Admin','admin@gmail.com','$2b$10$xB5XOJoFb8Wkdj4.zFySYuIfC7SzpxQT7WApDiXDS9ao.bZdhxK2W','8888-0001',1),(2,'Justin','Usuario','usuario@gmail.com','$2b$10$BHWknxZsMbeqrV9P8gV.7eX4EiZEu4KgvPER8RbA0NEbC6s87bywO','8888-0002',2),(3,'Voluntario','Voluntario','voluntario@gmail.com','$2b$10$jULFt6czxlx0pxlKb13VBufMYScFQqgf7lUd3aAWlX6/3fS.dNXPa','8888-0003',3),(5,'Justin','Esquivel','jesquivel@gmail.com','$2y$10$kLIh.o8u64TyH3GLpuzw1OP7LVUdVvafJvRUHwWNG8bd20Q0OM8GS','88151588',3),(6,'Ana','Ramírez','user1@dejandohuella.cr','$2b$10$BHWknxZsMbeqrV9P8gV.7eX4EiZEu4KgvPER8RbA0NEbC6s87bywO','7000-0001',2),(7,'Bruno','Soto','user2@dejandohuella.cr','$2b$10$BHWknxZsMbeqrV9P8gV.7eX4EiZEu4KgvPER8RbA0NEbC6s87bywO','7000-0002',2),(8,'Carla','Jiménez','user3@dejandohuella.cr','$2b$10$BHWknxZsMbeqrV9P8gV.7eX4EiZEu4KgvPER8RbA0NEbC6s87bywO','7000-0003',2),(9,'Diego','Mora','user4@dejandohuella.cr','$2b$10$BHWknxZsMbeqrV9P8gV.7eX4EiZEu4KgvPER8RbA0NEbC6s87bywO','7000-0004',2),(10,'Elena','Castro','user5@dejandohuella.cr','$2b$10$BHWknxZsMbeqrV9P8gV.7eX4KgvPER8RbA0NEbC6s87bywO','7000-0005',2),(11,'Fabio','Vargas','user6@dejandohuella.cr','$2b$10$BHWknxZsMbeqrV9P8gV.7eX4EiZEu4KgvPER8RbA0NEbC6s87bywO','7000-0006',2),(12,'Gina','Zúñiga','user7@dejandohuella.cr','$2b$10$BHWknxZsMbeqrV9P8gV.7eX4EiZEu4KgvPER8RbA0NEbC6s87bywO','7000-0007',2),(13,'Héctor','Rojas','user8@dejandohuella.cr','$2b$10$BHWknxZsMbeqrV9P8gV.7eX4EiZEu4KgvPER8RbA0NEbC6s87bywO','7000-0008',2),(14,'Irene','Solano','user9@dejandohuella.cr','$2b$10$BHWknxZsMbeqrV9P8gV.7eX4EiZEu4KgvPER8RbA0NEbC6s87bywO','7000-0009',2),(15,'Javier','Acuña','user10@dejandohuella.cr','$2b$10$BHWknxZsMbeqrV9P8gV.7eX4EiZEu4KgvPER8RbA0NEbC6s87bywO','7000-0010',2),(16,'Karen','Leiva','user11@dejandohuella.cr','$2b$10$BHWknxZsMbeqrV9P8gV.7eX4EiZEu4KgvPER8RbA0NEbC6s87bywO','7000-0011',2),(17,'Luis','Córdoba','user12@dejandohuella.cr','$2b$10$BHWknxZsMbeqrV9P8gV.7eX4EiZEu4KgvPER8RbA0NEbC6s87bywO','7000-0012',2),(18,'María','Piza','user13@dejandohuella.cr','$2b$10$BHWknxZsMbeqrV9P8gV.7eX4EiZEu4KgvPER8RbA0NEbC6s87bywO','7000-0013',2),(19,'Nicolás','Aguilar','user14@dejandohuella.cr','$2b$10$BHWknxZsMbeqrV9P8gV.7eX4EiZEu4KgvPER8RbA0NEbC6s87bywO','7000-0014',2),(20,'Olivia','Méndez','user15@dejandohuella.cr','$2b$10$BHWknxZsMbeqrV9P8gV.7eX4EiZEu4KgvPER8RbA0NEbC6s87bywO','7000-0015',3);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voluntarios`
--

DROP TABLE IF EXISTS `voluntarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `voluntarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` int NOT NULL,
  `fechaInicio` datetime NOT NULL,
  `fechaFin` datetime DEFAULT NULL,
  `horas` int NOT NULL DEFAULT '0',
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`id`),
  KEY `fk_voluntarios_usuario` (`usuario`),
  CONSTRAINT `fk_voluntarios_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voluntarios`
--

LOCK TABLES `voluntarios` WRITE;
/*!40000 ALTER TABLE `voluntarios` DISABLE KEYS */;
INSERT INTO `voluntarios` VALUES (1,3,'2025-08-20 20:33:03',NULL,0,'Activo');
/*!40000 ALTER TABLE `voluntarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-20 21:25:37
