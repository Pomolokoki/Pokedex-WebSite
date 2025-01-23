<?php
include_once("./database/extractDataFromDB.php");
$pokemonData = getDataFromDB("SELECT spriteM, name, id FROM pokemon WHERE id < 10000", null, null, true);
$regionData = getDataFromDB("region", "*", null);
$locationData = getDataFromDB("location", "*", "WHERE regionId =  1");
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
                </svg>
            </span>

            <div id="centered">
                <image id="refocus" draggable="fase" src="./img/refocusIcon.png"></image>
                <label>Center map</label>
            </div>

            <div id="pokedexContainer">
                <textarea id="pokemonSearch" rows="1" placeholder="search for..."></textarea>
                <div id="pokedex">
                    <?php for ($i = 0; $i < count($pokemonData); ++$i) { ?>
                        <div class="pokemonn">
                            <image class="pokemonImage" draggable="fase" src="<?= $pokemonData[$i]['spriteM'] ?>"
                                data-id="<?= $pokemonData[$i]['id'] ?>"></image>
                            <p><?= getTextLang($pokemonData[$i]['name'], $language) ?></p>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>

    <div id="bubble">
        <div id="locationName">
            Je suis une localisation
        </div>
    </div>

    <div id="info">
        <div id="phoneContainer1">
            <div id="currentgen"> Génération actuelle : </div>
            <select id="mapList">
                <?php
                for ($i = 1; $i <= count($regionData); $i++) {
                    if ($i == 1) {
                        echo "<option selected=selected value = " . getTextLang($regionData[$i - 1]["name"], "en") . " class = gens >$i - " . getTextLang($regionData[$i - 1]["name"], $language) . "</option>";
                        continue;
                    }
                    echo "<option value = " . getTextLang($regionData[$i - 1]["name"], "en") . " class = gens >$i - " . getTextLang($regionData[$i - 1]["name"], $language) . "</option>";
                }
                ?>
            </select>

            <div id="radioButtonsHolder">
                <label class="radioBut">
                    <input checked="checked" name="mapType" type="radio" class="checkboxInput" id="gameMap">
                    <span class="radio"></span>
                </label>
                <label for="gameMap" id="gameMapLabel" class="radioLabel"> - Carte de jeu </label>
                <label class="radioBut">
                    <input name="mapType" type="radio" id="realMap" class="checkboxInput">
                    <span class="radio"></span>
                </label>
                <label for="realMap" id="realMapLabel" class="radioLabel"> - Carte réaliste </label>
                <label class="radioBut">
                    <input name="mapType" type="radio" id="interactiveMap" class="checkboxInput">
                    <span class="radio"></span>
                </label>
                <label for="interactiveMap" id="interactiveMapLabel" class="radioLabel"> - Carte interactive </label>
            </div>

        </div>

        <div id="phoneContainer2">
            <div id="searchBarContainer">
                <input type="searchbar" id="searchBar" placeholder="Search..."></input>
            </div>
            <div id="mapLocation">
                <?php
                for ($i = 0; $i < count($locationData); $i++) {
                    echo '<div class=location data-location="' . GetTextLang($locationData[$i]["name"], "en") . '">' . GetTextLang($locationData[$i]["name"], $language) . '</div>';
                }
                ?>
            </div>
        </div>

    </div>

    <script src="scripts/svg.js"></script>
    <script src="scripts/map.js"></script>
</body>

</html>