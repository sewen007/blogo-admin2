<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../action-requires.php';

$username = $_SESSION['username'];
$description = $_POST['description'];
$to = $_POST['to'];
$from = $_POST['from'];
$title = $_POST['title'];
$type = $_POST['type'];
$category = $_POST['category'];


try {
    if (!isset($_SESSION['username']) || empty($_SESSION['username'])){
        header("Location: ../../login");
        exit;
    }
    
    if (empty($description) || empty($to) || empty($from) || empty($title) || empty($type) || empty($category)) {
        throw new Exception ("One or more values is/are empty. Please check and try again");
    }

    $calendar = new calendar();
    $success = $calendar->createEvent($from, $to, $title, $username, $type, $category, $description);
    
    if ($success){
        $_SESSION['success'] = "Event has been added successfully";
        header("Location: ../../create-event");
    }
} catch (Exception $error) {
    $_SESSION['error'] = $error->getMessage();
    header("Location: ../../create-event");
}
?>


