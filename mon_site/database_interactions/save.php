<?php 

// Récupération de la session
session_start();

// Récupération du template de connexion à la base de données
require 'database.php';

// Vérification si le twitt est déjà enregistré par l'utilisateur

$check_post = $database->prepare('SELECT * FROM saved WHERE user_id = :user_id AND twitt_id = :tweet_id');
$check_post->execute(
    [
        "user_id"=>$_SESSION["user_id"],
        "tweet_id"=>$_POST["id"]
    ]
);

$check_post = $check_post->fetchAll(PDO::FETCH_ASSOC);

// Si le twitt est déjà enregistré, on le supprime de la bdd

if(count($check_post) > 0){
    $delete_post = $database->prepare('DELETE FROM saved WHERE user_id = :user_id AND twitt_id = :tweet_id');
    $delete_post->execute(
        [
            "user_id"=>$_SESSION["user_id"],
            "tweet_id"=>$_POST["id"]
        ]
    );
    header("Location: ../index.php");
    exit();
}

// Sinon, on l'ajoute du twitt enregistré à la bdd

else {
    $add_post = $database->prepare('INSERT INTO saved (user_id, twitt_id) VALUES (:user_id, :tweet_id)');
    $add_post->execute(
        [
            "user_id"=>$_SESSION["user_id"],
            "tweet_id"=>$_POST["id"]
        ]
    );

    header("Location: ../index.php");
    exit();
}