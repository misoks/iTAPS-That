This repo is for the iTAPS That group in SI 664 Fall 2012. We're creating an application
to perform the functions that the School of Information's Tracking and Planning sheets do.


------------------------------INSTALLATION INSTRUCTIONS---------------------------------

DATABASE SETUP

 - Create a new database within your host's phpMyAdmin
 - Create a user with universal privileges for that database
 - Note the database name, username, password as these will be required later


LOADING COURSE INFORMATION

 - Run the code from createTables.sql in the SQL field
 - Run the code from loadData.sql in the SQL field to load class and requirement information


CONNECTING TO YOUR DATABASE

 - Duplicate "DEFAULT_db.php"
 - Rename it "db.php" 
 - Open db.php
 - Add your database name, username, and password in the appropriate locations