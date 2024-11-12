<?php

$MYSQL_PASSWORD = 'root';

function getPassword()
{
    $usePassword = false;
    $MYSQL_PASSWORD = 'root';
    if ($usePassword)
    {
        return $MYSQL_PASSWORD;
    }
    return;
}

?>