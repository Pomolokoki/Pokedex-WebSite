<?php
include_once("./database/extractDataFromDB.php");
$typeData = getDataFromDB("type", "*", null);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<title>Pokedex</title>
	<link rel="stylesheet" type="text/css" href="css/typeTable.css">
	<link rel="stylesheet" type="text/css" href="css/customCheckbox.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">

</head>


<body>
	<?php
	include_once('header.php');
	?>

	<script src="scripts/typeTable.js"></script>
	<div id="typeTableFrame">

		<!-- <div id="midVertival"> -->

		
		<div id="midVertical">
			<div id="defLabel">Défenseur</div>
			<div id="gridAtckFlex">
				<div id="atckLabel">Attaquant</div>
				<div id="grid">
					<?php
					for ($i = 0; $i < 19; $i++) {
						if ($i != 0) {
							$typeEfficiency = explode('/', $typeData[$i - 1]["efficiency"]);
						}
						for ($j = 0; $j < 19; $j++) {
							$id = $i . ";" . $j;
							if ($i == 0 && $j == 0) {
								echo "<button id = $id class = 'gridElement gridElementButton' onclick = 'selectType(null , null)'>RESET</button>";
							} else if ($i == 0) {
								echo "<button id = $id class = gridElement onclick = 'selectType(" . $j . ", false)'><img src=\"" . $typeData[$j - 1]["sprite"] . "\"/></button> ";
							} else if ($j == 0) {
								echo "<button id = $id class = 'gridElement gridElementButton' onclick = 'selectType(" . $i . ", true)'><img src = " . $typeData[$i - 1]["sprite"] . " /> " . getTextLang($typeData[$i - 1]["name"]) . "</button> ";
							} else {
								echo "<div id = $id class = gridElement > x" . $typeEfficiency[$j] . "</div> ";
							}
						}
					}
					?>
				</div>
			</div>
			<!-- <div id="gridParameters">
			<input type="checkbox" id="doubleType" value="Double Type">
			<label class="checkbox">
				<input type="checkbox" checked="checked" id="doubleType" onchange="doubleTypeChanged()">
				<span class="checkmark"></span>
			</label>
			<label for="doubleType" id="doubleTypeLabel"> Double type </label><br>
			<label class="checkbox" id="fitScreenBox">
				<input type="checkbox" checked="checked" id="fitScreen" onchange="FitScreen()">
				<span class="checkmark"></span>
			</label>
			<label for="fitScreen" id="fitScreenLabel"> Fit Screen </label><br>
		</div> -->
		</div>
		<!-- </div> -->
	</div>
</body>

</html>