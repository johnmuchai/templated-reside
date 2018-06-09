<?php
	ini_set('session.cookie_httponly', TRUE); 			// Helps mitigate xss
	ini_set('session.session.use_only_cookies', TRUE);	// Prevents session fixation
	ini_set('session.cookie_lifetime', FALSE);			// Smaller exploitation window for xss/csrf/clickjacking...
	ini_set('session.cookie_secure', TRUE);				// Owasp a9 violations
	
	// Start Sessions
	if(!isset($_SESSION))session_start();				// Session Start

	// Set Localization
	$local = $set['localization'];
	switch ($local) {
		case 'custom':	include ('../language/custom.php');	break;
		case 'english':	include ('../language/english.php');	break;
	}

	// Session Data
	if ((isset($_SESSION['rs']['adminId'])) && ($_SESSION['rs']['adminId'] != '')) {
		// Keep some Admin data available
		$rs_adminId 	= $_SESSION['rs']['adminId'];
		$rs_adminEmail 	= $_SESSION['rs']['adminEmail'];
		$rs_adminName 	= $_SESSION['rs']['adminName'];
		$rs_isAdmin 	= $_SESSION['rs']['isAdmin'];
		$rs_adminRole 	= $_SESSION['rs']['adminRole'];
		$rs_adminLoc 	= $_SESSION['rs']['location'];
	} else {
		$rs_adminId = $rs_adminEmail = $rs_adminName = $rs_isAdmin = $rs_adminRole = $rs_adminLoc = '';
	}

	$msgBox = '';