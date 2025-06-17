<?php
include_once __DIR__ . '/../database/get/FromPHP/getDBDataGlobal.php';
$pokemonMoveData = getPokemonMoves();
// not used but if pokedex -> link -> move
$isSet = isset($_POST['moveId']);
$columnList = ['Nom', 'Type', 'Catégorie', 'Puissance', 'PP', 'Précision', 'Priorité', 'Description', 'Taux_Crit'];
$idForColumList = ['nameFilter', 'typeFilter', 'categoryFilter', 'pcFilter', 'ppFilter', 'accuracyFilter', 'priorityFilter', 'descriptionFilter', 'criticityFilter'];
$selectedMoveData = $isSet ? getPokemonMove([$_POST['moveId']]) : null;
$typeData = GetTypesForPokemonMoves();

?>

<!DOCTYPE html>
<html lang='fr'>

<head>
    <meta charset='utf-8'>
    <title>Pokedex</title>
    <link rel='stylesheet' type='text/css' href='../style/css/pokemonMove.css'>
    <link rel='stylesheet' type='text/css' href='../style/php/typeColor.php'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>

<?php
include 'header.php';
?>

<body>
    <div id='moveContainer'>

        <table id='moveList'>
            <?php // there is two header bcs I need one to be 'static' ?>
            <thead id='thead'>
                <tr>
                    <th class='headCells' scope='col'>
                        <p class='headText' data-id='0'>Nom
                            <img class='sorter' loading='lazy' decoding='async' src='../../public/img/selector.png' alt='trier'>
                        </p>
                        <input type='text' class='filter' id='nameFilter'></input>
                    </th>
                    <th class='headCells' scope='col'>
                        <p class='headText' data-id='1'>Type
                            <img class='sorter' loading='lazy' decoding='async' src='../../public/img/selector.png' alt='trier'>
                        </p>
                        <select class='filter' id='typeFilter'>
                            <option value=''>--Tout--</option>
                            <?php for ($i = 0; $i < count($typeData); ++$i) { ?>
                                <option data-type=<?= getTextLang($typeData[$i]['name'], 'en') ?>><?= getTextLang($typeData[$i]['name'], $language) ?></option>
                            <?php } ?>
                        </select>
                    </th>
                    <th class='headCells' scope='col'>
                        <p class='headText' data-id='2'>Catégorie
                            <img class='sorter' loading='lazy' decoding='async' src='../../public/img/selector.png' alt='trier'>
                        </p>
                        <select class='filter' id='categoryFilter'>
                            <option value=''>--Tout--</option>
                            <option data-type='special'>Spécial</option>
                            <option data-type='physical'>Physique</option>
                            <option data-type='statut'>Statut</option>
                        </select>
                    </th>
                    <th class='headCells' scope='col'>
                        <p class='headText' data-id='3'>Puissance
                            <img class='sorter' loading='lazy' decoding='async' src='../../public/img/selector.png' alt='trier'>
                        </p>
                        <input type='text' class='filter' id='pcFilter' size='4'></input>
                    </th>
                    <th class='headCells' scope='col'>
                        <p class='headText' data-id='4'>PP
                            <img class='sorter' loading='lazy' decoding='async' src='../../public/img/selector.png' alt='trier'>
                        </p>
                        <input type='text' class='filter' id='ppFilter' size='4'></input>
                    </th>
                    <th class='headCells' scope='col'>
                        <p class='headText' data-id='5'>Précision
                            <img class='sorter' loading='lazy' decoding='async' src='../../public/img/selector.png' alt='trier'>
                        </p>
                        <input type='text' class='filter' id='accuracyFilter' size='4'></input>
                    </th>
                    <th class='headCells' scope='col'>
                        <p class='headText' data-id='6'>Priority
                            <img class='sorter' loading='lazy' decoding='async' src='../../public/img/selector.png' alt='trier'>
                        </p>
                        <input type='text' class='filter' id='priorityFilter' size='4'></input>
                    </th>
                    <th class='headCells' scope='col'>
                        <p class='headText' data-id='7'>Description
                            <img class='sorter' loading='lazy' decoding='async' src='../../public/img/selector.png' alt='trier'>
                        </p>
                        <input type='text' class='filter' id='descriptionFilter'></input>
                    </th>
                    <th class='headCells' scope='col'>
                        <p class='headText' data-id='8'>TauxCritique
                            <img class='sorter' loading='lazy' decoding='async' src='../../public/img/selector.png' alt='trier'>
                        </p>
                        <input type='text' class='filter' id='criticityFilter' size='4'></input>
                    </th>
                </tr>
            </thead>
            <!-- <thead>
                <tr>
                    <th class='headCells'>Nom<br>
                        <input type='text' class='filter'></input>
                    </th>
                    <th class='headCells'>Type<br>
                        <select class='filter'>
                            <option>--Tout--</option>
                            <?php for ($i = 0; $i < count($typeData); ++$i) { ?>
                                <option><?= getTextLang($typeData[$i]['name'], $language) ?></option>
                            <?php } ?>
                        </select>
                    </th>
                    <th class='headCells'>Catégorie<br>
                        <select class='filter'>
                            <option>--Tout--</option>
                            <option>Spécial</option>
                            <option>Physique</option>
                            <option>Statut</option>
                        </select>
                    </th>
                    <th class='headCells'>Puissance<br>
                        <input type='text' class='filter' size='4'></input>
                    </th>
                    <th class='headCells'>PP<br>
                        <input type='text' class='filter' size='4'></input>
                    </th>
                    <th class='headCells'>Précision<br>
                        <input type='text' class='filter' size='4'></input>
                    </th>
                    <th class='headCells'>Priority<br>
                        <input type='text' class='filter' size='4'></input>
                    </th>
                    <th class='headCells'>Description<br>
                        <input type='text' class='filter'></input>
                    </th>
                    <th class='headCells'>TauxCritique<br>
                        <input type='text' class='filter' size='4'></input>
                    </th>
                </tr>
            </thead> -->
            <tbody id='tbody'>
                <?php
                for ($i = 0; $i < count($pokemonMoveData); ++$i) {
                    ?>
                    <tr>
                        <td class='AtkCell AtkName'><?= getTextLang($pokemonMoveData[$i]['name'], $language) ?>
                        </td>
                        <td class='AtkCell AtkType'>
                            <p class='AtkTypeLabel <?= getTextLang($pokemonMoveData[$i]['type'], 'en') ?>'>
                                <?= getTextLang($pokemonMoveData[$i]['type'], $language) ?>
                            </p>
                        </td>
                        <td class='AtkCell AtkEffectType'><?php $category = $pokemonMoveData[$i]['effectType'];
                        if ($category == 1)
                            echo getTextLang('Physical///Physique', $language);
                        else if ($category == 2)
                            echo getTextLang('Special///Spéciale', $language);
                        else if ($category == 3)
                            echo getTextLang('Statut///Statut', $language);
                        else
                            echo getTextLang('Other///Autre', $language); ?> </td>
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
                        if ($value == 'NULL') {
                            echo 'Pas de description pour l\'instant';
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
    <script src='../scripts/JS/pokemonMove.js'></script>
</body>

</html>