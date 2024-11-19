<?php
include_once("database/connectSQL.php");
//include_once("database/getDataFunction.php");
?>
<!-- Inclusion du header -->
<?php include_once("header.php") ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    <?php include("css/register.css"); ?>
</style>

<!-- #region Sécurisation et Gestion des exceptions-->
<?php
#region Sécurisation et Gestion des exceptions
$_SESSION["accountCreated"] = false;
$_SESSION["uname"] = $_SESSION["email"] = $_SESSION["pword"] = $_SESSION['confirm_password'] = "";
$unameErr = $emailErr = $pwordErr = $confirm_passwordErr = "";
$passwordBool = true;
$idBool = true;
$passwordCheck = "";
$confirm_passwordCheck = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["username"])) {
        $unameErr = "Veuillez entrer un pseudo correct";
    } else {
        $_SESSION["uname"] = test_input($_POST["username"]);
        /*Check si le nom contient seulement des lettres et espace
        preg_match() recherche un pattern de string, et retourne vrai si le pattern existe */
        if (!preg_match("/^[a-zA-Z-' ]*$/", $_SESSION["uname"])) {
            $unameErr = "Seulement des lettres et des espaces sont autorisés";
        }
    }
    if (empty($_POST["email"])) {
        $emailErr = "Veuillez entrer un email correct";
    } else {
        $_SESSION["email"] = test_input($_POST["email"]);
        if (!filter_var($_SESSION["email"], FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Email invalide";
        }
    }

    if (!empty($_POST["password"]) && !empty($_POST["confirm_password"])) {
        $passwordCheck = test_input($_POST["password"]);
        $confirm_passwordCheck = test_input($_POST["confirm_password"]);
        $_SESSION["pword"] = $passwordCheck;
        $_SESSION["confirm_password"] = $confirm_passwordCheck;
        if (empty($confirm_passwordCheck)) {
            $confirm_passwordErr .= "Veuillez entrer la confirmation du mot de passe.";
            $passwordBool = false;
        }
        if ($passwordCheck != $confirm_passwordCheck) {
            $confirm_passwordErr .= "Les mots de passe ne correspondent pas\n";
            $passwordBool = false;
        }
        if (strlen($passwordCheck) <= 8) {
            $pwordErr .= " - Votre mot de passe doit contenir au minimum 8 caractères.\n";
            $passwordBool = false;
        }
        if (!preg_match("#[0-9]+#", $passwordCheck)) {
            $pwordErr .= "- Votre mot de passe doit contenir au minimum un nombre.\n";
            $passwordBool = false;
        }
        if (!preg_match("#[A-Z]+#", $passwordCheck)) {
            $pwordErr .= "- Votre mot de passe doit contenir au minimum une majuscule.\n";
            $passwordBool = false;
        }
        if (!preg_match("#[a-z]+#", $passwordCheck)) {
            $pwordErr .= "- Votre mot de passe doit contenir au minimum une minuscule\n";
            $passwordBool = false;
        }
    } else {
        $pwordErr .= "Entrer votre mot de passe et sa confirmation.\n";
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

if (!empty($_POST["username"]) && !empty($_POST["email"])) {
    $parcoursPlayerTable = $db->prepare("SELECT nickname,email,password FROM player");
    $parcoursPlayerTable->execute();
    $parcoursPlayerTable->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $parcoursPlayerTable->fetch()) {
        if ($row['nickname'] === $_SESSION['uname']) {
            $unameErr = "Pseudo déjà pris";
            $idBool = false;
        }
        if ($row['email'] === $_SESSION['email']) {
            $emailErr = "Email déjà pris";
            $idBool = false;
        }
    }
}

#region Validation du formulaire -->
if (!empty($_SESSION["uname"]) && !empty($_SESSION["email"]) && !empty($_SESSION["pword"]) && $passwordCheck === $confirm_passwordCheck && $passwordBool === true && $idBool === true) {

    if (isset($_SESSION["uname"]) && isset($_SESSION["email"]) && isset($_SESSION["pword"])) {
        $inscription = $db->prepare('INSERT INTO player(nickname, email, password) VALUES (:nickname, :email, :password)');
        $inscription->bindParam(':nickname', $username);
        $inscription->bindParam(':email', $email);
        $inscription->bindParam(':password', $password);
        //$query = 'INSERT INTO player(nickname, email, password) VALUES ('.$username . "," .$email . ",". $password .')';
        
        $username = $_SESSION['uname'];
        $email = $_SESSION['email'];
        $password = password_hash($_SESSION['pword'], PASSWORD_DEFAULT);

        $inscription->execute();
        //saveToDb($query,null,null,false,true);
        $_SESSION["accountCreated"] = true;
        $new_url = 'login.php';
        echo "<script>window.location.replace('$new_url');</script>";
    }
}
?>

<!--#endregion -->

<body>
    <div class="container">
        <h2>Formulaire d'inscription:</h2>
        <br>

        <span class="error"><strong>* champ obligatoire</strong></span>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <!-- Affiche l'erreur dans le cas où il y en a une -->
            <?php if (isset($errorMessage)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $errorMessage ?>
                    <br><br>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-25">
                    <label for="uname">Votre nom d'utilisateur</label>
                    <br><br>
                </div>
                <div class="col-75">
                    <input type="text" id="uname" name="username" placeholder="Votre pseudo...">
                    <span class="error">* <?php echo $unameErr; ?></span>
                    <br><br>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="email">Votre Email</label>
                </div>
                <div class="col-75">
                    <input type="email" id="email" name="email" placeholder="sacha.dubourgpalette@pokemon.com">
                    <span class="error">* <?php echo $emailErr; ?></span>
                    <br><br>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="pword">Votre mot de passe</label>
                </div>
                <div class="col-75">
                    <input type="password" id="pword" name="password">
                    <span class="error">* <br><?php echo nl2br($pwordErr); ?></span>
                    <br><br>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="pword2">Confirmer votre mot de passe</label>
                </div>
                <div class="col-75">
                    <input type="password" id="pword2" name="confirm_password">
                    <span class="error">* <?php echo nl2br($confirm_passwordErr); ?></span>
                    <br><br>
                </div>
            </div>
            <br>
            <div class="row">
                <p>Vous possédez un compte ? <a href="login.php">Connectez-vous !</a></p>
                <br><br>
                <input type="submit" value="S'inscrire">
            </div>
        </form>
        <!-- <script type="text/javascript" src="register.js"></script> -->
    </div>
    <footer>
    </footer>
</body>
</html>