<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<title>Pokedex</title>
	<link rel="stylesheet" type="text/css" href="css/Pokedex.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<script src="scripts/typeTable.js"></script>
	<div id="header">
	</div>
	<div id="content">
		<div id="img_l"></div>
		<div id="core">
			<div id="headerPokedex">
				<div id="filter_1">
					<select id="gen">
						<option value="all">All</option>
						<option value="g1">Gen 1</option>
						<option value="g2">Gen 2</option>
						<option value="g3">Gen 3</option>
						<option value="g4">Gen 4</option>
						<option value="g5">Gen 5</option>
						<option value="g6">Gen 6</option>
						<option value="g7">Gen 7</option>
						<option value="g8">Gen 8</option>
						<option value="g9">Gen 9</option>
					</select>
				</div>
				<div id="filter_2">
					<select id="type">
						<option value="all">All</option>
						<option value="eau">Eau</option>
						<option value="feu">Feu</option>
						<option value="plante">Plante</option>
						<option value="sol">Sol</option>
						<option value="roche">Roche</option>
						<option value="acier">Acier</option>
						<option value="glace">Glace</option>
						<option value="electrique">Electrique</option>
						<option value="dragon">Dragon</option>
						<option value="spectre">Spectre</option>
						<option value="psy">Psy</option>
						<option value="normal">Normal</option>
						<option value="combat">Combat</option>
						<option value="poison">Poison</option>
						<option value="insect">Insecte</option>
						<option value="vol">Vol</option>
						<option value="tenebre">Ténèbre</option>
						<option value="fee">Fée</option>
					</select>
				</div>
				<div id="filter_3">
					<select id="rarete">
						<option value="all">All</option>
						<option value="c">Commun</option>
						<option value="l">Légendaire</option>
					</select>
				</div>
				<div id="searchBar">
					<input type="text" name="text" id="an" class="search" placeholder="Rechercher" />
				</div>
			</div>
			<div id="pokedexCore">
				<div id="pokedex">
					<div class="pokemon"></div>
					<div class="pokemon"></div>
			</div>
			<div id="scrollBar"></div>
		</div>
	</div>
	<div id="img_r"></div>
	</div>
</body>

</html>