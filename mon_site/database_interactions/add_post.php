<?php 

// Récupération de la session
session_start();

// Récupération du template de connexion à la base de données
require 'database.php';

// Récupération du nom du fichier sauvegardé par le formulaire
$filename = $_FILES["media"]["name"];
$name = $_FILES["media"]["tmp_name"];
// Récupération de sa taille
$filesize = filesize($name);

// Si la taille du fichier est bien inférieure ou égale à 2Mo
if($filesize <= 20000000) {
    // on ajoute le fichier dans le dossier imgs/medias avec comme nom : [Identifiant de l'utilisateur]+[Nom du fichier]
    move_uploaded_file($_FILES["media"]["tmp_name"], "../imgs/medias/".$_SESSION['user_id']."_".$filename);

    // Requête pour insérer le post dans la base de données
    $add_post = $database->prepare('INSERT INTO twitts (tag, content, media,userid) VALUES (:tag, :content, :media, :userid)');
    $add_post->execute(
        [
            "tag"=>$_POST["tags-select"],
            "content"=>$_POST["twitt-content"],
            "media"=>$filename,
            "userid"=>$_POST["user_id"]
        ]
    );
}

// Redirection vers la page index
header("Location: ../index.php");