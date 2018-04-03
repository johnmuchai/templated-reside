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
	$dashNav = $propNav = $servNav = $userNav = '';
	if (isset($dashPage)) { $dashNav = 'active'; } else { $dashNav = ''; }
	if (isset($propPage)) { $propNav = 'active'; } else { $propNav = ''; }
	if (isset($servPage)) { $servNav = 'active'; } else { $servNav = ''; }
	if (isset($userPage)) { $userNav = 'active'; } else { $userNav = ''; }

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title><?php echo $set['siteName'].' &middot; '.$pageTitle; ?></title>

	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css" />
	<?php if (isset($addCss)) { echo $addCss; } ?>
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<link rel="stylesheet" type="text/css" href="css/styles.css" />

	<!--[if lt IE 9]>
		<script src="js/html5shiv.min.js"></script>
		<script src="js/respond.min.js"></script>
	<![endif]-->
</head>

<body>
	<div class="container page_block noTopBorder noBotBorder">
		<div class="header-cont">
			<div class="row">
				<div class="col-md-6">
					<div class="contact-text">
						<?php echo $needHelpText; ?> <i class="fa fa-phone"></i> <?php echo $set['contactPhone']; ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="header-social-links">
						<?php
							echo $facebook;
							echo $google;
							echo $linkedin;
							echo $pinterest;
							echo $twitter;
							echo $youtube;
						?>
					</div>
				</div>
			</div>

			<hr class="mt-10 mb-10" />

			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only"><?php echo $toggleNavText; ?></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="index.php" style="height:80px;"><img src="images/newlogo.png" /></a>
					</div>

					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-right">
							<li class="<?php echo $dashNav; ?>"><a href="page.php"><?php echo $dashboardNavLink; ?></a></li>
							<?php if ($rs_leaseId != '0') { ?>
								<li class="<?php echo $propNav; ?>"><a href="page.php?page=myProperty"><?php echo $myPropNavText; ?></a></li>
								<li class="<?php echo $servNav; ?>"><a href="page.php?page=serviceRequests"><?php echo $servReqNavLink; ?></a></li>
							<?php } ?>
							<li class="<?php echo $userNav; ?> dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $myAccNavLink; ?> <i class="fa fa-angle-down"></i></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="page.php?page=myProfile"><?php echo $myProfileNavLink; ?></a></li>
									<?php if ($set['enablePayments'] == '1') { ?>
										<li><a href="page.php?page=paymentHistory"><?php echo $payHistNavLink; ?></a></li>
									<?php } else { ?>
										<li><a href="page.php?page=newPayment"><?php echo $payInfoNavLink; ?></a></li>
									<?php } ?>
									<li><a href="page.php?page=myDocuments"><?php echo $myDocsNavLink; ?></a></li>
								</ul>
							</li>
							<li><a data-toggle="modal" href="#signOut"><?php echo $signOutNavLink; ?></a></li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
	</div>

	<div class="modal fade" id="signOut" tabindex="-1" role="dialog" aria-labelledby="signOutLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<p class="lead"><?php echo $rs_userFull; ?>, <?php echo $signOutConf; ?></p>
				</div>
				<div class="modal-footer">
					<a href="index.php?action=logout" class="btn btn-success btn-icon-alt"><?php echo $signOutNavLink; ?> <i class="fa fa-sign-out"></i></a>
					<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle"></i> <?php echo $cancelBtn; ?></button>
				</div>
			</div>
		</div>
	</div>
