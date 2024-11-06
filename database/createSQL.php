<?php
const MYSQL_HOST = 'localhost';
const MYSQL_PORT = 3306;
const MYSQL_USER = 'root';
// const MYSQL_PASSWORD = 'root';
try {
$db = new PDO(
sprintf('mysql:host=%s;port=%s;charset=utf8',
MYSQL_HOST, MYSQL_PORT),
MYSQL_USER,
//MYSQL_PASSWORD
);
$sqlCreateBD = 
"DROP DATABASE IF EXISTS pokedex;
CREATE DATABASE pokedex CHARACTER SET utf8;
USE pokedex;";

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $exception) {
die('Erreur : '.$exception->getMessage());
}
$statement = $db->prepare($sqlCreateBD);
$statement->execute();
?>