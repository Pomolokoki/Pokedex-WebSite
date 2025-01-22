<?php
session_start()
    ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
    <script src="scripts/header.js" defer></script>
    <!-- <script src="scripts/profile.js" defer></script> -->
    <title>PokeKrazy</title>
</head>

<header id="header">
    <div class="mycontainer">
        <div id="BackHeader">
            <nav id="theBugerParent">
                <input type="checkbox" id="check">
                <label for="check" class="menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                        class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                    </svg>
                </label>
                <div class="nav-items">
                    <ul class="overview">
                        <h3>PokeWorld :</h3>
                        <li class="pokedexPageMob2"><a href="Pokedex.php">- Pokedex</a></li>
                        <li id="typeTablePage2"><a href="typeTable.php">- Table des types</a></li>
                        <li id="mapPage2"><a href="map.php"> -Maps</a></li>
                        <li><a href="pokemonMove.php">- Attaques</a></li>
                        <li><a href="items.php">- Objet</a></li>
                        <li><a href="forum.php">- Forum</a></li>
                    </ul>
                    <hr>
                    <ul class="account">
                        <h3>Compte :</h3>
                        <li id="myProfile"><a href="#"><pre>- Profil</pre></a></li>
                    </ul>
                </div>
            </nav>
            <?php if(!isset($_SESSION["LOGGED_USER"]) && empty($_SESSION["LOGGED_USER"])):?>
                <style>
                    .account{
                        display: none;
                    }
                </style>
                <?php endif;?>
            <div id="Logo">
                <img src="img/PokeLogo.png" alt="PokeLogo bien carré" id="PokeLogo" />
            </div>

            <div id="Title">
                <p id="pokeTitle">PokeDex</p>                
            </div>
            <div id="Profile">
            <?php if (!isset($_SESSION["LOGGED_USER"]) && empty($_SESSION["LOGGED_USER"])): ?>
                <button type="button" class="Connexion" id="Login">Connexion</button>
            <?php else: ?>
                <div id="myPage">
                    <a href="profile.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" id="myProfile" 
                            class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                        </svg>
                    </a>
                    <form action="<?php echo htmlspecialchars("logout.php"); ?>" method="post">
                        <input type="submit" id="disconnect" value="Déconnexion">
                    </form>
                </div>
            <?php endif; ?>
            </div>
        </div>
        <div id="Nav">
            <div id="pokedexPage" class="navButton">
                <div class="textButton">
                    <p>Pokedex</p>
                </div>

            </div>

            <div id="typeTablePage" class="navButton">
                <div class="textButton">
                    <p>Table des types</p>
                </div>

            </div>

            <div id="mapPage" class="navButton">
                <div class="textButton">
                    <p>Maps</p>
                </div>
            </div>

            <div id="attackPage" class="navButton">
                <div class="textButton">
                    <p>Attaques</p>
                </div>
            </div>

            <div id="itemsPage" class="navButton">
                <div class="textButton">
                    <p>Objets</p>
                </div>
            </div>

            <div id="forumPage" class="navButton">
                <div class="textButton" id="tb6">
                    <p>Forum</p>
                </div>
            </div>
        </div>

    </div>

</header>
<div>
</div>

</html>