-- SQLITE Database
-- sqlite3 iutproject.sqlite < iutproject-insert.sql
BEGIN TRANSACTION;
INSERT INTO account (login, password, email, status)
 VALUES
 ('user1', 'user1', 'user1@local.com', 1),
 ('user2', 'user2', 'user2@local.com', 1),
 ('user3', 'user3', 'user3@local.com', 1);
 
INSERT INTO taskList (accountId, taskListName, status)
 VALUES
 (1, 'taskList11', 1),
 (2, 'taskList21', 1),
 (2, 'taskList22', 1);
 
INSERT INTO task (accountId, taskListId, taskName, status)
 VALUES
 (1, 1, 'task111', 1),
 (2, 2, 'task211', 1),
 (2, 2, 'task212', 1);
 
 COMMIT;
