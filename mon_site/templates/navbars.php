<!-- Template des barres de navigation -->

<!-- Barre de navigation en haut sur un écran de plus de 1010px -->
<nav class="navbar">

    <div class="name-retwitt">ReTWITT <i id="reload" class="fa-solid fa-rotate-right"></i></div>

    <div class="center-navbar">
        <a class="links" href="index.php"><i class="fa-solid fa-house"></i> Home</a>

        <!-- Si l'utilisateur est connecté, on donne la possibilité de rechercher un mot via un formulaire -->
        <?php if(isset($_SESSION['user_id'])) { ?>
        <form action="search.php" method="get">
            <input class="search" type="search" name="search" placeholder="Search">
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        <?php } ?>
    </div>

    <!-- Si l'utilisateur est connecté, on affiche l'onglet profil -->
    <?php if(isset($_SESSION['user_id'])) { ?>
        <div id="profile"><a class="links" href="profile.php?id_user=<?= $_SESSION['user_id'] ?>"><i class="fa-solid fa-user"></i> Profile</a></div>
    <?php } ?>
</nav>

<!-- Barre de navigation de gauche sur un écran de plus de 1010px -->
<nav class="side-bar">

    <div>
        <!-- Si l'utilisateur n'est pas connecté, on affiche les onglets Log In et Sign In -->
        <?php if(!isset($_SESSION['user_id'])) { ?>
            <a class="links" href="signin.php"><i class="fa-solid fa-right-to-bracket"></i> Sign In</a>
            <a class="links" href="login.php"><i class="fa-solid fa-right-to-bracket"></i> Log In</a>
        <!-- Sinon, l'onglet Log Out -->
        <?php } else { ?>
            <a class="links" href="not_yet.php"><i class="fa-solid fa-envelope"></i> Messages</a>
            <a class="links" href="not_yet.php"><i class="fa-solid fa-bell"></i> Notifications</a>
            <a class="links" href="saved.php"><i class="fa-solid fa-bookmark"></i> Saved</a>
            <a href="deconnect.php" class="links">Log Out</a>
        <?php } ?>
    </div>
</nav>

<!-- Barre de navigation du haut sur un écran de moins de 1010px -->
<div class="nav-bar-mobile">

    <div class="name-retwitt">ReTWITT</div>

    <div class="center-navbar">
        <!-- Si l'utilisateur est connecté, on donne la possibilité de rechercher un mot via un formulaire -->
        <?php if(isset($_SESSION['user_id'])) { ?>
        <form action="search.php" method="get">
            <input class="search" type="search" name="search" placeholder="Search">
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        <?php } ?>
    </div>
    <!-- Icon permettant d'afficher la side-bar -->
    <i class="menu fa-solid fa-bars"></i>
</div>

<!-- Barre de navigation sur un écran de moins de 1010px -->
<div class="side-bar-mobile">

    <a class="links" href="index.php"><i class="fa-solid fa-house"></i> Home</a>

    <!-- Si l'utilisateur est connecté, on affiche l'onglet profil et Log Out-->
    <?php if(isset($_SESSION['user_id'])) { ?>
        <a class="links" href="not_yet.php"><i class="fa-solid fa-envelope"></i> Messages</a>
        <a class="links" href="not_yet.php"><i class="fa-solid fa-bell"></i> Notifications</a>
        <a class="links" href="saved.php"><i class="fa-solid fa-bookmark"></i> Saved</a>
        <a class="links" href="profile.php?id_user=<?= $_SESSION['user_id'] ?>"><i class="fa-solid fa-user"></i> Profile</a>
        <a href="deconnect.php" class="links">Log Out</a>
    <!-- Sinon, l'onglet Sign In et Log In -->
    <?php } else { ?>
        <a class="links" href="signin.php"><i class="fa-solid fa-right-to-bracket"></i> Sign In</a>
        <a class="links" href="login.php"><i class="fa-solid fa-right-to-bracket"></i> Log In</a>
    <?php } ?>
</div>