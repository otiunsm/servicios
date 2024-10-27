/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100432
 Source Host           : localhost:3306
 Source Schema         : registro_oti

 Target Server Type    : MySQL
 Target Server Version : 100432
 File Encoding         : 65001

 Date: 23/10/2024 10:14:16
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for act_area
-- ----------------------------
DROP TABLE IF EXISTS `act_area`;
CREATE TABLE `act_area`  (
  `id_area` int NOT NULL AUTO_INCREMENT,
  `nombre_area` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `descripcion` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_area`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of act_area
-- ----------------------------
INSERT INTO `act_area` VALUES (4, 'Soporte tecnico', NULL);
INSERT INTO `act_area` VALUES (5, 'redes', NULL);
INSERT INTO `act_area` VALUES (6, 'soporte de sistemas', NULL);

-- ----------------------------
-- Table structure for act_categoria_actividad
-- ----------------------------
DROP TABLE IF EXISTS `act_categoria_actividad`;
CREATE TABLE `act_categoria_actividad`  (
  `id_categoria_actividad` int NOT NULL AUTO_INCREMENT,
  `nombre_c` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_categoria_actividad`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of act_categoria_actividad
-- ----------------------------
INSERT INTO `act_categoria_actividad` VALUES (1, 'soporte tecnico');
INSERT INTO `act_categoria_actividad` VALUES (2, 'mantenimiento');
INSERT INTO `act_categoria_actividad` VALUES (3, 'servicio de redes');

-- ----------------------------
-- Table structure for act_dependencia
-- ----------------------------
DROP TABLE IF EXISTS `act_dependencia`;
CREATE TABLE `act_dependencia`  (
  `id_dependencia` int NOT NULL AUTO_INCREMENT,
  `nombre_dep` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `descripcion` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_dependencia`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of act_dependencia
-- ----------------------------
INSERT INTO `act_dependencia` VALUES (1, 'Faculta de Ciencias agrarias', NULL);
INSERT INTO `act_dependencia` VALUES (2, 'Faculta de ingenieria', NULL);
INSERT INTO `act_dependencia` VALUES (3, 'dacultad de medicina', NULL);
INSERT INTO `act_dependencia` VALUES (4, '', NULL);

-- ----------------------------
-- Table structure for act_medio_solicitud
-- ----------------------------
DROP TABLE IF EXISTS `act_medio_solicitud`;
CREATE TABLE `act_medio_solicitud`  (
  `id_medio_solicitud` int NOT NULL AUTO_INCREMENT,
  `nombre_solicitud` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `descripcion` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_medio_solicitud`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of act_medio_solicitud
-- ----------------------------
INSERT INTO `act_medio_solicitud` VALUES (1, 'Llamada', NULL);
INSERT INTO `act_medio_solicitud` VALUES (2, 'presencial', NULL);
INSERT INTO `act_medio_solicitud` VALUES (3, 'Online', NULL);

-- ----------------------------
-- Table structure for act_registro
-- ----------------------------
DROP TABLE IF EXISTS `act_registro`;
CREATE TABLE `act_registro`  (
  `idregistro` int NOT NULL AUTO_INCREMENT,
  `numero` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fec_doc_sgd` date NULL DEFAULT NULL,
  `nro_carta` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `detalle_actividad` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fec_registro` date NULL DEFAULT NULL,
  `fec_atencion` date NULL DEFAULT NULL,
  `observacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `tipo_doc` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_dependencia` int NOT NULL,
  `id_solicitante` int NOT NULL,
  `id_medio_solicitud` int NOT NULL,
  `id_tipo_asistencia` int NOT NULL,
  `id_categoria_actividad` int NOT NULL,
  `id_usuario` int NULL DEFAULT NULL,
  `estado_r` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '1',
  `otras_atenciones` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idregistro`) USING BTREE,
  INDEX `fk_registro_categoria_actividad1`(`id_categoria_actividad` ASC) USING BTREE,
  INDEX `fk_registro_dependencia1`(`id_dependencia` ASC) USING BTREE,
  INDEX `fk_registro_medio_solicitud1`(`id_medio_solicitud` ASC) USING BTREE,
  INDEX `fk_registro_solicitante1`(`id_solicitante` ASC) USING BTREE,
  INDEX `fk_registro_tipo_asistencia1`(`id_tipo_asistencia` ASC) USING BTREE,
  INDEX `act_registro_ibfk_8`(`id_usuario` ASC) USING BTREE,
  CONSTRAINT `act_registro_ibfk_1` FOREIGN KEY (`id_categoria_actividad`) REFERENCES `act_categoria_actividad` (`id_categoria_actividad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `act_registro_ibfk_2` FOREIGN KEY (`id_dependencia`) REFERENCES `act_dependencia` (`id_dependencia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `act_registro_ibfk_4` FOREIGN KEY (`id_medio_solicitud`) REFERENCES `act_medio_solicitud` (`id_medio_solicitud`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `act_registro_ibfk_6` FOREIGN KEY (`id_solicitante`) REFERENCES `act_solicitante` (`id_solicitante`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `act_registro_ibfk_7` FOREIGN KEY (`id_tipo_asistencia`) REFERENCES `act_tipo_asistencia` (`id_tipo_asistencia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `act_registro_ibfk_8` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of act_registro
-- ----------------------------
INSERT INTO `act_registro` VALUES (1, '02', NULL, '0223', 'actualizacion de contraseña', '2024-09-18', '2024-09-17', 'aaa', 'sgd', 1, 2, 1, 1, 1, 7, '1', NULL);
INSERT INTO `act_registro` VALUES (7, '003', NULL, '000254', 'Asistencia en el laboratotio de Ti', '2024-10-03', '2024-10-03', 'AESSEDASAD', 'SGD', 2, 4, 2, 2, 2, 45, '1', NULL);

-- ----------------------------
-- Table structure for act_solicitante
-- ----------------------------
DROP TABLE IF EXISTS `act_solicitante`;
CREATE TABLE `act_solicitante`  (
  `id_solicitante` int NOT NULL AUTO_INCREMENT,
  `dni_so` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nombre_so` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email_so` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `telefono_so` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `direccion_so` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `cargo_so` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `estado_so` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '1',
  PRIMARY KEY (`id_solicitante`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of act_solicitante
-- ----------------------------
INSERT INTO `act_solicitante` VALUES (1, '20457114', 'Daniel Segura Lopez', 'danie@gmail.com', '956321454', 'Jr. los angeles', 'Asistente', '1');
INSERT INTO `act_solicitante` VALUES (2, '78965874', 'Maira Sandocal Areavalo', 'Maira@gmai.com', '936852147', 'Jr. las palmas', 'Docente', '1');
INSERT INTO `act_solicitante` VALUES (3, '76582314', 'Paul Garcia Gomez', 'Grcia@gmail.com', '936251478', 'Jr. Los Olivos', 'Jefe de recursos Humanos', '1');
INSERT INTO `act_solicitante` VALUES (4, '79326541', 'Andy Chujutalli Sanchez', 'andy@gmail.com', '963781004', 'Jr. Las palmas', 'Director ', '0');
INSERT INTO `act_solicitante` VALUES (5, '76381177', 'Juan Chuquipoma Fermín', 'j@mail.com', '917563898', 'Jr. orellana 836', 'practicantes', '0');
INSERT INTO `act_solicitante` VALUES (6, '76381177', 'cali ', 'j@mail.com', '44444', 'Jr. orellana 836', 'asistente', '0');
INSERT INTO `act_solicitante` VALUES (7, '76381177', 'Luis Carrasco', 'Luis@gmail.com', '914778888', 'Jr. Las cariñosas 836', 'admin', '0');

-- ----------------------------
-- Table structure for act_tipo_asistencia
-- ----------------------------
DROP TABLE IF EXISTS `act_tipo_asistencia`;
CREATE TABLE `act_tipo_asistencia`  (
  `id_tipo_asistencia` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_tipo_asistencia`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of act_tipo_asistencia
-- ----------------------------
INSERT INTO `act_tipo_asistencia` VALUES (1, 'ani desk');
INSERT INTO `act_tipo_asistencia` VALUES (2, 'presencial');
INSERT INTO `act_tipo_asistencia` VALUES (3, 'llamada');

-- ----------------------------
-- Table structure for automatizar
-- ----------------------------
DROP TABLE IF EXISTS `automatizar`;
CREATE TABLE `automatizar`  (
  `idautomatizar` int NOT NULL AUTO_INCREMENT,
  `descripcionautomatizar` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fechaautomatizar` date NOT NULL,
  `estadoautomatizar` tinyint NOT NULL DEFAULT 1,
  PRIMARY KEY (`idautomatizar`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of automatizar
-- ----------------------------
INSERT INTO `automatizar` VALUES (1, 'Activación de consultas RENIEC', '2024-10-23', 1);

-- ----------------------------
-- Table structure for modulo
-- ----------------------------
DROP TABLE IF EXISTS `modulo`;
CREATE TABLE `modulo`  (
  `id_modulo` int NOT NULL AUTO_INCREMENT,
  `nombremodulo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `urlmodulo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `idmodulopadre` int NULL DEFAULT NULL,
  `iconomodulo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `estadomodulo` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id_modulo`) USING BTREE,
  INDEX `idmodulopadre`(`idmodulopadre` ASC) USING BTREE,
  CONSTRAINT `modulo_ibfk_1` FOREIGN KEY (`idmodulopadre`) REFERENCES `modulo` (`id_modulo`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of modulo
-- ----------------------------
INSERT INTO `modulo` VALUES (1, 'Seguridad', NULL, NULL, NULL, 1);
INSERT INTO `modulo` VALUES (2, 'Consultar Servicios', NULL, NULL, NULL, 1);
INSERT INTO `modulo` VALUES (3, 'Perfiles', '/perfiles', 1, NULL, 1);
INSERT INTO `modulo` VALUES (4, 'Usuarios', '/user', 1, NULL, 1);
INSERT INTO `modulo` VALUES (5, 'RENIEC', '/consultas/dni', 2, NULL, 1);
INSERT INTO `modulo` VALUES (8, 'Boletas de Pagos en Tesorería', '/consultas/tesoreria', 2, NULL, 1);
INSERT INTO `modulo` VALUES (9, 'Boletas de Pago', '/consultas/boletapago', 2, NULL, 1);
INSERT INTO `modulo` VALUES (10, 'Antecedentes Policiales', '/consultas/antecedentespoliciales', 2, NULL, 1);
INSERT INTO `modulo` VALUES (11, 'SUNAT', '/consultas/ruc', 2, NULL, 1);
INSERT INTO `modulo` VALUES (12, 'Boletas de CAFAE', '/consultas/boletacafae', 2, NULL, 1);
INSERT INTO `modulo` VALUES (13, 'Inventario', NULL, NULL, NULL, 0);
INSERT INTO `modulo` VALUES (14, 'Articulos', '/inventario', NULL, NULL, 0);
INSERT INTO `modulo` VALUES (15, 'Ajustes', '/ajustes', 1, NULL, 1);
INSERT INTO `modulo` VALUES (16, 'Módulo SIAF', NULL, NULL, NULL, 1);
INSERT INTO `modulo` VALUES (17, 'Registro SIAF', '/siaf', 16, NULL, 1);
INSERT INTO `modulo` VALUES (18, 'Modulos', '/modulos', 1, NULL, 1);
INSERT INTO `modulo` VALUES (19, 'Servicios PIDE', NULL, NULL, NULL, 1);
INSERT INTO `modulo` VALUES (20, 'Institutos tecnológicos y pedagógicos', '/serviciospide/tecnologicosypedagogicos', 19, NULL, 1);
INSERT INTO `modulo` VALUES (21, 'Gestión de Actividades', '/', NULL, NULL, 1);
INSERT INTO `modulo` VALUES (22, 'Actividades', '/Act_registro', 21, NULL, 1);
INSERT INTO `modulo` VALUES (24, 'Solicitante', '/Act_solicitante', 21, NULL, 1);

-- ----------------------------
-- Table structure for perfil
-- ----------------------------
DROP TABLE IF EXISTS `perfil`;
CREATE TABLE `perfil`  (
  `id_perfil` int NOT NULL AUTO_INCREMENT,
  `nombreperfil` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `estadoperfil` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id_perfil`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of perfil
-- ----------------------------
INSERT INTO `perfil` VALUES (1, 'ADMINISTRADOR', 1);
INSERT INTO `perfil` VALUES (12, 'Prueba', 0);
INSERT INTO `perfil` VALUES (14, 'CONSULTAS', 1);
INSERT INTO `perfil` VALUES (15, 'CONSULTAS DNI', 0);
INSERT INTO `perfil` VALUES (16, 'CONSULTA RENIEC', 1);
INSERT INTO `perfil` VALUES (17, 'CONSULTA SUNAT Y RENIEC', 1);
INSERT INTO `perfil` VALUES (18, 'DOCENTE O ADMINISTRATIVO', 1);
INSERT INTO `perfil` VALUES (19, 'CONSULTA BOLETA DE PAGO', 1);
INSERT INTO `perfil` VALUES (20, 'SUPERADMIN', 1);
INSERT INTO `perfil` VALUES (21, 'CONSULTA SIAF', 1);
INSERT INTO `perfil` VALUES (22, 'CONSULTA DE BOLETAS Y SIAF', 1);
INSERT INTO `perfil` VALUES (23, 'ADMINISTRATIVO CONSULTA RENIEC', 1);
INSERT INTO `perfil` VALUES (24, 'Practicante', 1);

-- ----------------------------
-- Table structure for permiso
-- ----------------------------
DROP TABLE IF EXISTS `permiso`;
CREATE TABLE `permiso`  (
  `id_permiso` int NOT NULL AUTO_INCREMENT,
  `idperfilpermiso` int NULL DEFAULT NULL,
  `idmodulo` int NULL DEFAULT NULL,
  `estadopermiso` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id_permiso`) USING BTREE,
  INDEX `fk_permiso_perfil`(`idperfilpermiso` ASC) USING BTREE,
  INDEX `permiso_idmodulo`(`idmodulo` ASC) USING BTREE,
  CONSTRAINT `permiso_ibfk_1` FOREIGN KEY (`idperfilpermiso`) REFERENCES `perfil` (`id_perfil`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `permiso_ibfk_2` FOREIGN KEY (`idmodulo`) REFERENCES `modulo` (`id_modulo`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 530 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of permiso
-- ----------------------------
INSERT INTO `permiso` VALUES (36, 16, 2, 1);
INSERT INTO `permiso` VALUES (37, 16, 5, 1);
INSERT INTO `permiso` VALUES (153, 18, 2, 1);
INSERT INTO `permiso` VALUES (154, 18, 12, 1);
INSERT INTO `permiso` VALUES (155, 18, 9, 1);
INSERT INTO `permiso` VALUES (156, 14, 2, 1);
INSERT INTO `permiso` VALUES (157, 14, 12, 1);
INSERT INTO `permiso` VALUES (158, 14, 11, 1);
INSERT INTO `permiso` VALUES (159, 14, 9, 1);
INSERT INTO `permiso` VALUES (160, 14, 8, 1);
INSERT INTO `permiso` VALUES (161, 14, 5, 1);
INSERT INTO `permiso` VALUES (162, 19, 2, 1);
INSERT INTO `permiso` VALUES (163, 19, 12, 1);
INSERT INTO `permiso` VALUES (164, 19, 9, 1);
INSERT INTO `permiso` VALUES (168, 17, 2, 1);
INSERT INTO `permiso` VALUES (169, 17, 11, 1);
INSERT INTO `permiso` VALUES (170, 17, 5, 1);
INSERT INTO `permiso` VALUES (242, 22, 16, 1);
INSERT INTO `permiso` VALUES (243, 22, 17, 1);
INSERT INTO `permiso` VALUES (244, 22, 2, 1);
INSERT INTO `permiso` VALUES (245, 22, 12, 1);
INSERT INTO `permiso` VALUES (246, 22, 9, 1);
INSERT INTO `permiso` VALUES (247, 21, 16, 1);
INSERT INTO `permiso` VALUES (248, 21, 17, 1);
INSERT INTO `permiso` VALUES (249, 21, 2, 1);
INSERT INTO `permiso` VALUES (250, 21, 12, 1);
INSERT INTO `permiso` VALUES (251, 21, 11, 1);
INSERT INTO `permiso` VALUES (252, 21, 9, 1);
INSERT INTO `permiso` VALUES (253, 21, 8, 1);
INSERT INTO `permiso` VALUES (254, 21, 5, 1);
INSERT INTO `permiso` VALUES (282, 23, 2, 1);
INSERT INTO `permiso` VALUES (283, 23, 12, 1);
INSERT INTO `permiso` VALUES (284, 23, 9, 1);
INSERT INTO `permiso` VALUES (285, 23, 5, 1);
INSERT INTO `permiso` VALUES (330, 20, 2, 1);
INSERT INTO `permiso` VALUES (331, 20, 12, 1);
INSERT INTO `permiso` VALUES (332, 20, 11, 1);
INSERT INTO `permiso` VALUES (333, 20, 10, 1);
INSERT INTO `permiso` VALUES (334, 20, 9, 1);
INSERT INTO `permiso` VALUES (335, 20, 8, 1);
INSERT INTO `permiso` VALUES (336, 20, 5, 1);
INSERT INTO `permiso` VALUES (337, 20, 1, 1);
INSERT INTO `permiso` VALUES (338, 20, 4, 1);
INSERT INTO `permiso` VALUES (339, 20, 3, 1);
INSERT INTO `permiso` VALUES (378, 24, 2, 1);
INSERT INTO `permiso` VALUES (379, 24, 11, 1);
INSERT INTO `permiso` VALUES (515, 1, 21, 1);
INSERT INTO `permiso` VALUES (516, 1, 24, 1);
INSERT INTO `permiso` VALUES (517, 1, 22, 1);
INSERT INTO `permiso` VALUES (518, 1, 2, 1);
INSERT INTO `permiso` VALUES (519, 1, 12, 1);
INSERT INTO `permiso` VALUES (520, 1, 11, 1);
INSERT INTO `permiso` VALUES (521, 1, 10, 1);
INSERT INTO `permiso` VALUES (522, 1, 9, 1);
INSERT INTO `permiso` VALUES (523, 1, 8, 1);
INSERT INTO `permiso` VALUES (524, 1, 5, 1);
INSERT INTO `permiso` VALUES (525, 1, 1, 1);
INSERT INTO `permiso` VALUES (526, 1, 18, 1);
INSERT INTO `permiso` VALUES (527, 1, 15, 1);
INSERT INTO `permiso` VALUES (528, 1, 4, 1);
INSERT INTO `permiso` VALUES (529, 1, 3, 1);

-- ----------------------------
-- Table structure for responsables
-- ----------------------------
DROP TABLE IF EXISTS `responsables`;
CREATE TABLE `responsables`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of responsables
-- ----------------------------
INSERT INTO `responsables` VALUES (1, 'Enil Torres');

-- ----------------------------
-- Table structure for siaf_correlativo
-- ----------------------------
DROP TABLE IF EXISTS `siaf_correlativo`;
CREATE TABLE `siaf_correlativo`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `correlativo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of siaf_correlativo
-- ----------------------------
INSERT INTO `siaf_correlativo` VALUES (1, '8');

-- ----------------------------
-- Table structure for tb_siaf
-- ----------------------------
DROP TABLE IF EXISTS `tb_siaf`;
CREATE TABLE `tb_siaf`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `comprobante_pago` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `expediente` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tipo_giro` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nombres` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `partida_especifica` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `monto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fecha_pase` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `orden_compra` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `orden_servicio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `planilla_viatico` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `recibo_honorarios` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `exp_sgd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `asunto_sgd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `observacion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `estado_tramite` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_siaf
-- ----------------------------
INSERT INTO `tb_siaf` VALUES (1, '1', '74', '1', 'RENGIFO SMITH MIA ALESSANDRA', '', '149.00', '2023-12-11', '', '', '', '', '', '', '', NULL, NULL, NULL);
INSERT INTO `tb_siaf` VALUES (2, '2', '74', '', 'RENGIFO DEL AGUILA', 'partida', '149.00', '2023-12-11', '', '', '', '', '', '', '', NULL, NULL, NULL);
INSERT INTO `tb_siaf` VALUES (3, '3', '3', '2', 'LUIS MANUEL VARGAS VASQUEZ', 'd', '12', '2023-12-11', '', '', '', '', '', '', '', NULL, NULL, '2024-02-02 08:04:27');
INSERT INTO `tb_siaf` VALUES (4, '4', '2034', '', 'CRUZ VILCHEZ ALFREDO DEYVI', '', '2004.00', '2023-12-21', '', '', '', '', '', '', '', NULL, NULL, NULL);
INSERT INTO `tb_siaf` VALUES (5, '5', '2031', '', 'RENGIFO DEL AGUILA ANDRE ALONSO', '', '1782.00', '2023-12-21', '', '', '', '', '', '', '', NULL, NULL, NULL);
INSERT INTO `tb_siaf` VALUES (6, '6', '2031', '1', 'RENGIFO DEL AGUILA ANDRE ALONSO', '', '1782.00', '2024-02-02', '', '', '', '', '', '', NULL, NULL, '2024-02-02 08:48:00', '2024-02-02 08:48:00');
INSERT INTO `tb_siaf` VALUES (7, '7', '5559', '1', 'TAFUR PUERTA JHON', '', '1807.00', '2024-02-05', '', '', '', '', '', '', NULL, NULL, '2024-02-05 14:30:55', '2024-02-06 10:44:23');

-- ----------------------------
-- Table structure for tipo_giro
-- ----------------------------
DROP TABLE IF EXISTS `tipo_giro`;
CREATE TABLE `tipo_giro`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo_giro` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tipo_giro
-- ----------------------------
INSERT INTO `tipo_giro` VALUES (1, 'OPE');
INSERT INTO `tipo_giro` VALUES (2, 'CCI');
INSERT INTO `tipo_giro` VALUES (3, 'ABONO');
INSERT INTO `tipo_giro` VALUES (4, 'C/O');

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario`  (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `apellido` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `usuario` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `clave` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '1',
  `dni` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `telefono` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `idperfil_usuario` int NULL DEFAULT NULL,
  `correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `estado_clave` int NOT NULL DEFAULT 0,
  `fecha_clave` date NULL DEFAULT NULL,
  `ultimo_login` datetime NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `idarea` int NULL DEFAULT NULL,
  PRIMARY KEY (`id_usuario`) USING BTREE,
  INDEX `id_perfil`(`idperfil_usuario` ASC) USING BTREE,
  INDEX `usuario_ibfk_2`(`idarea` ASC) USING BTREE,
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idperfil_usuario`) REFERENCES `perfil` (`id_perfil`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`idarea`) REFERENCES `act_area` (`id_area`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1086 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES (7, 'ENIL', 'TORRES MERA', '43698668', '$2a$07$asxx54ahjppf45sd87a5auGJqTWXjUAWQ6xEldZH6DhEKsQvHPyyK', '1', '43698668', '', 1, 'etm_etm2@unsm.edu.pe', 'Jr. Tupac Amaru Cdra. 10 Mz. I Lte. 7', 1, '2022-04-19', '2024-09-12 10:23:05', NULL, '2024-03-20 16:03:22', NULL);
INSERT INTO `usuario` VALUES (10, 'Jorge Damian', 'Valverde Iparraguirre', '18131170', '$2a$07$asxx54ahjppf45sd87a5auqtx1kH7HIDEJlTl1EtatNYZh6uZ9.mG', '1', '18131170', '111222444', 14, 'jorge@gmail.com', '', 1, '2023-06-01', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (11, 'André Alonso', 'Rengifo del Aguila', '75244255', '$2a$07$asxx54ahjppf45sd87a5au9tt8kCgXuNSZJTnXaNlHbH8hUXyTZ4u', '1', '75244255', '042948809591', 1, 'a@gmail.com', '', 1, '2022-04-07', '2024-10-23 00:29:28', NULL, '2024-07-11 08:42:58', NULL);
INSERT INTO `usuario` VALUES (13, 'John Antony', 'Ruiz Cueva', '01143894', '$2a$07$asxx54ahjppf45sd87a5au3WrrYdVXC3DPvcsh4dYTveJjNncG2ty', '1', '01143894', '942863614', 1, 'john@gmail.com', '', 1, '2022-03-03', '2024-08-11 07:00:01', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (14, 'AQUILINO MESIAS', 'BAUTISTA GARCIA', '01158732', '$2a$07$asxx54ahjppf45sd87a5au1nZK6hoMXtAnamOWhX7ukQ98TN.6fZm', '1', '01158732', '', 14, '', '', 1, '2023-02-14', '2024-03-15 08:29:47', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (15, 'JULIAN', '  PINEDO LOPEZ', '44381078', '$2a$07$asxx54ahjppf45sd87a5autZO36wkkpK/5LXFMeGQQEH7drQtjuQO', '1', '44381078', '942056060', 14, 'jupinedo@unsm.edu.pe', '', 1, '2022-09-16', '2024-08-14 15:41:29', NULL, '2024-07-02 09:44:42', NULL);
INSERT INTO `usuario` VALUES (16, 'gloria', 'pizango', '47160589', '$2a$07$asxx54ahjppf45sd87a5aupeE37kJ8wUuInqebo/N//MWAUEEqKxO', '1', '47160589', '945747670', 1, 'gpizango@unsm.edu.pe', '', 1, '2022-04-26', '2023-08-15 11:40:15', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (20, 'FIORELLA MERCEDES ', 'VINCES MORI', '44846492', '$2a$07$asxx54ahjppf45sd87a5auZSmCHeBN6JAXFVXt0b1eCRj82n/Urxq', '1', '44846492', '55555555', 14, 'fvinces@unsm.edu.pe', '', 1, '2023-02-21', '2024-09-11 09:49:21', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (25, 'CARLOS ENRIQUE', 'PINCHI AREVALO', '01165171', '$2a$07$asxx54ahjppf45sd87a5aufx4FbaMtSXdWiMOusvMooJRDLWp0Hme', '1', '01165171', '942680000', 14, '', '', 1, '2022-05-02', '2024-05-29 10:43:17', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (27, 'Grimaneza ', 'Luna Maldonado', '01101012', '$2a$07$asxx54ahjppf45sd87a5auWrFBerbcMkA0azNXDm/njFZC5b4.fu6', '1', '01101012', '555555555', 18, '', '', 1, '2022-07-26', '2024-09-03 11:53:36', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (28, 'JUAN ANTONIO', 'REYNA SAAVEDRA', '43023087', '$2a$07$asxx54ahjppf45sd87a5auxcOm1EbDcI/X.pZt3WfBet4PzvQvipu', '1', '43023087', '555555555', 18, '', '', 1, '2022-03-08', '2023-07-13 11:16:18', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (36, 'Karina', 'Rios Ramirez', '41679908', '$2a$07$asxx54ahjppf45sd87a5augBuYehnMtezzqZhlMv5An0J4G2yTl9a', '1', '41679908', '', 18, '', '', 1, '2022-05-07', '2024-07-02 07:56:28', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (39, 'Bragnin', 'Shupingahua Arzapalo', '45920165', '$2a$07$asxx54ahjppf45sd87a5auLe07swwspq.7ZNswLNvy5qlM2OxGcSO', '1', '45920165', '', 14, '', '', 1, '2022-01-26', '2024-09-04 10:16:58', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (40, 'NEIRITH ', 'PEREZ CACHIQUE', '42905607', '$2a$07$asxx54ahjppf45sd87a5au4oxELiFsuBBNQeTVWhgzi1aL4fexnDa', '1', '42905607', '947449141', 18, 'nperez@unsm.edu.pe', 'nperez@unsm.edu.pe', 1, '2022-03-07', '2024-09-03 15:56:41', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (42, 'Carlos', 'Prueba', '87654321', '$2a$07$asxx54ahjppf45sd87a5auygZHGSqwTPqPppmYyhXTx5W/1wQzada', '1', '87654321', '', 24, 'a@gmail.com', 'd', 1, '2022-07-26', '2024-08-27 12:50:42', NULL, '2024-08-27 12:50:29', NULL);
INSERT INTO `usuario` VALUES (43, 'Patricia', 'Rodriguez Upiachihua', '01127599', '$2a$07$asxx54ahjppf45sd87a5auTfMAp3PThuGZ2xXJhDVU3pC6puYOyEy', '1', '01127599', '942651237', 14, '', '...', 1, '2022-03-07', '2024-09-03 12:13:10', NULL, '2024-09-03 12:12:57', NULL);
INSERT INTO `usuario` VALUES (44, 'ROSA ESTEHER', 'HERRERA RENGIFO', '01060874', '$2a$07$asxx54ahjppf45sd87a5auGnYZ5.mpRZ6LdXsBANCc.quL/Yj1n5y', '1', '01060874', '945319783', 14, '', '', 1, '2022-03-07', '2024-09-11 12:50:09', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (45, 'Henry', 'Sanchez del Aguila', '01146880', '$2a$07$asxx54ahjppf45sd87a5aunzlT7xKGyEWE3CfwStmqR2IoNGhp42.', '1', '01146880', '', 14, '', '', 1, '2022-04-07', '2024-09-04 11:00:31', NULL, '2024-09-04 11:00:17', NULL);
INSERT INTO `usuario` VALUES (46, 'MARCO ARMANDO', 'GALVEZ DIAS', '01080605', '$2a$07$asxx54ahjppf45sd87a5au3pzYeKs1epznvhzg5mY4Fod7McGXz06', '1', '01080605', '', 18, 'magalvez@unsm.edu.pe', '', 1, '2022-04-20', '2024-09-05 02:50:39', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (47, 'MARCOS AQUILES', 'AYALA DIAZ', '02848481', '$2a$07$asxx54ahjppf45sd87a5aubYI5nqonU5i0XeAUs57fTa/pqUeK1U2', '1', '02848481', '', 18, 'maayala@unsm.edu.pe', '', 1, '2023-08-18', '2024-09-01 11:15:02', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (48, 'Danipsa', 'Rodriguez Pisco', '47237804', '$2a$07$asxx54ahjppf45sd87a5au/E7yy6j1uGpjJ288LVkGRgmLfFN0/7q', '1', '47237804', '', 18, '', '', 1, '2022-04-24', '2024-08-07 10:30:56', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (49, 'PACO', 'NAVARRO PEZO', '01112534', '$2a$07$asxx54ahjppf45sd87a5aukLvXMYHnGM2LMBHUlDh2.iLuQsACegS', '1', '01112534', '', 19, '', '', 1, '2022-04-25', '2024-09-03 13:36:06', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (50, 'Jose Humberto', 'Melendez Diaz', '80210559', '$2a$07$asxx54ahjppf45sd87a5auEGzk.mr710EquN3yS8Km8X0QLlVHTXC', '1', '80210559', '935056159', 18, 'melendez_333@hotmail.com', 'Jr Santa Rosa S / N', 1, '2022-04-25', '2024-09-08 18:19:07', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (51, 'CARLOS HERIBERTO ', 'GARCIA TELLO', '00904213', '$2a$07$asxx54ahjppf45sd87a5au8jpOVziwm3kff44TXHUoTVv7mgudLGu', '1', '00904213', '', 18, '', '', 1, '2022-04-26', '2024-08-01 08:58:23', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (52, 'CONSUELO', 'LUNA LANATA', '01070620', '$2a$07$asxx54ahjppf45sd87a5auq3D2jcIdqIITM1mXMtAj26tjNIBfqRW', '1', '01070620', '', 18, '', '', 1, '2022-04-26', '2024-07-02 09:57:09', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (53, 'Luz Karen ', 'Quintanilla Morales', '25004507', '$2a$07$asxx54ahjppf45sd87a5auDjqXW.GcPYwk.HNv178xUlzyWkvOau2', '1', '25004507', '', 18, '', '', 1, '2022-04-27', '2024-09-10 23:05:26', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (54, 'Very', 'Rengifo Hidalgo', '09886163', '$2a$07$asxx54ahjppf45sd87a5audKaMpATmBFd8MTpy48FXPIWbT1Kjj66', '1', '09886163', '', 18, '', '', 1, '2022-04-27', '2024-08-28 14:14:34', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (55, 'Monica Evelyn', ' Juarez de la Cruz', '40621843', '$2a$07$asxx54ahjppf45sd87a5auUj5Gc443QpSOUtqz595dlpyzU2UL5Fq', '1', '40621843', '971356697', 18, 'mejuarez@unsm.edu.pe', 'Jr. Atumpampa 470- Morales', 1, '2022-05-09', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (56, 'Hugo Jaime', 'Mera Naval', '01051153', '$2a$07$asxx54ahjppf45sd87a5au3c54w5i/hJPK/1fcpfgxdd1R6DryTu.', '1', '01051153', '962501474', 18, 'hjmeran@unsm.edu.pe', 'Jr. Santo Toribio - 1200', 1, '2022-05-01', '2024-09-07 20:22:04', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (57, 'Carmen del Pilar', 'Sanchez Villacorta', '01110545', '$2a$07$asxx54ahjppf45sd87a5aufNL75qRqhGtPhly1aRJzKrnDW2vJ1jG', '1', '01110545', '', 18, '', '', 1, '2022-05-02', '2024-02-06 11:01:39', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (58, 'Pilar', 'Pinedo', '41744010', '$2a$07$asxx54ahjppf45sd87a5auBODcFXRJsozdAe0aKi3VwfzL33aCFba', '1', '41744010', '', 18, '', '', 1, '2022-05-02', '2024-08-07 10:13:51', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (59, 'Jeniffer Aracely', 'Montoya Carrera', '45327977', '$2a$07$asxx54ahjppf45sd87a5auNtB.BO5LGPZuPqub5a.TC/6nJz.h3A.', '1', '45327977', '', 18, '', '', 1, '2022-05-08', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (60, 'JUAN ORLANDO', 'RIASCOS ARMAS', '42043579', '$2a$07$asxx54ahjppf45sd87a5auyaF6VY2W9Scm5.2yuHoKm2.D.b7oDBO', '1', '42043579', '', 18, '', '', 1, '2022-05-02', '2024-09-03 20:49:35', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (61, 'John ', 'Ramirez Olano', '41671187', '$2a$07$asxx54ahjppf45sd87a5aur26II/OukgqfmmcDHPRoDriHuk5UipW', '1', '41671187', '', 18, 'jramirezolano@unsm.edu.pe', 'Jr. Huáscar 523', 1, '2022-05-03', '2024-09-09 16:06:28', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (62, 'CAROL BEATRIZ', 'BAO RATZEMBERG', '00967350', '$2a$07$asxx54ahjppf45sd87a5au8tXk.EstHDm/.fdIXIK0xWwm47rOANe', '1', '00967350', '', 18, '', '', 1, '2022-05-02', '2024-08-19 16:10:02', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (63, 'Maria ', 'Garcia Paredes', '40846963', '$2a$07$asxx54ahjppf45sd87a5auyD.R6EqG.DprFOt3nQGcxGVMmLNRKoa', '1', '40846963', '', 19, '', '', 1, '2022-05-03', '2024-09-05 07:48:35', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (64, 'Enrique ', 'Navarro Ramirez', '01121250', '$2a$07$asxx54ahjppf45sd87a5audI/ot6v40g.4TedkUgNZTPRlt3SGpX2', '1', '01121250', '', 19, '', '', 1, '2022-05-03', '2024-08-05 21:28:12', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (65, 'Angel', 'Delgado Rios', '01159336', '$2a$07$asxx54ahjppf45sd87a5auQAZxs3iDcEbJiS.N.ZamOleAKaH/hXm', '1', '01159336', '', 18, '', '', 0, '2022-02-03', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (66, 'Julio Armando ', ' Rios Ramirez', '01060238', '$2a$07$asxx54ahjppf45sd87a5aujHqvpnKQFGTC/bZcyrVDi3/OApJdUJK', '1', '01060238', '985352107', 18, 'jarios@unsm.edu.pe', 'JR. José Olaya 988', 1, '2022-05-03', '2024-07-16 19:36:14', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (67, 'Jorge', 'Melendez Pezo', '01061298', '$2a$07$asxx54ahjppf45sd87a5aumSrY6qoOdtC6elj/ALKDlcPS8KzkFaS', '1', '01061298', '', 18, '', '', 1, '2022-05-03', '2024-09-03 10:24:52', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (68, 'Manuel', 'Flores Flores', '01133354', '$2a$07$asxx54ahjppf45sd87a5auG8peAiDPrcTE1EeCQfvdLr3PsLDf2AC', '1', '01133354', '', 14, '', '', 1, '2022-05-03', '2024-09-03 12:40:05', NULL, '2023-12-04 09:47:40', NULL);
INSERT INTO `usuario` VALUES (69, 'Roydichan', 'Olano Arevalo', '01174101', '$2a$07$asxx54ahjppf45sd87a5aui4f02iYxT7buozA.JLfUqYdDPD4wb.2', '1', '01174101', '', 18, '', '', 1, '2022-05-04', '2024-08-30 11:48:10', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (70, 'Wendy', 'Palacios', '40412786', '$2a$07$asxx54ahjppf45sd87a5auWpuPs42kANIRpw/fSjhTPupl/U9sOri', '1', '40412786', '', 18, '', '', 1, '2024-01-22', '2024-06-20 13:07:30', NULL, '2023-10-22 10:49:39', NULL);
INSERT INTO `usuario` VALUES (71, 'EULER', 'NAVARRO PINEDO', '01162427', '$2a$07$asxx54ahjppf45sd87a5auH3Xu1eTrvnsyXMxXjgOg9/m5/t133tG', '1', '01162427', '', 18, '', '', 1, '2022-09-17', '2024-09-09 22:17:45', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (72, 'WANHIN ORLANDO', 'AGUILAR HERRERA', '01077922', '$2a$07$asxx54ahjppf45sd87a5autByPA7Grw5YRLNewD2fv/Qx.ZQ0UknK', '1', '01077922', '', 18, '', '', 1, '2022-05-04', '2024-08-20 10:49:45', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (73, 'JUAN', 'CAVERO-EGUSQUIZA PEZO', '01159872', '$2a$07$asxx54ahjppf45sd87a5au7vA1Pi06fodQKGVq5E03CBTEAxeBT1W', '1', '01159872', '', 18, '', '', 1, '2023-12-20', '2024-07-12 09:44:30', NULL, '2023-09-20 20:22:00', NULL);
INSERT INTO `usuario` VALUES (74, 'Victor', 'del Aguila del Aguila', '01088039', '$2a$07$asxx54ahjppf45sd87a5auT8BPkCC3ipwFFG4h8/fjVI5bKku1yau', '1', '01088039', '964686120', 18, 'vdelaguila_64@hotmail.com', 'Psj:verdum c_1', 1, '2022-05-04', '2023-11-25 10:35:21', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (75, 'Maria Elizabeth', 'Rodriguez Villacorta', '01080682', '$2a$07$asxx54ahjppf45sd87a5aui2EzSqw3Hp0C7dT12sxkosUXFCJ.Fk2', '1', '01080682', '', 18, '', '', 1, '2022-05-04', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (76, 'Siduith', 'Vergara', '01090730', '$2a$07$asxx54ahjppf45sd87a5auVwCntbUXAXhczFGgcm1mYS5e5cvm2PS', '1', '01090730', '', 18, 'siduith@unsm.edu.pe', '', 1, '2022-05-04', '2024-09-02 13:57:08', NULL, '2023-07-27 17:33:45', NULL);
INSERT INTO `usuario` VALUES (77, 'Karina', 'Rengifo Mesia', '10032072', '$2a$07$asxx54ahjppf45sd87a5audiz4W8nCy5HzYgxJ1QiwR9h34289WPW', '1', '10032072', '', 18, '', '', 1, '2022-05-04', '2024-04-12 11:30:30', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (78, 'LIONEL', 'BARDALES DEL AGUILA', '01080741', '$2a$07$asxx54ahjppf45sd87a5auVfifiV485ZlSbSaPclCP4evytHieBVO', '1', '01080741', '', 18, '', '', 1, '2022-05-04', '2024-07-03 09:22:15', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (79, 'RAMON', 'FLORES PEREIRA', '01068828', '$2a$07$asxx54ahjppf45sd87a5au0IRk.vvHWnJpw5x9mr3KaYmY6cjOjHS', '1', '01068828', '', 18, '', '', 1, '2022-05-04', '2024-06-12 12:29:14', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (80, 'remigio ', 'pinchi garcia', '01157697', '$2a$07$asxx54ahjppf45sd87a5au69sZHMxaW7cB1hDLhvgsHNPPDbF/eSO', '1', '01157697', '', 18, '', '', 1, '2022-05-05', '2024-07-21 08:46:40', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (81, 'Carlos', 'Castillo del Aguila', '01132882', '$2a$07$asxx54ahjppf45sd87a5aup3zVr5zatPcdDwNpLiEl5rPIK8sQY5u', '1', '01132882', '', 18, '', '', 1, '2022-10-01', '2024-09-03 16:42:40', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (82, 'Janeth', 'Ramírez Orbe', '01122026', '$2a$07$asxx54ahjppf45sd87a5auNo7XLemWnFnb/foOuIJN7zNCDsf94uq', '1', '01122026', '', 18, '', '', 1, '2022-05-05', '2024-06-12 22:41:35', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (83, ' Alex ', 'Ramirez Navarro', '01115031', '$2a$07$asxx54ahjppf45sd87a5auAo9kXxN90ky2fo6D..cfJ/pc89Gz7j2', '1', '01115031', '', 18, '', '', 1, '2022-10-20', '2024-03-13 14:05:41', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (84, 'LUZ MARIA', 'ACEVEDO LEMUS', '09485514', '$2a$07$asxx54ahjppf45sd87a5auFNHh6cdmTy.yds3YWu.oRf1jp7bQZtq', '1', '09485514', '975202941', 18, 'lmacevedo@unsm.edu.pe', '', 1, '2022-06-18', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (85, 'KATTY', 'ALAMO LARRAÑAGA', '01125055', '$2a$07$asxx54ahjppf45sd87a5ausNE/ikZrRRttWnnd4p0OBr8N1ZfsH.W', '1', '01125055', '952646114', 18, 'kalamo@unsm.edu.pe', '', 1, '2023-06-24', '2024-03-22 10:17:26', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (86, 'JOSE EVERGISTO', 'ALARCON ZAMORA', '16442591', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '16442591', '938516402', 18, 'jealarco@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (87, 'RAUL PABLO', 'ALEGRE GARAYAR', '01126926', '$2a$07$asxx54ahjppf45sd87a5auLymJcFyFGC7w9IrM3bT.GhiwiXXOAuK', '1', '01126926', '969618056', 18, 'pagarayar@unsm.edu.pe', '', 1, '2023-04-20', '2024-03-16 16:42:33', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (88, 'CARMEN CECILIA', 'ALHUAY SUAREZ', '01157204', '$2a$07$asxx54ahjppf45sd87a5aucfzH5FzUiuiv.oCzpe2ynAy0NGIFAiO', '1', '01157204', '942496631', 18, 'ccalhuay@unsm.edu.pe', '', 1, '2023-06-21', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (89, 'GILBERTO', 'ALIAGA ATALAYA', '27041154', '$2a$07$asxx54ahjppf45sd87a5aulDcHnNuAbHMt8e2TAzh59tdytEhIcv2', '1', '27041154', '942628800', 18, 'galiaga@unsm.edu.pe', '', 1, '2023-12-28', '2024-08-09 07:25:49', NULL, '2023-09-28 14:04:34', NULL);
INSERT INTO `usuario` VALUES (90, 'ALBERTO', 'ALVA AREVALO', '40118770', '$2a$07$asxx54ahjppf45sd87a5auLDs5UC224jeT87JanPEhvrPZXPy1Wbu', '1', '40118770', '942474035', 18, 'aalva@unsm.edu.pe', '', 1, '2022-08-25', '2024-08-04 13:34:46', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (91, 'CELSO MISAEL', 'ALVA AREVALO', '05383899', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '05383899', '0', 18, 'cmalvaa@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (92, 'SOFIA SOLEDAD', 'ALVA VASQUEZ', '07448999', '$2a$07$asxx54ahjppf45sd87a5aujtW90CMtg7uREPP6y21yJefaluaNCkK', '1', '07448999', '947883330', 18, 'ssalva@unsm.edu.pe', 'jr. Francisco Izquierdo Rios 643 Morales', 1, '2023-02-15', '2024-09-04 09:35:53', NULL, '2024-01-16 12:45:06', NULL);
INSERT INTO `usuario` VALUES (93, 'JORGE ARMANDO', 'ALVARADO GARAZATUA', '00953055', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '00953055', '964947968', 18, 'jaalvarado@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (94, 'JAIME WALTER', 'ALVARADO RAMIREZ', '00901846', '$2a$07$asxx54ahjppf45sd87a5au8f9GbRB9PN2YK94O.Cvls3uuuOK4sIG', '1', '00901846', '942690054', 18, 'jwalvarado@unsm.edu.pe', '', 1, '2023-02-22', '2024-09-10 10:33:43', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (95, 'JOILER', 'ALVARADO VILLASIS', '01151879', '$2a$07$asxx54ahjppf45sd87a5auo9J3ARqlU/8wPerkwSLQdq2EGVSjbTa', '1', '01151879', '942946745', 18, 'rrios@unsm.edu.pe', '', 1, '2022-05-23', '2023-10-04 12:02:17', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (96, 'LEONIDAS JULIA', 'AMADO DE FLORES', '01077042', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01077042', '958403034', 18, 'ljamado@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (97, 'EVANGELINA', 'AMPUERO FERNANDEZ', '01110147', '$2a$07$asxx54ahjppf45sd87a5aug3iyi74u5h3netzMwexshrknIRtc1E6', '1', '01110147', '950046319', 18, 'eampuero@unsm.edu.pe', '', 1, '2022-07-22', '2024-02-23 13:46:03', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (98, 'GERMAN', 'ARANIBAR OLIVAS', '00952597', '$2a$07$asxx54ahjppf45sd87a5auZZVesZWJUPClxW5x5f47fkh5W2jfXpG', '1', '00952597', '955675606', 18, 'garanibar@unsm.edu.pe', '', 1, '2023-08-29', '2024-02-02 16:35:17', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (99, 'LADY DIANA', 'AREVALO ALVA', '43040028', '$2a$07$asxx54ahjppf45sd87a5au7uiWIZE8W1Vi0A7m75DbJQsXoQwNsSG', '1', '43040028', '964894655', 18, 'alicialopezflores@unsm.edu.pe', '', 1, '2023-01-17', '2023-11-08 22:01:46', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (100, 'OLGA ADRIANA', 'AREVALO CUEVA', '40802625', '$2a$07$asxx54ahjppf45sd87a5au.Wk2Md9ZiWmtmnAkQyYitcLNcskuxRK', '1', '40802625', '948590963', 18, 'oaarevalo@unsm.edu.pe', '', 1, '2023-07-03', '2024-08-01 10:20:36', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (101, 'LOLITA', 'AREVALO FASANANDO', '01061380', '$2a$07$asxx54ahjppf45sd87a5au5XnHuaKbOV3QVNo8eDTzOgdUV1aamjm', '1', '01061380', '942692685', 18, 'larevalo@unsm.edu.pe', 'JR. SAPOSOA 118 TARAPOTO', 1, '2022-08-20', '2024-09-04 14:00:17', NULL, '2023-10-09 14:58:42', NULL);
INSERT INTO `usuario` VALUES (102, 'HERIBERTO', 'AREVALO RAMIREZ', '17815382', '$2a$07$asxx54ahjppf45sd87a5au5M82DjcONvOVnub.5cqx3crdDrzUAk2', '1', '17815382', '942828309', 18, 'harevalo@unsm.edu.pe', '', 1, '2022-05-14', '2024-09-04 09:48:29', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (103, 'MARTIN EZEQUIEL', 'ARROYO BENITES', '18070784', '$2a$07$asxx54ahjppf45sd87a5auvJhIx.4Rn7nV28Z7lvlFFiOwalMbBqa', '1', '18070784', '941890324', 18, 'mearroyo@unsm.edu.pe', '', 1, '2022-06-23', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (104, 'GILBERTO UBALDO', 'ASCON DIONICIO', '01109000', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01109000', '941951132', 18, 'guascon@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (105, 'SABINO', 'AYALA VILLEGAS', '01077869', '$2a$07$asxx54ahjppf45sd87a5auiZccmFYxc3OPohb/rzx.EXoBfwdwFou', '1', '01077869', '962542158', 18, 'sayala@unsm.edu.pe', '', 1, '2022-11-26', '2024-09-02 08:31:47', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (106, 'YRWIN FRANCISCO', 'AZABACHE LIZA', '18070745', '$2a$07$asxx54ahjppf45sd87a5auQgYKOygbVMvhGRi2bi2b5tXz7jRuK62', '1', '18070745', '958425398', 18, 'yfazabache@unsm.edu.pe', '', 1, '2022-07-11', '2024-08-22 06:22:54', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (107, 'ESTELA', 'BANCES ZAPATA', '16477141', '$2a$07$asxx54ahjppf45sd87a5auoq3SbhzvmQ5ttfmbDXJKl2Vg84zxvV6', '1', '16477141', '949939168', 18, 'ebances@unsm.edu.pe', '', 1, '2022-07-07', '2024-01-07 22:42:08', NULL, '2024-01-07 23:09:14', NULL);
INSERT INTO `usuario` VALUES (108, 'EFRAIN DE LA CRUZ', 'BARDALES ZAPATA', '16681180', '$2a$07$asxx54ahjppf45sd87a5auN7VFyIWAcO7LqLbxkaK5OU0sAT8x7Sq', '1', '16681180', '990946648', 18, 'ebardalesz@unsm.edu.pe', '', 1, '2022-08-11', '2024-08-18 19:11:58', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (109, 'MARVIN', 'BARRERA LOZANO', '00907036', '$2a$07$asxx54ahjppf45sd87a5aufd7aNKmH.YrBwfSGwffmlxm/oOrV2fm', '1', '00907036', '942613076', 18, 'mbarrera@unsm.edu.pe', '', 1, '2022-08-30', '2024-08-23 08:59:59', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (110, 'ABNER MILAN', 'BARZOLA CARDENAS', '01077389', '$2a$07$asxx54ahjppf45sd87a5auqE.eobiAZOwIcOfziqgCiVoRa40C/U2', '1', '01077389', '(042) 52-4296', 18, 'ambarzola@unsm.edu.pe', '', 1, '2023-03-13', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (111, 'ANA MARIBEL', 'BECERRIL IBERICO', '01064005', '$2a$07$asxx54ahjppf45sd87a5auc3cLg2/TbfSJz7jMhLaNAb5wjirG7XS', '1', '01064005', '942661441', 18, 'ambecerril@unsm.edu.pe', '', 1, '2022-11-19', '2024-08-02 14:45:06', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (112, 'HUGO ELIAS', 'BERNAL LOZANO', '01121124', '$2a$07$asxx54ahjppf45sd87a5auO0Wya34stOUkqS1GawvGH8sFmHpsfoW', '1', '01121124', '942952726', 18, 'hebernal@unsm.edu.pe', '', 1, '2022-08-11', '2024-09-05 07:37:17', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (113, 'PABLO OSWALDO', 'BLAZ MIRANDA', '01156459', '$2a$07$asxx54ahjppf45sd87a5auJqOmq2P8Kr3NnF5RWGTZRgNcWtIgiu.', '1', '01156459', '942018426', 18, 'poblaz@unsm.edu.pe', '', 1, '2022-07-06', '2024-02-08 13:23:27', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (114, 'JESSICA DEL PILAR', 'CABEL RABINES', '18207193', '$2a$07$asxx54ahjppf45sd87a5auehUxFVL8g1FJLqaS1WfzYs8ydF8zPdi', '1', '18207193', '944461352', 18, 'jpcabel@unsm.edu.pe', '', 1, '2022-06-23', '2024-08-15 09:39:28', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (115, 'CLAY PETTER', 'CABRERA TUANAMA', '01163212', '$2a$07$asxx54ahjppf45sd87a5auUj2YAQ17f8H/BxEIdyZKdz69aYaGpIe', '1', '01163212', '964931229', 18, 'cpcabrerat@unsm.edu.pe', '', 1, '2022-08-19', '2024-08-09 18:27:03', NULL, '2024-02-19 12:12:46', NULL);
INSERT INTO `usuario` VALUES (116, 'GERARDO', 'CACERES BARDALEZ', '40132871', '$2a$07$asxx54ahjppf45sd87a5auvFU51JxivuBFR28ncagnAhorDYaBciy', '1', '40132871', '942653856', 18, 'gcaceres@unsm.edu.pe', '', 1, '2022-06-18', '2024-08-09 10:23:11', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (117, 'WILHELM', 'CACHAY ORTIZ', '00807031', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '00807031', '985506201', 18, 'wcachay@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (118, 'JULIO CESAR', 'CAPPILLO TORRES', '00966459', '$2a$07$asxx54ahjppf45sd87a5auQyNWwGZ4J/CuaFSGlokDzCY8FeaDDDS', '1', '00966459', '942873170', 18, 'jcappillo@unsm.edu.pe', '', 1, '2022-09-14', '2024-08-25 17:24:06', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (119, 'CARMEN TEODORO', 'CARDENAS ALAYO', '01159874', '$2a$07$asxx54ahjppf45sd87a5auGO/J/s2dPw8KR7lg9w.Wn9.ojzXMaX.', '1', '01159874', '947995117', 18, 'ctcardenas@unsm.edu.pe', 'Jr. Independencia 214-Morales', 1, '2022-05-14', '2023-11-23 16:23:10', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (120, 'SERGIO LEONEL', 'CARPIO CARDENAS', '43486081', '$2a$07$asxx54ahjppf45sd87a5au15IDqqMhY1IEZO2ggK5fQo02wf8yQIa', '1', '43486081', '971143666', 18, 'slcarpio@unsm.edu.pe', '', 1, '2024-03-29', '2024-09-04 09:12:08', NULL, '2023-12-29 09:48:23', NULL);
INSERT INTO `usuario` VALUES (121, 'SANTIAGO ALBERTO', 'CASAS LUNA', '08008037', '$2a$07$asxx54ahjppf45sd87a5aupvOgQl3XntWdyH/GksNQjCu3fWIleqm', '1', '08008037', '975492187', 18, 'scasasl@unsm.edu.pe', '', 1, '2022-07-28', '2024-07-20 11:21:55', NULL, '2024-01-11 11:30:14', NULL);
INSERT INTO `usuario` VALUES (122, 'YOLANDA', 'CASTAÑEDA ALMERI', '18884074', '$2a$07$asxx54ahjppf45sd87a5aua2YQUcuYEKzd/2iZht.2PkgCmrR5TtK', '1', '18884074', '947926287', 18, 'ycastaneda@unsm.edu.pe', '', 1, '2022-05-10', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (123, 'RICARDO', 'CASTAÑEDA CABANILLAS', '01105160', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01105160', '942953201', 18, 'rcastaneda@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (124, 'TEDY', 'CASTILLO DIAZ', '01117959', '$2a$07$asxx54ahjppf45sd87a5auprOd/eDSbKa1XozUQ5Hr7A6kBEPUvza', '1', '01117959', '948625042', 18, 'tcastillo@unsm.edu.pe', '', 1, '2022-07-01', '2024-08-01 08:39:07', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (125, 'EULER', 'CASTILLO PINEDO', '01161403', '$2a$07$asxx54ahjppf45sd87a5auiK34e6hD.2egp4Bfqrhtusw6XO57daq', '1', '01161403', '951078886', 18, 'ecastillo@unsm.edu.pe', '', 1, '2022-07-26', '2024-09-10 19:55:23', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (126, 'INES', 'CASTILLO SANTA MARIA', '01130389', '$2a$07$asxx54ahjppf45sd87a5audC4pGPsIrEf9GIZ1gE3gdPfnZ5szNLS', '1', '01130389', '942998211', 18, 'icastillo@unsm.edu.pe', '', 1, '2022-08-20', '2024-07-31 16:26:31', NULL, '2023-08-25 11:12:16', NULL);
INSERT INTO `usuario` VALUES (127, 'NANCY BETTY', 'CAYO HUACHACA', '09878774', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '09878774', '945135034', 18, 'nbcayo@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (128, 'JOSE ENRIQUE', 'CELIS ESCUDERO', '00838985', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '00838985', '942882620', 18, 'jcelis@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (129, 'FABIAN', 'CENTURION TAPIA', '05315301', '$2a$07$asxx54ahjppf45sd87a5au./RzMV/6wcPTNU0bPlF8DTe7vSBQk0S', '1', '05315301', '949544647', 18, 'fcenturion@unsm.edu.pe', '', 1, '2023-03-21', '2024-09-03 17:02:45', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (130, 'OTILIA DEL SOCORRO', 'CERDAN RABINES', '17926938', '$2a$07$asxx54ahjppf45sd87a5auoyEiVW0R03g4l7BIdWZR9DnvH69HzsG', '1', '17926938', '955985934', 18, 'oscerdan@unsm.edu.pe', '', 1, '2024-01-10', '2024-04-09 14:03:08', NULL, '2023-11-09 11:37:30', NULL);
INSERT INTO `usuario` VALUES (131, 'AGUSTÍN', 'CERNA MENDOZA', '01105141', '$2a$07$asxx54ahjppf45sd87a5aumQ/H2hmO8JFZe.kZReko6TVqlI35E1y', '1', '01105141', '950029611', 18, 'acoronel@unsm.edu.pe', '', 1, '2022-05-15', '2024-09-02 10:56:40', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (132, 'ERIKA PATRICIA', 'CHANG ALVA', '01161414', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01161414', '923628202', 18, 'echang@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (133, 'CESAR ENRIQUE', 'CHAPPA SANTA MARIA', '01089862', '$2a$07$asxx54ahjppf45sd87a5auN840HP6s8e9ChzXsudZzWX7tiUjbE32', '1', '01089862', '945786230', 18, 'cechappa@unsm.edu.pe', '', 1, '2023-05-27', '2024-02-16 09:27:27', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (134, 'VICTOR', 'CHAPPA SANTA MARIA', '01089450', '$2a$07$asxx54ahjppf45sd87a5auCSw7frHqpRptPETKm/.lxkV3VK6qebO', '1', '01089450', '933551957', 18, 'vchappa@unsm.edu.pe', '', 1, '2022-05-08', '2023-10-02 07:03:33', NULL, '2023-08-03 11:57:20', NULL);
INSERT INTO `usuario` VALUES (135, 'SANTIAGO', 'CHAVEZ CACHAY', '26648504', '$2a$07$asxx54ahjppf45sd87a5augRKPlJKkZyhXgua9Vz1nVmx4zQ/dZNa', '1', '26648504', '976332596', 18, 'schavez@unsm.edu.pe', '', 1, '2022-11-12', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (136, 'WALTHER', 'CHAVEZ RIVASPLATA', '17845070', '$2a$07$asxx54ahjppf45sd87a5auwJMd6hJSnsvtn.8sUsaw9kgI/a/N2Wq', '1', '17845070', '942017843', 18, 'wchavez@unsm.edu.pe', '', 1, '2022-09-17', '2024-07-03 09:56:22', NULL, '2023-06-22 10:57:41', NULL);
INSERT INTO `usuario` VALUES (137, 'ANGEL', 'CHAVEZ SALAZAR', '33720009', '$2a$07$asxx54ahjppf45sd87a5au/PMPkpE0sB3PKP.W38cZgnq3unKY0Oa', '1', '33720009', '942864109', 18, 'angelchavez@unsm.edu.pe', '', 1, '2022-09-02', '2023-12-06 18:09:48', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (138, 'CARLOS ENRIQUE', 'CHUNG ROJAS', '01089135', '$2a$07$asxx54ahjppf45sd87a5auePrXPYfagOtSBWySL5sVu2N4tTVyyDu', '1', '01089135', '942622066', 18, 'cechung@unsm.edu.pe', '', 1, '2022-05-15', '2024-06-19 16:27:28', NULL, '2024-01-08 16:48:40', NULL);
INSERT INTO `usuario` VALUES (139, 'LUISA', 'CONDORI ', '29437116', '$2a$07$asxx54ahjppf45sd87a5auoGpqE8D/OySPrYZOEbB7eGGnjTMaHV2', '1', '29437116', '948661994', 18, 'lcondori@unsm.edu.pe', '', 1, '2022-09-01', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (140, 'VICTOR DANIEL', 'CORAL PEREZ', '01065089', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01065089', '942462643', 18, 'vdcoral@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (141, 'LUIS HILDEBRANDO', 'CORDOVA CALLE', '01118927', '$2a$07$asxx54ahjppf45sd87a5auvrQ0DneWlX8GDGxolIhg3ABZ7XX58GW', '1', '01118927', '980293389', 18, 'lcordovacalle@unsm.edu.pe', '', 1, '2023-04-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (142, 'ALEX', 'CORDOVA VASQUEZ', '42412849', '$2a$07$asxx54ahjppf45sd87a5auh6V8HMevA/PI1jO7PZzkzXJCXoqfQby', '1', '42412849', '943128294', 18, 'jogarcia@unsm.edu.pe', '', 1, '2023-05-22', '2024-08-03 14:41:03', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (143, 'JULIA', 'CORNEJO QUISPE', '08864349', '$2a$07$asxx54ahjppf45sd87a5auqQQAtABajTI4vVbebnEyMKrVJcMol1C', '1', '08864349', '942869086', 18, 'jcornejo@unsm.edu.pe', '', 1, '2023-03-22', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (144, 'MANUEL FERNANDO', 'CORONADO JORGE', '01124893', '$2a$07$asxx54ahjppf45sd87a5ausOAhNoyUHfPwmyhmB6Sa5DIeiAyatBi', '1', '01124893', '943847293', 18, 'mfcoronado@unsm.edu.pe', '', 1, '2023-03-29', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (145, 'CESAR AUGUSTO', 'COSTA POLO', '01149328', '$2a$07$asxx54ahjppf45sd87a5au540i2wBF3xv.x65yQO/4fkqjcozqSxq', '1', '01149328', '942928878', 18, 'cacostap@unsm.edu.pe', '', 1, '2023-11-01', '2024-09-04 21:05:42', NULL, '2023-08-01 12:44:08', NULL);
INSERT INTO `usuario` VALUES (146, 'JANINA', 'COTRINA LINARES DE QUEZADA', '01101194', '$2a$07$asxx54ahjppf45sd87a5au.dyvcN8PIVOPTWCFmdMJa1V5RbxE7aq', '1', '01101194', '939573163', 18, 'jcotrina@unsm.edu.pe', '', 1, '2023-04-03', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (147, 'ALEJANDRO ALBERTO', 'CRUZ RENGIFO', '01110679', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01110679', '956513527', 18, 'acruz@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (148, 'ROSA ELENA', 'CUETO ORBE', '01117140', '$2a$07$asxx54ahjppf45sd87a5auERdvXV4j6JFZHp1cNmlDqgj/vjPJmSC', '1', '01117140', '958561343', 18, 'recuetoo@unsm.edu.pe', '', 1, '2022-08-31', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (149, 'PEDRO', 'CUNYA FLORES', '02654956', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '02654956', '956147338', 18, 'ssalva@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (150, 'ARBEL', 'DAVILA RIVERA', '00822866', '$2a$07$asxx54ahjppf45sd87a5auBIUaJGqqR1alyx2NW92j5.f9iIYieRq', '1', '00822866', '942607856', 18, 'adavila@unsm.edu.pe', '', 1, '2022-07-25', '2024-09-05 00:46:25', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (151, 'CONSUELO', 'DAVILA TORRES', '01112931', '$2a$07$asxx54ahjppf45sd87a5au1VBSShCMETXuB8YPh.j6mHAwEbi0rf6', '1', '01112931', '942608791', 18, 'cdavila@unsm.edu.pe', '', 1, '2022-09-21', '2024-06-27 18:43:33', NULL, '2024-03-04 14:54:24', NULL);
INSERT INTO `usuario` VALUES (152, 'MARIA ANTONIETA', 'DEL AGUILA LOZANO', '01120966', '$2a$07$asxx54ahjppf45sd87a5auJ.gzVY7vNXjZ3XytZriM3ieiuL1Vjz.', '1', '01120966', '942414197', 18, 'madelaguila@unsm.edu.pe', '', 1, '2022-11-18', '2024-07-22 15:23:24', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (153, 'RUBEN', 'DEL AGUILA PANDURO', '01068356', '$2a$07$asxx54ahjppf45sd87a5auBTEmgECxhsYC2LkhqtmTX1V0HVgW22m', '1', '01068356', '999424292', 18, 'rdelaguila@unsm.edu.pe', '', 1, '2022-10-05', '2024-08-20 17:48:22', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (154, 'JULIO CESAR', 'DE LA ROSA RIOS', '00817168', '$2a$07$asxx54ahjppf45sd87a5aueUjNl.cWMc/A8ZZuXRkbLi4Cus7Vl/W', '1', '00817168', '943042278', 18, 'jcdelarosa@unsm.edu.pe', '', 1, '2022-07-08', '2024-08-22 17:26:59', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (155, 'LIRIA', 'DEL CASTILLO ORBE', '01064442', '$2a$07$asxx54ahjppf45sd87a5auhrEn2eAXAYNvmZkYP.vtLa0CgIa4SS2', '1', '01064442', '942682940', 18, 'ldelcastillo@unsm.edu.pe', '', 1, '2022-05-16', '2024-01-30 18:11:18', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (156, 'CESAR', 'DEL CASTILLO PEREZ', '01189655', '$2a$07$asxx54ahjppf45sd87a5auJxXYj1hJjP15te80GiFYGh7mu1fwNTe', '1', '01189655', '964736555', 18, 'jlparedes@unsm.edu.pe', '', 1, '2022-05-23', '2024-01-08 16:33:51', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (157, 'JOSE MANUEL', 'DELGADO BARDALES', '01126836', '$2a$07$asxx54ahjppf45sd87a5au75aSPCopNC8soIt2aTLIxO1nSTDdoLS', '1', '01126836', '941907628', 18, 'jmdelgado@unsm.edu.pe', '', 1, '2023-11-09', '2023-08-10 09:40:52', NULL, '2023-08-09 10:37:47', NULL);
INSERT INTO `usuario` VALUES (158, 'MANUELA', 'DEL ÁGUILA BARTRA', '01062453', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01062453', '947812174', 18, 'mdelaguilab@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (159, 'NORA MANUELA', 'DEXTRE PALACIOS', '01110030', '$2a$07$asxx54ahjppf45sd87a5auT.pivyTrhaVSCJz0t.QEXeNRy7fAgZG', '1', '01110030', '941904601', 18, 'nmdextre@unsm.edu.pe', '', 1, '2022-05-22', '2024-03-07 19:58:42', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (160, 'JUVENAL VICENTE', 'DIAZ AGIP', '01158760', '$2a$07$asxx54ahjppf45sd87a5auT0RmNbwo/B62o67V7ju6sYoKlsRQ8x2', '1', '01158760', '942860400', 18, 'jvdiaz@unsm.edu.pe', '', 1, '2022-11-12', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (161, 'ALFREDO IBAN', 'DIAZ VISITACION', '17854925', '$2a$07$asxx54ahjppf45sd87a5auC.3QdU23G8Ad0c3jLswQHsowqpyGFRC', '1', '17854925', '942834647', 18, 'aidiaz@unsm.edu.pe', '', 1, '2022-06-14', '2024-07-11 22:59:02', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (162, 'KAREN GABRIELA', 'DOCUMET PETRLIK', '01147548', '$2a$07$asxx54ahjppf45sd87a5auJavX5B3ATAAsehN69jjhGwt56plhDs6', '1', '01147548', '965084234', 18, 'kgdocumet@unsm.edu.pe', '', 1, '2023-10-12', '2024-08-10 17:32:51', NULL, '2023-07-12 07:55:25', NULL);
INSERT INTO `usuario` VALUES (163, 'MANUEL SANTIAGO', 'DORIA BOLAÑOS', '01061569', '$2a$07$asxx54ahjppf45sd87a5auK6.341hT4Rx53od89.VQe3v2C1x4ZE2', '1', '01061569', '942686892', 18, 'mdoria@unsm.edu.pe', '', 1, '2024-05-15', '2024-02-15 09:28:34', NULL, '2024-02-15 09:27:52', NULL);
INSERT INTO `usuario` VALUES (164, 'JUAN CARLOS', 'DUHARTE PEREDO', '09597487', '$2a$07$asxx54ahjppf45sd87a5auip6g9xfKAee8thpnw9tLDVgBT/3HYae', '1', '09597487', '952244720', 18, 'jcduhartep@unsm.edu.pe', '', 1, '2023-11-04', '2024-08-15 00:46:12', NULL, '2023-08-04 22:08:16', NULL);
INSERT INTO `usuario` VALUES (165, 'DANNY', 'ENCOMENDEROS DAVALOS', '18092156', '$2a$07$asxx54ahjppf45sd87a5auNA9bVJEMq1AJF7UMAVav7QoGybm35.O', '1', '18092156', '953625028', 18, 'dencomenderos@unsm.edu.pe', '', 1, '2022-07-22', '2024-09-05 03:43:41', NULL, '2023-11-16 12:02:53', NULL);
INSERT INTO `usuario` VALUES (166, 'CARLO', 'ESPINOZA AGUILAR', '16733556', '$2a$07$asxx54ahjppf45sd87a5auzfg2WUG/R1/v.3NsUn1eSVY6ccKQx7u', '1', '16733556', '950648576', 18, 'cespinoza@unsm.edu.pe', '', 1, '2022-06-23', '2024-08-02 08:39:30', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (167, 'DAVID NICOLAS', 'ESPINOZA DEXTRE', '43724426', '$2a$07$asxx54ahjppf45sd87a5auXwlQgG2aGK3K7sVvuyVk6mgEjQIiSOe', '1', '43724426', '980030177', 18, 'dnespinozad@unsm.edu.pe', '', 1, '2022-06-28', '2024-01-02 17:34:03', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (168, 'EDGARD MARTÍN', 'ESQUÉN PERALES', '16626554', '$2a$07$asxx54ahjppf45sd87a5auikk1zp3Asjd0Q0ItMWHtH9LS2hPiFAO', '1', '16626554', '937618316', 18, 'emesquen@unsm.edu.pe', '', 1, '2022-06-28', '2024-08-21 10:48:11', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (169, 'JOSE ALBERTO', 'FALEN MORALES', '16672822', '$2a$07$asxx54ahjppf45sd87a5aunyDjM98K1MC5j/E2zXnEPEd5TgR6.Te', '1', '16672822', '942625421', 18, 'recuetoo@unsm.edu.pe', '', 1, '2022-09-16', '2023-10-07 20:57:06', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (170, 'LUIS ENRIQUE', 'FARRO GAMBOA', '19323857', '$2a$07$asxx54ahjppf45sd87a5auiib4IMUtSCJ/GJaU2vIEWnRqsR0eiIy', '1', '19323857', '942933047', 18, 'lefarro@unsm.edu.pe', '', 1, '2024-02-15', '2024-07-17 12:32:43', NULL, '2023-11-15 09:14:41', NULL);
INSERT INTO `usuario` VALUES (171, 'MARIA ELENA', 'FARRO ROQUE', '01160186', '$2a$07$asxx54ahjppf45sd87a5auAxfil1qkVINTgGFt1SixAd6msYsxjU2', '1', '01160186', '942686181', 18, 'mefarro@unsm.edu.pe', '', 1, '2023-02-04', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (172, 'LUIS ALBERTO', 'FERNANDEZ SANJINES', '16659914', '$2a$07$asxx54ahjppf45sd87a5auHhP2M14rLULIiYKfPA/oXwA4LsB304S', '1', '16659914', '979276576', 18, 'lafernandez@unsm.edu.pe', '', 1, '2022-06-28', '2024-07-02 07:16:12', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (173, 'CARLOS ALBERTO', 'FLORES CRUZ', '16804870', '$2a$07$asxx54ahjppf45sd87a5au6ErDaigtYSCcNeyTkbAT4d/JXwkIBZ6', '1', '16804870', '990946480', 18, 'caflores@unsm.edu.pe', '', 1, '2022-06-28', '2023-11-30 09:16:05', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (174, 'EYBIS JOSE', 'FLORES GARCIA', '01086239', '$2a$07$asxx54ahjppf45sd87a5auLixABMiQmyf54SL8HPz7erLJ2iuWuA6', '1', '01086239', '969406173', 18, 'ejflores@unsm.edu.pe', '', 1, '2023-06-14', '2024-03-08 12:50:00', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (175, 'RONY', 'FLORES RAMIREZ', '42408638', '$2a$07$asxx54ahjppf45sd87a5auJDSc/xg1ObxUIWKN1GvbWopf9jUU4SW', '1', '42408638', '942980525', 18, '', '', 1, '2022-06-11', '2024-05-24 16:02:11', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (176, 'LUIS ALBERTO', 'GALVEZ MONCADA', '18027783', '$2a$07$asxx54ahjppf45sd87a5auOYj786NIdsxACWN41kQjcfd3Beu.sgC', '1', '18027783', '938262628', 18, 'lagalvez@unsm.edu.pe', '', 1, '2023-08-26', '2024-05-27 16:51:38', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (177, 'JUAN CARLOS', 'GARCIA CASTRO', '00954073', '$2a$07$asxx54ahjppf45sd87a5auxeTPQWp7fX8Cf3kfz1KZzDw7Fxv2ggy', '1', '00954073', '955935161', 18, 'jcgarcia@unsm.edu.pe', '', 1, '2022-05-14', '2024-07-11 20:00:19', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (178, 'CRISTIAN WERNER', 'GARCIA ESTRELLA', '42561521', '$2a$07$asxx54ahjppf45sd87a5auypqWRl2o/xlKktadJzZnv9secGRJBYq', '1', '42561521', '962937423', 18, 'cgarcia@unsm.edu.pe', '', 1, '2022-08-20', '2024-08-21 15:29:55', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (179, 'NELSON', 'GARCIA GARAY', '01063440', '$2a$07$asxx54ahjppf45sd87a5auMFGsZ4an0fcVBSzhMp7cdJVIXoZLW32', '1', '01063440', '943090166', 18, 'ngarcia@unsm.edu.pe', '', 1, '2022-08-12', '2023-09-19 17:01:12', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (180, 'PATRICIA ELENA', 'GARCIA GONZALES', '01117722', '$2a$07$asxx54ahjppf45sd87a5aud1O7jxz5K9xMlAYXuHulJPC7/P.oEaa', '1', '01117722', '940279443', 18, 'pegarcia@unsm.edu.pe', '', 1, '2022-06-16', '2024-08-29 14:31:21', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (181, 'ERNESTO ELISEO', 'GARCIA RAMIREZ', '01073306', '$2a$07$asxx54ahjppf45sd87a5aumdoT8wzITK2j/dLRMOX6GWhoTK.hrIO', '1', '01073306', '942693016', 18, 'eegarcia@unsm.edu.pe', '', 1, '2022-05-11', '2024-06-02 11:05:44', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (182, 'JULIO HELI', 'GARRIDO LOPEZ', '00952433', '$2a$07$asxx54ahjppf45sd87a5au/FNlqUQx3hR9Dcucm1oLhpv93/s6BbW', '1', '00952433', '985617081', 18, 'jhgarrido@unsm.edu.pe', '', 1, '2023-06-22', '2024-08-11 00:27:11', NULL, '2023-12-11 10:32:06', NULL);
INSERT INTO `usuario` VALUES (183, 'JULIO CESAR', 'GASTELO BARDALES', '16789681', '$2a$07$asxx54ahjppf45sd87a5au.gVYbVwF3UOG8f9oKYJw1gbm.9gn8oC', '1', '16789681', '942785500', 18, 'jcgastelo@unsm.edu.pe', 'Jr. Uruguay 152 - Tarapoto', 1, '2022-05-14', '2024-07-20 05:54:45', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (184, 'FERNANDA', 'GOMEZ ALEGRIA', '42757532', '$2a$07$asxx54ahjppf45sd87a5auHBpAYtfFTvfhF8mWK/l81Oh0/7xCZn2', '1', '42757532', '930771896', 18, 'jrsiaden@unsm.edu.pe', '', 1, '2024-01-20', '2023-10-20 13:17:56', NULL, '2023-10-20 13:17:15', NULL);
INSERT INTO `usuario` VALUES (185, 'JULIO CESAR', 'GONZALES DEL AGUILA', '22409405', '$2a$07$asxx54ahjppf45sd87a5auU35jbtA03AW96r3SX3jtPTR9Cf.n4o2', '1', '22409405', '942694573', 18, 'jgonzales@unsm.edu.pe', '', 1, '2023-02-14', '2024-08-01 11:37:04', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (186, 'PEDRO ANTONIO', 'GONZALES SANCHEZ', '01163222', '$2a$07$asxx54ahjppf45sd87a5auTvcsBh2hYQNhFp1LEgsGjnkMYyfbxVS', '1', '01163222', '982810493', 18, 'pagonzales@unsm.edu.pe', '', 1, '2023-03-19', '2024-09-04 16:36:18', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (187, 'NERIDA IDELSA', 'GONZALEZ GONZALEZ', '18854568', '$2a$07$asxx54ahjppf45sd87a5aufyECRQEpZ2qBoJEzOUD6W5neipG6sqy', '1', '18854568', '957656301', 18, 'nigonzales@unsm.edu.pe', '', 1, '2022-06-23', '2024-08-05 13:55:22', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (188, 'HILDA', 'GONZALEZ NAVARRO', '01061377', '$2a$07$asxx54ahjppf45sd87a5auEtIJbAEOeBzz2s6ipkvYb068nxpQlOi', '1', '01061377', '947454933', 18, 'hgonzalez@unsm.edu.pe', '', 1, '2023-10-21', '2024-05-29 18:07:16', NULL, '2024-03-27 07:45:44', NULL);
INSERT INTO `usuario` VALUES (189, 'PAMELA MAGNOLIA', 'GRANDA MILON', '01121822', '$2a$07$asxx54ahjppf45sd87a5au4gl0ezkA6L7gdzn1aFnC/xwIcNzy4Gq', '1', '01121822', '960742633', 18, 'pmgranda@unsm.edu.pe', '', 1, '2022-11-24', '2024-09-01 19:58:54', NULL, '2023-11-04 12:05:26', NULL);
INSERT INTO `usuario` VALUES (190, 'PEGGY', 'GRANDEZ RODRIGUEZ', '01077229', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01077229', '(042) 52-5244', 18, 'pgrandez@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (191, 'JAIME GUILLERMO', 'GUERRERO MARINA', '01088009', '$2a$07$asxx54ahjppf45sd87a5auG1vbRW1UWy8ejOs0H6irqdujpzN4BG.', '1', '01088009', '942831400', 18, 'jgguerrero@unsm.edu.pe', '', 1, '2022-05-10', '2024-01-12 12:04:36', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (192, 'VIOLETA', 'GUILLERMO MORENO', '01120436', '$2a$07$asxx54ahjppf45sd87a5auLNmGGDIUOBSXRw3TYbOyhiqkZin16w6', '1', '01120436', '959602368', 18, 'vguillermo@unsm.edu.pe', '', 1, '2023-03-14', '2024-08-17 20:01:09', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (193, 'FELIPE BALTAZAR', 'GUTIERREZ ARCE', '42235034', '$2a$07$asxx54ahjppf45sd87a5auGNW0TlJtLRkO739tIcNO44JPZv/9vda', '1', '42235034', '938254660', 18, 'joivillasis@unsm.edu.pe', '', 1, '2022-10-21', '2024-08-19 09:56:13', NULL, '2023-10-11 01:26:26', NULL);
INSERT INTO `usuario` VALUES (194, 'JORGE FERNANDO', 'GUTIÉRREZ LÓPEZ', '08631654', '$2a$07$asxx54ahjppf45sd87a5au/4Tr04XZr8sHq9VPLtCP9L5d5B9op1a', '1', '08631654', '950043543', 18, 'jfgutierrezl@unsm.edu.pe', 'Jr. Micaela Bastidas N° 151 -Tarapoto', 1, '2022-05-11', '2023-11-24 15:27:29', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (195, 'JOSE ENRRIQUE', 'GUZMAN ANTICONA', '18126303', '$2a$07$asxx54ahjppf45sd87a5aude1a4rtZmE5e8spCzGHedvbufTm.xxi', '1', '18126303', '942061687', 18, 'jeguzmana@unsm.edu.pe', '', 1, '2023-01-13', '2024-06-21 13:24:10', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (196, 'EDWIN AUGUSTO', 'HERNANDEZ TORRES', '17855758', '$2a$07$asxx54ahjppf45sd87a5audoakl6eRNQQSn6uD4VulYcfS.N9PMwq', '1', '17855758', '985711469', 18, 'ehernandez@unsm.edu.pe', '', 1, '2022-08-16', '2024-08-25 17:25:11', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (197, 'JUAN CARLOS', 'HERRERA VASQUEZ', '01062107', '$2a$07$asxx54ahjppf45sd87a5auzga1oTRH.K.Vn4tuUr/8Go5Z37CAEWS', '1', '01062107', '942692406', 18, 'jcherrera@unsm.edu.pe', '', 1, '2022-09-22', '2024-08-16 11:00:55', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (198, 'CARLOS FRANCOIS', 'HIDALGO REATEGUI', '18138473', '$2a$07$asxx54ahjppf45sd87a5au8Q6UeoEDIXZ2C51cyd.jEZcl/bF2DRG', '1', '18138473', '943017801', 18, 'cfrancoishr@unsm.edu.pe', '', 1, '2022-06-23', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (199, 'FREDY', 'HUAMAN HIDALGO', '00952508', '$2a$07$asxx54ahjppf45sd87a5aufS5BIgP1pFtVdL3nOHQTvdoSEyuPH8q', '1', '00952508', '944831008', 18, 'fhuaman@unsm.edu.pe', 'Jr Yurimaguas # 322 bda de Shilcayo ', 1, '2022-05-23', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (200, 'CARLOS SEGUNDO', 'HUAMAN TORREJON', '00953561', '$2a$07$asxx54ahjppf45sd87a5auZbfdptb//xt7U08hUBjY/pAgC/A4nLS', '1', '00953561', '950042479', 18, 'cshuamant@unsm.edu.pe', '', 1, '2023-07-13', '2024-08-07 09:30:35', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (201, 'MARINA VICTORIA', 'HUAMANTUMBA PALOMINO', '01071032', '$2a$07$asxx54ahjppf45sd87a5auVHwobxtxe.hdyUUAhAyTcc9eRgp8hWO', '1', '01071032', '942631537', 18, 'mvhuamantumba@unsm.edu.pe', '', 1, '2023-03-28', '2023-12-01 13:00:27', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (202, 'ELIZABETH', 'IGARZA CAMPOS', '01073212', '$2a$07$asxx54ahjppf45sd87a5aubBBvwjnGRAlspOmuwBhGG9scYpFGvGq', '1', '01073212', '942860974', 18, 'eigarza@unsm.edu.pe', '', 1, '2022-07-21', '2024-09-02 12:36:45', NULL, '2023-09-20 12:32:12', NULL);
INSERT INTO `usuario` VALUES (203, 'JEANETT SONIA', 'IGARZA CAMPOS', '01035566', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01035566', '942869365', 18, 'jsigarza@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (204, 'RICHARD ENRIQUE', 'INJANTE ORE', '41770053', '$2a$07$asxx54ahjppf45sd87a5auoLIhcuiX8vfh5XvUr702ByjwINEHCta', '1', '41770053', '942683389', 18, 'richard@unsm.edu.pe', '', 1, '2022-10-14', '2024-08-24 03:31:27', NULL, '2023-06-26 23:07:36', NULL);
INSERT INTO `usuario` VALUES (205, 'JUAN CARLOS', 'IPANAQUE PALACIOS', '43828495', '$2a$07$asxx54ahjppf45sd87a5aui3qp5p7MPaDVoJH26hGxFajEbiEnTwa', '1', '43828495', '921128961', 18, 'jcipanaque@unsm.edu.pe', '', 1, '2022-09-03', '2023-10-13 20:08:12', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (206, 'ROSA EMPERATRIZ', 'JOSEPH BARTRA', '01147940', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01147940', '942853205', 18, 'rejoseph@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (207, 'JUAN RAFAEL', 'JUAREZ DIAZ', '00832534', '$2a$07$asxx54ahjppf45sd87a5auM91KmktweQ8osKxvrzQ2WYuqPhX6OWu', '1', '00832534', '951035205', 18, 'jrjuarezd@unsm.edu.pe', '', 1, '2022-08-04', '2024-08-19 16:38:06', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (208, 'RONALD', 'JULCA URQUIZA', '17837391', '$2a$07$asxx54ahjppf45sd87a5auAYoxBj0Evhj0KhDWwSLAtYsqxIB/Bq2', '1', '17837391', '947443989', 18, 'rjulca@unsm.edu.pe', '', 1, '2022-09-22', '2024-07-15 10:51:19', NULL, '2024-01-30 08:51:03', NULL);
INSERT INTO `usuario` VALUES (209, 'OSCAR SANTIAGO', 'LARIOS RAMIREZ', '80252366', '$2a$07$asxx54ahjppf45sd87a5auzDqVDm01PQKPyVo4XKhfTQfFC.7fZKa', '1', '80252366', '979371496', 18, 'carlogarcia@unsm.edu.pe', '', 1, '2022-11-04', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (210, 'RICARDO RAUL', 'LAYZA CASTAÑEDA', '01144070', '$2a$07$asxx54ahjppf45sd87a5au.h4wSVbxhMdhvDDMcPF4r2dLxH4TFxq', '1', '01144070', '962927209', 18, 'rrlayza@unsm.edu.pe', '', 1, '2022-05-14', '2024-09-05 10:41:01', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (211, 'FLOR ENITH', 'LEVEAU BARRERA', '01116704', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01116704', '942016230', 18, 'feleveau@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (212, 'LUIS ALBERTO', 'LEVEAU GUERRA', '01062916', '$2a$07$asxx54ahjppf45sd87a5au3QI6U71GUi0MgpCAaY9LFL3sFisAwkm', '1', '01062916', '942476282', 18, 'laleveau@unsm.edu.pe', '', 1, '2023-01-06', '2024-09-03 17:07:52', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (213, 'PAULA CLOTILDE', 'LIZA SANTA CRUZ', '00953803', '$2a$07$asxx54ahjppf45sd87a5auTjgwwiSOlYYsiUJKCwFezcHRH7iAigy', '1', '00953803', '953911545', 18, 'pcliza@unsm.edu.pe', '', 1, '2022-07-18', '2024-09-12 09:32:20', NULL, '2023-11-07 08:26:56', NULL);
INSERT INTO `usuario` VALUES (214, 'AUGUSTO RICARDO', 'LLONTOP REATEGUI', '01065829', '$2a$07$asxx54ahjppf45sd87a5aulO/82lui0KG.jckYQOScJaLmV63yQjy', '1', '01065829', '942816989', 18, 'arllontop@unsm.edu.pe', '', 1, '2022-07-29', '2024-08-27 20:15:28', NULL, '2024-06-26 17:47:53', NULL);
INSERT INTO `usuario` VALUES (215, 'TEOBALDO', 'LOPEZ CHUMBE', '00864835', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '00864835', '942401296', 18, 'tlopez@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (216, 'ALICIA MARIA', 'LOPEZ FLORES', '09879847', '$2a$07$asxx54ahjppf45sd87a5auK3qK0yhcwW7bMKPuC4XHiT7RXW1kQjO', '1', '09879847', '945650078', 18, 'larevaloa@unsm.edu.pe', '', 1, '2022-09-09', '2024-08-13 20:20:39', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (217, 'ROALDO', 'LOPEZ FULCA', '01115119', '$2a$07$asxx54ahjppf45sd87a5auatOWVMrBm1GjJ.WT7oyultKjYsKfk8e', '1', '01115119', '950015427', 18, 'roalfulca@unsm.edu.pe', '', 1, '2022-07-20', '2024-08-15 20:50:42', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (218, 'IBIS LIZETH', 'LOPEZ NOVOA', '40120584', '$2a$07$asxx54ahjppf45sd87a5auoPMimjjS.wi7867WbSN97H2f91sLnyG', '1', '40120584', '937687114', 18, 'illopeznovoa@unsm.edu.pe', '', 1, '2022-06-24', '2024-08-05 10:16:40', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (219, 'ENRIQUE', 'LOPEZ RENGIFO', '18102482', '$2a$07$asxx54ahjppf45sd87a5auFwqSoNAtMd3RoJ/lPnuKxrZngdxwDe6', '1', '18102482', '942868273', 18, 'elopez@unsm.edu.pe', '', 1, '2022-08-03', '2024-07-11 14:17:07', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (220, 'CARLOS ENRIQUE', 'LOPEZ RODRIGUEZ', '00865537', '$2a$07$asxx54ahjppf45sd87a5au7UuOajObtPQXUg8S8ElmyUHONZNVu3i', '1', '00865537', '980383603', 18, 'celopez@unsm.edu.pe', '', 1, '2022-05-24', '2024-08-17 11:42:22', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (221, 'ESTUARDO ERIBERTO', 'LOZADA ALDANA', '01109939', '$2a$07$asxx54ahjppf45sd87a5auykNj522PENpxYApYkprxjSdJ1WuuO0q', '1', '01109939', '942624247', 18, 'eelozada@unsm.edu.pe', '...', 1, '2022-06-30', '2024-08-29 12:32:19', NULL, '2023-09-01 11:00:01', NULL);
INSERT INTO `usuario` VALUES (222, 'JORGE YVÁN', 'LUNA CÁRDENAS', '01132023', '$2a$07$asxx54ahjppf45sd87a5au07gx4T2IttpQgNWFAkc6.ay7JQHIUO6', '1', '01132023', '969138996', 18, 'jylunac@unsm.edu.pe', 'Jr. Primero de Abril 364 Banda de Shilcayo', 1, '2022-09-16', '2024-07-18 11:36:28', NULL, '2023-09-18 12:40:52', NULL);
INSERT INTO `usuario` VALUES (223, 'NATIVIDAD LUPE', 'MACEDO RODRIGUEZ', '29397044', '$2a$07$asxx54ahjppf45sd87a5auca/kVvtW3w9cI/8X2nSW8QqKlC4bTES', '1', '29397044', '942884946', 18, 'nlmacedo@unsm.edu.pe', '', 1, '2024-04-24', '2024-08-23 12:10:28', NULL, '2024-01-24 07:30:42', NULL);
INSERT INTO `usuario` VALUES (224, 'SEGUNDO DARIO', 'MALDONADO VASQUEZ', '01069841', '$2a$07$asxx54ahjppf45sd87a5auAUCRtnSCKTKv8gkC2NlN0GFlf3tXSRC', '1', '01069841', '980220813', 18, 'sdmaldonado@unsm.edu.pe', '', 1, '2024-04-12', '2024-01-12 11:16:42', NULL, '2024-01-12 11:16:29', NULL);
INSERT INTO `usuario` VALUES (225, 'KARLA PATRICIA', 'MARTELL ALFARO', '18216268', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '18216268', '942883576', 18, 'pemartinez@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (226, 'PERCY', 'MARTINEZ DAVILA', '05402553', '$2a$07$asxx54ahjppf45sd87a5auW1tRzcr8e/i23xvaEujVkY4zAIeEm8i', '1', '05402553', '957342512', 18, 'hsaavedraa@unsm.edu.pe', '', 1, '2022-07-27', '2024-08-28 13:14:01', NULL, '2024-04-08 19:01:28', NULL);
INSERT INTO `usuario` VALUES (227, 'EPIFANIO EFRAIN', 'MARTINEZ MENA', '06131609', '$2a$07$asxx54ahjppf45sd87a5auUoMQmsOEWcTndv3gAuWn1lWPLZOsnQ2', '1', '06131609', '942689941', 18, 'emartinez@unsm.edu.pe', '', 1, '2023-05-02', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (228, 'ENRIQUE NAPOLEÓN', 'MARTÍNEZ QUIROZ', '00953065', '$2a$07$asxx54ahjppf45sd87a5au.gMW48wcfik3wX7SlNcVz3rRSil1tdS', '1', '00953065', '942684003', 18, 'enmartinez@unsm.edu.pe', '', 1, '2023-07-27', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (229, 'GISELA DEL PILAR', 'MEDINA VELASQUEZ', '42310256', '$2a$07$asxx54ahjppf45sd87a5aut9lCtzIf.9PQFu5qE/Qvc93wWj5/P46', '1', '42310256', '950883067', 18, 'gpmedina@unsm.edu.pe', '', 1, '2024-09-05', '2024-06-05 13:22:06', NULL, '2024-06-05 11:29:15', NULL);
INSERT INTO `usuario` VALUES (230, 'MARI LUZ', 'MEDINA VIVANCO', '00954093', '$2a$07$asxx54ahjppf45sd87a5auH5Nhsxz.Z29QGrVRi3PNcf5rUka9WCe', '1', '00954093', '942027390', 18, 'mlmedina@unsm.edu.pe', '', 1, '2022-09-02', '2024-06-21 13:13:03', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (231, 'OSCAR WILFREDO', 'MENDIETA TABOADA', '00954038', '$2a$07$asxx54ahjppf45sd87a5auUBnqdkvNcGTCTcze2ikE2OrHzNrjFJW', '1', '00954038', '942613314', 18, 'omendieta@unsm.edu.pe', '', 1, '2024-06-22', '2024-04-10 15:27:12', NULL, '2024-03-22 20:02:30', NULL);
INSERT INTO `usuario` VALUES (232, 'ANITA RUTH', 'MENDIOLA CESPEDES', '01109405', '$2a$07$asxx54ahjppf45sd87a5auDGIc0aNerJUF8n04m0vGevi.FdKnEpu', '1', '01109405', '949784903', 18, 'amendiola@unsm.edu.pe', '', 1, '2022-08-23', '2024-09-05 16:34:30', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (233, 'JHIN DEMETRIO', 'MORENO AGUILAR', '43236240', '$2a$07$asxx54ahjppf45sd87a5auYc9c.oVm/jP1vGJ/NOFfB4/L2MC1W/i', '1', '43236240', '982811236', 18, 'tfpereap@unsm.edu.pe', '', 1, '2022-07-28', '2024-08-25 15:55:51', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (234, 'VICTOR HUGO', 'MUÑOZ DELGADO', '00953899', '$2a$07$asxx54ahjppf45sd87a5auidQ9ri2QYeNKJ64GOQcFb53BfxyYaD.', '1', '00953899', '937582898', 18, 'vhmunoz@unsm.edu.pe', '', 1, '2024-11-05', '2024-09-08 18:24:02', NULL, '2024-08-05 10:46:01', NULL);
INSERT INTO `usuario` VALUES (235, 'JOSE ELÍAS', 'MURGA MONTOYA', '01159092', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01159092', '979984758', 18, 'jemurga@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (236, 'YOLANDA', 'NAVARRO BARRERA', '01074866', '$2a$07$asxx54ahjppf45sd87a5auhI/id2q/pTkjlJDjDTU99lY4V5FAbuO', '1', '01074866', '942926486', 18, 'cdelcastillo@unsm.edu.pe', '', 1, '2022-09-22', '2024-08-10 14:29:28', NULL, '2024-01-31 11:07:09', NULL);
INSERT INTO `usuario` VALUES (237, 'RONALD', 'NAVARRO MACEDO', '01131206', '$2a$07$asxx54ahjppf45sd87a5auhC7mMFQGldaRuaU5poVI360pUysq9Qy', '1', '01131206', '964274889', 18, 'rnavarro@unsm.edu.pe', 'Jr. Guepi N° 548 Morales', 1, '2022-05-16', '2024-09-05 12:04:58', NULL, '2024-01-23 12:23:42', NULL);
INSERT INTO `usuario` VALUES (238, 'NORA', 'NIETO PENADILLO', '01147688', '$2a$07$asxx54ahjppf45sd87a5auzjLD0966wCtDZuRrNndd6hnH//TtQBK', '1', '01147688', '927988521', 18, 'dnespinozad@unsm.edu.pe', '', 1, '2022-08-11', '2024-07-23 16:22:54', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (239, 'ABNER FELIX', 'OBREGON LUJERIO', '01134902', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01134902', '965013777', 18, 'afobregon@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (240, 'KARINA MILAGROS', 'ORDOÑEZ RUIZ', '41807923', '$2a$07$asxx54ahjppf45sd87a5auEw.qUl251Mi.3oBZG7Rr5ws0CnXGHm6', '1', '41807923', '935259128', 18, 'kmordonesr@unsm.edu.pe', '', 1, '2022-07-27', '2024-04-11 11:01:09', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (241, 'LUIS ALBERTO', 'ORDOÑEZ SANCHEZ', '00844670', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '00844670', '942857565', 18, 'laordonez@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (242, 'JAVIER', 'ORMEÑO LUNA', '01131857', '$2a$07$asxx54ahjppf45sd87a5auHxlSDh3awfvXCnSzpFfosMOeVedRB5S', '1', '01131857', '957962563', 18, 'javierol@unsm.edu.pe', '', 1, '2022-08-27', '2024-07-06 12:58:10', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (243, 'MANUEL ', 'PADILLA GUZMAN', '00828442', '$2a$07$asxx54ahjppf45sd87a5auNejg70GHfN8QQENuT4WzBUtU.AS1qXK', '1', '00828442', '948140054', 18, 'mpadilla@unsm.edu.pe', '', 1, '2023-05-07', '2023-11-16 21:55:50', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (244, 'CRISTINA', 'PALOMINO AGUIRRE', '01109446', '$2a$07$asxx54ahjppf45sd87a5auQ4T/Vj.h8MvHom7J/j7JZpAhktcW98y', '1', '01109446', '942957584', 18, 'cpalomino@unsm.edu.pe', '', 1, '2022-06-23', '2023-12-18 17:36:44', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (245, 'GABRIELA DEL PILAR', 'PALOMINO ALVARADO', '00953069', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '00953069', '977210254', 18, 'gppalomino@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (246, 'LUIS', 'PAREDES AGUILAR', '01158952', '$2a$07$asxx54ahjppf45sd87a5auupoBAz6hdQ80MhPT6H/msfDtHHRt7KO', '1', '01158952', '971356673', 18, 'fmtorres@unsm.edu.pe', '', 1, '2022-05-24', '2024-07-24 13:33:41', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (247, 'JEINER LELIZ', 'PAREDES GONZALES', '42571219', '$2a$07$asxx54ahjppf45sd87a5auAxopLLsp98tWH.FVRNXJ7Ysj9VC7Huu', '1', '42571219', '947883331', 18, 'jlparedes@unsm.edu.pe', 'Jr francisco izquierdo rios 643', 1, '2022-05-23', '2024-04-11 14:47:55', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (248, 'GUILLERMO', 'PARILLO MANCILLA', '01162588', '$2a$07$asxx54ahjppf45sd87a5aumJsZg1X0nylvGP.C4XVSqG4.gPqSw2W', '1', '01162588', '959656442', 18, 'gparillo@unsm.edu.pe', '', 1, '2022-07-11', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (249, 'PABLO WALTHER', 'PAUCAR LOZANO', '01111277', '$2a$07$asxx54ahjppf45sd87a5auzyCgagP5SKkNfJ5qA.rtMstXEW7NKRi', '1', '01111277', '942671467', 18, 'ppaucar@unsm.edu.pe', '', 1, '2022-11-22', '2024-04-11 14:58:19', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (250, 'ERNESTO', 'PEÑA ROBALINO', '25469090', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '25469090', '932322981', 18, 'eperobalino@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (251, 'JORGE LUIS', 'PELAEZ RIVERA', '00951968', '$2a$07$asxx54ahjppf45sd87a5aufU08zqRpf1AZO.27LMz1GdllKvOGNSC', '1', '00951968', '942686127', 18, 'jlpelaez@unsm.edu.pe', '', 1, '2024-04-09', '2024-03-04 22:25:48', NULL, '2024-01-09 12:28:10', NULL);
INSERT INTO `usuario` VALUES (252, 'TERESA FLOR', 'PEREA PAREDES', '01120390', '$2a$07$asxx54ahjppf45sd87a5auNpI6K6hEnhLrU5Gb.wx75Zu3xMlXs3K', '1', '01120390', '942623279', 18, 'josmorales@unsm.edu.pe', '', 1, '2022-10-18', '2024-07-02 23:42:23', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (253, 'MANUEL ISAAC', 'PEREZ KUGA', '01078188', '$2a$07$asxx54ahjppf45sd87a5auKhIjC8XSueio1s0KDXkEzaFtH/ecj26', '1', '01078188', '958018108', 18, 'miperez@unsm.edu.pe', '', 1, '2023-05-06', '2024-08-20 18:44:50', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (254, 'CARMEN', 'PEREZ TELLO', '01124635', '$2a$07$asxx54ahjppf45sd87a5au41jEF2k6PSiIrEjsk5bpEo8.5i7GiP2', '1', '01124635', '959882845', 18, 'cperez@unsm.edu.pe', '', 1, '2022-07-06', '2024-08-18 17:01:29', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (255, 'PEDRO ELIAS', 'PEREZ VARGAS', '05280566', '$2a$07$asxx54ahjppf45sd87a5auFAT9iMsHy2ifHDmnvx3r2RIPYnrGB9O', '1', '05280566', '970314589', 18, 'peperez@unsm.edu.pe', '', 1, '2022-05-15', '2024-07-05 10:23:11', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (256, 'EDILBERTO', 'PEZO CARMELO', '05403402', '$2a$07$asxx54ahjppf45sd87a5auWzPzHjQjELJaNsULSIr7VAuXUGXdSui', '1', '05403402', '951551749', 18, 'epezoc@unsm.edu.pe', '', 1, '2024-06-20', '2024-09-09 17:19:10', NULL, '2024-03-20 09:37:02', NULL);
INSERT INTO `usuario` VALUES (257, 'MARIO', 'PEZO GONZALES', '01063640', '$2a$07$asxx54ahjppf45sd87a5auJUpBmbFJuzb/hvrhWPcVxCR/fyMRIx2', '1', '01063640', '972559772', 18, 'mpezo@unsm.edu.pe', '', 1, '2022-10-08', '2024-04-11 15:29:02', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (258, 'ALDINGER', 'PEZO PINEDO', '01160601', '$2a$07$asxx54ahjppf45sd87a5auQ5iTLo4rrl3IHuKOCgpflHQ7XBvzrIe', '1', '01160601', '942055051', 18, 'apezop@unsm.edu.pe', '', 1, '2022-07-29', '2024-08-14 10:27:06', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (259, 'ANIBAL', 'PINCHI VASQUEZ', '01120842', '$2a$07$asxx54ahjppf45sd87a5aubPrBOJmhoVUranQUtttpBkKCxyrEoo6', '1', '01120842', '942620802', 18, 'pinvas1960@unsm.edu.pe', '', 1, '2022-05-10', '2024-06-04 16:15:44', NULL, '2024-06-04 16:08:25', NULL);
INSERT INTO `usuario` VALUES (260, 'EDUARDO', 'PINCHI VASQUEZ', '01111111', '$2a$07$asxx54ahjppf45sd87a5aus7uxTXfcY/SoXQp/yEilx6RdmNNh1KW', '1', '01111111', '942693405', 18, 'epinchiv@unsm.edu.pe', '', 1, '2022-10-11', '2024-04-11 15:46:52', NULL, '2024-01-25 11:44:12', NULL);
INSERT INTO `usuario` VALUES (261, 'OSCAR ANTONIO', 'PINEDA MORALES', '01071105', '$2a$07$asxx54ahjppf45sd87a5auxMRrv1u5Plt3QW3nV8ie5J69SoCfZV.', '1', '01071105', '942621157', 18, 'oapineda@unsm.edu.pe', '', 1, '2022-09-20', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (262, 'JUAN JOSÉ', 'PINEDO CANTA', '01152072', '$2a$07$asxx54ahjppf45sd87a5auZhbITc8MoW1v4R5wHaMEoBK.PjbvKSe', '1', '01152072', '942832217', 18, 'jjpinedo@unsm.edu.pe', '', 1, '2023-02-24', '2024-08-16 09:28:23', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (263, 'RUBEN ADRIAN', 'PISCONTE BARAHONA', '07374857', '$2a$07$asxx54ahjppf45sd87a5auwPMJwzQJXDG.GwNqp4rb8NoUbpIZble', '1', '07374857', '990054730', 18, 'rapisconte@unsm.edu.pe', '', 1, '2022-06-23', '2024-03-18 12:08:12', NULL, '2024-03-18 07:44:16', NULL);
INSERT INTO `usuario` VALUES (264, 'JOSE DEL CARMEN', 'PIZARRO BALDERA', '00868981', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '00868981', '942690294', 18, 'jcpizarro@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (265, 'VICTOR ANDRES', 'PRETELL PAREDES', '01117644', '$2a$07$asxx54ahjppf45sd87a5auxGeM6k/lRJRojqJuTPmY588l7Dmz206', '1', '01117644', '942485648', 18, 'vapretell@unsm.edu.pe', '', 1, '2023-12-18', '2024-08-17 11:18:31', NULL, '2023-09-18 09:12:40', NULL);
INSERT INTO `usuario` VALUES (266, 'CESAR DANIEL', 'QUESQUEN LOPEZ', '16789565', '$2a$07$asxx54ahjppf45sd87a5auqzKnR8Y/aOkOudPfDHuEBnIDR.MMoMG', '1', '16789565', '937447419', 18, 'cdquesquenl@unsm.edu.pe', '', 1, '2022-06-28', '2024-08-12 08:17:40', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (267, 'JOSE ABSALON', 'QUEVEDO BUSTAMANTE', '01062412', '$2a$07$asxx54ahjppf45sd87a5auGLcjjZr18xSlpWYgo2EkDYZD3Fa8tX6', '1', '01062412', '942615333', 18, 'jaquevedo@unsm.edu.pe', '', 1, '2022-08-03', '2024-06-12 13:41:16', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (268, 'GLORIA FRANCISCA', 'QUIJANDRIA OLIVA', '01159407', '$2a$07$asxx54ahjppf45sd87a5au03WFg3CQTun/Z5RXwqytDseBj.e33Le', '1', '01159407', '987958696', 18, 'gfquijandria@unsm.edu.pe', '', 1, '2022-05-18', '2023-11-20 08:20:16', NULL, '2023-11-20 08:18:58', NULL);
INSERT INTO `usuario` VALUES (269, 'ALFREDO', 'QUINTEROS GARCIA', '01070452', '$2a$07$asxx54ahjppf45sd87a5auj1rQo7r3avIuKnYahc3SlkAigVHAcpm', '1', '01070452', '975501709', 18, 'alquinteros@unsm.edu.pe', '', 1, '2022-07-12', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (270, 'ANIBAL', 'QUINTEROS GARCIA', '01130958', '$2a$07$asxx54ahjppf45sd87a5auLdgCJ7PFCL/0eydbmWXYl/R0DvoJrsm', '1', '01130958', '941966333', 18, 'aquinteros@unsm.edu.pe', '', 1, '2022-06-17', '2024-08-09 07:28:32', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (271, 'NELSON MILCIADES', 'QUIÑONES VASQUEZ', '01073274', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01073274', '962595371', 18, 'nmquinonez@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (272, 'JOSE LUIS', 'RAMIREZ DEL AGUILA', '17818655', '$2a$07$asxx54ahjppf45sd87a5auKr8/gNYLBqk73.2wkAx9f7AVG7u0aEO', '1', '17818655', '942826852', 18, 'jlramirez@unsm.edu.pe', '', 1, '2023-02-24', '2024-04-11 17:01:12', NULL, '2023-11-23 10:44:53', NULL);
INSERT INTO `usuario` VALUES (273, 'HORACIO', 'RAMIREZ GARCIA', '01124879', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01124879', '942821438', 18, 'hramirez@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (274, 'MANUEL', 'RAMIREZ NAVARRO', '01069139', '$2a$07$asxx54ahjppf45sd87a5auQzra43/B6TckGa8ns122HXBbrSF95gm', '1', '01069139', '942980261', 18, 'mramirez@unsm.edu.pe', '', 1, '2022-09-27', '2024-09-03 12:55:34', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (275, 'WILLIAMS', 'RAMIREZ NAVARRO', '01062523', '$2a$07$asxx54ahjppf45sd87a5aunQirYwigAhuftzD/ICkm3gplktnkiP.', '1', '01062523', '995393847', 18, 'wramirezn@unsm.edu.pe', '', 1, '2024-12-03', '2024-09-03 09:28:28', NULL, '2024-09-03 09:28:13', NULL);
INSERT INTO `usuario` VALUES (276, 'WILDORO', 'RAMIREZ RAMIREZ', '01066115', '$2a$07$asxx54ahjppf45sd87a5auh.VglkCCaHlbQelcs7EPaxxTSoFQv2G', '1', '01066115', '959858468', 18, 'wramirez@unsm.edu.pe', '', 1, '2023-03-22', '2024-06-21 14:52:38', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (277, 'IVAN GUSTAVO', 'REATEGUI ACEDO', '01130970', '$2a$07$asxx54ahjppf45sd87a5au0GsaGiCav1bQ876TP5Wcrj83t0Fiki.', '1', '01130970', '965065845', 18, 'ireategui@unsm.edu.pe', '', 1, '2023-01-17', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (278, 'GINA ISABEL', 'REATEGUI ALEGRIA', '01110081', '$2a$07$asxx54ahjppf45sd87a5auPXwhfqELMnM/eUCAXjVJEZXcKB3sXky', '1', '01110081', '948020899', 18, 'gireategui@unsm.edu.pe', '', 1, '2022-07-28', '2024-09-09 15:12:34', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (279, 'ALFONSO', 'REATEGUI CAHUAZA', '25492342', '$2a$07$asxx54ahjppf45sd87a5aueVY8q3RYUYKhNJWJ/Pbem6B.ZQMekqO', '1', '25492342', '991116173', 18, 'areategui@unsm.edu.pe', '', 1, '2022-05-05', '2023-11-20 23:05:31', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (280, 'NELLY', 'REATEGUI LOZANO', '01020275', '$2a$07$asxx54ahjppf45sd87a5au05dLL.wwSn6oQroyVDlLK4X/9e/2doK', '1', '01020275', '942680300', 18, 'nreategui@unsm.edu.pe', '', 1, '2022-07-21', '2024-07-08 06:06:32', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (281, 'MARTHA LIZ', 'REATEGUI REATEGUI', '10311467', '$2a$07$asxx54ahjppf45sd87a5auLwiKwq1dWDQBxf9LXaAUfb.etln3WBK', '1', '10311467', '942626842', 18, 'mlreategui@unsm.edu.pe', '', 1, '2022-05-07', '2024-06-05 18:30:07', NULL, '2023-08-23 10:43:10', NULL);
INSERT INTO `usuario` VALUES (282, 'MIGUEL ANGEL ', 'RENGIFO ARIAS', '08147264', '$2a$07$asxx54ahjppf45sd87a5au7n14yhyHzWzbM5tcjzjfKIzRrgTeOJW', '1', '08147264', '942937020', 18, 'miguel.angel.rengifo@unsm.edu.pe', '', 1, '2022-10-06', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (283, 'CARLOS', 'RENGIFO SAAVEDRA', '01065119', '$2a$07$asxx54ahjppf45sd87a5auq6z.tPy0Hh3sAM6kHOAxTGsjHDmTn6m', '1', '01065119', '942605045', 18, 'crengifo@unsm.edu.pe', '', 1, '2023-07-20', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (284, 'OLGA MARITZA', 'REQUEJO LA TORRE', '01163359', '$2a$07$asxx54ahjppf45sd87a5au..OhrWqdzPGWglNH72XPCcFcVa7iu6i', '1', '01163359', '962849157', 18, 'omrequejo@unsm.edu.pe', '', 1, '2022-07-12', '2024-04-04 12:08:29', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (285, 'JORGE ISAACS', 'RIOJA DÍAZ', '01116067', '$2a$07$asxx54ahjppf45sd87a5au6lIN.cexQrysdDsWCa6ROg581VWk/1.', '1', '01116067', '953166733', 18, 'jirioja@unsm.edu.pe', '', 1, '2022-07-09', '2024-07-08 08:51:32', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (286, 'CARLOS ARMANDO ', 'RIOS LOPEZ', '18179294', '$2a$07$asxx54ahjppf45sd87a5aurrMO19mv/62NTR1BZoxIvca7d.nMOsm', '1', '18179294', '994687959', 18, 'carios@unsm.edu.pe', '', 1, '2024-01-11', '2023-10-11 11:18:40', NULL, '2023-10-11 10:01:52', NULL);
INSERT INTO `usuario` VALUES (287, 'LUIS ALBERTO', 'RIOS LOPEZ', '00951811', '$2a$07$asxx54ahjppf45sd87a5auXkjt//VzzGVvk3PHEiGNntNOUdjuCIa', '1', '00951811', '951008335', 18, 'lrios@unsm.edu.pe', '', 1, '2023-06-01', '2024-08-27 21:57:32', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (288, 'ROSA', 'RIOS LOPEZ DE HERRERA', '00951885', '$2a$07$asxx54ahjppf45sd87a5auijBgv2OXzmwchSAhYOt7AGEhR9ymxnq', '1', '00951885', '980990576', 18, 'rriosl@unsm.edu.pe', '', 1, '2022-09-22', '2024-08-18 18:05:15', NULL, '2023-11-14 07:49:25', NULL);
INSERT INTO `usuario` VALUES (289, 'LEOPOLDO', 'RIOS PANDURO', '01146500', '$2a$07$asxx54ahjppf45sd87a5auxJxgqKWZzoEESN7lnylMTlwSoFkVKWO', '1', '01146500', '951079397', 18, 'lriosp@unsm.edu.pe', 'Morales', 1, '2022-06-26', '2024-07-02 09:59:17', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (290, 'JUAN SEGUNDO', 'RIOS PEREZ', '01075777', '$2a$07$asxx54ahjppf45sd87a5auQbQwiVWOJH5IGqU7pWoY9U7bEqw34f.', '1', '01075777', '965046503', 18, 'jsrios@unsm.edu.pe', '', 1, '2023-11-02', '2024-08-07 08:44:58', NULL, '2023-08-02 09:17:16', NULL);
INSERT INTO `usuario` VALUES (291, 'ORLANDO', 'RIOS RAMIREZ', '01122663', '$2a$07$asxx54ahjppf45sd87a5auafZfgPOEcGgbwBL/5L7HJG7tJXKBThq', '1', '01122663', '979472859', 18, 'orios@unsm.edu.pe', '', 1, '2023-05-27', '2024-08-21 13:06:54', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (292, 'BUENAVENTURA', 'RIOS RIOS', '08754876', '$2a$07$asxx54ahjppf45sd87a5au07H2mnoDkfrz0wT3NxwLYHbp4oqkciO', '1', '08754876', '942819724', 18, 'brios@unsm.edu.pe', '', 1, '2023-07-27', '2024-04-10 11:14:49', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (293, 'ROLANDO', 'RIOS RIOS', '10622284', '$2a$07$asxx54ahjppf45sd87a5auJpM0rwLDbV92AWlT0q2ACIKsxsFuMn6', '1', '10622284', '942933435', 18, 'hjmeran@unsm.edu.pe', '', 1, '2022-06-16', '2024-08-17 10:22:05', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (294, 'WINSTON FRANZ', 'RIOS RUIZ', '01120961', '$2a$07$asxx54ahjppf45sd87a5au7lw/lp0hBa3YO/sb0Stdadvi6.hrx1.', '1', '01120961', '978955820', 18, 'wrios@unsm.edu.pe', '', 1, '2023-07-24', '2024-03-25 12:29:38', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (295, 'RAIDITH', 'RIVA RUIZ', '08222370', '$2a$07$asxx54ahjppf45sd87a5auIkpCc4f7Ma840wE2/aPwJN5KdoPaViy', '1', '08222370', '942856423', 18, 'rriva@unsm.edu.pe', '', 1, '2022-10-07', '2024-09-02 09:48:54', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (296, 'SILVERIO', 'RODRIGUEZ DE LA MATTA', '01066259', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01066259', '973354089', 18, 'srodriguez@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (297, 'YONI MENI', 'RODRIGUEZ ESPEJO', '18179075', '$2a$07$asxx54ahjppf45sd87a5auQJh0pOxWfCg0K0eUn/I701cDZaL1/zu', '1', '18179075', '951347147', 18, 'ymrodriguez@unsm.edu.pe', '', 1, '2024-06-06', '2024-03-14 15:23:24', NULL, '2024-03-06 07:23:29', NULL);
INSERT INTO `usuario` VALUES (298, 'JORGE HUMBERTO', 'RODRIGUEZ GOMEZ', '01127157', '$2a$07$asxx54ahjppf45sd87a5au8FFKE.LiiWtDgAZlF/F79omsywhasru', '1', '01127157', '951538615', 18, 'jhrodriguez@unsm.edu.pe', '', 1, '2022-05-14', '2024-07-17 13:54:17', NULL, '2024-07-10 13:32:07', NULL);
INSERT INTO `usuario` VALUES (299, 'CAROLA VELIA', 'RODRIGUEZ GONZALEZ', '18842832', '$2a$07$asxx54ahjppf45sd87a5auuMa46AOeXIFnPLYlxWKh07AD78cQjRu', '1', '18842832', '947920973', 18, 'cvrodriguez@unsm.edu.pe', '', 1, '2023-02-23', '2024-03-30 13:58:23', NULL, '2023-08-01 11:39:51', NULL);
INSERT INTO `usuario` VALUES (300, 'CARLOS', 'RODRIGUEZ GRANDEZ', '10473351', '$2a$07$asxx54ahjppf45sd87a5auIk5G7PH7pCf0hc5emPEDNWJkkeCzYj2', '1', '10473351', '965987692', 18, 'crodriguez@unsm.edu.pe', '...', 1, '2022-06-29', '2024-02-01 16:08:25', NULL, '2023-08-25 13:58:43', NULL);
INSERT INTO `usuario` VALUES (301, 'SEGUNDO', 'RODRIGUEZ MENDOZA', '01148240', '$2a$07$asxx54ahjppf45sd87a5auqfG4qYLAvKA8B8UiD.eBTEm5WMmpkAi', '1', '01148240', '942404459', 18, 'ssrodriguez@unsm.edu.pe', '', 1, '2022-06-29', '2023-11-28 15:21:12', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (302, 'LUIS EDUARDO', 'RODRIGUEZ PEREZ', '31652355', '$2a$07$asxx54ahjppf45sd87a5auCu.0bQTZf7F7ySxF1tCZW5IwY.YlydG', '1', '31652355', '937579935', 18, 'lerodriguez@unsm.edu.pe', '', 1, '2023-11-23', '2024-08-27 20:31:44', NULL, '2023-08-23 07:54:57', NULL);
INSERT INTO `usuario` VALUES (303, 'JESUS ', 'RODRIGUEZ SANCHEZ', '18169444', '$2a$07$asxx54ahjppf45sd87a5aut8Zg/lQqZep1YZ2DN0w5WCU1y3AG.u6', '1', '18169444', '999228676', 18, 'jrodriguez@unsm.edu.pe', '', 1, '2024-10-05', '2024-08-13 12:20:58', NULL, '2024-07-05 14:20:44', NULL);
INSERT INTO `usuario` VALUES (304, 'JOSE CARLOS', 'ROJAS GARCIA', '43459908', '$2a$07$asxx54ahjppf45sd87a5auWWxlOm6525tdyGdKhD0soeqNz6VRDQO', '1', '43459908', '947641442', 18, 'jogarcia@unsm.edu.pe', '', 1, '2022-08-02', '2024-03-15 09:03:02', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (305, 'OSCAR', 'ROJAS SANCHEZ', '16790276', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '16790276', '942044114', 18, 'orsanchez@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (306, 'JUAN CARLOS', 'ROJAS VASQUEZ', '01131400', '$2a$07$asxx54ahjppf45sd87a5aubfIpr3tBGBFoEYLlqNUBcJgsOP11zyK', '1', '01131400', '(042) 34-1286', 18, 'jcrojasv@unsm.edu.pe', '', 1, '2022-10-04', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (307, 'ALFONSO', 'ROJAS BARDALEZ', '00832316', '$2a$07$asxx54ahjppf45sd87a5auxKr40Kr9zeB8al2Qn.XVHOvpn681Zo.', '1', '00832316', '942957540', 18, 'arojas@unsm.edu.pe', '', 1, '2022-06-10', '2024-08-17 11:00:27', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (308, 'ROBERTO EDGARDO', 'ROQUE ALCARRAZ', '01156792', '$2a$07$asxx54ahjppf45sd87a5auX.7cUVW9/KKiFg0LFYOEOgLf5jn3pjK', '1', '01156792', '966632522', 18, 'reroque@unsm.edu.pe', '', 1, '2023-07-17', '2024-03-01 15:30:35', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (309, 'ANDY HIRVYN', 'RUCOBA REATEGUI', '40922161', '$2a$07$asxx54ahjppf45sd87a5aulQV5UvRduOWBq4X5AeAqLHqzKqe7ntu', '1', '40922161', '942931530', 18, 'ahrucoba@unsm.edu.pe', '', 1, '2022-07-01', '2024-07-20 10:43:36', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (310, 'ASTRIHT', 'RUIZ RIOS', '01223099', '$2a$07$asxx54ahjppf45sd87a5au2kIbl4pTOvUXuUdaWp8O4s2C7A2LmEu', '1', '01223099', '950414010', 18, 'aruiz@unsm.edu.pe', '', 1, '2022-07-16', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (311, 'FERNANDO', 'RUIZ SAAVEDRA', '01114891', '$2a$07$asxx54ahjppf45sd87a5auDDwBcvlgvYAPSSHPkrhgOEjzTN/RVuy', '1', '01114891', '975614607', 18, 'feruiz@unsm.edu.pe', '', 1, '2022-05-14', '2024-08-11 09:27:53', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (312, 'JUANA PAOLA', 'RUIZ SALVA', '46446495', '$2a$07$asxx54ahjppf45sd87a5aunf4W1PNFBhHV50EXfDWgHyhsL1JW4ty', '1', '46446495', '953524761', 18, 'jteran@unsm.edu.pe', '', 1, '2022-06-12', '2024-08-27 08:48:07', NULL, '2024-08-07 09:06:30', NULL);
INSERT INTO `usuario` VALUES (313, 'MARIA EMILIA', 'RUIZ SANCHEZ', '01158149', '$2a$07$asxx54ahjppf45sd87a5auWfshAkABtP5Bv.uONv07jD5Ag4/CLX6', '1', '01158149', '979978539', 18, 'meruiz@unsm.edu.pe', '', 1, '2022-08-13', '2024-08-21 13:33:08', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (314, 'RUBEN', 'RUIZ VALLES', '00818283', '$2a$07$asxx54ahjppf45sd87a5auvxHdCdI.1PCbMQceVBr.RlBJ7Z1Kzhq', '1', '00818283', '964852945', 18, 'rruiz@unsm.edu.pe', 'pedro tejada 268 - Moyobamba', 1, '2022-09-15', '2024-06-26 08:44:04', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (315, 'SARITA GUADALUPE', 'SAAVEDRA GRANDEZ', '00092213', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '00092213', '945897310', 18, 'mgarciap@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (316, 'FAUSTO', 'SAAVEDRA HOYOS', '06259745', '$2a$07$asxx54ahjppf45sd87a5auCCxXxBFdvAaXUN9QiugLoXwzYnzLvXu', '1', '06259745', '962204621', 18, 'fsaavedra@unsm.edu.pe', '', 1, '2022-09-13', '2023-11-17 06:53:09', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (317, 'GIL', 'SAAVEDRA RAMIREZ', '01066292', '$2a$07$asxx54ahjppf45sd87a5aunhnpKxhldaSgEVxUSj0x3SWgZP9xXd2', '1', '01066292', '963607218', 18, 'gsaavedra@unsm.edu.pe', '', 1, '2022-09-06', '2023-11-22 21:28:09', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (318, 'AUSVER', 'SAAVEDRA VELA', '00901728', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '00901728', '981686675', 18, 'asaavedra@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (319, 'LEOCADIA', 'SALAS PILLACA', '01109837', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01109837', '951588610', 18, 'lsalas@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (320, 'JUAN JOSE', 'SALAZAR DIAZ', '01069977', '$2a$07$asxx54ahjppf45sd87a5au8O9.aoJHxj2LmgldFuvoBNRjFu.6dxu', '1', '01069977', '942621331', 18, 'jjsalazar@unsm.edu.pe', '', 1, '2022-05-17', '2024-08-19 20:25:49', NULL, '2024-08-19 13:14:08', NULL);
INSERT INTO `usuario` VALUES (321, 'CARMELA ELISA', 'SALVADOR ROSADO', '17851477', '$2a$07$asxx54ahjppf45sd87a5aubjINxPle2Kt.vThZBqvIQo9pagPR8MW', '1', '17851477', '939171858', 18, 'cesalvador@unsm.edu.pe', '', 1, '2022-05-18', '2024-07-03 10:26:28', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (322, 'ROSSANA ROCIO', 'SALVATIERRA JURO', '09896061', '$2a$07$asxx54ahjppf45sd87a5auBdO2FcJ1sCog6H6XWhOmkjqZjJPbYeS', '1', '09896061', '942910543', 18, 'rrsalvatierra@unsm.edu.pe', 'Jr. Santo Toribio Nº 1250 - Rioja', 1, '2022-06-28', '2024-04-05 12:35:47', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (323, 'VÍCTOR EDUARDO', 'SAMAMÉ ZATTA', '01146907', '$2a$07$asxx54ahjppf45sd87a5auUFhe5s58UbpGOeUkGXTX3zBdfwx9tdS', '1', '01146907', '942403758', 18, 'vesamame@unsm.edu.pe', '', 1, '2022-07-18', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (324, 'HUGO', 'SANCHEZ CARDENAS', '00913434', '$2a$07$asxx54ahjppf45sd87a5auX7pXTnjYe0FVOGN99L2j6KQNs2gxUDq', '1', '00913434', '929424247', 18, 'hsanchez@unsm.edu.pe', '', 1, '2024-01-24', '2024-05-28 16:20:07', NULL, '2023-10-24 08:35:59', NULL);
INSERT INTO `usuario` VALUES (325, 'ROBERTO ESTEBAN', 'SANCHEZ COLINA ', '07403947', '$2a$07$asxx54ahjppf45sd87a5auFuRiyeuTj9uC6Av4BOMVHW5dw3asJMi', '1', '07403947', '942968440', 18, 'rsanchez@unsm.edu.pe', '', 1, '2023-05-20', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (326, 'MEYBOL ALICIA', 'SANCHEZ FLORES', '06291634', '$2a$07$asxx54ahjppf45sd87a5auBvnvK8f5yiLMyfFk2D5h4gGd8h40Obi', '1', '06291634', '975288661', 18, 'masanchezf@unsm.edu.pe', '', 1, '2024-02-09', '2024-02-19 13:13:25', NULL, '2023-11-09 09:48:29', NULL);
INSERT INTO `usuario` VALUES (327, 'VICTOR HUGO', 'SANCHEZ MERCADO', '26676942', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '26676942', '970065469', 18, 'vhsanchez@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (328, 'JORGE', 'SANCHEZ RIOS', '01072058', '$2a$07$asxx54ahjppf45sd87a5auSaCREIDFa8vsy6OScjzIU17BocaQDaC', '1', '01072058', '966638652', 18, 'jsanchezr@unsm.edu.pe', '', 1, '2023-04-03', '2023-12-07 09:02:17', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (329, 'NÉSTOR RAÚL', 'SANDOVAL SALAZAR', '16463569', '$2a$07$asxx54ahjppf45sd87a5au3RW/C2ud3lvM7OAU8s6golXgQGs36Cu', '1', '16463569', '948310521', 18, 'nrsandoval@unsm.edu.pe', '', 1, '2022-05-18', '2023-11-02 06:24:46', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (330, 'ANA NOEMI', 'SANDOVAL VERGARA', '43011735', '$2a$07$asxx54ahjppf45sd87a5aulR6UNJwwQsQfZXHLdoA7Iy3dhbg2ajy', '1', '43011735', '968991646', 18, 'vdcoral@unsm.edu.pe', '', 1, '2022-05-18', '2024-08-21 15:10:31', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (331, 'JOHN CLARK', 'SANTA MARIA PINEDO', '41720526', '$2a$07$asxx54ahjppf45sd87a5au4AhweuASH/3qkRhZc4XnawHR3Q6GnQS', '1', '41720526', '949836862', 18, 'jsantamaria@unsm.edu.pe', '', 1, '2022-08-10', '2024-05-22 23:27:30', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (332, 'WILSON ERNESTO', 'SANTANDER RUIZ', '01147911', '$2a$07$asxx54ahjppf45sd87a5auLaETpvSOykILD.LlDtQlYh2.I.uLIZO', '1', '01147911', '945499416', 18, 'wesantander@unsm.edu.pe', '', 1, '2024-01-17', '2023-10-19 08:38:31', NULL, '2023-10-17 16:12:11', NULL);
INSERT INTO `usuario` VALUES (333, 'ROBERTO', 'SEGURA  RUPAY', '32763912', '$2a$07$asxx54ahjppf45sd87a5aurClkbjLHCG5pDdgtKruWBPeNoTiKrzi', '1', '32763912', '957405368', 18, 'rsegura@unsm.edu.pe', '', 1, '2022-06-18', '2024-07-12 03:53:09', NULL, '2023-11-08 08:35:18', NULL);
INSERT INTO `usuario` VALUES (334, 'TOMÁS', 'SEIJAS ROJAS', '01073419', '$2a$07$asxx54ahjppf45sd87a5au91S6SZb2HE3vN7SffLdXZAtAjnkeE6m', '1', '01073419', '965942386', 18, 'tomrojas@unsm.edu.pe', '', 1, '2022-06-30', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (335, 'JOSE ROBERTO', 'SIADEN VALDIVIESO', '41461216', '$2a$07$asxx54ahjppf45sd87a5aupVVrJST3/xIRxUdhWGYA2ZgAQ1eW1fG', '1', '41461216', '988618969', 18, 'jrsaiden@unsm.edu.pe', '', 1, '2022-07-01', '2024-09-11 23:59:19', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (336, 'GRETHEL', 'SILVA HUAMANTUMBA', '44433888', '$2a$07$asxx54ahjppf45sd87a5auoHs5jkT3UL9Vzp3s9S0Vggu/ZHJ2A7a', '1', '44433888', '988936468', 18, 'lrios@unsm.edu.pe', '', 1, '2023-09-27', '2024-09-04 18:59:35', NULL, '2023-06-27 13:06:56', NULL);
INSERT INTO `usuario` VALUES (337, 'VANESSA', 'SOLIS FLORES', '10691893', '$2a$07$asxx54ahjppf45sd87a5auP0vlTPOnkqujf/6Bv0kZw44J80BgTIG', '1', '10691893', '975502363', 18, 'vsolis@unsm.edu.pe', '', 1, '2023-03-12', '2023-08-17 14:55:41', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (338, 'SERBANDO', 'SOPLOPUCO QUIROGA', '16475624', '$2a$07$asxx54ahjppf45sd87a5auOzh3CnYcftozzV7v.7VBSIta2ci2oJa', '1', '16475624', '942622319', 18, 'ssoplopuco@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (339, 'CLIFOR DANIEL', 'SOSA DE LA CRUZ', '07217837', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '07217837', '942661509', 18, 'cdsosa@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (340, 'SANTOS ALBERTO', 'SOTERO MONTERO', '01121087', '$2a$07$asxx54ahjppf45sd87a5auy6cmIqHpcweurNiUOhesQs9BWzCmhEq', '1', '01121087', '994563427', 18, 'sasotero@unsm.edu.pe', '', 1, '2022-10-08', '2024-09-03 16:07:19', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (341, 'RÉNIGER', 'SOUSA FERNÁNDEZ', '01109068', '$2a$07$asxx54ahjppf45sd87a5au53Wh1Uo/HxiKyC1WNGAaEgCRE4I4AVy', '1', '01109068', '956921830', 18, 'rsousa@unsm.edu.pe', '', 1, '2024-02-22', '2024-06-20 06:48:40', NULL, '2023-11-22 12:56:48', NULL);
INSERT INTO `usuario` VALUES (342, 'CARMINA', 'TANG DEL CASTILLO', '44067048', '$2a$07$asxx54ahjppf45sd87a5aukRSC2ZpNamQVjAcPdwGrV7jrwTCrvTq', '1', '44067048', '945290075', 18, 'ctang@unsm.edu.pe', '', 1, '2022-09-16', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (343, 'ARQUIMEDES', 'TELLO DIAZ', '01109466', '$2a$07$asxx54ahjppf45sd87a5auR0b2MwaWQ/d9CGzDQd5cvKAlN6AIEhy', '1', '01109466', '920010522', 18, 'atello@unsm.edu.pe', '', 1, '2022-07-22', '2024-08-01 11:01:35', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (344, 'ENRIQUE', 'TERLEIRA GARCIA', '01069220', '$2a$07$asxx54ahjppf45sd87a5auxYrmU3J6Uafv5CCMm9jgKlJqTG2ElUa', '1', '01069220', '942144580', 18, 'eterleira@unsm.edu.pe', '', 1, '2022-07-01', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (345, 'JULIO CÉSAR', 'TERÁN PIÑA', '41506542', '$2a$07$asxx54ahjppf45sd87a5au0LxD9x2rKg3mzFZ7x.gVr39L/X0y/ky', '1', '41506542', '958557246', 18, '', '', 1, '2023-07-03', '2024-02-28 14:01:49', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (346, 'ELIAS', 'TORRES FLORES', '05360645', '$2a$07$asxx54ahjppf45sd87a5auBLnKPkH3EJHOkMfvwyudNZW17XkWjPa', '1', '05360645', '942024970', 18, 'etorres@unsm.edu.pe', '', 1, '2022-08-05', '2024-02-09 17:22:58', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (347, 'YNES', 'TORRES FLORES', '01148660', '$2a$07$asxx54ahjppf45sd87a5auAgN6oeXdwJiJYL2.MFVfVjpB5BeAPpu', '1', '01148660', '942661468', 18, 'jfgutierrezl@unsm.edu.pe', '', 1, '2022-08-03', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (348, 'FLOR DE MARÍA', 'TORRES GÁLVEZ', '27988492', '$2a$07$asxx54ahjppf45sd87a5aub3s4FqI7CflSESte6yDqM65kAs4Hese', '1', '27988492', '951678402', 18, 'fmtorres@unsm.edu.pe', 'Jr.Atumpampa 320', 1, '2023-04-27', '2024-09-03 12:35:51', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (349, 'AMERICO', 'TORRES GONZALES', '18159421', '$2a$07$asxx54ahjppf45sd87a5au/DVfudPB/XoUFSbYZPh4BXYabrB29q2', '1', '18159421', '956940019', 18, 'atorres@unsm.edu.pe', '', 1, '2022-11-02', '2023-09-05 16:42:30', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (350, 'WILFREDO', 'TORRES REATEGUI', '40593385', '$2a$07$asxx54ahjppf45sd87a5auPj83y6VucbxBR61HDWsb3KCeH/q1Qqy', '1', '40593385', '942828484', 18, 'ynavarrob@unsm.edu.pe', '', 1, '2022-05-07', '2024-07-23 09:08:53', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (351, 'CARLOS', 'TRIGOSO GARCIA', '01130899', '$2a$07$asxx54ahjppf45sd87a5auXIB05B2mS6kMg7H3sPMltNNTzSAI6Qy', '1', '01130899', '999574600', 18, 'carlogarcia@unsm.edu.pe', '', 1, '2022-07-07', '2024-06-11 11:39:35', NULL, '2023-08-17 00:25:52', NULL);
INSERT INTO `usuario` VALUES (352, 'CICERON', 'TUANAMA REATEGUI', '18226094', '$2a$07$asxx54ahjppf45sd87a5aubwVTyI55zTQseeAzNdmTYgspJ6jna0S', '1', '18226094', '942464179', 18, 'ctuanamar@unsm.edu.pe', '', 1, '2022-08-25', '2024-07-24 13:10:53', NULL, '2023-10-24 13:53:07', NULL);
INSERT INTO `usuario` VALUES (353, 'ANGEL', 'TUESTA CASIQUE', '00839617', '$2a$07$asxx54ahjppf45sd87a5au04k2k8B6vnkPrWCA3L/Bq457yKQ76Ky', '1', '00839617', '942318456', 18, 'atuesta@unsm.edu.pe', '', 1, '2022-05-24', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (354, 'JORGE ARMANDO', 'TUESTA PINEDO', '01131853', '$2a$07$asxx54ahjppf45sd87a5au6aJolgOWzHuHmlf2knJZ5FhkoK0N1yC', '1', '01131853', '942624303', 18, 'jatuestap@unsm.edu.pe', '', 1, '2022-05-24', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (355, 'HUMBERTO', 'VALDERA RODRIGUEZ', '01063502', '$2a$07$asxx54ahjppf45sd87a5auMDHPbqMd/wN.jBRb92Yy16ZrD.ZqqJS', '1', '01063502', '987178243', 18, 'hvaldera@unsm.edu.pe', '', 1, '2022-07-18', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (356, 'JENNY DEL CARMEN', 'VALERA GALVEZ', '18037477', '$2a$07$asxx54ahjppf45sd87a5au8X2VkoevjguwoLAgBP1VChVUGFZRjGq', '1', '18037477', '993294854', 18, 'jcvalera@unsm.edu.pe', '', 1, '2022-06-29', '2024-06-13 10:00:17', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (357, 'ORFELINA', 'VALERA VEGA', '01075817', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01075817', '942698450', 18, 'ovalera@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (358, 'VICTOR MANUEL', 'VALLEJOS MONJA', '42183659', '$2a$07$asxx54ahjppf45sd87a5aupipKKtyCYjgXgUK8gxTqRtYSP9RT/0y', '1', '42183659', '953647471', 18, 'vmvm900@unsm.edu.pe', '', 1, '2022-07-26', '2024-07-14 18:17:38', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (359, 'MIGUEL ANGEL', 'VALLES CORAL', '40810431', '$2a$07$asxx54ahjppf45sd87a5auqd1OLgWRuC63tfHgevhpufta3A1I6dy', '1', '40810431', '942023414', 18, 'mavalles@unsm.edu.pe', '', 1, '2023-03-19', '2024-08-23 13:14:49', NULL, '2023-09-19 10:08:26', NULL);
INSERT INTO `usuario` VALUES (360, 'JORGE DAMIAN', 'VALVERDE IPARRAGUIRRE', '18141505', '$2a$07$asxx54ahjppf45sd87a5auLCTInolsJRr9vKiiR/QKxMi6y4AJgZW', '1', '18141505', '950976821', 18, 'jdvalver@unsm.edu.pe', '', 1, '2022-08-10', '2023-07-26 10:25:58', NULL, '2024-03-25 10:10:44', NULL);
INSERT INTO `usuario` VALUES (361, 'MIRTHA FELICITA', 'VALVERDE VERA', '17877428', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '17877428', '942689952', 18, 'mfvalverde@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (362, 'LLOY AMERICO', 'VARGAS DAZZA', '00924752', '$2a$07$asxx54ahjppf45sd87a5au8LtYS5njqLasf/KLj90Z7/12Y/ee8Pa', '1', '00924752', '941958052', 18, 'llavargasd@unsm.edu.pe', '', 1, '2022-05-17', '2024-06-12 08:44:20', NULL, '2024-06-12 08:39:19', NULL);
INSERT INTO `usuario` VALUES (363, 'PEDRO', 'VARGAS RODRIGUEZ', '01069122', '$2a$07$asxx54ahjppf45sd87a5auP39vD3mQmRWYOt4YoyYtymOi3rhGzDG', '1', '01069122', '942624541', 18, 'pvargas@unsm.edu.pe', '', 1, '2023-05-15', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (364, 'LUIS MANUEL', 'VARGAS VASQUEZ', '17814649', '$2a$07$asxx54ahjppf45sd87a5aujnK5LH03E04ySbqcBswdqCnNa08onky', '1', '17814649', '942988312', 18, 'lmvargas@unsm.edu.pe', '', 1, '2022-06-16', NULL, NULL, '2023-06-23 07:46:59', NULL);
INSERT INTO `usuario` VALUES (365, 'WASHINGTON TERCERO', 'VASQUEZ CACHAY', '00835477', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '00835477', '942685500', 18, 'wtvasquez@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (366, 'PATRICIA', 'VASQUEZ PINCHI', '01062654', '$2a$07$asxx54ahjppf45sd87a5auBSkW6tTUnxPqvEhqVvJ163jpVPUpd.S', '1', '01062654', '942698237', 18, 'pvasquez@unsm.edu.pe', '', 1, '2022-07-28', '2024-04-11 20:59:58', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (367, 'GUILLERMO', 'VASQUEZ RAMIREZ', '01065187', '$2a$07$asxx54ahjppf45sd87a5auEAbCRJLxw2ptAdc6g3kx5WZPcDZUnku', '1', '01065187', '943156128', 18, 'gvasquez@unsm.edu.pe', '', 1, '2022-12-29', '2024-02-16 12:15:16', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (368, 'MILTON SEGUNDO', 'VASQUEZ RUIZ', '01124481', '$2a$07$asxx54ahjppf45sd87a5auuF3AY/t8m6sE/hIoTSpY7q7YNJ7J0mS', '1', '01124481', '936733741', 18, 'msvasquez@unsm.edu.pe', '', 1, '2023-06-28', '2024-03-30 12:10:42', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (369, 'MAURO OLMEDO', 'VASQUEZ SANCHEZ', '01066263', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01066263', '961104643', 18, 'movasquez@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (370, 'FERNANDO', 'VASQUEZ VASQUEZ', '01149487', '$2a$07$asxx54ahjppf45sd87a5auM6tV09JZ00kogvEYwwXY0JyDI2rrKce', '1', '01149487', '942473140', 18, 'fvasquez@unsm.edu.pe', '', 1, '2023-09-07', '2024-09-09 13:05:48', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (371, 'RAMIRO', 'VASQUEZ VASQUEZ', '01073878', '$2a$07$asxx54ahjppf45sd87a5au8ZNK.LcIj4p5oLICwbAe9AJxPGpraFa', '1', '01073878', '942909666', 18, 'rvasquez@unsm.edu.pe', '', 1, '2023-04-06', '2024-01-31 14:39:43', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (372, 'CARLOS DANIEL', 'VECCO GIOVE', '07879978', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '07879978', '942058671', 18, 'tcotrina@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (373, 'MANUELA AURORA', 'VEGA CELIS', '01077158', '$2a$07$asxx54ahjppf45sd87a5auI62jcTXWj8QM5z43fCbC0AvTOiSC3Ba', '1', '01077158', '942884041', 18, 'mavega@unsm.edu.pe', '', 1, '2023-10-21', '2024-06-20 21:40:46', NULL, '2023-07-21 10:25:03', NULL);
INSERT INTO `usuario` VALUES (374, 'SEIDY JANICE', 'VELA REATEGUI', '40235016', '$2a$07$asxx54ahjppf45sd87a5auwRrgDmhP5uBrBB3tq4QSP4G8jHug6.6', '1', '40235016', '942604337', 18, 'seidyreategui@unsm.edu.pe', '', 1, '2024-06-20', '2024-03-21 16:18:20', NULL, '2024-03-20 16:10:37', NULL);
INSERT INTO `usuario` VALUES (375, 'TERESA', 'VELA VASQUEZ', '01068632', '$2a$07$asxx54ahjppf45sd87a5auy49qIDFdRye96J59H9s/neT0ktZ35MK', '1', '01068632', '950882169', 18, 'tvela@unsm.edu.pe', '', 1, '2024-02-27', '2024-08-22 10:04:47', NULL, '2023-11-27 10:23:39', NULL);
INSERT INTO `usuario` VALUES (376, 'LAURA EPIFANIA', 'VERA AZURIN', '01044529', '$2a$07$asxx54ahjppf45sd87a5auF9X8pjhGfJE9r2JcwPaexhPn98/A.JW', '1', '01044529', '942824445', 18, 'levera@unsm.edu.pe', '', 1, '2023-07-26', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (377, 'PIERRE', 'VIDAURRE ROJAS', '01146597', '$2a$07$asxx54ahjppf45sd87a5auBMZmegiEJZiRGtQZbIorw1OYGq0fHra', '1', '01146597', '965605695', 18, 'pvidaurre@unsm.edu.pe', '', 1, '2024-03-29', '2024-01-30 11:09:54', NULL, '2023-12-29 09:58:43', NULL);
INSERT INTO `usuario` VALUES (378, 'DAHPNE', 'VIENA OLIVEIRA', '05275781', '$2a$07$asxx54ahjppf45sd87a5auPNKQuqULvSDoxq9h3IvwVDvij/VZQBS', '1', '05275781', '944445324', 18, 'dviena@unsm.edu.pe', '', 1, '2023-01-20', '2024-02-22 09:23:50', NULL, '2023-11-27 10:33:45', NULL);
INSERT INTO `usuario` VALUES (379, 'SALVADOR LENININ', 'VIGIL VÁSQUEZ', '01156640', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01156640', '942953577', 18, 'slvigilv@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (380, 'MÁXIMO ALCIBIADES', 'VILCA COTRINA', '16448408', '$2a$07$asxx54ahjppf45sd87a5au2VFNl4LqgSvGvqaGCPweOsS46yOaLxW', '1', '16448408', '942980420', 18, 'mavilca@unsm.edu.pe', '', 1, '2023-06-24', '2024-03-14 20:47:37', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (381, 'MERCEDES', 'VILCHEZ ORDOÑEZ', '01144044', '$2a$07$asxx54ahjppf45sd87a5au4HYxVSNDmTYkZJdZ6B6cNQ5ssDjfIwS', '1', '01144044', '942018427', 18, 'mvilchez@unsm.edu.pe', '', 1, '2022-07-06', '2024-08-02 11:02:07', NULL, '2023-11-14 08:35:43', NULL);
INSERT INTO `usuario` VALUES (382, 'EDWARD', 'VILLACORTA PANDURO', '01114854', '$2a$07$asxx54ahjppf45sd87a5auYgvJ1UUIXSzvubWKZdQmE.8//wrSuAm', '1', '01114854', '942959532', 18, 'evillacorta@unsm.edu.pe', '', 1, '2023-09-22', '2024-08-23 08:31:59', NULL, '2023-06-22 10:30:33', NULL);
INSERT INTO `usuario` VALUES (383, 'LUCY AMELIA', 'VILLENA CAMPOS DE SAAVEDRA', '01128470', '$2a$07$asxx54ahjppf45sd87a5auSckXT0gMPmot5TDYLB5t.1DcXz33DwG', '1', '01128470', '945702009', 18, 'lavillena@unsm.edu.pe', '', 1, '2023-03-15', '2024-06-30 21:38:08', NULL, '2024-06-03 10:26:43', NULL);
INSERT INTO `usuario` VALUES (384, 'MARCIANO ALCIVIADES', 'VIVAS CAMPUSANO', '01163420', '$2a$07$asxx54ahjppf45sd87a5au9lJJ5mQy9wfE/4Irc.G.q5fakaXXzpi', '1', '01163420', '984580659', 18, 'mavivas@unsm.edu.pe', '', 1, '2022-08-03', '2023-11-12 11:40:48', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (385, 'BLANCA', 'YALTA FLORES', '01149770', '$2a$07$asxx54ahjppf45sd87a5auwQtQe3M/yVdSFaxZJVuBU4oS2u0coPi', '1', '01149770', '991774183', 18, 'byaltaf@unsm.edu.pe', 'Urb.Baltazar Martinez de Compagñon E-10', 1, '2022-06-15', '2024-08-15 11:18:37', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (386, 'TELMO', 'ZAVALETA ROSAS', '17890437', '$2a$07$asxx54ahjppf45sd87a5auWeGm3C1cclm/a3zCowQyQ0z.Eg3Yybu', '1', '17890437', '973922140', 18, 'tzavaleta@unsm.edu.pe', '', 1, '2024-05-15', '2024-02-15 11:01:21', NULL, '2024-02-15 10:28:52', NULL);
INSERT INTO `usuario` VALUES (387, 'JUAN', 'ZEGARRA CHUNG', '08191302', '$2a$07$asxx54ahjppf45sd87a5au2q5uKA6CEYtUX640us6phz5jLfDIhEC', '1', '08191302', '942614386', 18, 'jzegarra@unsm.edu.pe', '', 1, '2023-09-02', '2024-07-04 10:33:56', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (388, 'PEDRO', 'ZUBIATE MONTALVAN', '01045375', '$2a$07$asxx54ahjppf45sd87a5auj4X31merMpWCxX0rJFPow2vZWgGT/Sm', '1', '01045375', '942427922', 18, 'pzubiate@unsm.edu.pe', '', 1, '2022-08-11', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (389, 'PEDRO MIGUEL', 'AGUIRRE IMAN', '09883620', '$2a$07$asxx54ahjppf45sd87a5auUcDUhLBIlFciWx/cHJReXOtJOcYxQwW', '1', '09883620', '942-623215', 18, '', '', 1, '2022-11-23', '2024-09-10 10:49:07', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (390, 'MARCO POLO', 'ALAVA SAURIN', '01160151', '$2a$07$asxx54ahjppf45sd87a5auTGtiJJnBR784lvh39b98cqfOCP1DybK', '1', '01160151', '942677564', 18, '', '', 1, '2022-05-16', '2024-07-20 11:34:06', NULL, '2023-10-05 10:27:31', NULL);
INSERT INTO `usuario` VALUES (391, 'SYVIL MARGARITA', 'ALVAN PAREDES DE MELGAR', '01129123', '$2a$07$asxx54ahjppf45sd87a5auyZ/hv9NzOKaXgG.raAzkNVNE3u4xo/q', '1', '01129123', '525195', 18, 'syvilalvan@unsm.edu.pe', '', 1, '2022-09-06', '2024-08-15 15:37:37', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (392, 'MARIA MARLENI', 'AMARINGO SHAPIAMA', '01112203', '$2a$07$asxx54ahjppf45sd87a5auVq5ggq163rqPRuFz/P3DUXcAGIFw/Le', '1', '01112203', '', 18, '', '', 1, '2022-09-17', '2024-03-11 19:23:28', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (393, 'JOSE ALEX', 'ARAUJO ROMERO', '01080989', '$2a$07$asxx54ahjppf45sd87a5auPY.0C.FVHnC3iWoZj9DyeaObnmk91TK', '1', '01080989', '942-752554', 18, 'jaraujor@unsm.edu.pe', '', 1, '2022-05-23', '2024-09-12 08:06:07', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (394, 'JUAN CARLOS', 'ARCE ROJAS', '00954481', '$2a$07$asxx54ahjppf45sd87a5aua0zdJZBB6uwnQNUGq.YCsBkx.z1bmgy', '1', '00954481', '521208', 18, 'jcarcer@unsm.edu.pe', '', 1, '2022-07-07', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (395, 'TANIA RAQUEL', 'ARCE VASQUEZ', '41608887', '$2a$07$asxx54ahjppf45sd87a5auI.MKehehxsqOWuEiGdBQk3DmqUPCqve', '1', '41608887', '534521', 18, 'trarce@unsm.edu.pe', '', 1, '2022-09-20', '2024-08-21 10:40:54', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (396, 'ARMANDO', 'AREVALO CULQUI', '01089003', '$2a$07$asxx54ahjppf45sd87a5aufvkAwyRPH0U3Q.iAO/LGZeTtUBw5ByW', '1', '01089003', '0', 18, 'aarevaloc@unsm.edu.pe', '', 1, '2022-06-30', '2024-09-05 07:26:02', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (397, 'ESTEFITA', 'AREVALO DEL AGUILA', '01090728', '$2a$07$asxx54ahjppf45sd87a5auQbdX627E6JSJmXhy1DynMHVDvQGxg3K', '1', '01090728', '(042)52-4896', 18, 'fita@unsm.edu.pe', '', 1, '2022-09-17', '2024-08-09 12:48:11', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (398, 'ERASMO', 'AREVALO GARCIA', '01070396', '$2a$07$asxx54ahjppf45sd87a5auBXDddrIGDIs8/z4RxAqzEp7V8SkITJa', '1', '01070396', '531965', 18, '', '', 1, '2022-05-25', '2024-08-22 08:32:37', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (399, 'BETTY', 'AREVALO NAVARRO', '01117578', '$2a$07$asxx54ahjppf45sd87a5auPXE72T89.aXkUV5stlP0PwCekML.dIW', '1', '01117578', '942-632555', 18, 'barevalo@unsm.edu.pe', '', 1, '2022-05-10', '2024-09-12 09:18:48', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (400, 'PERCY', 'AREVALO PEZO', '01140109', '$2a$07$asxx54ahjppf45sd87a5auIKVqYfTpheIuEVO8.ydraNDXSm.MaPu', '1', '01140109', '(042) 53-1965', 18, '', '', 1, '2022-05-25', '2024-09-04 11:38:29', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (401, 'REGULO', 'BALDEON TRUJILLO', '06560082', '$2a$07$asxx54ahjppf45sd87a5autsOVJtDdtD9MxLbHJL0KEvPaekIi7PS', '1', '06560082', '942742244', 18, 'btrujillor@unsm.edu.pe', '', 1, '2022-08-06', '2024-03-12 08:47:06', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (402, 'ALEJANDRO CESAR', 'BULEJE GOMEZ', '01067235', '$2a$07$asxx54ahjppf45sd87a5au.wBlzWoZEhtct1bAGVzXkmHz1ybd8wm', '1', '01067235', '942684053', 18, 'abujele@unsm.edu.pe', '', 1, '2022-09-03', '2024-07-03 12:00:14', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (403, 'ASUSENA', 'CALONGOS RIOS VDA. DE PEREZ', '01074682', '$2a$07$asxx54ahjppf45sd87a5auivN750w1CLsTB/Q.0MJJEYRQWLqdxq.', '1', '01074682', '(042) 52-3879', 18, '', '', 1, '2022-10-01', '2024-01-03 11:50:11', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (404, 'GENARO', 'CARDENAS ALEGRIA', '01158954', '$2a$07$asxx54ahjppf45sd87a5au76CxrYpORV/jMc0sUPyccVoRlkgu4Qq', '1', '01158954', '942938804', 18, 'gcardenas@unsm.edu.pe', '', 1, '2022-07-29', '2024-08-13 16:11:50', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (405, 'NILS ADIEL', 'CARRASCO CORDOVA', '41791375', '$2a$07$asxx54ahjppf45sd87a5auPyxND2VQgmaPSxSQRMCDC5Opwjynj.u', '1', '41791375', '0000', 18, 'nacarrasco@unsm.edu.pe', '00000', 1, '2022-09-17', '2024-09-09 10:20:25', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (406, 'KEVIN', 'CASIQUE BARDALEZ', '05631532', '$2a$07$asxx54ahjppf45sd87a5auGrJ5woDUnqXwjDNFk5W12XudjJVocFC', '1', '05631532', '', 18, '', '', 1, '2022-07-25', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (407, 'MANUEL IGNACIO', 'CELIS TELLO', '01160635', '$2a$07$asxx54ahjppf45sd87a5au3C6dsVwY8pmTd2DJfnDveCf7m2dawb6', '1', '01160635', '(042)53-1939', 18, 'mcelis@unsm.edu.pe', '', 1, '2024-06-18', '2024-03-18 12:17:56', NULL, '2024-03-18 12:17:18', NULL);
INSERT INTO `usuario` VALUES (408, 'JOSE LUIS', 'CHAVARRI PEREZ', '41445772', '$2a$07$asxx54ahjppf45sd87a5auHDsamk7QWYe.BxOKrA4uLPCkvAxe.H6', '1', '41445772', '942468954', 18, 'jlchavarri@unsm.edu.pe', '', 1, '2022-09-14', '2024-09-02 17:47:00', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (409, 'PEDRO CELESTINO', 'CLEMENTE MONDALGO', '00953181', '$2a$07$asxx54ahjppf45sd87a5auiHHuXeZv5oD5RoPtyNmEZ3K/aWYJuO6', '1', '00953181', '942622865', 1, 'pclemente@unsm.edu.pe', '', 1, '2022-06-25', '2024-09-10 14:27:32', NULL, '2024-09-03 11:12:10', NULL);
INSERT INTO `usuario` VALUES (410, 'FLORENCIO', 'CONTRERAS CUBA', '01104888', '$2a$07$asxx54ahjppf45sd87a5auoWU0ogpHq3safqp8qhbBTH1zTtckP0i', '1', '01104888', '', 18, 'fcontreras@unsm.edu.pe', '', 1, '2023-04-03', '2023-09-25 14:42:45', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (411, 'PERCY JAVIER', 'CORAL GONZALES', '80436784', '$2a$07$asxx54ahjppf45sd87a5au8Auc6C2opOjQMl2YBWx6wUBh185b72W', '1', '80436784', '942-750080', 18, '', '', 1, '2022-09-01', '2024-09-05 12:34:52', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (412, 'RAFAEL', 'CORDOVA RUIZ', '01070528', '$2a$07$asxx54ahjppf45sd87a5aueddOZovGDFtKRdKehL.1e9vuQ.tdgV6', '1', '01070528', '*801287', 18, 'rcordovar@unsm.edu.pe', '', 1, '2022-05-23', '2024-07-01 13:09:06', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (413, 'FLORANGEL', 'CRISTANCHO LOZANO', '01118203', '$2a$07$asxx54ahjppf45sd87a5auAti/oSPgugd3G5hrq/ZWWb4QM54BHnm', '1', '01118203', '942699669', 18, 'florangelcristancho@unsm.edu.pe', '', 1, '2022-08-06', '2024-06-09 19:15:49', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (414, 'LUZ AMPARO', 'CUBAS HIDALGO', '00907896', '$2a$07$asxx54ahjppf45sd87a5aumKPqKQIDYdDCqccEmVqLPSlxqPDIAC2', '1', '00907896', '', 18, 'lacubash@unsm.edu.pe', '', 1, '2022-12-15', '2024-08-27 10:54:03', NULL, '2024-08-27 10:50:19', NULL);
INSERT INTO `usuario` VALUES (415, 'GILMAR', 'DAVILA TUESTA', '01069913', '$2a$07$asxx54ahjppf45sd87a5aumK7WB3eOw0czut87VAJsnudJIUDjvBq', '1', '01069913', '', 18, 'gdavila@unsm.edu.pe', '', 1, '2022-09-22', '2024-07-04 08:44:32', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (416, 'LENY', 'DE LA CRUZ FLORES', '01130879', '$2a$07$asxx54ahjppf45sd87a5auYeOLo2JcqJzW.0QpQovvvsfSaBvTJ3m', '1', '01130879', '', 18, 'lcruzf@unsm.edu.pe', '', 1, '2022-11-01', '2024-08-23 13:48:42', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (417, 'JUANA', 'DEL AGUILA CHUMBE DE HERRERA', '01142694', '$2a$07$asxx54ahjppf45sd87a5auLpOonbgs3XABq1QJZIlbHfrQOojFbTC', '1', '01142694', '942-997541', 18, 'juachumbe@unsm.edu.pe', '', 1, '2022-11-02', '2024-08-24 11:51:08', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (418, 'MELITA ', 'DEL AGUILA DE FLORES', '01091617', '$2a$07$asxx54ahjppf45sd87a5auQ2RQFTgbRgtPEKc91VT2j9VGC7Kt3u.', '1', '01091617', '528355', 18, 'meaguiflores@unsm.edu.pe', '', 1, '2022-09-07', '2023-09-27 20:09:59', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (419, 'MERCEDES', 'DEL AGUILA FERNANDEZ', '00037933', '$2a$07$asxx54ahjppf45sd87a5auYN4buky6TD7sTigbBX3nw9F6xy7ht92', '1', '00037933', '1234', 18, 'mfernandez@unsm.edu.pe', '', 1, '2022-09-23', '2024-05-24 09:18:43', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (420, 'TATIANA', 'DEL AGUILA REATEGUI', '01123515', '$2a$07$asxx54ahjppf45sd87a5aucvWOcqDC5GBm5wspJdyG/iN1IjlCGXu', '1', '01123515', '(042) 52-6831', 18, 'tdelaguila@unsm.edu.pe', '', 1, '2022-05-23', '2023-10-12 14:14:11', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (421, 'LILY', 'DELGADO RIOS', '01114637', '$2a$07$asxx54ahjppf45sd87a5aufPC2UjhNHsJmH6vSgybIGXf6tWnXZ/S', '1', '01114637', '', 18, 'lidelgado@unsm.edu.pe', '', 1, '2024-03-22', '2024-08-19 09:27:52', NULL, '2023-12-22 14:04:06', NULL);
INSERT INTO `usuario` VALUES (422, 'TORIBIA', 'DIAZ ANGULO', '01118969', '$2a$07$asxx54ahjppf45sd87a5aucs0640g5kgD9R5Udn99zdLs3c0E.yF6', '1', '01118969', '942677553', 18, 'tdiaza@unsm.edu.pe', '', 1, '2022-07-12', '2024-09-03 12:00:21', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (423, 'TOMAS', 'DIAZ FASABI', '01066113', '$2a$07$asxx54ahjppf45sd87a5auXlG1Ry6J5dViIY9huC1cdlv.cc7vLi.', '1', '01066113', '', 18, 'tdiaz@unsm.edu.pe', '', 1, '2022-07-01', '2024-08-29 15:45:17', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (424, 'MARIDITH', 'DIAZ PANDURO', '41742331', '$2a$07$asxx54ahjppf45sd87a5au2aVH7QCHMmupegsezhPl7TReD5M3fPe', '1', '41742331', '942-670048', 14, 'mdiaz@unsm.edu.pe', '', 1, '2022-05-07', '2024-07-30 11:39:14', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (425, 'MARILU', 'DIAZ TITO', '01121168', '$2a$07$asxx54ahjppf45sd87a5auzTJ8cMpBJdT7wEidjiGkfOQ5QZRRj/W', '1', '01121168', '0', 18, 'marilu@unsm.edu.pe', '0', 1, '2022-07-25', '2024-07-01 11:30:56', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (426, 'RICARDO', 'FASANANDO SHAPIAMA', '01063750', '$2a$07$asxx54ahjppf45sd87a5auFxRVncfWONNkPDBAnB1kdp8rMw/wnJq', '1', '01063750', '', 18, 'rfasanando@unsm.edu.pe', '', 1, '2022-05-23', '2024-06-27 19:13:23', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (427, 'ROSVER', 'FASANANDO SHAPIAMA', '01111883', '$2a$07$asxx54ahjppf45sd87a5au4tqSRfTxiD.9zdR4bxhNzK.ppZvgkr6', '1', '01111883', '', 18, 'rofasanando@unsm.edu.pe', '', 1, '2022-09-22', '2024-03-06 05:10:34', NULL, '2023-09-19 08:54:38', NULL);
INSERT INTO `usuario` VALUES (428, 'FERNANDO', 'FERNANDEZ PANDURO', '01088313', '$2a$07$asxx54ahjppf45sd87a5augVaKbLNyAJtBNAnTPgWXJPaIBV8ksqa', '1', '01088313', '954910648', 18, 'ffernandezp@unsm.edu.pe', '', 1, '2022-07-19', '2024-08-15 07:24:58', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (429, 'LUIS', 'FERNANDEZ TORRES', '01060861', '$2a$07$asxx54ahjppf45sd87a5auHagA2HKVAyquDiCbDs539DweG2I.8Hi', '1', '01060861', '942609828', 18, 'lfernandez@unsm.edu.pe', '', 1, '2022-09-23', '2024-09-10 16:58:09', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (430, 'DOLLY', 'FLORES DAVILA', '01112965', '$2a$07$asxx54ahjppf45sd87a5auie0.gUFw/Mf5Ca7RxJl5BeLEi0xbqpO', '1', '01112965', '', 18, 'dflores@unsm.edu.pe', '', 1, '2022-06-30', '2024-02-19 09:32:21', NULL, '2024-02-15 13:50:40', NULL);
INSERT INTO `usuario` VALUES (431, 'MARTHA', 'FLORES GARCIA', '01114924', '$2a$07$asxx54ahjppf45sd87a5au05892Qtk46WPp1iSndXSsd4ZMR8eyWi', '1', '01114924', '942-676938', 18, 'mfloresg@unsm.edu.pe', '', 1, '2022-10-13', '2024-08-09 07:27:26', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (432, 'MARTA ', 'FLORES GONZALES', '01119451', '$2a$07$asxx54ahjppf45sd87a5auXoUUX38KD60pTsH7ON8LCVN66KVUy4.', '1', '01119451', '942696534', 18, 'marflores@unsm.edu.pe', '', 1, '2022-09-15', '2023-10-11 13:28:27', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (433, 'JORGE', 'FLORES RAMIREZ', '01070527', '$2a$07$asxx54ahjppf45sd87a5auGPjSr85v3cMqRywgtc5MdScMxtu8CP6', '1', '01070527', '(042) 53-0129', 18, 'jfloresr@unsm.edu.pe', '', 1, '2022-09-20', '2024-07-20 10:38:34', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (434, 'RENIGER', 'FLORES REINA', '01091005', '$2a$07$asxx54ahjppf45sd87a5auuNt0X0pOhEbKIHwdHYqnlw5eAYAJEty', '1', '01091005', '528355', 18, 'reniger.flores@unsm.edu.pe', '', 1, '2022-05-09', '2024-07-17 13:24:19', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (435, 'CARMEN ROSA', 'FLORES ZAVALA', '01044511', '$2a$07$asxx54ahjppf45sd87a5ausOyqWysYPZv21QaMY0l4HfLV0hYJFgi', '1', '01044511', '942488273', 18, 'crflores@unsm.edu.pe', 'Jr. Libertad 604 - Rioja', 1, '2022-09-21', '2024-09-05 11:59:34', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (436, 'BACILIZA', 'GALVEZ FIGUEROA', '00912431', '$2a$07$asxx54ahjppf45sd87a5auhyF9f/VE1tmsW8BGpgi8j3RxPdA8JYO', '1', '00912431', '', 18, 'bacfigueroa@unsm.edu.pe', '', 1, '2022-08-16', '2024-09-03 11:38:20', NULL, '2024-02-21 11:45:57', NULL);
INSERT INTO `usuario` VALUES (437, 'JUAN', 'GARAY PEREZ', '01111224', '$2a$07$asxx54ahjppf45sd87a5auWMAhSmErlDzNRMoJE4FrqR65KRoJJrG', '1', '01111224', '(042) 52-1545', 18, 'juaperez@unsm.edu.pe', '', 1, '2022-09-03', '2024-02-23 15:12:30', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (438, 'HENNY EDITH', 'GARCIA LOPEZ', '01069884', '$2a$07$asxx54ahjppf45sd87a5auM8U8Vf3wQXIEeE33pspmLq2POut9cpu', '1', '01069884', '942692593', 18, 'hegarcial@unsm.edu.pe', '', 1, '2022-06-30', '2024-08-26 17:32:34', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (439, 'JUAN CARLOS', 'GARCIA RIOS', '00954829', '$2a$07$asxx54ahjppf45sd87a5auNH5W0B2uGU5Ei3DCuaFmEaOUOV6Hi6C', '1', '00954829', '', 14, 'jcgarciarios@unsm.edu.pe', '', 1, '2022-07-26', '2024-07-01 14:52:32', NULL, '2024-01-26 12:36:30', NULL);
INSERT INTO `usuario` VALUES (440, 'LUIS ARMANDO', 'GARCIA SAAVEDRA', '01111179', '$2a$07$asxx54ahjppf45sd87a5auR0/4w.YWeEnV9c0TEpIUGEKn8jp/nIG', '1', '01111179', '042526288', 18, 'lagarcias@unsm.edu.pe', '', 1, '2022-05-25', '2024-01-03 11:38:53', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (441, 'PERCY', 'GARCIA SANCHEZ', '01046667', '$2a$07$asxx54ahjppf45sd87a5aupLnhmgcdZJxIOvjCg/UTqP07Yqq/6Bq', '1', '01046667', '979892849', 18, 'pgarcias@unsm.edu.pe', 'Jr. Atahualpa N° 462 - RIOJA', 1, '2022-07-28', '2024-09-04 17:53:01', NULL, '2023-10-05 10:39:18', NULL);
INSERT INTO `usuario` VALUES (442, 'ERNESTO', 'GONZALES AMACIFUEN', '01105391', '$2a$07$asxx54ahjppf45sd87a5auzdlapee0XZnbeXBK3iMX3Cd9doWSwB2', '1', '01105391', '942866699', 18, 'egonzales@unsm.edu.pe', 'Jr. Abancay 588 Tarapoto', 1, '2022-06-23', '2024-09-07 10:03:06', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (443, 'ARTIDORO', 'GONZALES GONZALES', '01069979', '$2a$07$asxx54ahjppf45sd87a5aumHM60vd803GE.TTgMzp74JMcMdNUQV2', '1', '01069979', '529335', 18, 'artigonzales@unsm.edu.pe', '', 1, '2023-10-31', '2023-07-31 14:22:43', NULL, '2023-07-31 11:33:11', NULL);
INSERT INTO `usuario` VALUES (444, 'EDVIN', 'GONZALES RAMIREZ', '01070821', '$2a$07$asxx54ahjppf45sd87a5auwodgfzFohpnPGLaer7k3UX1pW.kZdmS', '1', '01070821', '', 18, 'edvingonzales@unsm.edu.pe', '', 1, '2022-05-10', '2024-09-06 10:17:22', NULL, '2024-03-15 10:32:07', NULL);
INSERT INTO `usuario` VALUES (445, 'MIGUEL ANGEL', 'GONZALES RENGIFO', '01091083', '$2a$07$asxx54ahjppf45sd87a5auoHfuIWgtI1XtNy6r9z4iGC8JuUBn85a', '1', '01091083', '', 18, 'miguelgonzales@unsm.edu.pe', '', 1, '2022-05-07', '2023-10-02 10:50:00', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (446, 'ANGELA BEATRIZ', 'GONZALES RIOS', '05365215', '$2a$07$asxx54ahjppf45sd87a5aufactkVZAX9GrrfcJz58Q/5r2uO8Iu52', '1', '05365215', '942652008', 18, 'abgonzalesr@unsm.edu.pe', '', 1, '2022-09-23', '2024-07-20 05:43:53', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (447, 'JORGE LUIS ', 'GRADOS CORDOVA', '01088678', '$2a$07$asxx54ahjppf45sd87a5au3bkZmBqfiLZg5uWCuR01K8kPlmQvRDC', '1', '01088678', '942656783', 18, 'jorgrados@unsm.edu.pe', '', 1, '2022-09-07', '2024-08-22 10:55:44', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (448, 'ALICIA MERCEDES', 'GRANDEZ DE LINAREZ', '01074122', '$2a$07$asxx54ahjppf45sd87a5auCZ9wPO9TtpiV3Yp.OzXsYDZo33crLf6', '1', '01074122', '523690', 18, 'bribra03@unsm.edu.pe', '', 1, '2022-05-18', '2023-12-04 09:48:54', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (449, 'LITA YSABEL', 'GRANDEZ PAREDES', '01149800', '$2a$07$asxx54ahjppf45sd87a5aupcrvKmEp3NQcDWR64WWsZe226BxujnW', '1', '01149800', '700221', 18, 'ligrandezp@unsm.edu.pe', '', 1, '2022-09-27', '2024-04-09 12:40:32', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (450, 'HERMES', 'GRANDEZ TUANAMA', '01158522', '$2a$07$asxx54ahjppf45sd87a5auyirbmK7co0q6W3aqfJJgxPfqw6DDCdm', '1', '01158522', '942809451', 18, 'hertuanama@unsm.edu.pe', '', 1, '2022-05-16', '2024-06-05 11:29:39', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (451, 'GILBERTO', 'GUERRERO SOTO', '01157092', '$2a$07$asxx54ahjppf45sd87a5au.xOYm1XAWZeeX0WlRFCewttMbOIDoE6', '1', '01157092', '942317912', 18, 'gilbertosoto@unsm.edu.pe', '', 1, '2022-05-07', '2024-09-09 08:25:16', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (452, 'PORFIRIO', 'GUERRERO SOTO', '01133557', '$2a$07$asxx54ahjppf45sd87a5augWtuGZkp4sd6I/wHw5Hsq43o5j5RPaa', '1', '01133557', '941843209', 18, 'porfiriosoto@unsm.edu.pe', '', 1, '2022-05-10', '2024-09-03 07:12:56', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (453, 'ERMA', 'HERRERA RENGIFO', '01060915', '$2a$07$asxx54ahjppf45sd87a5aubaZ9xjA/5eQihrupXT47PdmhD8aws96', '1', '01060915', '000000000', 18, 'eherrerar@unsm.edu.pe', '', 1, '2022-11-03', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (454, 'DORIS', 'HIDALGO FLORES', '01119115', '$2a$07$asxx54ahjppf45sd87a5auUuZNtZgs6UzxCsUPCgxLz.Ewg1xWdbG', '1', '01119115', '', 18, '', '', 1, '2023-04-03', '2024-06-21 10:24:22', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (455, 'JULIO CESAR', 'HUAÑAP GUZMAN', '01159438', '$2a$07$asxx54ahjppf45sd87a5au9BMD0b9ADfjUJ64Llt9IcB36kEoB/Ou', '1', '01159438', '942639233', 18, 'julguzman@unsm.edu.pe', '', 1, '2022-07-22', '2024-09-10 10:37:27', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (456, 'SONIA', 'JIMENEZ GOMEZ', '01104805', '$2a$07$asxx54ahjppf45sd87a5aurL0Pu1FbGGo0XDMAVWfrK4NgUbCtm1m', '1', '01104805', '532402', 18, 'soniagomez@unsm.edu.pe', '', 1, '2022-06-22', '2024-08-07 17:45:33', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (457, 'JOSE AUGUSTO', 'LI DE LA CRUZ', '01142308', '$2a$07$asxx54ahjppf45sd87a5au6CZgOHQVVvgwHTo06PKl3LWxhLS9WzG', '1', '01142308', '', 18, 'jalid@unsm.edu.pe', '', 1, '2022-10-04', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (458, 'LUIS GREGORIO', 'LOPEZ BALAREZO', '01126802', '$2a$07$asxx54ahjppf45sd87a5au8/wD2lMtblixhrNugxiwD5XH1jdmXzG', '1', '01126802', '#891168', 18, 'lubalarezo@unsm.edu.pe', '', 1, '2022-10-11', '2024-01-17 10:26:36', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (459, 'ADIEL ', 'LOPEZ PINEDO', '01090995', '$2a$07$asxx54ahjppf45sd87a5auoMnAD3SSZfkHnzVaosakuaz3hCE6k/O', '1', '01090995', '942-925083', 18, 'adielpinedo@unsm.edu.pe', '', 1, '2023-01-05', '2024-05-27 06:52:31', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (460, 'KETTY', 'LOPEZ RAMIREZ', '01121200', '$2a$07$asxx54ahjppf45sd87a5auBvuzx.2/H1CUUzyFDe46Y5tmdixg1Wm', '1', '01121200', '942970994', 18, 'klopez@unsm.edu.pe', '', 1, '2022-07-21', '2024-04-12 11:19:18', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (461, 'JORGE LUIS', 'LOPEZ RODRIGUEZ', '42051666', '$2a$07$asxx54ahjppf45sd87a5auiOEyCG0vTDqTwiPXFxqy7B6FJsLcm4W', '1', '42051666', '942623278', 18, 'jorlopez@unsm.edu.pe', '', 1, '2022-05-07', '2024-04-08 07:39:34', NULL, '2023-08-08 13:41:46', NULL);
INSERT INTO `usuario` VALUES (462, 'LUZ MARINA', 'LOPEZ RODRIGUEZ', '01126961', '$2a$07$asxx54ahjppf45sd87a5auZHp8izigGDMIELFqYrLtIqqWrhQxJKm', '1', '01126961', '423291', 18, 'lmlopez@unsm.edu.pe', '', 1, '2022-09-17', '2024-09-11 10:07:30', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (463, 'RINA', 'LOZANO CORDOVA', '42106184', '$2a$07$asxx54ahjppf45sd87a5audT53x8aR9wdMRmHk9P8s.0PKc9p5c/S', '1', '42106184', '942-958465', 18, 'rlozano@unsm.edu.pe', '', 1, '2022-09-14', '2024-07-17 10:03:53', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (464, 'EINSTEN JEAN', 'LOZANO FLORES', '40291779', '$2a$07$asxx54ahjppf45sd87a5auPMfRZxympFXGrts6OzyrwfJxfOOQezq', '1', '40291779', '#293802', 18, 'einslo@unsm.edu.pe', '', 1, '2022-10-21', '2024-07-24 09:52:41', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (465, 'HILDEBRANDO ', 'LOZANO GARCIA', '01092597', '$2a$07$asxx54ahjppf45sd87a5au6lvjO2bqHsMFAG2ITZVUGVvYgNnZUmi', '1', '01092597', '942-405729', 18, 'hildegarcia@unsm.edu.pe', '', 1, '2023-01-26', '2024-09-09 10:53:07', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (466, 'WALTER', 'LOZANO GARCIA', '01091291', '$2a$07$asxx54ahjppf45sd87a5auYLSJQ/nkWPWlyZn.O5R6VAp.As6gLha', '1', '01091291', '', 18, 'waltergarcia@unsm.edu.pe', '', 1, '2022-08-04', '2024-07-26 11:46:46', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (467, 'YDELSO', 'LOZANO GARCIA', '01092600', '$2a$07$asxx54ahjppf45sd87a5auwilw37UgjQ4qCNWoSOaYnSo6ZHXI0hy', '1', '01092600', '341598', 18, 'ydelsogarcia@unsm.edu.pe', '', 1, '2022-10-07', '2024-09-10 17:49:56', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (468, 'VICTORIA ', 'LUNA ROJAS', '00902283', '$2a$07$asxx54ahjppf45sd87a5au0WdbvhKDX62fWKYCEGEIrLpehI97Fgu', '1', '00902283', '523654', 18, 'vluna@unsm.edu.pe', '', 1, '2022-06-26', '2024-09-11 10:58:49', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (469, 'ROBERTO', 'MACEDO GONZALES', '01115377', '$2a$07$asxx54ahjppf45sd87a5au2uoEv5IamS.B7YByIDvpPmsbbZe/nRS', '1', '01115377', '(042) 9529510', 18, 'rmacedog@unsm.edu.pe', '', 1, '2022-08-09', '2024-05-29 16:07:00', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (470, 'ALLEN HANS', 'MACEDO PEREZ', '01073979', '$2a$07$asxx54ahjppf45sd87a5auu043fQBGHyN/YM6Wv59mOt9GGNe3zPC', '1', '01073979', '942-983248', 18, 'almape8@hotmail.com', '', 1, '2022-05-18', '2023-09-20 10:40:54', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (471, 'LUIS', 'MESTANZA NAVARRO', '01104905', '$2a$07$asxx54ahjppf45sd87a5augcM3DvsL9rw4u.ilv0In4LwmLtJkRMq', '1', '01104905', '942-606756', 18, 'lumentaza@unsm.edu.pe', '', 1, '2022-06-11', '2024-09-06 07:05:55', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (472, 'LUISA', 'MESTANZA TAPULLIMA', '01102405', '$2a$07$asxx54ahjppf45sd87a5au/unyum1ixsFpJ840lsnKDEM3zKApaj2', '1', '01102405', '503080', 18, 'luisatapullima@unsm.edu.pe', '', 1, '2023-11-15', '2023-08-15 14:19:11', NULL, '2023-08-15 14:18:48', NULL);
INSERT INTO `usuario` VALUES (473, 'JAIME', 'MONCADA MORI', '01127034', '$2a$07$asxx54ahjppf45sd87a5audLL4Ew/LiRvsQevTBWJq90DztaOzt1i', '1', '01127034', '526965', 18, 'jmoncadam@unsm.edu.pe', '', 1, '2022-05-15', '2024-04-08 07:17:20', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (474, 'MILCIADES', 'MONTES CHISTAMA', '01064402', '$2a$07$asxx54ahjppf45sd87a5auR6bQbzG46Qbc33guvSAjkeGvUxccZmG', '1', '01064402', '942612999', 18, 'milchistama@unsm.edu.pe', '', 1, '2022-09-14', '2024-02-06 12:06:39', NULL, '2023-07-26 08:48:06', NULL);
INSERT INTO `usuario` VALUES (475, 'JUANA', 'MORI VASQUEZ', '01115413', '$2a$07$asxx54ahjppf45sd87a5aubc.GPvQUq0MdbiVkB5bPGv10LrdlGqK', '1', '01115413', '42528933', 18, 'jmori@unsm.edu.pe', '', 1, '2022-10-08', '2024-07-15 17:32:12', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (476, 'EDGAR', 'MOZOMBITE SINARAHUA', '00896997', '$2a$07$asxx54ahjppf45sd87a5auizwXYmv4VwJqe.Gkr4N6AMx2XfnEin2', '1', '00896997', '', 18, 'edsinarahua@unsm.edu.pe', '', 1, '2022-07-18', '2024-03-12 19:39:58', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (477, 'WILMAR', 'MURRIETA VELA', '01112176', '$2a$07$asxx54ahjppf45sd87a5auuQabUdIg33yPk7ngI9RZygamnAOQFVG', '1', '01112176', '942961046', 18, 'wmurrieta@unsm.edu.pe', '', 1, '2022-09-07', '2024-02-28 16:42:21', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (478, 'JUDITH', 'NAVARRO CASIQUE', '40728690', '$2a$07$asxx54ahjppf45sd87a5auM/UNFnGP755pJ6LKqxUzT4VVxjMipiC', '1', '40728690', '', 18, '', '', 1, '2023-06-24', '2024-01-16 13:16:27', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (479, 'ROBERT', 'NAVARRO MORI', '01162968', '$2a$07$asxx54ahjppf45sd87a5augh35/.gUkFfALcOxE0ZcQCz/13EWB6.', '1', '01162968', '942-629312', 18, 'robmori@unsm.edu.pe', '', 1, '2023-07-11', '2024-07-09 10:55:00', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (480, 'LUIS ALBERTO', 'NAVARRO PANDURO', '01117773', '$2a$07$asxx54ahjppf45sd87a5auIPrFSyewZAMN4KBLLc62G1tqK73Bdya', '1', '01117773', '942-028552', 18, 'lanavarrop@unsm.edu.pe', '', 1, '2023-06-01', '2024-08-27 07:05:22', NULL, '2024-01-03 14:42:03', NULL);
INSERT INTO `usuario` VALUES (481, 'OTONIEL PERCY', 'NAVARRO PANDURO', '01101063', '$2a$07$asxx54ahjppf45sd87a5auJAxe7XBCFQBrWC9i1UBLbSiSEjv3vIi', '1', '01101063', '942411403', 18, 'otopanduro@unsm.edu.pe', '', 1, '2022-09-23', '2024-08-01 07:30:11', NULL, '2023-07-31 09:28:33', NULL);
INSERT INTO `usuario` VALUES (482, 'RODOLFO', 'NAVARRO PANDURO', '40382336', '$2a$07$asxx54ahjppf45sd87a5auHOlsW7keSTXP..b.RvO9r5BQN5R3SYe', '1', '40382336', '948616417', 18, 'rnavarropanduro@unsm.edu.pe', 'JR. BOLOGNESI 250', 1, '2022-07-12', '2024-09-05 12:12:28', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (483, 'DOLLY', 'NAVARRO PINEDO', '01116971', '$2a$07$asxx54ahjppf45sd87a5au6gEhv4cr7eX8vR.nPN6HxDLFdIg9L/C', '1', '01116971', '942-988133', 18, 'dnavarro@unsm.edu.pe', '', 1, '2022-05-18', '2024-06-25 12:18:31', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (484, 'GILMER', 'NAVARRO RAMIREZ', '01117994', '$2a$07$asxx54ahjppf45sd87a5auivRSEVzc65i2O.9rVpani3w5c6g65vu', '1', '01117994', '(042) 52-2641', 18, 'gnavarror@unsm.edu.pe', '', 1, '2022-08-03', '2024-08-23 13:49:52', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (485, 'ELY', 'NAVARRO TORRES', '01111736', '$2a$07$asxx54ahjppf45sd87a5auv/PgAs88m8KUmoUL9oD5r4J9WPMc402', '1', '01111736', '952579349', 18, 'elynatorres@unsm.edu.pe', '', 1, '2022-06-18', '2024-09-05 07:46:30', NULL, '2023-10-23 08:14:44', NULL);
INSERT INTO `usuario` VALUES (486, 'GIDITH', 'ORBE PINEDO', '01060703', '$2a$07$asxx54ahjppf45sd87a5au5/KvSItk05l0Ne1ZrXeyj33SUirFC8m', '1', '01060703', '', 18, 'gorbe@unsm.edu.pe', '', 1, '2022-10-04', '2024-07-01 10:00:01', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (487, 'MARTHA ELENA', 'ORBE SALAZAR', '01104968', '$2a$07$asxx54ahjppf45sd87a5au7qpUTZYOMsQ/EAC45jFCuc5GMBFgUR6', '1', '01104968', '942692498', 18, 'meorbes@unsm.edu.pe', '', 1, '2022-09-27', '2024-09-09 12:05:45', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (488, 'CARLOS', 'PAIMA MACEDO', '01114452', '$2a$07$asxx54ahjppf45sd87a5auMkLy87bfaMGZ5ptSBGSzPFXT7oUlLcm', '1', '01114452', '942-650133', 18, 'carmacedo@unsm.edu.pe', '', 1, '2022-12-02', '2024-08-27 20:16:07', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (489, 'WILSON', 'PAIMA SAAVEDRA', '01064139', '$2a$07$asxx54ahjppf45sd87a5auUjhaa3DCLwZTSWie.Y9M7KNA.2aXmom', '1', '01064139', '', 18, 'wilsaavedra@unsm.edu.pe', '', 1, '2022-09-20', '2024-09-11 20:56:40', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (490, 'ELMER', 'PANAIFO ESCOBEDO', '01126470', '$2a$07$asxx54ahjppf45sd87a5auA69tjUA.1IRjfWtmYG42U8RyfWvE1lG', '1', '01126470', '', 18, 'elescobedo@unsm.edu.pe', '', 1, '2022-07-19', '2024-08-13 16:16:21', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (491, 'DELMAN', 'PANDURO CARDENAS', '10535290', '$2a$07$asxx54ahjppf45sd87a5au.zYRY2bnnJDCnVITK4/uwWmyilwhPxS', '1', '10535290', '992-421596', 18, 'delcardenas@unsm.edu.pe', '', 1, '2023-03-02', '2024-07-11 10:06:22', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (492, 'JUAN', 'PAREDES TAFUR', '01123422', '$2a$07$asxx54ahjppf45sd87a5auE20anyW/OUFOmSzPW3ZfAtHX3eC5U2a', '1', '01123422', '529146', 18, 'juantafur@unsm.edu.pe', '', 1, '2022-07-25', '2024-06-13 11:22:04', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (493, 'GRETHEL VICTORIA', 'PASQUEL QUEVEDO', '01073440', '$2a$07$asxx54ahjppf45sd87a5auFj1IsG.DVpkqN5LUl2C0O0Na/mI1tNi', '1', '01073440', '942-903786', 18, 'gpasquel@unsm.edu.pe', '', 1, '2022-10-08', '2024-09-11 13:12:19', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (494, 'ELENA JUSTA', 'PERALTA RUIZ', '01114788', '$2a$07$asxx54ahjppf45sd87a5auf83VOM2dMhPA6OIGst5RuDBAtJXXxPy', '1', '01114788', '942693212', 14, 'eperalta@unsm.edu.pe', '', 1, '2022-07-26', '2024-07-04 10:27:43', NULL, '2024-01-26 12:35:48', NULL);
INSERT INTO `usuario` VALUES (495, 'ELOYNE', 'PEREZ REATEGUI', '01068877', '$2a$07$asxx54ahjppf45sd87a5augk9jrvzVTDGUAd5GZ00g7Y/VJ058DYq', '1', '01068877', '', 18, 'eperezr@unsm.edu.pe', '', 1, '2022-09-01', '2024-07-09 12:56:06', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (496, 'GILBERTO', 'PEZO FLORES', '01060603', '$2a$07$asxx54ahjppf45sd87a5auLVYzHn0KPU7K2NEDm6Klswsa2Kjpr/i', '1', '01060603', '943873985', 18, '', '', 1, '2023-02-07', '2024-03-27 14:05:14', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (497, 'EDILITA', 'PEZO GARCIA', '01134482', '$2a$07$asxx54ahjppf45sd87a5aumkmg0tmDbs6IY/q5HGNfbbsGdnGIWJ2', '1', '01134482', '521679', 18, 'epezog@unsm.edu.pe', '', 1, '2022-05-08', '2024-08-28 12:59:46', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (498, 'JOSE', 'PEZO GARCIA', '01091080', '$2a$07$asxx54ahjppf45sd87a5auACprnQDvMTe2A/OYFlpcrCWeDlCFaLO', '1', '01091080', '942659068', 18, 'josgarcia@unsm.edu.pe', '', 1, '2022-09-16', '2023-11-14 12:50:01', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (499, 'LEONIDAS', 'PEZO GRANDEZ', '01124667', '$2a$07$asxx54ahjppf45sd87a5auGbHI2cLCBcqyTs5tqx.u7z51FlYZxeu', '1', '01124667', '(042) 52-9496', 18, 'leograndez@unsm.edu.pe', '', 1, '2024-05-28', '2024-08-12 09:49:34', NULL, '2024-02-28 11:08:18', NULL);
INSERT INTO `usuario` VALUES (500, 'SEGUNDO FRANCISCO', 'PEZO RAMIREZ', '01069088', '$2a$07$asxx54ahjppf45sd87a5auHTXzV/7BCidyK/XS8P2iVGgv8aeD0..', '1', '01069088', '700190', 18, 'segpezo@unsm.edu.pe', '', 1, '2022-08-23', '2024-09-10 14:12:08', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (501, 'CLEMENTINA', 'PIï¿½A SANGAMA', '01119350', '$2a$07$asxx54ahjppf45sd87a5augTfrLu10YABCv0ImtyKghtiKmwycNqS', '1', '01119350', '', 18, 'clemsangama@unsm.edu.pe', '', 1, '2022-05-09', '2024-09-10 10:39:10', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (502, 'CESAR AUGUSTO', 'PINCHI GARCIA', '05371829', '$2a$07$asxx54ahjppf45sd87a5auYhLKXW9epjeKorH1gj2R/yxTLjpUg3C', '1', '05371829', '', 18, 'cegarcia@unsm.edu.pe', '', 1, '2022-05-14', '2024-09-04 09:31:49', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (503, 'LELIS DEL PILAR', 'PINCHI VERGARA', '40571093', '$2a$07$asxx54ahjppf45sd87a5auza.7p8tjC7eI.cxDPDiJuujhIgIr22S', '1', '40571093', '(042) 52-5433', 18, 'lpinchi@unsm.edu.pe', '', 1, '2022-06-22', '2024-07-08 15:21:17', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (504, 'MARITSA', 'PINEDO BARDALES', '01072184', '$2a$07$asxx54ahjppf45sd87a5auqAeUSy.NwPORSxgiWJvgLUFMjQ31y9G', '1', '01072184', '(042) 52-1438', 18, 'mpinedobardales@unsm.edu.pe', '', 1, '2022-11-18', '2024-08-15 11:45:47', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (505, 'WILLIAM', 'PINEDO GRANDEZ', '01101071', '$2a$07$asxx54ahjppf45sd87a5aua27EegYqsK/bG/vjWRG.O3TEyrwxdVy', '1', '01101071', '942-699839', 18, 'wipigran@unsm.edu.pe', '', 1, '2022-05-10', '2024-09-03 08:20:53', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (506, 'FERNANDO', 'PINEDO PINEDO', '01119543', '$2a$07$asxx54ahjppf45sd87a5aujsQYXboBbVAQbZ232wiWVCZlqUq7wvG', '1', '01119543', '', 18, 'ferpinedo@unsm.edu.pe', '', 1, '2022-09-22', '2024-07-04 08:33:28', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (507, 'RODOLFO', 'PINEDO PINEDO', '01112928', '$2a$07$asxx54ahjppf45sd87a5auUnu20Gf7Xwk/Q7KFkzq4eMuvK6sgmPS', '1', '01112928', '', 18, 'rpinedo@unsm.edu.pe', '', 1, '2022-05-14', '2024-09-12 10:47:10', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (508, 'AIDA', 'PINEDO REATEGUI', '00903594', '$2a$07$asxx54ahjppf45sd87a5auFMO7KEgs7KqR4TbxTw1TB2gwUcjPS0K', '1', '00903594', '543088', 18, 'aireategui@unsm.edu.pe', '', 1, '2024-02-15', '2024-08-14 14:52:26', NULL, '2023-11-15 10:48:18', NULL);
INSERT INTO `usuario` VALUES (509, 'ELISBETH', 'PINEDO REATEGUI', '00901440', '$2a$07$asxx54ahjppf45sd87a5ausMnWeHUr9pFz.SYEz1cOSXZG55VRUHm', '1', '00901440', '942-740130', 18, 'epinedo@unsm.edu.pe', '', 1, '2022-12-07', '2024-08-14 12:43:35', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (510, 'WILLIAM', 'PINEDO SINARAHUA', '01114899', '$2a$07$asxx54ahjppf45sd87a5auohGDWmka461Uwk4dpCGzs0KEKi/Onne', '1', '01114899', '942-652102', 18, 'wpinedo@unsm.edu.pe', '', 1, '2022-05-16', '2024-05-29 09:08:50', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (511, 'NILO', 'PINEDO SOTO', '00845915', '$2a$07$asxx54ahjppf45sd87a5aux4nlHSJuDI.bs60UYvqhP5Agf25USkm', '1', '00845915', '042529871', 18, 'nilsoto@unsm.edu.pe', '', 1, '2022-07-06', '2024-07-25 10:21:13', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (512, 'CESAR BERNARDO', 'PUPUCHE NEVADO', '16774206', '$2a$07$asxx54ahjppf45sd87a5au0RTv7Mp/v7f2Mcg4j801q8P0D3xgZyq', '1', '16774206', '', 18, 'cpupuchen@unsm.edu.pe', '', 1, '2022-09-06', '2024-08-21 04:35:25', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (513, 'WILFREDO', 'RAMIREZ GARCIA', '01074325', '$2a$07$asxx54ahjppf45sd87a5au/yAIz6AZdycsEg9RZjo5MZOtBnfhht6', '1', '01074325', '', 18, 'wilgarcia@unsm.edu.pe', '', 1, '2022-07-20', '2024-04-11 11:28:27', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (514, 'MARIA LUISA', 'RAMIREZ LOPEZ', '01119427', '$2a$07$asxx54ahjppf45sd87a5auftCurTw.WQZMZYFYjrqK17n50R3Yh6m', '1', '01119427', '942445220', 18, 'mlramirez@unsm.edu.pe', '', 1, '2022-10-04', '2024-05-31 09:34:30', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (515, 'ROGER', 'RAMIREZ NAVARRO', '01072831', '$2a$07$asxx54ahjppf45sd87a5auQpWyJqXe0JbQkSVqMe2bjRQ3OEo6yOS', '1', '01072831', '', 18, 'rognavarro@unsm.edu.pe', '', 1, '2022-12-20', '2024-01-15 08:02:21', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (516, 'CARLOS ENRIQUE', 'RAMIREZ PINEDO', '01121171', '$2a$07$asxx54ahjppf45sd87a5auPruT7EXJGivfI4rCHA2cwMcpz.VtYK2', '1', '01121171', '45456', 18, 'calosramirezp@unsm.edu.pe', '', 1, '2024-06-11', '2024-07-01 14:51:06', NULL, '2024-03-11 18:29:38', NULL);
INSERT INTO `usuario` VALUES (517, 'NICOLAS ARTEMIO', 'RAMIREZ PINEDO', '01073257', '$2a$07$asxx54ahjppf45sd87a5au1L27OsYu.HmXZeOJ/oPtkT9/VJB41Ha', '1', '01073257', '942-640197', 18, 'nicpinedo@unsm.edu.pe', '', 1, '2022-09-22', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (518, 'JOSE MANUEL', 'RAMIREZ RAMIREZ', '01116663', '$2a$07$asxx54ahjppf45sd87a5auWd763PmHr4y7Qj2dEkAzbDHykt79H.e', '1', '01116663', '', 18, 'manramirez@unsm.edu.pe', '', 1, '2022-07-08', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (519, 'ALANA ', 'RAMIREZ RUIZ', '01077904', '$2a$07$asxx54ahjppf45sd87a5aucyY/aT4313V1YcqAfyznAR/3kh/KkN6', '1', '01077904', '942996100', 18, 'aramirez@unsm.edu.pe', '', 1, '2022-10-04', '2024-03-13 13:34:28', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (520, 'ROCIO', 'RAMIREZ RUIZ', '01115522', '$2a$07$asxx54ahjppf45sd87a5auhtLYtmHl6D8vrBDPsicZ6c4jjzBhfTa', '1', '01115522', '680332', 18, 'rramirez@unsm.edu.pe', '', 1, '2022-10-04', '2024-08-25 12:13:10', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (521, 'LUIS', 'RAMIREZ TORRES', '01122306', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01122306', '942-421860', 18, 'lramirez@unsm.edu.pe', '', 1, '2022-05-18', '2024-07-22 09:28:17', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (522, 'FERNANDO', 'RAMIREZ VARGAS', '01118220', '$2a$07$asxx54ahjppf45sd87a5au6Ceciw4J1kScztjQC1.IZJaRSVm8tWK', '1', '01118220', '', 18, 'framirezv@unsm.edu.pe', '', 1, '2022-11-24', '2024-08-27 14:15:58', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (523, 'GINA MARIA', 'RAMIREZ VASQUEZ DE FERNANDEZ', '01061492', '$2a$07$asxx54ahjppf45sd87a5aueczqO6VJlaXTy106Px0jrW2Vj2X/MPK', '1', '01061492', '04250-8481', 18, 'ginfernandez@unsm.edu.pe', '', 1, '2022-05-17', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (524, 'ALFREDO', 'RAMOS PEREA', '01117359', '$2a$07$asxx54ahjppf45sd87a5aut0Iaow2FM1f2tBSN7dbAaQVyY2RPkKG', '1', '01117359', '942-791170', 18, 'aramos@unsm.edu.pe', '', 1, '2022-09-02', '2024-02-22 10:01:06', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (525, 'DEMETRIO', 'REINA DAVILA', '01091194', '$2a$07$asxx54ahjppf45sd87a5aumE3M417jPjtPryom0NI.WI6T/Zohpie', '1', '01091194', '(042) 50-8411', 18, 'demdavila@unsm.edu.pe', '', 1, '2022-12-20', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (526, 'LUZ AMPARO', 'RENGIFO FLORES', '01113179', '$2a$07$asxx54ahjppf45sd87a5auNstzvl5TVOGa57G6AvfAyH3A4dmwMUC', '1', '01113179', '527430', 18, 'larengifo@unsm.edu.pe', '', 1, '2022-07-07', '2024-07-01 14:33:30', NULL, '2023-09-11 14:12:07', NULL);
INSERT INTO `usuario` VALUES (527, 'GULNARA', 'RENGIFO RIOS', '00844024', '$2a$07$asxx54ahjppf45sd87a5auXsxUx.QZzZ9AuXXOvRUzpMWO9HjRBTi', '1', '00844024', '531004', 18, 'grengifo@unsm.edu.pe', '', 1, '2022-09-23', '2024-06-27 14:40:40', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (528, 'AMPARO', 'RIOJA GUERRA', '00953456', '$2a$07$asxx54ahjppf45sd87a5ausOOg6OjV.E78YPjzRd8mEQ8nJTahUY2', '1', '00953456', '(042) 54-3459', 18, 'ampguerra@unsm.edu.pe', '', 1, '2022-05-08', '2023-11-30 10:16:42', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (529, 'ALEX', 'RODRIGUEZ RAMIREZ', '01147693', '$2a$07$asxx54ahjppf45sd87a5auOuTD7FIcqoy/nYuulD9ppGSqNKzmjBy', '1', '01147693', '042528010', 14, 'arodriguez@unsm.edu.pe', '', 1, '2022-07-26', '2024-08-09 13:44:47', NULL, '2024-01-26 12:35:25', NULL);
INSERT INTO `usuario` VALUES (530, 'TERESA ', 'ROJAS DE PORTOCARRERO', '01074655', '$2a$07$asxx54ahjppf45sd87a5auR0KSsYgF.W1b/CxotvMVj/Q6AWxe7su', '1', '01074655', '956860814', 18, 'tererojas@unsm.edu.pe', '', 1, '2022-10-04', '2024-01-17 09:53:51', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (531, 'MARCO ANTONIO', 'ROJAS ROJAS', '01148515', '$2a$07$asxx54ahjppf45sd87a5auXwLzKP2PUsmgbdodzQy3ZxlALq/eifa', '1', '01148515', '', 18, 'marcrojas@unsm.edu.pe', '', 1, '2022-11-04', '2024-08-27 08:26:21', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (532, 'ULISES RAFAEL', 'ROJAS SANTOS', '08287937', '$2a$07$asxx54ahjppf45sd87a5aub.1XAN0rNV5y6wIZ7rH58LJxTO6mfyO', '1', '08287937', '', 18, 'rafasantos@unsm.edu.pe', '', 1, '2022-09-20', '2024-02-13 09:51:37', NULL, '2023-09-20 08:10:25', NULL);
INSERT INTO `usuario` VALUES (533, 'CARMEN', 'ROJAS SOPLIN', '01134792', '$2a$07$asxx54ahjppf45sd87a5auTtv08VNoS9krGM47muJnd8x8O2zWxsC', '1', '01134792', '942698430', 18, 'crojass@unsm.edu.pe', 'Jr. 1RO. ABRIL 328 BANDA DE SHILCAYO', 1, '2022-08-27', '2024-07-24 10:40:14', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (534, 'SEMIRA', 'ROJAS SOPLIN', '01133401', '$2a$07$asxx54ahjppf45sd87a5auoON1GXs5oE7N8kjDU8VxZWhK3mP36dO', '1', '01133401', '942-492293', 18, 'srojassoplin@unsm.edu.pe', '', 1, '2022-09-22', '2024-04-04 09:52:03', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (535, 'SEGUNDO LINO', 'ROMERO COMETIVOS', '00862448', '$2a$07$asxx54ahjppf45sd87a5auU5.GybPeL7vM7oeRHmz1/pokNaSyzqu', '1', '00862448', '', 18, 'segcometivos@unsm.edu.pe', '', 1, '2022-05-18', '2024-08-08 17:38:24', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (536, 'EYLEN', 'ROMERO CORDOVA', '42269557', '$2a$07$asxx54ahjppf45sd87a5auv3p0aCYTJJ3Jd5em/Gll.VJfsu35J92', '1', '42269557', '945011872', 18, 'eromero@unsm.edu.pe', 'Jr. Los Ángeles Nª 320 - Tarapoto', 1, '2022-05-18', '2024-07-18 15:30:03', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (537, 'MIGUEL', 'RUIZ BOCANEGRA', '01075189', '$2a$07$asxx54ahjppf45sd87a5auUkH7H8nmzGq8NAwn0CZY2K67xajnXa.', '1', '01075189', '', 18, 'mruizb@unsm.edu.pe', '', 1, '2022-09-27', '2024-03-22 09:26:40', NULL, '2024-03-22 08:53:30', NULL);
INSERT INTO `usuario` VALUES (538, 'JOSE MIGUEL', 'RUIZ GARCIA', '40857801', '$2a$07$asxx54ahjppf45sd87a5au5FmIhUeLG.hqoCBSudC2JnaCV7o42em', '1', '40857801', '972596128', 18, 'miguelseguridad1980@gmail.com', 'Tarapoto', 1, '2022-05-07', '2024-06-10 10:07:47', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (539, 'RIDER', 'RUIZ JESUS', '00847811', '$2a$07$asxx54ahjppf45sd87a5aubzkzL.0jN/FrKs7MgsHolP/8krvDdLC', '1', '00847811', '', 18, 'rijesus@unsm.edu.pe', '', 1, '2022-09-21', '2024-08-21 08:33:17', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (540, 'GENRRY', 'SAAVEDRA GRANDEZ', '01115144', '$2a$07$asxx54ahjppf45sd87a5auVCUz3hO0t13rPeMLysF9Bn5ZM9oTKU.', '1', '01115144', '942638128', 18, 'gsaavedrag@unsm.edu.pe', '', 1, '2024-02-16', '2024-08-23 09:42:57', NULL, '2023-11-16 13:22:34', NULL);
INSERT INTO `usuario` VALUES (541, 'KETTY', 'SAAVEDRA LOPEZ', '01162767', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01162767', '948430515', 18, 'ksaavedral@unsm.edu.pe', '', 1, '2022-05-18', '2024-07-12 08:43:49', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (542, 'NANCY', 'SAAVEDRA RAMIREZ', '01090928', '$2a$07$asxx54ahjppf45sd87a5auXc9R8ihrZOIrElizpdA5zCGYY1wBZBq', '1', '01090928', '(042) 52-4321', 18, 'nsaavedrar@unsm.edu.pe', '', 1, '2022-12-21', '2024-06-13 17:21:07', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (543, 'ANITA PASTORA ', 'SAAVEDRA TRIGOSO', '01148073', '$2a$07$asxx54ahjppf45sd87a5au/qE99xflUmSTBFxosEYgi17qI90nBYC', '1', '01148073', '', 18, 'apsaavedra@unsm.edu.pe', '', 1, '2022-09-15', '2024-08-12 00:15:09', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (544, 'GUIDO', 'SAAVEDRA VELA', '01073635', '$2a$07$asxx54ahjppf45sd87a5auYwEEhOasl9OySHGd90bv005Wuq9.4GC', '1', '01073635', '(042) 52-6983', 18, 'guivela@unsm.edu.pe', '', 1, '2022-06-30', '2024-09-05 09:52:55', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (545, 'LUIS ALBERTO', 'SABOYA HUAMAN', '00950699', '$2a$07$asxx54ahjppf45sd87a5aujo6Z/8hj.ChwKaWnqgeL73EpsNhvuom', '1', '00950699', '944565111', 18, 'luchosaboya6@gmail.com', 'Jiron Lim∆689', 1, '2022-05-16', '2024-09-01 12:41:12', NULL, '2024-09-12 11:17:12', NULL);
INSERT INTO `usuario` VALUES (546, 'ROGELIO', 'SABOYA TULUMBA', '01075641', '$2a$07$asxx54ahjppf45sd87a5au7RcnrekeQSaAo.VJ3IgPmoUC/bX7O2e', '1', '01075641', '942929893', 18, 'rogtulumba@unsm.edu.pe', '', 1, '2022-09-20', '2023-08-22 18:18:23', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (547, 'MELIRNE', 'SANCHEZ PEREZ', '00951958', '$2a$07$asxx54ahjppf45sd87a5aukIp87Od8JaDkQJpYslyEmOnRpy9vIAy', '1', '00951958', '942-699396', 18, 'meliperez@unsm.edu.pe', '', 1, '2022-09-20', '2024-08-19 14:31:32', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (548, 'RUTH', 'SANDOVAL PANAIFO', '00954365', '$2a$07$asxx54ahjppf45sd87a5auQ1psoCqIqebJUOEC80109Khy7mYpASK', '1', '00954365', '942-018439', 18, 'rsandovalp@unsm.edu.pe', '', 1, '2022-08-23', '2024-08-08 07:40:27', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (549, 'MARTHA SOLEDAD', 'TABOADA HOSOKAY', '01102540', '$2a$07$asxx54ahjppf45sd87a5auMC1TdEf5VtP.sdfdP3YgwCIFlk4XQ7S', '1', '01102540', '423212', 18, 'mstaboada@unsm.edu.pe', '', 1, '2022-09-14', '2023-11-15 10:50:01', NULL, '2023-11-15 10:48:41', NULL);
INSERT INTO `usuario` VALUES (550, 'EMERSON', 'TENAZOA SINTI', '01076541', '$2a$07$asxx54ahjppf45sd87a5au1TN5Z.XNlUv1dUNrTb/7sbEDXG.Q35C', '1', '01076541', '528410', 18, 'emersinti@unsm.edu.pe', '', 1, '2022-05-16', '2024-02-01 10:03:01', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (551, 'MARISOL', 'TORRES DAVILA', '01133405', '$2a$07$asxx54ahjppf45sd87a5auQmpahQEL4b/IGikWtQ5KimviVOVqZ46', '1', '01133405', '0048689', 14, 'mtorres@unsm.edu.pe', '', 1, '2022-05-15', '2024-02-05 11:56:52', NULL, '2024-01-26 12:36:04', NULL);
INSERT INTO `usuario` VALUES (552, 'ROGER', 'TORRES FLORES', '01091339', '$2a$07$asxx54ahjppf45sd87a5auJxRJt3XQsXHaqvLo.5lIQxq6ghz6tiq', '1', '01091339', '(042) 50-3435', 18, 'roflores@unsm.edu.pe', '', 1, '2023-02-28', '2023-09-07 16:53:34', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (553, 'ARNULFO', 'TORRES MERA', '01072669', '$2a$07$asxx54ahjppf45sd87a5auyVXBG4j4jsxQ1XEpgsJAz/WWQ0mvCgC', '1', '01072669', '942957137', 18, 'arnulmera@unsm.edu.pe', '', 1, '2022-06-15', '2024-02-13 11:14:23', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (554, 'ELSA LLERME', 'TORRES PERDOMO DE RAMIREZ', '01117452', '$2a$07$asxx54ahjppf45sd87a5augMJx5qodB2I543qPVvcE3PJtPMJHtti', '1', '01117452', '942-948286', 18, 'elsaperdomo@unsm.edu.pe', '', 1, '2022-07-20', '2024-09-05 12:35:27', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (555, 'BEATRIZ', 'TORRES SAAVEDRA', '01064796', '$2a$07$asxx54ahjppf45sd87a5au1Wlbp0WNOCN0dc.GzhTR6uHpm29VXuW', '1', '01064796', '', 18, 'beasaavedra@unsm.edu.pe', '', 1, '2022-07-19', '2024-09-11 16:24:34', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (556, 'GILBERTO', 'TRIGOZO GARCIA', '41326695', '$2a$07$asxx54ahjppf45sd87a5aumSCi2X1g6.gaih03GscLSwse.UylT4K', '1', '41326695', '', 18, 'gtrigozog@unsm.edu.pe', '', 1, '2022-05-08', '2024-06-21 07:56:49', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (557, 'LINDER', 'TRIGOZO LOPEZ', '01114585', '$2a$07$asxx54ahjppf45sd87a5autx7Q0lHKhAD7thAb7AAFzHKgOEVDdsa', '1', '01114585', '958691766', 18, 'ltrigozolopez@unsm.edu.pe', 'ltrigozolopez@unsm.edu.pe', 1, '2022-08-13', '2024-08-07 13:52:43', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (558, 'WELINTON', 'TUANAMA RIOS', '01070516', '$2a$07$asxx54ahjppf45sd87a5au7GLGZcucWdV2FkzDfVzGLDlZB0xYSfO', '1', '01070516', '942689572', 18, 'wtuanamar@unsm.edu.pe', '', 1, '2022-09-06', '2024-08-05 08:51:11', NULL, '2024-03-12 09:28:16', NULL);
INSERT INTO `usuario` VALUES (559, 'HERIBERTO', 'TUANAMA TELLO', '01071450', '$2a$07$asxx54ahjppf45sd87a5aujo4EwuGDxRTiSprFpyb2rRjB0iBMFci', '1', '01071450', '(042) 52-1705', 18, 'heritello@unsm.edu.pe', '', 1, '2024-05-12', '2024-06-03 12:36:57', NULL, '2024-02-12 13:05:39', NULL);
INSERT INTO `usuario` VALUES (560, 'CHARLES DARWIN', 'TUESTA GONZALES', '41792007', '$2a$07$asxx54ahjppf45sd87a5auZ6nfsLU2AT7f7apen0sxojjG7eHA4ay', '1', '41792007', '', 18, 'ctuestag@unsm.edu.pe', '', 1, '2022-06-28', '2024-08-22 11:45:04', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (561, 'TONNY', 'TUESTA PINEDO', '40916037', '$2a$07$asxx54ahjppf45sd87a5auRPI.wWv2c5YQfmKg3eJGWu.GYh0.phO', '1', '40916037', '952655681', 18, 'ttuesta@unsm.edu.pe', 'Mza G, Lte 9, Las Lomas de San Pedro-Tarapoto', 1, '2022-05-07', '2024-09-09 09:07:05', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (562, 'OSCAR ', 'TUESTA REATEGUI', '01114130', '$2a$07$asxx54ahjppf45sd87a5auXhHm4t6AvVfo98zNkAcAv8sKM7t66ri', '1', '01114130', '942-623065', 18, 'otuestar@unsm.edu.pe', '', 1, '2022-05-07', '2024-06-13 17:09:12', NULL, '2024-02-13 12:48:38', NULL);
INSERT INTO `usuario` VALUES (563, 'AGUSTIN', 'UBIDIA CUBAS', '01134036', '$2a$07$asxx54ahjppf45sd87a5auqx307lo1fo./Ramw9R0EIruZRB2Mt0G', '1', '01134036', '532392', 18, 'aubidiac@unsm.edu.pe', '', 1, '2022-05-24', '2024-07-24 19:23:40', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (564, 'RAMIRO', 'VASQUEZ GARCIA', '01080967', '$2a$07$asxx54ahjppf45sd87a5auT0ClC77DEtldjtPijJBbGmTNcT9XBKC', '1', '01080967', '942624894', 18, 'ramiro@unsm.edu.pe', '', 1, '2022-09-07', '2024-08-08 11:10:46', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (565, 'CLARA RAQUEL', 'VASQUEZ NUÑEZ', '05203001', '$2a$07$asxx54ahjppf45sd87a5autmRkpPp6s4Nrrqa1I9OyG/cJ73Vl4iW', '1', '05203001', '942668000', 18, 'clarvasquez@unsm.edu.pe', '', 1, '2022-08-26', '2024-07-03 09:25:12', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (566, 'EDINSON', 'VASQUEZ TORREJON', '40034187', '$2a$07$asxx54ahjppf45sd87a5auj4E.nuSEsR2.k4wlYthlAiWnBBRyUCq', '1', '40034187', '', 18, 'editorrejon@unsm.edu.pe', '', 1, '2022-10-11', '2024-06-05 16:05:31', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (567, 'RUBEN', 'VELA AGUILAR', '00833321', '$2a$07$asxx54ahjppf45sd87a5au3Q9//TrmDIrzDklwo07XX6SyEW6Ai96', '1', '00833321', '9563904', 18, 'rubaguilar@unsm.edu.pe', '', 1, '2022-07-25', '2024-09-10 17:47:00', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (568, 'LIZ DEYVIS', 'VELA FLORES', '01100865', '$2a$07$asxx54ahjppf45sd87a5aubUXwk2puDj2x0SB747Urbf93v4yjS5q', '1', '01100865', '(042) 50-8062', 18, 'lizvela@unsm.edu.pe', '', 1, '2022-05-11', '2024-08-14 17:57:11', NULL, '2024-01-08 11:27:23', NULL);
INSERT INTO `usuario` VALUES (569, 'CELINDA', 'VELA USHIÑAHUA', '01101166', '$2a$07$asxx54ahjppf45sd87a5auxpgJiTPprRb7zwkkQj46GPZ1uNM8P1q', '1', '01101166', '*300617', 18, 'ceveus@unsm.edu.pe', '', 1, '2022-11-03', '2024-09-10 10:15:32', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (570, 'CARLOS', 'VERDE GIRBAU', '01127948', '$2a$07$asxx54ahjppf45sd87a5au8OtkRWBMbPwVZAVjTzYt2EEN6wKDQl2', '1', '01127948', '', 18, 'cverde@unsm.edu.pe', '', 1, '2023-06-28', '2024-01-19 09:54:31', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (571, 'BETSI', 'VERGARA FASANANDO', '01114147', '$2a$07$asxx54ahjppf45sd87a5au55G7EgABrN2f5mXCZ7QQKK5KLoKodjS', '1', '01114147', '942699439', 18, 'bvergara@unsm.edu.pe', '', 1, '2022-05-25', '2024-01-11 19:36:32', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (572, 'ABEL', 'VILLACORTA TAPULLIMA', '01116332', '$2a$07$asxx54ahjppf45sd87a5au0lgfNwb8MwGwWq6WR/ojSEcAqmO77BS', '1', '01116332', '', 18, '', '', 1, '2022-05-16', '2024-03-09 09:47:22', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (573, 'EVELINA', 'VILLAVICENCIO RAMIREZ', '01161302', '$2a$07$asxx54ahjppf45sd87a5auDN8rZWsipFjD1T0P8z8vpmZkf42okwG', '1', '01161302', '948041883', 18, 'evillavicencio@unsm.edu.pe', '', 1, '2022-05-07', '2024-01-12 11:47:02', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (574, 'VICTOR FELIPE', 'YAP FLORES', '01112904', '$2a$07$asxx54ahjppf45sd87a5aubIa0o0kCnyabTuypUn8WrK8GF8zUZVO', '1', '01112904', '942743522', 18, 'vicyap@unsm.edu.pe', '', 1, '2022-08-06', '2024-06-12 13:41:48', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (575, 'VICTOR FIDEL', 'YAP FLORES', '01077653', '$2a$07$asxx54ahjppf45sd87a5auBHEgIZPxTf8abg9wV74XqeXyYOLUBAm', '1', '01077653', '929539909', 18, 'vicflores@unsm.edu.pe', '', 1, '2022-08-06', '2024-09-06 07:43:14', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (576, 'MILAGROS', 'AGUILAR RUIZ', '43264654', '$2a$07$asxx54ahjppf45sd87a5aupBkwecE/zaQDOFI0D0JPPtNo/hP22Nq', '1', '43264654', '943847485', 18, 'maguilar@unsm.edu.pe', '', 1, '2022-11-25', '2024-06-12 10:06:16', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (577, 'TEOFILO BRAYAN', 'ALBERCA MARIN', '70001230', '$2a$07$asxx54ahjppf45sd87a5au/.Giecbi/7DS3QLyU68silbddZCEmje', '1', '70001230', '946574999', 18, '', '', 1, '2022-06-24', '2024-09-11 10:18:51', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (578, 'VIOLETA', 'ALVA SALDAÑA', '08603427', '$2a$07$asxx54ahjppf45sd87a5au78vXVPm4o4sWJnLqmtSHOODG8suvht.', '1', '08603427', '948935757', 18, 'valvas@unsm.edu.pe', '', 1, '2022-05-10', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (579, 'LUCIOLA', 'AREVALO DEL AGUILA', '01090356', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01090356', '947886975', 18, '', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (580, 'ALAN', 'AREVALO GARCIA', '42130593', '$2a$07$asxx54ahjppf45sd87a5auG3c61QljEAL.YrTJl4hJYjGn7eR49R6', '1', '42130593', '913349586', 18, '', '', 1, '2023-08-28', '2024-01-02 09:52:20', NULL, '2024-01-02 09:50:44', NULL);
INSERT INTO `usuario` VALUES (581, 'LIZ LELIS', 'AREVALO PAREDES', '01147173', '$2a$07$asxx54ahjppf45sd87a5auj9R1kOeriYOClnqkiB2DR.O.iVO7TGO', '1', '01147173', '979979741', 18, '', '', 1, '2022-08-09', '2024-09-01 10:46:56', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (582, 'RICARDO', 'AREVALO PEZO', '01148651', '$2a$07$asxx54ahjppf45sd87a5auZND9SaobgPAOup92GYLuY/97lo142RG', '1', '01148651', '944487943', 18, '', '', 1, '2022-05-24', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (583, 'JOSE ALEXANDER', 'AYALA BUSTAMANTE', '42809268', '$2a$07$asxx54ahjppf45sd87a5au5My2pCFffffyYs0i0.ISO.55hyfSLK2', '1', '42809268', '958628692', 18, 'jayalab@unsm.edu.pe', '', 1, '2024-05-05', '2024-08-19 23:26:53', NULL, '2024-02-05 13:59:09', NULL);
INSERT INTO `usuario` VALUES (584, 'TANIA', 'BABILONIA PEREZ', '41390572', '$2a$07$asxx54ahjppf45sd87a5aufVzpfliA91q0YPS5Kkd5N8fkl5LPKAm', '1', '41390572', '920498510', 18, 'tbabilonia@unsm.edu.pe', '', 1, '2022-08-20', '2024-08-28 13:08:24', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (585, 'JHON WILLER', 'BARTRA MELENDEZ', '42727467', '$2a$07$asxx54ahjppf45sd87a5aut9PehFR3Wd4NanoJXoSMqKEUvmo58je', '1', '42727467', '952964489', 18, 'jwbartra@unsm.edu.pe', '', 1, '2022-05-10', '2024-01-17 12:14:12', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (586, 'JORGE', 'BOCANEGRA TELLO', '00946889', '$2a$07$asxx54ahjppf45sd87a5auwpdIwJCs6XgMwcaHaQ4cPNHBtBGxXb6', '1', '00946889', '999523201', 18, '', '', 1, '2022-05-05', '2024-08-29 14:01:05', NULL, '2024-03-25 10:46:48', NULL);
INSERT INTO `usuario` VALUES (587, 'MARCO STALIN', 'BRAVO CUBAS', '71494717', '$2a$07$asxx54ahjppf45sd87a5auyxG625LoUTKxutppDeBC496Rph6iUyu', '1', '71494717', '989533655', 18, '', '', 1, '2022-11-02', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (588, 'HITALO', 'CAHUAZA HUAMÁN', '73204189', '$2a$07$asxx54ahjppf45sd87a5aulYKuZAEMnevCd66E.35YzJn1bvbrcTO', '1', '73204189', '964532961', 18, 'hcahuaza@unsm.edu.pe', '', 1, '2022-05-10', '2023-10-20 20:07:57', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (589, 'MILAGROS JASMIN', 'CAMPOS HERRERA', '46767626', '$2a$07$asxx54ahjppf45sd87a5aunzMTxlTc2mhbw6nKEQ/OALTqRnSRKhe', '1', '46767626', '961650854', 18, 'mjcamposh@unsm.edu.pe', '', 1, '2022-06-26', '2024-03-02 12:51:32', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (590, 'MAGNA', 'CAMPOS IBAÑEZ', '01125029', '$2a$07$asxx54ahjppf45sd87a5auMCpo2DWm9hrWS1XXbzqgueayxbk7R2G', '1', '01125029', '945889631', 18, 'mcampos@unsm.edu.pe', '', 1, '2022-07-28', '2024-08-28 11:41:50', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (591, 'ALEX', 'CARBAJAL ISUIZA', '42674000', '$2a$07$asxx54ahjppf45sd87a5aub8mPQ1avfyW07l5x9Ak1/0O61WlRjoq', '1', '42674000', '925524836', 18, 'alexcarbajal48@gmail.com', '', 1, '2022-05-15', '2024-07-08 21:36:46', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (592, 'ELIDA', 'CEOPA TANGOA', '00951445', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '00951445', '973159530', 18, '', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (593, 'SILVANA KATHERINE', 'CHAVEZ PEREA', '71194496', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '71194496', '927530240', 18, '', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (594, 'ROGER ORLANDO', 'CHIROQUE SERNAQUE', '02634605', '$2a$07$asxx54ahjppf45sd87a5auzMfNVJZ0o1dleHpJFy/0CbiVNjC5D/O', '1', '02634605', '974878513', 18, '', '', 1, '2022-06-29', '2024-08-08 15:04:38', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (595, 'PEDRO', 'CHUNG PAREDES', '80254787', '$2a$07$asxx54ahjppf45sd87a5auLvtoCICjOHPt0b93Y1yNgvaOM0o3aM.', '1', '80254787', '963920020', 18, '', '', 1, '2022-08-03', '2024-08-07 10:53:54', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (596, 'JULISA ELIZABETH', 'CHUQUIVIGUEL ANGULO', '41462589', '$2a$07$asxx54ahjppf45sd87a5aujq1qjtjP00fh/bTfBEwDDCb9wmrgseK', '1', '41462589', '948148830', 18, 'jechuquiviguela@unsm.edu.pe', '', 1, '2022-05-08', '2024-08-08 11:00:31', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (597, 'EYLITH', 'DEL AGUILA HIDALGO', '40068115', '$2a$07$asxx54ahjppf45sd87a5auOMvpBNHsx2gGku8YKCqToB4xgr9Y1.m', '1', '40068115', '943493543', 18, 'eylidalgo@unsm.edu.pe', '', 1, '2022-08-12', '2024-07-24 07:35:35', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (598, 'MARIA ELENA', 'DIAZ PANDURO', '00905198', '$2a$07$asxx54ahjppf45sd87a5aujTyiNzM7RUzDFG2ycPOzf/nxiqueJSm', '1', '00905198', '999086155', 18, 'mdiazp@unsm.edu.pe', '', 1, '2023-04-09', '2024-08-02 09:56:02', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (599, 'SANTIAGO', 'DOMINGUEZ RIOS', '01063721', '$2a$07$asxx54ahjppf45sd87a5au4CVCGJbIXyc.gmREVHveCIXR67C/ZMi', '1', '01063721', '952012522', 18, 'sanrios@unsm.edu.pe', '', 1, '2022-12-27', '2024-08-26 09:20:26', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (600, 'ROY JIMMY', 'FABABA MORI', '44661071', '$2a$07$asxx54ahjppf45sd87a5auYfw5n2LZ90eIp9VbDjiripMcXaUyffy', '1', '44661071', '935178074', 18, 'rjfababam@unsm.edu.pe', '', 1, '2022-06-22', '2024-08-05 17:31:06', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (601, 'GRECIA VANESSA', 'FACHIN RUIZ', '46668022', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '46668022', '965958475', 18, 'gvfachin@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (602, 'LUIS ALAN', 'FAYA SOBRINO', '43144863', '$2a$07$asxx54ahjppf45sd87a5auwZy2RFeEEky1P2v2ECF58i/m2jLDb1a', '1', '43144863', '964594505', 18, 'lafayas@unsm.edu.pe', '', 1, '2022-07-11', '2024-09-12 10:23:42', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (603, 'JOSE BENITO', 'FERNANDEZ DIAZ', '40341055', '$2a$07$asxx54ahjppf45sd87a5aur/l04O1kffvYcPmEVKu6IgQjMBIW7u.', '1', '40341055', '965952139', 18, 'benidiaz@unsm.edu.pe', '', 1, '2022-11-01', '2024-06-27 12:10:57', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (604, 'DIANA', 'FLORES NAVARRO', '01120782', '$2a$07$asxx54ahjppf45sd87a5auSn7lGbzaJ5fGe9Qsk/AykwZSYkjHSsm', '1', '01120782', '953099601', 18, 'dinavarro@unsm.edu.pe', '', 1, '2023-04-13', '2024-07-25 09:22:51', NULL, '2024-04-02 14:01:59', NULL);
INSERT INTO `usuario` VALUES (605, 'RONAL', 'FLORES PEREZ', '00954600', '$2a$07$asxx54ahjppf45sd87a5auSCWpNgfrmM128.QQdvK07p.uu6kxkru', '1', '00954600', '938392548', 18, 'rfloresp@unsm.edu.pe', '', 1, '2022-07-29', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (606, 'ROMAN', 'FLORES RAMIREZ', '01116373', '$2a$07$asxx54ahjppf45sd87a5auEPyReO9bm1LdQg1dSl9zqWnQZYp4lmG', '1', '01116373', '942483966', 18, 'romramirez@unsm.edu.pe', '', 1, '2024-01-25', '2024-08-15 11:42:54', NULL, '2024-07-25 10:13:10', NULL);
INSERT INTO `usuario` VALUES (607, 'NAMI MORAIMA', 'FLORES SANCHEZ', '01118703', '$2a$07$asxx54ahjppf45sd87a5auc/2Vaho6roe7j7WH/rA6jcilrhqNumG', '1', '01118703', '902634488', 18, 'nasanchez@unsm.edu.pe', '', 1, '2022-05-10', '2024-08-13 16:20:34', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (608, 'AUGUSTO ARISTIDES', 'GALVEZ VARGAS', '07032470', '$2a$07$asxx54ahjppf45sd87a5audBs95tWitv9uvHuTiS/uLYfLyStAOVW', '1', '07032470', '948410462', 18, 'auvargas@unsm.edu.pe', '', 1, '2022-07-18', '2024-08-16 11:46:50', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (609, 'RICHER', 'GARAY MONTES', '80293207', '$2a$07$asxx54ahjppf45sd87a5auiGy3IIj7uDG4sTCJVKKQPLj0Y6/Kgp.', '1', '80293207', '995192716', 18, 'rgaraym@unsm.edu.pe', '', 1, '2022-07-01', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (610, 'LUIS RAFAEL', 'GARCÍA VELA', '41607912', '$2a$07$asxx54ahjppf45sd87a5auRoiYcnWOCT6fIyWlv0lNKq6cyiAtUlC', '1', '41607912', '959419388', 18, 'luisgarcia@unsm.edu.pe', '', 1, '2022-05-18', '2024-08-24 13:03:04', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (611, 'ORLANDO', 'GARCIA FALCON', '41524453', '$2a$07$asxx54ahjppf45sd87a5auXi7WHqst/v/ktFTNCeO2Las49MlMlUO', '1', '41524453', '978040439', 18, '', '', 1, '2022-08-31', '2024-08-29 09:02:01', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (612, 'FERNANDO', 'GARCIA GONZALES', '00845521', '$2a$07$asxx54ahjppf45sd87a5auR02ytHEvFDFNDFzvhD5P5iXj35cuB1S', '1', '00845521', '(042) 54-3142', 18, '', '', 1, '2024-01-23', '2023-11-21 10:45:37', NULL, '2023-10-23 10:14:11', NULL);
INSERT INTO `usuario` VALUES (613, 'DARLING', 'GONZALES GARCIA', '01146979', '$2a$07$asxx54ahjppf45sd87a5auZHRISVGM9U5EDEFMPvvcVyyhQuEMJRe', '1', '01146979', '942420141', 18, 'dargarcia@unsm.edu.pe', '', 1, '2022-05-09', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (614, 'JIAN ANGEL', 'GONZALES PINEDO', '43463011', '$2a$07$asxx54ahjppf45sd87a5autioMB669PiCXaZZKFEyBRk4c2A3fjEG', '1', '43463011', '942931144', 18, 'jianpinedo@unsm.edu.pe', '', 1, '2023-01-12', '2024-02-12 10:59:54', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (615, 'WILDER', 'GONZALES RAMIREZ', '01069822', '$2a$07$asxx54ahjppf45sd87a5au/uZQolFzPl00DN7HA1u75q/UqpTRftm', '1', '01069822', '985830392', 18, 'wildramirez@unsm.edu.pe', '', 1, '2023-01-10', '2024-02-29 11:03:00', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (616, 'MECHI', 'GONZALES SAAVEDRA', '01121272', '$2a$07$asxx54ahjppf45sd87a5auhCryd25BHLGDJ08FvrbRiX39skjwRhu', '1', '01121272', '938611985', 18, 'mgonzales@unsm.edu.pe', '', 1, '2023-08-29', '2024-08-21 09:23:09', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (617, 'JESUS', 'GONZALES TAPULLIMA', '47664720', '$2a$07$asxx54ahjppf45sd87a5autwHmtxnN2awomC/eIoJkj0/FMvPygvq', '1', '47664720', '951000639', 18, 'jegonzales@unsm.edu.pe', '', 1, '2023-11-02', '2024-07-16 14:04:54', NULL, '2023-08-02 13:59:46', NULL);
INSERT INTO `usuario` VALUES (618, 'DILFER', 'GUERRA GUERRA', '44050923', '$2a$07$asxx54ahjppf45sd87a5auFXD7Eb.Fh/cV.9iHdsZmXXJDU0VHg8a', '1', '44050923', '', 18, '', '', 1, '2023-06-22', '2023-10-23 11:24:35', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (619, 'FERNANDO', 'GUERRA GUERRA', '41060340', '$2a$07$asxx54ahjppf45sd87a5aurZHiIadfwQxyHM8W1a1D0WYOr6Du25C', '1', '41060340', '942878802', 18, '', '', 1, '2024-04-16', '2024-01-16 14:55:50', NULL, '2024-01-16 14:55:38', NULL);
INSERT INTO `usuario` VALUES (620, 'RONAL', 'GUERRA GUERRA', '42235813', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '42235813', '902407545', 18, '', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (621, 'ROBERT', 'GUEVARA HUAMAN', '01125140', '$2a$07$asxx54ahjppf45sd87a5auyz1iGz9XoCCyZz/Drt7K538AASsh.M.', '1', '01125140', '942066646', 18, 'rohuaman@unsm.edu.pe', '', 1, '2022-08-26', '2024-07-18 15:52:48', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (622, 'LINDER', 'HIDALGO MIRANDA', '01123433', '$2a$07$asxx54ahjppf45sd87a5aupuUATSjJFD59daGq24GvACDahHdVLcW', '1', '01123433', '942878634', 18, 'lhidalgo@unsm.edu.pe', '', 1, '2022-07-19', '2024-06-27 15:08:36', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (623, 'LLULI', 'INSAPILLO SANGAMA', '40041108', '$2a$07$asxx54ahjppf45sd87a5auLPP28eei6eDLxBL2bJZeuGM8v0vtcdG', '1', '40041108', '969933193', 18, 'llusangama@unsm.edu.pe', '', 1, '2022-08-16', '2024-07-09 12:50:07', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (624, 'JACKSON IGNACIO', 'ISUIZA ISUIZA', '46529766', '$2a$07$asxx54ahjppf45sd87a5auy6Az1f73ylQmgHcqDGk89EUau6RCX3C', '1', '46529766', '', 18, '', '', 1, '2024-01-31', '2024-08-29 14:27:23', NULL, '2023-10-31 09:10:52', NULL);
INSERT INTO `usuario` VALUES (625, 'SIMON YESSE', 'JIMENEZ GUEVARA', '01084825', '$2a$07$asxx54ahjppf45sd87a5auWZeRAfZRGdS80NOxYQhrHqA3fVlZl0O', '1', '01084825', '940244540', 18, '', '', 1, '2022-09-03', '2024-04-05 12:34:37', NULL, '2024-01-12 08:46:18', NULL);
INSERT INTO `usuario` VALUES (626, 'TOÑO MICKEY', 'LAULATE FASABI', '42445433', '$2a$07$asxx54ahjppf45sd87a5auiD.BH9D1h2gr91yc/VKUojkHtmWGWw2', '1', '42445433', '987173966', 18, 'mickfasabi@unsm.edu.pe', '', 1, '2022-08-19', '2024-05-30 08:24:50', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (627, 'AUGUSTO YSAIAS', 'LINAREZ MELENDEZ', '00883241', '$2a$07$asxx54ahjppf45sd87a5auyWUncp/Rbo81TPkEowWcg5upHzKeLEm', '1', '00883241', '948477432', 18, 'gustolinarez@unsm.edu.pe', '', 1, '2022-05-08', '2024-07-10 10:37:23', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (628, 'JOSE', 'LOMAS SALAS', '01073999', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01073999', '999764873', 18, 'josalas@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (629, 'MAYRA MAYSI', 'LOPEZ DAVILA', '70084088', '$2a$07$asxx54ahjppf45sd87a5auCHy.13bS0X/knxIBwWG5tLBz1engQLq', '1', '70084088', '959951427', 18, 'mlopezd@unsm.edu.pe', '', 1, '2023-03-07', '2024-08-14 07:07:31', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (630, 'ANDY ROMAN', 'MARINA AREVALO', '01090466', '$2a$07$asxx54ahjppf45sd87a5aulpukpfXCk6wKGOxdnZuYxC8W5tNF5m.', '1', '01090466', '939087247', 18, 'andymarina@unsm.edu.pe', '', 1, '2022-07-26', '2024-03-21 14:21:03', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (631, 'VICTOR RAUL', 'MATICORENA ALVARADO', '42503076', '$2a$07$asxx54ahjppf45sd87a5auCecIv7FoLoeYm4lxayldtnkzWyMrTni', '1', '42503076', '976433575', 18, 'vrmaticorena@unsm.edu.pe', '', 1, '2022-05-18', '2024-05-29 18:05:33', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (632, 'MAX HENRY', 'MOZOMBITE TENAZOA', '01119796', '$2a$07$asxx54ahjppf45sd87a5auRsIrRwy4vi7dI0F.iGY4CW.FdDFFuqy', '1', '01119796', '', 18, '', '', 1, '2023-02-15', '2024-09-11 11:14:25', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (633, 'LEIDY DIANA', 'NAJAR VALDIVIESO', '45865129', '$2a$07$asxx54ahjppf45sd87a5aux9qIeBLJMm6St/eVstF22RSEfcNQD6y', '1', '45865129', '956724256', 18, 'ldnajarvaldivieso@unsm.edu.pe', '', 1, '2023-04-03', '2024-02-20 07:53:01', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (634, 'LUIS FERNANDO', 'NAVARRO MENDOZA', '70880887', '$2a$07$asxx54ahjppf45sd87a5audp1zIhLv2eglNNGQAFe1MCckU5xsHQG', '1', '70880887', '954172128', 18, '', '', 1, '2022-09-01', '2024-08-08 10:55:50', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (635, 'GLORIA LIBERTAD', 'ORBE CHOTA', '01147367', '$2a$07$asxx54ahjppf45sd87a5auLmYLKvYR4Tt4YGgxfmtzWPOnewC0Uia', '1', '01147367', '964711860', 18, 'glorbec@unsm.edu.pe', '', 1, '2022-11-10', '2024-08-14 11:45:53', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (636, 'ROLANDO', 'PANDURO GONZALES', '44366009', '$2a$07$asxx54ahjppf45sd87a5aurYLeh9ghem0xKNUi47lPqN9w8zVREdy', '1', '44366009', '918460731', 18, 'rolagonzales@unsm.edu.pe', '', 1, '2024-01-27', '2024-09-05 15:22:25', NULL, '2023-10-27 08:58:03', NULL);
INSERT INTO `usuario` VALUES (637, 'PAOLO PATRICIO', 'PHILIPPS AREVALO', '43583651', '$2a$07$asxx54ahjppf45sd87a5auYzg6saslA/jZXQPJ1bV01WiUgrSFGH.', '1', '43583651', '944364350', 18, 'pphilippsa@unsm.edu.pe', '', 1, '2022-08-31', '2024-05-23 16:10:03', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (638, 'LUIS', 'PINCHI MURRIETA', '01118957', '$2a$07$asxx54ahjppf45sd87a5auZCLPyxje2SlezUyVac/QA4V9F2oU5iC', '1', '01118957', '970481187', 18, 'lumurrieta@unsm.edu.pe', '', 1, '2022-09-01', '2024-08-13 16:33:58', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (639, 'LILIAM KARINA', 'PINCHI VARGAS', '71558686', '$2a$07$asxx54ahjppf45sd87a5auKnkyqJjw5xHPMB1EGgM4Jd0r7b1dO3u', '1', '71558686', '955651944', 18, 'liliampvargas@unsm.edu.pe', '', 1, '2022-07-06', '2024-08-27 18:12:19', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (640, 'ROY', 'PINEDO PINEDO', '01162663', '$2a$07$asxx54ahjppf45sd87a5auUnu20Gf7Xwk/Q7KFkzq4eMuvK6sgmPS', '1', '01162663', '942628660', 18, 'ropinedo@unsm.edu.pe', '', 1, '2022-06-14', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (641, 'RAFAEL RANCIS', 'PINEDO RAMIREZ', '01124657', '$2a$07$asxx54ahjppf45sd87a5auOrXM14zjIEmcppmA5qKuR5Xo2YL2Fry', '1', '01124657', '951770583', 18, 'rrpinedor@unsm.edu.pe', 'jr. alegria arias de morey nª530', 1, '2022-05-14', '2024-07-24 10:00:48', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (642, 'SANDRA PAOLA', 'PINEDO RAMIREZ', '42508834', '$2a$07$asxx54ahjppf45sd87a5au8J.eBF7jsGxY0aR2E61mdPgXBkBYT42', '1', '42508834', '942307611', 18, 'sandrapaola@unsm.edu.pe', '', 1, '2022-05-18', '2024-09-03 14:22:29', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (643, 'VERÓNICA', 'PÉREZ PANDURO', '42944648', '$2a$07$asxx54ahjppf45sd87a5au6mjOilns0HMRHYEfPOVQJgA58AwItRq', '1', '42944648', '968684658', 18, '', '', 1, '2022-05-08', '2024-06-06 09:34:52', NULL, '2023-07-13 09:02:36', NULL);
INSERT INTO `usuario` VALUES (644, 'RAFAEL', 'RAMIREZ AMASIFUEN', '40382353', '$2a$07$asxx54ahjppf45sd87a5aukNIR4o.mXyg7mJNOXOI2ksGoz.7eItu', '1', '40382353', '943949348', 18, 'rafaramirez@unsm.edu.pe', '', 1, '2022-09-01', '2024-03-30 12:21:55', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (645, 'JAIME', 'RAMIREZ GARCIA', '01118470', '$2a$07$asxx54ahjppf45sd87a5aubI8GYb/Q4GRfWg0QYTkRkIByYyYnEMO', '1', '01118470', '952049971', 18, 'jaigarcia@unsm.edu.pe', '', 1, '2022-05-15', '2024-09-03 14:18:13', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (646, 'JAVIER', 'RAMIREZ GARCIA', '01063803', '$2a$07$asxx54ahjppf45sd87a5aufQT297IgqCabMAyQNsofDGhMAzt/z/u', '1', '01063803', '945698566', 18, 'javgarcia@unsm.edu.pe', '', 1, '2022-08-05', '2024-09-09 16:39:32', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (647, 'ELIAS', 'RAMIREZ SOLIS', '10015280', '$2a$07$asxx54ahjppf45sd87a5auRiyRKKSbgqegeQIE0fIpFcXQkHiKBAG', '1', '10015280', '', 18, '', '', 1, '2023-02-17', '2024-07-27 10:53:05', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (648, 'GENARO', 'RAMÍREZ PINCHI', '75616081', '$2a$07$asxx54ahjppf45sd87a5aujSTPdOpvIRhc7OhJfyNygePCk1c0Jxe', '1', '75616081', '926591178', 18, '', '', 1, '2022-08-03', '2023-11-06 10:37:24', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (649, 'SABITH', 'RENGIFO LUNA', '41410516', '$2a$07$asxx54ahjppf45sd87a5au4qbhS0jmjf1yBI4yV08Uk0MtJDlJJsC', '1', '41410516', '942676822', 18, 'srengifol@unsm.edu.pe', '', 1, '2022-09-03', '2024-08-27 18:50:34', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (650, 'JOSE ENRIQUE', 'REYES CULQUI', '72707687', '$2a$07$asxx54ahjppf45sd87a5auiCopHeLitPYPLAIvQjhbzsMT3qc2HI6', '1', '72707687', '944924283', 18, 'jereyesc@unsm.edu.pe', '', 1, '2024-05-01', '2024-02-01 08:08:25', NULL, '2024-02-01 08:08:15', NULL);
INSERT INTO `usuario` VALUES (651, 'GEMMA DALILA', 'REYES RAMIREZ', '45230545', '$2a$07$asxx54ahjppf45sd87a5aulwDLhwBDcIVrhHcZNyOpy8XTrhHU.wa', '1', '45230545', '(042) 52-6008', 18, 'gemareyes27@hotmail.com', '', 1, '2022-05-18', '2023-07-07 12:05:32', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (652, 'CRISTIAN MIGUEL', 'RIOS MONTES', '43196060', '$2a$07$asxx54ahjppf45sd87a5aua1hEHd6x1BVMQAF35QnPyWfgBt5Lcnm', '1', '43196060', '956207314', 18, '', '', 1, '2022-09-01', '2024-01-25 21:49:35', NULL, '2024-01-25 11:31:57', NULL);
INSERT INTO `usuario` VALUES (653, 'GUSTAVO', 'RIOS PANDURO', '10063522', '$2a$07$asxx54ahjppf45sd87a5aulqaGb20jxj3haWhaVuFiGe7XqFLWL.y', '1', '10063522', '932646231', 18, 'griospanduro@unsm.edu.pe', '', 1, '2022-08-27', '2024-06-27 13:02:04', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (654, 'CYNTHIA XIMENA', 'RIOS YALTA', '46516863', '$2a$07$asxx54ahjppf45sd87a5augrUPLjqtMF9BvAKHoYviGogXpy1z3ba', '1', '46516863', '951687941', 18, 'cxriosy@unsm.edu.pe', '', 1, '2022-05-10', '2024-08-08 08:00:52', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (655, 'JOSE LUIS', 'RODRIGUEZ ABAD', '45687863', '$2a$07$asxx54ahjppf45sd87a5auDPnY8pytRD.DaCcgnBVcRVBigoYlUUy', '1', '45687863', '981639781', 18, '', '', 1, '2023-04-16', '2024-07-25 16:37:23', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (656, 'ANN AMMIE', 'RODRIGUEZ ANGULO', '43928662', '$2a$07$asxx54ahjppf45sd87a5aucnmfeKkKRcw6qKilyCXCXTnko0cYeWS', '1', '43928662', '949500764', 18, 'aarodriguez@unsm.edu.pe', '', 1, '2022-05-07', '2024-09-09 15:34:30', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (657, 'NEIL', 'RODRIGUEZ SANCHEZ', '01117144', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01117144', '942306608', 18, 'neilrodriguez@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (658, 'MANUEL ANGEL', 'ROJAS TORRES', '47137209', '$2a$07$asxx54ahjppf45sd87a5auNeAH9PZa0uV606gWbpK0HX.9/bz0HJC', '1', '47137209', '942621894', 23, 'dmanuelrojas@unsm.edu.pe', '', 1, '2022-05-11', '2024-09-10 11:11:26', NULL, '2024-02-22 11:16:07', NULL);
INSERT INTO `usuario` VALUES (659, 'MARIA ESTHER', 'ROJAS TORRES', '42386035', '$2a$07$asxx54ahjppf45sd87a5aubhIOQJujakgFS8wAVPi8VlBFWhoNcTS', '1', '42386035', '975475856', 18, 'merojastorres@unsm.edu.pe', '', 1, '2023-02-18', '2024-02-22 07:33:30', NULL, '2023-11-03 07:25:59', NULL);
INSERT INTO `usuario` VALUES (660, 'MILAGRO', 'RUIZ MIRANO', '40360247', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '40360247', '950825682', 18, 'mruizm@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (661, 'JUSSARA MARGARITA', 'RUIZ ORBE', '46698650', '$2a$07$asxx54ahjppf45sd87a5aumG1QuX7gE.iz.EnqQQ6AMrSLV5UfmIC', '1', '46698650', '920538818', 18, 'apresupuestal@unsm.edu.pe', '', 1, '2022-05-07', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (662, 'OLIARTE RICARDO', 'RUIZ RIOS', '40184610', '$2a$07$asxx54ahjppf45sd87a5auuKbsW8HqzpR/cB8mVwb5U.8NF6aZHB2', '1', '40184610', '964865071', 18, 'olirios@unsm.edu.pe', '', 1, '2022-08-27', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (663, 'VILQUIN', 'SAAVEDRA GRANDEZ', '01120599', '$2a$07$asxx54ahjppf45sd87a5auQl/kZZ5mlmUYT..RJ2sCaAMGAXRbUyW', '1', '01120599', '948029343', 18, 'vilgrandez@unsm.edu.pe', '', 1, '2022-08-09', '2024-07-30 19:35:42', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (664, 'JAMES', 'SAAVEDRA VELASCO', '01123400', '$2a$07$asxx54ahjppf45sd87a5auIV1sN5so9UOyq8ndqUH0cs4ywTOO3C2', '1', '01123400', '963394142', 18, '', '', 1, '2023-02-28', '2024-09-10 08:02:51', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (665, 'WILMER JOSE', 'SALAZAR GAMONAL', '16789197', '$2a$07$asxx54ahjppf45sd87a5auJXHWwuLX0pusw5liDW.sCAaS3.bMrRu', '1', '16789197', '982977363', 18, 'wilgamonal@unsm.edu.pe', '', 1, '2022-09-01', '2024-03-15 11:54:48', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (666, 'JUANA YSABEL', 'SALDAÑA SAAVEDRA', '18099865', '$2a$07$asxx54ahjppf45sd87a5au2t5G001SQlvJ9NrMFHgl70bjwaznK2C', '1', '18099865', '957613639', 18, 'jysaldanas@unsm.edu.pe', '', 1, '2023-07-25', '2024-06-09 17:18:44', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (667, 'SILVIA', 'SALINAS PEREZ DE MORALES', '00964916', '$2a$07$asxx54ahjppf45sd87a5au1OvEjc2hpNCM4nsKBPhKHgcK2FtA1Ce', '1', '00964916', '977363090', 18, 'simorales@unsm.edu.pe', '', 1, '2022-05-19', '2024-08-05 17:23:57', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (668, 'SEGUNDO RUSBER', 'SANDOVAL VALERA', '41418544', '$2a$07$asxx54ahjppf45sd87a5aue9Hofl6HR.6BdS2wCyIeRLKbitcE6TG', '1', '41418544', '920185115', 18, 'segvalera@unsm.edu.pe', '', 1, '2022-09-01', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (669, 'JESSICA', 'SILVA MACEDO', '80534786', '$2a$07$asxx54ahjppf45sd87a5au6b24dOBNQAQ0Ez1WekCXu0tTvBfuCLO', '1', '80534786', '948520159', 18, 'jsilva@unsm.edu.pe', '', 1, '2022-05-07', '2024-03-13 10:58:44', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (670, 'MELIS', 'TENAZOA SALAS', '01128574', '$2a$07$asxx54ahjppf45sd87a5au7etsQEx241mfXv4e2QaAGMbe.F53B02', '1', '01128574', '948886399', 18, 'mesalas@unsm.edu.pe', '', 1, '2022-07-04', '2024-08-01 08:35:05', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (671, 'CARLOS MAGNO', 'TORREJON RODRIGUEZ', '42176217', '$2a$07$asxx54ahjppf45sd87a5au9Dp3S8uPHaOPXNSlCIEzHQ16CT/lExy', '1', '42176217', '945100791', 18, 'carlosmtr@unsm.edu.pe', '', 1, '2023-03-05', '2024-08-26 12:36:29', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (672, 'EDILTER', 'TORRES DAVILA', '01092201', '$2a$07$asxx54ahjppf45sd87a5auG13nh7raS2oMy6oEMcf.KEe8ZmtkubC', '1', '01092201', '927560868', 18, 'edidavila@unsm.edu.pe', '', 1, '2022-12-21', '2024-07-03 12:58:58', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (673, 'OSCAR MARTIN', 'TORRES DEL AGUILA', '10224039', '$2a$07$asxx54ahjppf45sd87a5au2AVw9/Liatn2A2KqzQn.JYhDajceezm', '1', '10224039', '942458875', 18, '', '', 1, '2022-11-22', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (674, 'RAFAEL MARTÍN', 'TORRES SAAVEDRA', '72488054', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '72488054', '989667560', 18, 'rmtorres@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (675, 'RAULISON LECBACSER', 'TORRES TANGOA', '10432881', '$2a$07$asxx54ahjppf45sd87a5auuJbYMfHRQ7SHgYhMTilKbgxvTJPaEZm', '1', '10432881', '961998516', 18, 'rautangoa@unsm.edu.pe', '', 1, '2022-07-19', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (676, 'KELITA', 'UPIACHIHUA FASANANDO', '45287102', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '45287102', '', 18, '', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (677, 'JOISE', 'UPIACHIHUA RODRIGUEZ', '01101463', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01101463', '966682211', 18, 'josrodriguez@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (678, 'ROLANDO', 'URQUIA PINCHI', '01101260', '$2a$07$asxx54ahjppf45sd87a5auiLqfCRXUk7hAbTeh4.xgnWczzcD/tKS', '1', '01101260', '973607987', 18, 'rolpinchi@unsm.edu.pe', '', 0, '2022-05-05', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (679, 'SILAS', 'VALLES CHUJUTALLI', '43162417', '$2a$07$asxx54ahjppf45sd87a5au9PiSd2XRTlUsTgeqdHldKSbv5rdpbx2', '1', '43162417', '926183382', 18, '', '', 1, '2024-09-19', '2024-08-09 11:46:09', NULL, '2024-06-19 11:36:41', NULL);
INSERT INTO `usuario` VALUES (680, 'VIDMER', 'VIENA FLORES', '25832377', '$2a$07$asxx54ahjppf45sd87a5aunXKYErKarA56/Lq/5xcS1sUjiqHLsYy', '1', '25832377', '971990776', 18, '', '', 1, '2022-09-27', '2024-07-04 11:04:21', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (681, 'RUT', 'VILLACREZ MEDINA', '72457306', '$2a$07$asxx54ahjppf45sd87a5auTnqAY.uPO2JAD1fQN91rrug.s03jse.', '1', '72457306', '947410734', 18, 'revillacrez@unsm.edu.pe', '', 1, '2022-05-11', '2024-08-20 10:17:38', NULL, '2024-08-20 09:13:59', NULL);
INSERT INTO `usuario` VALUES (933, 'Julian', 'Vasquez Arevalo', '01135196', '$2a$07$asxx54ahjppf45sd87a5auwJZ8y.hpX6lZvRnQXjym4soDa3jeqZ.', '1', '01135196', '910571635', 18, 'julian29091968@gmail.com', 'Jr.Micaela Bastidas 481', 1, '2022-05-07', '2023-12-07 14:24:50', NULL, '2023-08-02 09:11:24', NULL);
INSERT INTO `usuario` VALUES (934, 'SONIA ELIZABETH', 'SALAZAR VEGA DE SOUSA', '01109069', '$2a$07$asxx54ahjppf45sd87a5auwgospC/Dv3/8NlmJ8PVkeOzRIgfOGf6', '1', '01109069', '', 18, '', '', 1, '2022-05-10', '2024-08-12 00:03:38', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (935, 'Jose Javier', 'Tuanama Aguilar', '46376184', '$2a$07$asxx54ahjppf45sd87a5auV0QcqSvsv0OFZqyFZXDLDlXN2/HSI42', '1', '46376184', '', 18, '', '', 1, '2022-05-11', '2024-09-12 09:40:20', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (936, 'Fiorella', 'Vela', '73014708', '$2a$07$asxx54ahjppf45sd87a5auE3UC.pxZbOxsvKGlrw3/bjm3d0UO36C', '1', '73014708', '', 18, '', '', 1, '2022-05-11', '2024-07-16 13:41:36', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (937, 'Richard', 'Isuiza satalaya', '75402667', '$2a$07$asxx54ahjppf45sd87a5auvFGneI9TI4oUaad7SRopxI2sT8e.Q1e', '1', '75402667', '', 18, '', '', 1, '2022-05-14', '2024-07-30 12:24:35', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (938, 'AIMETH DEL PILAR', 'SINARAHUA SALAS', '42871017', '$2a$07$asxx54ahjppf45sd87a5auMbiCttuuolaOosrnJj4Mb8bdo0qng16', '1', '42871017', '', 18, '', '', 1, '2022-05-15', '2024-02-05 09:38:11', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (939, 'Adolfo', 'Fasanando Pezo', '01066409', '$2a$07$asxx54ahjppf45sd87a5auSKeOsa1/.7bEYmB3dMgNEJB51qAjsMO', '1', '01066409', '', 18, '', '', 1, '2022-05-15', '2023-09-16 09:04:55', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (940, 'a', 'p', '55556666', '$2a$07$asxx54ahjppf45sd87a5auQAZxs3iDcEbJiS.N.ZamOleAKaH/hXm', '0', '55556666', '', 18, '', '', 1, '2022-05-15', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (941, 'Manuel Fernando', 'Sandy Sanchez', '46736285', '$2a$07$asxx54ahjppf45sd87a5auusKNfcPYPfrRO0tvcWP6fm0t6TmUR9W', '1', '46736285', '', 18, '', '', 1, '2022-05-17', '2024-08-22 09:49:03', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (942, 'Rosa', 'Ramirez Garcia', '01062125', '$2a$07$asxx54ahjppf45sd87a5au2a6acmzFwqfILVeKOV4pgd3uLENiPYy', '1', '01062125', '', 18, '', '', 1, '2022-05-18', '2024-09-03 14:21:38', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (943, 'RIDLER KEITH', 'GARCIA HERRERA', '41720531', '$2a$07$asxx54ahjppf45sd87a5aubXpdRVxsi2yTarMsabOkwDV3dIGjqY2', '1', '41720531', '948 777 180', 18, '', '', 1, '2022-05-22', '2024-07-10 10:03:39', NULL, '2024-03-19 13:57:55', NULL);
INSERT INTO `usuario` VALUES (944, 'Zoila', 'Mestanza Flores', '01063724', '$2a$07$asxx54ahjppf45sd87a5auQ06lA0L7dFeYcm/4EYsMxe8EmUtQqiW', '1', '01063724', '', 18, '', '', 1, '2022-05-23', '2024-09-03 10:35:37', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (945, 'Manuel', 'Rojas Tasillo', '01110837', '$2a$07$asxx54ahjppf45sd87a5auaa5v/U./hGHVhZitPlXnxDCtcUQKHbG', '1', '01110837', '', 18, '', '', 1, '2022-05-23', '2024-03-04 12:03:10', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (946, 'ROSSANA HERMINIA', 'HIDALGO POZZI', '07618465', '$2a$07$asxx54ahjppf45sd87a5aubb238.SrMj51scWpA7QDX8a9ugCjd4K', '1', '07618465', '', 18, '', '', 1, '2022-05-24', '2024-07-09 13:04:13', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (947, 'Jorge', 'Torres delgado', '01146224', '$2a$07$asxx54ahjppf45sd87a5auakgPK79A5hS4TvAagouw5782kM9gH.K', '1', '01146224', '', 18, '', '', 1, '2022-05-25', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (948, 'Clidy', 'Santa Cruz Suarez', '01174047', '$2a$07$asxx54ahjppf45sd87a5auWqLeMD.36njL6VOVNvPWF13YI1dur0.', '1', '01174047', '', 18, '', '', 1, '2022-06-10', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (949, 'Jessica', 'Celiz Culqui', '45917850', '$2a$07$asxx54ahjppf45sd87a5auWm1f.GHnXdU8TVgpdEYh7xZcjNtrGiK', '1', '45917850', '', 18, '', '', 1, '2022-06-10', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (950, 'Efren', 'Escobedo', '75053098', '$2a$07$asxx54ahjppf45sd87a5aujjt9JFZMB6cuatkaJl0X9qzfyN5O5WK', '0', '75053098', '', 18, '', '', 1, '2022-06-10', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (951, 'Reynaldo Alcides', 'Campoblanco Virhuez', '01068815', '$2a$07$asxx54ahjppf45sd87a5auY/3zDt/WRoiiccntV3LEUsBvBE.8kra', '1', '01068815', '', 18, '', '', 1, '2022-06-10', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (952, 'KLEISER CAMALICH', 'GUERRERO GARCIA', '41137233', '$2a$07$asxx54ahjppf45sd87a5auUMtZzp7pRP1rbOpvkInpui5wta0E.Da', '1', '41137233', '', 18, '', '', 1, '2022-06-10', '2024-08-26 22:00:42', NULL, '2024-03-08 18:06:07', NULL);
INSERT INTO `usuario` VALUES (953, 'RAY ', 'BARRERA ZEGARRA', '44454456', '$2a$07$asxx54ahjppf45sd87a5au1XzTajj.Yl7ULMVxYSAucSXsyQkxoNe', '1', '44454456', '', 18, '', '', 1, '2022-06-24', '2023-12-20 16:02:50', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (954, 'JODY', 'PANDURO ROMERO', '42969259', '$2a$07$asxx54ahjppf45sd87a5auFlCnVoPFvyVg7n5TN1nUS5fjYEa9J4.', '1', '42969259', '', 18, '', '', 1, '2022-06-25', '2024-02-06 22:22:51', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (955, 'MARILIA', 'Macedo Dominguez', '46384118', '$2a$07$asxx54ahjppf45sd87a5auj2QAUZ0cWh6PKrJew/TQkG833AaTmbi', '1', '46384118', '', 22, '', '', 1, '2022-06-28', '2024-03-11 11:12:23', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (956, 'Anita', 'Linares Bensimon', '01066413', '$2a$07$asxx54ahjppf45sd87a5au4CBIQfXY3xYBPdiHDIAqUMf/seeYkiS', '1', '01066413', '', 18, '', '', 1, '2022-07-01', '2024-03-14 08:16:31', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (957, 'Clever', 'Sanchez Gonzales', '01074346', '$2a$07$asxx54ahjppf45sd87a5auYDVtNnA1FeFJHrW5sDVIjd8UqY4O.em', '1', '01074346', '', 18, '', '', 1, '2022-07-04', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (958, 'Frank Daniel', 'Ramirez Samgama', '44999209', '$2a$07$asxx54ahjppf45sd87a5auCWJ57nf8Y4P/XO25ODA7/SQ6cV2Pzma', '1', '44999209', '', 18, '', '', 1, '2022-07-07', '2024-07-30 11:37:03', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (959, 'Tanit', 'Torres Tuanama', '40439521', '$2a$07$asxx54ahjppf45sd87a5auuE0PL96du5cJWMfWLry5vxgaQyNoEF6', '1', '40439521', '', 18, '', '', 1, '2022-07-07', '2024-01-15 10:27:33', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (960, 'Tania Ciurlisa ', 'Saavedra de la Cruz', '46050425', '$2a$07$asxx54ahjppf45sd87a5auzkh3EhGDglVH7QMg3NDUNNYKSdoJW5u', '1', '46050425', '', 18, '', '', 1, '2022-07-07', '2024-04-04 12:11:35', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (961, 'ELIANA MARCELA', 'VELEZ ERAZO', '04681331', '$2a$07$asxx54ahjppf45sd87a5aufCVs7p3bo4Cb6hVVlCoVUHM3g442i2G', '1', '04681331', '914068669', 19, 'evelezer@unsm.edu.pe', '', 1, '2022-07-20', '2023-09-08 12:34:32', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (962, 'Mariano', 'Chavez Bazan', '01117903', '$2a$07$asxx54ahjppf45sd87a5auyKUYMuSUFqvrjb5tPNgZdy0YMNjaawC', '1', '01117903', '', 18, '', '', 1, '2022-07-25', '2024-07-22 14:21:47', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (963, 'BILLY JOSEFF', 'GONZALES VELA', '45873271', '$2a$07$asxx54ahjppf45sd87a5au7XQVTCjGSAhag8sL74xRjEff1X5rn3O', '1', '45873271', '975015534', 18, 'bjgonzalesvela@unsm.edu.pe', '', 1, '2022-07-25', '2024-09-05 10:37:22', NULL, '2023-11-28 07:30:36', NULL);
INSERT INTO `usuario` VALUES (964, 'Silvestre', 'Quintana Pumachoque', '24993798', '$2a$07$asxx54ahjppf45sd87a5auAOQnlsyVzIUmdMNcKrVTxS052xI2AaG', '1', '24993798', '', 18, '', '', 1, '2022-07-25', '2024-09-11 00:09:58', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (965, 'Caisedo ', 'Silva tocto', '43106566', '$2a$07$asxx54ahjppf45sd87a5au6ZGZXTymC3n3Ph5AZvXRmY4Euu/80/q', '1', '43106566', '', 18, '', '', 1, '2022-07-26', '2023-08-01 08:00:35', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (966, 'Gilberto', 'Vasquez Yalta', '01148903', '$2a$07$asxx54ahjppf45sd87a5auAjQggG9c8LLNyqPfvPIJreHhsivRbIa', '1', '01148903', '', 18, '', '', 1, '2022-07-26', '2024-09-08 21:07:20', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (967, 'Julio', 'Amasifuen Amasifuen', '00950904', '$2a$07$asxx54ahjppf45sd87a5auTtF4SV940tfQNDSRYSzVhBsf4bfVNpS', '1', '00950904', '983444331', 18, '', 'tarapoto', 1, '2022-07-26', '2024-09-08 22:20:11', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (968, 'EDMAN JUNIOR', ' SILVA HUAMANTUMBA', '45834373', '$2a$07$asxx54ahjppf45sd87a5aul.sHkMxHmQ1NVOf76t/jPFdZmUEs4RK', '1', '45834373', '', 18, '', '', 1, '2022-07-27', '2024-02-13 11:42:50', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (969, 'OSCAR', 'RUIZ FLORES', '01073157', '$2a$07$asxx54ahjppf45sd87a5auwpUWD/FEHTBU13eWJ1M2ZzlZ9U4v/Gy', '1', '01073157', '', 18, 'usuario@unsm.edu.pe', '', 1, '2022-07-28', '2023-11-08 14:54:25', NULL, '2023-09-11 14:13:29', NULL);
INSERT INTO `usuario` VALUES (970, 'Luciola', 'Tuanama', '01143811', '$2a$07$asxx54ahjppf45sd87a5aupENI/wyKo./5hTor0KBNDTbCvSJkSzy', '1', '01143811', '', 18, '', '', 1, '2022-08-04', '2024-09-05 19:41:34', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (971, 'Pedro', 'CARBAJAL', '44956682', '$2a$07$asxx54ahjppf45sd87a5au.HXBLMo.rNRZ.zna3V6/HiA1/GqSxYS', '1', '44956682', '', 18, '', '', 1, '2022-08-04', '2024-07-19 05:39:11', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (972, 'GIDIER', 'Lopez Davila', '44280340', '$2a$07$asxx54ahjppf45sd87a5auQ9KdKRQtqahbgtLxKAItpxRchAZEZZ6', '1', '44280340', '', 18, '', '', 1, '2022-08-11', '2024-04-10 12:04:09', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (973, 'LUIS ARMANDO', 'CUZCO TRIGOZO', '01127359', '$2a$07$asxx54ahjppf45sd87a5auegtiRuA.n7B64JJqjyU/jV5XnTSFb4e', '1', '01127359', '', 18, '', '', 1, '2022-08-18', '2024-09-03 15:54:06', NULL, '2023-07-31 13:31:47', NULL);
INSERT INTO `usuario` VALUES (974, 'YRWIN FRANCISCO', 'AZABACHE LIZA', '11111122', '$2a$07$asxx54ahjppf45sd87a5au43Iwejpc9IlNHsVBDdThvBPh74EvU3u', '0', '11111122', '', 18, '', '', 0, '2022-05-18', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (975, 'MIKE ANDERSON', 'CORAZON GUIVIN', '43081158', '$2a$07$asxx54ahjppf45sd87a5auzTeycQpMJeRxjxUZAYSYBhrf1fyouLS', '1', '43081158', '', 18, '', '', 1, '2022-08-24', '2024-09-09 21:49:23', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (976, 'JHON JAIRO', 'LOPEZ ROJAS', '43672261', '$2a$07$asxx54ahjppf45sd87a5autwDzSG5wJsVx9hyispH/LFAIDonI27e', '1', '43672261', '', 18, '', '', 1, '2022-08-30', '2024-09-09 17:47:20', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (977, 'STÁNLER', 'IRIGOÍN VÁSQUEZ', '41519947', '$2a$07$asxx54ahjppf45sd87a5auoGcDqiLAFl4X6n0uF3aYlwMCju1Y9Ja', '1', '41519947', '', 18, '', '', 1, '2022-08-30', '2024-07-05 12:27:47', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (978, 'DIGNA FLOR', 'RODRIGUEZ PINCHI', '41927232', '$2a$07$asxx54ahjppf45sd87a5ausg21MAtSGJK7hUmoTE9Lkhtk/GWw1ei', '1', '41927232', '', 18, '', '', 1, '2022-09-06', '2024-08-09 14:25:02', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (979, 'LUIS ANGEL', 'MONTILLA TUESTA', '41626966', '$2a$07$asxx54ahjppf45sd87a5auNnixL5hm6Co4WN1nhNBL4uSwhph7O1O', '1', '41626966', '', 18, '', '', 1, '2022-09-06', '2023-08-08 08:42:09', NULL, '2023-08-08 08:42:03', NULL);
INSERT INTO `usuario` VALUES (980, 'JUAN GABRIEL', 'PEÑA ARCE', '01146075', '$2a$07$asxx54ahjppf45sd87a5auHfCLXzQUZPNnTETgXP2PnYmw8A1JIze', '1', '01146075', '', 18, '', '', 1, '2023-03-20', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (981, 'SARA ', 'GARCIA CABALLERO', '01094682', '$2a$07$asxx54ahjppf45sd87a5aueY32A1dlKZAx2v9DZ22nFRIwLk6lKKS', '1', '01094682', '', 18, '', '', 1, '2024-06-14', '2024-03-14 11:10:33', NULL, '2024-03-14 11:10:13', NULL);
INSERT INTO `usuario` VALUES (982, 'NATALI', 'SANCHEZ ISUIZA', '46938422', '$2a$07$asxx54ahjppf45sd87a5auucS/CyniUZ2oYYkOwLZ80a9J0SoeQVC', '1', '46938422', '', 18, '', '', 1, '2022-09-07', '2024-03-11 12:29:47', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (983, 'HELEN LLEYDY', 'MACEDO FLORES', '72044267', '$2a$07$asxx54ahjppf45sd87a5auz7Wn1Qn8z2VH0CqIH7djhcQZA0jSfIy', '1', '72044267', '', 18, '', '', 1, '2022-09-07', '2024-02-01 21:51:59', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (984, 'CLAUDIA', 'LOPEZ AMAYO', '46997751', '$2a$07$asxx54ahjppf45sd87a5au.DwyrAkVi/xI8G1PhNH6n4Z9X2I2p8q', '1', '46997751', '', 18, '', '', 1, '2022-09-07', '2024-03-21 15:20:00', NULL, '2023-07-04 08:26:46', NULL);
INSERT INTO `usuario` VALUES (985, 'DEWI MARIA', 'FASANANDO UPIACHIHUA', '42859757', '$2a$07$asxx54ahjppf45sd87a5auGXdMoyc.YDOhe242zlqxIkjgr.prnSK', '1', '42859757', '', 18, '', '', 1, '2022-09-09', '2024-08-22 13:41:55', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (986, 'ALCIBIADEZ', 'GUEVARA DIAZ', '46849320', '$2a$07$asxx54ahjppf45sd87a5auS1731.y4Ajjcaf5.f3v63/kTGY9USja', '1', '46849320', '', 18, '', '', 1, '2022-09-08', '2024-02-28 07:23:32', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (987, 'CARLOS ALBERTO', 'SALDAÑA PINTO', '00885056', '$2a$07$asxx54ahjppf45sd87a5aug0UaZ8xHGATvmI41Gox2MVOUlgQAVai', '1', '00885056', '', 18, '', '', 1, '2022-09-14', '2024-09-02 15:35:06', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (988, 'CARLOS', 'MELGAR NEYRA', '01129124', '$2a$07$asxx54ahjppf45sd87a5auwMWZCpbZsYAi2EdQWuhXURwnUT6sMH.', '1', '01129124', '', 18, '', '', 1, '2022-09-16', '2024-02-23 10:19:21', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (989, 'ZULEMA', 'ROJAS VASQUEZ', '45064396', '$2a$07$asxx54ahjppf45sd87a5auPUS1VH7bjdLmVBGCmS2rtcxdn0necve', '1', '45064396', '', 18, '', '', 1, '2022-09-21', '2024-08-19 09:48:17', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (990, 'KAREN', 'REATEGUI VILLACORTA', '42519852', '$2a$07$asxx54ahjppf45sd87a5au/rJCY4.Y7eRcAleYHoQhvxtluf6nnqe', '1', '42519852', '969676323', 18, 'kreategui@unsm.edu.pe', 'Jr. Los Angeles N° 364', 1, '2022-09-22', '2024-04-12 10:14:37', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (991, 'DORIS', 'ROJAS CALLE', '43135750', '$2a$07$asxx54ahjppf45sd87a5auD6rjQMAF6ajasOqItOme/TbTaI81YZO', '1', '43135750', '', 18, '', '', 1, '2022-09-22', '2024-07-06 21:59:00', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (992, 'JIMMY', 'PACHERREZ RIVA', '40792629', '$2a$07$asxx54ahjppf45sd87a5auu5jPCzb.u4dwCqjSAKcVaUjbSRkoR/K', '1', '40792629', '', 18, '', '', 1, '2022-09-22', '2024-08-01 10:47:52', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (993, 'ORLANDO', 'TERRONES SUAREZ', '10618831', '$2a$07$asxx54ahjppf45sd87a5auuC18RwzZAvVA6zBmcUNf44zLkcchg4G', '1', '10618831', '', 18, '', '', 1, '2022-09-23', '2024-08-29 02:00:56', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (994, 'KAREN OLINDA', 'CASTRO MORI', '44517466', '$2a$07$asxx54ahjppf45sd87a5auwNIQ6iMCuKCtfbzmSzOTJ0qgz4JLmSq', '1', '44517466', '', 18, '', '', 1, '2022-09-27', '2024-06-03 14:15:31', NULL, '2023-11-27 12:41:47', NULL);
INSERT INTO `usuario` VALUES (995, 'ROGER RICARDO', 'RENGIFO AMASIFEN', '40842290', '$2a$07$asxx54ahjppf45sd87a5aupE9kDwrDXFKGHIRGgPaZz9haHjSBSam', '1', '40842290', '', 18, '', '', 1, '2022-09-27', '2023-12-14 13:50:46', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (996, 'FEDERICO', 'NUÑEZ SANCHEZ', '01073408', '$2a$07$asxx54ahjppf45sd87a5auwSBBA.2dzLRPGvGP8rwI5Q8o.Ud/NFa', '1', '01073408', '', 18, '', '', 1, '2022-09-30', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (997, 'VICTOR', 'CHAVEZ CANAL', '01104848', '$2a$07$asxx54ahjppf45sd87a5aurVdskDBkRp9UULgMWPnuxbFeiKgTh72', '1', '01104848', '', 18, '', '', 1, '2022-09-30', '2024-03-04 08:04:35', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (998, 'PATSSY JHOANA', 'AREVALO ARELLANO', '45829630', '$2a$07$asxx54ahjppf45sd87a5aun10214f2CLSmDmtxsy05/0SFUkX6TPq', '1', '45829630', '', 18, '', '', 1, '2022-10-01', '2024-08-07 11:07:18', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (999, 'HARRY', 'SAAVEDRA ALVA', '43248273', '$2a$07$asxx54ahjppf45sd87a5auAgX2KUlqVE5mx/eC3U0CMn9LUDqKlqO', '1', '43248273', '948905754', 18, '', '', 1, '2022-10-05', '2024-08-26 08:08:00', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1000, 'JOEL', 'FLORES FLORES', '01133583', '$2a$07$asxx54ahjppf45sd87a5auJMysdHaMPll2CjG2plWfMbra8Hare.2', '1', '01133583', '', 18, '', '', 1, '2022-10-07', '2024-05-29 16:46:44', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1001, 'WALTER JULIAN', 'GUTIERREZ ARCE', '80039395', '$2a$07$asxx54ahjppf45sd87a5auGG1osedQMQONssHbbeOs4KBS6RdNcou', '1', '80039395', '', 18, '', '', 1, '2022-10-12', '2024-06-06 16:20:25', NULL, '2024-05-28 13:47:46', NULL);
INSERT INTO `usuario` VALUES (1002, 'GEOMAR', 'VALLEJOS TORRES', '01162440', '$2a$07$asxx54ahjppf45sd87a5auIBOofZWgxTEC4.M6HRH5uHpWHvLPpBG', '1', '01162440', '956477477', 18, 'gvallejos@unsm.edu.pe', 'Prolongación san pablo de la cruz 229 - Tarapoto', 1, '2022-10-13', '2024-09-04 17:18:05', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1003, 'JOSE LUIS', 'PASQUEL REATEGUI', '43986976', '$2a$07$asxx54ahjppf45sd87a5aulXl6zjQWv.3Umt9v3vKMys/3hgPFT8i', '1', '43986976', '', 18, '', '', 1, '2022-10-15', '2024-08-29 16:46:08', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1004, 'IVAN HEISER', 'MEDINA SANCHEZ', '70056062', '$2a$07$asxx54ahjppf45sd87a5aufR7q1InDmNXVEHmJTKj5UIVmd6M5Dv6', '1', '70056062', '', 18, '', '', 1, '2022-10-21', '2024-06-06 11:26:27', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1005, 'JESSY', 'GONZALES PÉREZ', '01117500', '$2a$07$asxx54ahjppf45sd87a5au.lCd7hMohtmljw9YKljwPvzwRLsnbr2', '1', '01117500', '', 18, '', '', 1, '2022-10-21', '2024-09-01 16:42:29', NULL, '2024-04-02 14:01:50', NULL);
INSERT INTO `usuario` VALUES (1006, 'Ernie Augusto', 'Neyra', '46212450', '$2a$07$asxx54ahjppf45sd87a5auY86SZUAeoZtTVbjm59Uo2Ga.k13/aWy', '1', '46212450', '942817962', 18, 'eallanosn@unsm.edu.pe', 'JR ACHUAL N 151', 1, '2022-10-21', '2024-07-11 12:30:06', NULL, '2024-01-16 19:54:22', NULL);
INSERT INTO `usuario` VALUES (1007, 'SEGUNDO', 'MENDOZA RIOS', '00913452', '$2a$07$asxx54ahjppf45sd87a5auquNGAluZ1JlJS9mNQgxWNEFoRIaMTMa', '1', '00913452', '', 18, '', '', 1, '2022-11-01', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1008, 'Victor Luis', 'Rios del Aguila', '71719842', '$2a$07$asxx54ahjppf45sd87a5auXGuPNHAYS9y46owZIX/adZYVZwjscrq', '0', '71719842', '', 1, '', '', 1, '2022-11-02', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1009, 'ARLES', 'FASANANDO PINCHI', '45612451', '$2a$07$asxx54ahjppf45sd87a5auTsvS7p92sx95qKqgYpuhEPl9kFHCBhO', '1', '45612451', '', 18, '', '', 1, '2022-11-08', '2024-02-05 08:40:45', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1010, 'Bryan Orlando', 'Orbegoso Pezo', '74225337', '$2a$07$asxx54ahjppf45sd87a5au9Ne8TH9kFEUgWCzUMpH4LGhOGWiOmW6', '1', '74225337', '942424367', 17, 'ceveus@unsm.edu.pe', '...', 1, '2022-11-08', '2024-04-02 10:32:10', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1011, 'MIGUEL ANGEL', 'SALAZAR HIDALGO', '09762471', '$2a$07$asxx54ahjppf45sd87a5auSjjDPKMO7gV0UXdSUem6wZc5FX0dM2.', '1', '09762471', '', 18, '', '', 1, '2024-03-12', '2024-04-04 13:58:19', NULL, '2023-12-12 09:18:24', NULL);
INSERT INTO `usuario` VALUES (1012, 'YOLANDA', 'MARINA TULUMBA', '00818533', '$2a$07$asxx54ahjppf45sd87a5aunrDKdlOiWUHYWGSdBdyiDdUMTfrd0f.', '1', '00818533', '', 18, '', '', 1, '2022-11-10', '2024-09-04 13:29:36', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1013, 'JOSE IVAN', 'TUESTA ESTRELLA', '43348630', '$2a$07$asxx54ahjppf45sd87a5au4v5WIRf5NJ/B/mjmFoKp0aYKs9zbb3.', '1', '43348630', '', 18, '', '', 1, '2022-11-12', '2023-07-24 10:48:19', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1014, 'JOSE GABRIEL', 'SEIJAS DIAZ', '41216513', '$2a$07$asxx54ahjppf45sd87a5auoTuc3VDcIThosqm1oHLAjq14/6JcTk.', '1', '41216513', '', 18, '', '', 1, '2022-11-15', '2023-08-18 12:45:55', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1015, 'NATALY', 'HUAMAN MACEDO', '73424275', '$2a$07$asxx54ahjppf45sd87a5auPx4co4pLKxraL1eZPLdOVEuhSD//fBq', '1', '73424275', '', 1, '', '', 1, '2022-11-23', '2024-08-28 12:04:41', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1016, 'AYLY', 'SALAS SÁNCHEZ', '01159822', '$2a$07$asxx54ahjppf45sd87a5au3SA2yspfAXv4CfUqXQ4RtBKmtLTFMN6', '1', '01159822', '', 18, '', '', 1, '2022-12-01', '2024-07-29 14:56:54', NULL, '2023-12-19 11:34:26', NULL);
INSERT INTO `usuario` VALUES (1017, 'ASTRID CAROLINA', 'RAMIREZ ORBE', '70499623', '$2a$07$asxx54ahjppf45sd87a5aunbATumB660NXctdGERbL0q0y8hPIvE.', '1', '70499623', '943255514', 19, 'astridramirez@unsm.edu.pe', 'JR. BOLOGNESI Nº 1638', 1, '2022-12-27', '2024-08-05 10:54:38', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1018, 'IDANIA', 'POUZA GONZALEZ DE CORIMAYTA', '48965001', '$2a$07$asxx54ahjppf45sd87a5auad5Bj5eMTlNp5PLZ4pLUVfqQc07dW/u', '1', '48965001', '', 18, '', '', 1, '2022-12-29', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1019, 'JASMANY', 'CORIMAYTA GUTIERREZ', '40846386', '$2a$07$asxx54ahjppf45sd87a5auehqZxQL.toReyvCH/TqmjdQRhGVFyKe', '1', '40846386', '', 18, '', '', 1, '2022-12-29', '2023-10-07 12:10:00', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1020, 'CÉSAR ALFREDO', 'FERNÁNDEZ VALLES', '80290053', '$2a$07$asxx54ahjppf45sd87a5auNy0kZ0ThEMKCDWNEt8jhBrsgv334Dui', '1', '80290053', '', 18, '', '', 1, '2023-01-06', '2023-07-17 09:24:25', NULL, '2023-07-17 09:22:33', NULL);
INSERT INTO `usuario` VALUES (1021, 'CINTHYA', 'TORRES SILVA', '44003020', '$2a$07$asxx54ahjppf45sd87a5au1C4B3gYbMyfX6CbY5LC9XVotRXk9Aka', '1', '44003020', '', 18, '', '', 1, '2023-01-15', '2024-09-03 19:44:15', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1022, 'JACQUELINE', 'BARTRA GOMEZ', '40640199', '$2a$07$asxx54ahjppf45sd87a5aupi5mIfng9XfqiJkjgqGzhlpOh7Yaug2', '1', '40640199', '', 18, '', '', 1, '2023-02-02', '2024-08-28 09:11:37', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1023, 'JOSE LUIS', 'USHIÑAHUA DIAZ', '42359432', '$2a$07$asxx54ahjppf45sd87a5ausASDJhEqaPAtGRyBXbOee.oySwjBH/S', '1', '42359432', '', 18, '', '', 1, '2023-02-03', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1024, 'FERNANDO', 'AREVALO BARTRA', '01127566', '$2a$07$asxx54ahjppf45sd87a5auiyxOvkEPYoSB7GdL3b1GFIQhe114UJ.', '1', '01127566', '', 18, '', '', 1, '2023-02-14', '2024-02-05 13:24:35', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1025, 'MARIO', 'HONORIO GARCIA', '01140188', '$2a$07$asxx54ahjppf45sd87a5auzpLgrs.dn9U1IxkchRG6w7ZpAJG4W5G', '1', '01140188', '', 18, '', '', 1, '2023-02-28', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1026, 'RAUL', 'ESPIRITU CAVERO', '01110116', '$2a$07$asxx54ahjppf45sd87a5auKgZSaWQmQjpXB5A0YC/t4g87ySIiu2S', '1', '01110116', '', 18, '', '', 1, '2023-03-13', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1027, 'CESAR', 'CALDERON RUIZ', '46550868', '$2a$07$asxx54ahjppf45sd87a5au65AqOqcojoD0ri1eQflhy6DkxHWHD0a', '1', '46550868', '', 18, '', '', 1, '2023-03-13', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1028, 'KELLER', 'SANCHEZ DAVILA', '41997504', '$2a$07$asxx54ahjppf45sd87a5aut9AyZTog45luhIuuCre4y3VmCe2260a', '1', '41997504', '992502739', 18, 'ksanchezd@unsm.edu.pe', 'JR: FRANCISCO BOLOGNESI N° 135- URB. 9 DE ABRIL', 1, '2023-03-13', '2024-08-29 14:28:32', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1029, 'WALTER ARMANDO', 'RAMIREZ DEL CASTILLO', '01147493', '$2a$07$asxx54ahjppf45sd87a5auRiGW1JNA9dLRN6Raf40S4A5DiBAficy', '1', '01147493', '', 18, '', '', 1, '2023-03-20', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1030, 'OSVER JHOELL', 'SHUPINGAHUA GUZMAN', '47947007', '$2a$07$asxx54ahjppf45sd87a5auuvcm7WX1qwc2tW3cMUiz0onE4TinnKK', '1', '47947007', '', 18, '', '', 1, '2023-03-20', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1031, 'LLEISER GENARO', 'CEOPA RODRIGUEZ', '44235935', '$2a$07$asxx54ahjppf45sd87a5auVpjmqb8W2mdyxt1OmZz5tVT3T4gBGG6', '1', '44235935', '', 18, '', '', 1, '2023-03-27', '2024-04-10 11:59:49', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1032, 'KATHERINE JENNIFER', 'ZEGARRA ALVARADO', '71138900', '$2a$07$asxx54ahjppf45sd87a5auhWT.GVC114jMIAyuqqW9OyEvnINojmW', '1', '71138900', '', 18, '', '', 1, '2023-04-13', '2024-09-10 15:33:17', NULL, '2024-01-26 08:52:45', NULL);
INSERT INTO `usuario` VALUES (1033, 'MARIA ISABEL', 'ROJAS  RUFINO', '01074069', '$2a$07$asxx54ahjppf45sd87a5auJpUO3M1oNxwjYge4kyEhFLftxp/j18y', '1', '01074069', '', 18, '', '', 1, '2023-04-16', '2024-02-09 10:18:11', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1034, 'EDVA LILI', 'GARCIA CORDOVA', '01111470', '$2a$07$asxx54ahjppf45sd87a5auElyIqGOqxRZY.5PPrRobUQqEa.Jaxri', '1', '01111470', '', 18, '', '', 1, '2023-04-30', '2024-03-13 08:43:05', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1035, 'YAMALYT MADHELEY', 'CALDERÓN MERA', '71950349', '$2a$07$asxx54ahjppf45sd87a5auCMCTaHsuYOWQjZSMgByXwgUc8qiJf8u', '1', '71950349', '', 18, '', '', 1, '2023-05-01', '2024-09-09 13:14:16', NULL, '2023-12-21 14:20:10', NULL);
INSERT INTO `usuario` VALUES (1036, 'SANTOS EDUARDO', 'ALAVAN HUAMAN', '16640258', '$2a$07$asxx54ahjppf45sd87a5aucLcnpRITmVRjkgYPKPKzy5OrM80FtVK', '1', '16640258', '915373055', 18, 'sealavan@unsm.edu.pe', '..', 1, '2023-06-21', '2023-12-19 09:35:39', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1037, 'ROXANA', 'TRUJILLO VALDERRAMA', '23010879', '$2a$07$asxx54ahjppf45sd87a5aulUFpmzErF9.2NHZtxa3R1p50Zpzz8Du', '1', '23010879', '', 18, '', '', 1, '2023-05-16', '2024-08-13 17:48:30', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1038, 'EDGAR ELEAZAR', 'CASTILLO ZUMAETA', '01090401', '$2a$07$asxx54ahjppf45sd87a5auFgZNEhyk0Jj5Nf0UoI4zOfRf4OlBxRK', '1', '01090401', '', 18, '', '', 1, '2023-05-20', '2024-07-24 11:27:33', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1039, 'ROSA PRYSCILIA', 'CARDENAS URRELO', '42005332', '$2a$07$asxx54ahjppf45sd87a5auy9sxsw7mzdG8tnA/wIy3MSgD8vYiUPO', '1', '42005332', '', 18, '', '', 1, '2023-06-01', '2024-09-04 14:14:00', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1040, 'HEIDEGGER', 'MENDOZA RAMIREZ', '43461267', '$2a$07$asxx54ahjppf45sd87a5auK7ZCWk6PmkK5jzr7Tm4epTrdgFd6n0m', '1', '43461267', '', 18, '', '', 1, '2023-06-20', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1041, 'JUAN RODRIGO', 'TUESTA NOLE', '44331463', '$2a$07$asxx54ahjppf45sd87a5auFATuWULC66OQuC4bGQpAsIyeKMW6aSi', '1', '44331463', '', 18, '', '', 1, '2023-06-24', '2024-01-14 21:18:49', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1042, 'VICTOR HUMBERTO', 'PUICON NIÑO DE GUZMAN', '46211934', '$2a$07$asxx54ahjppf45sd87a5au70H0Dlw6HWMy.9TJcddW4azUNsN4WI6', '1', '46211934', '', 18, '', '', 1, '2023-07-03', '2024-04-11 16:11:32', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1043, 'MIGUEL ANGEL', 'PINO GUTIÉRREZ', '46601421', '$2a$07$asxx54ahjppf45sd87a5auLXkYTtuImYdQkuDd9LaIsiJz6bs3oFa', '1', '46601421', '962943980', 16, 'mapino@unsm.edu.pe', '...', 1, '2023-07-04', '2024-04-12 17:49:11', NULL, '2023-09-21 11:37:22', NULL);
INSERT INTO `usuario` VALUES (1044, 'JULIO CESAR', 'VELA RENGIFO', '43950056', '$2a$07$asxx54ahjppf45sd87a5auR0K7vnmpI53v5H1JhRMmpoQL/aKnHgq', '1', '43950056', '', 18, '', '', 1, '2023-07-05', '2023-07-13 16:53:09', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1045, 'MARIO ELEODORO', 'URQUIZO COAGUILA', '29624474', '$2a$07$asxx54ahjppf45sd87a5auhpIPiewONcwMCLPkE.6QJ2WH0dWDyfq', '1', '29624474', '', 18, '', '', 1, '2023-07-11', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1046, 'SANDRA KARINA', 'PEREZ JAVA', '47236573', '$2a$07$asxx54ahjppf45sd87a5aueARXSAWPfBfnzcjMFFf/AItLcbMdbm2', '1', '47236573', '', 19, '', '', 1, '2023-07-14', '2024-02-20 07:33:09', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1047, 'WILSON', 'TORRES DELGADO', '40751019', '$2a$07$asxx54ahjppf45sd87a5auPDwNJrYz1nwCrzAsh27qdKeNUFiVRby', '1', '40751019', '943992515', 18, 'wtorresd@unsm.edu.pe', 'JR. MANUEL AREVALO ORBE N°286-TPTO.', 1, '2023-08-04', '2024-03-21 12:05:22', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1048, 'MANUEL ALEXANDER', 'HERRADA GARCIA', '44545380', '$2a$07$asxx54ahjppf45sd87a5auGATkGqZTy6ACKjK6N5tJd8tg6l4UQpK', '1', '44545380', '', 18, 'correo@gmail.com', '', 1, '2023-08-17', '2024-03-10 15:24:03', NULL, '2023-06-22 11:12:38', NULL);
INSERT INTO `usuario` VALUES (1049, 'ELSA MAVILA', 'RAMÍREZ PINEDO', '70470285', '$2a$07$asxx54ahjppf45sd87a5auXaL47gN6/bZfbHXyBlVeNAxnYysqhza', '1', '70470285', '', 18, 'correo@unsm.edu.pe', '', 1, '2023-08-17', '2024-09-06 12:07:15', NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1050, 'NORMA', 'JALK RUIZ', '01150754', '$2a$07$asxx54ahjppf45sd87a5au5kMQbeKI0h3vmcU5oz8Kf0pAaFfECqW', '1', '01150754', '929607746', 18, 'njalkr@unsm.edu.pe', '...', 1, '2023-08-25', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1051, 'BLANCA ROSA', 'USHIÑAHUA FASANANDO', '01076489', '$2a$07$asxx54ahjppf45sd87a5auN8zyaYsV/k1DA9AukGxMFIhA/IA3Imq', '1', '01076489', '', 18, 'unsm@unsm.edu.pe', '', 1, '2023-09-02', NULL, NULL, NULL, NULL);
INSERT INTO `usuario` VALUES (1052, 'PATRICIA LIZETT', 'QUEVEDO PÉREZ', '41731299', '$2a$07$asxx54ahjppf45sd87a5auGu8dARcBZX1E3f7zW4rFjjAV1A5CeqW', '1', '41731299', '', 18, 'usuario@unsm.edu.pe', '', 1, '2023-09-12', '2024-09-02 21:35:36', NULL, '2024-02-01 21:13:02', NULL);
INSERT INTO `usuario` VALUES (1053, 'WALTHER FRUCTUOSO', 'CHÁVEZ QUESQUÉN', '45385828', '$2a$07$asxx54ahjppf45sd87a5auvuqI9V8BVctTpqksXsy8MKKAtBcBuEe', '1', '45385828', '111111111', 18, '', '', 1, '2023-09-22', '2024-07-03 10:03:36', '2023-06-22 11:15:49', '2023-06-22 11:20:34', NULL);
INSERT INTO `usuario` VALUES (1054, 'SEGUNDO ROGER', 'RAMIREZ SHUPINGAHUA', '45198491', '$2a$07$asxx54ahjppf45sd87a5auLMcLmU1v2Z5mHM/rNeGtdvcWZIL1lU.', '1', '45198491', '', 18, 'usuario@unsm.edu.pe', '', 1, '2023-11-11', '2023-12-28 11:56:21', '2023-08-11 10:02:01', '2023-12-28 11:53:08', NULL);
INSERT INTO `usuario` VALUES (1055, 'JORGE SEGUNDO', 'PEREA CAMUS', '05388198', '$2a$07$asxx54ahjppf45sd87a5auxTZ/scnPFEYokhJ3hPdKF5cfISHMNve', '1', '05388198', '', 14, 'usuario@unsm.edu.pe', '...', 1, '2023-11-15', '2024-09-12 11:13:20', '2023-08-15 14:22:38', '2024-09-03 11:44:25', NULL);
INSERT INTO `usuario` VALUES (1056, 'ELMER', 'RUIZ TRIGOZO', '09904342', '$2a$07$asxx54ahjppf45sd87a5au8cqZJW3TD6U5lmiPd9NRBwvcDiBA9yK', '1', '09904342', '', 18, 'usuario@unsm.edu.pe', '', 1, '2023-11-22', '2024-09-02 19:18:08', '2023-08-22 12:01:12', '2023-08-22 12:02:16', NULL);
INSERT INTO `usuario` VALUES (1057, 'TÁMARA CRUZ', 'PEÑA PIÑÁN', '21576784', '$2a$07$asxx54ahjppf45sd87a5auKm0a3t8421WO/S0BhjerwQBUq7CcARW', '1', '21576784', '', 18, 'usuario@gmai.com', '', 1, '2023-11-29', '2023-08-29 16:02:32', '2023-08-29 12:55:02', '2023-08-29 16:02:25', NULL);
INSERT INTO `usuario` VALUES (1058, 'EROL', 'MENDOZA LOZANO', '42675378', '$2a$07$asxx54ahjppf45sd87a5autN1H3J4gdtnDXLVOLTxa8hMEHMiCwpe', '1', '42675378', '000000000', 18, '', '....', 0, '2023-10-03', NULL, '2023-10-03 07:37:39', '2023-10-03 07:37:39', NULL);
INSERT INTO `usuario` VALUES (1059, 'ALICIA', 'BARTRA REATEGUI', '01148346', '$2a$07$asxx54ahjppf45sd87a5auUXjDlr0vwBMCeHEpsAUEYjuP5JCx6WO', '1', '01148346', '', 18, 'usuario@unsm.edu.pe', '', 1, '2024-01-12', '2024-09-10 12:01:55', '2023-10-12 13:05:58', '2024-09-10 12:01:17', NULL);
INSERT INTO `usuario` VALUES (1060, 'LEONEL ANTONIO', 'VALDIVIA MUNDACA', '00953804', '$2a$07$asxx54ahjppf45sd87a5au4CR2r4Fqx07wpjawMAqT7JfKGNyzZbe', '1', '00953804', '', 18, '', '', 1, '2024-01-24', '2024-02-20 10:18:00', '2023-10-24 12:01:27', '2023-10-24 12:01:43', NULL);
INSERT INTO `usuario` VALUES (1061, 'ANGEL', 'CARDENAS GARCIA', '40724225', '$2a$07$asxx54ahjppf45sd87a5au.CUu.52hOjaXuNRatzXsxW8zrV0SSc6', '1', '40724225', '', 18, '', '', 1, '2024-02-03', '2023-11-09 17:25:55', '2023-11-03 10:49:48', '2023-11-03 10:50:19', NULL);
INSERT INTO `usuario` VALUES (1062, 'JAIME', 'CUSE QUISPE', '23863909', '$2a$07$asxx54ahjppf45sd87a5au2kG1CJm0McZU/lghNQrxzmZ2oskOcnC', '1', '23863909', '', 18, '', '', 1, '2024-02-28', '2023-11-28 12:59:36', '2023-11-28 12:57:56', '2023-11-28 12:58:16', NULL);
INSERT INTO `usuario` VALUES (1063, 'ROGER', 'RENGIFO RUIZ', '46912468', '$2a$07$asxx54ahjppf45sd87a5aur43wbkzK4arB4sARP7fZ/QLLkItbTua', '1', '46912468', '', 18, '', '', 1, '2024-03-04', '2024-06-10 11:04:58', '2023-12-04 14:24:05', '2023-12-04 14:24:26', NULL);
INSERT INTO `usuario` VALUES (1064, 'SEGUNDO WILFREDO', 'FASANANDO GARCIA', '05352851', '$2a$07$asxx54ahjppf45sd87a5au5/QX/QV3cwjIL0qhyd8eCIk.3L8PHA6', '1', '05352851', '', 18, '', '', 1, '2024-03-04', '2024-01-04 10:12:15', '2023-12-04 14:33:50', '2023-12-04 14:34:03', NULL);
INSERT INTO `usuario` VALUES (1065, 'SANDRA', 'RUIZ CORREA', '01121307', '$2a$07$asxx54ahjppf45sd87a5auq0pT1og.HeG66pbznTO/5sQG9uVeOwO', '1', '01121307', '', 18, '', '', 1, '2024-03-29', '2024-08-03 21:23:36', '2023-12-22 10:57:10', '2023-12-29 16:32:08', NULL);
INSERT INTO `usuario` VALUES (1066, 'ELIAS', 'GONZALES PINEDO', '44351566', '$2a$07$asxx54ahjppf45sd87a5au1IXUtBmoUsM4P3PsGM.vYJx0CfRWeFi', '1', '44351566', '', 18, '', '', 1, '2024-04-03', '2024-01-22 16:48:56', '2024-01-03 11:27:11', '2024-01-03 11:28:04', NULL);
INSERT INTO `usuario` VALUES (1067, 'ROCIO ROSARIO', 'DE LA CRUZ PARINANGO', '20041448', '$2a$07$asxx54ahjppf45sd87a5auOHz4K.P2gLpPzGgVR.iXtUOe2/4zG4S', '1', '20041448', '', 18, '', '', 1, '2024-04-30', '2024-01-30 12:56:56', '2024-01-30 12:56:33', '2024-01-30 12:56:48', NULL);
INSERT INTO `usuario` VALUES (1068, 'NORITA JACQUELINE', 'TORRES SANDOVAL', '72072537', '$2a$07$asxx54ahjppf45sd87a5aucLqdMh8bUsaRT.NWE77lVQhAWhxeLe2', '1', '72072537', '', 18, '', '', 1, '2024-05-01', '2024-02-01 08:01:58', '2024-02-01 07:56:48', '2024-02-01 08:01:39', NULL);
INSERT INTO `usuario` VALUES (1069, 'Jorge', 'Chavez', '75687851', '$2a$07$asxx54ahjppf45sd87a5aujo6Z/8hj.ChwKaWnqgeL73EpsNhvuom', '1', '75687851', '', 1, '', '', 1, '2024-05-28', '2024-09-12 10:57:57', '2024-02-28 14:15:43', '2024-02-28 14:16:53', NULL);
INSERT INTO `usuario` VALUES (1070, 'HERBERT HUGO', 'AREVALO BARTRA', '01072563', '$2a$07$asxx54ahjppf45sd87a5au75QdEvxlt04YP9Ug84sgEepl7LfVib.', '1', '01072563', '', 18, '', '', 1, '2024-06-04', '2024-03-04 12:29:34', '2024-03-04 11:53:59', '2024-03-04 11:54:20', NULL);
INSERT INTO `usuario` VALUES (1071, 'KARINA', 'FLORES PANDURO', '40950646', '$2a$07$asxx54ahjppf45sd87a5auBqUUTSnt868x5LPKYR/5L8P3bP9Nnim', '1', '40950646', '', 18, '', '', 1, '2024-06-12', '2024-09-10 17:25:38', '2024-03-12 11:27:39', '2024-03-12 11:27:56', NULL);
INSERT INTO `usuario` VALUES (1072, 'JONATHAN LEE', 'AREVALO PINCHI', '42119784', '$2a$07$asxx54ahjppf45sd87a5auf/puoe2peWSgAQJD7nRE98l0oSd5ruq', '1', '42119784', '', 18, '', '', 0, '2024-05-22', NULL, '2024-05-22 22:15:14', '2024-05-22 22:15:14', NULL);
INSERT INTO `usuario` VALUES (1073, 'CINTHYA', 'ARÉVALO LAZO', '47207346', '$2a$07$asxx54ahjppf45sd87a5auKd3.YhOKAx/JWrfC5ejL7ivckLML0jS', '1', '47207346', '', 18, '', '', 0, '2024-08-22', '2024-05-22 22:16:01', '2024-05-22 22:15:45', '2024-05-22 22:15:58', NULL);
INSERT INTO `usuario` VALUES (1074, 'TERCERO', 'FASANANDO PUYO', '01146693', '$2a$07$asxx54ahjppf45sd87a5auCpa7RDiI.yLqFNK4V76F9FM99WkUZw6', '1', '01146693', '', 18, '', '', 1, '2024-08-22', '2024-07-19 20:19:07', '2024-05-22 22:17:14', '2024-05-22 22:17:33', NULL);
INSERT INTO `usuario` VALUES (1075, 'ROGER ROLANDO', 'REATEGUI SANDOVAL', '10264809', '$2a$07$asxx54ahjppf45sd87a5au9YYG3FHr9mZwo78BGLcXJLIH4D2k3..', '1', '10264809', '', 18, '', '', 1, '2024-09-13', '2024-08-10 12:18:39', '2024-06-13 12:54:51', '2024-06-13 12:55:29', NULL);
INSERT INTO `usuario` VALUES (1076, 'JUAN FRANCISCO', 'AGREDA VEGA', '47575587', '$2a$07$asxx54ahjppf45sd87a5auT2LdlqAHa8x73lYlh/X/Nq4TOKOwaOu', '1', '47575587', '', 18, '', '', 1, '2024-10-30', '2024-08-31 09:15:39', '2024-07-30 10:01:36', '2024-07-30 10:02:04', NULL);
INSERT INTO `usuario` VALUES (1077, 'ANDI', 'LOZANO CHUNG', '00914138', '$2a$07$asxx54ahjppf45sd87a5auN0WIye3XdUtBrRrg8U2AFsDB6Rq1BNK', '1', '00914138', '', 18, '', '', 1, '2024-10-30', '2024-07-30 10:49:20', '2024-07-30 10:41:00', '2024-07-30 10:41:17', NULL);
INSERT INTO `usuario` VALUES (1078, ' HANS', ' RAMIREZ CORDOVA', '72423281', '$2a$07$asxx54ahjppf45sd87a5augziLQt7uL8xMTZeyP7WxLtpp5.Iwft.', '1', '72423281', '', 16, '', '', 1, '2024-11-05', '2024-09-12 09:24:21', '2024-08-05 13:54:46', '2024-08-05 13:55:09', NULL);
INSERT INTO `usuario` VALUES (1079, 'LUCY TARY', 'MENDOZA FERNÁNDEZ', '71116795', '$2a$07$asxx54ahjppf45sd87a5auHoE5RP0WBO70WcWBsGQFPZhyQgwJR9O', '1', '71116795', '', 18, '', '', 1, '2024-11-22', '2024-08-22 09:02:01', '2024-08-22 07:59:39', '2024-08-22 08:00:08', NULL);
INSERT INTO `usuario` VALUES (1080, 'DANIEL', 'ILIQUIN TRIGOSO', '46767279', '$2a$07$asxx54ahjppf45sd87a5au1XNbPkAKZtiN.pGe4tV4t7Ow6haxYj6', '1', '46767279', '', 18, '', '', 1, '2024-11-29', '2024-09-05 13:19:04', '2024-08-29 10:51:57', '2024-08-29 11:00:42', NULL);
INSERT INTO `usuario` VALUES (1081, 'EMILIO', 'MENDEZ SAN MARTIN ', '10144165', '$2a$07$asxx54ahjppf45sd87a5aupvbpJo47BMSh/VG/Iq56nO9XlnV/84K', '1', '10144165', '', 18, '', '', 1, '2024-12-04', '2024-09-04 10:09:58', '2024-09-04 10:09:26', '2024-09-04 10:09:52', NULL);
INSERT INTO `usuario` VALUES (1082, 'DAGNE ETHEL', 'LINARES ALVA', '45965559', '$2a$07$asxx54ahjppf45sd87a5auaBrv1Q0HW4LILBZgzsDrlj4k2Raqhh.', '1', '45965559', '', 18, '', '', 1, '2024-12-12', '2024-09-12 10:54:10', '2024-09-12 10:28:53', '2024-09-12 10:30:43', NULL);
INSERT INTO `usuario` VALUES (1083, 'FELIX ALFREDO', 'FIGUEROA FERNANDINI', '07259841', '$2a$07$asxx54ahjppf45sd87a5auNDEz0l/f/7WEJbINqSTOkJn6heOmjjq', '1', '07259841', '', 18, '', '', 0, '2024-09-12', NULL, '2024-09-12 10:46:57', '2024-09-12 10:46:57', NULL);
INSERT INTO `usuario` VALUES (1084, 'Juan', 'Chuquipoma Fermin', '76381177', '$2a$07$asxx54ahjppf45sd87a5auLN8wfOBv6kolRtquoWQ.PsRKtwk14Xu', '1', '76381177', '917563898', 1, 'jan98chu@gmail.com', 'Jr. orellana 836', 1, '2024-12-16', '2024-10-23 09:45:19', '2024-09-16 16:05:10', '2024-10-12 11:33:06', NULL);
INSERT INTO `usuario` VALUES (1085, 'Calix chuquipoma', 'Alvarez', '76381175', '$2a$07$asxx54ahjppf45sd87a5auLN8wfOBv6kolRtquoWQ.PsRKtwk14Xu', '1', '76381175', '917563898', 24, 'calin@gmail.com', 'San Maritn', 0, '2024-10-17', NULL, '2024-10-17 11:06:07', '2024-10-18 09:47:14', NULL);

SET FOREIGN_KEY_CHECKS = 1;
