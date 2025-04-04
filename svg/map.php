<?php
include_once './database/extractDataFromDB.php';
$regionData = getDataFromDB('region', '*', null);
$locationData = getDataFromDB('location', '*', 'WHERE regionId = 3');
$language = 'fr'
?>
<!DOCTYPE html>
<html lang='fr'>

<head>
    <meta charset='utf-8'>
    <title>Pokedex</title>
    <link rel='stylesheet' type='text/css' href='css/map.css'>
    <link rel='stylesheet' type='text/css' href='css/customRadioButton.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>
<?php
include_once 'header.html';
?>

<body>
    <div id='mapFrame'>
        <div id='smallMapFrame'>
            <span id='mapContainer'>
                <image id='imgMap' draggable='false' src='./img/Hoenn.png'></image>
                <svg viewBox='0 0 350 350' width='350' heigh='350' id='svgMap' draggable='false'
                    xmlns='http://www.w3.org/2000/svg' xmlns:svg='http://www.w3.org/2000/svg' clip-rule='evenodd'
                    version='1.1'>
                    <?php //include_once './svg/Hoenn.svg' ?>
                </svg>

            </span>
            <div id='centered'>
                <image id='refocus' draggable='fase' src='./img/refocusIcon.png'></image>
                <label>Center map</label>
            </div>

        </div>
    </div>
    <div id='bubble'>
        <div id='locationName'>
            Je suis ton père
        </div>
    </div>
    <div id='info'>
        <div id='phoneContainer1'>

            <div id='currentgen'>Current map generation : </div>
            <select id='mapList'>
                <?php
                for ($i = 1; $i <= count($regionData); $i++) {
                    if ($i == 3) {
                        echo '<option selected=selected value = ' . getTextLang($regionData[$i - 1]['name'], 'en') . ' class = gens >$i - ' . getTextLang($regionData[$i - 1]['name']) . '</ption>';
                        continue;
                    }
                    echo '<option value = ' . getTextLang($regionData[$i - 1]['name'], 'en') . ' class = gens >$i - ' . getTextLang($regionData[$i - 1]['name']) . '</ption>';
                }
                ?>
            </select>
            <div id='radioButtonsHolder'>

                <label class='radioBut'>
                    <input checked='checked' name='mapType' type='radio' class='checkboxInput' id='gameMap'>
                    <span class='radio'></span>
                </label>
                <label for='gameMap' id='gameMapLabel' class='radioLabel'> - In Game Map </label>
                <label class='radioBut'>
                    <input name='mapType' type='radio' id='realMap' class='checkboxInput'>
                    <span class='radio'></span>
                </label>
                <label for='realMap' id='realMapLabel' class='radioLabel'> - Realistic Map </label>
                <label class='radioBut'>
                    <input name='mapType' type='radio' id='interactiveMap' class='checkboxInput'>
                    <span class='radio'></span>
                </label>
                <label for='interactiveMap' id='interactiveMapLabel' class='radioLabel'> - Interactive Map </label>
            </div>
        </div>
        <div id='phoneContainer2'>
            <div id='searchBarContainer'>
                <input type='searchbar' id='searchBar' placeholder='Search...'></input>
            </div>
            <div id='mapLocation'>
                <?php
                for ($i = 0; $i < count($locationData); $i++) {
                    echo '<div class=location data-location=\'' . GetTextLang($locationData[$i]['name'], 'en') . '\'>' . GetTextLang($locationData[$i]['name']) . '</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <script src='scripts/svg.js'></script>
    <script src='scripts/map.js'></script>
</body>

</html>