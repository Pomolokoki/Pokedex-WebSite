<?php
include_once("database/extractDataFromDB.php");
$pokemonMoveData = getDataFromDB("SELECT move.name, smallDescription, accuracy, pp, pc, type.name AS type, priority, criticity, effectType FROM move JOIN type ON type.id = move.type ORDER BY name", null, null, true);
$isSet = isset($_POST["moveId"]);
// var_dump($_POST);
// var_dump($_POST["pokemonId"]);
$columnList = ["Nom", "Type", "Catégorie", "Puissance", "PP", "Précision", "Priorité", "Description", "Taux_Crit"];
$idForColumList = ["nameFilter", "typeFilter", "categoryFilter", "pcFilter", "ppFilter", "accuracyFilter", "priorityFilter", "descriptionFilter", "criticityFilter"];
$selectedMoveData = $isSet ? getDataFromDB("SELECT name, smallDescription, accuracy, pp, pc, type.name, priority, criticity FROM move JOIN type ON type.id = move.type WHERE move.id = " . $_POST["moveId"], "", "", true) : null;
$typeData = getDataFromDB("SELECT name FROM type", null, null, true);
// var_dump($typeData)
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
    <link rel="stylesheet" type="text/css" href="css/pokemonMove.css">
    <link rel="stylesheet" type="text/css" href="css/typeColor.php">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<?php
include_once('header.php');
?>


<body>
    <div id="moveContainer">

        <table id="moveList">
            <thead id="thead">
                <tr>
                    <th class="headCells" scope="col">Nom<br>
                        <input type="text" class="filter" id="nameFilter"></input>
                    </th>
                    <th class="headCells" scope="col">Type<br>
                        <select class="filter" id="typeFilter">
                            <option value =''>--Tout--</option>
                            <?php for ($i = 0; $i < count($typeData); ++$i) { ?>
                                <option data-type=<?= getTextLang($typeData[$i]['name'], 'en') ?>><?= getTextLang($typeData[$i]['name'], $language) ?></option>
                            <?php } ?>
                        </select>
                    </th>
                    <th class="headCells" scope="col">Catégorie<br>
                        <select class="filter" id="categoryFilter">
                            <option value =''>--Tout--</option>
                            <option data-type='special'>Spécial</option>
                            <option data-type='physical'>Physique</option>
                            <option data-type='statut'>Statut</option>
                        </select>
                    </th>
                    <th class="headCells" scope="col">Puissance<br>
                        <input type="text" class="filter" id="pcFilter"></input>
                    </th>
                    <th class="headCells" scope="col">PP<br>
                        <input type="text" class="filter" id="ppFilter"></input>
                    </th>
                    <th class="headCells" scope="col">Précision<br>
                        <input type="text" class="filter" id="accuracyFilter"></input>
                    </th>
                    <th class="headCells" scope="col">Priority<br>
                        <input type="text" class="filter" id="priorityFilter"></input>
                    </th>
                    <th class="headCells" scope="col">Description<br>
                        <input type="text" class="filter" id="descriptionFilter"></input>
                    </th>
                    <th class="headCells" scope="col">TauxCritique<br>
                        <input type="text" class="filter" id="criticityFilter"></input>
                    </th>
                </tr>
            </thead>
            <thead>
                <tr>
                    <th class="headCells" scope="col">Nom<br>
                        <input type="text" class="filter"></input>
                    </th>
                    <th class="headCells" scope="col">Type<br>
                        <select class="filter">
                            <option>--Tout--</option>
                            <?php for ($i = 0; $i < count($typeData); ++$i) { ?>
                                <option data-type=<?= getTextLang($typeData[$i]['name'], 'en') ?>><?= getTextLang($typeData[$i]['name'], $language) ?></option>
                            <?php } ?>
                        </select>
                    </th>
                    <th class="headCells" scope="col">Catégorie<br>
                        <select class="filter">
                            <option>--Tout--</option>
                            <option data-type='special'>Spécial</option>
                            <option data-type='physical'>Physique</option>
                            <option data-type='statut'>Statut</option>
                        </select>
                    </th>
                    <th class="headCells" scope="col">Puissance<br>
                        <input type="text" class="filter"></input>
                    </th>
                    <th class="headCells" scope="col">PP<br>
                        <input type="text" class="filter"></input>
                    </th>
                    <th class="headCells" scope="col">Précision<br>
                        <input type="text" class="filter"></input>
                    </th>
                    <th class="headCells" scope="col">Priority<br>
                        <input type="text" class="filter"></input>
                    </th>
                    <th class="headCells" scope="col">Description<br>
                        <input type="text" class="filter"></input>
                    </th>
                    <th class="headCells" scope="col">TauxCritique<br>
                        <input type="text" class="filter"></input>
                    </th>
                </tr>
            </thead>
            <tbody id="tbody">
                <?php
                for ($i = 0; $i < count($pokemonMoveData); ++$i) {
                    ?>
                    <tr>
                        <td class='AtkCell AtkName'><?= getTextLang($pokemonMoveData[$i]['name'], $language) ?>
                            <div class="separator"></div>
                        </td>
                        <td class='AtkCell AtkType'>
                            <p class='AtkTypeLabel <?= getTextLang($pokemonMoveData[$i]['type'], 'en') ?>'>
                                <?= getTextLang($pokemonMoveData[$i]['type'], $language) ?>
                            </p>
                        </td>
                        <td class='AtkCell AtkEffectType'><?php $category = $pokemonMoveData[$i]['effectType'];
                        if ($category == 1)
                            echo getTextLang("Physical/Physique", $language);
                        else if ($category == 2)
                            echo getTextLang("Special/Spéciale", $language);
                        else if ($category == 3)
                            echo getTextLang("Statut/Statut", $language);
                        else
                            echo getTextLang("Other/Autre", $language); ?> </td>
                        <td class='AtkCell AtkPc'>
                            <?= $pokemonMoveData[$i]['pc'] == '' ? '- -' : $pokemonMoveData[$i]['pc'] ?>
                        </td>
                        <td class='AtkCell AtkPp'>
                            <?= $pokemonMoveData[$i]['pp'] == '' ? '- -' : $pokemonMoveData[$i]['pp'] ?>
                        </td>
                        <td class='AtkCell AtkAccuracy'>
                            <?= $pokemonMoveData[$i]['accuracy'] == '' ? '- -' : $pokemonMoveData[$i]['accuracy'] ?>
                        </td>
                        <td class='AtkCell AtkPriority'>
                            <?= $pokemonMoveData[$i]['priority'] == '' ? '- -' : $pokemonMoveData[$i]['priority'] ?>
                        </td>
                        <td class='AtkCell AtkDescription'><?php $value = getTextLang($pokemonMoveData[$i]['smallDescription'], $language);
                        if ($value == "NULL") {
                            echo "Pas de description pour l'instant";
                        } else {
                            echo $value;
                        } ?> </td>
                        <td class='AtkCell AtkCriticity'>
                            <?= $pokemonMoveData[$i]['criticity'] == '' ? '- -' : $pokemonMoveData[$i]['criticity'] ?>
                        </td>

                    </tr>

                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="scripts/pokemonMove.js"></script>
</body>

</html>