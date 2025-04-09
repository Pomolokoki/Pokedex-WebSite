<?php
include_once '../extractDataFromDB.php';

echo json_encode(getDataFromDB($_GET['request'], null,null, true));

