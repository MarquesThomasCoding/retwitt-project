<?php 

// Tentative de connexion à la base de données "retwitt"
try {
    $database = new PDO(
        "mysql:host=localhost;dbname=retwitt",
        "root",
        ""
    );
// Si erreur, on affiche le message d'erreur
} catch(PDOException $error) {
    die("Echec de connexion à la base de données : $error");
}
?>