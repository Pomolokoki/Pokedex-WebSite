var last_id = "x";
var pokemons = document.getElementsByClassName("pokemon");
var core = document.getElementById("core");
var Pokemon = document.createElement("div");
var content = document.getElementById("conteneur")
var dataPokemon = undefined;

var TableColor = {
  Acier: ["605e5e", "969494"],
  Combat: ["ffb400", "7d5f05"],
  Dragon: ["154ee4", "5606b1"],
  Eau: ["2167ff", "171ad2"],
  Électrik: ["ffdc00", "9f9800"],
  Fée: ["fa62d3", "da0b87"],
  Feu: ["f40e0e", "860000"],
  Glace: ["0effff", "078990"],
  Insecte: ["bbff02", "57be0f"],
  Normal: ["d0d0cf", "918f8f"],
  Plante: ["00ff15", "0a7000"],
  Poison: ["be33ed", "6c0279"],
  Psy: ["b857be", "c113aa",],
  Roche: ["bda777", "6c551e"],
  Sol: ["be8f2a", "573d02"],
  Spectre: ["a05da2", "4f1154"],
  Ténèbres: ["776e77", "1a161b"],
  Vol: ["71d2ff", "006f9e"]
};

var colorStat = ["#9afd7c", "#fff26b", "#ffb15c", "#7cfeff", "#6da2ff", "#c67bff"]

var language = "Fr";


document.getElementById('gender_button').addEventListener('click', function () {
  if (dataPokemon != undefined && dataPokemon["spriteF"] != null) {
    document.getElementById("img").style.backgroundImage = "url('" + dataPokemon["spriteF"] + "')";
  }
  if (document.getElementById("symbole").getAttribute("src") === "./img/M.png") {
    document.getElementById("symbole").src = "./img/F.png";
  }
  else {
    document.getElementById("img").style.backgroundImage = "url('" + dataPokemon["spriteM"] + "')";
    document.getElementById("symbole").src = "./img/M.png";
  }
});

document.getElementById('gen-').addEventListener('click', function () {
  let menos = document.getElementById('genAtk');
  if (menos.innerHTML.match(/\d+/)[0] == parseInt(document.getElementById("gen_Pokemon").innerText.match(/\d+/)[0]))
    return
  menos.innerHTML = "Gen : " + parseInt(menos.innerHTML.match(/\d+/)[0] - 1);
  LoadAtkPokemon(last_id);
});

document.getElementById('gen+').addEventListener('click', function () {
  let mas = document.getElementById('genAtk');
  if (mas.innerHTML.match(/\d+/)[0] == 9)
    return
  mas.innerHTML = "Gen : " + parseInt(parseInt(mas.innerHTML.match(/\d+/)[0]) + 1);
  LoadAtkPokemon(last_id);
});

function getText(str, lang = "fr") {
  if (lang === "fr") {
    if (str.split('/')[1] == "NULL")
      return str.split('/')[0];
    return str.split('/')[1];
  }
  else
    return str.split('/')[0];
}

function isNumber(value) {

  let reg = new RegExp('^[0-9]+$')
  return reg.test(value)
}

function filtre() {
  let gen, type, rarete, searchBar;
  gen = document.getElementById('gen').value;
  type = document.getElementById('type').value;
  rarete = document.getElementById('rarete').value;
  searchBar = document.querySelector('#searchBar input').value.toLowerCase();
  [...document.querySelectorAll(".pokemon")].forEach(pokemon => {
    pokemon.style.display = "none";
  });
  if (gen != 'all')
    gen = "[data-gen='" + gen + "']";
  else
    gen = "";
  if (type != 'all')
    type = "[data-type*='" + type + "']";
  else
    type = "";
  if (rarete != 'all')
    rarete = "[data-category='" + rarete + "']";
  else
    rarete = "";
  if (searchBar != '')
    if (isNumber(searchBar))
      searchBar = "[data-id*='" + searchBar + "']";
    else
      searchBar = "[data-name*='" + searchBar + "']";
  else
    searchBar = "";
  [...document.querySelectorAll(".pokemon" + gen + type + rarete + searchBar)].forEach(pokemon => {
    pokemon.style.display = "inline-block";
  });
}

// filtre 1
document.getElementById('gen').addEventListener('change', filtre);

// filtre 2
document.getElementById('type').addEventListener('change', filtre);

// filtre 3
document.getElementById('rarete').addEventListener('change', filtre);

// search bar
document.getElementById('searchBar').addEventListener('input', filtre);

function orderGrid() {
  let array = document.getElementsByClassName("Val_atk_case")
  for (let i = 0; i < array.length; i++) {
    if (typeof array[i] != "object") {
      continue
    }
    if (array[i].innerHTML == "Œuf") {
      let classTmp = array[i].classList[1];
      let tmpTab = document.getElementsByClassName(classTmp);
      setOrder(tmpTab, 0);
    }
    else if (array[i].innerHTML.includes("niveau ")) {
      let classTmp = array[i].classList[1];
      let tmpTab = document.getElementsByClassName(classTmp);
      setOrder(tmpTab, parseInt(array[i].innerHTML.match(/(\d+)/)));
    }
    if (array[i].innerHTML == "Enseigné") {
      let classTmp = array[i].classList[1];
      let tmpTab = document.getElementsByClassName(classTmp);
      setOrder(tmpTab, 101);
    }
    if (array[i].innerHTML == "CT/CS") {
      let classTmp = array[i].classList[1];
      let tmpTab = document.getElementsByClassName(classTmp);
      setOrder(tmpTab, 102);
    }
  }
}

function setOrder(eltliste, order) {
  for (let g = 0; g < eltliste.length; g++) {
    if (typeof eltliste[g] != "object") {
      continue
    }
    eltliste[g].style.order = order;
  }
}

var LoadDataPokemon = function (id) {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      dataPokemon = JSON.parse(this.responseText)[0];
      console.log(dataPokemon)
      // Info pokemon
      document.getElementById("id_Pokemon").innerHTML = "Id : " + dataPokemon["id"];
      document.getElementById("nom_Pokemon").innerHTML = " Nom : " + getText(dataPokemon["name"]);
      document.getElementById("img").style.backgroundImage = "url('" + dataPokemon["spriteM"] + "')";
      const category = JSON.parse(this.responseText)[0]["category"];
      if (category === 0) {
        document.getElementById("categorie_Pokemon").innerHTML = "Commun";
      }
      if (category === 1) {
        document.getElementById("categorie_Pokemon").innerHTML = "Légendaire";
      }
      if (category === 2) {
        document.getElementById("categorie_Pokemon").innerHTML = "Fabuleux";
      }
      if (category === 3) {
        document.getElementById("categorie_Pokemon").innerHTML = "Ultra-Chimère";
      }
      if (category === 4) {
        document.getElementById("categorie_Pokemon").innerHTML = "Paradox";
      }
      if (dataPokemon["type2"] === null) {
        document.getElementById("type_Pokemon").innerHTML = getText(dataPokemon["type1"])
        const colorType = getText(dataPokemon["type1"]);

        document.getElementById("type_Pokemon").style.background = 'linear-gradient( 90deg, #' + TableColor[colorType][0] + ', #' + TableColor[colorType][1] + ')';
      }
      else {
        document.getElementById("type_Pokemon").innerHTML = getText(dataPokemon["type1"]) + "/" + getText(dataPokemon["type2"]);
        const colorType1 = getText(dataPokemon["type1"]);
        const colorType2 = getText(dataPokemon["type2"]);
        document.getElementById("type_Pokemon").style.background = 'linear-gradient( 90deg, #' + TableColor[colorType1][0] + ', #' + TableColor[colorType2][0] + ')';
      }
      document.getElementById("gen_Pokemon").innerHTML = "Gen : " + dataPokemon["generation"];
      console.log("in pokemon : " + document.getElementById("gen_Pokemon").innerHTML)
      document.getElementById("taille_Pokemon").innerHTML = "Taille : " + dataPokemon["height"] / 10.0 + " m";
      document.getElementById("poids_Pokemon").innerHTML = "Poids : " + dataPokemon["weight"] / 10.0 + " Kg";
      document.getElementById("catch_rate_Pokemon").innerHTML = "Taux de capture : " + dataPokemon["catch_rate"];
      // Description
      document.getElementById("textDescription").innerHTML = getText(dataPokemon["description"]);
      // Stat pokemon
      for (let i = 1; i < 7; i++) {
        document.getElementById('val_Stat' + i).innerHTML = dataPokemon[8 + i];
      }
      // Graph pokemon
      let parentWidth = document.getElementsByClassName("Graph_stat_case")[0].clientWidth;
      for (let i = 1; i < 7; i++) {
        document.getElementById('graph_Stat' + i).style.width = parseInt(dataPokemon[8 + i] * parentWidth / 255) + "px";
        document.getElementById('graph_Stat' + i).style.backgroundColor = colorStat[i - 1];
      }
      // Faiblesse/Resistance
      let Resistance_Value = dataPokemon[15].split("/");
      for (let i = 0; i < 18; i++) {
        document.getElementById('Faibless_Resistance_Value' + i).innerText = "x" + Resistance_Value[i + 1];
        if (document.getElementById('Faibless_Resistance_Value' + i).innerText === "x0.25") {
          document.getElementById('Faibless_Resistance_Value' + i).style.background = 'radial-gradient(circle, rgba(34,255,0,1) 7%, rgba(50,200,41,1) 21%, rgba(53,201,24,1) 48%, rgba(67,240,23,1) 64%, rgba(13,200,3,1) 90%)';
        }
        if (document.getElementById('Faibless_Resistance_Value' + i).innerText === "x0.5") {
          document.getElementById('Faibless_Resistance_Value' + i).style.background = 'radial-gradient(circle, rgba(157,252,142,1) 7%, rgba(138,231,132,1) 21%, rgba(115,194,99,1) 48%, rgba(129,237,101,1) 64%, rgba(125,196,121,1) 90%)';
        }
        if (document.getElementById('Faibless_Resistance_Value' + i).innerText === "x0") {
          document.getElementById('Faibless_Resistance_Value' + i).style.background = 'radial-gradient(circle, rgba(142,142,142,1) 7%, rgba(184,184,184,1) 21%, rgba(133,128,128,1) 48%, rgba(181,178,178,1) 64%, rgba(94,94,94,1) 90%)';
        }
        if (document.getElementById('Faibless_Resistance_Value' + i).innerText === "x1") {
          document.getElementById('Faibless_Resistance_Value' + i).style.background = 'radial-gradient(circle, rgba(255,218,89,1) 7%, rgba(210,160,82,1) 21%, rgba(246,208,64,1) 48%, rgba(213,172,70,1) 64%, rgba(255,198,51,1) 90%)';
        }
        if (document.getElementById('Faibless_Resistance_Value' + i).innerText === "x2") {
          document.getElementById('Faibless_Resistance_Value' + i).style.background = 'radial-gradient(circle, rgba(255,119,119,1) 7%, rgba(193,88,88,1) 21%, rgba(232,106,106,1) 48%, rgba(207,69,69,1) 64%, rgba(255,93,93,1) 90%)';
        }
        if (document.getElementById('Faibless_Resistance_Value' + i).innerText === "x4") {
          document.getElementById('Faibless_Resistance_Value' + i).style.background = 'radial-gradient(circle, rgba(193,31,31,1) 7%, rgba(207,81,81,1) 21%, rgba(193,16,16,1) 48%, rgba(237,12,12,1) 64%, rgba(157,2,2,1) 90%)';
        }
      }
      document.getElementById("genAtk").innerText = document.getElementById("gen_Pokemon").innerText;
      LoadAtkPokemon(id);
    }
  }
  xmlhttp.open("GET", `./ajax/getDBData.php?request=
    SELECT pokemon.id,
    pokemon.name,
    pokemon.spriteM,
    pokemon.spriteF,
    pokemon.generation,
    pokemon.category,
    pokemon.height,
    pokemon.weight,
    pokemon.catch_rate,
    pokemon.hp,
    pokemon.attack,
    pokemon.defense,
    pokemon.atackspe,
    pokemon.defensespe,
    pokemon.speed,
    typeEfficiency, 
    pokemon.description, 
    t1.name AS type1, 
    t2.name AS type2 
    FROM pokemon 
    JOIN type AS t1 ON pokemon.type1 = t1.id 
    LEFT JOIN type AS t2 ON pokemon.type2 = t2.id 
    WHERE pokemon.id = ` + id, true);
  xmlhttp.send();
}


var LoadAbilityPokemon = function (id) {
  let xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      dataAbility = JSON.parse(this.responseText);
      document.getElementById("Talent").innerText = "";
      document.getElementById("Talent").classList.remove("NB_talent0", "NB_talent1", "NB_talent2", "NB_talent3")
      document.getElementById("Talent").classList.add("NB_talent" + dataAbility.length);
      for (let i = 0; i < dataAbility.length; i++) {
        let divElementName = document.createElement("div");
        divElementName.classList.add("nom_talent");
        divElementName.innerHTML = getText(dataAbility[i]["name"]);
        document.querySelector("body #content #Pokemon #Talent").appendChild(divElementName);
      }
      for (let i = 0; i < dataAbility.length; i++) {
        let divElementDesc = document.createElement("div");
        divElementDesc.classList.add("desc_talent");
        divElementDesc.innerHTML = getText(dataAbility[i]["smallDescription"]);
        document.querySelector("body #content #Pokemon #Talent").appendChild(divElementDesc);
      }
      console.log("ability Loaded !");
    }
  }
  xmlhttp.open("GET", `./ajax/getDBData.php?request=
      SELECT 
      ability.name,
      ability.smallDescription,
      ap.isHidden 
      FROM ability_pokemon AS ap 
      INNER JOIN ability ON ap.abilityId = ability.id 
      WHERE ap.pokemonId = ` + id, true);
  xmlhttp.send();
}


var LoadAtkPokemon = function (id, isGen = -1) {
  let xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      dataMove = JSON.parse(this.responseText);
      document.getElementById("Attaque").innerText = "";
      document.getElementById("Attaque").style.gridTemplateRows = "repeat(" + parseInt(dataMove.length + 1) + ",1fr)"
      let tab1 = ["Nom", "Type", "Catégorie", "Précision", "Puissance", "PP", "Apprentisage"]
      let tab2 = ["name", "type", "effectType", "accuracy", "pc", "pp", "learnMethod"]
      if (isGen != -1 && isGen < 1) {
        return
      }
      if (dataMove.length == 0) {
        LoadAtkPokemon(id, isGen = isGen == -1 ? document.getElementById("genAtk").innerHTML.match(/\d+/)[0] - 1 : isGen - 1)
        return
      }
      for (let i = -1; i < dataMove.length; i++) {
        for (let j = 0; j < 7; ++j) {
          let divElementName = document.createElement("div");
          divElementName.classList.add("Val_atk_case");
          if (i == -1) {
            divElementName.innerHTML = "<h3>" + tab1[j] + "</h3>"
            divElementName.style.order = 0;
          }
          else {
            divElementName.classList.add("Val_atk_case" + i);
            divElementName.style.order = 1;
            if (j == 6 && getText(dataMove[i]["learnMethod"]) == "Montée de niveau")
              divElementName.innerHTML = "niveau " + dataMove[i]["learnAtLevel"];
            else if (j == 6 && getText(dataMove[i]["learnMethod"]) == "Capsule")
              divElementName.innerHTML = "CT/CS";
            else if (j == 2)
              if (dataMove[i][tab2[j]] == 1)
                divElementName.innerHTML = "Physique"
              else if (dataMove[i][tab2[j]] == 2)
                divElementName.innerHTML = "Spéciale"
              else
                divElementName.innerHTML = "Statut"
            else if (j == 3 || j == 4 || j == 5)
              if (dataMove[i][tab2[j]] == undefined)
                divElementName.innerHTML = "--"
              else
                divElementName.innerHTML = dataMove[i][tab2[j]];
            else if (j == 1) {
              let divElementTypeAtk = document.createElement("div");
              divElementTypeAtk.classList.add("divElementTypeAtk");
              divElementTypeAtk.innerHTML = getText(dataMove[i][tab2[j]]);
              divElementName.appendChild(divElementTypeAtk);
              divElementTypeAtk.classList.add(getText(dataMove[i][tab2[j]], "en"))
            }
            else
              divElementName.innerHTML = getText(dataMove[i][tab2[j]]);
          }
          document.getElementById("Attaque").appendChild(divElementName);
        }
      }
      orderGrid();
    }
  }
  let genValue = isGen == -1 ? document.getElementById("genAtk").innerHTML.match(/\d+/)[0] : isGen
  xmlhttp.open("GET", `./ajax/getDBData.php?request=
      SELECT 
      move.name,
      type.name AS type,
      move.effectType,
      move.pc,
      move.accuracy,
      mp.learnMethod,
      mp.learnAtLevel,
      move.pp 
      FROM move_pokemon AS mp 
      INNER JOIN move ON mp.moveId = move.id 
      JOIN type ON move.type = type.id 
      WHERE mp.pokemonId = ` + id + ' AND mp.generation = ' + genValue, true);
  xmlhttp.send();
};

function divEvoCase(data){
  let divElementEvoCase = document.createElement("div");
  divElementEvoCase.classList = "Evo_case";
  document.getElementById("Evo").appendChild(divElementEvoCase);
}

var LoadEvoPokemon = function (id) {
  let xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      dataEvol = JSON.parse(this.responseText);
      document.getElementById("Evo").innerHTML = "";
      console.log(dataEvol)
      let tabEvo = [];
      let tabEvoCheck = [];
      let tabStageEvo = [];
      for (let i = 0; i < dataEvol.length; i++) {
        console.log(dataEvol[i].evolutionStade)
        console.log(tabStageEvo)
        // pokemon base div
        if (tabStageEvo.includes(dataEvol[i].evolutionStade) == false) {
          let divElementPokemon = document.createElement("div");
          divElementPokemon.classList.add("EvoStage_Pokemon_case");
          divElementPokemon.id = "stage1";
          document.getElementById("Evo").appendChild(divElementPokemon);
          tabStageEvo.push(dataEvol[i].evolutionStade);
        }
        // pokemon base
        if (tabEvo.includes(dataEvol[i].n1) == false) {
          let divElementPokemon = document.createElement("div");
          divElementPokemon.classList.add("Evo_Pokemon_case");
          document.getElementById("stage1").appendChild(divElementPokemon);
          divEvoCase(dataEvol[i]);
          tabEvo.push(dataEvol[i].n1)
          let img = document.createElement("img")
          img.src = dataEvol[i].s1
          divElementPokemon.appendChild(img)
        }
        // forme pokemon base
        if (dataEvol[i].n5 != null && tabEvo.includes(dataEvol[i].n5) == false) {
          let divElementPokemon = document.createElement("div");
          divElementPokemon.classList.add("Evo_Pokemon_case");
          document.getElementById("stage1").appendChild(divElementPokemon);
          divEvoCase(dataEvol[i]);
          tabEvo.push(dataEvol[i].n5)
          let img = document.createElement("img")
          img.src = dataEvol[i].s5
          divElementPokemon.appendChild(img)
        }
        // pokemon evol div
        if (tabStageEvo.includes(dataEvol[i].evolutionStade + 1) == false) {
          let divElementPokemon = document.createElement("div");
          divElementPokemon.classList.add("EvoStage_Pokemon_case");
          if (dataEvol[i].evolutionStade == 0) {
            divElementPokemon.id = "stage2";
            tabStageEvo.push(dataEvol[i].evolutionStade + 1);
          }
          else {
            divElementPokemon.id = "stage3";
            tabStageEvo.push(dataEvol[i].evolutionStade + 1);
          }
          // tabEvo.push(dataEvol[i].n2)
          document.getElementById("Evo").appendChild(divElementPokemon);
          if (dataEvol[i].n6 != null && (dataEvol[i].n6.toLowerCase().match("mega") || dataEvol[i].n6.toLowerCase().match("giga"))) {
            console.log("ooo", tabStageEvo)
            if (tabStageEvo.includes(-1) == true) {
              return
            }
            else {
              let divElementPokemon = document.createElement("div");
              divElementPokemon.classList.add("EvoStage_Pokemon_case");
              divElementPokemon.id = "stage4";
              tabStageEvo.push(-1);
              document.getElementById("Evo").appendChild(divElementPokemon);
            }
          }
        }
        
        // pokemon evol niveau1 niveau2 
        if (tabEvo.includes(dataEvol[i].n2) == false) {
          let divElementPokemon = document.createElement("div");
          divElementPokemon.classList.add("Evo_Pokemon_case");
          if (dataEvol[i].evolutionStade == 0) {
            document.getElementById("stage2").appendChild(divElementPokemon);
            divEvoCase(dataEvol[i]);
          }
          else {
            document.getElementById("stage3").appendChild(divElementPokemon);
          }
          tabEvo.push(dataEvol[i].n2)
          let img = document.createElement("img")
          img.src = dataEvol[i].s2
          divElementPokemon.appendChild(img)
        }
        // pokemon evol niveau1 niveau2 form
        if (dataEvol[i].n6 != null && tabEvo.includes(dataEvol[i].n6) == false) {
          let divElementPokemon = document.createElement("div");
          divElementPokemon.classList.add("Evo_Pokemon_case");
          if (dataEvol[i].n6.toLowerCase().match("mega") || dataEvol[i].n6.toLowerCase().match("giga")) {
            document.getElementById("stage4").appendChild(divElementPokemon);
          }
          else if (dataEvol[i].evolutionStade == 0) {
            document.getElementById("stage2").appendChild(divElementPokemon);
          }
          else {
            document.getElementById("stage3").appendChild(divElementPokemon);
          }
          tabEvo.push(dataEvol[i].n6)
          let img = document.createElement("img")
          img.src = dataEvol[i].s6
          divElementPokemon.appendChild(img)
        }
      }
    }
  }
  xmlhttp.open("GET", `./ajax/getDBData.php?request=
      SELECT 
      ev.id,
      ev.basePokemonId,
      ev.evoluedPokemonId,
      ev.evolutionStade,
      ev.gender,
      ev.heldItemId,
      ev.itemId,
      ev.knownMoveId,
      ev.knownMoveTypeId,
      ev.locationId,
      ev.minAffection,
      ev.minBeauty,
      ev.minHappiness,
      ev.minLevel,
      ev.needsOverworldRain,
      ev.partySpeciesId,
      ev.partyTypeId,
      ev.relativePhysicalStats,
      ev.timeOfDay,
      ev.tradeSpeciesId,
      ev.evolutionTrigger,
      ev.turnUpSideDown,

      po1.spriteM AS s1,
      po1.name AS n1,
      po1.type1 AS type11,
      po1.type2 AS type12, 

      po2.spriteM AS s2,
      po2.name AS n2,
      po2.type1 AS type21,
      po2.type2 AS type22, 

      po3.spriteM AS s3,
      po3.name AS n3,
      po3.type1 AS type31,
      po3.type2 AS type32,

      po4.spriteM AS s4,
      po4.name AS n4,
      po4.type1 AS type41,
      po4.type2 AS type42,

      po5.spriteM AS s5,
      po5.name AS n5,
      po5.type1 AS type51,
      po5.type2 AS type52,

      po6.spriteM AS s6,
      po6.name AS n6,
      po6.type1 AS type61,
      po6.type2 AS type62 

      FROM evolution_pokemon AS ev 
      LEFT JOIN pokemon AS po1 ON basePokemonId = po1.id 
      LEFT JOIN pokemon AS po2 ON evoluedPokemonId = po2.id 
      LEFT JOIN item AS it1 ON heldItemId = it1.id 
      LEFT JOIN item AS it2 ON itemId = it2.id 
      LEFT JOIN move ON knownMoveId = move.id 
      LEFT JOIN type AS ty1 ON knownMoveTypeId = ty1.id 
      LEFT JOIN location ON locationId = location.id 
      LEFT JOIN pokemon AS po3 ON partySpeciesId = po3.id 
      LEFT JOIN type AS ty2 ON partyTypeId = ty2.id 
      LEFT JOIN pokemon AS po4 ON tradeSpeciesId = po4.id 

      LEFT JOIN form_pokemon AS fp1 ON fp1.pokemonId = po1.id 
      LEFT JOIN pokemon AS po5 ON po5.id = fp1.formId 
      LEFT JOIN form_pokemon AS fp2 ON fp2.pokemonId = po2.id 
      LEFT JOIN pokemon AS po6 ON po6.id = fp2.formId 

      LEFT JOIN type AS t11 ON po1.type1 = t11.id 
      LEFT JOIN type AS t12 ON po1.type2 = t12.id 
      LEFT JOIN type AS t21 ON po2.type1 = t21.id  
      LEFT JOIN type AS t22 ON po2.type2 = t22.id 
      LEFT JOIN type AS t31 ON po3.type1 = t31.id  
      LEFT JOIN type AS t32 ON po3.type2 = t32.id 
      LEFT JOIN type AS t41 ON po4.type1 = t41.id  
      LEFT JOIN type AS t42 ON po4.type2 = t42.id 
      LEFT JOIN type AS t51 ON po5.type1 = t51.id  
      LEFT JOIN type AS t52 ON po5.type2 = t52.id 
      LEFT JOIN type AS t61 ON po6.type1 = t61.id  
      LEFT JOIN type AS t62 ON po6.type2 = t62.id 

      WHERE ev.id = ` + id, true);
  xmlhttp.send();
};

for (let i = 0; i < pokemons.length; i++) {

  pokemons[i].addEventListener('click', () => {
    if (last_id === pokemons[i].id) {
      console.log("a");
      last_id = "x";
      core.style.margin = "";
      core.style.maxWidth = "";
      dataPokemon = undefined;
    }
    else {
      LoadDataPokemon(pokemons[i].id)
      LoadAbilityPokemon(pokemons[i].id)
      LoadEvoPokemon(pokemons[i].id)
      last_id = pokemons[i].id;
      core.style.margin = "0px";
      // core.style.marginLeft = "275px";
      core.style.maxWidth = "450px";
    }
  }, false);
}

