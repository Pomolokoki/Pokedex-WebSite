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
include_once('header.html');
?>

	<script src="scripts/typeTable.js"></script>
	<div id="typeTableFrame">
		<div id="gridParameters">
			<!--<input type="checkbox" id="doubleType" value="Double Type">-->
			<label class="checkbox">
				<input type="checkbox" checked="checked" id="doubleType" onchange="doubleTypeChanged()">
				<span class="checkmark"></span>
			</label>
			<label for="doubleType" id="doubleTypeLabel"> Double type </label><br>
		</div>
		<div id="highlight"></div>
		<div id="grid">
			<?php
			$count = 20;
			for ($i = 0; $i < 19; $i++) {
				for ($j = 0; $j < 19; $j++) {
					$id = $i . ";" . $j;
					if ($j == 0) {
						echo "<button id = $id class = gridElement onclick = selectType(" . $i . ")>" . $count . "</button> ";
					} else {
						echo "<div id = $id class = gridElement >" . $count . "</div> ";
					}
					$count++;
				}
			}
			?>
		</div>
	</div>
</body>

</html>