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

</head>
<?php include_once 'header.php'; ?>

<body>

	
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
							      <li class="type"><?= getTextLang($datapokemon[$i]['type1']) ?></li>
							      <?php if ($datapokemon[$i]['type2']) : ?>
							        <li class="type"><?= getTextLang($datapokemon[$i]['type2']) ?></li>
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
		
        <img class="overlay-gender" 
     id="symbole-<?= $datapokemon[$i]['id'] ?>"
     src="../../public/img/M.png"
     data-sprite-m="<?= $datapokemon[$i]['spriteM'] ?>"
     data-sprite-f="<?= $datapokemon[$i]['spriteF'] ?>" />

      </div>

      <div class="overlay-types-meta">
        <span class="type-tag"><?= getTextLang($datapokemon[$i]['type1']) ?></span>
        <?php if (!empty($datapokemon[$i]['type2'])) : ?>
        <span class="type-tag"><?= getTextLang($datapokemon[$i]['type2']) ?></span>
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
        <div class="stat-box stat-red"><span>PV</span><span><?= $datapokemon[$i]['hp'] ?></span></div>
        <div class="stat-box stat-orange"><span>Attaque</span><span><?= $datapokemon[$i]['attack'] ?></span></div>
        <div class="stat-box stat-yellow"><span>Défense</span><span><?= $datapokemon[$i]['defense'] ?></span></div>
        <div class="stat-box stat-blue"><span>Attaque Spé</span><span><?= $datapokemon[$i]['atackspe'] ?></span></div>
        <div class="stat-box stat-green"><span>Défense Spé</span><span><?= $datapokemon[$i]['defensespe'] ?></span></div>
        <div class="stat-box stat-pink"><span>Vitesse</span><span><?= $datapokemon[$i]['speed'] ?></span></div>
      </div>

      <h3 class="section-title">Talent</h3>
	  <div class="overlay-talents" id="talents-<?= $datapokemon[$i]['id'] ?>">
	    <!-- Talents injectés -->
	  </div>
			  
    </div>

    <div class="overlay-evo" id="evo-overlay-<?= $datapokemon[$i]['id'] ?>"></div>

  </div>
</div>
<?php endfor; ?>

<style>
  body {
    background: url('../public/img/fond.png') no-repeat center center fixed;
    background-size: cover;
  }
</style>


<script>

// --- 1. Animation de zoom lors de l'apparition des Pokémon 
document.addEventListener("DOMContentLoaded", () => {
  const pokemons = document.querySelectorAll(".pokemon");

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("visible");
      } else {
        entry.target.classList.remove("visible");
      }
    });
  }, {
    threshold: 0.1
  });

  pokemons.forEach(p => observer.observe(p));
});

// --- 2. Recherche et filtres
document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.getElementById("searchBarInput");
  const filterGen = document.getElementById("gen");
  const filterType = document.getElementById("type");
  const filterRarete = document.getElementById("rarete");

  function applyFilters() {
    const search = searchInput.value.toLowerCase();
    const gen = filterGen.value;
    const type = filterType.value;
    const rarete = filterRarete.value;

    document.querySelectorAll(".pokemon").forEach(poke => {
      const name = poke.dataset.name.toLowerCase();
      const pokeGen = poke.dataset.gen;
      const pokeType = poke.dataset.type.toLowerCase();
      const pokeCat = poke.dataset.category;

      const matchName = name.includes(search);
      const matchGen = (gen === "all" || pokeGen === gen);
      const matchType = (type === "all" || pokeType.includes(type.toLowerCase()));
      const matchRarete = (rarete === "all" || pokeCat === rarete);

      poke.style.display = (matchName && matchGen && matchType && matchRarete) ? "" : "none";
    });
  }
// Événements sur les filtres
  searchInput.addEventListener("input", applyFilters);
  filterGen.addEventListener("change", applyFilters);
  filterType.addEventListener("change", applyFilters);
  filterRarete.addEventListener("change", applyFilters);
});


// --- 3. Affichage de l'overlay au clic sur un Pokémon
document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM chargé");
  const pokemons = document.querySelectorAll(".pokemon");
  console.log("Nb de .pokemon trouvés :", pokemons.length);
  
  
  pokemons.forEach(pokemon => {
    pokemon.addEventListener("click", () => {
      const id = pokemon.dataset.id;
      console.log("Clic sur Pokémon ID =", id);
      // Cache tous les overlays
      document.querySelectorAll(".overlay-poke").forEach(o => o.classList.add("hidden"));
      const overlay = document.getElementById("overlay-poke-" + id);
      console.log("Overlay trouvé ?", overlay !== null);
      
      if (overlay) {
  overlay.classList.remove("hidden");
   // Charge les données dynamiques
  LoadAbilityPokemon(id); 
  LoadEvoOverlay(id);
    const typeEfficiency = pokemon.dataset.typeefficiency;
  if (typeEfficiency && typeEfficiency !== "null") {
    LoadWeaknesses(id, typeEfficiency);
  }


// Ferme l'overlay si clic en dehors

  overlay.addEventListener("click", function handler(e) {
    if (!e.target.closest(".overlay-content")) {
      overlay.classList.add("hidden");
      overlay.removeEventListener("click", handler);
    }
  });
}

    });
  });
});


// --- 4. Fonction multilangue
function getTextLang(jsText) {
  const parts = jsText.split("///");
  return parts.length > 1 ? parts[1] : parts[0];
}


// --- 5. Chargement des talents du Pokémon
async function LoadAbilityPokemon(id) {
  const container = document.getElementById("talents-" + id);
  if (!container) return;

  container.innerHTML = "";

  const res = await fetch(`../database/get/FromJS/getDBDataPokedex.php?request=GetAbilityData&1=${id}`);
  const talents = await res.json();

  talents.forEach(t => {
    const wrapper = document.createElement("div");
    wrapper.classList.add("box-info");

    const name = document.createElement("span");
    name.textContent = getTextLang(t.name);

    const infoWrapper = document.createElement("div");
    infoWrapper.classList.add("info-wrapper");

    const info = document.createElement("span");
    info.classList.add("info-icon");
    info.textContent = "i";

    const tooltip = document.createElement("div");
    tooltip.classList.add("tooltip");
    tooltip.textContent = getTextLang(t.smallDescription);

    infoWrapper.appendChild(info);
    infoWrapper.appendChild(tooltip);

    wrapper.appendChild(name);
    wrapper.appendChild(infoWrapper);

    container.appendChild(wrapper);
  });
}


// --- 6. Chargement de l'évolution 
async function LoadEvoOverlay(id) {
  const container = document.getElementById("evo-overlay-" + id);
  const overlay = document.getElementById("overlay-poke-" + id); // ✅ cette ligne était manquante

  if (!container) return;

  const res = await fetch(`../database/get/FromJS/getDBDataPokedex.php?request=GetEvolutionData&1=${id}`);
  const dataEvol = await res.json();
  if (!Array.isArray(dataEvol)) {
    container.style.display = "none";
    return;
  }

  container.innerHTML = "";
  dataEvol.sort((a, b) => a.evolutionStade - b.evolutionStade);

  const stageMap = {};
  const added = new Set();

   // Fonction pour afficher un Pokémon dans la chaîne évolution
  const addPokemon = (id, name, sprite, stage, level) => {
    const stageKey = "stage-" + stage;
    if (!stageMap[stageKey]) {
      const stageDiv = document.createElement("div");
      stageDiv.className = "evo-step";
      stageDiv.id = stageKey;
      container.appendChild(stageDiv);
      stageMap[stageKey] = stageDiv;
    }

    const pokeWrapper = document.createElement("div");
    pokeWrapper.className = "evo-box";

    const img = document.createElement("img");
    img.src = sprite;
    img.classList.add("img_evo");
    pokeWrapper.appendChild(img);

    pokeWrapper.title = name;

    pokeWrapper.addEventListener("click", () => {
      document.getElementById(id)?.scrollIntoView({ behavior: "smooth" });
    });

    stageMap[stageKey].appendChild(pokeWrapper);

    const levelLabel = document.createElement("div");
    levelLabel.className = "lvl";
    levelLabel.textContent = (level && level > 0) ? `Nv ${level}` : '';
    stageMap[stageKey].appendChild(levelLabel);
  };

  // Ajout des pokémon à l'affichage
  dataEvol.forEach(evo => {
    if (!added.has(evo.id1)) {
      addPokemon(evo.id1, evo.n1, evo.s1, evo.evolutionStade, null);
      added.add(evo.id1);
    }
    if (!added.has(evo.id2)) {
      addPokemon(evo.id2, evo.n2, evo.s2, evo.evolutionStade + 1, evo.minLevel);
      added.add(evo.id2);
    }
  });
// Flèches entre les stades d'évolution
  const keys = Object.keys(stageMap).sort((a, b) =>
    parseInt(a.split("-")[1]) - parseInt(b.split("-")[1])
  );

  for (let i = 0; i < keys.length - 1; i++) {
    const arrow = document.createElement("span");
    arrow.className = "arrow";
    arrow.textContent = "→";
    container.insertBefore(arrow, stageMap[keys[i + 1]]);
  }

  // Partie genre
  const genderIcon = document.getElementById("symbole-" + id);
if (genderIcon) {
  const spriteF = genderIcon.dataset.spriteF;
  const spriteM = genderIcon.dataset.spriteM;

  if (spriteF && spriteF.toLowerCase() !== "null") {
    genderIcon.src = "../../public/img/F.png";
    const imgDiv = document.getElementById("img");
    if (imgDiv) imgDiv.style.backgroundImage = "url('" + spriteF + "')";
  } else {
    genderIcon.src = "../../public/img/M.png";
    const imgDiv = document.getElementById("img");
    if (imgDiv) imgDiv.style.backgroundImage = "url('" + spriteM + "')";
  }
}

}

// --- 7. Faiblesses / Résistances
function LoadWeaknesses(id, typeEfficiencyString) {
  const values = typeEfficiencyString?.split("/")?.slice(1) ?? [];
  for (let i = 0; i < 18; i++) {
    const elem = document.getElementById(`Faibless_Resistance_Value${id}_${i}`);
    if (!elem || !values[i]) continue;

    const val = `x${values[i]}`;
    elem.innerText = val;

    switch (val) {
      case "x0.25":
        elem.style.background = 'radial-gradient(circle, rgba(34,255,0,1) 7%, rgba(50,200,41,1) 21%, rgba(53,201,24,1) 48%, rgba(67,240,23,1) 64%, rgba(13,200,3,1) 90%)';
        elem.style.fontSize = "7px";
        break;
      case "x0.5":
        elem.style.background = 'radial-gradient(circle, rgba(157,252,142,1) 7%, rgba(138,231,132,1) 21%, rgba(115,194,99,1) 48%, rgba(129,237,101,1) 64%, rgba(125,196,121,1) 90%)';
        break;
      case "x0":
        elem.style.background = 'radial-gradient(circle, rgba(142,142,142,1) 7%, rgba(184,184,184,1) 21%, rgba(133,128,128,1) 48%, rgba(181,178,178,1) 64%, rgba(94,94,94,1) 90%)';
        break;
      case "x1":
        elem.style.background = 'radial-gradient(circle, rgba(255,218,89,1) 7%, rgba(210,160,82,1) 21%, rgba(246,208,64,1) 48%, rgba(213,172,70,1) 64%, rgba(255,198,51,1) 90%)';
        break;
      case "x2":
        elem.style.background = 'radial-gradient(circle, rgba(255,119,119,1) 7%, rgba(193,88,88,1) 21%, rgba(232,106,106,1) 48%, rgba(207,69,69,1) 64%, rgba(255,93,93,1) 90%)';
        break;
      case "x4":
        elem.style.background = 'radial-gradient(circle, rgba(193,31,31,1) 7%, rgba(207,81,81,1) 21%, rgba(193,16,16,1) 48%, rgba(237,12,12,1) 64%, rgba(157,2,2,1) 90%)';
        break;
    }
  }
}



</script>


</body>
</html>