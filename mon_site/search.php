<?php 

// Continuité de la session
session_start();

if(!isset($_SESSION["user_id"])){
    header("Location: index.php");
    exit();
}

// Récupération du template permettant la connexion à la bdd
require 'database_interactions/database.php';

//Requête pour récupérer tous les twitts contenant le mot recherché
$requete = $database->prepare("SELECT * FROM `twitts` INNER JOIN user WHERE twitts.userid = user.user_id AND `content` LIKE '%".$_GET['search']."%' ORDER BY date DESC");
$requete->execute();
$searchTwitts = $requete->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Récupération du template "style.php" -->
    <?php require "templates/style.php" ?>

    <title>ReTWITT - Search</title>
</head>
<body>
    <!-- Récupération du template "navbars.php" -->
    <?php require 'templates/navbars.php' ?>

    <div class="confirm-action">
        <div class="confirm-action-content">
            <div class="action-post-modal-content"></div>
            <div class="action-post-modal-bar">
                <div class="action-post-modal-bar-progress"></div>
            </div>
        </div>
    </div>

    <!-- Section des posts -->
    <div class="posts">
        <div class="filters">
            <div class="tags-filter filter">
                <div class="tags-menu">Tags <i class="fa-solid fa-chevron-down"></i></div>
            </div>
        </div>
        <!-- Menu de sélection des tags -->
        <div class="tags-content">
            <div class="tag-choice all">All</div>
            <div class="tag-choice voyage">Voyage</div>
            <div class="tag-choice jeu-video">JeuVidéo</div>
            <div class="tag-choice innovation">Innovation</div>
            <div class="tag-choice musique">Musique</div>
            <div class="tag-choice television">Télévision</div>
            <div class="tag-choice animaux">Animaux</div>
            <div class="tag-choice peinture">Peinture</div>
            <div class="tag-choice lecture">Lecture</div>
            <div class="tag-choice sport">Sport</div>
            <div class="tag-choice loisirs">Loisirs</div>
        </div>

        <!-- S'il n'y a aucun post à afficher, on le précise -->
        <?php if(empty($searchTwitts)) { ?>
            <h4>Aucun post ne correspond à votre recherche</h4>
        <?php } ?>

        <!-- Boucle de parcours des posts récupérés grâce à la requête -->
        <?php foreach ($searchTwitts as $twitt) { ?>
            <!-- Mise en page du post -->
            <div class="post <?= $twitt['tag'] ?>" id="<?= $twitt['id'] ?>">
                <div class="up-post">
                <?php if($twitt['img'] != "") { ?>
                    <img class="twitt_user_img" src="<?= "imgs/avatars/".$twitt['user_id']."_".$twitt['img'] ?>" alt="Avatar">
                <?php } else {?>
                    <img class="twitt_user_img" src="imgs/avatars/default.png" alt="Avatar">
                <?php } ?>
                    <div class=usernames>
                        <form action="profile.php" method="get">
                            <input type="hidden" name="id_user" value="<?= $twitt['user_id'] ?>">
                            <button class="no-btn userpseudo" type="submit"><?= $twitt['pseudo'] ?></button>
                        </form>
                        <h5 class="username">@<?= $twitt['nom'] ?></h5>
                    </div>
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
    <!-- On récupère le script JS -->
    <script src="script-retwitt.js"></script>
</body>
</html>