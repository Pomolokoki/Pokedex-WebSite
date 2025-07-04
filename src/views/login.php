<!-- Inclusion du header -->
<?php include_once '../database/connection/connectSQL.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
session_start();
include_once 'header.php';
// require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
// require '../vendor/phpmailer/phpmailer/src/SMTP.php';
// require '../vendor/phpmailer/phpmailer/src/Exception.php';
?>

<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet'>
<style>
    <?php include '../style/CSS/login.css'; ?>
</style>

<!-- #region Validation du formulaire et Sécurisation et Gestion des exceptions-->
<?php

#region Sécurisation et Gestion des exceptions

$_SESSION['identifier'] = $_SESSION['pword'] = '';
$identifierErr = $emailErr = $pwordErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["email"]) && (!empty($_POST["email"])) && isset($_POST["password"]) && (!empty($_POST["password"]))) {

    if (empty($_POST['id'])) {
        $identifierErr = 'Veuillez entrer un identifiant correct';
    } else {
        $_SESSION['identifier'] = test_input($_POST['id']);
    }


    if (empty($_POST['password'])) {
        $pwordErr = 'Veuillez entrer un mot de passe';
    } else {
        $_SESSION['pword'] = test_input($_POST['password']);
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

if (!empty($_POST['id']) && !empty($_POST['password'])) {


    $parcoursPlayerTable = $db->prepare('SELECT id,nickname,email,password FROM player');
    $parcoursPlayerTable->execute();
    $parcoursPlayerTable->setFetchMode(PDO::FETCH_ASSOC);
    $checkDB = 0;
    while ($row = $parcoursPlayerTable->fetch()) {
    while ($row = $parcoursPlayerTable->fetch()) {
        if ($row['nickname'] === $_POST['id'] || $row['email'] === $_POST['id']) {
            if (password_verify($_POST['password'], $row['password'])) {
                $findEmailPlayer = $db->prepare('SELECT id,email,nickname,forumRank,picture FROM player WHERE email=:identifier OR nickname=:identifier');
                $findEmailPlayer->bindParam(':identifier', $_POST['id']);
                $findEmailPlayer->execute();
                $test = $findEmailPlayer->fetchAll(PDO::FETCH_ASSOC);
                $_SESSION['LOGGED_USER'] = $test;
                break;
            }
        } else {
            $errorMessage = sprintf('L\'identifiant ou le mot de passe est invalide.');
        }
        $checkDB += 1;
    }
    if ($checkDB === 0) {
        $errorMessage = sprintf('L\'identifiant ou le mot de passe est invalide.');
    }
}
}
#endregion

?>

<!--#endregion -->

<!-- Modal de réinitialisation -->
<div id="resetModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Réinitialiser le mot de passe</h2>
            <p>Entrez votre adresse email pour recevoir un lien de réinitialisation.</p>
            
            <form method="POST" action="../scripts/PHP/send-password-reset.php">
                <div class="form-group">
                    <label for="resetEmail">Adresse email :</label>
                    <input type="email" id="resetEmail" name="email" required class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Envoyer le lien</button>
            </form>
        </div>
    </div>
<body>
    <div class='container'>
        <?php if (isset($_GET['reset']) && $_GET['reset'] === 'success'): ?>
            <div class="alert alert-success" role="alert">
                Un email de réinitialisation a été envoyé à votre adresse. Veuillez vérifier votre boîte de réception.
            </div>
        <?php endif; ?>    
        <?php if (!isset($_SESSION['accountCreated'])): ?>
        <?php else: ?>
            <?php if ((isset($_SESSION['accountCreated'])) && $_SESSION['accountCreated'] === true): ?>
                <div class='alert alert-success' role='alert'>
                    Compte crée avec succès !
                    <?php session_unset() ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (!isset($_SESSION['LOGGED_USER'])): ?>
            <h1>Connexion a votre compte:</h1>
            <br>
            <span class='error'><strong>* champ obligatoire</strong></span>
            <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST' autocomplete='off'>
                <!-- Affiche l'erreur dans le cas où il y en a une -->
                <?php if (isset($errorMessage)): ?>
                    <div class='alert alert-danger' role='alert'>
                        <?php echo $errorMessage ?>
                        <br><br>
                    </div>
                <?php endif; ?>
                <div class='row'>
                    <div class='col-25'>
                        <label for='identifier'>Votre Email ou nom d'utilisateur</label>
                    </div>
                    <div class='col-75'>
                        <input type='text' id='identifier' name='id' placeholder='sacha.dubourgpalette@pokemon.com'>
                        <span class='error'>* <?php echo $identifierErr; ?></span>
                        <br><br>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-25'>
                        <label for='pword'>Votre mot de passe</label>
                    </div>
                    <div class='col-75'>
                        <input type='password' id='pword' name='password'>
                        <span class='error'>* <?php echo $pwordErr ?></span>
                        <br><br>
                    </div>
                </div>
                <br>
                <div class='row'>
                    <p>Pas de compte ? <a href='register.php'>Inscrivez-vous !</a></p>
                    <input type='submit' id='submitButton' value='Connectez-vous !'>
                </div>
                <div class='row'>
                    <p>Mot de passe oublié ? <a href="#" id="showResetModal">Réinitialisez-le !</a></p>
                </div>
            </form>
        <?php else: ?>
            <div class='alert alert-success' role='alert'>
                <?php foreach ($_SESSION['LOGGED_USER'] as $id): ?>
                    Bonjour <?php echo $id['nickname'] ?> et bienvenue notre PokeSite !
                <?php endforeach; ?>
                <?php
                $new_url = 'pokedex.php';
                echo "<script>window.location.replace('$new_url');</script>";
                ?>
            </div>
        <?php endif; ?>
    </div>
    <footer>
    </footer>
    <script type='text/javascript' src='../scripts/JS/login.js'></script>
</body>