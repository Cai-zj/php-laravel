/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50635
Source Host           : localhost:3306
Source Database       : php_website

Target Server Type    : MYSQL
Target Server Version : 50635
File Encoding         : 65001

Date: 2017-09-30 18:21:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_admin
-- ----------------------------
DROP TABLE IF EXISTS `tb_admin`;
CREATE TABLE `tb_admin` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nikename` varchar(255) DEFAULT NULL COMMENT '真实名称',
  `username` varchar(255) DEFAULT NULL COMMENT '登录名称',
  `password` varchar(255) DEFAULT NULL COMMENT '登录密码',
  `address` varchar(255) DEFAULT NULL COMMENT '个人地址',
  `email` varchar(255) DEFAULT NULL COMMENT '个人邮箱',
  `is_delete` tinyint(4) DEFAULT '0' COMMENT '是否删除',
  `created_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for tb_article
-- ----------------------------
DROP TABLE IF EXISTS `tb_article`;
CREATE TABLE `tb_article` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `detail` text COMMENT '发布文字内容详情',
  `like_count` int(11) DEFAULT '0' COMMENT '点暂数',
  `view_count` int(11) DEFAULT '0' COMMENT '浏览数',
  `source` varchar(255) DEFAULT NULL COMMENT '来源',
  `cover` varchar(255) DEFAULT NULL COMMENT '封面图',
  `is_delete` tinyint(4) DEFAULT '0' COMMENT '是否删除',
  `created_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
SET FOREIGN_KEY_CHECKS=1;
