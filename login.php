<?php session_start(); ?>
<!-- Inclusion du header -->
<?php include_once("header.html") ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script type="text/javascript" src="login.js"></script>
<script type="text/javascript" src="header.js"></script>
<style>
    <?php include("css/login.css"); ?>
</style>



<!--#region Tableau de tests utilisateurs -->

<?php
$users = [
    [
        'username' => 'Testeur',
        'email' => 'test@exemple.com',
        'password' => 'test'
    ],
];
?>
<!--#endregion -->

<!-- #region Validation du formulaire et Sécurisation et Gestion des exceptions-->
<?php

#region Sécurisation et Gestion des exceptions

$_SESSION["identifier"] = $_SESSION["pword"] = "";
$identifierErr = $emailErr = $pwordErr = "";

$length = strlen($_SESSION["identifier"]);
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["id"])) {
        $identifierErr = "Veuillez entrer un identifiant correct";
    } else {
        $_SESSION["identifier"] = test_input($_POST["id"]);
        /*        
        //Check si le nom contient seulement des lettres et espace
        // preg_match() recherche un pattern de string, et retourne vrai si le pattern existe
        if (!preg_match("/^[a-zA-Z-' ]*$/", $_SESSION["uname"])) {
            $identifierErr = "Seulement des lettres et des espaces sont autorisés";
        }
        */
    }

    if (empty($_POST["identifier"])) {
        $emailErr = "Veuillez entrer un email";
    } else {
        $_SESSION["identifier"] = test_input($_POST["identifier"]);
        /* A mettre dans l'inscription
        //Check si l'adresse est bien formulée
        if (!filter_var($_SESSION["email"], FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Email invalide";
        }*/
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

if (isset($_POST['id']) && isset($_POST['password'])) {

    foreach ($users as $user) {
        if (

            $user['email'] === $_POST['id'] || $user['username'] === $_POST['id'] &&
            $user['password'] === $_POST['password']
        ) {
            $_SESSION['LOGGED_USER'] = $user['email'];
        } else {
            $errorMessage = sprintf("L'identifiant ou le mot de passe est invalide.");
        }
    }
}
#endregion
?>

<!--#endregion -->

<body>
    <div class="container">
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
                Bonjour <?php echo $_SESSION['LOGGED_USER']; ?> et bienvenue notre PokeSite !
                <?php
                $new_url = 'index.php';
                echo "<script>window.location.replace('$new_url');</script>";
                ?>
                
            </div>
        <?php endif; ?>

        <?php
        echo "Test : ";
        echo "<br>";
        echo $_POST['id'];
        echo "<br>";
        echo $_SESSION["identifier"];
        echo "<br>";
        echo $_SESSION["pword"];
        // session_destroy();
        ?>
    </div>
    <footer>
    </footer>
</body>

</html>