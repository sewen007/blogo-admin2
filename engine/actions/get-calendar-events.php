<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../action-requires.php';

$username = $_SESSION['username'];


try {
    if (!isset($_SESSION['username']) || empty($_SESSION['username'])){
        header("Location: ../../login");
        exit;
    }
    
    $calendar = new calendar();
    $events = $calendar->getAllEvents();
    
    echo json_encode($events);
} catch (Exception $error) {
    echo $error->getMessage();
}

//exit;
//$query = "select * from calendar_events";
//
//$link = mysql_connect('localhost', 'diamond4_admin', '#ew8eZV#ir]T');
//
//mysql_select_db('diamond4_admindb', $link) or die(mysql_error());
//
//$res = mysql_query($query) or die(mysql_error());
//
//$events = array();
//
//while ($row = mysql_fetch_assoc($res)) {
//    $eventsArray['id'] = $row['id'];
//    $eventsArray['title'] = $row['title'];
//    $eventsArray['start'] = $row['start'];
//    $eventsArray['type'] = $row['type'];
//    $eventsArray['category'] = $row['category'];
//    $eventsArray['end'] = $row['end'];
//    $eventsArray['description'] = $row['description'];
//    $events[] = $eventsArray;
//}
//
//print_r($events);exit;
//echo json_encode($events);
