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
<html lang="zxx">
<head>
<title>M-reside by Swift Cloud Ace</title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Factual Real Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free web designs for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<script src="js/jquery-2.2.3.min.js"></script>
<link href="css/bootstrap-home.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="css/cm-overlay.css">
<link href="css/style-home.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/dataTables.css">
</head>
<body>
<div class="main" id="home">
<!-- header -->
<div class="banner-top">
			<div class="social-bnr-agileits">
				<ul>
					<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
					<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
					<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
					<li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>					
				</ul>
			</div>
			<div class="contact-bnr-w3-agile">
				<ul>
				    <li><i class="fa fa-home" aria-hidden="true"></i> Mreside</li>
					<li><i class="fa fa-envelope" aria-hidden="true"></i><a href="mailto:info@example.com">info@m-reside.com</a></li>
					<li><i class="fa fa-phone" aria-hidden="true"></i>+254712472060/+254720847320</li>	
				</ul>
			</div>
			<div class="clearfix"></div>
		</div>

	<div class="w3_navigation">
		<div class="container">
			<nav class="navbar navbar-default">
				<div class="navbar-header navbar-left">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<h1><a class="navbar-brand" href="index.html"><img src="images/newlogo.PNG" alt="" height=50px;></a></h1>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
					<nav class="menu menu--iris">
						<ul class="nav navbar-nav menu__list">
							<li class="menu__item menu__item--current"><a href="index.html" class="menu__link">Home</a></li>
							<li class="menu__item"><a href="#about" class="menu__link scroll">About</a></li>
							<li class="menu__item"><a href="#gallery" class="menu__link scroll">Available Properties</a></li>
							<li class="menu__item"><a href="#gallery" class="menu__link scroll">Rental Application</a></li>
							<li class="menu__item"><a href="#contact" class="menu__link scroll">Contact Us</a></li>
						</ul>
					</nav>
				</div>
			</nav>
		</div>
	</div>
<!-- //header -->
		<div class="home-banner">
			<img src="images/banner1.jpg" id="home-ban" style="width:100%;height: 60vh;background-size: cover;background-position: center;" >
			<div  id="home_banner">
					<h3>Manage your real estate smoothly</h3>
					<p>Forget the pain of managing your tenants and tracking their payments.</p>
				</div>
		</div>
<!-- banner -->

<!--count-->
			<div class="count-agileits">
					<div class="count-grids">
					<div class="count-bgcolor-w3ls">

							<div class="col-md-2 agileits_w3layouts_about_counter_left c1 count-grid">
							  <i class="fa fa-smile-o" aria-hidden="true"></i>
								<span></span>
									<a href="sign-in.php">Sign In</a>
							</div>
							<div class="col-md-2 agileits_w3layouts_about_counter_left c2 count-grid">
							<i class="fa fa-building-o" aria-hidden="true"></i>
								<span></span>
								<a href="view-property.php">Available Properties</a>
							</div>
							<div class="col-md-2 agileits_w3layouts_about_counter_left c3 count-grid">
							 <i class="fa fa-home" aria-hidden="true"></i>
								<span></span>
									<a href="rental-application.php">Rental Application</a>
							</div>
							<div class="col-md-2 agileits_w3layouts_about_counter_left c4 count-grid">
							 <i class="fa fa-users" aria-hidden="true"></i>
								<span></span>
								<a href="about-us.php">About Us</a>
							</div>
							<div class="col-md-2 agileits_w3layouts_about_counter_left c4 count-grid">
								<i class="fa fa-users" aria-hidden="true"></i>
								<span></span>
								<a href="contact-us.php">Contact Us</a>
							</div>

						<div class="clearfix"></div>
						</div>
					</div>
			</div>
<!-- //propertygirds_agileits -->
	<!--services -->
	<div class="property_girds_agileits" style="margin-top:40px; margin-bottom:40px;">
		<div class="agile_team_grid">	
	
					<div class="col-md-4 w3ls_banner_bottom_grid">
						<img src="images/g1.jpg" alt=" " class="img-responsive" />
						<div class="overlay">
							<h4>Tenants and Properties</h4>
							<h6 class="social_agileinfo" style="margin-top:20px;">
								Manage all your tenants and properties
							</h6>
						</div>
					</div>

					<div class="col-md-4 w3ls_banner_bottom_grid">
						<img src="images/g2.jpg" alt=" " class="img-responsive" />
						<div class="overlay">
							<h4>Payments and Penalties</h4>
							<h6 class="social_agileinfo" style="margin-top:20px;">
							Manage tenant rental payments and penalties
							</h6>
						</div>
					</div>


					<div class="col-md-4 w3ls_banner_bottom_grid hvr-shutter-in-horizontal">
						<img src="images/mpesa.png" alt=" " width=500px height=450px class="img-responsive" />
						<div class="overlay">
							<h4>MPESA, Bank or Card</h4>
							<h6 class="social_agileinfo" style="margin-top:20px;">
								Accept payments via MPESA, Bank or Card
							</h6>
						</div>
					</div>

		</div>
		<div class="clearfix"></div>
	</div>
	<div class="property_girds_agileits" style="margin-top:40px; margin-bottom:40px;">
		<div class="agile_team_grid">	
	
					<div class="col-md-4 w3ls_banner_bottom_grid">
						<img src="images/g1.jpg" alt=" " class="img-responsive" />
						<div class="overlay">
							<h4>Reports on Payments</h4>
							<h6 class="social_agileinfo" style="margin-top:20px;">
								View reports on payments
							</h6>
						</div>
					</div>

					<div class="col-md-4 w3ls_banner_bottom_grid">
						<img src="images/request.png" alt=" " width=500px height=450px  class="img-responsive" />
						<div class="overlay">
							<h4>Service Request</h4>
							<h6 class="social_agileinfo" style="margin-top:20px;">
								Tenants can raise service request with you
							</h6>
						</div>
					</div>


					<div class="col-md-4 w3ls_banner_bottom_grid hvr-shutter-in-horizontal">
						<img src="images/comm.jpg" alt=" " width=500px height=450px  class="img-responsive"  height=100px; />
						<div class="overlay">
							<h4>Seamless Communication</h4>
							<h6 class="social_agileinfo" style="margin-top:20px;">
								Communicate with your tenants seamlessly
							</h6>
						</div>
					</div>

		</div>
		<div class="clearfix"></div>
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
                        </div>
                        </div>

	<div class="footer jarallax" >
		<div class="container">
			<div class="col-md-4 agileinfo_footer_grid">
				<h3>About Us</h3>
				<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				<form action="#" method="post">
					<input type="email" name="Email" placeholder="Email" required="">
					<input type="submit" value="Send">
				</form>
			</div>
			<div class="col-md-4 agileinfo_footer_grid">
				<h3>Twitter Posts</h3>
				<ul class="w3agile_footer_grid_list">
					<li>Ut aut reiciendis voluptatibus maiores <a href="#">http://lkj.ewr.com</a> alias, ut aut reiciendis.
						<span>02 days ago</span></li>
					<li>Itaque earum rerum hic tenetur a sapiente delectus <a href="#">http://uiubajaj.com</a> ut aut
						voluptatibus.<span>03 days ago</span></li>
				</ul>
			</div>
			<div class="col-md-4 agileinfo_footer_grid">
				<h3>Social Media</h3>
				<ul class="agileinfo_social_icons">
					<li><a href="#" class="facebook"><span><i class="fa fa-facebook" aria-hidden="true"></i></span>Facebook</a></li>
					<li><a href="#" class="twitter"><span><i class="fa fa-twitter" aria-hidden="true"></i></span>Twitter</a></li>
					<li><a href="#" class="google"><span><i class="fa fa-google-plus" aria-hidden="true"></i></span>Google+</a></li>
					<li><a href="#" class="instagram"><span><i class="fa fa-linkedin" aria-hidden="true"></i></span>linkedin</a></li>
				</ul>
				
			</div>
		</div>
	</div>
<!-- //footer -->
<!-- copy-right -->
	
<!-- //copy-right -->
<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
 <!-- js -->
<script src="js/jquery-2.2.3.min.js"></script>
<!-- skills -->

<script>
        $(function(){ 

  // parameters
  // image height
  var images_height = '500px';
  // array of images
  var images_url = [
      'images/banner1.jpeg',
      'images/banner2.jpeg',
      'images/banner3.jpeg'
  ];
  var images_count = images_url.length;

  // create nodes
  for(var j=0;j<images_count+1;j++){
      $('.banner ul').append('<li></li>')
  }

  // pagination
  for(var j=0;j<images_count;j++){
      if(j==0){
          $('.banner ol').append('<li class="current"></li>')
      }else{
          $('.banner ol').append('<li></li>')
      }
  }

  // convert images into backgrounds
  $('.banner ul li').css('background-image','url('+images_url[0]+')');
  
  $.each(images_url,function(key,value){
      $('.banner ul li').eq(key).css('background-image','url('+value+')');
  });

  $('.banner').css('height',images_height);

  $('.banner ul').css('width',(images_count+1)*100+'%');

  $('.banner ol').css('width',images_count*20+'px');
  $('.banner ol').css('margin-left',-images_count*20*0.5-10+'px');

  var num = 0;

  var window_width = $(window).width();

  $(window).resize(function(){
      window_width = $(window).width();
      $('.banner ul li').css({width:window_width});
      clearInterval(timer);
      nextPlay();
      timer = setInterval(nextPlay,2000);
  });

  $('.banner ul li').width(window_width);

  // pagination dots
  $('.banner ol li').mouseover(function(){
      $(this).addClass('current').siblings().removeClass('current');
      var i = $(this).index();
      //console.log(i);
      $('.banner ul').stop().animate({left:-i*window_width},500);
      num = i;
  });

  // autoplay
  var timer = null;

  function prevPlay(){
      num--;
      if(num<0){
          $('.banner ul').css({left:-window_width*images_count}).stop().animate({left:-window_width*(images_count-1)},500);
          num=images_count-1;
      }else{
          $('.banner ul').stop().animate({left:-num*window_width},500);
      }
      if(num==images_count-1){
          $('.banner ol li').eq(images_count-1).addClass('current').siblings().removeClass('current');
      }else{
          $('.banner ol li').eq(num).addClass('current').siblings().removeClass('current');

      }
  }

  function nextPlay(){
      num++;
      if(num>images_count){
          $('.banner ul').css({left:0}).stop().animate({left:-window_width},500);
          num=1;
      }else{
          $('.banner ul').stop().animate({left:-num*window_width},500);
      }
      if(num==images_count){
          $('.banner ol li').eq(0).addClass('current').siblings().removeClass('current');
      }else{
          $('.banner ol li').eq(num).addClass('current').siblings().removeClass('current');

      }
  }

  timer = setInterval(nextPlay,2000);

  // auto pause on mouse enter
  $('.banner').mouseenter(function(){
      clearInterval(timer);
      $('.banner i').fadeIn();
  }).mouseleave(function(){
      timer = setInterval(nextPlay,2000);
      $('.banner i').fadeOut();
  });

  // goto next
  $('.banner .right').click(function(){
      nextPlay();
  });

  // back to previous
  $('.banner .left').click(function(){
      prevPlay();
  });

});
    </script>
	<!-- Stats-Number-Scroller-Animation-JavaScript -->
				
		<!-- //Stats-Number-Scroller-Animation-JavaScript -->
	<script src="js/responsiveslides.min.js"></script>

	<script>
								// You can also use "$(window).load(function() {"
								$(function () {
								  // Slideshow 4
								  $("#slider4").responsiveSlides({
									auto: true,
									pager:true,
									nav:false,
									speed: 500,
									namespace: "callbacks",
									before: function () {
									  $('.events').append("<li>before event fired.</li>");
									},
									after: function () {
									  $('.events').append("<li>after event fired.</li>");
									}
								  });
							
								});
							 </script>

	
			<script src="js/jquery.tools.min.js"></script>
			<script src="js/jquery.mobile.custom.min.js"></script>
			<script src="js/jquery.cm-overlay.js"></script>
			<script>
				$(document).ready(function(){
					$('.cm-overlay').cmOverlay();
				});
			</script>



<!-- start-smoth-scrolling -->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script>
<!-- start-smoth-scrolling -->
			<script src="js/jarallax.js"></script>
	
	<script type="text/javascript">
		/* init Jarallax */
		$('.jarallax').jarallax({
			speed: 0.5,
			imgWidth: 1366,
			imgHeight: 768
		})
	</script>
	
		
<script type="text/javascript">
							$(window).load(function() {
								$("#flexiselDemo1").flexisel({
									visibleItems:1,
									animationSpeed: 1000,
									autoPlay: true,
									autoPlaySpeed: 3000,    		
									pauseOnHover: true,
									enableResponsiveBreakpoints: true,
									responsiveBreakpoints: { 
										portrait: { 
											changePoint:480,
											visibleItems: 1
										}, 
										landscape: { 
											changePoint:640,
											visibleItems:1
										},
										tablet: { 
											changePoint:768,
											visibleItems: 1
										}
									}
								});
								
							});
					</script>
					<script type="text/javascript" src="js/jquery.flexisel.js"></script>
<!-- //js -->
 
	<script src="js/bootstrap-home.js"></script>
<!-- //for bootstrap working -->
<!-- here stars scrolling icon -->
	<script type="text/javascript">
		$(document).ready(function() {
			/*
				var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
				};
			*/
								
			$().UItoTop({ easingType: 'easeOutQuart' });
								
			});
	</script>
<!-- //here ends scrolling icon -->
</body>
</html>
