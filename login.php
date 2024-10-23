<?php
include('../db.php');
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: password_reset.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        header("Location: password_reset.php");
        exit;
    } else {
        $error = "Identifiants incorrects";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="./script/app.js" defer></script>
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
            <h1 class="title">Connexion</h1>
            <?php if (isset($error)): ?>
                <div class="notification is-danger">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="field">
                    <label class="label">Adresse email</label>
                    <div class="control">
                        <input class="input" type="email" name="email" required>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Mot de passe</label>
                    <div class="control">
                        <input class="input" type="password" name="password" required>
                    </div>
                </div>
                <div class="control">
                    <button class="button is-link" type="submit">Se connecter</button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>
