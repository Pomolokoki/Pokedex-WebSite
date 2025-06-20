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

        include_once(__DIR__ . "/../../src/database/get/extractDataFromDb.php");
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

    public function test_get_attaques()
    {
        $attacks = executeQueryWReturn("SELECT * FROM ability", null, $this->database);

        $this->assertEquals($attacks[0]["name"], "Stench///Puanteur");
        $this->assertEquals($attacks[0]["smallDescription"], "Has a 10% chance of making target Pokémon flinch with each hit.///Les capacités physiques du Pokémon ont 10 % de chances d'apeurer la cible.");
        $this->assertEquals($attacks[0]["effect"], "By releasing a stench when attacking, the Pokémon may cause the target to flinch.///Le Pokémon émet une odeur si nauséabonde qu'il peut effrayer sa cible en l'attaquant.");

        $this->assertEquals($attacks[158]["name"], "Sand Force///Force Sable");
        $this->assertEquals($attacks[158]["smallDescription"], "Strengthens rock, ground, and steel moves to 1.3× their power during a sandstorm.  Protects against sandstorm damage.///Sous le climat tempête de sable, la puissance des capacités de type Acier, Roche et Sol du Pokémon augmente de 30 %.\r\nImmunité contre les dégâts de la tempête de sable.");
        $this->assertEquals($attacks[158]["effect"], "Boosts the power of Rock-, Ground-, and Steel-type moves in a sandstorm. ///Augmente la puissance des capacités de types Roche,\nSol et Acier en cas de tempête de sable.");
    }

    public function test_get_items()
    {
        $items = executeQueryWReturn("SELECT * FROM item", null, $this->database);

        $this->assertEquals($items[0]["name"], "Master Ball///Master Ball");
        $this->assertEquals($items[0]["smallDescription"], "Catches a wild Pokémon every time.///NULL");
        $this->assertEquals($items[0]["category"], "standard-balls");
        $this->assertEquals($items[0]["pocket"], "pokeballs");
        $this->assertEquals($items[0]["effect"], "The best Poké Ball with the ultimate level of\r\nperformance. With it, you will catch any wild\r\nPokémon without fail.///Assurément la Poké Ball la plus performante.\r\nElle permet de capturer à coup sûr un Pokémon\r\nsauvage.");

        $this->assertEquals($items[190]["name"], "White Herb///Herbe Blanche");
        $this->assertEquals($items[190]["smallDescription"], "Held: Resets all lowered stats to normal at end of turn. Consumed after use.///NULL");
        $this->assertEquals($items[190]["category"], "held-items");
        $this->assertEquals($items[190]["pocket"], "misc");
        $this->assertEquals($items[190]["effect"], "An item to be held by a Pokémon. It will restore any\r\nlowered stat in battle. It can be used only once.///Objet à tenir. Restaure les stats qui ont subi une baisse.\r\nNe peut être utilisé qu’une fois.");
    }
}