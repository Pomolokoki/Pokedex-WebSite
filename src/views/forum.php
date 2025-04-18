<?php
include_once '../database/get/extractDataFromDB.php';
$channelData = GetChannels();
$messageData = GetMessages();
?>

<!DOCTYPE html>
<html lang='fr'>

<head>
    <meta charset='utf-8'>
    <title>Pokedex</title>
    <link rel='stylesheet' type='text/css' href='../style/css/forum.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>


<body>
    <?php
    include_once 'header.php';
    ?>
    <?php
    $playerFavChannelData = GetFavoritesChannel([isset($_SESSION['LOGGED_USER']) ? $_SESSION['LOGGED_USER'][0]['id'] : 'NULL']);
    if ($playerFavChannelData == 'No results found.')
        $playerFavChannelData = [];
    ?>
    <div id='forumFrame'>
        <?php if (isset($_SESSION['LOGGED_USER'])) {
            echo '<span id=\'data\' data-nickname=\'' . $_SESSION['LOGGED_USER'][0]['nickname'] . '\' data-id=\'' . $_SESSION['LOGGED_USER'][0]['id'] . '\' data-rank=\'' . $_SESSION['LOGGED_USER'][0]['forumRank'] . '\'></span>';
        } ?>

        <div id='themes'>
            <div id='searchBarContainer'>
                <?php
                if (isset($_SESSION['LOGGED_USER'])) { ?>
                    <svg id='selectFavorite' data-selected='false' xmlns='http://www.w3.org/2000/svg'
                        class='star star-dotted' viewBox='0 0 16 16'>
                        <path
                            d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z' />
                    </svg>
                <?php } ?>
                <textarea id='themeSearchbar' placeholder='Rechercher un thème' rows='1'></textarea>
                <p id='themeSearchbarResultsTitle'> Thèmes les plus récents :</p>
            </div>

            <div id='themeResults'>
                <?php
                for ($i = 0; $i < count($channelData); $i++) {
                    echo '<div class=theme data-channelId=' . $channelData[$i]['id'] . ' data-keyWords=\'' . $channelData[$i]['keyWords'] . '\' data-favorite=false>' . $channelData[$i]['title'] . '</div>';
                }
                ?>
            </div>
            <?php
            if (isset($_SESSION['LOGGED_USER'])) {
                echo '<div class=theme id=createTheme>+</div>';
            }
            ?>
            <div id='selector'>
                <button>
                    < </button>
                        <button>1</button>
                        <button>2</button>
                        <button>></button>
            </div>
        </div>

        <div id='channel'>
            <img id='mobileBackArrow' src='../../public/img/backIcon.png' alt='retourAuxThemes'>
            <?php
            if (isset($_SESSION['LOGGED_USER'])) {
                $isFav = false;
                foreach ($playerFavChannelData as $favChannel) {
                    if ($favChannel['channelId'] == '1') {
                        $isFav = true;
                        break;
                    }
                }
                if ($isFav) {
                    ?>
                    <svg id='setFavorite' data-selected='true' xmlns='http://www.w3.org/2000/svg' class='star star-dotted'
                        viewBox='0 0 16 16'>
                        <path
                            d='M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z' />
                    </svg>
                <?php } else { ?>
                    <svg id='setFavorite' data-selected='false' xmlns='http://www.w3.org/2000/svg' class='star star-dotted'
                        viewBox='0 0 16 16'>
                        <path
                            d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z' />
                    </svg>
                <?php }
            } ?>

            <div id='channelMessages'>
                <h2 id='title' class='message' data-owner=<?php echo '\'' . $messageData[0]['playerId'] . '\''; ?>><?php echo $channelData[1]['title']; ?></h2><br>
                <?php
                for ($i = 0; $i < count($messageData); ++$i) {
                    echo '<div class=profile>
                        <img class=profilePicture src=\'../../public/img/' . $messageData[$i]['profilePicture'] . '\' alt=\'photo de profil\' loadding=lazy decoding=async>
                        <label>' . $messageData[$i]['nickname'] . '</label>
                    </div>';
                    if ($messageData[$i]['reply'] != null) {
                        echo '<div data-id=\'' . $messageData[$i]['replyId'] . '\' data-owner=\'' . $messageData[$i]['replyOwner'] . '\'class=reply > :::repying to <img class=replyProfilePicture loadding=lazy decoding=async src=../../public/img/' . $messageData[$i]['replyProfilePicture'] . ' alt=\'photo de profil\'>' . substr($messageData[$i]['replyNickname'], 0, 10) . '... : ' . substr($messageData[$i]['replyText'], 0, 20) . '...</div>';
                    }
                    echo '<div id=\'' . $messageData[$i]['id'] . '\' class=message data-reply=\'' . $messageData[$i]['replyId'] . '\' data-owner=\'' . $messageData[$i]['playerId'] . '\'>' . $messageData[$i]['text'] . '</div><br><br>';
                }
                ?>
            </div>

            <?php
            if (isset($_SESSION['LOGGED_USER'])) {
                echo '
                <div id=messageArea>
                    <p id=typing></p>
                    <textarea id=messageTextBox type=text rows=1 placeholder=Appuyer sur un touche pour commencer à écrire></textarea>
                    <input id=submitMessage type=image src=../../public/img/sendMessageIcon.png alt =Submit></input>
                </div>';
            } ?>
            <div id='optionsTrigger'>...
                <div id='optionsMenu'>
                    <div id='editOption' class='options'>Modifier</div>
                    <div id='answerOption' class='options'>Répondre</div>
                    <div id='deleteOption' class='options'>Supprimer</div>
                    <div id='reportOption' class='options'>Signaler</div>
                </div>
            </div>
        </div>

        <div id='favorites'>
            <p id='favTitle'> Vos thèmes favoris :</p>
            <div id='favList'>
                <?php
                if (isset($_SESSION['LOGGED_USER'])) {
                    for ($i = 0; $i < count($playerFavChannelData); ++$i) {
                        echo '<div class=theme data-channelId=' . $playerFavChannelData[$i]['channelId'] . '>' . $playerFavChannelData[$i]['title'] . '</div>';
                    }
                    if (count($playerFavChannelData) == 0) {
                        echo '<div id=noTheme class=favorite> Vous n\'avez pas encore de thèmes favoris </div>';
                    }
                } else {
                    echo '<div id=toConnect class=favorite> Connectez vous pour voir vos thèmes favoris ici</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <div id='confirmAction'>
    </div>

    <div id='confirmBox'>
        <p id='confirmText'> Help, je suis en grand danger, sauvez moi</p>
        <div id='confirmBut1' class='but'> Confirmer </div>
        <div id='confirmBut2' class='but'> Annuler </div>
    </div>

    <script src='../scripts/js/svg.js'></script>
    <script src='../scripts/js/forum.js'></script>

    <body>