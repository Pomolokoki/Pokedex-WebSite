DROP DATABASE IF EXISTS pokedex;
CREATE DATABASE pokedex CHARACTER SET utf8;
USE pokedex;

CREATE TABLE ability(
id TINYINT UNSIGNED PRIMARY KEY,
name VARCHAR(50),
isHidden BOOLEAN,
description TEXT,
effect VARCHAR(25),
effectValue FLOAT,
effectDuration TINYINT,
affect TINYINT UNSIGNED,
moment TINYINT
);

CREATE TABLE type(
id TINYINT PRIMARY KEY,
name VARCHAR(15),
sprite TEXT,
efficiency VARCHAR(19) 
);

CREATE TABLE move(
id SMALLINT PRIMARY KEY,
description TEXT,
accuracy TINYINT,
type TINYINT,
pp TINYINT,
pc TINYINT,
statut VARCHAR(25),
effect VARCHAR(25),
effectValue FLOAT,
effectDuration TINYINT,
affect INT UNSIGNED,
isPhysical BOOLEAN,
combo TINYINT UNSIGNED,
priority BOOLEAN,
criticity FLOAT,
influenced TINYINT,
learnship TINYINT,
CONSTRAINT move_type_FK FOREIGN KEY (type) REFERENCES type(id)
);

CREATE TABLE pokemon(
id FLOAT UNSIGNED PRIMARY KEY,
generation TINYINT UNSIGNED,
category TINYINT UNSIGNED,
name VARCHAR(100),
spriteM TEXT,
spriteF TEXT,
type1 TINYINT UNSIGNED,
type2 TINYINT UNSIGNED,
ability1 TINYINT UNSIGNED,
ability2 TINYINT UNSIGNED,
ability3 TINYINT UNSIGNED,
hp SMALLINT UNSIGNED,
atack TINYINT UNSIGNED,
defense TINYINT UNSIGNED,
atackspe TINYINT UNSIGNED,
defensespe TINYINT UNSIGNED,
speed TINYINT UNSIGNED,
typeEfficiency VARCHAR(255),
evolSup VARCHAR(100),
conditionEvol VARCHAR(100),
evolInf FLOAT UNSIGNED,
mega BOOLEAN,
height VARCHAR(10),
weight VARCHAR(10),
catch_rate TINYINT,
moves TEXT,
CONSTRAINT pokemeon_type1_FK FOREIGN KEY (type) REFERENCES type(id),
CONSTRAINT pokemeon_type2_FK FOREIGN KEY (type) REFERENCES type(id),
CONSTRAINT pokemeon_ability1_FK FOREIGN KEY (ability1) REFERENCES ability(id),
CONSTRAINT pokemeon_ability2_FK FOREIGN KEY (ability2) REFERENCES ability(id),
CONSTRAINT pokemeon_ability3_FK FOREIGN KEY (ability3) REFERENCES ability(id)
);

CREATE TABLE item(
id SMALLINT UNSIGNED PRIMARY KEY,
name VARCHAR(50),
description TEXT,
sprite TEXT,
statut VARCHAR(25),
effect VARCHAR(25),
effectValue FLOAT,
oneUse BOOLEAN
);

CREATE TABLE pokeball(
id TINYINT UNSIGNED PRIMARY KEY,
name VARCHAR(25),
description TEXT,
sprite TEXT,
captureRate FLOAT
);

CREATE TABLE team(
id TINYINT UNSIGNED PRIMARY KEY,
name VARCHAR(25),
spriteBg TEXT,
spriteHead TEXT,
spriteLeft TEXT,
spriteRight TEXT,
spriteBonus TEXT
);

CREATE TABLE combatTeam
(
id INT UNSIGNED PRIMARY KEY,
name VARCHAR(25),
pokemon1 FLOAT,
pokemon2 FLOAT,
pokemon3 FLOAT,
pokemon4 FLOAT,
pokemon5 FLOAT,
pokemon6 FLOAT
);

CREATE TABLE player(
id INT UNSIGNED PRIMARY KEY,
nickname VARCHAR(50),
level SMALLINT UNSIGNED,
xp SMALLINT UNSIGNED,
team TINYINT UNSIGNED,
picture TEXT,
combatTeam1 INT UNSIGNED, 
combatTeam2 INT UNSIGNED,
combatTeam3 INT UNSIGNED,
selectedTeam INT UNSIGNED,
favorites TEXT,
pokedex TEXT,
friends TEXT,
CONSTRAINT player_team_FK FOREIGN KEY (team) REFERENCES team(id),
CONSTRAINT player_combatTeam1_FK FOREIGN KEY (combatTeam1) REFERENCES combatTeam(id),
CONSTRAINT player_combatTeam2_FK FOREIGN KEY (combatTeam2) REFERENCES combatTeam(id),
CONSTRAINT player_combatTeam_FK FOREIGN KEY (combatTeam3) REFERENCES combatTeam(id)
);
