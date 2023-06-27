<?php

// Récupération du template de connexion à la base de données
require 'database.php';

//Requête pour récupérer le dernier post
$update_account = $database->prepare('SELECT * FROM twitts ORDER BY date DESC LIMIT 1');
$update_account->execute();
$query = $update_account->fetchAll(PDO::FETCH_ASSOC);

// Renvoie le dernier post au format JSON
echo json_encode($query);