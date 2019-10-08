<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once '../action-requires.php';

$blogID = $_POST['blog_id'];
$title = $_POST['title'];
$content = $_POST['content'];
$image_url = $_POST['image_url'];
$user_id = $_POST['user_id'];
$us_id = $_POST['us_id'];
$transaction_id = $_POST['transaction_id'];

try {

    if (empty($blogID) || empty($title) || empty($content) || empty($image_url)) {
        throw new Exception ("One or more values is/are empty. Please check and try again");
    }

    $blog = new blog();
    $success = $blog->editBlogPost($blogID, $title, $content, $image_url,$us_id,$user_id,$transaction_id);

    if ($success){
        echo "1| Successful";
    }
} catch (Exception $error) {
    echo $error->getMessage();
}
?>