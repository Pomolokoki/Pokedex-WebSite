<?php
include_once("../database/extractdata.php");

echo json_encode(getDataFromDB($_GET["request"], null,null, true));

?>