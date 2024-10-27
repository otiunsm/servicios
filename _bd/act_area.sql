/*
 Navicat Premium Data Transfer

 Source Server         : dbunsm
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : registro_oti

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 25/10/2024 10:32:40
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
  `tipo_estado` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `estado_area` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`idarea`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 98 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of act_area
-- ----------------------------
INSERT INTO `act_area` VALUES (1, 'INFRAESTRUCTURA TECNOLOGICA', 'Area encargada de reparacion y matenimiento ', '1', '1');
INSERT INTO `act_area` VALUES (92, 'Nueva Area', 'Area encargada de las infraestructuras tecnol', 'R', '1');
INSERT INTO `act_area` VALUES (93, 'Seguridad ', 'Descripción del docente', 'R', '1');
INSERT INTO `act_area` VALUES (94, 'Infra aqui', 'descrip', 'C', '1');
INSERT INTO `act_area` VALUES (96, 'OTROS', 'OTROS', 'P', '1');
INSERT INTO `act_area` VALUES (97, 'Juanito', 'Describe aqui', 'P', '1');

SET FOREIGN_KEY_CHECKS = 1;
