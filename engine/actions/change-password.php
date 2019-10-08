<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../action-requires.php';

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: ../../login");
    exit;
}

$adminUsername = $_SESSION['username'];

$username = $_POST['username'];
$currentPassword = $_POST['current-password'];
$newPassword = $_POST['new-password'];
$confirmPassword = $_POST['confirm-password'];


try {
    if (empty($username) || empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        throw new Exception ("One or more values is/are empty. Please check and make sure your all filled are correctly filled");
    }
    
    if (strcmp($newPassword, $confirmPassword) != 0) {
        throw new Exception("Your passwords do not match. Please check and try again.");
    }

    $admin = new admin();
    $success = $admin->updateEmployeePassword($username, $currentPassword, $confirmPassword);
    
    if ($success){
        $_SESSION['success'] = "Your password has successfully been changed";
        header("Location: ../../change-password");
    }
} catch (Exception $error) {
    $_SESSION['error'] = $error->getMessage();
    header("Location: ../../change-password");
}
?>