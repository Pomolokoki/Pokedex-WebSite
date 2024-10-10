var last_id = "x";
var pokemons = document.getElementsByClassName("pokemon");
var core = document.getElementById("core");
var Pokemon = document.createElement("div");
var content = document.getElementById("conteneur")
var TableColor = {
  Acier: ["605e5e", 27, "969494", 86],
  Combat: ["ffb400", 13, "7d5f05", 100],
  Dragon: ["154ee4", 13, "5606b1", 87],
  Eau: ["64aaff", 21, "171ad2", 86],
  Électrik: ["ffdc00", 27, "9f9800", 87],
  Fée: ["fa62d3", 19, "da0b87", 76],
  Feu: ["f40e0e", 12, "860000", 77],
  Glace: ["02edff", 18, "078990", 89],
  Insecte: ["bbff02", 13, "57be0f", 93],
  Normal: ["d0d0cf", 12, "918f8f", 91],
  Plante: ["00ff15", 14, "0a7000", 94],
  Poison: ["be33ed", 24, "6c0279", 99],
  Psy: ["e76dee", 18, "c113aa", 86],
  Roche: ["bda777", 18, "6c551e", 90],
  Sol: ["be8f2a", 27, "573d02", 92],
  Spectre: ["a05da2", 23, "4f1154", 92],
  Ténèbres: ["776e77", 20, "1a161b", 92],
  Vol: ["2c92fe", 6, "006f9e", 74]
};
var language = "Fr";


document.getElementById('gender_button').addEventListener('click', function () {
  // if (JSON.parse(this.responseText)[0]["id"].spriteF != null){
  //   document.getElementById("img").style.backgroundImage = "url('" + JSON.parse(this.responseText)[0]["spriteF"] + "')";
  // }
  if (document.getElementById("gender_button").innerHTML === "♂") {
    document.getElementById("gender_button").innerHTML = "♀";
  }
  else {
    document.getElementById("gender_button").innerHTML = "♂";
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
  }
  else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("id_Pokemon").innerHTML = "Id : " + JSON.parse(this.responseText)[0]["id"];
        document.getElementById("nom_Pokemon").innerHTML = " Nom : " + getText(JSON.parse(this.responseText)[0]["name"]);
        document.getElementById("img").style.backgroundImage = "url('" + JSON.parse(this.responseText)[0]["spriteM"] + "')";
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
        if (JSON.parse(this.responseText)[0]["type2"] === null) {
          document.getElementById("type_Pokemon").innerHTML = getText(JSON.parse(this.responseText)[0]["type1"])
          const colorType = getText(JSON.parse(this.responseText)[0]["type1"]);
          document.getElementById("type_Pokemon").style.background = 'linear-gradient( 90deg, #' + TableColor[colorType][0] + ', #' + TableColor[colorType][2] + ')';
        }
        else {
          document.getElementById("type_Pokemon").innerHTML = getText(JSON.parse(this.responseText)[0]["type1"]) + " \t \t  " + getText(JSON.parse(this.responseText)[0]["type2"]);
          const colorType1 = getText(JSON.parse(this.responseText)[0]["type1"]);
          const colorType2 = getText(JSON.parse(this.responseText)[0]["type2"]);
          document.getElementById("type_Pokemon").style.background = 'linear-gradient( 90deg, #' + TableColor[colorType1][0] + ', #' + TableColor[colorType2][0] + ')';
        }
        document.getElementById("gen_Pokemon").innerHTML = "Gen : " + JSON.parse(this.responseText)[0]["generation"];
        document.getElementById("taille_Pokemon").innerHTML = "Taille : " + JSON.parse(this.responseText)[0]["height"] / 10.0 + " m";
        document.getElementById("poids_Pokemon").innerHTML = "Poids : " + JSON.parse(this.responseText)[0]["weight"] / 10.0 + " Kg";
        document.getElementById("catch_rate_Pokemon").innerHTML = "Taux de capture : " + JSON.parse(this.responseText)[0]["catch_rate"];
      }
    }
  };

for (var i = 0; i < pokemons.length; i++) {
  pokemons[i].addEventListener('click', myFunction, false);
}


