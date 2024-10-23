<?php
include('../db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['email'])) {
    header("Location: home.php");
    exit;
}

$email = $_GET['email'];

// Récupérer l'ID de l'utilisateur à partir de son email
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    header("Location: home.php");
    exit;
}

// Récupérer les publications de l'utilisateur
$stmt = $pdo->prepare("SELECT message, created_at FROM publications WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user['id']]);
$publications = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Publications de <?= htmlspecialchars($email) ?></title>
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
            <h1 class="title">Publications de <?= htmlspecialchars($email) ?></h1>
            <ul>
                <?php foreach ($publications as $publication): ?>
                    <li>
                        <strong>Publié le <?= $publication['created_at'] ?></strong><br>
                        <?= nl2br(htmlspecialchars($publication['message'])) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
</body>
</html>
