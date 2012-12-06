CREATE TABLE Class(
class_id INT AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(128) NOT NULL,
link VARCHAR(2000),
credits DOUBLE NOT NULL,
pep_credits DOUBLE,
UNIQUE(title) );

CREATE TABLE Student(
user_id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(128) NOT NULL,
password VARCHAR(128) NOT NULL,
specialization VARCHAR(128) NOT NULL,
second_spec VARCHAR(128),
year INT(4),
UNIQUE(username) );

CREATE TABLE Manually_Entered_Class(
class_id INT AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(128) NOT NULL,
link VARCHAR(2000),
credits DOUBLE NOT NULL,
pep_credits DOUBLE );

ALTER TABLE Manually_Entered_Class
AUTO_INCREMENT = 1000;

CREATE TABLE Requirements(
r_id INT AUTO_INCREMENT PRIMARY KEY,
specialization VARCHAR(128) NOT NULL,
description VARCHAR(1000) NOT NULL,
credits DOUBLE );

CREATE TABLE Takes(
user_id INT,
class_id INT,
UNIQUE(user_id, class_id) );

CREATE TABLE Fulfills(
r_id INT,
class_id INT,
UNIQUE(r_id, class_id) );