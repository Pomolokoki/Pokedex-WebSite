<?php
include_once("../database/extractdata.php");

echo json_encode(getDataFromDB("pokemon", "*", "WHERE id = " . $_GET["id"]));

?>