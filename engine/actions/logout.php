<?php

require_once '../action-requires.php';

try {
    //create a new instance of the admin, handle sessions, update admin last login
    $admin = new admin();
    if ($admin->logoutAdmin() == true) {
        header("Location: ../../");
    }
} catch (Exception $error) {
    echo $error->getMessage();
}
?>
