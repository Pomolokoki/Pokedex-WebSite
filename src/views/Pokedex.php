<?php

include_once __DIR__ . '/../database/get/FromPHP/getDBDataGlobal.php';

$type = ['Steel', 'Fighting', 'Dragon', 'Water', 'Electric', 'Fairy', 'Fire', 'Ice', 'Bug', 'Normal', 'Grass', 'Poison', 'Psychic', 'Rock', 'Ground', 'Ghost', 'Dark', 'Flying'];

$Stat_name = ['Stat', 'PV', 'Attaque', 'Défense', 'Attaque Spéciale', 'Défense Spéciale', 'Vitesse'];
$datapokemon = GetPokemonsForPokedex();
$dataType = GetTypesForPokedex();

$pokemonToShow = null;
if (isset($_POST['pokemonId']) && $_POST['pokemonId'] != '') {
	$pokemonToShow = $_POST['pokemonId'];
	$_POST['pokemonId'] != '';
}
?>

<!DOCTYPE html>
<html lang='fr'>

<head>
	<meta charset='utf-8'>
	<title>Pokedex</title>
	<link rel='stylesheet' type='text/css' href='../style/CSS/Pokedex.css'>
	<link rel='stylesheet' type='text/css' href='../style/PHP/typeColor.php'>
	<link rel='stylesheet' type='text/html' href='../style/PHP/statName.php'>

	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<script src="../scripts/JS/Pokedex2.js" defer></script> 
</head>

<body>
	<?php include_once 'header.php'; ?>
	
	<div id='Data_User'>
		<?php if (isset($_SESSION['LOGGED_USER'][0]['id'])) {
			echo ($_SESSION['LOGGED_USER'][0]['id']);
		} ?></div>
	<span id='pokemonSelected' data-pokemon='<?= $pokemonToShow ?>'></span>
	<div id='content'>
		<div id='img_background'></div>
		<div id='core'>
			<div id="headerPokedex">
  <div class="headerBar">
    <div id="searchBar">
  <input id="searchBarInput" type="text" placeholder="Rechercher" />
  <span id="clearSearch">×</span>
</div>


    <div class="filter">
      <select id="gen">
        <option value="all">Gen</option>
        <option value="1">Gen 1</option>
        <option value="2">Gen 2</option>
        <option value="3">Gen 3</option>
        <option value="4">Gen 4</option>
        <option value="5">Gen 5</option>
        <option value="6">Gen 6</option>
        <option value="7">Gen 7</option>
        <option value="8">Gen 8</option>
        <option value="9">Gen 9</option>
      </select>

      <select id='type'>
						<option value='all'>Type</option>
						<?php
						for ($i = 0; $i < 18; $i++) {
							echo '<option value=\'' . getTextLang($dataType[$i]['name'], 'en') . '\'>' . getTextLang($dataType[$i]['name']) . '</option>';
						}
						?>
					</select>

      <select id="rarete">
        <option value="all">Rareté</option>
        <option value="0">Commun</option>
        <option value="2">Fabuleux</option>
        <option value="1">Légendaire</option>
        <option value="3">Ultra-Chimère</option>
        <option value="4">Paradox</option>
      </select>
    </div>
  </div>
</div>

			<div id='pokedexCore'>
			    <div class="pokedex-wrapper">
			        <ol id='pokedex'>
						<?php for ($i = 0; $i < count($datapokemon); $i++) { ?>
							<li class="pokemon <?= strtolower(getTextLang($datapokemon[$i]['type1'], 'en')) ?>"
    							data-name="<?= getTextLang(mb_strtolower($datapokemon[$i]['name'])) ?>"
    							data-type="<?= getTextLang($datapokemon[$i]['type1'], 'en') . ' ' . getTextLang($datapokemon[$i]['type2'] ?? '', 'en') ?>"
    							data-category="<?= $datapokemon[$i]['category'] ?>"
    							data-gen="<?= $datapokemon[$i]['generation'] ?>"
    							data-id="<?= $datapokemon[$i]['id'] ?>"
                  data-typeefficiency="<?= $datapokemon[$i]['typeEfficiency'] ?>">

							  <div class="pokeinfos">
							    <span class="number">#<?= str_pad($datapokemon[$i]['id'], 3, '0', STR_PAD_LEFT) ?></span>
							    <h3 class="<?= (strlen(getTextLang($datapokemon[$i]['name'])) > 15 ? 'small-font' : '') ?>">
								    <?= getTextLang($datapokemon[$i]['name']) ?>
								</h3>

                <ul class="types">
                  <li class="type type1"><?= getTextLang($datapokemon[$i]['type1']) ?></li>
                  <?php if ($datapokemon[$i]['type2']) : ?>
                    <li class="type type2 type-<?= strtolower(getTextLang($datapokemon[$i]['type2'], 'en')) ?>">
                      <?= getTextLang($datapokemon[$i]['type2']) ?>
                    </li>
                  <?php endif; ?>
                </ul>


							    <p class="rarete">
							      <?php
											if ($datapokemon[$i]['category'] == 0) {
												echo 'Commun';
											} elseif ($datapokemon[$i]['category'] == 1) {
												echo 'Légendaire';
											} elseif ($datapokemon[$i]['category'] == 2) {
												echo 'Fabuleux';
											} elseif ($datapokemon[$i]['category'] == 3) {
												echo 'Ultra-Chimère';
											} else {
												echo 'Paradox';
											}
											?>
							    </p>
							  </div>
							  <div class="pokeimg">
							    <img class="imgbackground" src="https://pokemoncalc.web.app/en/assets/pokeball.svg" alt="pokeball">
							    <img class="sprite" src="<?= $datapokemon[$i]['spriteM'] ?>" alt="<?= getTextLang($datapokemon[$i]['name']) ?>">
							  </div>
							</li>
							  <?php } ?>
</ol>
							

<?php for ($i = 0; $i < count($datapokemon); $i++) : ?>
<div class="overlay-poke hidden" id="overlay-poke-<?= $datapokemon[$i]['id'] ?>">
  <div class="overlay-content type-<?= strtolower(getTextLang($datapokemon[$i]['type1'], 'en')) ?>">

    <div class="overlay-left">
    <img class="overlay-pokemon-img" src="<?= $datapokemon[$i]['spriteM'] ?>" alt="<?= getTextLang($datapokemon[$i]['name']) ?>">

	  <img class="overlay-bg-pokeball" src="https://pokemoncalc.web.app/en/assets/pokeball.svg" alt="pokeball">



    <div class="overlay-attacks-toggle">
   <button class="btn-toggle-attacks" onclick="showAttacks(<?= $datapokemon[$i]['id'] ?>, <?= $datapokemon[$i]['generation'] ?>, '<?= strtolower(getTextLang($datapokemon[$i]['type1'], 'en')) ?>')">Attaques</button>

    </div>
    

      <div class="overlay-weak">
  <h3>Faiblesses / Résistances</h3>
  <div id="Table_type_<?= $datapokemon[$i]['id'] ?>" class="weakness-grid">

    <div id="Table_type1">
      <?php for ($t = 0; $t < count($dataType); $t++) {
        if ($dataType[$t]['id'] > 9) continue; ?>
        <div class="tab_Type <?= getTextLang($dataType[$t]['name'], 'en') ?>">
          <img class="type_img" src="../../public/img/<?= $dataType[$t]['sprite'] ?>">
        </div>
      <?php } ?>
      <?php for ($j = 0; $j < 9; $j++) { ?>
        <div class="Faibless_Resistance">
          <h2 class="Faibless_Resistance_Value" id="Faibless_Resistance_Value<?= $datapokemon[$i]['id'] ?>_<?= $j ?>"></h2>
        </div>
      <?php } ?>
    </div>

    <div id="Table_type2">
      <?php for ($t = 9; $t < count($dataType); $t++) {
        if ($dataType[$t]['id'] > 18) continue; ?>
        <div class="tab_Type <?= getTextLang($dataType[$t]['name'], 'en') ?>">
          <img class="type_img" src="../../public/img/<?= $dataType[$t]['sprite'] ?>">
        </div>
      <?php } ?>
      <?php for ($j = 9; $j < 18; $j++) { ?>
        <div class="Faibless_Resistance">
          <h2 class="Faibless_Resistance_Value" id="Faibless_Resistance_Value<?= $datapokemon[$i]['id'] ?>_<?= $j ?>"></h2>
        </div>
      <?php } ?>
    </div>

  </div>
</div>

    </div>

    <div class="overlay-right">
      <div class="overlay-header-line">
        <span class="overlay-id">#<?= str_pad($datapokemon[$i]['id'], 3, '0', STR_PAD_LEFT) ?></span>
        <span class="overlay-name"><?= getTextLang($datapokemon[$i]['name']) ?></span>
		
 <img
    class="overlay-gender"
    id="symbole-<?= $datapokemon[$i]['id'] ?>"
    src="<?= !empty($datapokemon[$i]['spriteM']) ? '../../public/img/M.png' : '../../public/img/F.png' ?>"
    data-sprite-m="<?= $datapokemon[$i]['spriteM'] ?>"
    data-sprite-f="<?= $datapokemon[$i]['spriteF'] ?>"
  />
<?php
  $spriteM = strtolower(trim($datapokemon[$i]['spriteM'] ?? ''));
  $spriteF = strtolower(trim($datapokemon[$i]['spriteF'] ?? ''));

  $showSwitch = !empty($spriteM) &&
                !empty($spriteF) &&
                $spriteM !== $spriteF &&
                $spriteF !== 'NULL' &&
                $spriteF !== 'undefined';
?>

<button class="switch-gender"
  onclick="switchGender(<?= $datapokemon[$i]['id'] ?>)"
  style="<?= $showSwitch ? '' : 'display: none;' ?>">
  <img src="../../public/img/switch.png" alt="Switch genre">
</button>






</div>

      <div class="overlay-types-meta">
        <span class="type-tag type1"><?= getTextLang($datapokemon[$i]['type1']) ?></span>
<?php if (!empty($datapokemon[$i]['type2'])) : ?>
  <span class="type-tag type2 type-<?= strtolower(getTextLang($datapokemon[$i]['type2'], 'en')) ?>">
    <?= getTextLang($datapokemon[$i]['type2']) ?>
  </span>
<?php endif; ?>

        <span class="overlay-category">
          <?php
            switch ($datapokemon[$i]['category']) {
              case 0: echo 'Commun'; break;
              case 1: echo 'Légendaire'; break;
              case 2: echo 'Fabuleux'; break;
              case 3: echo 'Ultra-Chimère'; break;
              case 4: echo 'Paradox'; break;
            }
          ?>
        </span>
        <span class="overlay-gen">Gen <?= $datapokemon[$i]['generation'] ?></span>
      </div>

      <div class="overlay-description"><?= getTextLang($datapokemon[$i]['description']) ?></div>

      <div class="overlay-physique">
        <div class="box-info">Taille<br><span><?= number_format($datapokemon[$i]['height'] / 10, 1, ',', ' ') ?> m</span></div>
        <div class="box-info">Poids<br><span><?= number_format($datapokemon[$i]['weight'] / 10, 1, ',', ' ') ?> kg</span></div>
      </div>

      <h3 class="section-title">Statistiques</h3>
      <div class="overlay-stats">
        <div class="stat-box stat-green"><span>PV</span><span><?= $datapokemon[$i]['hp'] ?></span></div>
        <div class="stat-box stat-yellow"><span>Attaque</span><span><?= $datapokemon[$i]['attack'] ?></span></div>
        <div class="stat-box stat-orange"><span>Défense</span><span><?= $datapokemon[$i]['defense'] ?></span></div>
        <div class="stat-box stat-blue2"><span>Attaque Spé</span><span><?= $datapokemon[$i]['atackspe'] ?></span></div>
        <div class="stat-box stat-blue"><span>Défense Spé</span><span><?= $datapokemon[$i]['defensespe'] ?></span></div>
        <div class="stat-box stat-purple"><span>Vitesse</span><span><?= $datapokemon[$i]['speed'] ?></span></div>
      </div>

      <h3 class="section-title">Talent</h3>
	  <div class="overlay-talents" id="talents-<?= $datapokemon[$i]['id'] ?>">

	  </div>
			  
    </div>

    <div class="overlay-evo" id="evo-overlay-<?= $datapokemon[$i]['id'] ?>"></div>

<div class="attacks-overlay hidden type-<?= strtolower($datapokemon[$i]['type1']) ?>" id="attacks-overlay-<?= $datapokemon[$i]['id'] ?>">

  <div class="attacks-header">
    <button onclick="hideAttacks(<?= $datapokemon[$i]['id'] ?>)">← Retour</button>
    
    <div id='atkTitle' style="display: flex; flex-direction: column;">
      <h2 id='TitleAtk' class='name_section'>Attaques</h2>
      
      <div id='atkButtons' style="display: flex; justify-content: center; align-items: center; gap: 10px; margin-top: 8px;">
        <button class='moreLessButton' onclick="changeGen(-1, <?= $datapokemon[$i]['id'] ?>)">
          ←
        </button>
        <label id='genAtk-<?= $datapokemon[$i]['id'] ?>'>gen 1</label>
        <button class='moreLessButton' onclick="changeGen(1, <?= $datapokemon[$i]['id'] ?>)">
          →
        </button>
      </div>
    </div>
  </div>

  <div id='Attaque-<?= $datapokemon[$i]['id'] ?>' class="attacks-table">

  </div>
</div>

  </div>
</div>
<?php endfor; ?>

<style>
  body {
    background: url('../public/img/fond.png') no-repeat center center fixed;
    background-size: cover;
  }
</style>



<div id="tooltip-evo" style="
  display: none;
  position: fixed;
  z-index: 9999;
  background: #fff;
  border: 1px solid #aaa;
  border-radius: 6px;
  padding: 8px;
  font-size: 12px;
  max-width: 240px;
  white-space: pre-line;
  box-shadow: 0 2px 6px rgba(0,0,0,0.2);
  pointer-events: none;
  color: black;
"></div>




</body>
</html>