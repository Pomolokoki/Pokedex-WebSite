
let currentRegion = "Hoenn";
let currentMode = "InGame";
let currentLocation = undefined

let map = document.getElementById("svgMap")
map.style.left = "0px"
map.style.top = "0px"
console.log(map.clientHeight)
map.style.width = map.clientWidth + 'px'
map.style.height = map.clientHeight + 'px'
let mapP = document.getElementById("smallMapFrame")

let bubble = document.getElementById("bubble")
let bubbleText = document.getElementById("locationName")


mapP.addEventListener("wheel", function (e) {
    if (e.deltaY < 0) {
        console.log(map.style.height)
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
document.addEventListener("mouseup", function (e) {
    drag = false
})
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
    console.log(map.style.width, mapP.offsetWidth)
    map.style.left = mapP.offsetWidth / 2 - parseFloat(map.style.width) / 2 + "px"
    map.style.top = mapP.offsetHeight / 2 - parseFloat(map.style.height) / 2 + "px"
    bubble.style.display = "none"
}

document.getElementById("centered").addEventListener("click", center)
center();







let imgMap = document.getElementById("imgMap")
let svgMap = document.getElementById("svgMap")

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
            if (currentRegion != "Hoenn") {
                alert("Interactive map haven't been set yet for this region");
                return
            }
            if (!(map instanceof SVGElement)) {
                console.log("changing to svg")
                map = svgMap;
                imgMap.style.display = "none"
                svgMap.style.display = "unset"
            }
            svgMap.innerHTML = Hoenn
            bindInteractiveMap()
        }
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
    updateMap("regionChanged");
    console.log(currentRegion)
});

function getListElement(name)
{
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
    console.log("eh", currentLocation)
    bubble.style.display = "unset"
    let locationClass = target.className.baseVal.split(' ')
    let currentClass = locationClass[locationClass .length - 1]
    let displayedClass = currentClass == "sea" ? "mer" : currentClass == "road" ? "route" : currentClass == "city" ? "ville" : "special";
    bubbleText.innerHTML = getListElement(target.id).innerHTML + " \n\n(" + displayedClass + ")"
    bubble.style.left = (parseFloat(target.getBoundingClientRect().x - 12 + target.getBoundingClientRect().width / 2)) + 'px'
    bubble.style.top = (parseFloat(target.getBoundingClientRect().y - 35)) + 'px'
}

function onOver(e) {
    replaceBubble(e.target)
}
function removeBubble(force = false) {
    if (currentLocation != undefined && !force) return
    bubble.style.display = "none"
    if (currentLocation != undefined)
    {
        currentLocation.style.filter = "";
    }
}

function setLocation(location)
{
    currentLocation = document.getElementById(location.dataset.location)
    replaceBubble(currentLocation, true)
    currentLocation.style.filter = "brightness(70%)"
    location.style.backgroundColor = "#ffffff"
}
function removeLocation(location)
{
    console.log(location)
    removeBubble(true);
    currentLocation = undefined
    location.style.backgroundColor = "#ff0000"
    console.log(location)
}

function selectLocation(name) {
    let locationListItem = getListElement(name)
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

function onLeave()
{
    removeBubble();
}

function onClick(e) {
    let name = e.target.id
    selectLocation(name)
}

let objectWithEvent = []
function bindInteractiveMap() {
    for (let obj in objectWithEvent) {
        objectWithEvent[obj].removeEventListener("mouseover", onOver)
        objectWithEvent[obj].removeEventListener("mouseleave", onLeave)
        objectWithEvent[obj].removeEventListener("click", onClick)
    }
    objectWithEvent = []
    let listLocation = document.getElementsByClassName("mapLocation")
    for (let location in listLocation) {
        if (typeof listLocation[location] != "object") continue;
        listLocation[location].addEventListener("mouseover", onOver)
        listLocation[location].addEventListener("mouseleave", onLeave)
        listLocation[location].addEventListener("click", onClick)
        objectWithEvent.push(listLocation[location])
    }
}

let locationList = document.getElementsByClassName("location")
for (let location in locationList) {
    if (typeof locationList[location] != "object") continue
    locationList[location].addEventListener("click", () => {

        let mapLocationList = document.getElementsByClassName("mapLocation")
        for (let loc in mapLocationList) {
            if (typeof mapLocationList[loc] != "object") continue
            //console.log(mapLocationList[loc])
            if (locationList[location].dataset.location == mapLocationList[loc].id) {
                if (currentLocation == undefined) {
                    setLocation(locationList[location])
                }
                else if (currentLocation.id == mapLocationList[loc].id){
                    removeLocation(locationList[location])
                }
                else {
                    removeLocation(getListElement(currentLocation.id))
                    setLocation(locationList[location])
                }
                break;
            }
        }
    })

}

// bindInteractiveMap();