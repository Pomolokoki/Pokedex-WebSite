document.querySelectorAll('.pokemon')

  // --- Genre
function switchGender(id) {
  console.log("Switch click ID =", id);
  const symbole = document.getElementById("symbole-" + id);
  const spriteM = symbole.getAttribute("data-sprite-m");
  const spriteF = symbole.getAttribute("data-sprite-f");

  const overlay = document.getElementById("overlay-poke-" + id);
  const pokemonImg = overlay.querySelector(".overlay-pokemon-img");
  console.log("Image trouvée :", pokemonImg);
  console.log("spriteM =", spriteM);
console.log("spriteF =", spriteF);


  if (!symbole || !pokemonImg) return;

  const isCurrentlyM = symbole.src.includes("M.png");

  if (isCurrentlyM && spriteF && spriteF.toLowerCase() !== "null") {
    symbole.src = "../../public/img/F.png";
    pokemonImg.src = spriteF;
  } else if (spriteM && spriteM.toLowerCase() !== "null") {
    symbole.src = "../../public/img/M.png";
    pokemonImg.src = spriteM;
  }
}



  // --- Fonction multilangue
function getTextLang(jsText) {
  const parts = jsText.split("///");
  return parts.length > 1 ? parts[1] : parts[0];
}

const GEN_MIN_BY_POKEMON = {}; 
const TYPE_BY_POKEMON = {};



  // --- Attaques 
function showAttacks(id, gen, type) {
  GEN_MIN_BY_POKEMON[id] = gen;
  TYPE_BY_POKEMON[id] = type;
  document.querySelector(`#attacks-overlay-${id}`).classList.remove('hidden');
  LoadAtkPokemon(id, gen);
}


function hideAttacks(id) {
  document.querySelector(`#attacks-overlay-${id}`).classList.add('hidden');
}

function changeGen(delta, id) {
  const label = document.getElementById(`genAtk-${id}`);
  let currentGen = parseInt(label.innerText.replace("gen ", ""));
  let newGen = currentGen + delta;

  const minGen = GEN_MIN_BY_POKEMON[id] ?? 1;
  if (newGen < minGen || newGen > 9) return;

  LoadAtkPokemon(id, newGen);
}

function LoadAtkPokemon(id, gen = 1) {
  const container = document.getElementById("Attaque-" + id);
  const genLabel = document.getElementById("genAtk-" + id);
  if (!container || !genLabel) return;

  fetch("../database/get/FromJS/getDBDataPokedex.php?request=GetMoveData&1=" + id + "&2=" + gen)
    .then((res) => res.json())
    .then((data) => {
      container.innerHTML = "";

      if (!Array.isArray(data) || data.length === 0) {
        container.innerHTML = "<p>Aucune attaque trouvée pour cette génération.</p>";
        genLabel.textContent = `gen ${gen}`;
        return;
      }

      // Appliquer la couleur de fond (type du Pokémon)
      const overlay = document.querySelector(`#attacks-overlay-${id}`);
overlay.className = overlay.className.replace(/\btype-\w+\b/g, '').trim();

const type = TYPE_BY_POKEMON[id];
if (type) {
  overlay.classList.add("type-" + type.toLowerCase());
}

      // TRI
      data.sort((a, b) => (a.learnAtLevel ?? 999) - (b.learnAtLevel ?? 999));

      const table = document.createElement("table");
      table.className = "attacks-table-inner";

      const header = document.createElement("tr");
      ["Nom", "Type", "Puissance", "Précision", "PP", "Catégorie", "Appris"].forEach((text) => {
        const th = document.createElement("th");
        th.textContent = text;
        header.appendChild(th);
      });
      table.appendChild(header);

      data.forEach((atk) => {
        const row = document.createElement("tr");

        const tdName = document.createElement("td");
        tdName.textContent = getTextLang(atk.name) ?? "-";
        row.appendChild(tdName);

        const tdType = document.createElement("td");
        tdType.textContent = getTextLang(atk.type) ?? "-";
        row.appendChild(tdType);

        const tdPower = document.createElement("td");
        tdPower.textContent = atk.pc ?? "--";
        row.appendChild(tdPower);

        const tdAcc = document.createElement("td");
        tdAcc.textContent = atk.accuracy ?? "--";
        row.appendChild(tdAcc);

        const tdPP = document.createElement("td");
        tdPP.textContent = atk.pp ?? "--";
        row.appendChild(tdPP);

        const tdCat = document.createElement("td");
        if (atk.effectType == 1) tdCat.textContent = "Physique";
        else if (atk.effectType == 2) tdCat.textContent = "Spéciale";
        else tdCat.textContent = "Statut";
        row.appendChild(tdCat);

        const tdLearn = document.createElement("td");
        const method = getTextLang(atk.learnMethod ?? "");
        const level = atk.learnAtLevel ?? "?";

        if (method.includes("Montée de niveau") || method.includes("Level up"))
          tdLearn.textContent = "niveau " + level;
        else if (method.includes("Capsule") || method.includes("Machine"))
          tdLearn.textContent = "CT/CS";
        else
          tdLearn.textContent = method;

        row.appendChild(tdLearn);
        table.appendChild(row);
      });

      container.appendChild(table);
      genLabel.textContent = `gen ${gen}`;

      // GESTION DES FLÈCHES
      const leftArrow = document.querySelector(`#attacks-overlay-${id} .moreLessButton:first-child`);
      const rightArrow = document.querySelector(`#attacks-overlay-${id} .moreLessButton:last-child`);

      leftArrow.style.display = "inline-block";
      rightArrow.style.display = "inline-block";

      const minGen = GEN_MIN_BY_POKEMON[id] ?? 1;
      const genPrev = gen - 1;
      const genNext = gen + 1;

if (genPrev < minGen) {
  leftArrow.style.visibility = "hidden";
} else {
  fetch(`../database/get/FromJS/getDBDataPokedex.php?request=GetMoveData&1=${id}&2=${genPrev}`)
    .then(r => r.json())
    .then(d => {
      leftArrow.style.visibility = (d && d.length > 0) ? "visible" : "hidden";
    });
}

if (genNext > 9) {
  rightArrow.style.visibility = "hidden";
} else {
  fetch(`../database/get/FromJS/getDBDataPokedex.php?request=GetMoveData&1=${id}&2=${genNext}`)
    .then(r => r.json())
    .then(d => {
      rightArrow.style.visibility = (d && d.length > 0) ? "visible" : "hidden";
    });
}

    })
    .catch(() => {
      container.innerHTML = "<p>Erreur de chargement des attaques.</p>";
    });
}


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
  const search = searchInput.value.toLowerCase().trim();
  const gen = filterGen.value;
  const type = filterType.value;
  const rarete = filterRarete.value;

  document.querySelectorAll(".pokemon").forEach(poke => {
    const name = poke.dataset.name.toLowerCase();
    const pokeId = poke.dataset.id.padStart(3, '0'); // ex: "6" devient "006"
    const pokeGen = poke.dataset.gen;
    const pokeType = poke.dataset.type.toLowerCase();
    const pokeCat = poke.dataset.category;

    const matchName = name.includes(search);
    const matchId = pokeId.includes(search);
    const matchGen = (gen === "all" || pokeGen === gen);
    const matchType = (type === "all" || pokeType.includes(type.toLowerCase()));
    const matchRarete = (rarete === "all" || pokeCat === rarete);

    poke.style.display = ((matchName || matchId) && matchGen && matchType && matchRarete) ? "" : "none";
  });
}

// Événements sur les filtres
  searchInput.addEventListener("input", applyFilters);
  filterGen.addEventListener("change", applyFilters);
  filterType.addEventListener("change", applyFilters);
  filterRarete.addEventListener("change", applyFilters);
});
const searchInput = document.getElementById('searchBarInput');
const clearIcon = document.getElementById('clearSearch');

searchInput.addEventListener('input', () => {
  clearIcon.style.display = searchInput.value ? 'inline' : 'none';
});

clearIcon.addEventListener('click', () => {
  searchInput.value = '';
  clearIcon.style.display = 'none';
  searchInput.dispatchEvent(new Event('input')); // relancer le filtrage
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
document.addEventListener("mousemove", (e) => {
  const tooltip = document.getElementById("tooltip-evo");
  if (tooltip && tooltip.style.display === "block") {
    tooltip.style.left = e.clientX + 15 + "px";
    tooltip.style.top = e.clientY - tooltip.offsetHeight - 15 + "px";
  }
});




// --- 6. Chargement de l'évolution 
async function LoadEvoOverlay(id) {
  const container = document.getElementById("evo-overlay-" + id);
  if (!container) return;

  const evoData = await fetch(`../database/get/FromJS/getDBDataPokedex.php?request=GetEvolutionData&1=${id}`)
    .then(res => res.json());

  if (!Array.isArray(evoData)) {
    container.style.display = "none";
    return;
  }

  container.innerHTML = "";
  
  const tooltip = document.getElementById("tooltip-evo");

  // Exceptions
  let chain = evoData.filter(evo => {
    // Exclure Zigzaton Galar
    if (evo.id1 == 10174 || evo.id2 == 10174) return false;
    // Supprimer "Niveau" de Berserkatt
    if (evo.id2 == 863) evo.minLevel = null;
    return true;
  });

  // --- CAS M. MIME / M. GLAQUETTE
if (
  [439, 122, 10168, 866].includes(id) ||
  chain.some(e => [439, 122, 10168, 866].includes(e.id1) || [439, 122, 10168, 866].includes(e.id2))
) {
    container.innerHTML = `
      <div class="manual-evo-mime">
        <div class="evo-box evo-click" data-id="439">
          <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/439.png" class="img_evo">
        </div>
        <span class="arrow">→</span>
        <div class="evo-box evo-click" data-id="122">
          <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/122.png" class="img_evo">
        </div>
        <div class="divider-mime"></div>
        <div class="evo-box evo-click" data-id="10168">
          <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/10168.png" class="img_evo">
        </div>
        <span class="arrow">→</span>
        <div class="evo-box evo-click" data-id="866">
          <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/866.png" class="img_evo">
          <div class="lvl">Nv 42</div>
        </div>
      </div>
    `;
// as spéciaux (Mime et Verpom)
container.querySelectorAll(".evo-click").forEach(div => {
  const pokeId = div.dataset.id;

  // Événement de clic (affichage overlay)
  div.addEventListener("click", () => {
    const overlay = document.getElementById("overlay-poke-" + pokeId);
    document.querySelectorAll(".overlay-poke").forEach(o => o.classList.add("hidden"));
    if (overlay) {
      overlay.classList.remove("hidden");
      LoadAbilityPokemon(pokeId);
      LoadEvoOverlay(pokeId);
      const typeEfficiency = document.querySelector(`[data-id="${pokeId}"]`)?.dataset.typeefficiency;
      if (typeEfficiency && typeEfficiency !== "null") {
        LoadWeaknesses(pokeId, typeEfficiency);
      }
      overlay.addEventListener("click", function handler(e) {
        if (!e.target.closest(".overlay-content")) {
          overlay.classList.add("hidden");
          overlay.removeEventListener("click", handler);
        }
      });
    }
  });

  // tooltips
  const img = div.querySelector("img");
  if (img) {
    img.addEventListener("mouseenter", () => {
      const evoItem = evoData.find(e => e.id2 == pokeId);
      tooltip.innerHTML = evoItem ? getTooltipHTML(evoItem) : "Pas d'évolution spéciale";
      tooltip.style.display = "block";
    });
    img.addEventListener("mouseleave", () => {
      tooltip.style.display = "none";
    });
  }
});


  return;
}

// --- CAS VERPOM
if (
  [840, 1011, 842, 841, 1019].includes(id) ||
  chain.some(e => [840, 1011, 842, 841, 1019].includes(e.id1) || [840, 1011, 842, 841, 1019].includes(e.id2))
) {
    container.innerHTML = `
      <div class="manual-evo-mime">
        <div class="evo-box evo-click" data-id="840">
          <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/840.png" class="img_evo">
        </div>
        <span class="arrow">→</span>
        <div class="evo-box evo-click" data-id="1011">
          <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/1011.png" class="img_evo">
        </div>
        <div class="evo-box evo-click" data-id="842">
          <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/842.png" class="img_evo">
        </div>
        <div class="divider-pom"></div>
        <div class="evo-box evo-click" data-id="841">
          <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/841.png" class="img_evo">
        </div>
        <span class="arrow">→</span>
        <div class="evo-box evo-click" data-id="1019">
          <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/1019.png" class="img_evo">
        </div>
      </div>
    `;


container.querySelectorAll(".evo-click").forEach(div => {
  const pokeId = div.dataset.id;


  div.addEventListener("click", () => {
    const overlay = document.getElementById("overlay-poke-" + pokeId);
    document.querySelectorAll(".overlay-poke").forEach(o => o.classList.add("hidden"));
    if (overlay) {
      overlay.classList.remove("hidden");
      LoadAbilityPokemon(pokeId);
      LoadEvoOverlay(pokeId);
      const typeEfficiency = document.querySelector(`[data-id="${pokeId}"]`)?.dataset.typeefficiency;
      if (typeEfficiency && typeEfficiency !== "null") {
        LoadWeaknesses(pokeId, typeEfficiency);
      }
      overlay.addEventListener("click", function handler(e) {
        if (!e.target.closest(".overlay-content")) {
          overlay.classList.add("hidden");
          overlay.removeEventListener("click", handler);
        }
      });
    }
  });

  const img = div.querySelector("img");
  if (img) {
    img.addEventListener("mouseenter", () => {
      const evoItem = evoData.find(e => e.id2 == pokeId);
      tooltip.innerHTML = evoItem ? getTooltipHTML(evoItem) : "Pas d'évolution spéciale";
      tooltip.style.display = "block";
    });
    img.addEventListener("mouseleave", () => {
      tooltip.style.display = "none";
    });
  }
});


  return;
}


  // Ajout manuel de Ixon
  if (id == 263 || id == 264 || id == 862 || chain.some(e => [263, 264, 862].includes(e.id1) || [263, 264, 862].includes(e.id2))) {
    chain = chain.filter(e => ![10174].includes(e.id1) && ![10174].includes(e.id2));
    chain.push({
      id1: 264,
      id2: 862,
      n1: "Linéon",
      n2: "Ixon",
      s1: "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/264.png",
      s2: "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/862.png",
      evolutionStade: 2,
      minLevel: 35
    });
  }

  const stageMap = {};
  const added = new Set();

  function getTooltipHTML(data) {
    let html = "";
    if (data.evolutionTrigger && getTextLang(data.evolutionTrigger) !== "Level up") {
      html += getTextLang(data.evolutionTrigger) + "<br>";
    }
    if (data.gender != null) html += data.gender == 1 ? "Si femelle (♀)<br>" : "Si mâle (♂)<br>";
    if (data.it1name) html += `<img src="${data.it1sprite}"><br>`;
    if (data.it2name) html += `<img src="${data.it2sprite}"><br>`;
    if (data.moveName) html += "- Doit maîtriser " + getTextLang(data.moveName) + "<br>";
    if (data.tyName) html += "- Doit maîtriser " + getTextLang(data.tyName) + "<br>";
    if (data.locationName) html += "- Lieu : " + getTextLang(data.locationName) + "<br>";
    if (data.minAffection) html += "- Affection ≥ " + data.minAffection + "<br>";
    if (data.minBeauty) html += "- Beauté ≥ " + data.minBeauty + "<br>";
    if (data.minHappiness) html += "- Bonheur ≥ " + data.minHappiness + "<br>";
    if (data.minLevel) html += "- Niveau " + data.minLevel + "<br>";
    if (data.needsOverworldRain) html += "Pling Pling Plong<br>";
    if (data.n3) html += "- Avec " + getTextLang(data.n3) + " dans l'équipe<br>";
    if (data.ty2Name) html += "- Avec un Pokémon de type " + getTextLang(data.ty2Name) + " dans l'équipe<br>";
    if (data.relativePhysicalStats != null)
      html += data.relativePhysicalStats === 1 ? "- Attaque > Défense<br>" : "- Défense > Attaque<br>";
    if (data.timeOfDay)
      html += data.timeOfDay === "day" ? "- De jour<br>" : data.timeOfDay === "night" ? "- De nuit<br>" : "- Nuit de pleine lune<br>";
    if (data.n4) html += "- Avec " + getTextLang(data.n4) + "<br>";
    if (data.turnUpSideDown) html += "- En retournant la console<br>";
    return html.trim();
  }

  const addPokemon = (pokeId, name, sprite, stage, level) => {
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

    img.addEventListener("mouseenter", () => {
      const evoData = chain.find(e => e.id2 == pokeId);
      if (evoData) {
        tooltip.innerHTML = getTooltipHTML(evoData);
        tooltip.style.display = "block";
      }
    });

    img.addEventListener("mouseleave", () => {
      tooltip.style.display = "none";
    });

    pokeWrapper.appendChild(img);

    pokeWrapper.addEventListener("click", () => {
      const overlay = document.getElementById("overlay-poke-" + pokeId);
      document.querySelectorAll(".overlay-poke").forEach(o => o.classList.add("hidden"));
      if (overlay) {
        overlay.classList.remove("hidden");
        LoadAbilityPokemon(pokeId);
        LoadEvoOverlay(pokeId);
        const typeEfficiency = document.querySelector(`[data-id="${pokeId}"]`)?.dataset.typeefficiency;
        if (typeEfficiency && typeEfficiency !== "null") {
          LoadWeaknesses(pokeId, typeEfficiency);
        }
        overlay.addEventListener("click", function handler(e) {
          if (!e.target.closest(".overlay-content")) {
            overlay.classList.add("hidden");
            overlay.removeEventListener("click", handler);
          }
        });
      }
    });

    stageMap[stageKey].appendChild(pokeWrapper);

    const levelLabel = document.createElement("div");
    levelLabel.className = "lvl";
    levelLabel.textContent = (level && level > 0) ? `Nv ${level}` : '';
    stageMap[stageKey].appendChild(levelLabel);
  };

  chain.sort((a, b) => a.evolutionStade - b.evolutionStade);
  chain.forEach(evo => {
    if (!added.has(evo.id1)) {
      addPokemon(evo.id1, evo.n1, evo.s1, evo.evolutionStade, null);
      added.add(evo.id1);
    }
if (!added.has(evo.id2)) {
  // Barre verticale entre M. Mime et M. Glaquette
  if (evo.id1 === 122 && evo.id2 === 10168) {
    const divider = document.createElement("div");
    divider.className = "divider-mime";
    container.appendChild(divider);
  }

  addPokemon(evo.id2, evo.n2, evo.s2, evo.evolutionStade + 1, evo.minLevel);
  added.add(evo.id2);
}

  });
  

  const keys = Object.keys(stageMap).sort((a, b) =>
    parseInt(a.split("-")[1]) - parseInt(b.split("-")[1])
  );

  for (let i = 0; i < keys.length - 1; i++) {
    const arrow = document.createElement("span");
    arrow.className = "arrow";
    arrow.textContent = "→";
    container.insertBefore(arrow, stageMap[keys[i + 1]]);
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
        //elem.style.background = 'radial-gradient(circle, rgba(34,255,0,1) 7%, rgba(50,200,41,1) 21%, rgba(53,201,24,1) 48%, rgba(67,240,23,1) 64%, rgba(13,200,3,1) 90%)';
        elem.style.background = 'radial-gradient(circle, rgb(34, 255, 0) 7%, rgb(9, 176, 0) 90%)';
        elem.style.fontSize = "7px";
        break;
      case "x0.5":
        //elem.style.background = 'radial-gradient(circle, rgba(157,252,142,1) 7%, rgba(138,231,132,1) 21%, rgba(115,194,99,1) 48%, rgba(129,237,101,1) 64%, rgba(125,196,121,1) 90%)';
        elem.style.background = 'radial-gradient(circle, rgb(131, 248, 113) 7%,rgb(89, 178, 67) 84%)';
        elem.style.fontSize = "9px";
        break;
      case "x0":
        elem.style.background = 'radial-gradient(circle, rgb(142, 142, 142) 40%,rgb(94, 94, 94) 90%)';

        break;
      case "x1":
        //elem.style.background = 'radial-gradient(circle, rgba(255,218,89,1) 7%, rgba(210,160,82,1) 21%, rgba(246,208,64,1) 48%, rgba(213,172,70,1) 64%, rgba(255,198,51,1) 90%)';
                elem.style.background = 'radial-gradient( rgb(255, 218, 89) 40%, rgb(191, 154, 61) 90%)';
        break;
      case "x2":
        //elem.style.background = 'radial-gradient(circle, rgba(255,119,119,1) 7%, rgba(193,88,88,1) 21%, rgba(232,106,106,1) 48%, rgba(207,69,69,1) 64%, rgba(255,93,93,1) 90%)';
        elem.style.background = 'radial-gradient(circle, rgb(255, 119, 119) 7%, rgb(207, 69, 69) 84%)';
        break;
      case "x4":
        //elem.style.background = 'radial-gradient(circle, rgba(193,31,31,1) 7%, rgba(207,81,81,1) 21%, rgba(193,16,16,1) 48%, rgba(237,12,12,1) 64%, rgba(157,2,2,1) 90%)';
        elem.style.background = 'radial-gradient(circle, rgb(193, 31, 31) 35%, rgb(157, 2, 2) 90%)';
        break;
    }
  }
}
document.addEventListener("DOMContentLoaded", () => {
  let index = 0;
  let pokemons = Array.from(document.querySelectorAll(".pokemon")).filter(p => p.offsetParent !== null);

  const highlightPokemon = (i) => {
    pokemons.forEach(p => p.classList.remove("selected-keyboard"));
    const selected = pokemons[i];
    selected?.classList.add("selected-keyboard");
    selected?.scrollIntoView({ behavior: "smooth", block: "center" });
  };


  if (pokemons.length > 0) highlightPokemon(index);

  document.addEventListener("keydown", (e) => {

    pokemons = Array.from(document.querySelectorAll(".pokemon")).filter(p => p.offsetParent !== null);

    if (pokemons.length === 0) return;

    if (e.key === "ArrowDown") {
      e.preventDefault();
      index = (index + 1) % pokemons.length;
      highlightPokemon(index);
    }

    if (e.key === "ArrowUp") {
      e.preventDefault();
      index = (index - 1 + pokemons.length) % pokemons.length;
      highlightPokemon(index);
    }

    if (e.key === "Enter") {
      e.preventDefault();
      pokemons[index]?.click();
    }
  });
});


