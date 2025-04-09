<?php
session_start();
include_once '../database/connection/connectSQL.php';
?>

<!DOCTYPE html>
<html lang='fr'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='../style/CSS/header.css'>
    <script src='../scripts/JS/header.js' defer></script>
    
    <script src='../scripts/JS/profile.js' defer></script>
    <title>PokeKrazy</title>
</head>

<?php if (isset($_SESSION['LOGGED_USER'][0]['picture'])) {
    $profilePictureUser = $_SESSION['LOGGED_USER'][0]['picture'];
    $user_id = $_SESSION['LOGGED_USER'][0]['id'];
}

if(isset($_FILES['image'])){
    
    $file_name = $_FILES['image']['name'];
    $file_tmpName = $_FILES['image']['tmp_name'];
    $file_error = $_FILES['image']['error'];
    //Créer un dossier pour stocker les images
    $upload_dir = 'uploads/';
    if(!is_dir($upload_dir)){
        mkdir($upload_dir);
    }
    
    $file_destination = $upload_dir . $file_name;
    if ($file_error === 0){
        if(move_uploaded_file($file_tmpName, $file_destination)){
        $updateSQL = 'UPDATE player SET picture = :picture WHERE id = :id';
        $stmt = $db->prepare($updateSQL);
        $stmt->execute([
            ':picture' => $file_destination,
            ':id' => $user_id
        ]);
        $_SESSION['LOGGED_USER'][0]['picture'] = $file_destination;
    }
    else{
        echo 'Erreur lors de l\'upload';
    }
    }
    else{
        echo 'Erreur : ' . $file_error;
    }
}
?>
<header id='header'>
    <div class='mycontainer'>
        <div id='BackHeader'>
            <nav id='theBugerParent'>
                <input type='checkbox' id='check'>
                <label for='check' class='menu'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' fill='currentColor'
                        class='bi bi-list' viewBox='0 0 16 16' id='menuIcon'>
                        <path fill-rule='evenodd'
                            d='M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z' />
                    </svg>
                </label>
                <div class='nav-items'>
                    <ul class='overview'>
                        <h3>PokeWorld :</h3>
                        <li><a href='Pokedex.php'>- Pokedex</a></li>
                        <li><a href='typeTable.php'>- Table des types</a></li>
                        <li><a href='map.php'> -Maps</a></li>
                        <li><a href='pokemonMove.php'>- Attaques</a></li>
                        <li><a href='items.php'>- Objet</a></li>
                        <li><a href='forum.php'>- Forum</a></li>
                    </ul>
                    <hr>
                    <ul class='account'>
                        <h3>Compte :</h3>
                        <li><a href='profile.php'>- Profil</a></li>
                    </ul>
                </div>
            </nav>
            <?php if(!isset($_SESSION['LOGGED_USER']) && empty($_SESSION['LOGGED_USER'])):?>
                <style>
                    .account{
                        display: none;
                    }
                </style>
                <?php endif;?>
            <div id='Logo'>
                <img src='/public/img/PokeLogov2.png' alt='Logo' id='PokeLogo' />
            </div>
            <div id='Profile'>
            <?php if (!isset($_SESSION['LOGGED_USER']) && empty($_SESSION['LOGGED_USER'])): ?>
                <button type='button' class='Connexion' id='Login'>Connexion</button>
            <?php else: ?>
                <div id='myPage' style='cursor: pointer;'>
                        <img src='<?php echo htmlspecialchars($profilePictureUser); ?>' alt='Profile Picture' id='profilePicture'>
                    </a>
                </div>
            <?php endif; ?>
            </div>
        </div>
        <div id='Nav'>
            <div id='pokedexPage' class='navButton'>
                <div class='textButton'>
                    <p>Pokedex</p>
                </div>

            </div>

            <div id='typeTablePage' class='navButton'>
                <div class='textButton'>
                    <p>Table des types</p>
                </div>

            </div>

            <div id='mapPage' class='navButton'>
                <div class='textButton'>
                    <p>Maps</p>
                </div>
            </div>

            <div id='attackPage' class='navButton'>
                <div class='textButton'>
                    <p>Attaques</p>
                </div>
            </div>

            <div id='itemsPage' class='navButton'>
                <div class='textButton'>
                    <p>Objets</p>
                </div>
            </div>

            <div id='forumPage' class='navButton'>
                <div class='textButton' id='tb6'>
                    <p>Forum</p>
                </div>
            </div>
        </div>

    </div>
</header>
</html>