/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100432
 Source Host           : localhost:3306
 Source Schema         : bd_unsm_oti

 Target Server Type    : MySQL
 Target Server Version : 100432
 File Encoding         : 65001

 Date: 12/09/2024 18:22:33
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for act_area
-- ----------------------------
DROP TABLE IF EXISTS `act_area`;
CREATE TABLE `act_area`  (
  `idarea` int NOT NULL AUTO_INCREMENT,
  `nombre_area` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `descripcion` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idarea`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of act_area
-- ----------------------------
INSERT INTO `act_area` VALUES (1, 'administracion de sistemas', 'desarrollo');
INSERT INTO `act_area` VALUES (2, 'Soporte Tecnico', 'maquinas malogradas');
INSERT INTO `act_area` VALUES (3, 'Redes ', NULL);

-- ----------------------------
-- Table structure for act_categoria_actividad
-- ----------------------------
DROP TABLE IF EXISTS `act_categoria_actividad`;
CREATE TABLE `act_categoria_actividad`  (
  `idcategoria_actividad` int NOT NULL AUTO_INCREMENT,
  `nombre_c` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idcategoria_actividad`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of act_categoria_actividad
-- ----------------------------

-- ----------------------------
-- Table structure for act_dependencia
-- ----------------------------
DROP TABLE IF EXISTS `act_dependencia`;
CREATE TABLE `act_dependencia`  (
  `id_dependencia` int NOT NULL AUTO_INCREMENT,
  `nombre_dep` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `descripcion` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_dependencia`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of act_dependencia
-- ----------------------------

-- ----------------------------
-- Table structure for act_estado
-- ----------------------------
DROP TABLE IF EXISTS `act_estado`;
CREATE TABLE `act_estado`  (
  `id_estado` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_estado`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of act_estado
-- ----------------------------

-- ----------------------------
-- Table structure for act_medio_solicitud
-- ----------------------------
DROP TABLE IF EXISTS `act_medio_solicitud`;
CREATE TABLE `act_medio_solicitud`  (
  `idmedio_solicitud` int NOT NULL AUTO_INCREMENT,
  `nombre_solicitud` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `descripcion` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idmedio_solicitud`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of act_medio_solicitud
-- ----------------------------

-- ----------------------------
-- Table structure for act_perfil
-- ----------------------------
DROP TABLE IF EXISTS `act_perfil`;
CREATE TABLE `act_perfil`  (
  `idperfil` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `usuarios_id_usuario` int NOT NULL,
  PRIMARY KEY (`idperfil`) USING BTREE,
  INDEX `fk_perfil_usuarios1`(`usuarios_id_usuario` ASC) USING BTREE,
  CONSTRAINT `fk_perfil_usuarios1` FOREIGN KEY (`usuarios_id_usuario`) REFERENCES `act_usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of act_perfil
-- ----------------------------

-- ----------------------------
-- Table structure for act_periodo
-- ----------------------------
DROP TABLE IF EXISTS `act_periodo`;
CREATE TABLE `act_periodo`  (
  `id_periodo` int NOT NULL AUTO_INCREMENT,
  `fecha_inicio` date NULL DEFAULT NULL,
  `fecha_fin` date NULL DEFAULT NULL,
  `pe_estado` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '1',
  PRIMARY KEY (`id_periodo`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of act_periodo
-- ----------------------------

-- ----------------------------
-- Table structure for act_permiso
-- ----------------------------
DROP TABLE IF EXISTS `act_permiso`;
CREATE TABLE `act_permiso`  (
  `idpermiso` int NOT NULL AUTO_INCREMENT,
  ` nombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idpermiso`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of act_permiso
-- ----------------------------

-- ----------------------------
-- Table structure for act_registro
-- ----------------------------
DROP TABLE IF EXISTS `act_registro`;
CREATE TABLE `act_registro`  (
  `idregistro` int NOT NULL AUTO_INCREMENT,
  `numero` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nro_carta` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fec_atencion` date NULL DEFAULT NULL,
  `detalle_actividad` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fec_registro` date NULL DEFAULT NULL,
  `observacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `tipo_doc` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_dependencia` int NOT NULL,
  `id_solicitante` int NOT NULL,
  `idmedio_solicitud` int NOT NULL,
  `id_tipo_asistencia` int NOT NULL,
  `id_usuario` int NOT NULL,
  `idcategoria_actividad` int NOT NULL,
  `id_estado` int NOT NULL,
  `id_periodo` int NOT NULL,
  PRIMARY KEY (`idregistro`) USING BTREE,
  INDEX `fk_registro_dependencia1`(`id_dependencia` ASC) USING BTREE,
  INDEX `fk_registro_solicitante1`(`id_solicitante` ASC) USING BTREE,
  INDEX `fk_registro_medio_solicitud1`(`idmedio_solicitud` ASC) USING BTREE,
  INDEX `fk_registro_tipo_asistencia1`(`id_tipo_asistencia` ASC) USING BTREE,
  INDEX `fk_registro_usuarios1`(`id_usuario` ASC) USING BTREE,
  INDEX `fk_registro_categoria_actividad1`(`idcategoria_actividad` ASC) USING BTREE,
  INDEX `fk_registro_estado1`(`id_estado` ASC) USING BTREE,
  INDEX `fk_registro_periodo1`(`id_periodo` ASC) USING BTREE,
  CONSTRAINT `fk_registro_categoria_actividad1` FOREIGN KEY (`idcategoria_actividad`) REFERENCES `act_categoria_actividad` (`idcategoria_actividad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_dependencia1` FOREIGN KEY (`id_dependencia`) REFERENCES `act_dependencia` (`id_dependencia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_estado1` FOREIGN KEY (`id_estado`) REFERENCES `act_estado` (`id_estado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_medio_solicitud1` FOREIGN KEY (`idmedio_solicitud`) REFERENCES `act_medio_solicitud` (`idmedio_solicitud`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_periodo1` FOREIGN KEY (`id_periodo`) REFERENCES `act_periodo` (`id_periodo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_solicitante1` FOREIGN KEY (`id_solicitante`) REFERENCES `act_solicitante` (`id_solicitante`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_tipo_asistencia1` FOREIGN KEY (`id_tipo_asistencia`) REFERENCES `act_tipo_asistencia` (`id_tipo_asistencia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_usuarios1` FOREIGN KEY (`id_usuario`) REFERENCES `act_usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of act_registro
-- ----------------------------

-- ----------------------------
-- Table structure for act_solicitante
-- ----------------------------
DROP TABLE IF EXISTS `act_solicitante`;
CREATE TABLE `act_solicitante`  (
  `id_solicitante` int NOT NULL AUTO_INCREMENT,
  `nombre_solicitante` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `dni_solicitante` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `telefono` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `direccion` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `cargo` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `estado` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_solicitante`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of act_solicitante
-- ----------------------------

-- ----------------------------
-- Table structure for act_tipo_asistencia
-- ----------------------------
DROP TABLE IF EXISTS `act_tipo_asistencia`;
CREATE TABLE `act_tipo_asistencia`  (
  `id_tipo_asistencia` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_tipo_asistencia`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of act_tipo_asistencia
-- ----------------------------

-- ----------------------------
-- Table structure for act_usuarios
-- ----------------------------
DROP TABLE IF EXISTS `act_usuarios`;
CREATE TABLE `act_usuarios`  (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombres` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_creacion` datetime NULL DEFAULT current_timestamp,
  `idarea` int NOT NULL,
  `estado_usu` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '1',
  PRIMARY KEY (`id_usuario`) USING BTREE,
  INDEX `fk_usuarios_area1`(`idarea` ASC) USING BTREE,
  CONSTRAINT `fk_usuarios_area1` FOREIGN KEY (`idarea`) REFERENCES `act_area` (`idarea`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of act_usuarios
-- ----------------------------
INSERT INTO `act_usuarios` VALUES (1, 'juan Chuki', 'j@gmail.com', '123456', '2024-09-11 09:14:09', 1, '1');
INSERT INTO `act_usuarios` VALUES (2, 'Tito H', 'tito@gmail.com', '1234', '2024-09-12 09:49:24', 1, '1');

-- ----------------------------
-- Table structure for act_usuarios_has_permiso
-- ----------------------------
DROP TABLE IF EXISTS `act_usuarios_has_permiso`;
CREATE TABLE `act_usuarios_has_permiso`  (
  `idusuarios_permiso` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `idpermiso` int NOT NULL,
  PRIMARY KEY (`idusuarios_permiso`) USING BTREE,
  INDEX `fk_usuarios_has_permiso_usuarios1`(`id_usuario` ASC) USING BTREE,
  INDEX `fk_usuarios_has_permiso_permiso1`(`idpermiso` ASC) USING BTREE,
  CONSTRAINT `fk_usuarios_has_permiso_permiso1` FOREIGN KEY (`idpermiso`) REFERENCES `act_permiso` (`idpermiso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_has_permiso_usuarios1` FOREIGN KEY (`id_usuario`) REFERENCES `act_usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of act_usuarios_has_permiso
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
