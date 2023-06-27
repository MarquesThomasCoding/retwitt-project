<?php 

// On récupère la session
session_start();

// On défait les informations qui lui sont liées
session_unset();

// On détruit la session
session_destroy();

// On redirige vers la page index
header("Location: index.php");

?>