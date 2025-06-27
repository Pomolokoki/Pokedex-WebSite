<?php
include_once '../database/connection/connectSQL.php';
include_once "header.php";

$token = $_GET["token"];
$token_hash = hash("sha256", $token);

$query = "SELECT * FROM player WHERE reset_token_hash = :tokenhash";
$stmt = $db->prepare($query);
$stmt->bindParam(':tokenhash', $token_hash);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$result || $result === null) {
    die("<div class='container'><div class='alert alert-danger'>Le token n'a pas été trouvé.</div></div>");
}
if (strtotime($result["reset_token_expires_at"]) <= time()) {
    die("<div class='container'><div class='alert alert-danger'>Le token est expiré.</div></div>");
}

$success = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'], $_POST['password_confirm'])) {
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $passwordBool = true;
    $error = '';
     if (empty($password) || empty($password_confirm)) {
        $error .= 'Entrer votre mot de passe et sa confirmation.' . "\n";
        $passwordBool = false;
    }
    if ($password !== $password_confirm) {
        $error .= '- Les mots de passe ne correspondent pas.' . "\n";
        $passwordBool = false;
    }
    if (strlen($password) <= 8) {
        $error .= '- Votre mot de passe doit contenir au minimum 8 caractères.' . "\n";
        $passwordBool = false;
    }
    if (!preg_match('#[0-9]+#', $password)) {
        $error .= '- Votre mot de passe doit contenir au minimum un nombre.' . "\n";
        $passwordBool = false;
    }
    if (!preg_match('#[A-Z]+#', $password)) {
        $error .= '- Votre mot de passe doit contenir au minimum une majuscule.' . "\n";
        $passwordBool = false;
    }
    if (!preg_match('#[a-z]+#', $password)) {
        $error .= '- Votre mot de passe doit contenir au minimum une minuscule.' . "\n";
        $passwordBool = false;
    }
    elseif ($password !== $password_confirm) {
        $error = "Les mots de passe ne correspondent pas.";
    } 
    if ($passwordBool) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $update = $db->prepare("UPDATE player SET password = :password, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE id = :id");
        $update->bindParam(':password', $password_hash);
        $update->bindParam(':id', $result['id']);
        $update->execute();
        $success = true;
    }
}
?>

<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet'>
<style>
    <?php include '../style/CSS/login.css'; ?>
</style>

<body>
    <div class="container">
        <h2>Réinitialisation du mot de passe</h2>
        <?php if ($success): ?>
            <div class="alert alert-success" role="alert">
                Votre mot de passe a été réinitialisé avec succès.<br>
                <a href="login.php">Retour à la connexion</a>
            </div>
        <?php else: ?>
            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo nl2br(htmlspecialchars($error)); ?>
                </div>
            <?php endif; ?>
            <form method="POST" autocomplete="off">
                <div class="row">
                    <div class="col-25">
                        <label for="password">Nouveau mot de passe</label>
                    </div>
                    <div class="col-75">
                        <input type="password" id="password" name="password" required placeholder="Nouveau mot de passe">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="password_confirm">Confirmer le mot de passe</label>
                    </div>
                    <div class="col-75">
                        <input type="password" id="password_confirm" name="password_confirm" required placeholder="Confirmez le mot de passe">
                    </div>
                </div>
                <br>
                <div class="row">
                    <input type="submit" value="Réinitialiser le mot de passe" class="btn btn-primary">
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>