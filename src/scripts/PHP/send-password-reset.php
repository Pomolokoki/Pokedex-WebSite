<?php
include_once "../../database/connection/connectSQL.php";

$email = $_POST["email"];
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);

$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$query = "UPDATE player SET reset_token_hash = ?, reset_token_expires_at = ? WHERE email = ?";
$stmt = $db->prepare($query);
$stmt->bindParam(1, $token_hash, PDO::PARAM_STR);
$stmt->bindParam(2, $expiry, PDO::PARAM_STR);
$stmt->bindParam(3, $email, PDO::PARAM_STR);
$stmt->execute();

if ($stmt->rowCount()) {
    $mail = require __DIR__ . "/mailer.php";
    $mail->CharSet = 'UTF-8';
    $mail->setFrom("noreply@pokedex.com");
    $mail->addAddress($email);
    $mail->Subject = "Réinitialisation de mot de passe";
    $mail->Body = <<<END
        <p>Bonjour,</p>
        <p>Vous avez demandé la réinitialisation de votre mot de passe pour votre compte sur Pokedex-WebSite.</p>
        <p>Pour choisir un nouveau mot de passe, veuillez cliquer sur le lien ci-dessous&nbsp;:</p>
        <p>
            <a href="http://localhost/Github/Pokedex-WebSite/src/views/reset-password.php?token=$token">
                Réinitialiser mon mot de passe
            </a>
        </p>
        <p>Si vous n'êtes pas à l'origine de cette demande, vous pouvez ignorer cet email.</p>
        <p>Cet email est généré automatiquement, merci de ne pas y répondre.</p>
    END;
    try {
        if($mail->send()){
            header("Location: ../../views/login.php?reset=success");
            exit;
        }
    } catch (Exception $e) {
        echo "votre message n'a pas pu s'envoyer. Erreur Mailer : {$mail->ErrorInfo}";
    }
}