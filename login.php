<?php
session_start();
?>

<!--#region Html head -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-control" content="no-cache">
    <link rel="stylesheet" href="css/login.css">
    <script src="scripts/header.js" defer></script>
    <script src="scripts/login.js" defer></script>
    <title>PokeKrazy</title>
</head>
<!--#endregion -->

<!-- Inclusion du header -->
<?php include_once("header.html") ?>

<!--#region Tableau de tests utilisateurs -->

<?php
$users = [
    [
        'username' => 'Bawa',
        'email' => 'bawahm@exemple.com',
        'password' => 'bawa'
    ],
];
?>
<!--#endregion -->

<!-- #region Validation du formulaire et sécurisation-->
<?php
$_SESSION["identifier"] = $_SESSION["pword"] = "";
$identifierErr = $emailErr = $pwordErr = "";

$length = strlen($_SESSION["identifier"]);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    for ($i=0; $i < $length ; $i++) {
        if (empty($_POST["identifier"])) {
            $identifierErr = "Veuillez entrer un identifiant correct";
        }        
        elseif($_POST["indentifier"][$i] === "@"){
            $identifierErr = "balls";
        }       
    }

    if (empty($_POST["identifier"])) {
        $identifierErr = "Veuillez entrer un identifiant correct";
    } 
    // else{
    //     $_SESSION["identifier"] = test_input($_POST["identifier"]);
    //     //Check si le nom contient seulement des lettres et espace
    //     // preg_match() recherche un pattern de string, et retourne vrai si le pattern existe
    //     if (!preg_match("/^[a-zA-Z-' ]*$/", $_SESSION["uname"])) {
    //         $identifierErr = "Seulement des lettres et des espaces sont autorisés";
    //     }
    // }

    // if (empty($_POST["identifier"])) {
    //     $emailErr = "Veuillez entrer un email";
    // } 
    // else {
    //     $_SESSION["email"] = test_input($_POST["email"]);
    
    
    //     /* A mettre dans l'inscription
    //     //Check si l'adresse est bien formulée
    //     if (!filter_var($_SESSION["email"], FILTER_VALIDATE_EMAIL)) {
    //         $emailErr = "Email invalide";
    //     }*/
    // }

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

if (isset($_POST['email']) && isset($_POST['password'])) {
    foreach ($users as $user) {
        if (
            $user['email'] === $_POST['email'] &&
            $user['password'] === $_POST['password']
        ) {
            $_SESSION['LOGGED_USER'] = $user['email'];
        } else {
            $errorMessage = sprintf("L'email ou le mot de passe est invalide.");
        }
    }
}

?>
<!--#endregion -->

<body>
    <div class="container">
        <?php if (!isset($_SESSION['LOGGED_USER'])): ?>
            <h1>Connexion a votre compte:</h1>
            <br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" autocomplete="off">
                <!-- Affiche l'erreur dans le cas où il y en a une -->
                <?php if (isset($errorMessage)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $errorMessage ?>
                        <br><br>
                    </div>
                <?php endif; ?>
                <!--
                <div class="row">
                    <div class="col-25">
                        <label for="fname">Votre nom d'utilisateur</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="uname" name="username" placeholder="Votre pseudo...">
                        <span class="error">* <?/*php echo $unameErr; */?></span>
                        <br><br>
                    </div>
                </div>
                 -->
                <div class="row">
                    <div class="col-25">
                        <label for="lname">Votre Email ou nom d'utilisateur</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="identifier" name="identifier" placeholder="sacha.dubourgpalette@pokemon.com">
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
            </div>
        <?php endif; ?>

        <?php
        echo "Test : ";
        echo "<br>";
        echo $_SESSION["uname"];
        echo "<br>";
        echo $_SESSION["email"];
        echo "<br>";
        echo $_SESSION["pword"];
        ?>

    </div>
    <?php if (isset($_SESSION['LOGGED_USER'])): ?>
        <?php 
            echo 'edfhg';
        ?>
    <?php endif; ?>
    <footer>
    </footer>
</body>

</html>