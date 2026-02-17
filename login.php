<?php
require_once 'lib/config.php';
require_once 'lib/session.php';
require_once 'lib/pdo.php';
require_once 'lib/user.php';

require_once 'templates/header.php';


$errors = [];
$messages = [];

// Si le formulaire a été souis
if (isset($_POST['loginUser'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($email === '' || $password === '') {
        $errors[] = 'Email ou mot de passe manquant';
    } else {
        $user = verifyUserLoginPassword($pdo, $email, $password);
        if ($user !== false) {
            $_SESSION['user'] = $user;
            if (isset($user['role']) && $user['role'] === 'admin') {
                header('Location: admin/index.php');
                exit();
            } else {
                header('Location: index.php');
                exit();
            }
        } else {
            $errors[] = 'Email ou mot de passe incorrect';
        }
    }

  }

?>
    <h1>Login</h1>

    <?php // @todo afficher les erreurs avec la structure suivante :
        /*
        <div class="alert alert-danger" role="alert">
            Utilisatuer ou mot de passe incorrect
        </div>
        */
    ?>
        <?php foreach ($errors as $error) { ?>
            <div class="alert alert-danger" role="alert">
                <?= $error; ?>
            </div>
        <?php } ?>

    <form method="POST">
        <div class="mb-3">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de psse</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <input type="submit" name="loginUser" class="btn btn-primary" value="Enregistrer">

    </form>

    <?php
require_once 'templates/footer.php';
?>