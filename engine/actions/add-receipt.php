<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../action-requires.php';



$fileDestination = "../../files";
$permittedFileType = array("image/jpeg", "image/jpg", "image/png");

$receiptImage = $_FILES['receipt'];
$paymentDay = $_POST['payment-day'];
$paymentMonth = $_POST['payment-month'];
$paymentYear = $_POST['payment-year'];
$paymentType = $_POST['payment-type'];
$merchant = $_POST['merchant-name'];
$productNumber = $_POST['product-number'];
$subtotal = $_POST['subtotal'];
$total = $_POST['total'];
$remark = $_POST['remark'];

try {
    if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
        header("Location: ../../login");
        exit;
    }
    
    $username = $_SESSION['username'];

    if (empty($receiptImage)) {
        throw new Exception("Please make sure you have uploaded your an image for this payment");
    }

    $productArray = array();
    
    $product1 = array("name" => $_POST['name-1'],
            "quantity" => $_POST['quantity-1'],
            "unit-price" => $_POST['unit-price-1'],
            "total" => $_POST['unit-total-1']);
    $productArray[] = $product1;
    
    if ($productNumber > 1 && !empty($_POST['name-2']) && !empty($_POST['unit-total-2'])) {
        $product2 = array("name" => $_POST['name-2'],
            "quantity" => $_POST['quantity-2'],
            "unit-price" => $_POST['unit-price-2'],
            "total" => $_POST['unit-total-2']);
        $productArray[] = $product2;
    }

    if ($productNumber > 2 && !empty($_POST['name-3']) && !empty($_POST['unit-total-3'])) {
        $product3 = array("name" => $_POST['name-3'],
            "quantity" => $_POST['quantity-3'],
            "unit-price" => $_POST['unit-price-3'],
            "total" => $_POST['unit-total-3']);
        $productArray[] = $product3;
    }

    if ($productNumber > 3 && !empty($_POST['name-4']) && !empty($_POST['unit-total-4'])) {
        $product4 = array("name" => $_POST['name-4'],
            "quantity" => $_POST['quantity-4'],
            "unit-price" => $_POST['unit-price-4'],
            "total" => $_POST['unit-total-4']);
        $productArray[] = $product4;
    }

    if ($productNumber > 4 && !empty($_POST['name-5']) && !empty($_POST['unit-total-5'])) {
        $product5 = array("name" => $_POST['name-5'],
            "quantity" => $_POST['quantity-5'],
            "unit-price" => $_POST['unit-price-5'],
            "total" => $_POST['unit-total-5']);
        $productArray[] = $product5;
    }

    //upload receipt
    $resumeUploader = new Uploader($fileDestination, $receiptImage, $merchant, $permittedFileType);
    $receiptImageURL = $resumeUploader->moveUploadedFile();
    $receiptImageURL = "http://admin.diamondscripts.ng/files/" . $receiptImageURL;

    if (empty($paymentDay) || empty($paymentMonth) || empty($paymentYear) || empty($paymentType)) {
        throw new Exception("One or more values is/are empty. Please check and try again");
    }

    $paymentDate = $paymentYear . "-" . $paymentMonth . "-" . $paymentDay;
    
    $admin = new account();
    $paymentID = $admin->addPayment($paymentType, $merchant, $productNumber, $paymentDate, $subtotal, $total, $receiptImageURL, $remark);
    
    if ($admin->addProducts($paymentID, $productArray)){
        $_SESSION['success'] = "Payment has been successfully added.";
        header("Location: ../../add-payment");
    }
} catch (Exception $error) {
    $_SESSION['error'] = $error->getMessage();
    header("Location: ../../add-payment");
}
?>