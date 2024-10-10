var last_id = "x";
var pokemons = document.getElementsByClassName("pokemon");
var core = document.getElementById("core");
var Pokemon = document.createElement("div");
var content = document.getElementById("conteneur")
var dataPokemon = undefined;

var TableColor = {
  Acier: ["605e5e","969494"],
  Combat: ["ffb400","7d5f05"],
  Dragon: ["154ee4","5606b1"],
  Eau: ["2167ff","171ad2"],
  Électrik: ["ffdc00","9f9800"],
  Fée: ["fa62d3","da0b87"],
  Feu: ["f40e0e","860000"],
  Glace: ["0effff","078990"],
  Insecte: ["bbff02","57be0f"],
  Normal: ["d0d0cf","918f8f"],
  Plante: ["00ff15","0a7000"],
  Poison: ["be33ed","6c0279"],
  Psy: ["e76dee","c113aa",],
  Roche: ["bda777","6c551e"],
  Sol: ["be8f2a","573d02"],
  Spectre: ["a05da2","4f1154"],
  Ténèbres: ["776e77","1a161b"],
  Vol: ["71d2ff","006f9e"]
};

var colorStat = ["#9afd7c","#fff26b","#ffb15c","#7cfeff","#6da2ff","#c67bff"]

var language = "Fr";


document.getElementById('gender_button').addEventListener('click', function () {
  if (dataPokemon != undefined && dataPokemon["spriteF"] != "") {
    document.getElementById("img").style.backgroundImage = "url('" + dataPokemon["spriteF"] + "')";
    document.getElementById('gender_button').style.color = "#ee82ee";
  }
  if (document.getElementById("gender_button").innerHTML === "♂") {
    document.getElementById("gender_button").innerHTML = "♀";
    document.getElementById('gender_button').style.color = "#ee82ee";
  }
  else {
    document.getElementById("img").style.backgroundImage = "url('" + dataPokemon["spriteM"] + "')";
    document.getElementById("gender_button").innerHTML = "♂";
    document.getElementById('gender_button').style.color = "#0000ff";
  }
});

function getText(str) {
  if (language === "Fr") {
    return str.split('/')[1];
  }
}


var myFunction = function () {
  if (last_id === this.id) {
    console.log("a");
    last_id = "x";
    core.style.margin = "";
    core.style.maxWidth = "";
    dataPokemon = undefined
  }
  else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        dataPokemon = JSON.parse(this.responseText)[0];
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
          document.getElementById("type_Pokemon").innerHTML = getText(JSON.parse(this.responseText)[0]["type1"]) + " / " + getText(JSON.parse(this.responseText)[0]["type2"]);
          const colorType1 = getText(dataPokemon["type1"]);
          const colorType2 = getText(dataPokemon["type2"]);
          document.getElementById("type_Pokemon").style.background = 'linear-gradient( 90deg, #' + TableColor[colorType1][0] + ', #' + TableColor[colorType2][1] + ')';
        }
        document.getElementById("gen_Pokemon").innerHTML = "Gen : " + dataPokemon["generation"];
        document.getElementById("taille_Pokemon").innerHTML = "Taille : " + dataPokemon["height"] / 10.0 + " m";
        document.getElementById("poids_Pokemon").innerHTML = "Poids : " + dataPokemon["weight"] / 10.0 + " Kg";
        document.getElementById("catch_rate_Pokemon").innerHTML = "Taux de capture : " + dataPokemon["catch_rate"];

        // Stat pokemon
        for (let i = 1; i < 7; i++) {
          document.getElementById('val_Stat' + i).innerHTML = dataPokemon[8+i];
        }
        // Graph pokemon
        let parentWidth = document.getElementsByClassName("Graph_stat_case")[0].clientWidth;
        for (let i = 1; i < 7; i++) {
          document.getElementById('graph_Stat' + i).style.width =  parseInt(dataPokemon[8+i]*parentWidth/255) + "px";
          console.log(parentWidth);
          document.getElementById('graph_Stat' + i).style.backgroundColor = colorStat[i-1];
        }

      }
    }
    xmlhttp.open("GET", "./ajax/getDBData.php?request=SELECT pokemon.id,pokemon.name,pokemon.spriteM,pokemon.spriteF,pokemon.generation,pokemon.category,pokemon.height,pokemon.weight,pokemon.catch_rate, pokemon.hp, pokemon.attack, pokemon.defense, pokemon.atackspe, pokemon.defensespe, pokemon.speed, t1.name AS type1, t2.name AS type2 FROM pokemon JOIN type AS t1 ON pokemon.type1 = t1.id LEFT JOIN type AS t2 ON pokemon.type2 = t2.id WHERE pokemon.id = " + this.id, true);
    xmlhttp.send();
    console.log(this.id)
    last_id = this.id;
    core.style.margin = "0px";
    // core.style.marginLeft = "275px";
    core.style.maxWidth = "400px";
  }
};
for (var i = 0; i < pokemons.length; i++) {
  pokemons[i].addEventListener('click', myFunction, false);
}


