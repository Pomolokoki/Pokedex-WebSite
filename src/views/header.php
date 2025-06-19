<?php
session_start();
include_once __DIR__ . '/../database/connection/connectSQL.php';
?>

<!DOCTYPE html>
<html lang='fr'>

<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <link rel='stylesheet' href='../style/CSS/header.css'>
  <script src='../scripts/JS/header.js' defer></script>
  <script src='../scripts/JS/profile.js' defer></script>
  <title>PokeKrazy</title>
</head>

<?php
if (isset($_SESSION['LOGGED_USER'][0]['picture'])) {
  $profilePictureUser = $_SESSION['LOGGED_USER'][0]['picture'];
  $user_id = $_SESSION['LOGGED_USER'][0]['id'];
}

if (isset($_FILES['image'])) {
  $file_name = $_FILES['image']['name'];
  $file_tmpName = $_FILES['image']['tmp_name'];
  $file_error = $_FILES['image']['error'];
  $upload_dir = '../../uploads/';
  if (!is_dir($upload_dir)) mkdir($upload_dir);
  $file_destination = $upload_dir . $file_name;
  if ($file_error === 0 && move_uploaded_file($file_tmpName, $file_destination)) {
    $updateSQL = 'UPDATE player SET picture = :picture WHERE id = :id';
    $stmt = $db->prepare($updateSQL);
    $stmt->execute([
      ':picture' => $file_destination,
      ':id' => $user_id
    ]);
    $_SESSION['LOGGED_USER'][0]['picture'] = $file_destination;
  }
}
?>

<header id="header">
  <div class="header-top">
    <div class="header-logo">
      <img src="../../public/img/PokeLogov3.png" alt="Logo Pokedex">
    </div>
    <div class="header-login">
      <?php if (!isset($_SESSION['LOGGED_USER'])): ?>
        <button class="connexion-btn" id="Login">Connexion</button>
      <?php else: ?>
        <div id="myPage" style="cursor: pointer;">
          <img src="<?= htmlspecialchars($profilePictureUser) ?>" alt="Profile Picture" id="profilePicture">
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="header-nav">
    <a href="Pokedex.php" class="nav-btn">Pokedex</a>
    <a href="typeTable.php" class="nav-btn">Types</a>
    <a href="map.php" class="nav-btn">Maps</a>
    <a href="pokemonMove.php" class="nav-btn">Attaques</a>
    <a href="items.php" class="nav-btn">Objets</a>
  </div>
</header>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const loginBtn = document.getElementById("Login");
    if (loginBtn) {
      loginBtn.addEventListener("click", () => {
        window.location.href = "login.php"; 
      });
    }

    const profile = document.getElementById("myPage");
    if (profile) {
      profile.addEventListener("click", () => {
        window.location.href = "profile.php";
      });
    }
  });
</script>

</html>
