<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once '../action-requires.php';

if($_SERVER['REQUEST_METHOD']=='POST'){   
        
    //assign value to variables
    $blog_id = $_POST['blog_id'];
    $user_id = $_POST['user_id'];
    $us_id = $_POST['us_id'];
    $transaction_id = $_POST['transaction_id'];
        
    try {
        
        if (empty($user_id) || empty($blog_id)){
            throw new Exception("Some important values are empty. Please try and rectify");
        }
        
        if (empty($transaction_id) || empty($us_id)){
            throw new Exception("No device configuration IDs. Please contact admin");
        }

        $deletePost = new blog();
        $result = $deletePost->deleteBlogPost($blog_id, $user_id, $transaction_id, $us_id);
        
        if ($result){
        
            $_SESSION['success'] = "Post has been deleted successfully";
            header("Location: ../../test-pages.php?action=delete-blog-post");
            
            exit;
        }
        
        // throw new Exception("Wasn't able to delete post using the parameters " . print_r($_POST));
    } catch (Exception $ex) {
        echo '0| '.$ex->getMessage();
    }
}
