<?php
session_start();
include("inc/connect.inc.php");

/* Verifie si la variable GET id n'est pas vide */
if(isset($_GET['id']) AND !empty($_GET['id'])){
    
    $getid = htmlspecialchars($_GET['id']);

    $maRequete= $pdo->prepare('SELECT * FROM discussion WHERE id = :id');
    $maRequete->execute([":id"=>$getid]);
    $sujet = $maRequete->fetch();


/* script d'insertion */
//stocker mes deux champs reponse et pseudo dans des variables 

    if(isset($_POST['submit_reponse'])) {
        if(isset ($_POST[ 'pseudo_reponse'], $_POST['texte_reponse']) AND !empty($_POST['pseudo_reponse']) AND !empty($_POST['texte_reponse'])) {
            $varpseudo = htmlspecialchars($_POST['pseudo_reponse' ]);
            $vartexterep = htmlspecialchars ($_POST['texte_reponse']);
            if(strlen($varpseudo)<25) {
                $insertRep = $pdo->prepare("INSERT INTO reponse (pseudo_reponse, texte_reponse, id_sujet_r) VALUES (?,?,?)");
                $insertRep->execute(array($varpseudo,$vartexterep,$getid));

            } else {
                $c_msg = "Erreur : Le pseudo doit faire moins de 25 caractères";
            }
         } else {
            $c_msg = "Erreur : Tous les champs doivent être complétés";
            }          
    }
    $vartexterep= $pdo->prepare('SELECT * FROM reponse WHERE id_sujet_r = ? ORDER BY id_rep DESC');
    $vartexterep->execute(array($getid));

    // Pour modifier le format de la date on utilise la fonction DateTime    
    $date1 = $sujet["date"];
    $dateTime1 = new DateTime($date1);

?>    
 


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
        <link rel="icon" href="img/iconForum.png" />
        <link rel="stylesheet" href="style.css">
        <title>Forum CEN - Réponses</title>
    </head>
    <body>
        <div id="titre">
            <div class="test">
                <div class="item">
                    <p>Sujet :</p>
                </div>
                <div class="item">
                    <h1><?=$sujet['intitule'] ?></h1>
                </div>
            </div>
            <div class="doubleBtn">
                <a href="afficher.php" class="button">Revenir à la liste des sujets</a>
                <a href="#repondre" class="button">Répondre au sujet</a>
            </div>
        </div>

        <div class="postSujet">
            <div class="headPostSujet">
                Auteur <span class="author"><?=$sujet['pseudo'] ?></span> le <span class="author"><?=$dateTime1->format('d M Y à H:i:s')?></span>
            </div>
            <div class="bodyPostSujet">
                <?=$sujet['texte'] ?>
            </div>
        </div>
    </body>

</html>

<?php while($c = $vartexterep->fetch()) { ?>

    <?php $date2 = $c['date_reponse'];
    $dateTime2 = new DateTime($date2); ?>

    <div class="post">
        <div class="headPost">
            Par <span class="author"><?= $c['pseudo_reponse']?></span> le <span class="author"><?= $dateTime2->format('d M Y à H:i:s')?></span>
        </div>
        

        <div class="bodyPost">
            <?= $c['texte_reponse'] ?>
        </div>

    </div>
<?php } ?>
<?php
}
?>

<div class="container">
    <h1 id="repondre">Répondre :</h1>
    <form method = "POST">
        <p class="form">Pseudo</p>
        <input type="text" id="nomRep" name="pseudo_reponse" placeholder="Saisir votre pseudo"> 
        
        <p class="form">Réponse</p>
        <?php if(isset($c_msg)) { echo $c_msg; } ?>
        <textarea name="texte_reponse" id="descrip" cols="30" rows="10" placeholder="Pour que les discussions restent agréables, nous vous remercions de rester poli en toutes circonstances. En postant sur nos espaces, vous vous engagez à en respecter la charte d'utilisation. Tout message discriminatoire ou incitant à la haine sera supprimé et son auteur sanctionné."></textarea><br> 
        
        <input type="submit" id="btnPost" value= "Envoyer ma reponse" name="submit_reponse">
    </form>
</div>


