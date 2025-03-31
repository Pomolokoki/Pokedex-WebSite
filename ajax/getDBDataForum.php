<?php
include_once '../database/extractDataFromDB.php';
//var_dump($_GET);
$req = $_GET['request'];
switch ($req) {
    case 'UUID':
        echo json_encode(executeQueryWReturn('SELECT UUID() AS uuid', null));
        break;

    case 'PlayerInfo':
        $id = $_GET[1];
        //if (!is_numeric($id))
        //    return 'No results found.';
        //echo $id;
        echo json_encode(executeQueryWReturn('SELECT picture, nickname FROM player WHERE id=:id', [':id' => $id]));
        break;

    case 'NewMessage':
        if ($_GET[3] == "null")
            $_GET[3] = null;
        echo executeQuery('INSERT INTO message (id, text, reply, owner, postDate, channelId) VALUES (:id, :text, :replyId, :playerId, :postDate, :channelId)', [
            ':id' => $_GET[1],
            ':text' => $_GET[2],
            ':replyId' => $_GET[3],
            ':playerId' => $_GET[4],
            ':postDate' => $_GET[5],
            ':channelId' => $_GET[6]
        ]);
        break;

    case 'NewChannel':
        echo executeQuery('INSERT INTO message (id, text, reply, owner, postDate, channelId) VALUES (:id, :owner, :title, :keyWords, :creationDate)', [
            ':id' => $_GET[1],
            ':owner' => $_GET[2],
            ':title' => $_GET[3],
            ':keyWords' => $_GET[4],
            ':creationDate' => $_GET[5]
        ]);
        break;

    case 'GetFavs':
        echo json_encode(executeQueryWReturn('SELECT channelId FROM player_fav_channel WHERE playerId=:playerId', [
            ':playerId' => $_GET[1]
        ]));
        break;

    case 'GetFav':
        echo json_encode(executeQueryWReturn('SELECT channelId FROM player_fav_channel WHERE playerId=:playerId AND channelId=:themeId', [
            ':playerId' => $_GET[1],
            ':themeId' => $_GET[2]
        ]));
        break;

    case 'GetMessages':
        echo json_encode(executeQueryWReturn('SELECT
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
        ));
        break;

    case 'AddFav':
        echo executeQuery('INSERT INTO player_fav_channel VALUES (:playerId, :channelId)', [
            ':playerId' => $_GET[1],
            ':channelId' => $_GET[2]
        ]);
        break;

    case 'RemoveFav':
        echo executeQuery('DELETE FROM player_fav_channel WHERE playerId=:playerId AND channelId=:channelId', [
            ':playerId' => $_GET[1],
            ':channelId' => $_GET[2]
        ]);
        break;

    case 'RemoveMessage':
        echo executeQuery('DELETE FROM message WHERE id=:messageId', [':messageId' => $_GET[1]]);
        break;

    case 'UpdateMessage':
        echo executeQuery('UPDATE message SET text = :text WHERE id=:message.id', [
            ':text' => $_GET[1],
            ':messageId' => $_GET[2]
        ]);
        break;

    default:
        echo json_encode(getDataFromDB($_GET['request'], null, null, true));
        break;
}