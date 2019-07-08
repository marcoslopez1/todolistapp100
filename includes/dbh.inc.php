<?php
//File to connect to the database

//When creating the database from the phpMyAdmin page make sure you use the estatment like this:
//USERS TABLE***********************************************************************************
//CREATE TABLE users (
//id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
//name TINYTEXT NOT NULL,
//username TINYTEXT NOT NULL,
//email TINYTEXT NOT NULL,
//password LONGTEXT NOT NULL,
//active SET( '0', '1' ) NOT NULL,
//banned SET( '0', '1' ) NOT NULL
//)
//ITEMS TABLE***********************************************************************************
//CREATE TABLE items (
//id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
//name TINYTEXT NOT NULL,
//userid INT NOT NULL,
//done SET( '0', '1' ) NOT NULL,
//created DATETIME NOT NULL
//)

$servername = "localhost";
$dBUsername = "phpmyadmin";
$dBPassword = "root";
$dBName = "to_do_app";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);
$db = new PDO ('mysql:dbname='.$dBName.';host='.$servername,$dBUsername,$dBPassword);


//Checking the connection to the database and showing the error in case the connection didn't work
if (!$conn) {
  die("Connection failed: ".mysqli_connect_error());
}

?>
