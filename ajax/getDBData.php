<?php
include_once("../database/extractDataFromDB.php");
echo json_encode(getDataFromDB($_GET["request"], null,null, true));

?>