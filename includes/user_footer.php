<?php
	// Get Manager/Admin Data
	$fmgr = "SELECT * FROM admins WHERE isActive = 1";
	$fmgrres = mysqli_query($mysqli, $fmgr) or die('-79' . mysqli_error());
?>
	<div class="container footer_block noBotBorder mt-20">
		<div class="row">
			<div class="col-md-8">
				<h4 class="footer-hLine"><?php echo $getToKnowTitle; ?></h4>
				<div class="row">
					<?php
						while ($fmgrrow = mysqli_fetch_assoc($fmgrres)) {
							$profileurl = preg_replace('/ /', '-', clean($fmgrrow['adminName']));
					?>
							<div class="col-md-6">
								<div class="profile-widget">
									<div class="profile">
										<div class="img"><img alt="<?php echo $admAvatarAlt; ?>" src="<?php echo $avatarDir.$fmgrrow['adminPhoto']; ?>" /></div>
										<div class="info">
											<a href="profile.php?profile=<?php echo $profileurl; ?>"><?php echo clean($fmgrrow['adminName']); ?></a><br />
											<span><?php echo clean($fmgrrow['adminRole']); ?></span>
										</div>
									</div>
								</div>
							</div>
					<?php } ?>
				</div>		
			</div>
			<div class="col-md-4">
				<div class="dateTime">
					<div class="day"><?php echo date('j'); ?></div>
					<div class="monthYear">
						<?php echo $monthName.' '.date('Y'); ?><br />
						<span><?php echo $dayName; ?></span>
					</div>
				</div>
				<hr class="clearfix" />
				<?php if ($rs_userLoc != '') { $widgetLoc = $rs_userLoc; } else { $widgetLoc = $set['weatherLoc']; } ?>
				<input id="weatherLoc" type="hidden" value="<?php echo $widgetLoc; ?>" />
				<div id="weather"></div>
			</div>
		</div>
		
		<div class="copyright clearfix">
			<div class="pull-left">
				<span><i class="fa fa-copyright"></i> <?php echo $copyrightText; ?> <?php echo date("Y"); ?></span> <?php echo $copyrightLink; ?>
			</div>
			<div class="pull-right">
				<ul class="list-inline footer-nav">
					<li><a href="index.php"><?php echo $homeNavLink; ?></a></li>
					<li><a href="available-properties.php"><?php echo $propNavLink; ?></a></li>
					<li><a href="about-us.php"><?php echo $aboutUsNavLink; ?></a></li>
					<li><a href="contact-us.php"><?php echo $contactUsNavLink; ?></a></li>
					<?php if (($rs_adminId != '') || ($rs_userId != '')) { ?>
						<li><a data-toggle="modal" href="#signOut"><?php echo $signOutNavLink; ?></a></li>
					<?php
						} else {
							if ($set['allowRegistrations'] == '1') {
					?>
							<li><a href="sign-in.php"><?php echo $signInUpNavLink; ?></a></li>
					<?php } else { ?>
							<li><a href="sign-in.php"><?php echo $signInNavLink; ?></a></li>
					<?php
							}
						}	
					?>
				</ul>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<?php
		if (isset($chosen)) {
			echo '
					<script type="text/javascript" src="js/chosen.jquery.min.js"></script>
					<script type="text/javascript" src="js/chosen.js"></script>
				';
		}
	?>
	<script type="text/javascript" src="js/simpleWeather.min.js"></script>
	<script type="text/javascript" src="js/simpleWeather.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	<?php if (isset($flixSlider)) { echo '<script type="text/javascript" src="js/jquery.flexslider.js"></script>'; } ?>
	<?php
		if (isset($dataTables)) {
			echo '
				<script src="js/dataTables.js"></script>
				<script src="js/dataTables.tableTools.js"></script>
			';
			include('js/tableTools.php');
		}
	?>
	<?php if (isset($jsFile)) { echo '<script type="text/javascript" src="js/includes/'.$jsFile.'.js"></script>'; } ?>

</body>
</html>