<?php

include_once("createSQL.php");
include_once("connectSQL.php");
function loadSQL($file)
{

    if (file_exists($file))
    {
        $sql = explode("INSERT INTO", file_get_contents($file));
        global $db;
        for ( $i = 0; $i < count($sql); $i++ )
        {
            echo "". $sql[$i] ."";
            if ($i == 0)
            {
                $statemnt = $db->prepare($sql[$i]);
                $statemnt->execute();
                continue;
            }
            $statemnt = $db->prepare("INSERT INTO " . $sql[$i]);
            $statemnt->execute();
        }
    }
}

loadSQL("pokedexFromPhp.sql");
?>