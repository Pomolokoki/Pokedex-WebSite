<?php
if (!isset($_GET['request'])) {
    header("Location: unauthorized.php");
    return;
}

include_once '../extractDataFromDB.php';


function UUID($params)
{
    return json_encode(executeQueryWReturn(
        'SELECT UUID() AS uuid',
        $params
    ));
}

function PlayerInfo($params)
{
    return json_encode(executeQueryWReturn(
        'SELECT picture, nickname FROM player WHERE id=:id',
        $params
    ));
}

function GetMessages($params)
{
    return json_encode(
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
            WHERE message.channelId = :channelId ORDER BY message.postDate, LIMIT :offset, 25',
            $params
        )
    );
}

function NewMessage($params)
{
    return executeQuery(
        'INSERT INTO message (id, text, reply, owner, postDate, channelId) VALUES (:id, :text, :replyId, :playerId, :postDate, :channelId)',
        $params
    );
}

function NewChannel($params)
{
    return executeQuery(
        'INSERT INTO message (id, text, reply, owner, postDate, channelId) VALUES (:id, :owner, :title, :keyWords, :creationDate)',
        $params
    );
}

function GetFavs($params)
{
    return json_encode(executeQueryWReturn(
        'SELECT channelId FROM player_fav_channel WHERE playerId=:playerId',
        $params
    ));
}

function GetFav($params)
{
    return json_encode(executeQueryWReturn(
        'SELECT channelId FROM player_fav_channel WHERE playerId=:playerId AND channelId=:themeId',
        $params
    ));
}

function AddFav($params)
{
    return executeQuery(
        'INSERT INTO player_fav_channel VALUES (:playerId, :channelId)',
        $params
    );
}

function RemoveFav($params)
{
    return executeQuery(
        'DELETE FROM player_fav_channel WHERE playerId=:playerId AND channelId=:channelId',
        $params
    );
}

function RemoveMessage($params)
{
    return executeQuery(
        'DELETE FROM message WHERE id=:messageId',
        $params
    );
}
function UpdateMessage($params)
{
    return executeQuery(
        'UPDATE message SET text = :text WHERE id=:message.id',
        $params
    );
}

$req = $_GET['request'];
switch ($req) {

    case 'UUID':
        echo UUID(null);
        return;

    case 'PlayerInfo':
        echo PlayerInfo([':id' => $id]);
        return;

    case 'GetMessages':
        echo GetMessages([':channelId' => $_GET[1]]);
        return;
}

if (!isset($_SESSION) || !isset($_SESSION['LOGGED_USER']) || !isset($_SESSION['LOGGED_USER'][0])) {
    header("Location: unauthorized.php");
    return;
}


switch ($req) {
    case 'NewMessage':
        if ($_GET[4] != $_SESSION['LOGGED_USED'][0]['id']) {
            header("Location: unauthorized.php");
            return;
        }
        echo NewMessage([
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
        echo NewChannel([
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
        echo GetFavs([
            ':playerId' => $_GET[1]
        ]);
        break;

    case 'GetFav':
        if ($_GET[1] != $_SESSION['LOGGED_USED'][0]['id']) {
            header("Location: unauthorized.php");
            return;
        }
        echo GetFav([
            ':playerId' => $_GET[1],
            ':themeId' => $_GET[2]
        ]);
        break;

    case 'AddFav':
        if ($_GET[1] != $_SESSION['LOGGED_USED'][0]['id']) {
            header("Location: unauthorized.php");
            return;
        }
        echo AddFav([
            ':playerId' => $_GET[1],
            ':channelId' => $_GET[2]
        ]);
        break;

    case 'RemoveFav':
        if ($_GET[1] != $_SESSION['LOGGED_USED'][0]['id']) {
            header("Location: unauthorized.php");
            return;
        }
        echo RemoveFav([
            ':playerId' => $_GET[1],
            ':channelId' => $_GET[2]
        ]);
        break;

    case 'RemoveMessage':
        if ($_GET[2] != $_SESSION['LOGGED_USED'][0]['id'] && $_SESSION['LOGGED_USED'][0]['forumRank'] != 8) {
            header("Location: unauthorized.php");
            return;
        }
        echo RemoveMessage([':messageId' => $_GET[1]]);
        break;

    case 'UpdateMessage':
        if ($_GET[3] != $_SESSION['LOGGED_USED'][0]['id']) {
            header("Location: unauthorized.php");
            return;
        }
        echo UpdateMessage([
            ':text' => $_GET[1],
            ':messageId' => $_GET[2]
        ]);
        break;
}