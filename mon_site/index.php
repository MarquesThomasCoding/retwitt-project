<?php 

// Continuité de la session
session_start();

// Récupération du template de connexion à la base de données
require 'database_interactions/database.php';

//Requête pour récupérer tous les twitts par ordre décroissant
$requete = $database->prepare("SELECT * FROM twitts INNER JOIN user WHERE twitts.userid = user.user_id ORDER BY date DESC");
$requete->execute();
$allTwitts = $requete->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Récupération du template "style.php" -->
    <?php require "templates/style.php" ?>

    <title>ReTWITT - Home</title>
</head>
<body>

    <!-- Récupération du template "navbars.php" -->
    <?php require 'templates/navbars.php' ?>


    <!-- Pop-up pour confirmer la suppression d'un post -->
    <div class="confirm-delete">
        <div class="confirm-delete-content">
            <h2>Delete post?</h2>
            <div>This action cannot be undo</div>
            <form class="confirm-delete-content-buttons">
                <button class="confirm-delete-content-buttons-close">Close</button>
                <button class="confirm-delete-content-buttons" type="submit" placeholder="Confirm">Confirm</button>
            </form>
        </div>
    </div>


    <!-- Fenêtre de confirmation d'action (suppression ou enregistrement d'un post) -->
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
        <!-- Filtres -->
        <div class="filters">
            <div class="tags-filter filter">
                <div class="tags-menu">Tags <i class="fa-solid fa-chevron-down"></i></div>
            </div>
            <span class="tag-preview"></span>
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
        <?php if(empty($allTwitts)) { ?>
            <h4>Aucun post à afficher</h4>
        <?php } ?>

        <!-- Boucle de parcours des posts récupérés grâce à la requête -->
        <?php foreach ($allTwitts as $twitt) { ?>
            <!-- Mise en page du post -->
            <div class="post <?= $twitt['tag'] ?>" id="<?= $twitt['id'] ?>">
                <div class="up-post">

                    <!-- On affiche l'avatar de l'auteur du post -->
                    <?php if($twitt['img'] != "") { ?>
                        <img class="twitt_user_img" src="<?= "imgs/avatars/".$twitt['user_id']."_".$twitt['img'] ?>" alt="Avatar">
                    <!-- Sinon signin l'auteur du post n'a pas d'avatar, on lui met l'avatar par défaut -->
                    <?php } else {?>
                        <img class="twitt_user_img" src="imgs/avatars/default.png" alt="Avatar">
                    <?php } ?>

                        <div class=usernames>
                            <!-- Formulaire permettant de cliquer sur le pseudo d'un utilisateur pour accéder à sa page profil -->
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

                <!-- Si le post contient un média, on l'affiche -->
                <?php if($twitt['media'] != "") { ?>
                    <img class="media" src="imgs/medias/<?= $twitt['userid']."_".$twitt['media'] ?>" alt="Média">
                <?php } ?>
                <hr>
                
                <!-- Options du post -->
                <div class="post-option">
                    <!-- Icone d'enregistrement du post -->
                    <form class="saved-icon" action="database_interactions/save.php" method="post">
                        <input name="id" type="hidden" value="<?= $twitt['id'] ?>">
                        <button class="saved-icon"><i class="options fa-solid fa-bookmark"></i></button>
                    </form>

                    <!-- Si le post appartient à l'utilisateur connecté, on donne la possibilité de supprimer le post -->
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
    <!-- Si l'utilisateur est connecté, on affiche un bref résumé de son profil -->
    <?php if(isset($_SESSION['user_id'])) { ?>
        <div class="profile-part">
            <div class="profile-card">
                <?php if($_SESSION['img'] != "imgs/avatars/".$_SESSION['user_id']."_") { ?>
                    <img src="<?= $_SESSION['img'] ?>" alt="Avatar">
                <?php } else {?>
                    <img src="imgs/avatars/default.png" alt="Avatar">
                <?php } ?>
                <div class="usernames">
                    <h4><?= $_SESSION['pseudo'] ?></h4>
                    <h5 class="username">@<?= $_SESSION['nom'] ?></h5>
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- Bouton pour faire un nouveau post -->
    <div class="new-post-modal">
        <a class="new-post-modal"><i id ="new-post-modal" class="new-post-modal fa-regular fa-message"></i></a>
    </div>

    <!-- Pop up du nouveau post -->
    <div class="new-post-modal-content">
        <h3>Publish</h3>
        <form class="new-post-modal" action="database_interactions/add_post.php" method="post" enctype="multipart/form-data">

        <!-- Sélection du tag du post -->
            <select id="twitt-tag" name="tags-select">
                <option class="voyage">voyage</option>
                <option class="jeu-video">jeu-video</option>
                <option class="innovation">innovation</option>
                <option class="musique">musique</option>
                <option class="television">television</option>
                <option class="animaux">animaux</option>
                <option class="peinture">peinture</option>
                <option class="lecture">lecture</option>
                <option class="sport">sport</option>
                <option class="loisirs">loisirs</option>
            </select>

            <textarea name="twitt-content" id="twitt-content"></textarea>

            <div class="medias">
                <input id="media-input" class="media-input" type="file" name="media" accept=".jpg,.png,.gif" onchange="showPreview(event)">
                <label for="media-input">MEDIA<br>+</label>
                
                <!-- Preview du média -->
                <div id="preview"></div>
            </div>

            <!-- Si l'utilisateur est connecté, on donne la possibilité de publier le post -->
            <?php if(isset($_SESSION['user_id'])) { ?>
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                <button class="button" type=submit>Publish</button>
            </form>
            <!-- Sinon, on affiche les boutons de connexion et d'inscription -->
            <?php } else { ?>
            </form>
        <div class="buttons">
            <button class="button" onclick="window.location.href='signin.php'"><i class="fa-solid fa-right-to-bracket"></i> Sign In</button>
            <button class="button" onclick="window.location.href='login.php'"><i class="fa-solid fa-right-to-bracket"></i> Log In</button>
        </div>
        <?php } ?>
        
    </div>
    <!-- On récupère le script JS -->
    <script src="js/script-retwitt.js"></script>
</body>
</html>
