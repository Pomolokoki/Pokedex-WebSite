<?php
require __DIR__ . '/../../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../..');
$dotenv->load();

$MYSQL_HOST = $_ENV['DB_HOST'];
$MYSQL_PORT = $_ENV['DB_PORT'];
$MYSQL_NAME = $_ENV['DB_NAME'];
$MYSQL_USER = $_ENV['DB_USERNAME'];

try {
    $db = new PDO(
        sprintf(
            'mysql:host=%s;dbname=%s;port=%s;charset=utf8',
            $MYSQL_HOST,
            $MYSQL_NAME,
            $MYSQL_PORT
        ),
        $MYSQL_USER,
        $_ENV['DB_PASSWORD']
    );

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //include_once 'loadDataIntoWebsite.php';

} catch (Exception $exception) {
    if (str_contains($exception->getMessage(), 'Unknown database')) {
        include_once 'createSQL.php';
    } else
        die('Erreur : ' . $exception->getMessage());
}