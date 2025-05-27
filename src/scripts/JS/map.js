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
  if (str == undefined || str == null) return "";
  if (language === "fr") {
    if (str.split("///")[1] == "NULL")
      // if not found, return en version
      return str.split("///")[0];
    return str.split("///")[1];
  }
  return str.split("///")[0];
}

// map zoom
mapP.addEventListener("wheel", function (e) {
  if (currentMode != "Interactive") return;
  if (document.getElementById("pokedex").contains(e.target)) return;

  if (e.deltaY < 0) {
    //scroll direction : < 0 = zoom
    if (parseFloat(map.style.height) * 1.1 > 3000) {
      // max zoom
      return;
    }

    map.style.height = parseFloat(map.style.height) * 1.1 + "px";
    map.style.width = parseFloat(map.style.width) * 1.1 + "px";
    let a = parseFloat(map.style.left);
    let b = parseFloat(map.style.top);
    map.style.left = e.offsetX - (e.offsetX - a) * 1.1 + "px"; // zomm where the mouse is
    map.style.top = e.offsetY - (e.offsetY - b) * 1.1 + "px"; // zoom where the mouse is
  } else if (e.deltaY > 0) {
    map.style.height = parseFloat(map.style.height) * 0.9 + "px";
    map.style.width = parseFloat(map.style.width) * 0.9 + "px";
    let a = parseFloat(map.style.left);
    let b = parseFloat(map.style.top);
    map.style.left = e.offsetX - (e.offsetX - a) * 0.9 + "px"; // dezomm where the mouse is
    map.style.top = e.offsetY - (e.offsetY - b) * 0.9 + "px"; // dezomm where the mouse is
  }
  bubble.style.display = "none";
});

let drag = false;
mapP.addEventListener("mousedown", function () {
  if (currentMode == "Interactive") drag = true; //start dragging
});

document.addEventListener("mouseup", function () {
  drag = false; // stop dragging
});

// event for phones (not working until installing a special thingy)
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
    map.style.left = parseFloat(map.style.left) + e.movementX + "px";
    map.style.top = parseFloat(map.style.top) + e.movementY + "px";
    bubble.style.display = "none";
  }
};

// re-center / re-size the map
function center() {
  if (currentMode != "Interactive") return;
  map.style.width = "350px";
  map.style.height = "350px";
  map.style.left =
    mapP.offsetWidth / 2 - parseFloat(map.style.width) / 2 + "px";
  map.style.top =
    mapP.offsetHeight / 2 - parseFloat(map.style.height) / 2 + "px";
  bubble.style.display = "none";
}

document.getElementById("centered").addEventListener("click", center);

// map management
let imgMap = document.getElementById("imgMap");
let svgMap = document.getElementById("svgMap");
map.style.left = mapP.offsetWidth / 2 - parseFloat(map.offsetWidth) / 2 + "px";
map.style.top = mapP.offsetHeight / 2 - parseFloat(map.offsetHeight) / 2 + "px";

imgMap.style.margin = "auto";
svgMap.style.left = "0px";
svgMap.style.top = "0px";
svgMap.style.width = "350px";
svgMap.style.height = "350px";

// when map changes
function updateMap(e) {
  if (e == "regionChanged" || (e instanceof Event && e.target.checked)) {
    // quick verification (don't remember for waht)
    if (currentMode == "InGame" || currentMode == "Realistic") {
      if (map instanceof SVGElement) {
        // need a png image
        map = imgMap;
        svgMap.style.display = "none";
        imgMap.style.display = "unset";
      }
      if (currentMode == "Realistic") {
        imgMap.src = "../../public/img/" + currentRegion + "Realist.png";
        imgMap.alt = "image carte" + currentRegion + "realiste";
      } else {
        imgMap.src = "../../public/img/" + currentRegion + ".png";
        imgMap.alt = "image carte" + currentRegion;
      }

      document.getElementById("pokedexContainer").style.display = "none"; // disbale pokedex (reserved Interactive map)
      document.getElementById("centered").style.display = "none"; // disbale center button (reserved Interactive map)
      [...document.querySelectorAll(".location")].forEach((location) => {
        location.style.cursor = "unset";
      });
    } else if (currentMode == "Interactive") {
      if (currentRegion != "Hoenn" && currentRegion != "Kanto") {
        // only those have svg ready
        alert("Interactive map haven't been set yet for this region");
        return;
      }
      if (!(map instanceof SVGElement)) {
        // need a svg image
        console.log("changing to svg");
        map = svgMap;
        imgMap.style.display = "none";
        svgMap.style.display = "unset";
      }
      if (currentRegion == "Hoenn") svgMap.innerHTML = Hoenn;
      else if (currentRegion == "Kanto") svgMap.innerHTML = Kanto;
      bindInteractiveMap();
      document.getElementById("pokedexContainer").style.display = "block"; // enable pokedex (reserved Interactive map)
      document.getElementById("centered").style.display = "block"; // enable center button (reserved Interactive map)
      [...document.querySelectorAll(".location")].forEach((location) => {
        location.style.cursor = "pointer";
      });
      createPokedex();
    }
    center(); // center the map
  }
}

//map change inputs
document.getElementById("gameMap").addEventListener("click", (e) => {
  currentMode = "InGame";
  updateMap(e);
});

document.getElementById("realMap").addEventListener("click", (e) => {
  currentMode = "Realistic";
  updateMap(e);
});

document.getElementById("interactiveMap").addEventListener("click", (e) => {
  if (currentRegion != "Hoenn" && currentRegion != "Kanto") {
    // only those have svg ready
    alert("Interactive map haven't been set yet for this region");
    if (currentMode == "InGame") document.getElementById("gameMap").click();
    else document.getElementById("realMap").click();
    return;
  }
  currentMode = "Interactive";
  updateMap(e);
});

// the map region has been changed
document.getElementById("mapList").addEventListener("change", async (e) => {
  currentRegion = e.target.options[e.target.selectedIndex].value;
  const decodedJSON = await fetch(
    "../database/get/FromJS/getDBDataMaps.php?request=GetLocationFromRegion&1=" +
      currentRegion
  ).then((res) => res.json());
  // var xmlhttp = new XMLHttpRequest();
  // xmlhttp.onreadystatechange = function () {
  //     if (this.readyState == 4 && this.status == 200) {
  let dataLocation = decodedJSON;
  // Info Location on DB
  locationContainer.innerHTML = ""; // upd the list of map location
  for (let i = 0; i < dataLocation.length; ++i) {
    let location = document.createElement("div");
    location.className = "location";
    location.dataset.location = getText(dataLocation[i]["name"], "en");
    location.innerHTML = getText(dataLocation[i]["name"], language);
    locationContainer.appendChild(location);
  }
  if (
    currentMode == "Interactive" &&
    currentRegion != "Kanto" &&
    currentRegion != "Hoenn"
  ) {
    alert("carte pas encore interactive");
    return;
  }
  updateMap("regionChanged");
  console.log(currentRegion);
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
  let locationClass = target.className.baseVal.split(" ");
  let currentClass = locationClass[locationClass.length - 1];
  let displayedClass =
    currentClass == "sea"
      ? "mer"
      : currentClass == "road"
      ? "route"
      : currentClass == "city"
      ? "ville"
      : "special";
  bubbleText.innerHTML =
    getListElement(target.id).innerHTML + " \n\n(" + displayedClass + ")";
  bubble.style.left =
    parseFloat(
      target.getBoundingClientRect().x -
        12 +
        target.getBoundingClientRect().width / 2
    ) + "px";
  bubble.style.top = parseFloat(target.getBoundingClientRect().y - 35) + "px";
}

// svg element hovered
function onOver(e) {
  replaceBubble(e.target);
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
}

// unselect location
function removeLocation(location, updPokemon = true) {
  removeBubble(true);
  currentLocation = undefined;
  if (location != null) location.style.background = "";
  if (updPokemon) showLocationPokemon("");
}

// user click on location
function selectLocation(name) {
  let locationListItem = getListElement(name);
  locationListItem.scrollIntoView({ behavior: "smooth" });
  if (locationListItem == null) return;
  if (currentLocation == undefined) {
    // if nothing selected
    setLocation(locationListItem);
  } else if (currentLocation.id == name) {
    // if already slelected
    removeLocation(locationListItem);
  } else {
    // if another location selected
    removeLocation(getListElement(currentLocation.id), false);
    setLocation(locationListItem);
  }
}

// mouse leaving map element
function onLeave(e) {
  removeBubble();
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
      } else if (currentLocation.id == mapLocationList[loc].id) {
        removeLocation(location);
      } else {
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
    locationList[location].addEventListener("click", () => {
      onLocationClick(locationList[location]);
    });
  }
}
// endregion

// region searchbar
function filter() {
  [...document.querySelectorAll(".location")].forEach((location) => {
    location.style.display = "none";
  });
  let searchBar = document.getElementById("searchBar");
  searchBar = searchBar.value.toLowerCase();
  let locationList = document.getElementsByClassName("location");
  for (let i = 0; i < locationList.length; ++i) {
    if (typeof locationList[i] != "object") continue;
    if (locationList[i].innerHTML.toLowerCase().includes(searchBar))
      locationList[i].style.display = "block";
  }
}

document.getElementById("searchBar").addEventListener("input", filter);
// endregion

// region pokedex
let lastPokemonClickedId = -1;
let pokedex = document.getElementById("pokedex");

async function createPokedex() {
  pokedex.innerHTML = "";
  let dataPokemon = await fetch(
    "../database/get/FromJS/getDBDataMaps.php?request=GetInfoPokemonFromRegion&1=" +
      currentRegion
  ).then((res) => res.json());

  for (let i = 0; i < dataPokemon.length; ++i) {
    let pokemon = document.createElement("div");
    pokemon.className = "pokemonn";
    pokemon.tabIndex = "11";
    let image = document.createElement("img");
    image.className = "pokemonImage";
    image.draggable = false;
    image.src = dataPokemon[i].spriteM;
    image.alt = "Image " + getText(dataPokemon[i].name, language);
    image.dataset.id = dataPokemon[i].id;
    image.loading = "lazy"
    image.decoding =  "async"
    let name = document.createElement("p");
    name.innerHTML = getText(dataPokemon[i].name, language);
    pokemon.appendChild(image);
    pokemon.appendChild(name);
    pokedex.appendChild(pokemon);

    pokemon.addEventListener("click", () => {
      pokemonClick(pokemon.firstElementChild.dataset.id);
    });

    pokemon.addEventListener("dblclick", () => {
      // console.log("dbb")
      let form = document.createElement("form");
      form.setAttribute("method", "POST");
      form.setAttribute("action", "./pokedex.php");

      let data = document.createElement("input");
      data.setAttribute("type", "hidden");
      data.setAttribute("name", "pokemonId");
      data.setAttribute("value", pokemon.firstElementChild.dataset.id);
      form.appendChild(data);

      document.body.appendChild(form);
      // console.log( pokemon.firstElementChild.dataset.id)
      form.submit();
    });
  }
}

// get location where pokemon clicked lives in
async function pokemonClick(id) {
  let decodedJSON;
  if (lastPokemonClickedId == id) {
    decodedJSON = await fetch(
      "../database/get/FromJS/getDBDataMaps.php?request=GetLocationFromRegion&1=" +
        currentRegion
    ).then((res) => res.json());
    lastPokemonClickedId = -1;
  } else {
    decodedJSON = await fetch(
      "../database/get/FromJS/getDBDataMaps.php?request=GetLocationFromPokemon&1=" +
        currentRegion +
        "&2=" +
        id
    ).then((res) => res.json());
    lastPokemonClickedId = id;
  }

  const dataLocation = decodedJSON;

  console.log(dataLocation);
  // Info Location in DB
  let locationList = document.getElementsByClassName("location");
  if (dataLocation == "No results found.") {
    alert("pas de lieu trouvé");
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
      if (
        locationList[i].dataset.location ==
        getText(dataLocation[j]["name"], "en")
      )
        found = true;
    }
    if (found) locationList[i].style.display = "block";
    else locationList[i].style.display = "none";
  }
}

// when click on location, show all pokemon living here
async function showLocationPokemon(location) {
  let decodedJSON;
  if (location == "") {
    decodedJSON = await fetch(
      "../database/get/FromJS/getDBDataMaps.php?request=GetPokemonFromRegion&1=" +
        currentRegion
    ).then((res) => res.json());
  } else {
    decodedJSON = await fetch(
      "../database/get/FromJS/getDBDataMaps.php?request=GetPokemonFromLocation&1=" +
        currentRegion +
        "&2=" +
        location
    ).then((res) => res.json());
  }

  const dataPokemon = decodedJSON;
  // Info pokemon live on this location in BD

  let pokemons = document.getElementsByClassName("pokemonn");

  //update pokedex
  let found = false;
  for (let i = 0; i < pokemons.length; ++i) {
    if (typeof pokemons[i] != "object") continue;
    pokemons[i].style.display = "none";
    for (let j = 0; j < dataPokemon.length; ++j) {
      found = false;
      if (pokemons[i].firstElementChild.dataset.id == dataPokemon[j]["id"]) {
        found = true;
        break;
      }
    }
    if (found) pokemons[i].style.display = "flex";
    else pokemons[i].style.display = "none";
  }
}

// pokemon searchBar
function pokemonSearch() {
  let searchBar = document.getElementById("pokemonSearch");
  searchBar = searchBar.value.toLowerCase();
  let pokemonList = document.getElementsByClassName("pokemonn");
  for (let i = 0; i < pokemonList.length; ++i) {
    if (typeof pokemonList[i] != "object") continue;
    pokemonList[i].style.display = "none";
    console.log(
      pokemonList[i].lastElementChild.innerHTML.toLowerCase(),
      searchBar
    );
    // console.log(pokemonList[i].lastElementChild.innerHTML.toLowerCase().includes(searchBar));
    if (
      pokemonList[i].lastElementChild.innerHTML
        .toLowerCase()
        .includes(searchBar)
    )
      pokemonList[i].style.display = "flex";
  }
  // console.log(searchBar)
}

document
  .getElementById("pokemonSearch")
  .addEventListener("input", pokemonSearch);

document.addEventListener("keydown", (e) => {
  if (
    (document.activeElement.className == "radio" ||
      document.activeElement.className == "location" ||
      document.activeElement.id == "centered") &&
    e.key == "Enter"
  ) {
    let active = document.activeElement;
    active.click();
    active.focus();
  } else if (
    document.activeElement.className == "location" &&
    e.key == "Escape"
  ) {
    if (currentMode == "Interactive") {
      document.getElementById("centered").focus();
    } else {
      document.getElementById("looseFocus").focus();
    }
  } else if (
    document.activeElement.className == "location" &&
    e.key == "Escape"
  ) {
    document.getElementById("looseFocus").focus();
  }
});

center();
