<?php
include('../db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Récupérer la liste des utilisateurs inscrits
$stmt = $pdo->query("SELECT email FROM users");
$users = $stmt->fetchAll();

// Récupérer les publications de tous les utilisateurs
$stmt = $pdo->query("SELECT p.message, p.created_at, u.email FROM publications p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC");
$publications = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil connecté</title>
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
      <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
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
            <!-- Liste des utilisateurs inscrits -->
            <h1 class="title">Utilisateurs inscrits</h1>
            <ul>
                <?php foreach ($users as $user): ?>
                    <li><a href="publications.php?email=<?= urlencode($user['email']) ?>"><?= htmlspecialchars($user['email']) ?></a></li>
                <?php endforeach; ?>
            </ul>

            <!-- Formulaire de publication -->
            <h2 class="subtitle">Publier un nouveau message</h2>
            <form method="POST" action="post_message.php">
                <div class="field">
                    <label class="label">Nouveau message</label>
                    <div class="control">
                        <textarea class="textarea" name="message" required></textarea>
                    </div>
                </div>
                <div class="control">
                    <button class="button is-link" type="submit">Publier</button>
                </div>
            </form>

            <!-- Liste des publications -->
            <h2 class="subtitle">Messages publiés</h2>
            <ul>
                <?php foreach ($publications as $publication): ?>
                    <li>
                        <strong><?= htmlspecialchars($publication['email']) ?></strong> le <?= $publication['created_at'] ?><br>
                        <?= nl2br(htmlspecialchars($publication['message'])) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
</body>
</html>
