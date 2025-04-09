<?php
if (!isset($_GET['request'])) {
    header("Location: unauthorized.php");
    return;
}

include_once '../extractDataFromDB.php';

$req = $_GET['request'];
switch ($req) {

    case 'UUID':
        echo json_encode(executeQueryWReturn('SELECT UUID() AS uuid', null));
        return;

    case 'PlayerInfo':
        $id = $_GET[1];
        //if (!is_numeric($id))
        //    return 'No results found.';
        //echo $id;
        echo json_encode(executeQueryWReturn('SELECT picture, nickname FROM player WHERE id=:id', [':id' => $id]));
        return;

    case 'GetMessages':
        echo json_encode(
            executeQueryWReturn('SELECT
                channel.title,
                message.id,
                message.text,
                message.reply,
                player.id AS owner, 
                player.nickname,
                player.picture,
                reply.id AS replyId,
                reply.owner AS replyOwner,
                reply.text AS replyText,
                replyPlayer.nickname AS replyNickname,
                replyPlayer.picture AS replyPicture 
                FROM message 
                LEFT JOIN message AS reply ON message.reply = reply.id 
                LEFT JOIN player ON message.owner = player.id 
                LEFT JOIN player AS replyPlayer ON reply.owner = replyPlayer.id 
                LEFT JOIN channel ON message.channelId = channel.id 
                WHERE message.channelId = :channelId ORDER BY message.postDate',
                [':channelId' => $_GET[1]]
            )
        );
        return;
}

if (!isset($_SESSION) || !isset($_SESSION['LOGGED_USER']) ||!isset($_SESSION['LOGGED_USER'][0])) {
    header("Location: unauthorized.php");
    return;
}

//var_dump($_SESSION['LOGGED_USER'][0]);
//var_dump($_GET);

switch ($req) {
    case 'NewMessage':
        if ($_GET[4] != $_SESSION['LOGGED_USED'][0]['id']) {
            header("Location: unauthorized.php");
            return;
        }
        echo executeQuery('INSERT INTO message (id, text, reply, owner, postDate, channelId) VALUES (:id, :text, :replyId, :playerId, :postDate, :channelId)', [
            ':id' => $_GET[1],
            ':text' => $_GET[2],
            ':replyId' => $_GET[3],
            ':playerId' => $_GET[4],
            ':postDate' => date('Y-m-d'),
            ':channelId' => $_GET[5]
        ]);
        break;

    case 'NewChannel':
        if ($_GET[2] != $_SESSION['LOGGED_USED'][0]['id']) {
            header("Location: unauthorized.php");
            return;
        }
        echo executeQuery('INSERT INTO message (id, text, reply, owner, postDate, channelId) VALUES (:id, :owner, :title, :keyWords, :creationDate)', [
            ':id' => $_GET[1],
            ':owner' => $_GET[2],
            ':title' => $_GET[3],
            ':keyWords' => $_GET[4],
            ':creationDate' => date('Y-m-d'),
        ]);
        break;

    case 'GetFavs':
        if ($_GET[1] != $_SESSION['LOGGED_USED'][0]['id']) {
            header("Location: unauthorized.php");
            return;
        }
        echo json_encode(executeQueryWReturn('SELECT channelId FROM player_fav_channel WHERE playerId=:playerId', [
            ':playerId' => $_GET[1]
        ]));
        break;

    case 'GetFav':
        if ($_GET[1] != $_SESSION['LOGGED_USED'][0]['id']) {
            header("Location: unauthorized.php");
            return;
        }
        echo json_encode(executeQueryWReturn('SELECT channelId FROM player_fav_channel WHERE playerId=:playerId AND channelId=:themeId', [
            ':playerId' => $_GET[1],
            ':themeId' => $_GET[2]
        ]));
        break;

    case 'AddFav':
        if ($_GET[1] != $_SESSION['LOGGED_USED'][0]['id']) {
            header("Location: unauthorized.php");
            return;
        }
        echo executeQuery('INSERT INTO player_fav_channel VALUES (:playerId, :channelId)', [
            ':playerId' => $_GET[1],
            ':channelId' => $_GET[2]
        ]);
        break;

    case 'RemoveFav':
        if ($_GET[1] != $_SESSION['LOGGED_USED'][0]['id']) {
            header("Location: unauthorized.php");
            return;
        }
        echo executeQuery('DELETE FROM player_fav_channel WHERE playerId=:playerId AND channelId=:channelId', [
            ':playerId' => $_GET[1],
            ':channelId' => $_GET[2]
        ]);
        break;

    case 'RemoveMessage':
        if ($_GET[2] != $_SESSION['LOGGED_USED'][0]['id'] && $_SESSION['LOGGED_USED'][0]['forumRank'] != 8) {
            header("Location: unauthorized.php");
            return;
        }
        echo executeQuery('DELETE FROM message WHERE id=:messageId', [':messageId' => $_GET[1]]);
        break;

    case 'UpdateMessage':
        if ($_GET[3] != $_SESSION['LOGGED_USED'][0]['id']) {
            header("Location: unauthorized.php");
            return;
        }
        echo executeQuery('UPDATE message SET text = :text WHERE id=:message.id', [
            ':text' => $_GET[1],
            ':messageId' => $_GET[2]
        ]);
        break;
}