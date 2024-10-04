<?php
$type = array("Acier", "Combat", "Dragon", "Eau", "Electrik", "Fee", "Feu", "Glace", "Insecte", "Normal", "Plante", "Poison", "Psy", "Roche", "Sol", "Spectre", "Tenebre", "Vol");

$Stat_name = array("Stat", "PV", "Attaque", "Défense", "Attaque Spéciale", "Défense Spéciale", "Vitesse");
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<title>Pokedex</title>
	<link rel="stylesheet" type="text/css" href="css/Pokedex.css">
	<link rel="stylesheet" type="text/css" href="css/TypeColor.php">
	<link rel="stylesheet" type="text/html" href="css/StatName.php">
	<meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body>
	<div id="header">
	</div>

	<div id="content">
		<div id="img_background"></div>
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

					<select id="type">
						<option value="all">All</option>
						<option value="Acier">Acier</option>
						<option value="Combat">Combat</option>
						<option value="Dragon">Dragon</option>
						<option value="Eau">Eau</option>
						<option value="Electrik">Electrik</option>
						<option value="Fée">Fée</option>
						<option value="Feu">Feu</option>
						<option value="Glace">Glace</option>
						<option value="Insecte">Insecte</option>
						<option value="Normal">Normal</option>
						<option value="Plante">Plante</option>
						<option value="Poison">Poison</option>
						<option value="Psy">Psy</option>
						<option value="Roche">Roche</option>
						<option value="Sol">Sol</option>
						<option value="Spectre">Spectre</option>
						<option value="tenebre">Ténèbre</option>
						<option value="vol">Vol</option>
					</select>

					<select id="rarete">
						<option value="all">All</option>
						<option value="c">Commun</option>
						<option value="f">Fabuleux</option>
						<option value="l">Légendaire</option>
					</select>
				</div>
				<div id="searchBar">
					<input type="text" name="text" id="an" class="search" placeholder="Rechercher" />
				</div>
			</div>
			<div id="pokedexCore">
				<div id="pokedex">
					<?php for ($i = 0; $i < 1000; $i++) {
						?>
						<div class="pokemon" id="<?php echo $i ?>">
							<div class="colors">
							</div>
							<div class="info">
								<div class="img_pokemon"></div>
								<div class="info_pokemon">
									<div class="info_l">
										<div class="id_pokemon"></div>
										<div class="nom_pokemon"></div>
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

		<div id="Pokemon">
			<h2 class="name_section">Information Pokemon :</h2>
			<div id="Info_Pokemon">
				<div id="sprit">
					<div id="img"></div>
					<div id="button">
						<div type="button" id="M_button"></div>
						<div type="button" id="F_button"></div>
					</div>
				</div>
				<div id="Info">
					<div id="Info_Pok_l">
						<div id="id_Pokemon"></div>
						<div id="nom_Pokemon"></div>
						<div id="categorie_Pokemon"></div>
						<div id="type_Pokemon"></div>
					</div>
					<div id="Info_Pok_r">
						<div id="data_pokemon">
							<div id="gen_Pokemon"></div>
							<div id="taille_Pokemon"></div>
							<div id="poids_Pokemon"></div>
							<div id="catch_rate_Pokemon"></div>
						</div>
						<div id="button_user">

							<input type="checkbox" id="check_fav">
							<label for="check_fav" id="fav">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
									class="bi bi-plus-circle-dotted" viewBox="0 0 16 16">
									<path
										d="M8 0q-.264 0-.523.017l.064.998a7 7 0 0 1 .918 0l.064-.998A8 8 0 0 0 8 0M6.44.152q-.52.104-1.012.27l.321.948q.43-.147.884-.237L6.44.153zm4.132.271a8 8 0 0 0-1.011-.27l-.194.98q.453.09.884.237zm1.873.925a8 8 0 0 0-.906-.524l-.443.896q.413.205.793.459zM4.46.824q-.471.233-.905.524l.556.83a7 7 0 0 1 .793-.458zM2.725 1.985q-.394.346-.74.74l.752.66q.303-.345.648-.648zm11.29.74a8 8 0 0 0-.74-.74l-.66.752q.346.303.648.648zm1.161 1.735a8 8 0 0 0-.524-.905l-.83.556q.254.38.458.793l.896-.443zM1.348 3.555q-.292.433-.524.906l.896.443q.205-.413.459-.793zM.423 5.428a8 8 0 0 0-.27 1.011l.98.194q.09-.453.237-.884zM15.848 6.44a8 8 0 0 0-.27-1.012l-.948.321q.147.43.237.884zM.017 7.477a8 8 0 0 0 0 1.046l.998-.064a7 7 0 0 1 0-.918zM16 8a8 8 0 0 0-.017-.523l-.998.064a7 7 0 0 1 0 .918l.998.064A8 8 0 0 0 16 8M.152 9.56q.104.52.27 1.012l.948-.321a7 7 0 0 1-.237-.884l-.98.194zm15.425 1.012q.168-.493.27-1.011l-.98-.194q-.09.453-.237.884zM.824 11.54a8 8 0 0 0 .524.905l.83-.556a7 7 0 0 1-.458-.793zm13.828.905q.292-.434.524-.906l-.896-.443q-.205.413-.459.793zm-12.667.83q.346.394.74.74l.66-.752a7 7 0 0 1-.648-.648zm11.29.74q.394-.346.74-.74l-.752-.66q-.302.346-.648.648zm-1.735 1.161q.471-.233.905-.524l-.556-.83a7 7 0 0 1-.793.458zm-7.985-.524q.434.292.906.524l.443-.896a7 7 0 0 1-.793-.459zm1.873.925q.493.168 1.011.27l.194-.98a7 7 0 0 1-.884-.237zm4.132.271a8 8 0 0 0 1.012-.27l-.321-.948a7 7 0 0 1-.884.237l.194.98zm-2.083.135a8 8 0 0 0 1.046 0l-.064-.998a7 7 0 0 1-.918 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
								</svg>
							</label>
							<input type="checkbox" id="check_capture">
							<label for="check_capture" id="capture">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
									class="bi bi-plus-circle-dotted" viewBox="0 0 16 16">
									<path
										d="M8 0q-.264 0-.523.017l.064.998a7 7 0 0 1 .918 0l.064-.998A8 8 0 0 0 8 0M6.44.152q-.52.104-1.012.27l.321.948q.43-.147.884-.237L6.44.153zm4.132.271a8 8 0 0 0-1.011-.27l-.194.98q.453.09.884.237zm1.873.925a8 8 0 0 0-.906-.524l-.443.896q.413.205.793.459zM4.46.824q-.471.233-.905.524l.556.83a7 7 0 0 1 .793-.458zM2.725 1.985q-.394.346-.74.74l.752.66q.303-.345.648-.648zm11.29.74a8 8 0 0 0-.74-.74l-.66.752q.346.303.648.648zm1.161 1.735a8 8 0 0 0-.524-.905l-.83.556q.254.38.458.793l.896-.443zM1.348 3.555q-.292.433-.524.906l.896.443q.205-.413.459-.793zM.423 5.428a8 8 0 0 0-.27 1.011l.98.194q.09-.453.237-.884zM15.848 6.44a8 8 0 0 0-.27-1.012l-.948.321q.147.43.237.884zM.017 7.477a8 8 0 0 0 0 1.046l.998-.064a7 7 0 0 1 0-.918zM16 8a8 8 0 0 0-.017-.523l-.998.064a7 7 0 0 1 0 .918l.998.064A8 8 0 0 0 16 8M.152 9.56q.104.52.27 1.012l.948-.321a7 7 0 0 1-.237-.884l-.98.194zm15.425 1.012q.168-.493.27-1.011l-.98-.194q-.09.453-.237.884zM.824 11.54a8 8 0 0 0 .524.905l.83-.556a7 7 0 0 1-.458-.793zm13.828.905q.292-.434.524-.906l-.896-.443q-.205.413-.459.793zm-12.667.83q.346.394.74.74l.66-.752a7 7 0 0 1-.648-.648zm11.29.74q.394-.346.74-.74l-.752-.66q-.302.346-.648.648zm-1.735 1.161q.471-.233.905-.524l-.556-.83a7 7 0 0 1-.793.458zm-7.985-.524q.434.292.906.524l.443-.896a7 7 0 0 1-.793-.459zm1.873.925q.493.168 1.011.27l.194-.98a7 7 0 0 1-.884-.237zm4.132.271a8 8 0 0 0 1.012-.27l-.321-.948a7 7 0 0 1-.884.237l.194.98zm-2.083.135a8 8 0 0 0 1.046 0l-.064-.998a7 7 0 0 1-.918 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
								</svg>
							</label>
							<input type="checkbox" id="check_equipe">
							<label for="check_equipe" id="equipe">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
									class="circle-dotted" viewBox="0 0 16 16">
									<path
										d="M8 0q-.264 0-.523.017l.064.998a7 7 0 0 1 .918 0l.064-.998A8 8 0 0 0 8 0M6.44.152q-.52.104-1.012.27l.321.948q.43-.147.884-.237L6.44.153zm4.132.271a8 8 0 0 0-1.011-.27l-.194.98q.453.09.884.237zm1.873.925a8 8 0 0 0-.906-.524l-.443.896q.413.205.793.459zM4.46.824q-.471.233-.905.524l.556.83a7 7 0 0 1 .793-.458zM2.725 1.985q-.394.346-.74.74l.752.66q.303-.345.648-.648zm11.29.74a8 8 0 0 0-.74-.74l-.66.752q.346.303.648.648zm1.161 1.735a8 8 0 0 0-.524-.905l-.83.556q.254.38.458.793l.896-.443zM1.348 3.555q-.292.433-.524.906l.896.443q.205-.413.459-.793zM.423 5.428a8 8 0 0 0-.27 1.011l.98.194q.09-.453.237-.884zM15.848 6.44a8 8 0 0 0-.27-1.012l-.948.321q.147.43.237.884zM.017 7.477a8 8 0 0 0 0 1.046l.998-.064a7 7 0 0 1 0-.918zM16 8a8 8 0 0 0-.017-.523l-.998.064a7 7 0 0 1 0 .918l.998.064A8 8 0 0 0 16 8M.152 9.56q.104.52.27 1.012l.948-.321a7 7 0 0 1-.237-.884l-.98.194zm15.425 1.012q.168-.493.27-1.011l-.98-.194q-.09.453-.237.884zM.824 11.54a8 8 0 0 0 .524.905l.83-.556a7 7 0 0 1-.458-.793zm13.828.905q.292-.434.524-.906l-.896-.443q-.205.413-.459.793zm-12.667.83q.346.394.74.74l.66-.752a7 7 0 0 1-.648-.648zm11.29.74q.394-.346.74-.74l-.752-.66q-.302.346-.648.648zm-1.735 1.161q.471-.233.905-.524l-.556-.83a7 7 0 0 1-.793.458zm-7.985-.524q.434.292.906.524l.443-.896a7 7 0 0 1-.793-.459zm1.873.925q.493.168 1.011.27l.194-.98a7 7 0 0 1-.884-.237zm4.132.271a8 8 0 0 0 1.012-.27l-.321-.948a7 7 0 0 1-.884.237l.194.98zm-2.083.135a8 8 0 0 0 1.046 0l-.064-.998a7 7 0 0 1-.918 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
								</svg>
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
									class="circle-fill" viewBox="0 0 16 16">
									<path
										d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
								</svg>
							</label>
						</div>
					</div>
				</div>
			</div>
			<h2 class="name_section">Talent :</h2>
			<div id="Talent">
				<?php for ($i = 0; $i < 3; $i++) {
					?>
					<div class="nom_talent"></div>
					<?php
				}
				?>
				<?php for ($j = 0; $j < 3; $j++) {
					?>
					<div class="desc_talent"></div>
					<?php
				}
				?>
			</div>
			<h2 class="name_section">Description :</h2>
			<div id="Description"></div>

			<h2 class="name_section">Statistique :</h2>
			<div id="Stat">
				<div id="Name_stat">
					<?php include_once("./css/StatName.php"); ?>
				</div>
				<div id="Val_stat">
					<?php for ($i = 0; $i < 7; $i++) {
						?>
						<div class="Val_stat_case"></div>
						<?php
					}
					?>
				</div>
				<div id="Graph_stat">
					<?php for ($i = 0; $i < 7; $i++) {
						?>
						<div class="Graph_stat_case"></div>
						<?php
					}
					?>
				</div>
			</div>
			<h2 class="name_section">Faibless/Resistance :</h2>
			<div id="Table_type">
				<?php for ($i = 0; $i < 18; $i++) {
					?>
					<div class="tab_Type <?php echo $type[$i] ?>"></div>
					<?php
				}
				?>
				<?php for ($j = 0; $j < 18; $j++) {
					?>
					<div class="Faibless_Resistance"></div>
					<?php
				}
				?>
			</div>
			<h2 class="name_section">Attaque :</h2>
			<div id="Attaque"></div>
		</div>
	</div>
	<script src="./script.js"></script>
</body>

</html>