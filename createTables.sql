use itaps;

CREATE TABLE Class(
class_id INT AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(128) NOT NULL,
link VARCHAR(2000),
credits DECIMAL NOT NULL,
pep_credits DECIMAL,
UNIQUE (title) );

CREATE TABLE Student(
user_id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(128) NOT NULL,
password VARCHAR(128) NOT NULL,
specialization VARCHAR(128) NOT NULL,
year INT(4),
UNIQUE(username) );

CREATE TABLE Manually_Entered_Class(
class_id INT AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(128) NOT NULL,
credits DECIMAL NOT NULL,
pep_credits DECIMAL,
UNIQUE (title) );

ALTER TABLE Manually_Entered_Class
AUTO_INCREMENT = 1000;

CREATE TABLE Requirements(
r_id INT AUTO_INCREMENT PRIMARY KEY,
specialization VARCHAR(128) NOT NULL,
description VARCHAR(1000) NOT NULL,
credits DECIMAL,
UNIQUE(specialization) );

CREATE TABLE Takes(
user_id INT,
class_id INT,
UNIQUE(user_id, class_id) );

CREATE TABLE Fulfills(
r_id INT,
class_id INT,
UNIQUE(r_id, class_id) );