<?php
include('../db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashed_password, $_SESSION['user_id']]);
        header("Location: home.php");
        exit;
    } else {
        $error = "Les mots de passe ne correspondent pas.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modification du mot de passe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../script/app.js" defer></script>
</head>
<body>
<nav class="navbar is-primary" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="../index.php">
      Accueil
    </a>
  </div>

  <div class="navbar-menu">
    <div class="navbar-start">
    </div>

    <div class="navbar-end">
      <?php if (!isset($_SESSION['user_id'])): ?>
        <a class="navbar-item" href="login.php">Connexion</a>
        <a class="navbar-item" href="register.php">Inscription</a>
      <?php else: ?>
        <a class="navbar-item" href="password_reset.php"><?= $_SESSION['user_email'] ?></a>
         <a class="navbar-item" id="logout" href="#">Déconnexion</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

    <!-- Contenu principal -->
    <section class="section">
        <div class="container">
            <h1 class="title">Modification du mot de passe</h1>
            <?php if (isset($error)): ?>
                <div class="notification is-danger">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="field">
                    <label class="label">Nouveau mot de passe</label>
                    <div class="control">
                        <input class="input" type="password" name="new_password" required>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Confirmer le mot de passe</label>
                    <div class="control">
                        <input class="input" type="password" name="confirm_password" required>
                    </div>
                </div>
                <div class="control">
                    <button class="button is-link" type="submit">Modifier</button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>

