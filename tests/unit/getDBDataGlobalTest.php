<?php

use PHPUnit\Framework\TestCase;

class getDBDataGlobalTest extends TestCase
{
    private $database;

    protected function setUp(): void
    {
        // Lance le script de création de la DB de test
        shell_exec('php ' . __DIR__ . '/../scripts/createTestDatabase.php');

        // Crée la connexion à la DB
        require __DIR__ . '/../../vendor/autoload.php';
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
        $dotenv->load();

        $MYSQL_HOST = $_ENV['DB_HOST'];
        $MYSQL_PORT = $_ENV['DB_PORT'];
        $MYSQL_NAME = $_ENV['DB_NAME'] . '_test';
        $MYSQL_USER = $_ENV['DB_USERNAME'];

        try {
            // Connect to server
            $this->database = new PDO(
                sprintf(
                    'mysql:host=%s;dbname=%s;port=%s;charset=utf8',
                    $MYSQL_HOST,
                    $MYSQL_NAME,
                    $MYSQL_PORT
                ),
                $MYSQL_USER,
                $_ENV['DB_PASSWORD']
            );
        } catch (Exception $exception) {
            throw new Exception('Erreur : ' . $exception->getMessage());
        }

        include(__DIR__ . "/../../src/database/get/extractDataFromDb.php");
    }
    public function test_get_pokemons()
    {
        $pokemons = executeQueryWReturn("SELECT * FROM pokemon", null, $this->database);

        $this->assertEquals($pokemons[0]["name"], "Bulbasaur///Bulbizarre");
        $this->assertEquals($pokemons[0]["description"], "While it is young, it uses the nutrients that are\r\nstored in the seed on its back in order to grow.///Quand il est jeune, il absorbe les nutriments\r\nconservés dans son dos pour grandir\r\net se développer.");
        $this->assertEquals($pokemons[0]["species"], "Seed Pokémon///Pokémon Graine");
        $this->assertEquals($pokemons[0]["generation"], 1);

        $this->assertEquals($pokemons[178]["name"], "Mareep///Wattouat");
        $this->assertEquals($pokemons[178]["description"], "Rubbing its fleece generates electricity.\r\nYou’ll want to pet it because it’s cute, but if you\r\nuse your bare hand, you’ll get a painful shock.///Il a beau être mignon, sa laine génère de\r\nl’électricité quand on la frotte. Tentez de le\r\ncaresser, et il vous mettra vite au courant !");
        $this->assertEquals($pokemons[178]["species"], "Wool Pokémon///Pokémon Laine");
        $this->assertEquals($pokemons[178]["generation"], 2);
    }
}