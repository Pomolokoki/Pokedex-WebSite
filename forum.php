<?php
include_once("./database/extractDataFromDB.php");
$channelData = getDataFromDB("channel", "*", "ORDER BY creationDate LIMIT 20");
$messageData = getDataFromDB("SELECT message.id, message.text, message.reply, player.nickname as replyNickname, reply.text as replyText, reply.id AS replyId FROM message LEFT JOIN message AS reply ON message.reply = reply.id LEFT JOIN player ON reply.owner = player.id WHERE message.channelId=1 ORDER BY message.postDate", "", "", true);
$playerFavChannelData = getDataFromDB("player_fav_channel", "*", "");

?>
<!DOCTYPE html>
<html lang="fr">
    
    <head>
        <meta charset="utf-8">
        <title>Pokedex</title>
        <link rel="stylesheet" type="text/css" href="css/forum.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
    </head>
    
    
    <body>
        <?php
    include_once('header.php');
    ?>
    <div id="forumFrame">
        <?php if (isset($_SESSION["LOGGED_USER"]))
        {
            echo '<span id="data" data-nickname="' .  $_SESSION["LOGGED_USER"][0]["nickname"] . '" data-id="' . $_SESSION["LOGGED_USER"][0]["id"] . '"></span>';
        }?>
        
        <div id="themes">
            <div id="searchBarContainer">
                <textarea id="themeSearchbar" placeholder="Rechercher un thème..." rows="1"></textarea>
                <p id="themeSearchbarResultsTitle"> Thèmes les plus récents :</p>
            </div>
            <div id="themeResults">
                <?php
                for ($i = 0; $i < count($channelData); $i++) {
                    echo "<div class=theme data-channelId=" . $channelData[$i]["id"] . " data-keyWords='" . $channelData[$i]["keyWords"] . "'>" . $channelData[$i]["title"] . "</div>";
                }
                if (isset(($_SESSION["LOGGED_USER"])))
                {
                    echo "<div class=theme id=createTheme> + </div>";
                }
                ?>
            </div>
            <div id="selector">
                <button><</button>
                <button>1</button>
                <button>2</button>
                <button>></button>
            </div>
        </div>
        <div id="channel">
            <div id="channelMessages">
                <h2 id = 'title' class="message"><?php echo $channelData[1]["title"]; ?></h2><br>
            <?php
                for ($i = 0; $i < count($messageData); ++$i)
                {
                    if ($messageData[$i]["reply"] != null)
                    {
                        echo "<div data-id='" . $messageData[$i]["replyId"] . "' class=reply > :::repying to " . substr($messageData[$i]["replyNickname"], 0, 10) . "... : " . substr($messageData[$i]["replyText"], 0, 20) . "...</div>";
                    }
                    echo "<div id='" . $messageData[$i]["id"] . "' class=message data-reply=" . $messageData[$i]["replyId"] . ">" . $messageData[$i]["text"] . "</div><br><br>";
                }
                ?>
            </div>
            <?php 
            if (isset($_SESSION["LOGGED_USER"]))
            {
                echo`
                <div id="messageArea">
                    <textarea id="messageTextBox" type="text" rows="1" placeholder="Appyuer sur un touche pour commencer à écrire"></textarea>
                    <input id="submitMessage" type="image" src="./img/sendMessageIcon.png" alt ="Submit"></input>
                </div>`;
            }?>
        </div>
        <div id="favorites">
            <p> Vos thèmes favoris :</p>
            <div id="favList">
                <?php
                if (isset($_SESSION["LOGGED_USER"]))
                {
                    for ($i = 0; $i < count($playerFavChannelData); ++$i)
                    {
                        echo "<div class=favorite data-channelId=" . $playerFavChannelData[$i]["channelId"] . ">" . $playerFavChannelData[$i]["title"] . "</div>";
                    }
                    if (count($playerFavChannelData) == 0)
                    {
                        echo "<div class=favorite> Vous n'avez pas encre de thèmes favoris </div>" ;
                    }
                }
                else
                {
                    echo "<div class=favorite> Connectez vous pour voir vos thèmes favoris ici</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="./scripts/forum.js"></script>
    <body>