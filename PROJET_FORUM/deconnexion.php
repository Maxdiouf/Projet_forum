<?php
session_start();
// Détruit la session 
session_destroy();
// Rediriger l'utilisateur vers la page des sujets
header('Location: afficher.php');
?>