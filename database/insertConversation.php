<?php
include_once("extractApi.php");

$sqlInsertPlayer = 
"INSERT INTO player (nickname) VALUES
('Patrick');\n";

$sqlInsertChannel = 
"INSERT INTO channel (title, keyWords, creationDate) VALUES
('Hoenn is intercative', 'hoenn map interactive', '2009-08-12'),
('XY game is out', 'XY release game', '2007-01-04');\n";

$sqlInsertMessage = 
"INSERT INTO message (id, text, reply, postDate, owner, channelId) VALUES
('Hoenn is intercative/2009-08-12 12:00:00/1', 'I just saw that they added an intercactive now, woahh that \'s crazyyyyyy', NULL, '2009-08-12 12:00:00', NULL, 1),
('Hoenn is intercative/2009-08-13 02:54:41/1', 'yes i checked that, but I don\'t really like the map style, \\nnot very representative of real colors in game', NULL, '2009-08-13 02:54:41', 1, 1),
('Hoenn is intercative/2009-08-13 08:15:20/1', 'I don\'t agree, the style is may not an exact representation of the game, but it has it\'s own mood and style, and think of the effort the dev have putted in to make that map interactive', 'Hoenn is intercative/2009-08-13 02:54:41/1', '2009-08-13 08:15:20', NULL, 1),
('XY game is out/2015-04-23 13:06:33/1', 'First', NULL, '2015-04-23 13:06:33',NULL , 2);\n";


saveToDb($sqlInsertPlayer, "", "", false, true);
saveToDb($sqlInsertChannel, "", "", false, true);
saveToDb($sqlInsertMessage, "", "", false, true);
