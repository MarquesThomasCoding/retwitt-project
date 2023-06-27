<?php 

// Récupération de la session
session_start();

// Récupération du template de connexion à la base de données
require 'database.php';

// Requête pour insérer le post dans la base de données
$add_post = $database->prepare('INSERT INTO twitts (tag, content, media,userid) VALUES (:tag, :content, :media, :userid)');
$add_post->execute(
    [
        "tag"=>"innovation",
        "content"=>"Bonjour ! Ceci est un post pré-écrit ! Vous pouvez le modifier dans le fichier postPreTwitt.php ! :)",
        "media"=>"",
        // L'identifiant du compte est fixé à 7 pour le moment, il faudra le changer par la suite
        "userid"=>"7"
    ]
);

// Redirection vers la page index
header("Location: ../index.php");
