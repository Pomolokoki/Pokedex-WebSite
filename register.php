<?php
include_once 'database/connectSQL.php';

?>
<!-- Inclusion du header -->
<?php include_once 'header.php' ?>

<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet'>
<style>
    <?php include 'css/register.css' ; ?>
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
    <div class='container'>
        <h2>Formulaire d'inscription:</h2>
        <br>

        <span class='error'><strong>* champ obligatoire</strong></span>
        <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
            <!-- Affiche l'erreur dans le cas où il y en a une -->
            <?php if (isset($errorMessage)): ?>
                <div class='alert alert-danger' role='alert'>
                    <?php echo $errorMessage ?>
                    <br><br>
                </div>
            <?php endif; ?>
            <div class='row'>
                <div class='col-25'>
                    <label for='uname'>Votre nom d'utilisateur</label>
                    <br><br>
                </div>
                <div class='col-75'>
                    <input type='text' id='uname' name='username' placeholder='Votre pseudo...' value='<?php echo htmlspecialchars($donneeForm['username']); ?>'>
                    <span class='error'>* <?php echo $unameErr; ?></span>
                    <br><br>
                </div>
            </div>
            <div class='row'>
                <div class='col-25'>
                    <label for='email'>Votre Email</label>
                </div>
                <div class='col-75'>
                    <input type='email' id='email' name='email' placeholder='sacha.dubourgpalette@pokemon.com' value='<?php echo htmlspecialchars($donneeForm['email']); ?>'>
                    <span class='error'>* <?php echo $emailErr; ?></span>
                    <br><br>
                </div>
            </div>
            <div class='row'>
                <div class='col-25'>
                    <label for='pword'>Votre mot de passe</label>
                </div>
                <div class='col-75'>
                    <input type='password' id='pword' name='password' value='<?php echo htmlspecialchars($donneeForm['password']); ?>'>
                    <span class='error'>* <br><?php echo nl2br($pwordErr); ?></span>
                    <br><br>
                </div>
            </div>
            <div class='row'>
                <div class='col-25'>
                    <label for='pword2'>Confirmer votre mot de passe</label>
                </div>
                <div class='col-75'>
                    <input type='password' id='pword2' name='confirm_password' value='<?php echo htmlspecialchars($donneeForm['confirm_password']); ?>'>
                    <span class='error'>* <?php echo nl2br($confirm_passwordErr); ?></span>
                    <br><br>
                </div>
            </div>
            <br>
            <div class='row'>
                <p>Vous possédez un compte ? <a href='login.php'>Connectez-vous !</a></p>
                <br><br>
                <input type='submit' value="S'inscrire">
            </div>
        </form>
    </div>
    <footer>
    </footer>
</body>
</html>