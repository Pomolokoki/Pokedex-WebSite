<?php session_start(); 
include_once("database/connectSQL.php");
?>
<!-- Inclusion du header -->
<?php include_once("header.html") ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script type="text/javascript" src="login.js"></script>
<script type="text/javascript" src="header.js"></script>
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

    while($row = $parcoursPlayerTable->fetch()){
        if($row['nickname'] === $_POST["id"] || $row['email'] === $_POST['id']){
            if(password_verify($_POST['password'],$row['password'])){
                // $_SESSION["LOGGED_USER"] = $row['email'];
                $emailDB = $row['email'];
                $idForm = $_POST['id'];
                $sql = "SELECT email FROM player WHERE (? = ?)";
                $stmt = $db->prepare($sql);
                $stmt->execute([$emailDB,$idForm]);
                $_SESSION["LOGGED_USER"] = $row['email'];
            }
        }
        else{
            $errorMessage = sprintf("L'identifiant ou le mot de passe est invalide.");
            echo $row['email'];            
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
                $new_url = 'pokedex.php';
                echo "<script>window.location.replace('$new_url');</script>";
                ?>
                
            </div>
        <?php endif; ?>
        <?php 
            session_destroy();
        ?>
    </div>
    <footer>
    </footer>
</body>

</html>