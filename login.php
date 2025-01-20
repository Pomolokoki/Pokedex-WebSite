<!-- Inclusion du header -->
<?php include_once("database/connectSQL.php"); ?>
<?php include_once("header.php") ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- <script type="text/javascript" src="header.js"></script> -->
<style>
    <?php include("css/login.css"); ?>
</style>




<!-- #region Validation du formulaire et Sécurisation et Gestion des exceptions-->
<?php

#region Sécurisation et Gestion des exceptions

$_SESSION["identifier"] = $_SESSION["pword"] = "";
$identifierErr = $emailErr = $pwordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (empty($_POST["id"])) {
        $identifierErr = "Veuillez entrer un identifiant correct";
    } else {
        $_SESSION["identifier"] = test_input($_POST["id"]);
    }
    
    if (empty($_POST["password"])) {
        $pwordErr = "Veuillez entrer un mot de passe";
    } else {
        $_SESSION["pword"] = test_input($_POST["password"]);
    }
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
#endregion

#region Validation du formulaire -->

if (!empty($_POST["id"]) && !empty($_POST["password"])) {
    
    $parcoursPlayerTable = $db->prepare("SELECT id,nickname,email,password FROM player");
    $parcoursPlayerTable->execute();
    $parcoursPlayerTable->setFetchMode(PDO::FETCH_ASSOC);
    $checkDB = 0;
    while ($row = $parcoursPlayerTable->fetch()) {        
        echo "<br>";
        if ($row['nickname'] === $_POST["id"] || $row['email'] === $_POST['id']) {
            if (password_verify($_POST['password'], $row['password'])) {
                $findEmailPlayer = $db->prepare("SELECT id,email,nickname,forumRank FROM player WHERE email=:identifier OR nickname=:identifier");
                $findEmailPlayer->bindParam(':identifier', $_POST['id']);
                $findEmailPlayer->execute();
                $test = $findEmailPlayer->fetchAll(PDO::FETCH_ASSOC);
                $_SESSION['LOGGED_USER'] = $test;
                $_SESSION['user_id'] = $userData['id'];
                $_SESSION['username'] = $userData['nickname'];
                $_SESSION['user_email'] = $userData['email'];
                break;
            }
        } else {
            $errorMessage = sprintf("L'identifiant ou le mot de passe est invalide.");
        }
        $checkDB += 1;
              
    }   
    if($checkDB === 0) {
        $errorMessage = sprintf("L'identifiant ou le mot de passe est invalide.");        
    }
}
#endregion
?>

<!--#endregion -->

<body>
    <div class="container">
        
        <?php if (!isset($_SESSION["accountCreated"])): ?>
        <?php else: ?>
            <?php if ((isset($_SESSION["accountCreated"])) && $_SESSION["accountCreated"] === true): ?>
                <div class="alert alert-success" role="alert">
                    Compte crée avec succès !
                    <?php session_unset() ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (!isset($_SESSION['LOGGED_USER'])): ?>
            <h1>Connexion a votre compte:</h1>
            <br>
            <span class="error"><strong>* champ obligatoire</strong></span>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" autocomplete="off">
                <!-- Affiche l'erreur dans le cas où il y en a une -->
                <?php if (isset($errorMessage)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $errorMessage ?>
                        <br><br>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-25">
                        <label for="identifier">Votre Email ou nom d'utilisateur</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="identifier" name="id" placeholder="sacha.dubourgpalette@pokemon.com">
                        <span class="error">* <?php echo $identifierErr; ?></span>
                        <br><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="pword">Votre mot de passe</label>
                    </div>
                    <div class="col-75">
                        <input type="password" id="pword" name="password">
                        <span class="error">* <?php echo $pwordErr ?></span>
                        <br><br>
                    </div>
                </div>
                <br>
                <div class="row">
                    <p>Pas de compte ? <a href="register.php">Inscrivez-vous !</a></p>
                    <input type="submit" id="submitButton" value="Connectez-vous !">
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-success" role="alert">
                <?php foreach ($_SESSION["LOGGED_USER"] as $id): ?>
                    Bonjour <?php echo $id["nickname"] ?> et bienvenue notre PokeSite !

                <?php endforeach; ?>
                <?php echo $_SESSION['LOGGED_USER'][0]['nickname']; ?>
                <?php
                $new_url = 'pokedex.php';
                echo "<script>window.location.replace('$new_url');</script>";
                ?>
            </div>
            <?php endif; ?>
            <?php
        //session_destroy();
        ?>
        <script type="text/javascript" src="./scripts/login.js"></script>        
    </div>
    <footer>
        </footer>
    </body>
    
    </html>