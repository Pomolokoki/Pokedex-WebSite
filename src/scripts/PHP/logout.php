<?php
session_start();
session_destroy();

$new_url = '../../../views/pokedex.php';
echo "<script>window.location.replace('$new_url');</script>";
