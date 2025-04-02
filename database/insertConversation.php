<?php
include_once 'extractApi.php';

$sqlInsertPlayer = 
'INSERT INTO player (id, nickname, email, password, forumRank) VALUES
(1, \'Patrick\', \'p.pat@gmail.com\', \'abc\', 1),
(2, \'Jean\', \'j.jean@gmail.com\', \'abcd\', 1),
(3, \'Mokal\', \'m.mok@gmail.com\', \'abcdf\', 1),
(4, \'pseudo\', \'pseudo@exemple.com\', \'$2y$10$l4C9YnsMIAh9pEngvcRfc.k.qhLBTYBpAlqWH3ZtFUzExeNJdgs4i\', 1),
(5, \'admin\', \'nn@n.gmail.com\', \'$2y$10$mXIG4dYF3TrEd2LLtjSaD.UFxHLiehODKhFj0CBlW.X9TEIGoOeSG\', 8),
(6, \'az\', \'a@gmail.com\', \'$2y$10$01ByUnJoLA7W3RHABEw/SerrVU7QbvrbFRQqLi/D87Y028/B1/bge\', 1)';

$sqlInsertChannel = 
'INSERT INTO channel (id, title, keyWords, creationDate) VALUES
(1, \'Hoenn est interactive\', \'hoenn map interactive\', \'2009-08-12\'),
(2, \'Le jeu XY est sorti\', \'XY sorti jeu\', \'2007-01-04\')';

$sqlInsertMessage = 
'INSERT INTO message (id, text, reply, postDate, owner, channelId) VALUES
(NULL, \'Je viens de voir qu\\\'il ont mis cette carte interactive, c\\\'est ouf\', NULL, \'2009-08-12 12:00:00\', 2, 1),
(NULL, \'Oui j\\\'ai vu ca, mais j\\\'aime pas vraiment le style de la map, pas très représentatif des vraies couleurs\', NULL, \'2009-08-13 02:54:41\', 1, 1),
(NULL, \'Je ne suis pas d\\\'accord, ce n\\\'est peut etre pas une réalisation correcte, mais c\\\'est tout de meme très impressionant, et j\\\'aime bien cette texture, ca donne une dimension nouvelle à la carte, bravo aux devs\', NULL, \'2009-08-13 08:15:20\', 2, 1),
(NULL, \'Premier\', NULL, \'2015-04-23 13:06:33\',3 , 2)';


saveToDb($sqlInsertPlayer, '', '', false, true);
saveToDb($sqlInsertChannel, '', '', false, true);
saveToDb($sqlInsertMessage, '', '', false, true);
