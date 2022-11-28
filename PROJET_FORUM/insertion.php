<?php

include("inc/connect.inc.php");
/* Script d'insertion */
// Je prépare la requête pour l'insertion des sujets dans la table discussion
$maRequete = $pdo->prepare("INSERT INTO discussion VALUES(NULL, :pseudo, :intitule, :texte, NULL)");
// On lie chaque marqueur à une valeur
$maRequete->bindValue(":pseudo", $_POST["name"]);
$maRequete->bindValue(":intitule", $_POST["sujet"]);
$maRequete->bindValue(":texte", $_POST["reponse"]);
// Exécuter la requête
$maRequete->execute();
// Rediriger l'utilisateur vers la page des sujets
header('Location: afficher.php');

?>
