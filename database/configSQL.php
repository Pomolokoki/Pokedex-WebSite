<?php



function getPassword()
{
    $usePassword = true;
    $usePassword = false; // comment if UwAmp
    $MYSQL_PASSWORD = 'root';
    if ($usePassword)
    {
        return $MYSQL_PASSWORD;
    }
    return;
}

?>