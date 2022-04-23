-- SQLITE Database
-- sqlite3 iutproject.sqlite < iutproject.sql

DROP TABLE IF EXISTS account;
CREATE TABLE account(
   accountId INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
   login VARCHAR(50) NOT NULL,
   password VARCHAR(127) NOT NULL,
   email VARCHAR(255) NOT NULL,
   status TINYINT NOT NULL DEFAULT (0),
   activeCode VARCHAR(255),
   activeExpireDate DATETIME,
   crtDate DATETIME NOT NULL DEFAULT (DATETIME()),
   updDate DATETIME NOT NULL DEFAULT (DATETIME()),
   UNIQUE(login)
);

DROP TABLE IF EXISTS taskList;
CREATE TABLE taskList (
   taskListId INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
   accountId INTEGER NOT NULL,
   taskListName VARCHAR(50) NOT NULL,
   status TINYINT NOT NULL DEFAULT (0),
   crtDate DATETIME NOT NULL DEFAULT (DATETIME()),
   updDate DATETIME NOT NULL DEFAULT (DATETIME()),
   FOREIGN KEY(accountId) REFERENCES account(accountId) ON DELETE CASCADE,
   UNIQUE(accountId, taskListName)
);

DROP TABLE IF EXISTS task;
CREATE TABLE task(
   taskId INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
   accountId INTEGER NOT NULL,
   taskListId INTEGER NOT NULL,
   taskName VARCHAR(50) NOT NULL,
   status TINYINT NOT NULL DEFAULT (0),
   dueDate DATETIME,
   note VARCHAR(255),
   crtDate DATETIME NOT NULL DEFAULT (DATETIME()),
   updDate DATETIME NOT NULL DEFAULT (DATETIME()),
   FOREIGN KEY(accountId) REFERENCES account(accountId) ON DELETE CASCADE,
   FOREIGN KEY(taskListId) REFERENCES taskList(taskListId) ON DELETE CASCADE,
   UNIQUE(accountId, taskListId, taskName)
);
