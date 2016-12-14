<?php

/* 
 * Website configuration file
 * Possible items to place here would be:
 * - location of database connection info
 * - site url defaults
 * - api url 
 * - global error handling routines
 * - any other constants (like sales tax for example)
 * - or anything that needs to be shared by the entire website
 */

//Folder will be outside public web folder
$root = dirname($_SERVER['DOCUMENT_ROOT']). '/dbconn'; 
//echo $root;
//this will create the following uri
//c:/xampp/dbconn/

//create a mysql constant with the location of the connection file name
define('MYSQL',$root . '/2016_mysql_connect.php');
//giving the final
//c:/xampp/dbconn/2016_mysql_connect.php