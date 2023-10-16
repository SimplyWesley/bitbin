DROP DATABASE IF EXISTS `bitbin`;

CREATE DATABASE `bitbin`;

USE `bitbin`;

DROP TABLE IF EXISTS `snippets`;

CREATE TABLE `snippets` (
    id MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    snippet_id VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    language VARCHAR(20) NOT NULL,
    snippet TEXT NOT NULL,
    password VARCHAR(100) NULL
);