// Requiring modules
//import express from 'express';
//require("mysql")

// import express from "express";

// const app = express();
// const PORT = 3000;

// app.get("/", (req, res) => {
//   res.send("Hello from Express!");
// });

// app.listen(PORT, () => {
//   console.log(`Express server running at http://localhost:${PORT}/`);
// });
// require(["mysql"],function(mysql){
//     /// your code

// const conn = mysql.createConnection({user: 'root',
//     password: 'root',
//     host: 'localhost',
//     database: 'pokedex'})
//     conn.connect();
// //const express = require('express');
// //const app = express();
// //const mssql = require(['require', 'mssql']);


//         // Query to the database and get the records
//         request.query('select * from type',
//             function (err, records) {

//                 if (err) console.log(err)

//                 // Send records as a response
//                 // to browser
//                 res.send(records);
//             });


// });

var last_id = "x";
var pokemons = document.getElementsByClassName("pokemon");
var core = document.getElementById("core");
var Pokemon = document.createElement("div");
var content = document.getElementById("conteneur")

var myFunction = function () {
    if (last_id === this.id) {
        console.log("a");
        last_id = "x";
        core.style.margin = "";
        core.style.maxWidth = "";
    }
    else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById("id_Pokemon").innerHTML = JSON.parse(this.responseText)[0]["id"];
              document.getElementById("nom_Pokemon").innerHTML = JSON.parse(this.responseText)[0]["name"];
              document.getElementById("img").style.backgroundImage = "url('" + JSON.parse(this.responseText)[0]["spriteM"] + "')";
            }
          }
          xmlhttp.open("GET", "./ajax/getPokeData.php?id="+this.id, true);
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