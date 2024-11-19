<!-- Inclusion du header -->
<?php include_once("database/connectSQL.php"); ?>
<?php include_once("./database/extractDataFromDb.php") ?>
<?php include_once("header.php") ?>

<?php 
$dataItems = getDataFromDB("SELECT item.id,item.name,item.smallDescription,item.sprite,item.category,item.pocket,item.effect FROM item",null,null,true);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script type="text/javascript" src="scripts/items.js"></script>
<!-- <script type="text/javascript" src="scripts/header.js"></script> -->
<style>
    <?php include("css/items.css"); ?>
</style>

<div id="itemTable">
    <div id="itemFilter">
        <label for="inputName">itemName:</label>
        <input type="text" class="input-text" id="inputName">
        <label for="inputCategory">Category:</label>
        <select name="inputCategory" id="inputCategory">
            <option value>- Tout -</option>
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
                    <th id="itemName"><div>Nom</div></th>
                    <th><div id="itemCategory">Category</div></th>
                    <th><div id="itemDescription">Description</div></th>
                    <th><div id="itemEffect">Effet</div></th>
            </thead>
            <tbody class="itemListBody">
                <tr>
                    
                    <?php 
                    
                    foreach($dataItems as $result) {
                        echo $result, '<br>';
                    }
                    
                    ?>
                    <td>aaaaa</td>
                    <td>bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb</td>
                    <td>ccccc</td>
                    <td>ddddd</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>