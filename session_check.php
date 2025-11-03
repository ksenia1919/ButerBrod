<?php
session_start();

$response = array();

if (isset($_SESSION['phone'])) {
    $response['loggedIn'] = true;
} else {
    $response['loggedIn'] = false;
}

echo json_encode($response);
?>