<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../action-requires.php';

$username = $_POST['username'];
$password = $_POST['password'];

try {
    if (empty($username) || empty($password)) {
        throw new Exception("One or more of the field is incorrectly filled. Please check and try again");
    }

    $admin = new admin();

    if ($admin->authenticateAdmin($username, $password) == false) {
        throw new Exception("Invalid username and/or password. Please try again");
    }
    
    header("Location: ../../dashboard");
} catch (Exception $error) {
    $_SESSION['error'] = $error->getMessage();
    header("Location: ../../login");
}
?>