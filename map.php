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
include_once('header.html');
?>

<body>
    <div id="mapFrame">
        <div id="smallMapFrame">
            <image id="map" draggable="false" src="./img/carteTestSansMer.png"></image>
            <div id="centered">
                <label>Center map
                    <image id="refocus" draggable="fase" src="./img/refocusIcon.png"></image>
                </label>
            </div>
        </div>
    </div>
    <div id="info">
        <div id="currentgen">Current map generation : </div>
        <select id="mapList">
            <?php
            for ($i = 1; $i <= 9; $i++) {
                echo "<option value = $i class = gens>Gen $i</ption>";
            }
            ?>
        </select>
        <div id="radioButtonsHolder">

            <label class="radioBut">
                <input name="mapType" type="radio" checked="checked" class="checkboxInput" id="gameMap">
                <span class="radio"></span>
            </label>
            <label for="gameMap" id="gameMapLabel" class="radioLabel"> In Game Map </label><br>
            <label class="radioBut">
                <input name="mapType" type="radio" id="realMap" class="checkboxInput">
                <span class="radio"></span>
            </label>
            <label for="realMap" id="realMapLabel" class="radioLabel"> Realistic Map </label><br>
        </div>

        <div id="mapLocation">
            <?php
            for ($i = 1; $i < 15; $i++) {
                echo "<div class=location> location $i </div>";
            }
            ?>
        </div>
    </div>
    <script src="scripts/map.js"></script>
</body>

</html>