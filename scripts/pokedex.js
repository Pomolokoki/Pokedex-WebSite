var last_id = "x";
var pokemons = document.getElementsByClassName("pokemon");
var core = document.getElementById("core");
var Pokemon = document.createElement("div");
var content = document.getElementById("conteneur")
var language = "Fr";

function getText(str)
{
    if (language === "Fr"){
        return str.split('/')[1];
    }
}


var myFunction = function() {
    if (last_id === this.id){
        console.log("a");
        last_id = "x";
        core.style.margin = "";
        core.style.maxWidth = "";
    }
    else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById("id_Pokemon").innerHTML = "Id : " + JSON.parse(this.responseText)[0]["id"];
              document.getElementById("nom_Pokemon").innerHTML = " Nom : " + getText(JSON.parse(this.responseText)[0]["name"]);
              document.getElementById("img").style.backgroundImage = "url('" + JSON.parse(this.responseText)[0]["spriteM"] + "')";
              const x = JSON.parse(this.responseText)[0]["category"];
              if (x === 0){
                document.getElementById("categorie_Pokemon").innerHTML = "Commun";
              }
              if (x === 1){
                document.getElementById("categorie_Pokemon").innerHTML = "Légendaire";
              }
              if (x === 2){
                document.getElementById("categorie_Pokemon").innerHTML = "Fabuleux";
              }
              if (x === 3){
                document.getElementById("categorie_Pokemon").innerHTML = "Ultra-Chimère";
              }
              document.getElementById("type_Pokemon").innerHTML = getText(JSON.parse(this.responseText)[0]["type"]);
              document.getElementById("gen_Pokemon").innerHTML = "Gen : " + JSON.parse(this.responseText)[0]["generation"];
              document.getElementById("taille_Pokemon").innerHTML = "Taille : " + JSON.parse(this.responseText)[0]["height"]/10.0;
              document.getElementById("poids_Pokemon").innerHTML = "Poids : " + JSON.parse(this.responseText)[0]["weight"];
              document.getElementById("catch_rate_Pokemon").innerHTML = "Taux de capture : " + JSON.parse(this.responseText)[0]["catch_rate"] ;
            }
          }
          xmlhttp.open("GET", "./ajax/getDBData.php?request=SELECT pokemon.id,pokemon.name,pokemon.spriteM,pokemon.generation,pokemon.category,pokemon.height,pokemon.weight,pokemon.catch_rate, type.name AS type FROM pokemon JOIN type ON pokemon.type1 = type.id WHERE pokemon.id = "+this.id, true);
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


