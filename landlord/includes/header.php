<?php
// If you use an SSL Certificate - HTTPS://
// Uncomment (remove the double slashes) from lines 5 - 9
// ************************************************************************
//if (!isset($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) != "on") {
//	$url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
//	header("Location: $url");
//	exit;
//}

// Set the Active State on the Navigation
$homeNav = $propNav = $aboutNav = $contactNav = $userNav = $manageNav = '';
if (isset($homePage)) { $homeNav = 'active'; } else { $homeNav = ''; }
if (isset($propPage)) { $propNav = 'active'; } else { $propNav = ''; }
if (isset($aboutPage)) { $aboutNav = 'active'; } else { $aboutNav = ''; }
if (isset($contactPage)) { $contactNav = 'active'; } else { $contactNav = ''; }
if (isset($userPage)) { $userNav = 'active'; } else { $userNav = ''; }
if (isset($managePage)) { $manageNav = 'active'; } else { $manageNav = ''; }

// Get Pictures Directory
$propPicsPath = $set['propPicsPath'];

// Get Documents Directory
$docUploadPath = $set['uploadPath'];

// Get the Avatar Directory
$avatarDir = $set['avatarFolder'];

// Get Social Network Icons & Links
if (!empty($set['facebook'])) {
	$facebook = '<a href="'.clean($set['facebook']).'" class="facebook" data-toggle="tooltip" data-placement="bottom" title="'.$facebookText.'"><i class="fa fa-facebook"></i></a>';
} else { $facebook = ''; }
if (!empty($set['google'])) {
	$google = '<a href="'.clean($set['google']).'" class="google" data-toggle="tooltip" data-placement="bottom" title="'.$googleText.'"><i class="fa fa-google-plus"></i></a>';
} else { $google = ''; }
if (!empty($set['linkedin'])) {
	$linkedin = '<a href="'.clean($set['linkedin']).'" class="linkedin" data-toggle="tooltip" data-placement="bottom" title="'.$linkedinText.'"><i class="fa fa-linkedin"></i></a>';
} else { $linkedin = ''; }
if (!empty($set['pinterest'])) {
	$pinterest = '<a href="'.clean($set['pinterest']).'" class="pinterest" data-toggle="tooltip" data-placement="bottom" title="'.$pinterestText.'"><i class="fa fa-pinterest"></i></a>';
} else { $pinterest = ''; }
if (!empty($set['twitter'])) {
	$twitter = '<a href="'.clean($set['twitter']).'" class="twitter" data-toggle="tooltip" data-placement="bottom" title="'.$twitterText.'"><i class="fa fa-twitter"></i></a>';
} else { $twitter = ''; }
if (!empty($set['youtube'])) {
	$youtube = '<a href="'.clean($set['youtube']).'" class="youtube" data-toggle="tooltip" data-placement="bottom" title="'.$youtubeText.'"><i class="fa fa-youtube"></i></a>';
} else { $youtube = ''; }

// Contact Request Form
if (isset($_POST['submit']) && $_POST['submit'] == 'contactReq') {
	// User Validations
	if($_POST['crFirstName'] == '') {
		$msgBox = alertBox($fnameReq, "<i class='fa fa-times-circle'></i>", "danger");
	} else if($_POST['crLastName'] == '') {
		$msgBox = alertBox($lnameReq, "<i class='fa fa-times-circle'></i>", "danger");
	} else if($_POST['crEmail'] == '') {
		$msgBox = alertBox($validEmailReq, "<i class='fa fa-times-circle'></i>", "danger");
	} else if($_POST['crMessage'] == '') {
		$msgBox = alertBox($msgTextReqErr, "<i class='fa fa-times-circle'></i>", "danger");
	} else if($_POST['crCaptcha'] == "") {
		$msgBox = alertBox($captchaReq, "<i class='fa fa-times-circle'></i>", "danger");
		// Black Hole Trap to help reduce bot registrations
	} else if($_POST['none'] != '') {
		$msgBox = alertBox($msgSendErr, "<i class='fa fa-times-circle'></i>", "danger");
		$_POST['crFirstName'] = $_POST['crLastName'] = $_POST['crEmail'] = $_POST['crPhone'] = $_POST['crMessage'] = '';
	} else {
		if(strtolower($_POST['crCaptcha']) == $_SESSION['thecode']) {
			$crFirstName = htmlspecialchars($_POST['crFirstName']);
			$crLastName = htmlspecialchars($_POST['crLastName']);
			$crEmail = htmlspecialchars($_POST['crEmail']);
			$crPhone = htmlspecialchars($_POST['crPhone']);
			$crMessage = allowedHTML(htmlspecialchars($_POST['crMessage']));

			// Add Recent Activity
			$activityType = '15';
			if ($rs_adminId != '') { $rs_aid = $rs_adminId; } else { $rs_aid = '0'; }
			if ($rs_userId != '') { $rs_uid = $rs_userId; } else { $rs_uid = '0'; }
			$activityTitle = $sendMsgSubject.' '.$crFirstName.' '.$crLastName.' ('.$crEmail.')';
			updateActivity($rs_aid,$rs_uid,$activityType,$activityTitle);

			// Send out the email in HTML
			$installUrl = $set['installUrl'];
			$siteName = $set['siteName'];
			$siteEmail = $set['siteEmail'];

			$subject = $sendMsgEmail1.' '.$siteName;
			$message = '<html><body>';
			$message .= '<h3>'.$subject.'</h3>';
			$message .= '<hr />';
			$message .= '<p>'.$sendMsgEmail2.' '.$crFirstName.' '.$crLastName.'<br />';
			$message .= $sendMsgEmail3.' '.$crEmail.'<br />';
			$message .= $sendMsgEmail4.' '.$crPhone.'</p>';
			$message .= '<p>'.$sendMsgEmail5.'<br />'.nl2br($crMessage).'</p>';
			$message .= '<hr />';
			$message .= '<p>'.$emailTankYouTxt.'<br>'.$siteName.'</p>';
			$message .= '</body></html>';

			$headers = "From: ".$crFirstName." ".$crLastName." <".$crEmail.">\r\n";
			$headers .= "Reply-To: ".$crEmail."\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

			if (mailer($siteEmail, $subject, $message, $headers)) {
				$msgBox = alertBox($sendMsgEmailSent, "<i class='fa fa-check-square'></i>", "success");
				$_POST['crFirstName'] = $_POST['crLastName'] = $_POST['crEmail'] = $_POST['crPhone'] = $_POST['crMessage'] = '';
			}
		} else {
			$msgBox = alertBox($sendMsgEmailErr, "<i class='fa fa-times-circle'></i>", "danger");
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<link rel="stylesheet" href="../star/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../star/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../star/vendors/css/vendor.bundle.addons.css">

	<title><?php echo $set['siteName'].' &middot; '.$pageTitle; ?></title>

	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="../css/font-awesome.css" />
	<?php if (isset($addCss)) { echo $addCss; } ?>
	<link rel="stylesheet" type="text/css" href="../css/custom.css" />
	<link rel="stylesheet" type="text/css" href="../css/styles.css" />

	<!--[if lt IE 9]>
	<script src="js/html5shiv.min.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
	<link rel="stylesheet" href="../star/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../star/images/favicon.png" />
</head>

<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
   
    <nav class="navbar default-layout col-md-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="index.html">
          <img src="../images/newlogo.png" style="width:150px;height:60px; " />

        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
          <li class="nav-item">
                <a href="../index.php" class="nav-link"><?php echo $homeNavLink; ?></a>
              </li>

      <li class="nav-item <?php echo $aboutNav; ?>"><a class="nav-link" href="../about-us.php"><?php echo $aboutUsNavLink; ?></a></li>
	<li class="nav-item <?php echo $contactNav; ?>"><a  class="nav-link" href="../contact-us.php"><?php echo $contactUsNavLink; ?></a></li>

             
          </ul>
          <?php if ($rs_userId != '') { ?>
          <ul class="navbar-nav navbar-nav-right">
          
          <li class="nav-item dropdown d-none d-xl-inline-block">
            <a class="nav-link dropdown-toggle" id="UserDropdown" href="index.php?action=myProfile"data-toggle="dropdown" aria-expanded="false">
              <span class="profile-text"><?php echo $myAccNavLink; ?></span>
              
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
            
                <a class="dropdown-item" href="index.php"><?php echo $dashboardNavLink; ?></a>
				<a class="dropdown-item" href="index.php?action=myProfile"><?php echo $myProfileNavLink;?></a>
			<?php if ($rs_adminId != '') { ?>
								<li class="<?php echo $manageNav; ?>"><a href="index.php?action=dashboard"><?php echo $manageNavLink; ?></a></li>
							<?php } ?>
							<?php if (($rs_adminId != '') || ($rs_userId != '')) { ?>
								<a class="dropdown-item" data-toggle="modal" href="#signOut"><?php echo $signOutNavLink; ?></a>
								<?php
							} else {
								if ($set['allowRegistrations'] == '1') {
									?>
									<a class="dropdown-item" href="sign-in.php"><?php echo $signInUpNavLink; ?></a>
								<?php } else { ?>
									<a class="dropdown-item" href="sign-in.php"><?php echo $signInNavLink; ?></a>
									<?php
								}
							}
							?>
             
            </div>
          </li>
        </ul>
        <?php } ?>
      </div>


  </nav>
</div>
<div class="modal fade" id="signOut" tabindex="-1" role="dialog" aria-labelledby="signOutLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <p class="lead"><?php echo $rs_adminName; ?>, <?php echo $signOutConf; ?></p>
      </div>
      <div class="modal-footer">
        <a href="../index.php?action=logout" class="btn btn-success btn-icon-alt"><?php echo $signOutNavLink; ?> <i class="fa fa-sign-out"></i></a>
        <button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle"></i> <?php echo $cancelBtn; ?></button>
      </div>
    </div>
  </div>
</div>




					
