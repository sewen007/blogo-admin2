<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if($_SERVER['REQUEST_METHOD']=='POST'){
    require_once '../CreateEmailTemplate.php';

    session_start();

    try{ 

        $table_type = '';

        $image = $_FILES['image'];
        $etype = $_POST['etype4'];
        $itype = $_POST['itype'];
        $iposition = $_POST['iposition'];
        $trans_id = $_POST['trans_id'];
        
        $_SESSION['email_type'] = $etype;

        if(empty($image)) {
            throw new Exception("You can not submit an empty field");
        }

        $emailImage = new CreateEmailTemplate();

        if($etype == 'personal') {
            $table_type = 'katlogg_personal_email';
        } elseif ($etype == 'promotional') {
            $table_type = 'katlogg_promotional_email';
        } elseif ($etype == 'newsletter') {
            $table_type = 'katlogg_newsletter_email';
        }

        $imageDestination = "../../email-images/";


        $response = $emailImage->createNewImage($image, $etype, $itype, $trans_id, $table_type, $imageDestination);

        $_SESSION['success'] = $response;
        $_SESSION['tables'] = $table_type;
       
        header("Location: ../../email-templates.php");

    } catch (Exception $error) {
        $_SESSION['error'] = $error->getMessage();
        header("Location: ../../email-templates.php");
    }
}