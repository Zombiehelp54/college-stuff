create database events;
use events;
create table event(id int auto_increment primary key not null, type varchar(10), time FLOAT, target TEXT);
