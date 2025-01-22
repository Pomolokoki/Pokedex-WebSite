<!-- Inclusion du header -->
<?php include_once("header.php");
include_once("database/connectSQL.php");
include_once("./database/extractDataFromDb.php");

$dataPokemonFav = getDataFromDB("SELECT pokemon.name as pokemonName, pokemon.spriteM as pokemonSprite, pokemon.id as pokemonId FROM pokemon INNER JOIN player_favorites ON pokemon.id = pokemonId and playerId = $user_id", null, null, true);
$dataPokemonCatch = getDataFromDB("SELECT pokemon.name as pokemonName, pokemon.spriteM as pokemonSprite, pokemon.id as pokemonId FROM pokemon INNER JOIN player_pokemon ON pokemon.id = pokemonId and playerId = $user_id", null, null, true);
?>
<!DOCTYPE html>
<html lang="fr">

<meta name="viewport" content="width=device-width, initial-scale=1.0" charset="UTF-8">
<title>Profil Utilisateur</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    <?php include("css/profile.css"); ?>
</style>

<body>
    <!-- #region Validation du formulaire et Sécurisation et Gestion des exceptions-->
    <div id="ID_User"><?php $_SESSION["LOGGED_USER"][0]["id"] ?></div>

    <?php
    if (!isset($_SESSION['LOGGED_USER'])) {
        header("Location: login.php");
        exit();
    }

    $username = $_SESSION['LOGGED_USER'][0]['nickname'];
    $email = $_SESSION['LOGGED_USER'][0]['email'];
    $user_id = $_SESSION['LOGGED_USER'][0]['id'];
    $success_message = '';
    $error_message = '';
    #region Validation du formulaire -->
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
        $new_username = trim($_POST['new_username']);
        $new_email = trim($_POST['new_email']);
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        $errors = [];

        if (empty($new_username)) {
            $errors[] = "Le pseudo ne peut pas être vide";
        } elseif (!preg_match("/^[a-zA-Z0-9-' ]*$/", $new_username)) {
            $errors[] = "Le pseudo ne peut contenir que des lettres, chiffres et espaces";
        }

        if (empty($new_email)) {
            $errors[] = "L'email ne peut pas être vide";
        } elseif (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Format d'email invalide";
        }

        if ($new_username !== $username || $new_email !== $email) {
            $stmt = $db->prepare("SELECT nickname, email,password FROM player WHERE (nickname = :nickname OR email = :email) AND id != :id");
            $stmt->execute([
                ':nickname' => $new_username,
                ':email' => $new_email,
                ':id' => $user_id
            ]);

            while ($row = $stmt->fetch()) {
                if ($row['nickname'] === $new_username) {
                    $errors[] = "Ce pseudo est déjà pris";
                }
                if ($row['email'] === $new_email) {
                    $errors[] = "Cet email est déjà utilisé";
                }
                if (!password_verify($current_password, $row['password'])) {
                    $errors[] = "Le mot de passe actuel est incorrect";
                }
            }
        }

        if (!empty($new_password) || !empty($confirm_password)) {
            if (empty($current_password)) {
                $errors[] = "Le mot de passe actuel est requis pour changer de mot de passe";
            }
            if ($new_password !== $confirm_password) {
                $errors[] = "Les nouveaux mots de passe ne correspondent pas";
            }
            if (strlen($new_password) < 8) {
                $errors[] = "Le nouveau mot de passe doit contenir au moins 8 caractères";
            }
        }

        // Update le profil si pas d'erreur
        if (empty($errors)) {
            try {
                $db->beginTransaction();

                $updateSQL = "UPDATE player SET nickname = :nickname, email = :email";
                $params = [
                    ':nickname' => $new_username,
                    ':email' => $new_email,
                    ':id' => $user_id
                ];

                if (!empty($new_password)) {
                    $updateSQL .= ", password = :password";
                    $params[':password'] = password_hash($new_password, PASSWORD_DEFAULT);
                }

                $updateSQL .= " WHERE id = :id";
                $stmt = $db->prepare($updateSQL);
                $stmt->execute($params);

                $db->commit();

                $_SESSION['LOGGED_USER'][0]['nickname'] = $new_username;
                $_SESSION['LOGGED_USER'][0]['email'] = $new_email;

                $success_message = "Profil mis à jour avec succès!";
                $username = $new_username;
                $email = $new_email;
            } catch (Exception $e) {
                $db->rollBack();
                $error_message = "Une erreur est survenue lors de la mise à jour du profil";
            }
        } else {
            $error_message = implode("<br>", $errors);
        }
    }
    #endregion
    ?>
    <!--#endregion -->
    <!-- #region Affichage du profil -->
    <div class="container-fluid py-5">
        <div class="row align-items-start">
            <div class="col align-items-start">
                <!-- #region Profil -->
                <div class="col-12 col-lg-15">
                    <div class="card shadow">
                        <div class="card-body">
                            <?php if ($success_message): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?php echo htmlspecialchars($success_message); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    
                                </div>
                            <?php endif; ?>
    
                            <div class="text-center mb-4">
                                <div class="profile-avatar mb-3">
                                    <!-- <i class="fas fa-user"></i> -->
                                    <form action="profile.php" method="POST" enctype="multipart/form-data">
                                        <label for="fileImage" class="position-relative" style="cursor: pointer;">
                                            <img src="<?php echo htmlspecialchars($profilePictureUser) ?>" alt=""
                                                id="output">
                                            <i class="fas fa-edit me-2 profile-edit" aria-hidden="true"
                                                id="profile-pic"></i>
                                            <input type="file" name="image" id="fileImage" style="display: none;"
                                                accept="image/*">
                                            <button type="submit" name="submitImage" style="display: none;"
                                                id="submitButton">Test</button>
                                        </label>
                                    </form>
                                </div>
                                <!-- <i class="fa fa-pencil-square" aria-hidden="true"></i> -->
    
                                <h2 class="card-title">Profil de <?php echo htmlspecialchars($username); ?></h2>
                            </div>
    
                            <div class="row g-3 mb-3">
                                <div class="col-20 col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-muted">Pseudo : </h6>
                                            <p class="card-text"><?php echo htmlspecialchars($username); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-20 col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-muted">Email : </h6>
                                            <p class="card-text" id="email"><?php echo htmlspecialchars($email); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-20 col-md-12">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-muted">Thème du header : </h6>
                                            <p class="list-group">
                                                <button class="list-group-item list-group-item-action">Team Magma</button>
                                                <button class="list-group-item list-group-item-action">Team Aqua</button>
                                                <button class="list-group-item list-group-item-action">Team Plasm</button>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <button class="btn btn-primary me-md-2" data-bs-toggle="modal"
                                    data-bs-target="#editProfileModal">
                                    <i class="fas fa-edit me-2"></i>Modifier le profil
                                </button>
                                <a href="logout.php" class="btn btn-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #endregion -->                
                <div class="col align-items-start">
                <!-- #region Pokemon Capturés -->
                <div class="col-auto col-xs-auto col-lg-15">
                    <div class="card shadow mt-4">
                        <div class="card-body">
                            <h5 class="card-title text-center">Pokémon capturés</h5>
                            <div class="row g-3">
                            <?php if(isset($dataPokemonCatch)  && $dataPokemonCatch != "No results found."):?>
                                <?php for ($i = 0; $i < count($dataPokemonCatch); $i++): ?>
                                    <div class="col-auto col-xs-auto col-md-auto col-lg-auto">
                                        <div class="card h-100">
                                            <div class="card-body pokemonCatch">
                                                <p class="card-text">
                                                    <img class="pokemon" data-id="<?php echo $dataPokemonCatch[$i]["pokemonId"]?>" src="<?php echo $dataPokemonCatch[$i]["pokemonSprite"] ?>" alt="">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- endregion -->
            </div>
            
            </div>
            <!-- #region Pokemon Favoris -->
            <div class="col align-items-start">
                <div class="col-12 col-lg-15">
                    <div class="card shadow mt-4">
                        <div class="card-body">
                            <h5 class="card-title text-center">Pokémon favoris</h5>
                            <div class="row g-3">
                            <?php if(isset($dataPokemonFav)  && $dataPokemonFav != "No results found."):?>
                            <?php for ($i = 0; $i < count($dataPokemonFav); $i++): ?>
                                    <div class="col-auto col-xs-auto col-sm-auto col-md-auto col-lg-auto">        
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <p class="card-text">
                                                    <img class="pokemon" data-id="<?php echo $dataPokemonFav[$i]["pokemonId"]?>" src="<?php echo $dataPokemonFav[$i]["pokemonSprite"]?>" alt="">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- endregion -->
        </div>        
    </div>
    <!--#endregion -->

    <!-- #region Édition du profil -->

    <div class="modal fade" id="editProfileModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier le profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php if ($error_message): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="new_username" class="form-label">Nouveau pseudo</label>
                            <input type="text" class="form-control" id="new_username" name="new_username"
                                value="<?php echo htmlspecialchars($username); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="new_email" class="form-label">Nouvel email</label>
                            <input type="email" class="form-control" id="new_email" name="new_email"
                                value="<?php echo htmlspecialchars($email); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mot de passe actuel</label>
                            <input type="password" class="form-control" id="current_password" name="current_password">
                            <div class="form-text">Requis pour changer le mot de passe</div>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" class="form-control" id="new_password" name="new_password">
                            <div class="form-text">Laisser vide pour ne pas changer</div>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmer le nouveau mot de passe</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="update_profile" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Sauvegarder les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--#endregion -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="scripts/profile.js"></script>
    <script>
        // Affiche l'édition du profil en cas d'erreur
        <?php if ($error_message): ?>
            document.addEventListener('DOMContentLoaded', function() {
                new bootstrap.Modal(document.getElementById('editProfileModal')).show();
            });
        <?php endif; ?>
    </script>
</body>



</html>