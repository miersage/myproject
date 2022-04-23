DROP DATABASE IF EXISTS iutproject;
DROP USER IF EXISTS 'iutproject'@'localhost';
CREATE USER 'iutproject'@'localhost' IDENTIFIED BY 'iutproject';
CREATE DATABASE iutproject
    CHARACTER SET = 'utf8mb4'
    COLLATE = 'utf8mb4_general_ci';
USE iutproject;
GRANT ALL ON iutproject.* TO 'iutproject'@'localhost';
FLUSH PRIVILEGES;

DROP TABLE IF EXISTS account;
CREATE TABLE account(
   accountId INT NOT NULL AUTO_INCREMENT,
   login VARCHAR(50) NOT NULL,
   password VARCHAR(127) NOT NULL,
   email VARCHAR(255) NOT NULL,
   status TINYINT NOT NULL DEFAULT (0),
   activeCode VARCHAR(255),
   activeExpireDate DATETIME,
   crtDate DATETIME NOT NULL DEFAULT NOW(),
   updDate DATETIME NOT NULL DEFAULT crtDate,
   PRIMARY KEY(accountId),
   UNIQUE(login)
) ENGINE=INNODB;

DROP TABLE IF EXISTS taskList;
CREATE TABLE taskList(
   taskListId INT NOT NULL AUTO_INCREMENT,
   accountId INT NOT NULL,
   taskListName VARCHAR(50) NOT NULL,
   status TINYINT NOT NULL DEFAULT (0),
   crtDate DATETIME NOT NULL DEFAULT NOW(),
   updDate DATETIME NOT NULL DEFAULT crtDate,
   PRIMARY KEY(taskListId),
   FOREIGN KEY(accountId) REFERENCES account(accountId) ON DELETE CASCADE,
   UNIQUE(accountId, taskListName)
) ENGINE=INNODB;

DROP TABLE IF EXISTS task;
CREATE TABLE task(
   taskId INT NOT NULL AUTO_INCREMENT,
   accountId INT NOT NULL,
   taskListId INT NOT NULL,
   taskName VARCHAR(50) NOT NULL,
   status TINYINT NOT NULL DEFAULT (0),
   dueDate DATETIME,
   note VARCHAR(255),
   crtDate DATETIME NOT NULL DEFAULT NOW(),
   updDate DATETIME NOT NULL DEFAULT crtDate,
   PRIMARY KEY(taskId),
   FOREIGN KEY(accountId) REFERENCES account(accountId) ON DELETE CASCADE,
   FOREIGN KEY(taskListId) REFERENCES taskList(taskListId) ON DELETE CASCADE,
   UNIQUE(accountId, taskListId, taskName)
) ENGINE=INNODB;
