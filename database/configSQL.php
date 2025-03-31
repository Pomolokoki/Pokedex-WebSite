<?php



function getPassword()
{
    $usePassword = true;
    $usePassword = false; // comment if UwAmp
    $MYSQL_PASSWORD = 'mdp';
    if ($usePassword)
    {
        return $MYSQL_PASSWORD;
    }
    return;
}