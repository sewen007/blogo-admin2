<?php

$from = $_POST['from'];
$to = $_POST['to'];

if (empty($from)){
    $from = "--";
}

if (empty($to)){
    $to = "--";
}

header("Location: ../../view-pettycash?from=" . $from . "&to=" . $to);
