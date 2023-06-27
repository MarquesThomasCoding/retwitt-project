<?php 

// Continuité de la session
session_start();

if(!isset($_SESSION["user_id"])){
    header("Location: index.php");
    exit();
}

// Récupération du template permettant la connexion à la bdd
require 'database_interactions/database.php';

//Requête pour récupérer le compte de l'utilisateur renseigné dans la barre de recherche (via son identifiant)
$requete = $database->prepare("SELECT * FROM user WHERE user_id=:user_id");
$requete->execute(
    [
        "user_id"=>$_GET['id_user']
    ]
);
$user_info = $requete->fetchAll(PDO::FETCH_ASSOC);

// Si aucun compte n'est trouvé, on redirige vers la page d'accueil
if(count($user_info) == 0) {
    header("Location: index.php");
    exit();
}   

//Requête pour récupérer tous les twitts publiés par cet utilisateur
$requestTwitt = $database->prepare("SELECT * FROM twitts WHERE userid=:userid ORDER BY date DESC");
$requestTwitt->execute(
    [
        "userid"=>$_GET['id_user']
    ]
    );
$twitts = $requestTwitt->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Récupération du template "style.php" -->
    <?php require "templates/style.php" ?>

    <title>ReTWITT - Profile</title>
</head>
<body>

    <!-- Récupération du template "navbars.php" -->
    <?php require "templates/navbars.php"; ?>

    <!-- Carte de profil de l'utilisateur -->
    <div class="profile-card-user">
        <!-- On vérifie si l'avatar existe dans le dossier -->

        <?php if(file_exists("imgs/avatars/".$user_info[0]['user_id']."_".$user_info[0]['img'])) { ?>
            <img class="avatar" src="<?= "imgs/avatars/".$user_info[0]['user_id']."_".$user_info[0]['img'] ?>" alt="Avatar">
        <?php } else { ?>
            <img class="avatar" src="imgs/avatars/default.png" alt="Avatar">
        <?php } ?>
        <div class="infos">

            <!-- Formulaire de modification des informations de l'utilisateur (caché initialement) -->
            <form action="database_interactions/update_account.php" class="hidden form-log-sign" method="post">
                <input type="text" name="pseudo" value="<?= $user_info[0]['pseudo'] ?>" placeholder="Pseudonyme" required="required">
                <input type="text" name="nom" value="<?= $user_info[0]['nom'] ?>" placeholder="Username" required="required">
                <input type="email" name="mail" value="<?= $user_info[0]['mail'] ?>" placeholder="Adresse-mail" required="required">
                <input type="password" name="mdp" placeholder="Password" required="required">
                <button type="submit" class="button">Submit</button>
            </form>

            <!-- Informations de l'utilisateur -->
            <p>
                <u>Pseudonyme :</u> <?= $user_info[0]['pseudo'] ?>
                <br><br><br>
                <u>Username :</u> <?= $user_info[0]['nom'] ?>
                <br><br><br>
                <u>Email Address :</u> <?= $user_info[0]['mail'] ?>
                <br><br><br>
                <u>ID :</u> <?= $user_info[0]['user_id'] ?>
            </p>
            <!-- Si le compte affiché est celui de l'utilisateur connecté, on donne la possibilité de modifier les informations -->
            <?php if($user_info[0]['user_id'] == $_SESSION['user_id']) { ?>
                <button onclick="updateButton()" class="button modif-button" id="update">Modify</button>
            <?php } ?>

        </div>
        <span class="posts-profile-separator">POSTS</span>
        <!-- Posts de l'utilisateur -->
        <div class="user-posts">
            <?php foreach ($twitts as $twitt) { ?>
                <div class="user-post <?= $twitt['tag'] ?>" id="<?= $twitt['id'] ?>">
                    <div class="up-post">
                        <div class="date-publication"><?= $twitt['date'] ?></div>
                        <div class="tag <?= $twitt['tag'] ?>">#<?= $twitt['tag'] ?></div>
                    </div>
                    <hr>
                    <div class="post-content"><?= $twitt['content'] ?></div>
                    <?php if($twitt['media'] != "") { ?>
                        <img class="media" src="imgs/medias/<?= $twitt['userid']."_".$twitt['media'] ?>" alt="Média">
                    <?php } ?>
                    <hr>

                    <!-- Si le post appartient à l'utilisateur connecté, on donne la possibilité de supprimer le post -->
                    
                    <div class="post-option">
                        <form class="saved-icon" action="database_interactions/save.php" method="post">
                            <input name="id" type="hidden" value="<?= $twitt['id'] ?>">
                            <button class="saved-icon"><i class="options fa-solid fa-bookmark"></i></button>
                        </form>
                        <?php if(isset($_SESSION['user_id']) && $twitt['userid'] == $_SESSION['user_id']) { ?>
                        <form class="del-icon" action="database_interactions/del_post.php" method="post">
                            <input name="id" type="hidden" value="<?= $twitt['id'] ?>">
                            <button class="del-icon"><i class="options fa-solid fa-trash"></i></button>
                        </form>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <!-- On récupère le script JS -->
    <script src="profile.js"></script>
</body>
</html>