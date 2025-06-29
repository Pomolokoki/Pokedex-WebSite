<?php
include_once __DIR__ . '/../database/get/FromPHP/getDBDataGlobal.php';
$typeData = GetTypesForTypeTable();
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


<?php
include_once 'header.php';
?>
<div id='main'>
	<div id='defLabel'>Défenseur</div>
	<div id='horizontalFlex'>
		<div id='atckLabel'>Attaquant</div>
		<div id='gridWrapper'>
			<div class='info'>Clique sur une cellule pour la faire ressortir</div>
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
							echo "
								<button id = $id class = 'gridElement " . getTextLang($typeData[$j - 1]['name'], 'en') . '\' onclick = \'selectType(' . $j . ', false)\'>
									<img src=\'../../public/img/' . $typeData[$j - 1]['sprite'] . '\' alt=\'' . getTextLang($typeData[$j - 1]['name']) .'\' loading=lazy decoding=async/>
								</button>';
						} else if ($j == 0) {
    echo "
        <button id = $id class = 'gridElement gridElementButton no-icon " . getTextLang($typeData[$i - 1]['name'], 'en') . '\' onclick = \'selectType(' . $i . ', true)\'>'
            . getTextLang($typeData[$i - 1]['name']) . '
         </button> ';

						} else {
							echo "<button id = $id class = 'gridElement x" . $typeEfficiency[$j] . '\' tabindex=-1 onclick = \'selectCell(' . $i . ', ' . $j . ')\'> x' . $typeEfficiency[$j] . '</button> ';
						}
					}
				}
				?>
			</div>
			<div id='warning' class='info'>Les données peuvent varier selon les pokémons, merci de vous référer à <a
					href='./pokedex.php'>pokedex</a> pour une meilleure précision</div>

		</div>
	</div>
	<div>
		<script src='../scripts/js/typeTable.js'></script>
	</div>


	</body>

</html>