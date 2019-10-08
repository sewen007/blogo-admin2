<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../action-requires.php';

$recordID = $_POST['record-id'];
$username = $_SESSION['username'];
$description = $_POST['description'];
$date = $_POST['date'];
$initialAmount = $_POST['initial-amount'];
$correctAmount = $_POST['correct-amount'];

try {
    if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
        header("Location: ../../login");
        exit;
    }
    
    $username = $_SESSION['username'];

    if (!isset($_SESSION['username']) || empty($_SESSION['username'])){
        header("Location: ../../login");
        exit;
    }

    if (empty($description) || empty($date) || empty($correctAmount) || empty($initialAmount) || empty($recordID)) {
        throw new Exception ("One or more values is/are empty. Please check and try again");
    }

    $account = new account();
    $pettyCashRecord = $account->getPettyCashRecordByID($recordID);

    $amountChanged = 0;
    $changeType = "";

    $finalBalance = $pettyCashRecord['final_balance'];

    if ($initialAmount < $correctAmount){
        $changeType = "negative";
        $amountChanged = $correctAmount - $initialAmount;
        $finalBalance = $finalBalance - $amountChanged;
    } else if ($initialAmount > $correctAmount){
        $changeType = "positive";
        $amountChanged = $initialAmount - $correctAmount;
        $finalBalance = $finalBalance + $amountChanged;
    }


    $success = $account->editPettyCashRecord($recordID, $description, $date, $correctAmount, $finalBalance, $amountChanged, $changeType);

    if ($success){
        $_SESSION['success'] = "Record has been edited successfully";
        header("Location: ../../edit-pettycash?id=" . $recordID);
    }
} catch (Exception $error) {
    $_SESSION['error'] = $error->getMessage();
    header("Location: ../../edit-pettycash?id=" . $recordID);
}
?>