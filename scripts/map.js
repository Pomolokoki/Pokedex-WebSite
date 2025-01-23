let language = "fr";

let currentRegion = "Kanto";
let currentMode = "InGame";
let currentLocation = undefined;

let map = document.getElementById("imgMap");
let mapP = document.getElementById("smallMapFrame");

let bubble = document.getElementById("bubble");
let bubbleText = document.getElementById("locationName");

let locationContainer = document.getElementById("mapLocation");
// region map stuff
// in DB text are wrotten like : 'en/fr', so we can split it up to get the desired language
function getText(str, language) {
    if (language === "fr") {
        if (str.split('///')[1] == "NULL") // if not foudn, return en version
            return str.split('///')[0];
        return str.split('///')[1];
    }
    return str.split('///')[0];
}

// map zoom
mapP.addEventListener("wheel", function (e) {
    if (currentMode != "Interactive")
        return;
    if (document.getElementById("pokedex").contains(e.target))
        return;

    if (e.deltaY < 0) { //scroll direction : < 0 = zoom
        if (parseFloat(map.style.height) * 1.1 > 3000) { // max zoom
            return;
        }

        map.style.height = parseFloat(map.style.height) * 1.1 + "px";
        map.style.width = parseFloat(map.style.width) * 1.1 + "px";
        let a = parseFloat(map.style.left);
        let b = parseFloat(map.style.top);
        map.style.left = (e.offsetX - (e.offsetX - a) * 1.1) + "px"; // zomm where the mouse is
        map.style.top = (e.offsetY - (e.offsetY - b) * 1.1) + "px"; // zoom where the mouse is
    }
    else if (e.deltaY > 0) {
        map.style.height = parseFloat(map.style.height) * 0.9 + "px";
        map.style.width = parseFloat(map.style.width) * 0.9 + "px";
        let a = parseFloat(map.style.left);
        let b = parseFloat(map.style.top);
        map.style.left = (e.offsetX - (e.offsetX - a) * 0.9) + "px"; // dezomm where the mouse is
        map.style.top = (e.offsetY - (e.offsetY - b) * 0.9) + "px"; // dezomm where the mouse is
    }
    bubble.style.display = "none"
})


let drag = false;
mapP.addEventListener("mousedown", function () {
    if (currentMode == "Interactive")
        drag = true; //start dragging
})

document.addEventListener("mouseup", function () {
    drag = false; // stop dragging
})

// event for phones (not working)
/*document.addEventListener('touchstart', function (e) {
    drag = true
})
document.addEventListener('touchend', function (e) {
    drag = false
})
document.addEventListener('touchmove', function (e) {
    console.log(e)
    if (drag) {
        map.style.left = parseFloat(map.style.left) + e.movementX + 'px';
        map.style.top = parseFloat(map.style.top) + e.movementY + 'px'
        bubble.style.display = "none"
    }
})*/

// when mouse move, no matter where
document.onmousemove = function (e) {
    if (drag) {
        map.style.left = parseFloat(map.style.left) + e.movementX + 'px';
        map.style.top = parseFloat(map.style.top) + e.movementY + 'px';
        bubble.style.display = "none";
    }
}


// re-center / re-size the map
function center() {
    if (currentMode != "Interactive")
        return;
    map.style.width = '350px';
    map.style.height = '350px';
    map.style.left = mapP.offsetWidth / 2 - parseFloat(map.style.width) / 2 + "px";
    map.style.top = mapP.offsetHeight / 2 - parseFloat(map.style.height) / 2 + "px";
    bubble.style.display = "none";
}

document.getElementById("centered").addEventListener("click", center)





// map management
let imgMap = document.getElementById("imgMap");
let svgMap = document.getElementById("svgMap");
map.style.left = mapP.offsetWidth / 2 - parseFloat(map.offsetWidth) / 2 + "px";
map.style.top = mapP.offsetHeight / 2 - parseFloat(map.offsetHeight) / 2 + "px";
    
// imgMap.style.left = "0px";
// imgMap.style.top = "0px";
// imgMap.style.width = "350px";
// imgMap.style.height = "350px";
imgMap.style.margin = "auto";
svgMap.style.left = "0px";
svgMap.style.top = "0px";
svgMap.style.width = "350px";
svgMap.style.height = "350px";

// when map changes
function updateMap(e) {
    if (e == "regionChanged" || (e instanceof Event && e.target.checked)) { // quick verification (don't remember for waht)
        if (currentMode == "InGame" || currentMode == "Realistic") {
            if (map instanceof SVGElement) { // need a png image
                map = imgMap;
                svgMap.style.display = "none";
                imgMap.style.display = "unset";
            }
            if (currentMode == "Realistic")
                imgMap.src = "./img/" + currentRegion + "Realist.png";
            else
                imgMap.src = "./img/" + currentRegion + ".png";
            document.getElementById("pokedexContainer").style.display = "none"; // disbale pokedex (reserved Interactive map)
            document.getElementById("centered").style.display = "none";         // disbale center button (reserved Interactive map)
            [...document.querySelectorAll(".location")].forEach(location => {location.style.cursor = "unset";})
        }   
        else if (currentMode == "Interactive") {
            if (currentRegion != "Hoenn" && currentRegion != "Kanto") { // only those have svg ready
                alert("Interactive map haven't been set yet for this region");
                return;
            }
            if (!(map instanceof SVGElement)) { // need a svg image
                console.log("changing to svg");
                map = svgMap;
                imgMap.style.display = "none";
                svgMap.style.display = "unset";
            }
            if (currentRegion == "Hoenn")
                svgMap.innerHTML = Hoenn;
            else if (currentRegion == "Kanto")
                svgMap.innerHTML = Kanto;
            bindInteractiveMap();
            document.getElementById("pokedexContainer").style.display = "block"; // enable pokedex (reserved Interactive map)
            document.getElementById("centered").style.display = "block";         // enable center button (reserved Interactive map)
            [...document.querySelectorAll(".location")].forEach(location => {location.style.cursor = "pointer";})
        }
        center(); // center the map
    }
}


//map change inputs
document.getElementById("gameMap").addEventListener("click", (e) => {
    currentMode = "InGame";
    updateMap(e);
})

document.getElementById("realMap").addEventListener("click", (e) => {
    currentMode = "Realistic";
    updateMap(e);
})

document.getElementById("interactiveMap").addEventListener("click", (e) => {
    if (currentRegion != "Hoenn" && currentRegion != "Kanto") { // only those have svg ready
        alert("Interactive map haven't been set yet for this region");
        if (currentMode == "InGame")
            document.getElementById("gameMap").click();
        else
            document.getElementById("realMap").click();
        return;
    }
    currentMode = "Interactive";
    updateMap(e);
})

// the map region has been changed
document.getElementById("mapList").addEventListener("change", (e) => {
    currentRegion = e.target.options[e.target.selectedIndex].value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let dataLocation = JSON.parse(this.responseText);
            // Info Location on DB
            locationContainer.innerHTML = ""; // upd the list of map location
            for (let i = 0; i < dataLocation.length; ++i) {
                let location = document.createElement("div");
                location.className = "location";
                location.dataset.location = getText(dataLocation[i]["name"], "en");
                location.innerHTML = getText(dataLocation[i]["name"], language);
                locationContainer.appendChild(location);
            }
            if (currentMode == "Interactive" && (currentRegion != "Kanto" && currentRegion != "Hoenn")) {
                alert("carte pas encore interactive");
                return;
            }
            updateMap("regionChanged");
            console.log(currentRegion);
        }
    }
    xmlhttp.open("GET", `./ajax/getDBData.php?request=
      SELECT location.name
      FROM location 
      JOIN region ON location.regionId = region.id 
      WHERE region.name LIKE '` + currentRegion + "%'", true);
    xmlhttp.send();
});
// endregion

// region interactive

// get a .location element by giving the location name 
function getListElement(name) {
    // console.log(name);
    let locationList = document.getElementsByClassName("location");
    for (let location in locationList) {
        if (typeof locationList[location] != "object") continue;
        if (locationList[location].dataset.location == name) {
            return locationList[location];
        }
    }
    return null;
}

// place the bubble at the right position on the map
// force = force replace it
function replaceBubble(target, force = false) {
    if (currentLocation != undefined && !force) return;
    bubble.style.display = "unset";
    let locationClass = target.className.baseVal.split(' ');
    let currentClass = locationClass[locationClass.length - 1];
    let displayedClass = currentClass == "sea" ? "mer" : currentClass == "road" ? "route" : currentClass == "city" ? "ville" : "special";
    bubbleText.innerHTML = getListElement(target.id).innerHTML + " \n\n(" + displayedClass + ")";
    bubble.style.left = (parseFloat(target.getBoundingClientRect().x - 12 + target.getBoundingClientRect().width / 2)) + 'px';
    bubble.style.top = (parseFloat(target.getBoundingClientRect().y - 35)) + 'px';
}

// svg element hovered
function onOver(e) {
    replaceBubble(e.target);
    // has been used to clone an element on Kanto Map (svg not accurate) 
    //
    // if (e.target.id == cloned)
    //     return;
    // let clone = document.getElementById("cloned")
    // if (clone != null)
    // {
    //     cloned = undefined;   
    //     clone.remove()
    // }
    // if (currentRegion == "Kanto" && (e.target.id == "Route 17" || e.target.id == "Route 18" || e.target.id == "Route 12" ||  e.target.id == "Sea Route 19"))
    // {
    //     cloned = e.target.id;
    //     let clone =  e.target.cloneNode();
    //     clone.id = "cloned";
    //     clone.addEventListener("mouseleave", onLeave);
    //     svgMap.appendChild(clone);
    //     clone.style.filter = "brightness(70%)";
    // }
}

// remove the bubble form where it was
function removeBubble(force = false) {
    if (currentLocation != undefined && !force) return;
    bubble.style.display = "none";
    if (currentLocation != undefined) {
        currentLocation.style.filter = "";
    }
}

// apply location selction on map & location list
function setLocation(location) {
    currentLocation = document.getElementById(location.dataset.location);
    replaceBubble(currentLocation, true);
    currentLocation.style.filter = "brightness(70%)";
    location.style.background = "#ffffff";
    showLocationPokemon(location.dataset.location);

    // Kanto clone stuff (l.230)
    //
    // if (currentRegion == "Kanto" && (currentLocation.id == "Route 17" || currentLocation.id == "Route 18" || currentLocation.id == "Route 12" || currentLocation.id == "Sea Route 19"))
    // {
    //     console.log("currentLocation", currentLocation, location)
    //     let clone =  currentLocation.cloneNode();
    //     clone.id = "cloned";
    //     clone.addEventListener("mouseleave", onLeave);
    //     svgMap.appendChild(clone);
    // }

}

// unselect location
function removeLocation(location) {
    removeBubble(true);
    currentLocation = undefined;
    if (location != null)
        location.style.background = "";
    showLocationPokemon("");
}

// user click on location
function selectLocation(name) {
    let locationListItem = getListElement(name);
    locationListItem.scrollIntoView({ behavior: "smooth" });
    if (locationListItem == null) return;
    if (currentLocation == undefined) { // if nothing selected
        setLocation(locationListItem);
    }
    else if (currentLocation.id == name) { // if already slelected
        removeLocation(locationListItem);
    }
    else { // if another location selected
        removeLocation(getListElement(currentLocation.id));
        setLocation(locationListItem);
    }
}

// mouse leaving map element
function onLeave(e) {
    // clone stuff (l.230)
    //
    // if (e.target.id != cloned)
    removeBubble();

    // let clone = document.getElementById("cloned")
    // if (clone && e.target.id != cloned)
    // {
    //     clone.remove();
    //     cloned = undefined;
    // }
}

// mouse clicking on map element
function onClick(e) {
    let name = e.target.id;
    selectLocation(name);
}

// mouse clicking on location list element
function onLocationClick(location) {
    let mapLocationList = document.getElementsByClassName("mapLocation");
    for (let loc in mapLocationList) {
        if (typeof mapLocationList[loc] != "object") continue;
        if (location.dataset.location == mapLocationList[loc].id) {
            if (currentLocation == undefined) {
                setLocation(location);
            }
            else if (currentLocation.id == mapLocationList[loc].id) {
                removeLocation(location);
            }
            else {
                removeLocation(getListElement(currentLocation.id));
                setLocation(location);
            }
            break;
        }
    }
}

// set the location list element & map element ready to be clicked
let objectWithEvent = [];
let objectWithEvent2 = [];
function bindInteractiveMap() {
    // unbind
    for (let obj in objectWithEvent) {
        objectWithEvent[obj].removeEventListener("mouseover", onOver);
        objectWithEvent[obj].removeEventListener("mouseleave", onLeave);
        objectWithEvent[obj].removeEventListener("click", onClick);
    }
    for (let obj in objectWithEvent2) {
        objectWithEvent[obj].removeEventListener("click", onLocationClick);
    }
    // empty
    objectWithEvent = [];
    objectWithEvent2 = [];
    // bind
    let listLocation = document.getElementsByClassName("mapLocation");
    for (let location in listLocation) {
        if (typeof listLocation[location] != "object") continue;
        listLocation[location].addEventListener("mouseover", onOver);
        listLocation[location].addEventListener("mouseleave", onLeave);
        listLocation[location].addEventListener("click", onClick);
        objectWithEvent.push(listLocation[location]);
    }

    let locationList = document.getElementsByClassName("location");
    for (let location in locationList) {
        if (typeof locationList[location] != "object") continue;
        locationList[location].addEventListener("click", () => { onLocationClick(locationList[location]); })
    }
}
// endregion

// region searchbar
function filter() {
    [...document.querySelectorAll(".location")].forEach(location => {
        location.style.display = "none";
    });
    let searchBar = document.getElementById('searchBar');
    searchBar = searchBar.value.toLowerCase();
    let locationList = document.getElementsByClassName("location");
    for (let i = 0; i < locationList.length; ++i) {
        if (typeof locationList[i] != "object") continue;
        if (locationList[i].innerHTML.toLowerCase().includes(searchBar))
        locationList[i].style.display = "block";
    }
}

document.getElementById('searchBar').addEventListener('input', filter);
// endregion

// region pokedex
let lastPokemonClickedId = -1
let pokedex = document.getElementById("pokedex");

// get location where pokemon clicked lives in
function pokemonClick(id) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let dataLocation = JSON.parse(this.responseText);
            console.log(dataLocation)
            // Info Location in DB
            let locationList = document.getElementsByClassName("location");
            if (dataLocation == "No results found.") {
                alert("pas de lieu trouvé")
                for (let i = 0; i < locationList.length; ++i) {
                    if (typeof locationList[i] != "object") continue;
                    locationList[i].style.display = "block";
                }
                return;
            }

            //filter
            for (let i = 0; i < locationList.length; ++i) {
                if (typeof locationList[i] != "object") continue;
                locationList[i].style.display = "none";
            }
            for (let i = 0; i < locationList.length; ++i) {
                if (typeof locationList[i] != "object") continue;
                let found = false;
                for (let j = 0; j < dataLocation.length; ++j) {
                    if (locationList[i].dataset.location == getText(dataLocation[j]["name"], "en"))
                        found = true;
                }
                if (found)
                    locationList[i].style.display = "block";
                else
                    locationList[i].style.display = "none";
            }
        }
    }
    if (lastPokemonClickedId == id) { // unselect pokemon
        xmlhttp.open("GET", `./ajax/getDBData.php?request=
            SELECT location.name 
            FROM location 
            JOIN region ON location.regionId = region.id 
            WHERE region.name LIKE '` + currentRegion + "%'"
        );
        lastPokemonClickedId = -1;
    }
    else { // select pokemon
        xmlhttp.open("GET", `./ajax/getDBData.php?request=
            SELECT DISTINCT location.name 
            FROM location 
            INNER JOIN location_pokemon AS lp ON location.id = lp.locationId 
            INNER JOIN region ON location.regionId = region.id 
            WHERE region.name LIKE '` + currentRegion + "%' AND lp.pokemonId=" + id
        );
        lastPokemonClickedId = id;
    }
    xmlhttp.send();
}

// when click on location, show all pokemon living here
function showLocationPokemon(location) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let dataPokemon = JSON.parse(this.responseText);
            // Info pokemon live on this location in BD
            
            let pokemons = document.getElementsByClassName("pokemonn");

            // if (dataPokemon == "No results found.") {
            //     for (let i = 0; i < pokemons.length; ++i) {
            //         if (typeof pokemons[i] != "object") continue;
            //         pokemons[i].style.display = "block";
            //     }
            //     return;
            // }

            //update pokedex
            let found = false;
            for (let i = 0 ; i < pokemons.length; ++i) {
                if (typeof pokemons[i] != "object") continue;
                pokemons[i].style.display = "none";
                for (let j = 0; j < dataPokemon.length; ++j) {
                    found = false;
                    if (pokemons[i].firstElementChild.dataset.id == dataPokemon[j]["id"]) {
                        found = true;
                        break;
                    }
                }
                if (found)
                    pokemons[i].style.display = "flex";
                else
                    pokemons[i].style.display = "none";
            }
        }
    }
    if (location == "") { // unselect location
        xmlhttp.open("GET", `./ajax/getDBData.php?request=
            SELECT DISTINCT pokemon.id 
            FROM pokemon 
            JOIN location_pokemon AS lp ON pokemon.id = lp.pokemonId 
            JOIN region ON lp.generation = region.id 
            WHERE region.name LIKE '` + currentRegion + "%'");
    }
    else { // select location
        xmlhttp.open("GET", `./ajax/getDBData.php?request=
            SELECT DISTINCT pokemon.id 
            FROM pokemon 
            JOIN location_pokemon AS lp ON pokemon.id = lp.pokemonId 
            JOIN location ON location.id = lp.locationId 
            JOIN region ON lp.generation = region.id 
            WHERE region.name LIKE '` + currentRegion + "%' AND location.name LIKE'" + location + "%'");
    }
    xmlhttp.send();
}

// pokemon searchBar
function pokemonSearch() {
    // [...document.querySelectorAll(".pokemon")].forEach(pokemon => {
    //     pokemon.style.display = "none";
    // });
    let searchBar = document.getElementById('pokemonSearch');
    searchBar = searchBar.value.toLowerCase();
    let pokemonList = document.getElementsByClassName("pokemonn");
    for (let i = 0; i < pokemonList.length; ++i) {
        if (typeof pokemonList[i] != "object") continue;
        pokemonList[i].style.display = "none";
        console.log(pokemonList[i].lastElementChild.innerHTML.toLowerCase(), searchBar);
        // console.log(pokemonList[i].lastElementChild.innerHTML.toLowerCase().includes(searchBar));
        if (pokemonList[i].lastElementChild.innerHTML.toLowerCase().includes(searchBar))
            pokemonList[i].style.display = "flex";
    }
    // console.log(searchBar)
}

[...document.querySelectorAll(".pokemonn")].forEach(pokemon => {
    pokemon.addEventListener("click", () => { pokemonClick(pokemon.firstElementChild.dataset.id); })
    pokemon.addEventListener("dblclick", () => {
        // console.log("dbb")
        let form = document.createElement('form');
        form.setAttribute('method', 'POST');
        form.setAttribute('action', "./pokedex.php");

        let data = document.createElement('input');
        data.setAttribute('type', 'hidden');
        data.setAttribute('name', 'pokemonId');
        data.setAttribute('value', pokemon.firstElementChild.dataset.id);
        form.appendChild(data);

        document.body.appendChild(form);
        // console.log( pokemon.firstElementChild.dataset.id)
        form.submit();
    })
});

document.getElementById('pokemonSearch').addEventListener('input', pokemonSearch);


center();