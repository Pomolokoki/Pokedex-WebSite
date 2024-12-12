<?php
include_once("database/extractDataFromDB.php");
$pokemonMoveData = getDataFromDB("SELECT name, smallDescription, accuracy, pp, pc, type.name, priority, criticity FROM move JOIN type ON type.id = move.type ORDER BY name", null, null, true);
$isSet = isset($_POST["moveId"]);
// var_dump($_POST);
// var_dump($_POST["pokemonId"]);
$columnList = ["Name", "Type", "Catégorie", "Power", "PP", "Accuracy", "Priorité", "Description", "Taux Crit"];
$selectedMoveData = $isSet ? getDataFromDB("SELECT name, smallDescription, accuracy, pp, pc, type.name, priority, criticity FROM move JOIN type ON type.id = move.type WHERE move.id = " . $_POST["moveId"], "", "", true) : null;

// name VARCHAR(70),
// description TEXT,
// smallDescription TEXT,
// accuracy TINYINT UNSIGNED,
// type SMALLINT UNSIGNED,
// pc TINYINT UNSIGNED,
// pp TINYINT UNSIGNED,
// statut VARCHAR(25),
// effect VARCHAR(25),
// effectValue FLOAT,
// effectDuration TINYINT,
// effectType TINYINT UNSIGNED,
// affect INT UNSIGNED,
// comboMin TINYINT UNSIGNED,
// comboMax TINYINT UNSIGNED,
// priority BOOLEAN,
// criticity FLOAT,


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
    <table id="moveList">
        <thead>
            <tr>
                <?php
                for ($i = 0; $i < count($columnList); ++$i) {
                    echo '<th scope="col">' . $columnList[$i] . '</th>';
                }
                ?>
            </tr>
        </thead>
        <?php
        for ($i = 0; $i < count($pokemonMoveData); ++$i) {
            ?>
            <tr>
                <td><?= $pokemonMoveData[$i]['name'] ?> </td>
                <td><?= $pokemonMoveData[$i]['type'] ?> </td>
                <td><?= $pokemonMoveData[$i]['name'] ?> </td>
                <td><?= $pokemonMoveData[$i]['name'] ?> </td>
            </tr>

            <?php
        }
        ?>
    </table>
    <div id="moveFrame">
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

        </div>
    </div>
    <div id="info">
        <div id="phoneContainer1">

            <div id="currentgen">Current map generation : </div>
            <select id="mapList">
                <?php
                for ($i = 1; $i <= count($regionData); $i++) {
                    if ($i == ($isSet ? $_POST["generationId"] : 1)) {
                        echo "<option selected=selected value = " . getTextLang($regionData[$i - 1]["name"], "en") . " class = gens >$i - " . getTextLang($regionData[$i - 1]["name"]) . "</ption>";
                        continue;
                    }
                    echo "<option value = " . getTextLang($regionData[$i - 1]["name"], "en") . " class = gens >$i - " . getTextLang($regionData[$i - 1]["name"]) . "</ption>";
                }
                ?>
            </select>
            <div id="radioButtonsHolder">

                <label class="radioBut">
                    <input <?php if (!$isSet) {
                        echo 'checked="checked"';
                    } ?> name="mapType" type="radio"
                        class="checkboxInput" id="gameMap">
                    <span class="radio"></span>
                </label>
                <label for="gameMap" id="gameMapLabel" class="radioLabel"> - In Game Map </label>
                <label class="radioBut">
                    <input name="mapType" type="radio" id="realMap" class="checkboxInput">
                    <span class="radio"></span>
                </label>
                <label for="realMap" id="realMapLabel" class="radioLabel"> - Realistic Map </label>
                <label class="radioBut">
                    <input <?php if ($isSet) {
                        echo 'checked="checked"';
                    } ?> name="mapType" type="radio"
                        id="interactiveMap" class="checkboxInput">
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
                if ($isSet) {
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