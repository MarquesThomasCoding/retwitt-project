<!-- HTML -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Récupération du template "style.php" -->
    <?php require "templates/style.php" ?>
    
    <title>ReTWITT - Login</title>
</head>
<body class="form-log-sign-body">
    <h1>ReTWITT</h1>
    <div class="form-log-sign">
        <h1>Log In</h1>

        <!-- Formulaire de connexion -->
        <form action="database_interactions/check_account.php" method="post">
            <input type="email" name="mail" placeholder="Email" required="required">
            <input type="password" name="mdp" placeholder="Password" required="required">
            <button class="button" type="submit"><i class="fa-solid fa-right-to-bracket"></i> Log in</button>
            <br>
            Don't have an account yet ? <a href="signin.php">Sign in</a>
            <a href="index.php">Home</a>
        </form>

    </div>
</body>
</html>