<?php

require_once 'engine/account.php';
require_once 'engine/database.php';
require_once 'engine/admin.php';
require_once 'engine/project.php';
require_once 'engine/library.php';
require_once 'engine/task.php';
require_once 'engine/calendar.php';
require_once 'engine/blog.php';
require_once 'engine/analytic_api.inc.php';

$project = new project();
$allProjects = $project->getAllProjects();

$employees = new admin();
$allEmployees = $employees->getAllEmployees();

if (!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("Location: login");
    exit;
}

$username = $_SESSION['username'];

