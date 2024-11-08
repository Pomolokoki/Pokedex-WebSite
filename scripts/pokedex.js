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
  if (menos.innerHTML.match(/\d+/)[0] == 1)
    return
  menos.innerHTML = "gen " + parseInt(menos.innerHTML.match(/\d+/)[0] - 1);
  LoadAtkPokemon(last_id);
});

document.getElementById('gen+').addEventListener('click', function () {
  let mas = document.getElementById('genAtk');
  if (mas.innerHTML.match(/\d+/)[0] == 9)
    return
  mas.innerHTML = "gen " + parseInt(parseInt(mas.innerHTML.match(/\d+/)[0]) + 1);
  LoadAtkPokemon(last_id);
});

function getText(str) {
  if (language === "Fr") {
    if (str.split('/')[1] == "NULL")
      return str.split('/')[0];
    return str.split('/')[1];
  }
}

function filtre() {
  let gen, type, rarete, searchBar;
  gen = document.getElementById('gen').value;
  type = document.getElementById('type').value;
  rarete = document.getElementById('rarete').value;
  searchBar = document.querySelector('#searchBar input').value.toLowerCase();
  console.log(gen, type, rarete, searchBar);
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
    console.log(i, array.length)
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


var LoadAtkPokemon = function (id) {
  let xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      dataMove = JSON.parse(this.responseText);
      document.getElementById("Attaque").innerText = "";
      document.getElementById("Attaque").style.gridTemplateRows = "repeat(" + parseInt(dataMove.length + 1) + ",1fr)"
      let tab1 = ["Nom", "Type", "Catégorie", "Précision", "Puissance", "PP", "Apprentisage"]
      let tab2 = ["name", "type", "effectType", "accuracy", "pc", "pp", "learnMethod"]
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
            else
              divElementName.innerHTML = getText(dataMove[i][tab2[j]]);
          }
          document.getElementById("Attaque").appendChild(divElementName);
        }
      }
      orderGrid();
    }
  }
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
      WHERE mp.pokemonId = ` + id + ' AND mp.generation = ' + document.getElementById("genAtk").innerHTML.match(/\d+/)[0], true);
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
      LoadAtkPokemon(pokemons[i].id)
      last_id = pokemons[i].id;
      core.style.margin = "0px";
      // core.style.marginLeft = "275px";
      core.style.maxWidth = "450px";
    }
  }, false);

}

