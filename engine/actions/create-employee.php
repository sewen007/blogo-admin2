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

$fullName = $_POST['name'];
$username = $_POST['username'];
$role = $_POST['role'];
$address = $_POST['address'];
$phoneNumber1 = $_POST['phone-number-1'];
$phoneNumber2 = $_POST['phone-number-2'];
$corporateEmail = $_POST['corporate-email'];
$personalEmail = $_POST['personal-email'];
$birthDay = $_POST['birth-day'];
$birthMonth = $_POST['birth-month'];
$birthYear = $_POST['birth-year'];
$bank = $_POST['bank'];
$accountName = $_POST['account-name'];
$accountNumber = $_POST['account-number'];
$spouseName = $_POST['spouse-name'];
$spouseNumber = $_POST['spouse-number'];
$spouseEmployer = $_POST['spouse-employer'];
$nextName = $_POST['next-name'];
$nextEmail = $_POST['next-email'];
$nextAddress = $_POST['next-address'];
$nextPhoneNumber1 = $_POST['next-phone-number-1'];
$nextPhoneNumber2 = $_POST['next-phone-number-2'];
$nextOccupation = $_POST['next-occupation'];
$nextRelationship = $_POST['next-relationship'];
$emergencyName = $_POST['emergency-name'];
$emergencyEmail = $_POST['emergency-email'];
$emergencyAddress = $_POST['emergency-address'];
$emergencyPhoneNumber1 = $_POST['emergency-phone-number-1'];
$emergencyPhoneNumber2 = $_POST['emergency-phone-number-2'];
$emergencyOccupation = $_POST['emergency-occupation'];
$emergencyRelationship = $_POST['emergency-relationship'];


try {
    if (empty($username) || empty($correctAmount) || empty($investmentPlan) || empty($paymentSystem)) {
        //throw new Exception ("One or more values is/are empty. Please check and try again");
    }

    $admin = new admin();
    $success = $admin->createEmployee($fullName, $username, $role, $address, $phoneNumber1, $phoneNumber2, $corporateEmail, 
            $personalEmail, $birthDay, $birthMonth, $birthYear, $bank, $accountName, $accountNumber, 
            $spouseName, $spouseNumber, $spouseEmployer, $nextName, $nextEmail, $nextAddress, 
            $nextPhoneNumber1, $nextPhoneNumber2, $nextOccupation, $nextRelationship, $emergencyName, 
            $emergencyEmail, $emergencyAddress, $emergencyPhoneNumber1, $emergencyPhoneNumber2, 
            $emergencyOccupation, $emergencyRelationship);
    
    if ($success){
        $_SESSION['success'] = "Employee has been created successfully";
        header("Location: ../../create-employee");
    }
} catch (Exception $error) {
    $_SESSION['error'] = $error->getMessage();
    header("Location: ../../create-employee");
}
?>