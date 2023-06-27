<?php
session_start();

// Si l'utilisateur est connecté, on une variable loggedIn à true, sinon false, et on renvoie ça en json

$response = array();
if(isset($_SESSION['user_id'])) {
    $response['loggedIn'] = true;
} else {
    $response['loggedIn'] = false;
}

header('Content-Type: application/json');
echo json_encode($response);