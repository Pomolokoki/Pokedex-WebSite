<!-- Inclusion du header -->
<?php include_once '../database/connection/connectSQL.php';
include_once 'header.php';
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
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
    if($checkDB === 0) {
        $errorMessage = sprintf('L\'identifiant ou le mot de passe est invalide.');        
    }
}
#endregion
?>

<!--#endregion -->

<body>
<div class="pokeball-bg">
  <img src="https://pokemoncalc.web.app/en/assets/pokeball.svg" class="ball ball1">
  <img src="https://pokemoncalc.web.app/en/assets/pokeball.svg" class="ball ball2">
  <img src="https://pokemoncalc.web.app/en/assets/pokeball.svg" class="ball ball3">
  <img src="https://pokemoncalc.web.app/en/assets/pokeball.svg" class="ball ball4">
  <img src="https://pokemoncalc.web.app/en/assets/pokeball.svg" class="ball ball5">
</div>


    <div class='container'>
        
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
            <h1 class="login-title">Connexion</h1>
            <br>
            


<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" autocomplete="off">
  <?php if (isset($errorMessage)): ?>
    <div class="alert alert-danger" role="alert"><?= $errorMessage ?></div>
  <?php endif; ?>

  <input type="text" name="id" placeholder="Email / Pseudo" value="<?= htmlspecialchars($_SESSION['identifier']) ?>">
  <span class="error"><?= $identifierErr ?></span>


<div class="password-wrapper">
  <input type="password" id="pword" placeholder="Mot de passe">
  <img src="https://pokemoncalc.web.app/en/assets/pokeball.svg" alt="toggle password" id="togglePassword">
</div>


  <span class="error"><?= $pwordErr ?></span>

  <input type="submit" value="Valider">
</form>

<p class="register-msg">Pas de compte ? <a href="register.php">Inscrivez-vous !</a></p>

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
            <?php
        ?>
        <script type='text/javascript' src='../scripts/JS/login.js'></script>
    </div>
    <footer>
        </footer>
    </body>
    
    </html>