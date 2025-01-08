
let currentRegion = "Kanto";
let currentMode = "InGame";
let currentLocation = undefined

let map = document.getElementById("imgMap")
let mapP = document.getElementById("smallMapFrame")

let bubble = document.getElementById("bubble")
let bubbleText = document.getElementById("locationName")

let locationContainer = document.getElementById("mapLocation")

let language = "fr";
function getText(str, language) {
    if (language === "fr") {
        if (str.split('/')[1] == "NULL")
            return str.split('/')[0];
        return str.split('/')[1];
    }
    return str.split('/')[0];
}

mapP.addEventListener("wheel", function (e) {
    if (e.deltaY < 0) {
        if (parseFloat(map.style.height) * 1.1 > 3000) {
            return;
        }

        map.style.height = parseFloat(map.style.height) * 1.1 + "px";
        map.style.width = parseFloat(map.style.width) * 1.1 + "px";
        let a = parseFloat(map.style.left) //+ parseFloat(map.style.width) ;
        let b = parseFloat(map.style.top) //+ parseFloat(map.style.height) ;
        map.style.left = (e.offsetX - (e.offsetX - a) * 1.1) + "px";
        map.style.top = (e.offsetY - (e.offsetY - b) * 1.1) + "px";
        //pos.y = at.y - (at.y - pos.y) * 1.1;
    }
    else if (e.deltaY > 0) {
        map.style.height = parseFloat(map.style.height) * 0.9 + "px";
        map.style.width = parseFloat(map.style.width) * 0.9 + "px";
        let a = parseFloat(map.style.left) //- parseFloat(map.style.width) ;
        let b = parseFloat(map.style.top) //- parseFloat(map.style.width) ;
        map.style.left = (e.offsetX - (e.offsetX - a) * 0.9) + "px";
        map.style.top = (e.offsetY - (e.offsetY - b) * 0.9) + "px";
    }
    bubble.style.display = "none"
})

let drag = false;
mapP.addEventListener("mousedown", function (e) {
    drag = true
})
/*document.addEventListener('touchstart', function (e) {
    drag = true
})*/
document.addEventListener("mouseup", function (e) {
    drag = false
})
/*document.addEventListener('touchend', function (e) {
    drag = false
})
document.addEventListener('touchmove', function (e) {
    console.log(e)
    if (drag) {
        map.style.left = parseFloat(map.style.left) + e.movementX + 'px';
        map.style.top = parseFloat(map.style.top) + e.movementY + 'px'
        bubble.style.display = "none"
    }
});*/
document.onmousemove = function (e) {
    if (drag) {
        map.style.left = parseFloat(map.style.left) + e.movementX + 'px';
        map.style.top = parseFloat(map.style.top) + e.movementY + 'px'
        bubble.style.display = "none"
    }
}



function center() {
    map.style.width = '350px'
    map.style.height = '350px'
    map.style.left = mapP.offsetWidth / 2 - parseFloat(map.style.width) / 2 + "px"
    map.style.top = mapP.offsetHeight / 2 - parseFloat(map.style.height) / 2 + "px"
    bubble.style.display = "none"
}

document.getElementById("centered").addEventListener("click", center)






let imgMap = document.getElementById("imgMap")
let svgMap = document.getElementById("svgMap")
imgMap.style.left = "0px"
imgMap.style.top = "0px"
imgMap.style.width = "350px"
imgMap.style.height = "350px"
svgMap.style.left = "0px"
svgMap.style.top = "0px"
svgMap.style.width = "350px"
svgMap.style.height = "350px"

function updateMap(e) {
    if (e == "regionChanged" || (e instanceof Event && e.target.checked)) {
        if (currentMode == "InGame" || currentMode == "Realistic") {
            if (map instanceof SVGElement) {
                map = imgMap;
                svgMap.style.display = "none"
                imgMap.style.display = "unset"
            }
            if (currentMode == "Realistic")
                imgMap.src = "./img/" + currentRegion + "Realist.png";
            else
                imgMap.src = "./img/" + currentRegion + ".png";
        }
        else if (currentMode == "Interactive") {
            if (currentRegion != "Hoenn" && currentRegion != "Kanto") {
                alert("Interactive map haven't been set yet for this region");
                return
            }
            if (!(map instanceof SVGElement)) {
                console.log("changing to svg")
                map = svgMap;
                imgMap.style.display = "none"
                svgMap.style.display = "unset"
            }
            if (currentRegion == "Hoenn")
                svgMap.innerHTML = Hoenn
            else if (currentRegion == "Kanto")
                svgMap.innerHTML = Kanto
            bindInteractiveMap()
        }
        center();
    }
}


document.getElementById("gameMap").addEventListener("click", (e) => {
    currentMode = "InGame"
    updateMap(e)
});

document.getElementById("realMap").addEventListener("click", (e) => {
    currentMode = "Realistic"
    updateMap(e)
});

document.getElementById("interactiveMap").addEventListener("click", (e) => {
    currentMode = "Interactive"
    updateMap(e)
});



document.getElementById("mapList").addEventListener("change", (e) => {
    currentRegion = e.target.options[e.target.selectedIndex].value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let dataLocation = JSON.parse(this.responseText);
            // Info Location
            locationContainer.innerHTML = "";
            for (let i = 0; i < dataLocation.length; ++i) {
                let location = document.createElement("div");
                location.className = "location"
                location.dataset.location = getText(dataLocation[i]["name"], "en")
                location.innerHTML = getText(dataLocation[i]["name"], language);
                locationContainer.appendChild(location)
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

function getListElement(name) {
    console.log(name)
    let locationList = document.getElementsByClassName("location")
    for (let location in locationList) {
        if (typeof locationList[location] != "object") continue
        if (locationList[location].dataset.location == name) {
            return locationList[location];
        }
    }
    return null;
}

function replaceBubble(target, force = false) {
    if (currentLocation != undefined && !force) return
    bubble.style.display = "unset"
    let locationClass = target.className.baseVal.split(' ')
    let currentClass = locationClass[locationClass.length - 1]
    let displayedClass = currentClass == "sea" ? "mer" : currentClass == "road" ? "route" : currentClass == "city" ? "ville" : "special";
    bubbleText.innerHTML = getListElement(target.id).innerHTML + " \n\n(" + displayedClass + ")"
    bubble.style.left = (parseFloat(target.getBoundingClientRect().x - 12 + target.getBoundingClientRect().width / 2)) + 'px'
    bubble.style.top = (parseFloat(target.getBoundingClientRect().y - 35)) + 'px'
}
// let cloned
function onOver(e) {
    replaceBubble(e.target)
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
function removeBubble(force = false) {
    if (currentLocation != undefined && !force) return;
    bubble.style.display = "none";
    if (currentLocation != undefined) {
        currentLocation.style.filter = "";
    }
}

function setLocation(location) {
    currentLocation = document.getElementById(location.dataset.location)
    replaceBubble(currentLocation, true);
    currentLocation.style.filter = "brightness(70%)";
    location.style.backgroundColor = "#ffffff";
    showLocationPokemon(location.dataset.location);

    // if (currentRegion == "Kanto" && (currentLocation.id == "Route 17" || currentLocation.id == "Route 18" || currentLocation.id == "Route 12" || currentLocation.id == "Sea Route 19"))
    // {
    //     console.log("currentLocation", currentLocation, location)
    //     let clone =  currentLocation.cloneNode();
    //     clone.id = "cloned";
    //     clone.addEventListener("mouseleave", onLeave);
    //     svgMap.appendChild(clone);
    // }

}
function removeLocation(location) {
    removeBubble(true);
    currentLocation = undefined;
    if (location != null)
        location.style.backgroundColor = "#ff0000";
    showLocationPokemon("");
}

function selectLocation(name) {
    let locationListItem = getListElement(name)
    locationListItem.scrollIntoView({ behavior: "smooth" });
    if (locationListItem == null) return;
    if (currentLocation == undefined) {
        setLocation(locationListItem)
    }
    else if (currentLocation.id == name) {
        removeLocation(locationListItem)
    }
    else {
        removeLocation(getListElement(currentLocation.id))
        setLocation(locationListItem)
    }
}

function onLeave(e) {
    // if (e.target.id != cloned)
    removeBubble();

    // let clone = document.getElementById("cloned")
    // if (clone && e.target.id != cloned)
    // {
    //     clone.remove();
    //     cloned = undefined;
    // }
}

function onClick(e) {
    let name = e.target.id
    selectLocation(name)
}

function onLocationClick(location) {
    console.log(location)
    let mapLocationList = document.getElementsByClassName("mapLocation")
    for (let loc in mapLocationList) {
        if (typeof mapLocationList[loc] != "object") continue
        if (location.dataset.location == mapLocationList[loc].id) {
            if (currentLocation == undefined) {
                setLocation(location)
            }
            else if (currentLocation.id == mapLocationList[loc].id) {
                removeLocation(location)
            }
            else {
                removeLocation(getListElement(currentLocation.id))
                setLocation(location)
            }
            break;
        }
    }
}

let objectWithEvent = []
let objectWithEvent2 = []
function bindInteractiveMap() {
    for (let obj in objectWithEvent) {
        objectWithEvent[obj].removeEventListener("mouseover", onOver)
        objectWithEvent[obj].removeEventListener("mouseleave", onLeave)
        objectWithEvent[obj].removeEventListener("click", onClick)
    }
    for (let obj in objectWithEvent2) {
        objectWithEvent[obj].removeEventListener("click", onLocationClick)
    }
    objectWithEvent = []
    objectWithEvent2 = []
    let listLocation = document.getElementsByClassName("mapLocation")
    for (let location in listLocation) {
        if (typeof listLocation[location] != "object") continue;
        listLocation[location].addEventListener("mouseover", onOver)
        listLocation[location].addEventListener("mouseleave", onLeave)
        listLocation[location].addEventListener("click", onClick)
        objectWithEvent.push(listLocation[location])
    }


    let locationList = document.getElementsByClassName("location")
    for (let location in locationList) {
        if (typeof locationList[location] != "object") continue;
        locationList[location].addEventListener("click", () => { onLocationClick(locationList[location]) })
    }
}

function filter() {
    [...document.querySelectorAll(".location")].forEach(location => {
        location.style.display = "none";
    });
    let searchBar = document.getElementById('searchBar')
    searchBar = searchBar.value.toLowerCase();
    console.log(searchBar)
    let locationList = document.getElementsByClassName("location")
    for (let i = 0; i < locationList.length; ++i) {
        if (typeof locationList[i] != "object") continue;
        if (locationList[i].innerHTML.toLowerCase().includes(searchBar))
            locationList[i].style.display = "block";
    }
}

document.getElementById('searchBar').addEventListener('input', filter);



center();

// document.getElementById("currentgen").addEventListener('click', () => {document.location.href = './map.php?pokemonId=4&generationId=1'; window.open("")})

// bindInteractiveMap();







let lastPokemonClickedId = -1
function pokemonClick(id) {

    console.log("pokemon id : ", id)


    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let dataLocation = JSON.parse(this.responseText);
            // Info Location
            locationContainer.innerHTML = "";
            for (let i = 0; i < dataLocation.length; ++i) {
                let location = document.createElement("div");
                location.className = "location"
                location.dataset.location = getText(dataLocation[i]["name"], "en")
                location.innerHTML = getText(dataLocation[i]["name"], language);
                locationContainer.appendChild(location)
            }
        }
    }
    if (lastPokemonClickedId == id) {
        xmlhttp.open("GET", `./ajax/getDBData.php?request=
            SELECT location.name 
            FROM location 
            JOIN region ON location.regionId = region.id 
            WHERE region.name LIKE '` + currentRegion + "%'"
        );
        lastPokemonClickedId = -1;
    }
    else {
        xmlhttp.open("GET", `./ajax/getDBData.php?request=
            SELECT location.name 
            FROM location 
            JOIN location_pokemon AS lp ON location.id = lp.locationId 
            JOIN region ON location.regionId = region.id 
            WHERE region.name LIKE '` + currentRegion + "%' AND lp.pokemonId=" + id
        );
        lastPokemonClickedId = id;
    }
    xmlhttp.send();
}
let pokedex = document.getElementById("pokedex");
function showLocationPokemon(location) {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let dataPokemon = JSON.parse(this.responseText);
            // Info Location
            pokedex.innerHTML = "";
            for (let i = 0; i < dataPokemon.length; ++i) {
                let pokemon = document.createElement("div");
                pokemon.className = "pokemon";
                let img = pokemon.createElement("img");
                img.className = "pokemonImage";
                img.draggable = false;
                img.src = dataPokemon[i]["spriteM"];
                img.dataset.id = dataPokemon[i]["id"]
                let p = pokemon.createElement("p");
                p.innerHTML = getText(dataPokemon[i]["name"], language);
                pokedex.appendChild(pokemon)
            }
        }
    }
    if (location == "") {

        xmlhttp.open("GET", `./ajax/getDBData.php?request=
            SELECT pokemon.name, pokemon.spriteM, pokemon.id 
            FROM pokemon 
            JOIN location_pokemon AS lp ON pokemon.id = lp.pokemonId 
            JOIN region ON lp.generation = region.id 
            WHERE region.name LIKE '` + currentRegion + "%");
    }
    else {
        xmlhttp.open("GET", `./ajax/getDBData.php?request=
            SELECT pokemon.name, pokemon.spriteM, pokemon.id 
            FROM pokemon 
            JOIN location_pokemon AS lp ON pokemon.id = lp.pokemonId 
            JOIN location ON location.id = lp.locationId 
            JOIN region ON lp.generation = region.id 
            WHERE region.name LIKE '` + currentRegion + "%' AND location.name LIKE'" + location + "%'");
    }
    xmlhttp.send();
}

function pokemonSearch() {
    [...document.querySelectorAll(".pokemon")].forEach(pokemon => {
        pokemon.style.display = "none";
    });
    let searchBar = document.getElementById('pokemonSearch')
    searchBar = searchBar.value.toLowerCase();
    let pokemonList = document.getElementsByClassName("pokemon")
    for (let i = 0; i < pokemonList.length; ++i) {
        if (typeof pokemonList[i] != "object") continue;
        if (pokemonList[i].innerHTML.toLowerCase().includes(searchBar))
            pokemonList[i].style.display = "block";
    }
}

[...document.querySelectorAll(".pokemon")].forEach(pokemon => {
    pokemon.addEventListener("click", pokemonClick(pokemon.firstChild.dataset.id))
    pokemon.addEventListener("dbclick", () => {
        let form = document.createElement('form');
        form.setAttribute('method', 'POST');
        form.setAttribute('action', "./pokedex.php");

        let data = document.createElement('input');
        data.setAttribute('type', 'hidden');
        data.setAttribute('name', 'pokemonId');
        data.setAttribute('value', pokemon.firstChild.dataset.id);
        form.appendChild(data);

        document.body.appendChild(form);
        form.submit();
    }
    );
});

document.getElementById('pokemonSearch').addEventListener('input', pokemonSearch);
