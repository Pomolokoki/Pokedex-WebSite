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

function mobileVersion() {
  return window.innerWidth < 500;
}

document.getElementById('check_fav').addEventListener('click', function () {
  let id_pokemon = document.getElementById('id_Pokemon').textContent.match(/\d+/)[0];
  let id_player = document.getElementById('Data_User').textContent.match(/\d+/)[0];
  if (document.getElementsByClassName("star-dotted")[0].style.display == "block") {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", `./ajax/getDBData.php?request=
      INSERT INTO player_favorites VALUES (`+ id_player + `,` + id_pokemon + `);`)
    xmlhttp.send();
    console.log('azerty')
  }
  else {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", `./ajax/getDBData.php?request= 
      DELETE FROM player_favorites WHERE playerId =`+ id_player + ` AND pokemonId =` + id_pokemon + `;`)
    xmlhttp.send();
  }
  check_pokemonUser(id_pokemon);
});

document.getElementById('check_capture').addEventListener('click', function () {
  let id_pokemon = document.getElementById('id_Pokemon').textContent.match(/\d+/)[0];
  let id_player = document.getElementById('Data_User').textContent.match(/\d+/)[0];
  if (document.getElementsByClassName("pokeball-empty")[0].style.display == "block") {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", `./ajax/getDBData.php?request=
      INSERT INTO player_pokemon VALUES (`+ id_player + `,` + id_pokemon + `);`)
    xmlhttp.send();
    console.log('qwerty')
    console.log(`INSERT INTO player_pokemon VALUES (` + id_player + `,` + id_pokemon + `);`)
    console.log(dataCheck)
  }
  else {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", `./ajax/getDBData.php?request= 
      DELETE FROM player_pokemon WHERE playerId =`+ id_player + ` AND pokemonId =` + id_pokemon + `;`)
    xmlhttp.send();
  }
  check_pokemonUser(id_pokemon);
});

var check_pokemonUser = function (id) {
  let xmlhttp = new XMLHttpRequest();
  let id_player = document.getElementById('Data_User').textContent.match(/\d+/)[0];
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      dataCheck = JSON.parse(this.responseText);
      console.log(dataCheck)
      if (dataCheck == "No results found.") {
        document.getElementsByClassName("star-dotted")[0].style.display = "block";
        document.getElementsByClassName("pokeball-empty")[0].style.display = "block";
        document.getElementsByClassName("star-fill")[0].style.display = "none";
        document.getElementsByClassName("pokeball-fill")[0].style.display = "none";
        return
      }
      else {
        for (let i = 0; i < dataCheck.length; i++) {
          if (dataCheck[i]["pokemonFav"] == null) {
            document.getElementsByClassName("star-dotted")[0].style.display = "block";
            document.getElementsByClassName("star-fill")[0].style.display = "none";
            console.log("aled")
          }
          else {
            document.getElementsByClassName("star-dotted")[0].style.display = "none";
            document.getElementsByClassName("star-fill")[0].style.display = "block";
          }
          if (dataCheck[i]["pokemonPlayer"] == null) {
            document.getElementsByClassName("pokeball-empty")[0].style.display = "block";
            document.getElementsByClassName("pokeball-fill")[0].style.display = "none";
          }
          else {
            document.getElementsByClassName("pokeball-empty")[0].style.display = "none";
            document.getElementsByClassName("pokeball-fill")[0].style.display = "block";
          }

        }
      }
    }
    console.log("pokemonCheck Loaded !");
  }
  xmlhttp.open("GET", `./ajax/getDBData.php?request=
      SELECT 
      pf.pokemonId AS pokemonFav,
      pp.pokemonId AS pokemonPlayer 
      FROM player_favorites AS pf 
      RIGHT JOIN player_pokemon AS pp ON pp.playerId = pf.playerId
      UNION
      SELECT 
      pf.pokemonId AS pokemonFav,
      pp.pokemonId AS pokemonPlayer 
      FROM player_favorites AS pf 
      LEFT JOIN player_pokemon AS pp ON pp.playerId = pf.playerId  
      WHERE pf.playerId = ` + (document.getElementById('Data_User').textContent) + ` AND pf.pokemonId= ` + id, true);

  xmlhttp.send();
}

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

document.getElementById('TitleAtk').addEventListener('click', function () {
  let atk = document.getElementById('Attaque');
  let atkTitle = document.getElementById('TitleAtk');
  let atkButton = document.getElementById('atkButtons')
  if (atk.classList.contains('open')) {
    atk.classList.remove('open');
    atkTitle.innerHTML = "Attaque : ▲";
    atkButton.style.display = 'none';
  } else {
    atk.classList.add('open');
    atkTitle.innerHTML = "Attaque : ▼";
    atkButton.style.display = '';
  }
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
      if (getText(dataPokemon["name"]) == "M. Mime" || getText(dataPokemon["name"]) == "Mime Jr." || getText(dataPokemon["name"]) == "M. Glaquette") {
        document.getElementById("nom_Pokemon").innerHTML = " Nom : " + getText(dataPokemon["name"]);
      }
      else {
        document.getElementById("nom_Pokemon").innerHTML = " Nom : " + getText(dataPokemon["name"]).split(" ")[0];
      }
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
      if (dataPokemon[15] != null) {
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
      if (dataMove == "No results found.") {
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
            else if (j == 2) {
              if (dataMove[i][tab2[j]] == 1)
                divElementName.innerHTML = "Physique"
              else if (dataMove[i][tab2[j]] == 2)
                divElementName.innerHTML = "Spéciale"
              else
                divElementName.innerHTML = "Statut"
            }
            else if (j == 3 || j == 4 || j == 5) {
              if (dataMove[i][tab2[j]] == undefined)
                divElementName.innerHTML = "--"
              else
                divElementName.innerHTML = dataMove[i][tab2[j]];
            }
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

function divEvoCaseGroup(stage) {
  let divElementEvoCase = document.createElement("div");
  divElementEvoCase.classList = "Evo_case_group";
  divElementEvoCase.id = "Evo_case_group" + stage;
  document.getElementById("Evo").appendChild(divElementEvoCase);
}
function divEvoCase(stage, data) {
  let divElementEvoCase = document.createElement("div");
  divElementEvoCase.classList = "Evo_case";
  if (data.evolutionTrigger != null) {
    if (getText(data.evolutionTrigger) == "Other") {
      divElementEvoCase.innerHTML += "remplir une condition précise"
    }
    else {
      divElementEvoCase.innerHTML += getText(data.evolutionTrigger) + "<br>";
    }
  }
  if (data.gender != null) {
    if (data.gender == 1) {
      divElementEvoCase.innerHTML = "Si femelle(♀) <br> ";
    }
    else {
      divElementEvoCase.innerHTML = "Si male(♂) <br> ";
    }
  }
  if (data.it1name != null) {
    divElementEvoCase.innerHTML += "<img src='" + data.it1sprite + "'> <br>";
  }
  if (data.it2name != null) {
    divElementEvoCase.innerHTML += "<img src='" + data.it2sprite + "'> <br>";
  }
  if (data.moveName != null) {
    divElementEvoCase.innerHTML += "doit maitriser " + getText(data.moveName) + "<br>";
  }
  if (data.tyName != null) {
    divElementEvoCase.innerHTML += "doit maitriser " + getText(data.tyName) + "<br>";
  }
  if (data.locationName != null) {
    divElementEvoCase.innerHTML += getText(data.locationName) + "<br>";
  }
  if (data.minAffection != null) {
    divElementEvoCase.innerHTML += "niveau d'affection " + data.minAffection + "<br>";
  }
  if (data.minBeauty != null) {
    divElementEvoCase.innerHTML += "niveau de beauté " + data.minBeauty + "<br>";
  }
  if (data.minHappiness != null) {
    divElementEvoCase.innerHTML += "niveau de bonheur " + data.minHappiness + "<br>";
  }
  if (data.minLevel != null) {
    divElementEvoCase.innerHTML += "niveau " + data.minLevel + "<br>";
  }
  if (data.needsOverworldRain == 1) {
    divElementEvoCase.innerHTML += "Pling Pling Plong"
  }
  if (data.n3 != null) {
    divElementEvoCase.innerHTML += "avec " + getText(data.n3) + " dans l'équipe";
  }
  if (data.ty2Name != null) {
    divElementEvoCase.innerHTML += "avec pokemon " + getText(data.ty2Name) + " dans l'équipe <br>";
  }
  if (data.relativePhysicalStats != null) {
    if (data.relativePhysicalStats == 1) {
      divElementEvoCase.innerHTML += "atk > def";
    }
    else {
      divElementEvoCase.innerHTML += "def > atk";
    }
  }
  if (data.timeOfDay != null) {
    if (data.timeOfDay == "day") {
      divElementEvoCase.innerHTML += " de jour";
    }
    if (data.timeOfDay == "night") {
      divElementEvoCase.innerHTML += " de nuit";
    }
    else {
      divElementEvoCase.innerHTML += " nuit de pleine lune";
    }
  }
  if (data.n4 != null) {
    divElementEvoCase.innerHTML += "avec " + getText(data.n4) + "<br>";
  }
  if (data.turnUpSideDown != 0 && data.turnUpSideDown != null) {
    divElementEvoCase.innerHTML += "en retournant la console"
  }

  document.getElementById("Evo_case_group" + stage).appendChild(divElementEvoCase);
  if (data.id == 67) {
    let eevee = document.getElementsByClassName("Evo_case");
    for (let eevee_count = 0; eevee_count < eevee.length; eevee_count++) {
      eevee[eevee_count].style.height = '96px';
      eevee[eevee_count].style.marginBottom = '0px';
    }
  }
  else {
    return;
  }
  return divElementEvoCase;
}

function divStagePokemon(name) {
  let divElementPokemon = document.createElement("div");
  divElementPokemon.classList.add("EvoStage_Pokemon_case");
  divElementPokemon.id = name;
  document.getElementById("Evo").appendChild(divElementPokemon);
  return divElementPokemon;
}

// document.getElementsByClassName('EvoStage_Pokemon_case').addEventListener('click', function () {
//   let evoId = document.getElementById(divElementPokemon.id);
//   console.log(evoId);
// });


var LoadEvoPokemon = function (id) {
  let xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      dataEvol = JSON.parse(this.responseText);
      if (dataEvol == "No results found.") {
        document.getElementById("evoSection").style.display = "none";
        document.getElementById("Evo").style.display = "none";
        return;
      }
      else {
        document.getElementById("evoSection").style.display = "unset";
        document.getElementById("Evo").style.display = "flex";
      }
      document.getElementById("Evo").innerHTML = "";
      dataEvol.sort((a, b) => { return a.evolutionStade - b.evolutionStade; })
      let tabEvo = [];
      let tabEvoCaseGroup = [];
      let tabStageEvo = [];


      for (let i = 0; i < dataEvol.length; i++) {

        // insert a div to put base pokemon in
        if (tabStageEvo.includes(dataEvol[i].evolutionStade) == false) {
          divStagePokemon("stage1");
          tabStageEvo.push(dataEvol[i].evolutionStade);
        }

        // insert the pokemon in the previous div
        if (tabEvo.includes(dataEvol[i].n1) == false) {

          //if new pokemon is a previous evolution then move everyone
          if (tabEvo.includes(dataEvol[i].n2)) {
            let s2 = document.getElementById("stage2")
            let s1 = document.getElementById("stage1")
            console.log("passe ici", s2)
            if (s2 != null) {
              let s3 = divStagePokemon("stage3");
              tabStageEvo.push(2);
              s3.innerHTML = s2.innerHTML;
              s2.innerHTML = s1.innerHTML;
            }
          }


          let divElementPokemon = document.createElement("div");
          divElementPokemon.classList.add("Evo_Pokemon_case");
          divElementPokemon.id = dataEvol[i].n1;
          document.getElementById("stage1").appendChild(divElementPokemon);
          tabEvo.push(dataEvol[i].n1)
          let img = document.createElement("img")
          img.src = dataEvol[i].s1
          divElementPokemon.appendChild(img)
          divElementPokemon.addEventListener('click', function () {
            LoadPokemon(dataEvol[i].id1);
            if (dataEvol[i].id1 > 10000) {
              return;
            }
            document.getElementById(dataEvol[i].id1).scrollIntoView({ behavior: "smooth" });
            document.getElementById('Pokemon').scroll({ top: 0, behavior: 'smooth' });
          });
        }

        if (tabEvoCaseGroup.includes(dataEvol[i].evolutionStade) == false) {
          divEvoCaseGroup(dataEvol[i].evolutionStade);
          tabEvoCaseGroup.push(dataEvol[i].evolutionStade);
        }
        divEvoCase(dataEvol[i].evolutionStade, dataEvol[i]);

        // insert a new div to contains pokemon (one for each evolution)
        if (tabStageEvo.includes(dataEvol[i].evolutionStade + 1) == false) {
          let divElementPokemon = document.createElement("div");
          divElementPokemon.classList.add("EvoStage_Pokemon_case");
          if (dataEvol[i].evolutionStade == 0) {
            divElementPokemon.id = "stage2";
            tabStageEvo.push(dataEvol[i].evolutionStade + 1);
          }
          else {
            divElementPokemon.id = "stage3";
            if (dataEvol[i].id == 442) {
              tabStageEvo.push(dataEvol[i].evolutionStade + 1);
              divElementPokemon.style.alignSelf = 'end'
              document.getElementById("Evo_case_group" + dataEvol[i].evolutionStade).style.alignSelf = 'end'

            }
            else {
              divElementPokemon.style.alignSelf = 'center'
              document.getElementById("Evo_case_group" + dataEvol[i].evolutionStade).style.alignSelf = 'center'
              tabStageEvo.push(dataEvol[i].evolutionStade + 1);
            }
          }
          document.getElementById("Evo").appendChild(divElementPokemon);


          //   // tabEvo.push(dataEvol[i].n2)
          //   if (dataEvol[i].n6 != null && (dataEvol[i].n6.toLowerCase().match("mega") || dataEvol[i].n6.toLowerCase().match("giga"))) {
          //     console.log("ooo", tabStageEvo)
          //     if (tabStageEvo.includes(-1) == true) {
          //       return
          //     }
          //     else {
          //       let divElementPokemon = document.createElement("div");
          //       divElementPokemon.classList.add("EvoStage_Pokemon_case");
          //       divElementPokemon.id = "stage4";
          //       tabStageEvo.push(-1);
          //       document.getElementById("Evo").appendChild(divElementPokemon);
          //     }
          //   }
        }

        // insert pokemon on their divssss
        if (tabEvo.includes(dataEvol[i].n2) == false) {
          let divElementPokemon = document.createElement("div");
          divElementPokemon.classList.add("Evo_Pokemon_case");
          if (dataEvol[i].evolutionStade == 0) {
            document.getElementById("stage2").appendChild(divElementPokemon);
          }
          else {
            document.getElementById("stage3").appendChild(divElementPokemon);
          }
          tabEvo.push(dataEvol[i].n2);
          let img = document.createElement("img");
          img.src = dataEvol[i].s2;
          divElementPokemon.appendChild(img);
          divElementPokemon.addEventListener('click', function () {
            LoadPokemon(dataEvol[i].id2);
            document.getElementById(dataEvol[i].id2).scrollIntoView({ behavior: "smooth" });
            document.getElementById('Pokemon').scroll({ top: 0, behavior: 'smooth' });
          });
        }
      }
    }
  }
  xmlhttp.open("GET", `./ajax/getDBData.php?request=
      SELECT DISTINCT
      ev.id,
      ev.basePokemonId,
      ev.evoluedPokemonId,
      ev.evolutionStade,
      ev.gender,
      it1.name AS it1name,
      it1.sprite AS it1sprite,
      it2.name AS it2name,
      it2.sprite AS it2sprite,
      move.name AS moveName,
      ty1.name AS tyName,
      location.name AS locationName,
      ev.minAffection,
      ev.minBeauty,
      ev.minHappiness,
      ev.minLevel,
      ev.needsOverworldRain,
      po3.name AS n3,
      ty2.name AS ty2Name,
      ev.relativePhysicalStats,
      ev.timeOfDay,
      ev.tradeSpeciesId,
      ev.evolutionTrigger,
      po4.name AS n4,
      ev.turnUpSideDown,

      po1.spriteM AS s1,
      po1.name AS n1,
      po1.type1 AS type11,
      po1.type2 AS type12,
      po1.id AS id1, 

      po2.spriteM AS s2,
      po2.name AS n2,
      po2.type1 AS type21,
      po2.type2 AS type22,
      po2.id AS id2   

      FROM evolution AS ev 
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

      LEFT JOIN type AS t11 ON po1.type1 = t11.id 
      LEFT JOIN type AS t12 ON po1.type2 = t12.id 
      LEFT JOIN type AS t21 ON po2.type1 = t21.id  
      LEFT JOIN type AS t22 ON po2.type2 = t22.id 

      LEFT JOIN evolution_pokemon ON ev.id = evolutionFamilyId 

      WHERE evolutionFamilyId = (SELECT evolutionFamilyId FROM evolution_pokemon WHERE pokemonId =` + id + ")", true);
  xmlhttp.send();
};

function LoadPokemon(id) {
  LoadDataPokemon(id)
  LoadAbilityPokemon(id)
  LoadEvoPokemon(id)
  check_pokemonUser(id)
  last_id = id;
  if (id > 10000) {
    return;
  }
  let pok = document.getElementById(id);
  pok.children[0].classList.remove("selectAnimation")
  void pok.offsetWidth
  pok.children[0].classList.add("selectAnimation")
}

for (let i = 0; i < pokemons.length; i++) {

  pokemons[i].addEventListener('click', () => {
    if (last_id === pokemons[i].id) {
      last_id = "x";
      core.style.maxWidth = "900px";
      core.style.margin = "auto";
      document.getElementById('Pokemon').style.display = 'none';
      dataPokemon = undefined;
      console.log("pokemon unload")
    }
    else {
      if (mobileVersion() == true) {
        document.getElementById('core').style.display = 'none';
        LoadPokemon(pokemons[i].id)
        core.style.margin = "0px";
        document.getElementById('Pokemon').style.display = 'block';
        core.style.maxWidth = "450px";
      }
      else {
        LoadPokemon(pokemons[i].id)
        core.style.margin = "0px";
        document.getElementById('Pokemon').style.display = 'block';
        core.style.maxWidth = "450px";
      }
    }
  }, false);
}

