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
				<div class="filter">
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
				<div class="filter">
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
				<div class="filter">
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
					<?php for ($i = 0; $i < 30; $i++) {
						?>
						<div class="pokemon" id="<?php echo $i ?>">
							<div class="colors">
							</div>
							<div class="info">
								<div class="img_Pokemon"></div>
								<div class="info_Pokemon">
									<div class="info_l">
										<div class="id_Pokemon"></div>
										<div class="nom_Pokemon"></div>
										<div class="type">
											<div class="type_1"></div>
											<div class="type_2"></div>
										</div>
									</div>
									<div class="info_r">
										<div class="niveau"></div>
									</div>
								</div>
							</div>

						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
		<div id="img_r"></div>
	</div>
	<script src="./script.js"></script>
</body>

</html>