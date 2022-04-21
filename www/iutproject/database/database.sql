-- SQLITE Database
-- sqlite3 database.sqlite < database.sql

DROP TABLE IF EXISTS users;
create table users (
	id integer primary key autoincrement,
	login varchar(255) not null,
	password varchar(255) not null
);
