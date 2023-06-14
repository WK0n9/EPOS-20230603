/*
 Navicat Premium Data Transfer

 Source Server         : 飞鸾办公测试环境
 Source Server Type    : MySQL
 Source Server Version : 80027
 Source Host           : localhost:3306
 Source Schema         : epos

 Target Server Type    : MySQL
 Target Server Version : 80027
 File Encoding         : 65001

 Date: 14/06/2023 16:54:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for order_bill
-- ----------------------------
DROP TABLE IF EXISTS `order_bill`;
CREATE TABLE `order_bill`  (
  `Bill_ID` bigint NOT NULL AUTO_INCREMENT,
  `Bill_DeskID` bigint NULL DEFAULT NULL,
  `Bill_Date` datetime NULL DEFAULT NULL,
  `Bill_DishID` bigint NULL DEFAULT NULL,
  `Bill_DishName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Bill_DishNum` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Bill_DishSale` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Bill_DishSaleEqual` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Bill_Value` int NULL DEFAULT NULL,
  `Bill_DeleteValue` int NULL DEFAULT NULL,
  PRIMARY KEY (`Bill_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 87 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of order_bill
-- ----------------------------

-- ----------------------------
-- Table structure for order_bill_equal
-- ----------------------------
DROP TABLE IF EXISTS `order_bill_equal`;
CREATE TABLE `order_bill_equal`  (
  `Bill_Equal_ID` bigint NOT NULL AUTO_INCREMENT,
  `Bill_Equal_DeskID` bigint NULL DEFAULT NULL,
  `Bill_Equal_Date` datetime NULL DEFAULT NULL,
  `Bill_Equal_Sale` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Bill_Equal_Sale_Real` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Bill_Equal_Value` int NULL DEFAULT NULL,
  `Bill_Equal_DeleteValue` int NULL DEFAULT NULL,
  PRIMARY KEY (`Bill_Equal_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of order_bill_equal
-- ----------------------------

-- ----------------------------
-- Table structure for order_cate
-- ----------------------------
DROP TABLE IF EXISTS `order_cate`;
CREATE TABLE `order_cate`  (
  `Cate_ID` bigint NOT NULL AUTO_INCREMENT,
  `Cate_Name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Cate_Order` bigint NULL DEFAULT NULL,
  `Cate_DeleteValue` int NULL DEFAULT NULL,
  PRIMARY KEY (`Cate_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of order_cate
-- ----------------------------

-- ----------------------------
-- Table structure for order_desk
-- ----------------------------
DROP TABLE IF EXISTS `order_desk`;
CREATE TABLE `order_desk`  (
  `Desk_ID` bigint NOT NULL AUTO_INCREMENT,
  `Desk_Name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Desk_Order` bigint NULL DEFAULT NULL,
  `Desk_DeleteValue` int NULL DEFAULT NULL,
  PRIMARY KEY (`Desk_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of order_desk
-- ----------------------------

-- ----------------------------
-- Table structure for order_dish
-- ----------------------------
DROP TABLE IF EXISTS `order_dish`;
CREATE TABLE `order_dish`  (
  `Dish_ID` bigint NOT NULL AUTO_INCREMENT,
  `Dish_Name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Dish_Cate` bigint NULL DEFAULT NULL,
  `Dish_Num` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Dish_Cost` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Dish_Sale` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Dish_Stock` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Dish_DeleteValue` int NULL DEFAULT NULL,
  PRIMARY KEY (`Dish_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of order_dish
-- ----------------------------

-- ----------------------------
-- Table structure for order_item
-- ----------------------------
DROP TABLE IF EXISTS `order_item`;
CREATE TABLE `order_item`  (
  `Item_ID` bigint NOT NULL AUTO_INCREMENT,
  `Item_Date` datetime NULL DEFAULT NULL,
  `Item_Tips` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Item_Cost` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Item_DeleteValue` int NULL DEFAULT NULL,
  PRIMARY KEY (`Item_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of order_item
-- ----------------------------

-- ----------------------------
-- Table structure for order_token
-- ----------------------------
DROP TABLE IF EXISTS `order_token`;
CREATE TABLE `order_token`  (
  `Token_ID` bigint NOT NULL AUTO_INCREMENT,
  `Token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Token_MD5` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Token_Cate` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Token_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of order_token
-- ----------------------------
INSERT INTO `order_token` VALUES (1, '123456', NULL, 'qiantai');
INSERT INTO `order_token` VALUES (2, '987654', NULL, 'houchu');

SET FOREIGN_KEY_CHECKS = 1;
