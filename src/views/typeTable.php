<?php
include_once './database/extractDataFromDB.php';
$typeData = getDataFromDB('type', '*', null);
?>
<!DOCTYPE html>
<html lang='fr'>

<head>
	<meta charset='utf-8'>
	<title>Pokedex</title>
	<link rel='stylesheet' type='text/css' href='css/typeTable.css'>
	<link rel='stylesheet' type='text/css' href='css/customCheckbox.css'>
	<link rel='stylesheet' type='text/css' href='css/typeColor.php'>
	<link rel='stylesheet' type='text/css' href='css/SWColor.php'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>

</head>


	<?php
	include_once 'header.php';
	?>
	<div id="gridWrapper">
		
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
					echo "<button id = $id class = 'gridElement " . getTextLang($typeData[$j - 1]['name'], 'en') . '\' onclick = \'selectType(' . $j . ', false)\'><img src=\'' . $typeData[$j - 1]['sprite'] . '\'/></button>';
				} else if ($j == 0) {
					echo "<button id = $id class = 'gridElement gridElementButton " . getTextLang($typeData[$i - 1]['name'], 'en') . '\' onclick = \'selectType(' . $i . ', true)\'><img src =\'' . $typeData[$i - 1]['sprite'] . '\'/>' . getTextLang($typeData[$i - 1]['name']) . '</button> ';
				} else {
					echo "<div id = $id class = 'gridElement x" . $typeEfficiency[$j] . '\' > x' . $typeEfficiency[$j] . '</div> ';
				}
			}
		}
		?>
	</div>
	</div>
	<script src='scripts/typeTable.js'></script>
	<div id='defLabel'>Défenseur</div>
	<div id='atckLabel'>Attaquant</div>
	<div>

		<div>Clique sur une colonne pour la faire ressortir</div>
		
</div>
	
	<div id='warning'>Les données peuvent varier selon les pokémons, merci de vous référer à <a
			href='./pokedex.php'>pokedex</a> pour une meilleure précision</div>

</body>

</html>