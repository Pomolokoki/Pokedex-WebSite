<?php
$type = ['Steel', 'Fighting', 'Dragon', 'Water', 'Electric', 'Fairy', 'Fire', 'Ice', 'Bug', 'Normal', 'Grass', 'Poison', 'Psychic', 'Rock', 'Ground', 'Ghost', 'Dark', 'Flying'];

$Stat_name = ['Stat', 'PV', 'Attaque', 'Défense', 'Attaque Spéciale', 'Défense Spéciale', 'Vitesse'];
for ($i = 0; $i < count($Stat_name); $i++) {
    echo '<div class=Name_stat_case tabindex="1"><h3>' . $Stat_name[$i] . '</h3></div>';
}
