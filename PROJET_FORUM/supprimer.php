<?php
// Supprimer un sujet avec un identifiant (en GET, sous la forme ?id=1)
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
// Requête pour supprimer
if($id) {
    include("inc/connect.inc.php");
    // Etape 1 : Je prépare ma requête
    $maRequete = $pdo->prepare("DELETE FROM discussion WHERE id = :id");
    // Etape 2 : J'exécute ma requête
    $maRequete->execute([":id" => $id]);
    // Pas d'étape 3, parce qu'on ne fait pas de SELECT
}
// Rediriger l'utilisateur vers la page des sujets
header('Location: afficher.php');
exit(); 
