<?php
// Check if install.php is present
if(is_dir('install')) {
	header("Location: ../install/install.php");
} else {

	if(!isset($_SESSION)) session_start();

	if (!isset($_SESSION['rs']['userId'])) {
		header ('Location: ../index.php');
		exit;
	}

	// Access DB Info
	include('../config.php');

	// Get Settings Data
	include ('../includes/settings.php');
	$set = mysqli_fetch_assoc($setRes);

	// Include Functions
	include('../includes/functions.php');

	// Include Sessions & Localizations
	include('includes/sessions.php');

	// Set Week Day Name
	$theDay = date('l');
	switch ($theDay) {
		case 'Sunday':		$dayName = $sunText;	break;
		case 'Monday':		$dayName = $monText;	break;
		case 'Tuesday':		$dayName = $tueText;	break;
		case 'Wednesday':	$dayName = $wedText;	break;
		case 'Thursday':	$dayName = $thuText;	break;
		case 'Friday':		$dayName = $friText;	break;
		case 'Saturday':	$dayName = $satText;	break;
	}

	// Set Month Name
	$theMonth = date('F');
	switch ($theMonth) {
		case 'January':		$monthName = $janText;	break;
		case 'February':	$monthName = $febText;	break;
		case 'March':		$monthName = $marText;	break;
		case 'April':		$monthName = $aprText;	break;
		case 'May':			$monthName = $mayText;	break;
		case 'June':		$monthName = $junText;	break;
		case 'July':		$monthName = $julText;	break;
		case 'August':		$monthName = $augText;	break;
		case 'September':	$monthName = $septText;	break;
		case 'October':		$monthName = $octText;	break;
		case 'November':	$monthName = $novText;	break;
		case 'December':	$monthName = $decText;	break;
	}

	// Link to the Page
	if (isset($_GET['action']) && $_GET['action'] == 'myProfile') {					$page = 'myProfile';
	} else if (isset($_GET['action']) && $_GET['action'] == 'payments') {		$page = 'payments';
	} else if (isset($_GET['action']) && $_GET['action'] == 'properties') {	$page = 'properties';
	} else if (isset($_GET['action']) && $_GET['action'] == 'tenants') {	$page = 'tenants';
	} else if (isset($_GET['action']) && $_GET['action'] == 'viewProperty') {			$page = 'viewProperty';
} else if (isset($_GET['action']) && $_GET['action'] == 'viewTenant') {			$page = 'viewTenant';
	} else if (isset($_GET['action']) && $_GET['action'] == 'leaseProperty') {			$page = 'leaseProperty';
	} else if (isset($_GET['action']) && $_GET['action'] == 'leasedProperties') {			$page = 'leasedProperties';
	} else if (isset($_GET['action']) && $_GET['action'] == 'leasedTenants') {			$page = 'leasedTenants';
	} else if (isset($_GET['action']) && $_GET['action'] == 'imports') {			$page = 'imports';
	} else if (isset($_GET['action']) && $_GET['action'] == 'newProperty') {			$page = 'newProperty';
	} else if (isset($_GET['action']) && $_GET['action'] == 'newTenant') {			$page = 'newTenant';
} else if (isset($_GET['action']) && $_GET['action'] == 'bulkApartments') {			$page = 'bulkApartments';
	} else if (isset($_GET['action']) && $_GET['action'] == 'unit') {			$page = 'unit';

	} else {$page = 'dashboard';}

	if (file_exists('pages/'.$page.'.php')) {
		// Load the Page
		include('pages/'.$page.'.php');
	} else {
		$pageTitle = $pageNotFoundHeader;

		if (($page != 'receipt') && ($page != 'workOrder')) {
			include('includes/header.php');
		}

		// Else Display an Error
		echo '
		<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />
		<h3>'.$pageNotFoundHeader.'</h3>
		<div class="alertMsg warning mb-20">
		<div class="msgIcon pull-left">
		<i class="fa fa-warning"></i>
		</div>
		'.$pageNotFoundQuip.'
		</div>
		</div>
		';
	}

	if (($page != 'receipt') && ($page != 'workOrder')) {
		include('includes/footer.php');
	}
}
?>
