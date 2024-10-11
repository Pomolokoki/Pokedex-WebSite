<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
    <script src="scripts/header.js" defer></script>
    <title>PokeKrazy</title>
</head>

<?php include_once("header.html") ?>
<body>
    
    <div class="container">
    <h1>Formulaire d'inscription:</h1>
    <br>
        <form action="/action_page.php" method="POST">
            <div class="row">
                <div class="col-25">
                    <label for="fname">Votre nom d'utilisateur</label>
                    <br><br>
                </div>
                <div class="col-75">
                    <input type="text" id="uname" name="username" placeholder="Votre pseudo...">
                    <br><br>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="lname">Votre Email</label>
                    
                </div>
                <div class="col-75">
                    <input type="email" id="email" name="email" placeholder="sacha.dubourgpalette@pokemon.com">
                    <br><br>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="pword">Votre mot de passe</label>
                    
                </div>
                <div class="col-75">
                    <input type="password" id="pword" name="password">
                    <br><br>
                </div>
            </div>            
            <br>
            <div class="row">
            <p>Vous possédez un compte ? <a href="login.php">Connectez-vous !</a></p>
                <input type="submit" value="S'inscrire">
            </div>
        </form>
    </div>
    <footer>
    </footer>
</body>
</html>