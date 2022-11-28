<?php
session_start();
include("inc/connect.inc.php");

/* Lister les sujets */
// Je prépare ma requête pour selectionner toute ma table discussion
$maRequete = $pdo->prepare("SELECT * FROM discussion");
// Exécuter la requête 
$maRequete->execute();
// Je récupère les résultats dans la variable sujets
$sujets = $maRequete->fetchAll();

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
        <title>Forum CEN - Liste des sujets</title>
    </head>

    <body>
        <h1>Liste des sujets</h1>
        <div class="admin">
            <a href="login.php"><img src="img/iconAdmin.png" id="iconAdmin"></a>
            <!-- Si la session admin est connecté alors j'affiche le bouton Deconnexion -->
            <?php if(isset($_SESSION['connecte'])) {
                echo '<a href="deconnexion.php"><img src="img/iconDeconnexion.png" id="iconDeconnexion"></a>';
            } ?>
        </div>
            
        <table>
            <thead>
                <tr>
                    <th>Sujet</th>
                    <th>Auteur </th>
                    <th>Date de création</th>
                    <th>Nb de reponse</th>
                    <!-- Si la session admin est connecté alors j'affiche le titre supprimer sur le tableau -->
                    <?php if(isset($_SESSION['connecte'])) {
                        echo '<th>Supprimer</th>';
                    } ?>
                </tr>
            </thead>
            <tbody>
                <!-- Cette boucle va permettre d'afficher tout les champs de ma table discussion -->
                <?php foreach($sujets as $sujet): ?>
                    <!-- La préparation de la requête suivante est pour afficher le nb de réponse dans chaque sujet -->
                    <?php $id = $sujet["id"];
                    // Je prépare ma requête pour selectionner les id de ma table discussion identique à celle de la table réponse
                    $maRequete2 = $pdo->prepare("SELECT * FROM reponse WHERE id_sujet_r = :id");
                    // Exécuter la requête 
                     $maRequete2->execute([":id" => $id ]);
                    // Je récupère les résultats dans la variable nbReb 
                    $nbRep = $maRequete2->fetchAll(); 
                    // Pour modifier le format de la date on utilise la fonction DateTime
                    $date = $sujet["date"];
                    $dateTime = new DateTime($date);
                    ?>

                    <tr>
                        <!-- Récupère le id du sujet pour afficher sa page unique -->
                        <td><a href="reponse.php?id=<?= $sujet["id"]?>"><?= $sujet["intitule"]?></a></td>
                        <td><?= $sujet["pseudo"]?></td>
                        <td><?= $dateTime->format('d/m/Y')?></td>
                        <!-- Compte le nombre d'élément dans la variable nbRep grâce à count -->
                        <?php echo '<td>'.count($nbRep).'</td>';?>
                        <!-- Si la session admin est connecté alors j'affiche le bouton supprimer sur le tableau -->
                        <?php if(isset($_SESSION['connecte'])) {
                            echo '<td><a href="supprimer.php?id='.$sujet["id"].'"><img src="img/delete.png" class="deleteImage"></a></td>'; 
                        } ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="container">
            <h1>Nouveau sujet</h1>
            <!-- Formulaire de saisie pour ajouter un nouveau sujet -->
            <form action="insertion.php" method="POST">
                <div class="formDiv">
                    <p class="form">Pseudo</p>
                    <input type="text" id="pseudo" name="name" placeholder="Saisir votre pseudo">
                    
                    <p class="form">Intitule</p>
                    <input type="text" id="intitule" name="sujet" placeholder="Saisir le titre du sujet">
                    
                    <p class="form">Texte</p>
                    <textarea id="texte" name="reponse" cols="30" rows="10" placeholder="Pour que les discussions restent agréables, nous vous remercions de rester poli en toutes circonstances. En postant sur nos espaces, vous vous engagez à en respecter la charte d'utilisation. Tout message discriminatoire ou incitant à la haine sera supprimé et son auteur sanctionné."></textarea>
                    
                    <input type="submit" id="btnPost" value="Poster">
                </div>
            </form>
        </div>
    </body>
</html>


