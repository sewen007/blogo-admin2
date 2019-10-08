<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../action-requires.php';

$email = $_POST['email'];

try {
    if (empty($email)) {
        echo "No email address discovered. Please check and try again";
    }

    $admin = new admin();
    if ($admin->requestAdminPasswordReset($email)){
        echo "1";
    } else {
        echo "Something failed to happen";
    }
} catch (Exception $error) {
    echo $error->getMessage();
}