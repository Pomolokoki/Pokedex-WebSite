<?php
include_once("connectSQL.php");
function loadSQL($file)
{
    if (file_exists($file))
    {
        $sql = explode("INSERT INTO", file_get_contents($file));
        global $db;
        for ( $i = 0; $i < count($sql); $i++ )
        {
            echo "". $sql[$i] ."<br><br>";
            if ($i == 0)
            {
                // $createQuerys = explode("DELIMITER", $sql[$i]);
                // for ( $j = 0; $j < count($createQuerys); $j++ )
                // {
                    // echo " " . $createQuerys[$j] . "<br>" . $j . "<br>";
                    // if ($j%2 == 1)
                    // {
                        // echo " DELIMITER | <br><br>";
                        // $statemnt = $db->prepare("DELIMITER |");
                        // $statemnt->execute();
                    // }
                    // else if ($j > 0)
                    // {
                        // echo " DELIMITER ; <br><br>";
                        // $statemnt = $db->prepare("DELIMITER ;");
                        // $statemnt->execute();
                    // }
                    // $statemnt = $db->prepare($createQuerys[$j]);
                    $statemnt = $db->prepare($sql[$i]);
                    $statemnt->execute();
                // }
                continue;
            }
            $statemnt = $db->prepare("INSERT INTO " . $sql[$i]);
            $statemnt->execute();
        }
    }
}

function loadDB()
{
    loadSQL("./pokedexFromPhp.sql");
    loadSQL("./database/pokedexFromPhp.sql");
}
loadDB();
?> 