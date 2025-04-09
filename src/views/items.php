<!-- Inclusion du header -->
<?php
include_once '../database/connection/connectSQL.php';
include_once '../database/get/extractDataFromDb.php';
include_once 'header.php';



$dataItems = getDataFromDB('SELECT item.id,item.name,item.smallDescription,item.sprite,item.category,item.pocket,item.effect FROM item', null, null, true);
?>

<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet'>
<style>
    <?php include '../style/CSS/items.css' ; ?>
</style>
<?php 
function getItemNoDescOrEffect($str,$mot){        
    if($str == 'NULL'){
        return 'Cet item n\'a pas de ' . $mot;
    }
    else{
        return $str;
    }
}

?>
<div id='itemTable'>
    <div id='itemFilter'>
        <label for='inputName'>Nom de l'item:</label>
        <input type='text' class='input-text' id='inputName'>
        <label for='inputCategory'>Catégorie:</label>
        <select name='inputCategories' id='inputCategory'>
            <option value='All'>- Tout -</option>
            <option value='battle'>Combat</option>
            <option value='berries'>Baies</option>
            <option value='key'>Clés</option>
            <option value='machines'>Machines</option>
            <option value='mail'>Mail</option>
            <option value='medicine'>Soins</option>
            <option value='misc'>Autres</option>
            <option value='pokeballs'>Pokeballs</option>
        </select>
        <div id='filterCategory'></div>
    </div>
    <div class='table-responsive itemList'>
        <table class='table itemListTable'>
            <thead>
                <tr>
                    <th id='itemName' scope='col'>
                        <div>Nom</div>
                    </th>
                    <th>
                        <div id='itemCategory' scope='col'>Categorie</div>
                    </th>
                    <th>
                        <div id='itemDescription' scope='col'>Description</div>
                    </th>
                    <th>
                        <div id='itemEffect' scope='col'>Effet</div>
                    </th>
            </thead>
            <tbody id='itemListBody'>
                <?php for ($i = 0; $i < count($dataItems); $i++):
                    ?>
                    <tr data-id='<?php echo $dataItems[$i]['id'] ?>' data-name='<?php echo $dataItems[$i]['name'] ?>'
                        data-category='<?php $dataItems[$i]['category'] ?>' scope='row'>
                        <td id='itemNameData'><?php echo getTextLang($dataItems[$i]['name'], 'fr') ?></td>
                        <td><?php echo $dataItems[$i]['pocket'] ?></td>
                        <td><?php echo getItemNoDescOrEffect(getTextLang($dataItems[$i]['effect'], 'fr'), 'effet') ?></td>
                        <td><?php echo getItemNoDescOrEffect(getTextLang($dataItems[$i]['smallDescription'], 'fr'), 'description') ?></td>
                    </tr>
                <?php endfor; ?>
            </tbody>
            </div>
            </div>

<script type='text/javascript' src='../scripts/JS/items.js'></script>