<?php 

// Récupération de la session
session_start();

// Récupération du template de connexion à la base de données
require 'database.php';

$password = $_POST["mdp"];

//Requête pour récupérer les comptes possédant l'adresse mail et le mot de passe renseignés dans le formulaire de connexion
$accounts = $database->prepare('SELECT * FROM user WHERE mail = :mail');
$accounts->execute(
    [
        "mail"=>$_POST["mail"]
    ]
);

// Récupération du résultat de la requête

$check = $accounts->fetchAll(PDO::FETCH_ASSOC);

// Si la requête a bien renvoyé un résultat, le compte existe bien, on peut mettre les informations du compte dans la session et rediriger vers la page index
if($check == true) {
    // Vérification du mot de passe
    if(password_verify($password, $check[0]['mdp'])) {
        $_SESSION['user_id'] = $check[0]['user_id'];
        $_SESSION['nom'] = $check[0]['nom'];
        $_SESSION['pseudo'] = $check[0]['pseudo'];
        $_SESSION['email'] = $check[0]['mail'];
        $_SESSION['img'] = "imgs/avatars/".$_SESSION['user_id']."_".$check[0]['img'];
        header("Location: ../index.php");
    }
    else {
        header("Location: ../redirection.php");
    }
}

// Sinon, redirection vers la page redirection, qui affichera le message d'erreur
else {
    header("Location: ../redirection.php");
}

