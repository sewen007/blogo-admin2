<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../action-requires.php';

	$user_id = $_POST['user_id'];
    $us_id = $_POST['us_id'];
    $transaction_id = $_POST['transaction_id'];

try {
	if (empty($user_id)){
            throw new Exception("Some important values are empty. Please try and rectify");
    }
        
    if (empty($transaction_id) || empty($us_id)){
            throw new Exception("No device configuration IDs. Please contact admin");
    }
    
    $blog = new blog();
    $posts = $blog->getAllBlogPosts($user_id,$us_id,$transaction_id);
    
    echo json_encode($posts);
} catch (Exception $error) {
    echo $error->getMessage();
}