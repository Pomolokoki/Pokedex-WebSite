<!-- Inclusion du header -->
<?php include_once("database/connectSQL.php"); ?>
<?php include_once("./database/extractDataFromDb.php") ?>
<?php include_once("header.php") ?>

<?php
$dataItems = getDataFromDB("SELECT item.id,item.name,item.smallDescription,item.sprite,item.category,item.pocket,item.effect FROM item", null, null, true);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- <script type="text/javascript" src="scripts/header.js"></script> -->
<style>
    <?php include("css/items.css"); ?>
</style>
<?php 
function getTextFrEng($str, $language = "fr")
{
    if ($language == "fr" && explode('///',$str)[1] != "NULL")
    {
        echo $str;
        return explode('///', $str)[1];
    }
    else
    {
        return explode('///', $str)[0];
    }
}

// function getTextLangTest($str, $mot)
// {

    
//     $nodesc = "Cet item ne possède pas de description";
    
//     if ($language == "fr") {
//         if ($split[1] == "NULL") {
//             $str =  $split[0];
//             if ($split[0] == "NULL") {
//                  return "Cet item n'a pas de description / effet";                
//             }
//         }
//         // if ($split[0] == "NULL" && $split[1] =="NULL"){
//         //     return "mais ";
//         // }
//         if ($str == "NULL/NULL") {
//             return "NULL/NULL";
//         }
//         // else{
//         //     return $split[1];
//         // }              
//     } else {
//         return $split[0];
//     }
//     return $str;
// }

function getTest($str,$mot){        
    if($str == "NULL"){
        return "Cet item n'a pas de " . $mot;
    }
    else{
        return $str;
    }
}

?>
<div id="itemTable">
    <div id="itemFilter">
        <label for="inputName">Nom de l'item:</label>
        <input type="text" class="input-text" id="inputName" onkeyup="recherche()">
        <label for="inputCategory">Catégorie:</label>
        <select name="inputCategories" id="inputCategory">
            <option value="All">- Tout -</option>
            <option value="battle">Combat</option>
            <option value="berries">Baies</option>
            <option value="key">Clés</option>
            <option value="machines">Machines</option>
            <option value="mail">Mail</option>
            <option value="medicine">Soins</option>
            <option value="misc">Autres</option>
            <option value="pokeballs">Pokeballs</option>
        </select>
        <div id="filterCategory"></div>
    </div>
    <div class="itemList">
        <table class="itemListTable">
            <thead>
                <tr>
                    <th id="itemName">
                        <div>Nom</div>
                    </th>
                    <th>
                        <div id="itemCategory">Category</div>
                    </th>
                    <th>
                        <div id="itemDescription">Description</div>
                    </th>
                    <th>
                        <div id="itemEffect">Effet</div>
                    </th>
            </thead>
            <tbody id="itemListBody">
                <?php for ($i = 0; $i < count($dataItems); $i++):
                    ?>
                    <tr data-id="<?php echo $dataItems[$i]["id"] ?>" data-name="<?php echo $dataItems[$i]["name"] ?>"
                        data-category="<?php $dataItems[$i]["category"] ?>">
                        <td id="itemNameData"><?php echo getTextLang($dataItems[$i]["name"], "fr") ?></td>
                        <td><?php echo $dataItems[$i]["pocket"] ?></td>
                        <td><?php echo getTest(getTextLang($dataItems[$i]["smallDescription"], "fr"), "description") ?></td>
                        <td><?php echo getTest(getTextLang($dataItems[$i]["effect"], "fr"), "effet") ?></td>
                    </tr>
                <?php endfor; ?>
            </tbody>
            </div>
            </div>

<script type="text/javascript" src="scripts/items.js"></script>