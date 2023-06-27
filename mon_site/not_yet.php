<!-- Template pour les pages en cours de développement -->

<?php session_start(); 

if(!isset($_SESSION["user_id"])){
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "templates/style.php" ?>
    <title>ReTWITT - Soon</title>
</head>
<body>
    <?php require "templates/navbars.php" ?>
    <h1 class="comingsoon">Coming soon</h1>
    <script src="script-retwitt.js"></script>
</body>
</html>