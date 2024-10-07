<?php
include_once("./database/extractdata.php");

$typeData = getDataFromDB("type", "name", null);
for ($i = 0; $i < count($typeData); $i++) {
    echo '<option value="' . getTextFr($typeData[$i]["name"]) . '">' . getTextFr($typeData[$i]["name"]) . '</option>';

}
?>