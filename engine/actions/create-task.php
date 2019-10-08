<?php
ob_start();
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../action-requires.php';


if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: ../../login");
    exit;
}

$creator = $_SESSION['username'];

$project = $_POST['project'];
$assignee = $_POST['assignee'];
$title = $_POST['title'];
$priority = $_POST['priority'];
$type = $_POST['type'];
$description = $_POST['description'];

try {
    if (empty($project) || empty($assignee) || empty($title) || empty($priority) || empty($type) || empty($description)) {
        throw new Exception("Please make sure you fill all the fields necessary");
    }

    $task = new task();
    $success = $task->createTask($creator, $project, $title, $assignee, $priority, $type, $description);

    if ($success) {
        $_SESSION['success'] = "Task has been created successfully";
        header("Location: ../../create-task");
        exit();
    }
} catch (Exception $error) {
    $_SESSION['error'] = $error->getMessage();
    header("Location: ../../create-task");
}