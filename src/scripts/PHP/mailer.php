<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/../../../vendor/autoload.php";
$mail = new PHPMailer(true);
$mail->isSMTP(true);
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
$mail->Username = "pokedex.website.sae4@gmail.com";
$mail->Password = "ldlc kevy qlan jjkh";

$mail->isHTML(true);
return $mail;