<?php 

// Récupération de la session
session_start();

// Récupération du template de connexion à la base de données
require 'database.php';

//Requête pour récupérer le twitt concerné par la suppression
$twitt = $database->prepare('SELECT * FROM twitts WHERE id=:id');
$twitt->execute(
    [
        "id"=>$_POST["id"]
    ]
);

$media = $twitt->fetchAll(PDO::FETCH_ASSOC);

// On supprime le media du post de l'ordinateur
$filename = "../imgs/medias/".$_SESSION['user_id'].$media[0]['media'];
unlink($filename);

// On supprime le post de la base de données
$del_post = $database->prepare('DELETE FROM twitts WHERE id=:id');
$del_post->execute(
    [
        "id"=>$_POST["id"]
    ]
);

// Redirection vers la page index
header("Location: ../index.php");