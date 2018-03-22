<?php

if(is_dir('install')) {
	header("Location: install/install.php");
} else {
	if(!isset($_SESSION)) session_start();

	// Access DB Info
	include('config.php');

	// Get Settings Data
	include ('includes/settings.php');
	$set = mysqli_fetch_assoc($setRes);

	// Include Functions
	include('includes/functions.php');

	// Include Sessions & Localizations
	include('includes/sessions.php');

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
	$sign_out = '';
	if ($rs_adminId != '') {
		// Add Recent Activity
		$activityType = '12';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$adminSignout;
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		$sign_out = 'true';
	} else if ($rs_userId != '') {
		// Add Recent Activity
		$activityType = '12';
		$rs_aid = '0';
		$activityTitle = $rs_userFull.' '.$userSignout;
		updateActivity($rs_aid,$rs_userId,$activityType,$activityTitle);
		$sign_out = 'true';
	}
	if ($sign_out == 'true') {
		session_destroy();
		header ('Location: index.php');
	}
}
}
 ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">

		<title>m-reside by Swift Cloud Ace</title>

		<!-- Loading third party fonts -->
		<link href="http://fonts.googleapis.com/css?family=Roboto:300,400,700|" rel="stylesheet" type="text/css">
		<link href="fonts/font-awesome.min.css" rel="stylesheet" type="text/css">

		<!-- Loading main css file -->
		<link rel="stylesheet" href="css/style.css">

		<!--[if lt IE 9]>
		<script src="js/ie-support/html5.js"></script>
		<script src="js/ie-support/respond.js"></script>
		<![endif]-->

	</head>


	<body>

		<div class="site-content">
			<header class="site-header" data-bg-image="images/banner.png">
				<div class="container">
					<a href="#" class="branding">
						<img src="images/newlogo.png" alt="Apartments">
						<!--<h1 class="site-title">Swift Cloudace</h1>-->
						<!--<small class="site-description">Manage better</small>-->
					</a>
				</div>
				<div class="banner" >
					<div class="banner-content">
						<div class="container">
							<div class="cta">
								<a href="#">
									<a href="#" class="arrow-button"><i class="fa fa-angle-right"></i></a>
									<h2>Manage your real estate smoothly</h2>
									<small>Forget the pain of managing your tenants and tracking their payments.</small>
								</a>
							</div>

							<div class="subscribe-form">
							<ul class="arrow-list">
							<li>
								<a href="sign-in.php">Sign In</a>
							</li>
							<li>
								<a href="view-property.php">Available properties</a>
							</li>
							<li>
								<a href="rental-application.php">Rental application</a>
							</li>
							<li>
								<a href="about-us.php">About us</a>
							</li>
							<li>
								<a href="contact-us.php">Contact us</a>
							</li>
							</ul>

							</div>
						</div>
					</div>
				</div>
			</header> <!-- .site-header -->

			<main class="main-content">
				<div class="fullwidth-block">
					<div class="container">
						<h2 class="section-title">What is so great about Swift Cloudace?</h2>
						<div class="row">
							<div class="col-md-5">
								<ul class="arrow-list">
									<li>Manage all your tenants and properties</li>
									<li>Manage tenant rental payments and penalties</li>
									<li>Accept payments via MPESA, Bank or Card</li>
									<li>View reports on payments, re</li>
									<li>Tenants can raise service request with you</li>
									<li>Communicate with your tenants seamlessly</li>
								</ul>
							</div>
							<div class="col-md-7">
								<div class="feature-slider">
									<ul class="slides">
										<li>
											<figure>
												<img src="images/feature-1.png" alt="Feature 1">
												<figcaption>
													<h3 class="feature-title">View instant statistics quickly</h3>
													<small class="feature-desc">Velit esse cillum dolore pariatur</small>
												</figcaption>
											</figure>
										</li>
										<li>
											<figure>
												<img src="images/feature-2.png" alt="Feature 2">
												<figcaption>
													<h3 class="feature-title">View tenants with late payment</h3>
													<small class="feature-desc">Reprehenderit in voluptate velit</small>
												</figcaption>
											</figure>
										</li>
										<li>
											<figure>
												<img src="images/feature-3.png" alt="Feature 3">
												<figcaption>
													<h3 class="feature-title">View payments received</h3>
													<small class="feature-desc">Quia dolor ipsum quia dolor sit</small>
												</figcaption>
											</figure>
										</li>
									</ul>

								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="fullwidth-block" data-bg-color="#f0f0f0">
					<div class="container">
						<div class="row">
							<div class="col-md-3 col-sm-6">
								<div class="feature">
									<div class="feature-icon"><img src="images/icon-money.png" alt=""></div>
									<h3 class="feature-title">Easy Payment Reconciliation</h3>
									<p>See all your due and received payments in one place.</p>
								</div>
							</div>
							<div class="col-md-3 col-sm-6">
								<div class="feature">
									<div class="feature-icon"><img src="images/icon-report.png" alt=""></div>
									<h3 class="feature-title">24/7 access to reports</h3>
									<p>We give you access to realtime summary and detailed reports to support your business.</p>
								</div>
							</div>
							<div class="col-md-3 col-sm-6">
								<div class="feature">
									<div class="feature-icon"><img src="images/icon-comm.png" alt=""></div>
									<h3 class="feature-title">Easy Communication with tenants</h3>
									<p>Your tenants can raise service requests with you thus ensuring quick turnaround time.</p>
								</div>
							</div>
							<div class="col-md-3 col-sm-6">
								<div class="feature">
									<div class="feature-icon"><img src="images/logo1.png" alt=""></div>
									<h3 class="feature-title">Everything in one place</h3>
									<p>Everything you need to manage your real estate business in one place.</p>
								</div>
							</div>
						</div>

						<!--<div class="post-list">
							<article class="post">
								<figure class="feature-image" data-bg-image="images/figure-1.jpg"></figure>
								<div class="post-detail">
									<h2 class="entry-title">Lorem porro quisquam dolorem</h2>
									<p>Omnis iste natus error sit voluptatem doloremque laudantium totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo nemo enim ipsam voluptatem quia.</p>
									<a href="#" class="button">See more</a>
								</div>
							</article>
							<article class="post">
								<figure class="feature-image" data-bg-image="images/figure-1.jpg"></figure>
								<div class="post-detail">
									<h2 class="entry-title">Lorem porro quisquam dolorem</h2>
									<p>Omnis iste natus error sit voluptatem doloremque laudantium totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo nemo enim ipsam voluptatem quia.</p>
									<a href="#" class="button">See more</a>
								</div>
							</article>
							<article class="post">
								<figure class="feature-image">
									<iframe width="854" height="510" src="https://www.youtube.com/embed/B8dmbnTsy3g" frameborder="0" allowfullscreen></iframe>
								</figure>
								<div class="post-detail">
									<h2 class="entry-title">Lorem porro quisquam dolorem</h2>
									<p>Omnis iste natus error sit voluptatem doloremque laudantium totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo nemo enim ipsam voluptatem quia.</p>
									<a href="#" class="button">See more</a>
								</div>
							</article>
						</div>-->


					</div>
				</div>
				<!--<div class="fullwidth-block">
					<div class="container">
						<h2 class="section-title">Meet our partners</h2>
						<div class="partners">
							<a href="#"><img src="images/partner-1.png" alt=""></a>
							<a href="#"><img src="images/partner-2.png" alt=""></a>
							<a href="#"><img src="images/partner-3.png" alt=""></a>
							<a href="#"><img src="images/partner-4.png" alt=""></a>
							<a href="#"><img src="images/partner-5.png" alt=""></a>
						</div>
					</div>
				</div>-->
			</main>

			<footer class="site-footer">
				<div class="container">
					<p>Copyright 2018 Swift Cloudace. Designed by Themezy. All rights reserved</p>
					<div class="social-links">
						<a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
						<a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
						<a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
						<a href="#" class="pinterest"><i class="fa fa-pinterest"></i></a>
					</div>
				</div>
			</footer>
		</div>

		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/plugins.js"></script>
		<script src="js/app.js"></script>

	</body>

</html>
