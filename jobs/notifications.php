<?php

// Access DB Info
include('../config.php');

// Get Settings Data
include ('../includes/settings.php');
$set = mysqli_fetch_assoc($setRes);

// Include Functions
include('../includes/functions.php');

$todayDate = date("Y-m-d");
$currentYear = date('Y');
$currentMonth = date('n');




?>
