<?php

$type= ['Steel', 'Fighting', 'Dragon', 'Water', 'Electric', 'Fairy', 'Fire', 'Ice', 'Bug', 'Normal', 'Grass', 'Poison', 'Psychic', 'Rock', 'Ground', 'Ghost', 'Dark', 'Flying'];
$typeColors=[
    '605e5e',27,'969494',86, 	#Acier
    'ffb400',13,'7d5f05',100, 	#Combat
    '154ee4',13,'5606b1',87,	#Dragon
    '64aaff',21,'171ad2',86,    #Eau
    'ffdc00',27,'9f9800',87,	#Electrick
    'fa62d3',19,'da0b87',76,	#Fée
    'f40e0e',12,'860000',77,	#Feu
    '02edff',18,'078990',89,	#Glace
    'bbff02',13,'57be0f',93,	#Insecte
    'd0d0cf',12,'918f8f',91,	#Normale
    '00ff15',14,'0a7000',94,	#Plante
    'be33ed',24,'6c0279',99,	#Poison
    'e76dee',18,'c113aa',86,	#Psy
    'bda777',18,'6c551e',90,	#Roche
    'be8f2a',27,'573d02',92,	#Sol
    'a05da2',23,'4f1154',92,	#Spectre
    '776e77',20,'1a161b',92,	#Ténèbre
    '2c92fe',6,'006f9e',74		#Vol
];

header('Content-type: text/css; charset: UTF-8'); 
for ($i = 0; $i <count($type) ; $i++) {
    echo '.'.$type[$i].'{background: radial-gradient(#'.$typeColors[$i*4].' '.$typeColors[$i*4+1].'%, #'.$typeColors[$i*4+2].' '.$typeColors[$i*4+3].'%); }';
   }