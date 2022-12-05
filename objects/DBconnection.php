<?php

define("DB_PASSWORD", "123");//must change to 
define("DB_NAME", "root");
define("DB_MYSQLCOMMAND", "mysql:host=127.0.0.1;dbname=usedspaceshipsdb");

//use constant fro server user password
$connection = new PDO(DB_MYSQLCOMMAND,DB_NAME,DB_PASSWORD);

//make sure all the problemes shows exceptions

$connection -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//protect code against some of sql injection

$connection -> setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

