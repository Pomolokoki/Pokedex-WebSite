<?php
include_once '../database/connection/connectSQL.php';

?>
<!-- Inclusion du header -->
<?php include_once 'header.php' ?>

<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet'>
<style>
    <?php include '../style/CSS/register.css' ; ?>
</style>

<!-- #region Sécurisation et Gestion des exceptions-->
<?php 
#region Sécurisation et Gestion des exceptions
$_SESSION['accountCreated'] = false;
$unameErr = $emailErr = $pwordErr = $confirm_passwordErr = '';
$passwordBool = true;
$idBool = true;
$donneeForm = array(
    'username' => '',
    'email' => '',
    'password' => '',
    'confirm_password' => ''    
);
$passwordCheck = '';
$confirm_passwordCheck = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $donneeForm = array(
        'username' => $_POST['username'] ?? '',
        'email' => $_POST['email'] ?? '',
        'password' => $_POST['password'] ?? '',
        'confirm_password' => $_POST['confirm_password'] ?? ''
    );
    if (empty($_POST['username'])) {
        $unameErr = 'Veuillez entrer un pseudo correct';
    } else {
        $donneeForm['username'] = test_input($_POST['username']);
        /*Check si le nom contient seulement des lettres et espace
        preg_match() recherche un pattern de string, et retourne vrai si le pattern existe */
        if (!preg_match('/^[a-zA-Z0-9-\' ]*$/', $donneeForm['username'])) {
            $unameErr = 'Seulement des lettres, des chiffres et des espaces sont autorisés';
        }
    }
    if (empty($_POST['email'])) {
        $emailErr = 'Veuillez entrer un email correct';
    } else {
        $donneeForm['email'] = test_input($_POST['email']);
        if (!filter_var($donneeForm['email'], FILTER_VALIDATE_EMAIL)) {
            $emailErr = 'Email invalide';
        }
    }

    if (!empty($_POST['password']) && !empty($_POST['confirm_password'])) {
        echo $passwordBool;
        $passwordCheck = test_input($_POST['password']);
        $confirm_passwordCheck = test_input($_POST['confirm_password']);
        if (empty($confirm_passwordCheck)) {
            $confirm_passwordErr .= 'Veuillez entrer la confirmation du mot de passe.';
            $passwordBool = false;
        }
        if ($passwordCheck != $confirm_passwordCheck) {
            $confirm_passwordErr .= 'Les mots de passe ne correspondent pas' . "\n";
            $passwordBool = false;
        }
        if (strlen($passwordCheck) <= 8) {
            $pwordErr .= ' - Votre mot de passe doit contenir au minimum 8 caractères.' . "\n";
            $passwordBool = false;
        }
        if (!preg_match('#[0-9]+#', $passwordCheck)) {
            $pwordErr .= '- Votre mot de passe doit contenir au minimum un nombre.' . "\n";
            $passwordBool = false;
        }
        if (!preg_match('#[A-Z]+#', $passwordCheck)) {
            $pwordErr .= '- Votre mot de passe doit contenir au minimum une majuscule.' . "\n";
            $passwordBool = false;
        }
        if (!preg_match('#[a-z]+#', $passwordCheck)) {
            $pwordErr .= '- Votre mot de passe doit contenir au minimum une minuscule' . "\n";
            $passwordBool = false;
        }
    } else {
        $pwordErr .= 'Entrer votre mot de passe et sa confirmation.' . "\n";
        $passwordBool = false;
    }
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



if (!empty($donneeForm['username']) && !empty($donneeForm['email'])) {
    $stmt = $db->prepare('SELECT nickname, email FROM player WHERE nickname = :nickname OR email = :email');
    $stmt->execute([
        ':nickname' => $donneeForm['username'],
        ':email' => $donneeForm['email']
    ]);
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['nickname'] === $donneeForm['username']) {
            $unameErr = 'Pseudo déjà pris';
            $idBool = false;
        }
        if ($row['email'] === $donneeForm['email']) {
            $emailErr = 'Email déjà pris';
            $idBool = false;
        }
    }
}
#endregion

#region Validation du formulaire
if (!empty($donneeForm['username']) && !empty($donneeForm['email']) && !empty($donneeForm['password']) && $passwordCheck === $confirm_passwordCheck && $passwordBool === true && $idBool === true) {

    if (isset($donneeForm['username']) && isset($donneeForm['email']) && isset($donneeForm['password'])) {
        $inscription = $db->prepare('INSERT INTO player(nickname, email, password) VALUES (:nickname, :email, :password)');
        $inscription->bindParam(':nickname', $username);
        $inscription->bindParam(':email', $email);
        $inscription->bindParam(':password', $password);
        
        $username = $donneeForm['username'];
        $email = $donneeForm['email'];
        $password = password_hash($donneeForm['password'], PASSWORD_DEFAULT);

        $inscription->execute();
        $_SESSION['accountCreated'] = true;
        $new_url = 'login.php';
        echo "<script>window.location.replace('$new_url');</script>";
    }
}
#endregion
?>

<!--#endregion -->

<body>
<body>
  <!-- Pokéballs de fond -->
  <div class="pokeball-bg">
    <img src="https://pokemoncalc.web.app/en/assets/pokeball.svg" class="ball ball1">
    <img src="https://pokemoncalc.web.app/en/assets/pokeball.svg" class="ball ball2">
    <img src="https://pokemoncalc.web.app/en/assets/pokeball.svg" class="ball ball3">
    <img src="https://pokemoncalc.web.app/en/assets/pokeball.svg" class="ball ball4">
    <img src="https://pokemoncalc.web.app/en/assets/pokeball.svg" class="ball ball5">
  </div>

  <div class='container'>
    <h2 class="login-title">Inscription</h2>
    <br>
          <!--<span class='error'><strong>* champ obligatoire</strong></span>-->

    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST' autocomplete="off">
      <?php if (isset($errorMessage)): ?>
        <div class='alert alert-danger' role='alert'>
          <?= $errorMessage ?><br><br>
        </div>
      <?php endif; ?>

      <input type='text' id='uname' name='username' placeholder='Pseudo' value='<?= htmlspecialchars($donneeForm['username']); ?>'>
      <!--<span class='error'>* <?= $unameErr; ?></span>-->

      <input type='email' id='email' name='email' placeholder='Email' value='<?= htmlspecialchars($donneeForm['email']); ?>'>
      <!--<span class='error'>* <?= $emailErr; ?></span>-->

      <!-- Mot de passe -->
      <div class="password-wrapper">
        <input type='password' id='pword' name='password' placeholder="Mot de passe" value='<?= htmlspecialchars($donneeForm['password']); ?>'>
        <img src="https://pokemoncalc.web.app/en/assets/pokeball.svg" alt="toggle password" id="togglePassword1">
      </div>
      <!--<span class='error'>* <br><?= nl2br($pwordErr); ?></span>-->

      <!-- Confirmation -->
      <div class="password-wrapper">
        <input type='password' id='pword2' name='confirm_password' placeholder="Confirmation Mot de passe" value='<?= htmlspecialchars($donneeForm['confirm_password']); ?>'>
        <img src="https://pokemoncalc.web.app/en/assets/pokeball.svg" alt="toggle password" id="togglePassword2">
      </div>
      <!--<span class='error'>* <?= nl2br($confirm_passwordErr); ?></span>-->

      <p class="register-msg">Vous possédez un compte ? <a href='login.php'>Connectez-vous !</a></p>
      <input type='submit' value="S'inscrire">
    </form>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      function addToggle(pwdId, toggleId) {
        const pwd = document.getElementById(pwdId);
        const toggle = document.getElementById(toggleId);
        if (pwd && toggle) {
          toggle.addEventListener("click", function () {
            pwd.type = pwd.type === "password" ? "text" : "password";
          });
        }
      }
      addToggle("pword", "togglePassword1");
      addToggle("pword2", "togglePassword2");
    });
  </script>
</body>
</html>

</body>
