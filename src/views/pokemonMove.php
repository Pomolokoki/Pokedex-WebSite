<?php
include_once __DIR__ . '/../database/get/FromPHP/getDBDataGlobal.php';
$pokemonMoveData = getPokemonMoves();
$isSet = isset($_POST['moveId']);
$typeData = GetTypesForPokemonMoves();
$selectedMoveData = $isSet ? getPokemonMove([$_POST['moveId']]) : null;

function generateSelectOptions($data, $key) {
    $values = array_unique(array_filter(array_column($data, $key)));
    sort($values);
    $options = "<option value=''>Tous</option>";
    foreach ($values as $val) {
        $options .= "<option value='" . htmlspecialchars($val) . "'>$val</option>";
    }
    return $options;
}

?>

<!DOCTYPE html>
<html lang='fr'>

<head>
    <meta charset='utf-8'>
    <title>Pokedex</title>
    <link rel='stylesheet' type='text/css' href='../style/css/pokemonMove.css'>
    <link rel='stylesheet' type='text/css' href='../style/php/typeColor2.php'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>

<?php include 'header.php'; ?>

<body>
    <div id='moveContainer'>
        <table id='moveList'>
            <thead id='thead'>
                <tr>
                    <th class='headCells'>
                        <p class='headText' data-id='0'>
                            Nom <img class='sorter' src='../../public/img/selector.png'>
                        </p>
                        <input type='text' class='filter' id='nameFilter' placeholder="Rechercher">
                    </th>

                    <th class='headCells'>
                        <p class='headText' data-id='1'>
                            Type <img class='sorter' src='../../public/img/selector.png'>
                        </p>
                        <select class='filter' id='typeFilter'>
                            <option value=''>Tous</option>
                            <?php foreach ($typeData as $type): ?>
                                <option value='<?= strtolower(getTextLang($type['name'], 'fr')) ?>'><?= getTextLang($type['name'], 'fr') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </th>

                    <th class='headCells'>
                        <p class='headText' data-id='2'>
                            Catégorie <img class='sorter' src='../../public/img/selector.png'>
                        </p>
                        <select class='filter' id='categoryFilter'>
                            <option value=''>Tous</option>
                            <option value='physique'>Physique</option>
                            <option value='spéciale'>Spéciale</option>
                            <option value='statut'>Statut</option>
                        </select>
                    </th>

                    <th class='headCells'>
                        <p class='headText' data-id='3'>
                            Puissance <img class='sorter' src='../../public/img/selector.png'>
                        </p>
                        <select class='filter' id='pcFilter'><?= generateSelectOptions($pokemonMoveData, 'pc') ?></select>
                    </th>

                    <th class='headCells'>
                        <p class='headText' data-id='4'>
                            PP <img class='sorter' src='../../public/img/selector.png'>
                        </p>
                        <select class='filter' id='ppFilter'><?= generateSelectOptions($pokemonMoveData, 'pp') ?></select>
                    </th>

                    <th class='headCells'>
                        <p class='headText' data-id='5'>
                            Précision <img class='sorter' src='../../public/img/selector.png'>
                        </p>
                        <select class='filter' id='accuracyFilter'><?= generateSelectOptions($pokemonMoveData, 'accuracy') ?></select>
                    </th>

                    <th class='headCells'>
                        <p class='headText' data-id='6'>
                            Priorité <img class='sorter' src='../../public/img/selector.png'>
                        </p>
                        <select class='filter' id='priorityFilter'><?= generateSelectOptions($pokemonMoveData, 'priority') ?></select>
                    </th>

                    <th class='headCells'>
                        <p class='headText' data-id='7'>
                            Description <img class='sorter' src='../../public/img/selector.png'>
                        </p>
                        
                    </th>

                    <th class='headCells'>
                        <p class='headText' data-id='8'>
                            TauxCritique <img class='sorter' src='../../public/img/selector.png'>
                        </p>
                        <select class='filter' id='criticityFilter'><?= generateSelectOptions($pokemonMoveData, 'criticity') ?></select>
                    </th>
                </tr>
            </thead>

            <tbody id='tbody'>
                <?php foreach ($pokemonMoveData as $move): ?>
                    <tr>
                        <td class='AtkCell AtkName'><?= getTextLang($move['name'], 'fr') ?></td>
                        <td class='AtkCell AtkType'>
                            <p class='AtkTypeLabel pokemon <?= strtolower(getTextLang($move['type'], 'en')) ?>'>
                                <?= getTextLang($move['type'], 'fr') ?>
                            </p>
                        </td>
                        <td class='AtkCell AtkEffectType'>
                            <?php
                            $cat = ['1' => 'Physique', '2' => 'Spéciale', '3' => 'Statut'];
                            echo $cat[$move['effectType']] ?? 'Autre';
                            ?>
                        </td>
                        <td class='AtkCell AtkPc'><?= $move['pc'] ?: '- -' ?></td>
                        <td class='AtkCell AtkPp'><?= $move['pp'] ?: '- -' ?></td>
                        <td class='AtkCell AtkAccuracy'><?= $move['accuracy'] ?: '- -' ?></td>
                        <td class='AtkCell AtkPriority'><?= $move['priority'] ?: '- -' ?></td>
                        <td class='AtkCell AtkDescription'><?= getTextLang($move['smallDescription'], 'fr') ?: 'Pas de description' ?></td>
                        <td class='AtkCell AtkCriticity'><?= $move['criticity'] ?: '- -' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src='../scripts/JS/pokemonMove.js'></script>
</body>

</html>
