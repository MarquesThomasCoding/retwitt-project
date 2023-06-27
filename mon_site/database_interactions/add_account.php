<?php 

// Récupération de la session
session_start();

// Récupération du template de connexion à la base de données
require 'database.php';

// Vérification de l'existence du compte lors de l'inscription

// Requête pour récupérer les comptes avec la même adresse mail que celle renseignée
$account_exist = $database->prepare('SELECT * FROM user WHERE mail = :mail');
$account_exist->execute(
    [
        "mail"=>$_POST["email"]
    ]
);

$check=$account_exist->fetchAll(PDO::FETCH_ASSOC);

// S'il n'y a pas de compte avec la même adresse mail
if($check == false) {

    // Récupération du nom du fichier sauvegardé par le formulaire
    $filename = $_FILES["avatar"]["name"];
    $name = $_FILES["avatar"]["tmp_name"];
    // Récupération de sa taille
    $filesize = filesize($name);

    if($filesize <= 20000000) {
        // Hashage du mot de passe
        $password = $_POST["mdp"];
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Requête pour insérer dans la base de données le compte avec les informations renseignées par l'utilisateur
        $add_account = $database->prepare('INSERT INTO user (pseudo, nom, mail, mdp, img) VALUES (:pseudo, :nom, :mail, :mdp, :img)');
        $add_account->execute(
            [
                "pseudo"=>$_POST["pseudo"],
                "nom"=>$_POST["nom"],
                "mail"=>$_POST["email"],
                "mdp"=>$password_hash,
                "img"=>$filename,
            ]
        );
    }

    // Récupération du compte nouvellement créé
    $recup_account = $database->prepare('SELECT * FROM user WHERE mail = :mail');
    $recup_account->execute(
        [
            "mail"=>$_POST['email']
        ]
    );

    $account=$recup_account->fetchAll(PDO::FETCH_ASSOC);

    // Ajout des informations du compte dans la session
    $_SESSION['user_id'] = $account[0]['user_id'];
    $_SESSION['nom'] = $account[0]['nom'];
    $_SESSION['pseudo'] = $account[0]['pseudo'];
    $_SESSION['email'] = $account[0]['mail'];
    $_SESSION['img'] = "imgs/avatars/".$_SESSION['user_id']."_".$account[0]['img'];
    // on ajoute le fichier dans le dossier imgs/avatars avec comme nom : [Identifiant de l'utilisateur]+[Nom du fichier]
    move_uploaded_file($_FILES["avatar"]["tmp_name"], "../".$_SESSION['img']);

    // Redirection vers la page index
    header("Location: ../index.php");

}

// Sinon, redirection vers la page redirection
else {
    header("Location: ../redirection.php");
}