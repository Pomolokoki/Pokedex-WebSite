<?php
if (php_sapi_name() !== 'cli') {
    throw new Exception('You need to be in a CLI');
}

require __DIR__ . '/../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

$MYSQL_HOST = $_ENV['DB_HOST'];
$MYSQL_PORT = $_ENV['DB_PORT'];
$MYSQL_NAME = $_ENV['DB_NAME'] . '_test';
$MYSQL_USER = $_ENV['DB_USERNAME'];

try {
    // Connect to server
    echo "Connecting to server...\n";
    $db = new PDO(
        sprintf(
            'mysql:host=%s;port=%s;charset=utf8',
            $MYSQL_HOST,
            $MYSQL_PORT
        ),
        $MYSQL_USER,
        $_ENV['DB_PASSWORD']
    );

    // Create the test DB
    echo "Reseting or creating the database '" . $MYSQL_NAME . "'.\n";
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqlCreateBD =
        'DROP DATABASE IF EXISTS ' . $MYSQL_NAME . '; CREATE DATABASE ' . $MYSQL_NAME . ' CHARACTER SET utf8; USE ' . $MYSQL_NAME . ';';
    $statement = $db->prepare($sqlCreateBD);
    $statement->execute();
    $statement->closeCursor();

    // Create the tables into the DB
    echo "Creating the tables.\n";
    $file = __DIR__ . '/../../src/database/create/pokedexFromPhp.sql';
    if (file_exists($file)) {
        $sql = explode('INSERT INTO', file_get_contents($file));
        global $db;
        for ($i = 0; $i < count($sql); $i++) {
            if ($i == 0) {
                $statemnt = $db->prepare($sql[$i]);
                $statemnt->execute();
                continue;
            }
            $statemnt = $db->prepare('INSERT INTO ' . $sql[$i]);
            $statemnt->execute();
        }
    } else {
        throw new Exception("Can't create tables in DB : SQL file not found");
    }

    echo "Inserting start test data.\n";
    $file = __DIR__ . '/startTestData.sql';
    if (file_exists($file)) {
        $sql = explode('INSERT INTO', file_get_contents($file));
        global $db;
        for ($i = 0; $i < count($sql); $i++) {
            if ($i == 0) {
                $statemnt = $db->prepare($sql[$i]);
                $statemnt->execute();
                continue;
            }
            $statemnt = $db->prepare('INSERT INTO ' . $sql[$i]);
            $statemnt->execute();
        }
    } else {
        throw new Exception("Can't insert data in DB : SQL file not found");
    }

} catch (Exception $exception) {
    throw new Exception('Erreur : ' . $exception->getMessage());
}

echo "Success!\n";
