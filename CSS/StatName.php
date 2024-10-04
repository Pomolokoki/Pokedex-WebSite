<?php
$type = array("Acier", "Combat", "Dragon", "Eau", "Electrik", "Fee", "Feu", "Glace", "Insecte", "Normal", "Plante", "Poison", "Psy", "Roche", "Sol", "Spectre", "Tenebre", "Vol");

$Stat_name=array("Stat","PV","Attaque","Défense","Attaque Spéciale","Défense Spéciale","Vitesse");
for ($i = 0; $i <count($Stat_name) ; $i++) {
    echo'<div class="Name_stat_case"><h3>'.$Stat_name[$i]."</h3></div>";
}
?>

