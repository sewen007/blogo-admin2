<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../action-requires.php';

$username = $_SESSION['username'];
$description = "Balance Replenishment";
$date = $_POST['date'];
$amount = $_POST['amount'];
$currentBalance = $_POST['current-balance'];
$finalBalance = $_POST['final-balance'];

try {
    if (!isset($_SESSION['username']) || empty($_SESSION['username'])){
        header("Location: ../../login");
        exit;
    }
    
    if (empty($description) || empty($date) || empty($amount) || empty($finalBalance)) {
        throw new Exception ("One or more values is/are empty. Please check and try again");
    }

    $account = new account();
    $success = $account->replenishPettyCashBalance($username, $description, $date, $amount, $currentBalance, $finalBalance);
    
    if ($success){
        $_SESSION['success'] = "Balance has been updated successfully";
        header("Location: ../../replenish-balance");
    }
} catch (Exception $error) {
    $_SESSION['error'] = $error->getMessage();
    header("Location: ../../replenish-balance");
}
?>

