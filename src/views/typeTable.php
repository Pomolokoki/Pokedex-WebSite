<?php
include_once '../database/get/extractDataFromDB.php';
$typeData = getDataFromDB('type', '*', null);
?>
<!DOCTYPE html>
<html lang='fr'>

<head>
	<meta charset='utf-8'>
	<title>Pokedex</title>
	<link rel='stylesheet' type='text/css' href='../style/css/typeTable.css'>
	<link rel='stylesheet' type='text/css' href='../style/css/customCheckbox.css'>
	<link rel='stylesheet' type='text/css' href='../style/php/typeColor.php'>
	<link rel='stylesheet' type='text/css' href='../style/php/SWColor.php'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>

</head>


<body>
	<?php
	include_once 'header.php';
	?>

	<script src='../scripts/JS/typeTable.js'></script>
	<div id='typeTableFrame'>
		<div id='midVertical'>
			<div id='defLabel'>Défenseur</div>
			<div id='gridAtckFlex'>
				<div id='atckLabel'>Attaquant</div>
				<div id='grid'>
					<?php
					for ($i = 0; $i < 19; $i++) {
						if ($i != 0) {
							$typeEfficiency = explode('/', $typeData[$i - 1]['efficiency']);
						}
						for ($j = 0; $j < 19; $j++) {
							$id = $i . ';' . $j;
							if ($i == 0 && $j == 0) {
								echo "<button id = $id class = 'gridElement gridElementButton' onclick = 'selectType(null , null)'>RESET</button>";
							} else if ($i == 0) {
								echo "<button id = $id class = 'gridElement " . getTextLang($typeData[$j - 1]['name'], 'en') . '\' onclick = \'selectType(' . $j . ', false)\'><img src=\'../../public/img/' . $typeData[$j - 1]['sprite'] . '\'/></button>';
							} else if ($j == 0) {
								echo "<button id = $id class = 'gridElement gridElementButton " . getTextLang($typeData[$i - 1]['name'], 'en') . '\' onclick = \'selectType(' . $i . ', true)\'><img src =\'../../public/img/' . $typeData[$i - 1]['sprite'] . '\'/>' . getTextLang($typeData[$i - 1]['name']) . '</button> ';
							} else {
								echo "<div id = $id class = 'gridElement x" . $typeEfficiency[$j] . '\' > x' . $typeEfficiency[$j] . '</div> ';
							}
						}
					}
					?>
				</div>
			</div>
			<div id='warning'>Les données peuvent varier selon les pokémons, merci de vous référer à <a
					href='./pokedex.php'>pokedex</a> pour une meilleure précision</div>
		</div>
	</div>
</body>

</html>