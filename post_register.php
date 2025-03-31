<?php session_start(); 
include_once 'database/connectSQL.php';


$_SESSION['uname'] = $_SESSION['email'] = $_SESSION['pword'] = '';
$unameErr = $emailErr = $pwordErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (empty($_POST['username'])) {
        $unameErr = 'Veuillez entrer un pseudo correct';
    } else {
        $_SESSION['uname'] = test_input($_POST['username']);
        /*Check si le nom contient seulement des lettres et espace
        preg_match() recherche un pattern de string, et retourne vrai si le pattern existe */
        if (!preg_match('/^[a-zA-Z-\' ]*$/', $_SESSION['uname'])) {
            $identifierErr = 'Seulement des lettres et des espaces sont autorisés';
        }
        
    }
    if (empty($_POST['email'])) {
        $emailErr = 'Veuillez entrer un email correct';
    } else {
        $_SESSION['email'] = test_input($_POST['email']);
        /* A mettre dans l'inscription
        Check si l'adresse est bien formulée*/
        if (!filter_var($_SESSION['email'], FILTER_VALIDATE_EMAIL)) {
            $emailErr = 'Email invalide';
        }
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
?>

<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet'>
<style>
    <?php include('css/register.css'); ?>
</style>

<?php 
#region Validation du formulaire -->
if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])){
    $inscription = $db ->prepare('INSERT INTO player(nickname, email, password) VALUES (:nickname, :email, :password)');
    $inscription -> bindParam(':nickname',$username);
    $inscription -> bindParam(':email',$email);
    $inscription -> bindParam(':password', $password);

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $inscription->execute();   

}
else{
    echo $_POST['username'];    
}

?>