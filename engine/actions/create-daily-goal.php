<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../action-requires.php';

//print_r($_POST);exit;



if (!isset($_SESSION['adminUsername']) || empty($_SESSION['adminUsername'])) {
    //throw new Exception ("Error processing request. Please logout and try again.");
}

$username = $_SESSION['username'];

$day = $_POST['day'];
$mainGoal = $_POST['main-goal'];
$three30Goal = $_POST['330-goal'];


try{
    if (empty($day) || empty($mainGoal) || empty($three30Goal)){
        throw new Exception("Please make sure you fill all the fields necessary");
    }
    
    $task = new task();
    $success = $task->createDailyGoal($username, $day, $mainGoal, $three30Goal);
    
    if ($success){
        $_SESSION['success'] = "Your daily goal has been created successfully";
        header("Location: ../../create-daily-goal");
    }
} catch (Exception $error) {
    $_SESSION['error'] = $error->getMessage();
    header("Location: ../../create-daily-goal");
}