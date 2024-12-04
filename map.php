<?php
include_once("./database/extractDataFromDB.php");
$isSet = isset($_POST["pokemonId"]) && isset($_POST["generationId"]);
// var_dump($_POST);
// var_dump($_POST["pokemonId"]);
$pokemonLocationData = $isSet ? getDataFromDB("SELECT location.name, pokemon.spriteM, pokemon.name AS pokemonName, generation FROM location_pokemon AS lp JOIN location ON location.id = lp.locationId JOIN pokemon ON pokemon.id = lp.pokemonId WHERE pokemonId = " . $_POST["pokemonId"], "", "", true) : null;
$regionData = getDataFromDB("region", "*", null);
$locationData = getDataFromDB("location", "*", "WHERE regionId = " . ($isSet ? $_POST["generationId"] : 1));
// $pokemonList = getDataFromDB("SELECT pokemon.name, pokemon.spriteM AS image, pokemon.id FROM location_pokemon AS lp JOIN location ON location.id = lp.locationId JOIN pokemon ON pokemon.id = lp.pokemonId WHERE locationId = 1 ", "", "", true);
$language = "fr";
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Pokedex</title>
    <link rel="stylesheet" type="text/css" href="css/map.css">
    <link rel="stylesheet" type="text/css" href="css/customRadioButton.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<?php
include_once('header.php');
?>

<body>
    <div id="mapFrame">
        <div id="smallMapFrame">
            <span id="mapContainer">
                <image id="imgMap" draggable="false" src="./img/Kanto.png"></image>
                <svg viewBox="0 0 350 350" width="350" heigh="350" id="svgMap" draggable="false"
                    xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg" clip-rule="evenodd"
                    version="1.1">
                    <?php //include_once("./svg/Hoenn.svg") ?>
                </svg>

            </span>
            <div id="centered">
                <image id="refocus" draggable="fase" src="./img/refocusIcon.png"></image>
                <label>Center map</label>
                </div>
            <?php if ($isSet) echo '
            <div id="pokemon">
                <image id="pokemonImage" draggable="fase" src="./img/refocusIcon.png"></image>
                <p>
            </div>
            '; 
            else {
                echo '
            <div id="pokeListContainer">
                <select id="pokeList"><select>
            </div>
            ';
            } ?>
        </div>
    </div>
    <div id="bubble">
        <div id="locationName">
            Je suis ton père
        </div>
    </div>
    <div id="info">
        <div id="phoneContainer1">

            <div id="currentgen">Current map generation : </div>
            <select id="mapList">
                <?php
                for ($i = 1; $i <= count($regionData); $i++) {
                    if ($i == ($isSet ? $_POST["generationId"] : 1)) {
                        echo "<option selected=selected value = " . getTextLang($regionData[$i - 1]["name"], "en") . " class = gens >$i - " . getTextLang($regionData[$i - 1]["name"]) . "</option>";
                        continue;
                    }
                    echo "<option value = " . getTextLang($regionData[$i - 1]["name"], "en") . " class = gens >$i - " . getTextLang($regionData[$i - 1]["name"]) . "</option>";
                }
                ?>
            </select>
            <div id="radioButtonsHolder">

                <label class="radioBut">
                    <input <?php if (!$isSet) { echo 'checked="checked"'; }?> name="mapType" type="radio" class="checkboxInput" id="gameMap">
                    <span class="radio"></span>
                </label>
                <label for="gameMap" id="gameMapLabel" class="radioLabel"> - In Game Map </label>
                <label class="radioBut">
                    <input name="mapType" type="radio" id="realMap" class="checkboxInput">
                    <span class="radio"></span>
                </label>
                <label for="realMap" id="realMapLabel" class="radioLabel"> - Realistic Map </label>
                <label class="radioBut">
                    <input <?php if ($isSet) { echo 'checked="checked"'; }?> name="mapType" type="radio" id="interactiveMap" class="checkboxInput">
                    <span class="radio"></span>
                </label>
                <label for="interactiveMap" id="interactiveMapLabel" class="radioLabel"> - Interactive Map </label>
            </div>
        </div>
        <div id="phoneContainer2">
            <div id="searchBarContainer">
                <input type="searchbar" id="searchBar" placeholder="Search..."></input>
            </div>
            <div id="mapLocation">
                <?php
                $datas = $isSet ? $pokemonLocationData : $locationData;
                for ($i = 0; $i < count($datas); $i++) {
                    echo '<div class=location data-location="' . GetTextLang($datas[$i]["name"], "en") . '">' . GetTextLang($datas[$i]["name"]) . '</div>';
                }
                if ($isSet)
                {
                    echo "<div id=pokemon> <img src=" . $pokemonLocationData["spriteM"] . " alt='" . $pokemonLocationData["pokemonName"] . "Image'> <label>" . $pokemonLocationData["pokemonName"] . "<div>";

                }
                ?>
            </div>
        </div>
    </div>

    <script src="scripts/svg.js"></script>
    <script src="scripts/map.js"></script>
</body>

</html>