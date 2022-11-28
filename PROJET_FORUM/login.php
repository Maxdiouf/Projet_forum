<?php
session_start();
// Creer 2 variables qui sont associé avec l'id du formulaire des 2 inputs
$login = filter_input(INPUT_POST, "login");
$password = filter_input(INPUT_POST, "password");

// Si les valeurs des 2 inputs sont admin alors on peut se connecter
if($login == "admin" && $password == "admin") {
    $_SESSION["connecte"] = true;
    // Rediriger l'utilisateur vers la page des sujets
    header('Location: afficher.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="icon" href="img/iconForum.png" />
    <link rel="stylesheet" href="style.css">
    <title>Connexion session administrateur</title>
</head>

<body>
    <h1>Connexion à la session administrateur</h1>
    <div class="coBtn">
        <a href="afficher.php" class="button">Revenir à la liste des sujets</a>
    </div>
    <!-- Formulaire de saisie pour se connecter à la session admin -->
    <form method="POST">
        <p class="form">Identifiant :</p>
        <input type="text" name="login" id="login" placeholder="Identifiant"><br/>
        
        <p class="form">Mot de passe :</p>
        <input type="password" name="password" id="password" placeholder="Mot de passe"><br/>
        
        <input type="submit" id="btnPost" value="Se connecter">
    </form>
</body>
</html>