<?php
include_once 'configSQL.php';

const MYSQL_HOST = 'localhost';
const MYSQL_PORT = 3306;
const MYSQL_USER = 'root';

try {
    $db = new PDO(
        sprintf(
            'mysql:host=%s;port=%s;charset=utf8',
            MYSQL_HOST,
            MYSQL_PORT
        ),
        MYSQL_USER,
        getPassword()
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqlCreateBD =
        'DROP DATABASE IF EXISTS pokedex; CREATE DATABASE pokedex CHARACTER SET utf8; USE pokedex;';
    $statement = $db->prepare($sqlCreateBD);
    $statement->execute();
    $statement->fetchAll();
    $statement->closeCursor();
    
    
} catch (Exception $exception) {
    die('Erreur : ' . $exception->getMessage());
}
?>

<!DOCTYPE html>
<html lang='fr'>

<head>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet'>
	<title>Pokedex</title>
</head>

<?php include_once 'header.php'; ?>

	<body>
        <p>Merci d'attendre, la base de donnée est en cours de chargement</p>
		<img src="./img/loadingPokeballGif.gif" height="100%" width="100%" aspect-ratio="1/1">
        <form action="loadingDB.php">
            <input type="submit">
        </form>
	</body>

</html>
