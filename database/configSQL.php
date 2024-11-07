<?php



function getPassword()
{
    $usePassword = true;
    $MYSQL_PASSWORD = 'root';
    if ($usePassword)
    {
        return $MYSQL_PASSWORD;
    }
    return;
}

?>