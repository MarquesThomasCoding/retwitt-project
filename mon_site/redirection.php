<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Récupération du template "style.php" -->
    <?php require "templates/style.php" ?>

    <title>Error</title>
</head>
<body>
    <!-- Récupération du template "navbars.php" -->
    <?php require "templates/navbars.php" ?>

    <div class="error">
        <p>An error has occured :<br>
            - You tried to sign in with an existing account<br>
            - You tried to log in with an uncorrect email address or password
        </p>
        <br><br>
        <h1>You will be redirected in 5 seconds.<br>If not, you can click here -> <a href="index.php">Home</a></h1>
    </div>

    <!-- On redirige l'utilisateur sur la page index au bout de 5 secondes -->
    <?php header("refresh:5;url=index.php") ?>
</body>
</html>